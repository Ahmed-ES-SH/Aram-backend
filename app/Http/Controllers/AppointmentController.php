<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;
use App\Modules\Service\Services\AppointmentResponseService;
use App\Modules\Service\Services\AppointmentService;
use App\Modules\Service\Services\CancelAppointmentService;
use App\Http\Traits\ApiResponse;
use App\Models\Appointment;
use App\Modules\Organization\Models\Organization;
use App\Modules\User\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\OpenApi\Responses\CreatedResponse;
use App\OpenApi\Responses\ErrorResponse;
use App\OpenApi\Responses\NoContentResponse;
use App\OpenApi\Responses\OkResponse;
use App\OpenApi\Responses\PaginatedOkResponse;
use App\OpenApi\Responses\ServerErrorResponse;
use App\OpenApi\Responses\UnprocessableResponse;

class AppointmentController extends Controller
{

    use ApiResponse;




    // available times for users to show the times he can selected
    #[OA\Get(
        path: '/organizations/{organization}/available-times',
        summary: 'Get available appointment time slots for a given date',
        tags: ['Appointments'],
        parameters: [
            new OA\Parameter(name: 'organization', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'date', in: 'query', required: false, schema: new OA\Schema(type: 'string', format: 'date'), description: 'Date to generate slots for (defaults to today)'),
            new OA\Parameter(name: 'interval', in: 'query', required: false, schema: new OA\Schema(type: 'integer', example: 30), description: 'Slot interval in minutes (default 30)'),
        ],
        responses: [
            new OkResponse('Available times'),
            new ErrorResponse(400, 'Working hours are not set for this organization'),
            new ServerErrorResponse(),
        ],
    )]
    public function getAvailableTimes(Request $request, Organization $organization)
    {
        try {
            $date = $request->input('date', now()->toDateString());
            $interval = $request->input('interval', 30); // minutes

            $openAt = $organization->open_at;
            $closeAt = $organization->close_at;

            if (!$openAt || !$closeAt) {
                return $this->errorResponse([
                    'ar' => 'لم يتم تحديد ساعات العمل لهذا المركز.',
                    'en' => 'Working hours are not set for this organization.'
                ], 400);
            }

            $start = Carbon::parse("$date $openAt");
            $end = Carbon::parse("$date $closeAt");

            // Fetch booked times
            $bookedAppointments = Appointment::where('organization_id', $organization->id)
                ->whereDate('start_time', $date)
                ->get(['start_time', 'end_time']);

            $available = [];
            $current = $start->copy();

            while ($current < $end) {
                $slotStart = $current->copy();
                $slotEnd = $current->copy()->addMinutes($interval);

                // check if the slot overlaps with any existing appointment
                $isBooked = $bookedAppointments->contains(function ($appointment) use ($slotStart, $slotEnd) {
                    return !($slotEnd <= $appointment->start_time || $slotStart >= $appointment->end_time);
                });

                if (!$isBooked) {
                    $available[] = $slotStart->format('H:i');
                }

                $current->addMinutes($interval);
            }

            $data = [
                'date' => $date,
                'available_times' => $available
            ];

            return $this->successResponse($data, 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }


    #[OA\Get(
        path: '/organizations/{organization}/all-times',
        summary: 'Get all time slots with availability status',
        tags: ['Appointments'],
        parameters: [
            new OA\Parameter(name: 'organization', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'date', in: 'query', required: false, schema: new OA\Schema(type: 'string', format: 'date'), description: 'Date to generate slots for (defaults to today)'),
            new OA\Parameter(name: 'interval', in: 'query', required: false, schema: new OA\Schema(type: 'integer', example: 30), description: 'Slot interval in minutes (default 30)'),
        ],
        responses: [
            new OkResponse('All times with availability status'),
            new ErrorResponse(400, 'Working hours are not set for this organization'),
            new ServerErrorResponse(),
        ],
    )]
    public function getAllTimes(Request $request, Organization $organization)
    {
        try {
            $date = $request->input('date', now()->toDateString());
            $interval = (int) $request->input('interval', 30);

            $openAt = $organization->open_at;
            $closeAt = $organization->close_at;

            if (!$openAt || !$closeAt) {
                return $this->errorResponse([
                    'ar' => 'لم يتم تحديد ساعات العمل لهذا المركز.',
                    'en' => 'Working hours are not set for this organization.'
                ], 400);
            }

            $start = Carbon::parse("$date $openAt");
            $end   = Carbon::parse("$date $closeAt");

            // جلب المواعيد التي قد تتداخل مع نافذة العمل
            $bookedAppointments = Appointment::where('organization_id', $organization->id)
                ->where('start_time', '<', $end) // يبدأ قبل نهاية العمل
                ->where(function ($q) use ($start) {
                    // وينتهي بعد بداية العمل أو ليس له end_time
                    $q->where('end_time', '>', $start)
                        ->orWhereNull('end_time');
                })
                ->get(['id', 'start_time', 'end_time', 'user_id']);

            // حوّل إلى Carbons واعتبر end_time = start + 1 hour إذا كانت null
            $booked = $bookedAppointments->map(function ($a) use ($end) {
                $s = Carbon::parse($a->start_time);
                // إذا لم يوجد end_time نفترض ساعة واحدة فقط
                $e = $a->end_time
                    ? Carbon::parse($a->end_time)
                    : $s->copy()->addHour();

                // لا نجعل الانتهاء يتجاوز وقت إغلاق المركز (clamp)
                if ($e->greaterThan($end)) {
                    $e = $end->copy();
                }

                return [
                    'id' => $a->id,
                    'start' => $s,
                    'end' => $e,
                ];
            });

            $all = [];
            $current = $start->copy();

            while ($current < $end) {
                $slotStart = $current->copy();
                $slotEnd = $current->copy()->addMinutes($interval);

                if ($slotStart >= $end) break;

                if ($slotEnd > $end) {
                    $slotEnd = $end->copy();
                }

                // التداخل: NOT (slotEnd <= appt.start OR slotStart >= appt.end)
                $isBooked = $booked->first(function ($appt) use ($slotStart, $slotEnd) {
                    return ! ($slotEnd <= $appt['start'] || $slotStart >= $appt['end']);
                }) !== null;

                $all[] = [
                    'time' => $slotStart->format('H:i'),
                    'status' => $isBooked ? 'booked' : 'available',
                ];

                $current->addMinutes($interval);
            }

            return $this->successResponse([
                'date' => $date,
                'all_times' => $all
            ], 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }



    #[OA\Get(
        path: '/all-times/{organization}',
        summary: 'Get all appointments for an organization grouped by day',
        tags: ['Appointments'],
        parameters: [
            new OA\Parameter(name: 'organization', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OkResponse('Appointments grouped by day'),
            new NoContentResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function getAllAppointments(Request $request, Organization $organization)
    {
        try {
            // التحقق من أن المركز (organization) تم تحديده
            $organizationId = $organization->id;

            if (!$organizationId) {
                return $this->errorResponse('organization_id is required', 400);
            }

            // جلب جميع المواعيد الخاصة بالمركز المحدد
            $appointments = Appointment::where('organization_id', $organizationId)
                ->orderBy('start_time', 'asc')
                ->get();

            if ($appointments->isEmpty()) {
                return $this->noContentResponse();
            }

            // تحويل البيانات إلى شكل منسّق (grouped by day)
            $grouped = $appointments->groupBy(function ($appointment) {
                return Carbon::parse($appointment->start_time)->format('Y-m-d');
            })->map(function ($items, $day) {
                return [
                    'book_day' => $day,
                    'times' => $items->map(function ($item) {
                        return [
                            'time' => Carbon::parse($item->start_time)->format('H:i'),
                            'status' => $item->status ?? 'pending',
                        ];
                    })->values(),
                ];
            })->values();

            return $this->successResponse([
                'data' => $grouped,
                'count' => $appointments->count(),
            ], 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }


    #[OA\Get(
        path: '/appointments/{type}/{id}',
        summary: 'List appointments for a user or an organization (paginated, filterable)',
        tags: ['Appointments'],
        parameters: [
            new OA\Parameter(name: 'type', in: 'path', required: true, schema: new OA\Schema(type: 'string'), description: 'Must be user or organization'),
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'), description: 'The user or organization id'),
            new OA\Parameter(name: 'status', in: 'query', required: false, schema: new OA\Schema(type: 'string'), description: 'Filter by appointment status'),
            new OA\Parameter(name: 'date', in: 'query', required: false, schema: new OA\Schema(type: 'string', format: 'date'), description: 'Filter by appointment date'),
        ],
        responses: [
            new PaginatedOkResponse('Appointment'),
            new ErrorResponse(400, 'Invalid type, must be user or organization'),
            new ServerErrorResponse(),
        ],
    )]
    public function index(Request $request, string $type, int $id)
    {
        try {
            // Validate type
            if (!in_array($type, ['user', 'organization'])) {
                return $this->errorResponse([
                    'ar' => 'النوع غير صالح، يجب أن يكون user أو organization.',
                    'en' => 'Invalid type, must be user or organization.'
                ], 400);
            }

            // Base query
            $query = Appointment::query()
                ->with(['user:id,name,image,email', 'organization:id,title,logo,email'])
                ->when($type === 'user', fn($q) => $q->where('user_id', $id))
                ->when($type === 'organization', fn($q) => $q->where('organization_id', $id));

            // Optional filters
            if ($request->has('status')) {
                $query->where('status', $request->get('status'));
            }

            if ($request->has('date')) {
                $query->whereDate('start_time', $request->get('date'));
            }

            // Sorting and pagination
            $appointments = $query
                ->orderByDesc('start_time')
                ->paginate(10);

            // Response
            return $this->paginationResponse($appointments, 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }


    #[OA\Post(
        path: '/organizations/{organization}/appointments',
        summary: 'Create a new appointment booking request',
        tags: ['Appointments'],
        parameters: [
            new OA\Parameter(name: 'organization', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['user_id', 'start_time', 'is_paid'],
                properties: [
                    new OA\Property(property: 'user_id', type: 'integer'),
                    new OA\Property(property: 'start_time', type: 'string', format: 'date-time', example: '2026-01-01 10:00'),
                    new OA\Property(property: 'end_time', type: 'string', format: 'date-time', nullable: true),
                    new OA\Property(property: 'is_paid', type: 'boolean'),
                    new OA\Property(property: 'user_notes', type: 'string'),
                ],
            ),
        ),
        responses: [
            new CreatedResponse('Booking request sent successfully'),
            new ErrorResponse(400, 'Selected time is outside working hours'),
            new UnprocessableResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function store(Request $request, Organization $organization, AppointmentService $appointmentService)
    {
        try {
            $result = $appointmentService->create($request->all(), $organization);

            if (!$result['success']) {
                return $this->errorResponse($result['errors'], $result['code']);
            }

            return $this->successResponse([
                'ar' => 'تم إرسال طلب الحجز بنجاح.',
                'en' => 'Booking request sent successfully.',
                'appointment' => $result['appointment']
            ], 201);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    #[OA\Post(
        path: '/pending-appointments/{organization}',
        summary: 'Bulk insert cancelled appointments owned by the organization',
        tags: ['Appointments'],
        parameters: [
            new OA\Parameter(name: 'organization', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['appointments'],
                properties: [
                    new OA\Property(property: 'appointments', type: 'array', items: new OA\Items(type: 'object'), description: 'List of {organization_id, start_time, end_time}'),
                ],
            ),
        ),
        responses: [
            new OkResponse('Appointments added successfully'),
            new ErrorResponse(400, 'No appointments provided'),
            new ErrorResponse(409, 'No new appointments to insert'),
            new ServerErrorResponse(),
        ],
    )]
    public function cancelAppointmentsByOwner(Request $request, Organization $organization)
    {
        try {
            // التحقق من وجود المواعيد في الطلب
            if (!$request->has('appointments')) {
                return $this->errorResponse('No appointments provided', 400);
            }

            // تحويل JSON إلى مصفوفة PHP
            $appointments = is_array($request->appointments)
                ? $request->appointments
                : json_decode($request->appointments, true);

            if (empty($appointments)) {
                return $this->errorResponse('Appointments list is empty', 400);
            }

            $insertData = [];
            $now = now();

            foreach ($appointments as $appointment) {
                // التحقق من الحقول الأساسية
                if (
                    empty($appointment['organization_id']) ||
                    empty($appointment['start_time']) ||
                    empty($appointment['end_time'])
                ) {
                    continue; // تجاهل أي موعد ناقص البيانات الأساسية
                }

                // التأكد من عدم وجود موعد بنفس start/end لنفس المركز
                $exists = Appointment::where('organization_id', $appointment['organization_id'])
                    ->where('start_time', $appointment['start_time'])
                    ->where('end_time', $appointment['end_time'])
                    ->exists();

                if ($exists) {
                    continue; // تخطي هذا الموعد لأنه مكرر
                }

                $insertData[] = [
                    'user_id' => null,
                    'organization_id' => $appointment['organization_id'],
                    'start_time' => $appointment['start_time'],
                    'end_time' => $appointment['end_time'],
                    'price' => null,
                    'is_paid' => 0,
                    'status' => 'cancelled_by_org',
                    'user_notes' => "تم التعليق من قبل المركز نفسة .",
                    'organization_notes' => "تم التعليق من قبل المركز نفسة .",
                    'confirmed_at' => null,
                    'rejected_at' => null,
                    'cancelled_at' => null,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            // إذا لم يكن هناك مواعيد جديدة، أعد رسالة مناسبة
            if (empty($insertData)) {
                return $this->errorResponse('No new appointments to insert', 409);
            }

            // إدخال جميع المواعيد دفعة واحدة
            Appointment::insert($insertData);

            return $this->successResponse([
                'message' => 'Appointments added successfully',
                'inserted_count' => count($insertData),
            ], 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }



    #[OA\Post(
        path: '/organizations/{organization}/appointments/{appointment}/response',
        summary: 'Respond to an appointment booking request (confirm or reject)',
        tags: ['Appointments'],
        parameters: [
            new OA\Parameter(name: 'organization', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'appointment', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['status'],
                properties: [
                    new OA\Property(property: 'status', type: 'string', enum: ['confirmed', 'rejected']),
                    new OA\Property(property: 'organization_notes', type: 'string', nullable: true),
                ],
            ),
        ),
        responses: [
            new OkResponse('Appointment updated'),
            new ErrorResponse(403, 'Appointment does not belong to this organization'),
            new ErrorResponse(409, 'Appointment already responded to'),
            new UnprocessableResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function respond(Request $request, Organization $organization, Appointment $appointment, AppointmentResponseService $service)
    {
        $result = $service->respondToAppointment($appointment, $request->all(), $organization);

        if (!$result['success']) {
            return $this->errorResponse($result['errors'], $result['code']);
        }

        return $this->successResponse($result['appointment'], 200);
    }

    #[OA\Post(
        path: '/cancel-appointment',
        summary: 'Cancel an appointment',
        tags: ['Appointments'],
requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['appointment_id', 'cancler_id', 'cancler_type'],
                properties: [
                    new OA\Property(property: 'appointment_id', type: 'integer'),
                    new OA\Property(property: 'cancler_id', type: 'integer'),
                    new OA\Property(property: 'cancler_type', type: 'string', enum: ['user', 'organization']),
                ],
            ),
        ),
        responses: [
            new OkResponse('Appointment cancelled'),
            new ErrorResponse(403, 'Cancellation not allowed'),
            new UnprocessableResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function cancel(Request $request, CancelAppointmentService $appointmentService)
    {
        $validated = $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'cancler_id' => 'required|integer',
            'cancler_type' => 'required|in:user,organization',
        ]);

        $result = $appointmentService->cancelAppointment($validated);

        if ($result['success']) {
            return $this->successResponse($result['message'], 200);
        }

        return $this->errorResponse($result['message'], 403);
    }



    #[OA\Delete(
        path: '/delete-appointment',
        summary: 'Delete an appointment (pending/confirmed appointments cannot be deleted)',
        tags: ['Appointments'],
requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['appointment_id', 'deleter_id', 'deleter_type'],
                properties: [
                    new OA\Property(property: 'appointment_id', type: 'integer'),
                    new OA\Property(property: 'deleter_id', type: 'integer'),
                    new OA\Property(property: 'deleter_type', type: 'string', enum: ['user', 'organization']),
                ],
            ),
        ),
        responses: [
            new OkResponse('Appointment deleted'),
            new ErrorResponse(400, 'Cannot delete active appointments'),
            new ErrorResponse(403, 'Not authorized to delete this appointment'),
            new UnprocessableResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function destroy(Request $request)
    {
        try {
            // ✅ Validate incoming data
            $validated = $request->validate([
                'appointment_id' => 'required|exists:appointments,id',
                'deleter_id' => 'required|integer',
                'deleter_type' => 'required|in:user,organization',
            ]);

            $appointment = Appointment::findOrFail($validated['appointment_id']);

            // ✅ Ensure deleter is one of the parties involved in the appointment
            $isAuthorized =
                ($validated['deleter_type'] === 'user' && $validated['deleter_id'] == $appointment->user_id) ||
                ($validated['deleter_type'] === 'organization' && $validated['deleter_id'] == $appointment->organization_id);

            if (! $isAuthorized) {
                return $this->errorResponse([
                    'ar' => 'غير مصرح لك بحذف هذا الموعد.',
                    'en' => 'You are not authorized to delete this appointment.'
                ], 403);
            }

            // ✅ Optional: Prevent deletion of active (pending/confirmed) appointments
            if (in_array($appointment->status, ['pending', 'confirmed'])) {
                return $this->errorResponse([
                    'ar' => 'لا يمكن حذف المواعيد النشطة، قم بإلغائها أولاً.',
                    'en' => 'You cannot delete active appointments. Please cancel them first.'
                ], 400);
            }

            // ✅ Perform deletion
            $appointment->delete();

            return $this->successResponse([
                'ar' => 'تم حذف الموعد بنجاح.',
                'en' => 'The appointment was deleted successfully.',
                'appointment_id' => $appointment->id
            ], 200);
        } catch (Exception $e) {

            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
