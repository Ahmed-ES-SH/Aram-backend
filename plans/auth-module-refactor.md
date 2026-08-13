# Plan — Auth Module Refactor

**Status:** EXECUTED — Phase 5 (execution) complete, all 9 files moved to `app/Modules/Auth/`, routes + swagger config updated, changes left uncommitted for review.
**Scope:** Structural refactor of "auth logic" into `app/Modules/Auth/` per AGENTS.md rules (move code, don't rewrite it; behavior must remain identical).

---

## Phase 1 — Inspection (DONE)

- [x] Identified the two parallel auth implementations in the codebase
- [x] Verified API auth (Sanctum): `app/Http/Controllers/AuthController.php`
- [x] Verified web session auth: `app/Http/Controllers/Auth/*` (6 controllers) + `app/Http/Requests/Auth/LoginRequest.php`
- [x] Verified mail: `app/Mail/SendOTPCode.php` (auth-owned), `app/Mail/VerifyEmail.php` (shared — stays)
- [x] Verified no auth DTOs, events, listeners, jobs, policies, factories, or resources exist
- [x] Verified no class references to auth classes in tests/factories/seeders/providers

## Phase 2 — Domain Mapping (DONE)

- [x] Auth module boundary defined
- [x] Shared/global infrastructure identified (must NOT move)

**Stays global:**
- `app/OpenApi/**` (schemas + responses + document) — shared infrastructure
- `app/Mail/VerifyEmail.php` — used by `UserController` and `CreateOrganizationService`
- `app/Http/Traits/ApiResponse.php` — used by 56 controllers
- `app/Http/Controllers/Controller.php`, `app/Http/Middleware/EnsureEmailIsVerified.php`
- Models `User`, `Organization`, `Notification`, `PromotionActivity`
- `SMSController`, `SocialAccountController`

## Phase 3 — Target Structure

```
app/Modules/Auth/
├── Controllers/
│   ├── AuthController.php
│   ├── AuthenticatedSessionController.php
│   ├── EmailVerificationNotificationController.php
│   ├── NewPasswordController.php
│   ├── PasswordResetLinkController.php
│   ├── RegisteredUserController.php
│   └── VerifyEmailController.php
├── Requests/
│   └── LoginRequest.php
└── Mail/
    └── SendOTPCode.php
```

## Phase 4 — Move Table (validation complete)

| # | Old path | New path | New namespace | References to update |
|---|---|---|---|---|
| 1 | `app/Http/Controllers/AuthController.php` | `app/Modules/Auth/Controllers/AuthController.php` | `App\Modules\Auth\Controllers` | `routes/api.php:10` (import), `use App\Mail\SendOTPCode` (line 6) |
| 2 | `app/Http/Controllers/Auth/AuthenticatedSessionController.php` | `app/Modules/Auth/Controllers/AuthenticatedSessionController.php` | `App\Modules\Auth\Controllers` | `routes/auth.php:3`, `use App\Http\Requests\Auth\LoginRequest` (line 5) |
| 3 | `app/Http/Controllers/Auth/EmailVerificationNotificationController.php` | `app/Modules/Auth/Controllers/EmailVerificationNotificationController.php` | `App\Modules\Auth\Controllers` | `routes/auth.php:4` |
| 4 | `app/Http/Controllers/Auth/NewPasswordController.php` | `app/Modules/Auth/Controllers/NewPasswordController.php` | `App\Modules\Auth\Controllers` | `routes/auth.php:5` |
| 5 | `app/Http/Controllers/Auth/PasswordResetLinkController.php` | `app/Modules/Auth/Controllers/PasswordResetLinkController.php` | `App\Modules\Auth\Controllers` | `routes/auth.php:6` |
| 6 | `app/Http/Controllers/Auth/RegisteredUserController.php` | `app/Modules/Auth/Controllers/RegisteredUserController.php` | `App\Modules\Auth\Controllers` | `routes/auth.php:7` |
| 7 | `app/Http/Controllers/Auth/VerifyEmailController.php` | `app/Modules/Auth/Controllers/VerifyEmailController.php` | `App\Modules\Auth\Controllers` | `routes/auth.php:8` |
| 8 | `app/Http/Requests/Auth/LoginRequest.php` | `app/Modules/Auth/Requests/LoginRequest.php` | `App\Modules\Auth\Requests` | only `AuthenticatedSessionController` |
| 9 | `app/Mail/SendOTPCode.php` | `app/Modules/Auth/Mail/SendOTPCode.php` | `App\Modules\Auth\Mail` | only `AuthController` (`:6`, `:277`) |

**Required config change (preserve behavior):** add `app_path('Modules')` to `config/l5-swagger.php` → `paths.annotations` (currently only `app_path('Http/Controllers')` + `app_path('OpenApi')`), otherwise the OpenAPI document silently loses every Auth endpoint.

**Composer:** no change needed (existing `App\` → `app/` PSR-4 covers `app/Modules/`). Run `composer dump-autoload` after moving.

## Phase 5 — Execution (DONE)

- [x] Move 9 files (Phase 4 table)
- [x] Update namespaces + imports in moved files
- [x] Update `routes/api.php` import (line 10)
- [x] Update `routes/auth.php` imports (lines 3–8)
- [x] Update `config/l5-swagger.php` annotations scan paths
- [x] Verify no remaining references to old namespaces (`grep` for `App\Http\Controllers\AuthController`, `App\Http\Controllers\Auth\`, `App\Http\Requests\Auth\`, `App\Mail\SendOTPCode`) — zero matches remain
- [x] `composer dump-autoload`
- [x] `php artisan optimize:clear`
- [x] `php artisan route:list` — confirm all auth URLs intact (URLs, names, methods, middleware unchanged)
- [ ] `php artisan test` — **skipped per user instruction**; one attempted run showed 9 failures, all pre-existing `QueryException 1824` (FK `service_pages.category_id` → missing `service_categories` table) in the test DB — unrelated to this refactor, no `database/` files touched
- [x] `git diff` / `git status` — diff shows moves + namespace/import changes only

**Extra change required by the move (not in table):** added `use App\Http\Controllers\Controller;` to `AuthController` — previously resolved via its own namespace; without it the class would fatal-error after the move.

## Phase 6 — Flagged / Uncertain (confirmed no action during execution)

- [x] `POST /register` (`routes/api.php:371`) → `UserController::store` — stays in User domain (extracting = rewrite, forbidden)
- [x] `UserController::sendVerifyEmail` (`/send-verify-email`) — stays in User domain
- [x] `RegisterUserRequestSchema` — used by `UserController::store`; schemas stay global in `app/OpenApi`, no action
- [x] Web-session auth and API auth are duplicate implementations — both moved as-is, NO merging

## Phase 7 — Pre-existing Issues (report only, NOT fixed)

- [x] OTP expiry not enforced on reset: `verifyOTP()` checks 5-min window (`AuthController.php:323`), `resetPassword()` (`:354–397`) does not — expired OTP can still reset password
- [x] `verifyOTP()` does not consume/delete the OTP record; reusable until `resetPassword` deletes it
- [x] `AuthController::getCurrentUser()` catch block (`:519–523`) returns 401 for any exception, masking server errors
- [x] Duplicate route paths across `routes/api.php` and `routes/auth.php` (`/login`, `/reset-password`) — same URLs, different semantics (API vs web session)

---

**Execution complete — changes are staged/unstaged in git, NOT committed, awaiting review.**