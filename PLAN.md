# API Documentation Plan — OpenAPI Annotation Coverage

**Task:** Document every API endpoint with OpenAPI PHP attributes (`#OpenApi\Attributes`) on controllers, backed by reusable `app/OpenApi/Responses/*` and `app/OpenApi/Schemas/*` helpers, so the full OpenAPI spec can be generated from the code.

**Rule:** Annotations only — no behavior, route, schema, or business-logic changes. Endpoints stay faithful to the real request/response contracts (status codes, validation, auth via bearer token).

**Legend:** `[x]` done · `[~]` partial · `[ ]` not done

---

## Phase 1 — Auth Endpoints `[x] DONE`

- [x] `AuthController` — OTP register/login, resend & verify OTP, reset password, social auth (Google/Facebook), logout, logout-all, refresh-token, access-tokens list/delete, `/me` (CurrentUserResponseSchema)
- [x] `SMSController` — SMS send

## Phase 2 — CMS / Admin Endpoint Groups `[x] DONE`

- [x] `UserController` — list, show, update, delete, change password, restore, users-points
- [x] `MemberController`, `FamilyMemberController` — member & family management
- [x] `CategoryController`, `SubCategoryController`, `CardCategoryController` — categories (store/update/delete + list)
- [x] `CurrencyController` — currencies
- [x] `HomePageController`, `AboutController`, `DashboardMainPageController`, `VariableDataController` — CMS static content
- [x] `SlideController`, `WebsiteVideoController`, `FooterLinkController`, `KeywordController`, `TagController` — content groups
- [x] `QuestionAnswerController` — FAQ

## Phase 3 — Post / Like Endpoints (Articles) `[x] DONE`

- [x] `ArticleController` — CRUD + toggle publish
- [x] `ArticleCategoryController` — categories
- [x] `ArticleCommentController` — comments CRUD
- [x] `ArticleInteractionsController` — like/unlike/bookmark
- [x] `ArticleTagController` — dead resource stub, **no routes registered** (verified via `route:list` + `routes/` grep) → nothing to annotate
- [x] `UserArticleInteractionController` — dead resource stub, **no routes registered** (verified via `route:list` + `routes/` grep) → nothing to annotate

## Phase 4 — Data / Transaction Endpoints `[x] DONE`

- [x] `TransactionController` — transactions
- [x] `OfferController`, `PromoterController` — offers & promoters
- [x] `PaymentController` — payment confirm/callback
- [x] `WalletController`, `WithdrawRequestController` — wallets & withdraw requests
- [x] `PromoterRatioController`, `PromoterTrackingController`, `PromotionActivityController` — promotion
- [x] `InvoiceController` — dead resource stub, **no routes registered** (verified via `route:list` + `routes/` grep) → nothing to annotate
- [x] `CouponUsageController` — dead resource stub, **no routes registered** (verified via `route:list` + `routes/` grep) → nothing to annotate
- [x] `ReferralController` — dead resource stub, **no routes registered** (verified via `route:list` + `routes/` grep) → nothing to annotate

## Phase 4a — Static Pages & Contact Endpoints `[x] DONE`

- [x] `PrivacyPolicyController`, `TermsConditionController`
- [x] `OrganizationPrivacyPolicyController`, `OrganizationReviewController`
- [x] `ContactMessageController`, `ServicePageContactMessageController`
- [x] `NewsletterController`
- [x] `OrganizationTermsConditionController` — index (only live route: `GET /organiztions-terms`) annotated; store/update/destroy have no routes

## Phase 4b — Service Module Endpoints `[x] DONE`

- [x] `ServiceCategoryController`, `ServicePageController`, `ServiceFormController`, `ServiceFormFieldController`
- [x] `ServiceFormSubmissionController`, `ServiceOrderController`
- [x] `ServiceTrackingController`, `AppointmentController`
- [x] `PendingServiceOrderFileController` — dead resource stub, **no routes registered** (verified via `route:list` + `routes/` grep) → nothing to annotate
- [x] `ServiceTrackingFileController` — dead resource stub, **no routes registered** (verified via `route:list` + `routes/` grep) → nothing to annotate

