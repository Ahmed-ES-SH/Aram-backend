# Plan — User Module Refactor

**Status:** PLANNED — awaiting execution.
**Scope:** Structural refactor of the "users" domain into `app/Modules/User/` per AGENTS.md rules (move code, don't rewrite it; behavior must remain identical).

---

## Phase 1 — Inspection (DONE)

- [x] Identified all user-domain files in the actual tree (not the AGENTS.md example list)
- [x] `app/Http/Controllers/UserController.php` — user CRUD, search, ids/count, password check, email verification, register-with-referral (692 lines, 13 endpoints)
- [x] `app/Models/User.php` — auth subject model (Sanctum), scopes `searchNormalized`, `FilterNonPromoters`
- [x] `app/Http/Requests/StoreUserRequest.php`, `UpdateUserRequest.php` — only two user FormRequests, both extend global `BaseFormRequest`
- [x] No user DTOs, events, listeners, jobs, policies, resources exist
- [x] No user-specific factory (global `database/factories/UserFactory.php` only), migrations untouched
- [x] Verified factory resolution in vendor (`Factory.php:1053-1063`): namespace-based; model outside `App\Models\` would resolve to a non-existent factory class

## Phase 2 — Domain Mapping (DONE)

**Moves into `App\Modules\User`:** `UserController`, `User` model, `StoreUserRequest`, `UpdateUserRequest`.

**Stays global (must NOT move):**
- `app/Http/Controllers/Controller.php`, `app/Http/Traits/ApiResponse.php`, `app/Http/Requests/BaseFormRequest.php`, `app/Http/Services/ImageService.php` — shared across domains
- `app/Mail/VerifyEmail.php` — **shared**: also used by `OrganizationServices/CreateOrganizationService.php:187`
- `app/OpenApi/**` — includes `UserSchema`, `RegisterUserRequestSchema`, `UpdateUserRequestSchema`, `CurrentUserResponseSchema`; controllers reference them only as string refs (`#/components/schemas/User`), so keeping them global breaks nothing
- `database/factories/UserFactory.php`, all migrations/seeders (import updates only)
- `app/Modules/Auth/**` — existing module; import updates only
- Other-domain features not in scope: `FamilyMember`, `Member`, `Todo`, `Dashboard`, `Notification`, `SocialAccount`

## Phase 3 — Target Structure

```
app/Modules/User/
├── Controllers/
│   └── UserController.php
├── Models/
│   └── User.php
└── Requests/
    ├── StoreUserRequest.php
    └── UpdateUserRequest.php
```

## Phase 4 — Move Table (validation complete)

| # | Old path | New path | New namespace | References to update |
|---|---|---|---|---|
| 1 | `app/Http/Controllers/UserController.php` | `app/Modules/User/Controllers/UserController.php` | `App\Modules\User\Controllers` | `routes/api.php:36` (import; usages 169–170, 370, 563, 847 unchanged); add `use App\Http\Controllers\Controller;` (was same-namespace); re-point request + model imports |
| 2 | `app/Models/User.php` | `app/Modules/User/Models/User.php` | `App\Modules\User\Models` | **+ `#[UseFactory(\Database\Factories\UserFactory::class)]` attribute** (see decision below); add imports for same-namespace relations `Promoter`, `Message`, `Conversation`, `Notification`, `Coupon`, `Appointment`, `Wallet` + `App\Helpers\TextNormalizer`; ~60 downstream files (Phase 4b) |
| 3 | `app/Http/Requests/StoreUserRequest.php` | `app/Modules/User/Requests/StoreUserRequest.php` | `App\Modules\User\Requests` | only `UserController:6` |
| 4 | `app/Http/Requests/UpdateUserRequest.php` | `app/Modules/User/Requests/UpdateUserRequest.php` | `App\Modules\User\Requests` | only `UserController:7` |

**Decision (user-approved):** move the `User` model into the module and add `#[UseFactory(\Database\Factories\UserFactory::class)]` (`use Illuminate\Database\Eloquent\Attributes\UseFactory;`). Laravel's `resolveFactoryName` derives the factory from the model namespace — after the move it would look for `Database\Factories\Modules\User\Models\UserFactory` and `User::factory()` (used by `TodoSeeder:21` + 7 calls in 3 test files) would crash. The attribute is the sanctioned Laravel 12 fix; behavior-neutral.

### Phase 4b — Update-only files (no moves; import/reference changes)

**Explicit `use App\Models\User` (40 files):**
- Controllers (15): `ServiceOrderController`, `ServicePageContactMessageController`, `ServiceTrackingController`, `UserArticleInteractionController`, `WalletController`, `WithdrawRequestController`, `AppointmentController`, `ArticleInteractionsController`, `DashboardMainPageController`, `FamilyMemberController`, `NotificationController`, `OwnedCardController`, `PromoterController`, `PromotionActivityController`, (+ moved `UserController`)
- Services (10): `AppointmentResponseService`, `AppointmentService`, `CancelAppointmentService`, `ConversationService`, `CouponAuthorizationService`, `CouponUsageService`, `ProcessBookPaymentService`, `ProcessServiceDealPayment`, `ProcessServicePayment`, `StoreServiceOrderService`
- `app/Listeners/SendSubscriptionExpiredNotification.php`, `app/Modules/Auth/Controllers/{AuthController,RegisteredUserController}.php`
- `config/auth.php:70` (guard model — keep env override, change default class string)
- `app/Providers/AppServiceProvider.php:44` (morphMap — **keep morph key `'user'`**, change class)
- Seeders (12): `ServicePageSeeder_1..8`, `TodoSeeder`, `FamilyMemberSeeder`, `OrganizationReviewSeeder`, `PromoterSeeder`
- Tests (3): `tests/Feature/Auth/{AuthenticationTest,EmailVerificationTest,PasswordResetTest}.php`

**Same-namespace `User::class` refs (21 models — each gets a new `use`):** `Appointment`, `Article`, `ArticleComment`, `ConversationBlock`, `Coupon`, `CouponUsage`, `FamilyMember`, `OfferUsage`, `OrganizationReview`, `Promoter`, `PromotionActivity`, `Referral`, `ReviewLikesCheck`, `ServiceFormSubmission`, `ServiceOrder`, `ServiceTracking`, `Todo`, `Transaction`, `UserArticleInteraction`, `Wallet`, `WithdrawRequest`.

**Config check (no change needed):** `config/l5-swagger.php` already scans `app_path('Modules')` (added during the Auth refactor) — moved controllers/attributes remain in the OpenAPI document. Composer PSR-4 already covers `app/Modules/`.

## Phase 5 — Execution (PENDING — run with build agent)

- [ ] Move 4 files (Phase 4 table)
- [ ] Update namespaces + imports in moved files (incl. new `use App\Http\Controllers\Controller;` in `UserController`, `UseFactory` attribute + relation imports in `User`, keep `use App\Http\Requests\BaseFormRequest;` in requests)
- [ ] Update `routes/api.php` import (line 36) — URLs/methods/names/middleware untouched
- [ ] Update the 40 explicit `use` files + 21 same-namespace models (Phase 4b)
- [ ] Update `config/auth.php` + `AppServiceProvider` morphMap
- [ ] Update 12 seeders + 3 test files
- [ ] `grep` for remaining `App\Models\User` / old request-namespace references — zero matches expected
- [ ] `composer dump-autoload`
- [ ] `php artisan optimize:clear`
- [ ] `php artisan route:list` — confirm all `/users*`, `/register`, `/send-verify-email`, `/verify-email/{id}` routes intact
- [ ] `php artisan test`
- [ ] `git diff` / `git status` — moves + namespace/import changes only

## Phase 6 — Flagged / Uncertain

- `app/Mail/VerifyEmail.php` — shared with Organization (`CreateOrganizationService`); stays global despite only being *called* from `UserController` in this domain
- OpenApi user schemas (`UserSchema`, `RegisterUserRequestSchema`, `UpdateUserRequestSchema`, `CurrentUserResponseSchema`) — kept global per AGENTS.md §48 (OpenApi = global infra); string refs keep working from any location under `app/`
- `CouponUser` model contains the string "User" but no `User::` class reference was found — verify during execution
- `FamilyMember`, `Member`, `Todo`, `Notification`, `Dashboard` — user-related but separate features; NOT in this module
- Email verification endpoints (`/send-verify-email`, `/verify-email/{id}`) stay in `UserController` (moving them to Auth would be a rewrite — forbidden)

## Phase 7 — Pre-existing Issues (report only, NOT fixed)

- [x] `UserController::destroy()` (`:351`) returns `['name', $user->name]` — literal first element, almost certainly intended as `['name' => $user->name]`
- [x] `User::scopeSearchNormalized` duplicates the same hand-written SQL REPLACE block 4× (name/email/phone/country)
- [x] `StoreUserRequest` / `UpdateUserRequest` import `Illuminate\Foundation\Http\FormRequest` which is never used (they extend `BaseFormRequest`)
- [x] `UserController::update()` decodes JSON `location` on `$user` but returns `$user->fresh()`; `location` is cast to `array` anyway, making the manual `isJson` handling redundant
- [ ] Pre-existing test-DB failure noted during Auth refactor (FK `service_pages.category_id` missing table) may still fail `php artisan test` — unrelated to this refactor

---

**Plan only — no files were changed. If this looks correct, run `/laravel-refactor-apply users` to execute it with the build agent.**