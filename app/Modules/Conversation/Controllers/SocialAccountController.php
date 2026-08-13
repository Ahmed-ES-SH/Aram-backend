<?php

namespace App\Modules\Conversation\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Conversation\Requests\UpdateSocialAccountsRequest;
use App\Http\Traits\ApiResponse;
use App\Modules\Conversation\Models\SocialAccount;
use Illuminate\Http\Request;

use App\OpenApi\Responses\OkResponse;
use App\OpenApi\Responses\UnauthorizedResponse;
use App\OpenApi\Responses\ForbiddenResponse;
use App\OpenApi\Responses\UnprocessableResponse;
use App\OpenApi\Responses\ServerErrorResponse;

use OpenApi\Attributes as OA;

class SocialAccountController extends Controller
{
    use ApiResponse;


    #[OA\Get(
        path: '/social-contact-info',
        summary: 'Get the social media accounts and contact info',
        tags: ['Settings'],
        responses: [
            new OkResponse('Social accounts'),
            new ServerErrorResponse(),
        ],
    )]
    public function getAccounts()
    {
        try {
            $accounts = SocialAccount::findOrFail(1);
            return $this->successResponse($accounts, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }


    #[OA\Get(
        path: '/get-whatsapp-number',
        summary: 'Get the WhatsApp number',
        tags: ['Settings'],
        responses: [
            new OkResponse('WhatsApp number'),
            new ServerErrorResponse(),
        ],
    )]
    public function getWhatsappNumber()
    {
        return $this->successResponse(SocialAccount::select('whatsapp_number')->findOrFail(1));
    }


    #[OA\Post(
        path: '/update-social-contact-info',
        summary: 'Update the social media accounts and contact info (admin)',
        security: [['sanctum' => []]],
        tags: ['Settings'],
        responses: [
            new OkResponse('Social accounts updated'),
            new UnprocessableResponse(),
            new UnauthorizedResponse(),
            new ForbiddenResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function update(UpdateSocialAccountsRequest $request)
    {
        try {
            $data = $request->validated();
            $accounts = SocialAccount::findOrFail(1);
            $accounts->update($data);
            return $this->successResponse($accounts, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