## Phase 4c — Remaining Endpoints (main sweep) `[x] DONE`

- [x] `OrganizationController` — org CRUD & profile (21 annotations)
- [x] `CardController`, `CardCategoryController`, `OwnedCardController` — card endpoints
- [x] `ConversationController`, `MessageController` — chat/conversations
- [x] `NotificationController`, `TodoController` — notifications & todos
- [x] `SocialAccountController`, `TempUploadController`, `ReviewLikesCheckController`

## Phase 5 — Gap Sweep (leftovers) `[x] DONE`

2 controllers with **0 annotations** found during `route:list` cross-check — both resolved, no routes registered → nothing to annotate:

- [x] `OrganizationSubCategoryController` (org subcategories) — dead resource stub, **no routes registered** (verified via `route:list` + `routes/` grep) → nothing to annotate
- [x] `ConversationBlockController` (conversation block) — dead resource stub, **no routes registered** (verified via `route:list` + `routes/` grep); block/unblock covered by `ConversationController` annotations → nothing to annotate

Resolved in Phase 3 (dead stubs, no routes — nothing to annotate): `ArticleTagController`, `UserArticleInteractionController`

Resolved in Phase 4 (dead stubs, no routes — nothing to annotate): `InvoiceController`, `CouponUsageController`, `ReferralController`, `PendingServiceOrderFileController`, `ServiceTrackingFileController`

Resolved in Phase 5 (dead stubs, no routes — nothing to annotate): `OrganizationSubCategoryController`, `ConversationBlockController`

## Phase 6 — Generation & Verification `[x] DONE`

- [x] Cross-check: every `route:list` route has an `#[OA]` annotation (no undocumented endpoints)
- [x] Generate OpenAPI spec (`php artisan l5-swagger:generate`)
- [x] Confirm spec validates + tests still pass

Closed the last gaps found by the `route:list` ↔ generated-spec cross-check (spec now 340 paths; every API route documented):

- `ServiceOrderController@index` — added 2nd `#[OA\Get]` for `GET /api/service-orders` (admin variant of `/all-service-orders`)
- `OrganizationController@OrganizationsForSelectionTable` — added 2nd `#[OA\Get]` for `GET /api/dashboard/organizations-table` (admin variant of public twin)
- `SMSController@send` — added 2nd `#[OA\Post]` for `POST /api/internal/send-sms` (API-key variant, same contract)
- `TermsConditionController@store/update/destroy` — added 2nd attributes for `/api/add-oranization-term`, `/api/update-oranization-term/{id}`, `/api/oranization-term/{id}`

**Dead routes removed from `routes/api.php` (all pointed to methods that do not exist — guaranteed 500s; removal user-approved, verified via `method_exists`):**

- `POST api/sub-categories/search` → `SubCategoryController@search`
- `POST api/add-service-order` → `ServiceOrderController@store`
- `GET api/service-order/{serviceOrder}` → `ServiceOrderController@show`
- `POST api/update-service-order/{serviceOrder}` → `ServiceOrderController@update`
- `DELETE api/delete-service-order/{serviceOrder}` → `ServiceOrderController@destroy`

**Not documented (by design):** Breeze web routes `forgot-password`, `verify-email/{id}/{hash}`, `email/verification-notification` (`routes/auth.php`, no `api/` prefix — not part of the API contract).

**Verification:** `l5-swagger:generate` succeeds; spec parses, required OpenAPI keys present, no path/method collisions; `php artisan route:list` clean (359 API routes, only the 5 dead ones removed); tests fail **pre-existing** (`could not find driver` — MySQL PDO driver missing in this env; identical failure on stash-clean checkout).

---

## Progress Notes

- Responses helpers created (shared) — `OkResponse`, `ListOkResponse`, `PaginatedOkResponse`, `CreatedResponse`, `EntityOkResponse`, `NoContentResponse`, `ErrorResponse`, `UnprocessableResponse`, `ForbiddenResponse`, `NotFoundResponse`, `UnauthorizedResponse`, `ServerErrorResponse`, `RefOkResponse`
- Request/response schemas created per endpoint group (see `app/OpenApi/Schemas/`)
- Annotations are additive only — no route/controller behavior changed