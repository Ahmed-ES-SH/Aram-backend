# Plan — Coupon & Promotion Module Refactor

**Status:** PROPOSED — not yet applied
**Generated:** 2026-08-13
**Scope:** Structural refactor of the Coupon domain into `app/Modules/Coupon/` and the Offer/Promotion domain into `app/Modules/Promotion/` per AGENTS.md rules (move code, don't rewrite it; behavior must remain identical).

---

## Phase 1 — Inspection (DONE)

### Coupon domain

- [x] `app/Http/Controllers/CouponController.php` (311 lines) — 9 endpoints (public: account-coupons, check-coupon, distribute-coupon, get-coupon; admin: dashboard/coupons, active-coupons, add-coupon, send-coupon, update-coupon, delete-coupon), injects 5 services already living in `App\Modules\Coupon\Services` (`CouponFetchService`, `CouponService`, `CouponValidationService`, `CouponAuthorizationService`, `CouponUsageService`), `ApiResponse` trait, imports models `Coupon`, `CouponOrganization`, `CouponUsage`, `CouponUser`, requests `StoreCouponRequest`/`UpdateCouponRequest`
- [x] `app/Http/Controllers/CouponUsageController.php` (65 lines) — fully empty stub (all 10 resource methods blank), **NOT registered in any route**; imports `App\Models\CouponUsage`
- [x] Models: `Coupon` (imports `Organization`, `User` module models), `CouponCategory` (standalone), `CouponOrganization` (pivot), `CouponUsage` (imports `Organization`, `User`), `CouponUser` (pivot) — all in `App\Models`
- [x] Requests: `StoreCouponRequest` / `UpdateCouponRequest` extend `FormRequest`, in `App\Http\Requests`
- [x] Services already migrated: `CouponAuthorizationService`, `CouponFetchService`, `CouponService`, `CouponUsageService`, `CouponValidationService` in `App\Modules\Coupon\Services` — all still import `App\Models\Coupon*`

### Offer / Promotion domain

- [x] `app/Http/Controllers/OfferController.php` (527 lines) — 7 endpoints (public: active-offers, active-offers/{orgId}, account-offers, add-offer, get-offer; admin: dashboard/offers, update-offer, update-status-offer, delete-offer), injects `App\Http\Services\ImageService`, `ApiResponse` trait, imports `App\Models\Offer`, requests `StoreOfferRequest`/`UpdateOfferRequest`
- [x] `app/Http/Controllers/PromoterController.php` (361 lines) — 5 endpoints (admin: promoters, search-for-promoter, add-promoter, update-promoter, delete-promoter; public: get-promoter, check-promoter-code), imports `App\Models\Promoter`, module models `Organization`/`User`, request `StorePromoterRequest`
- [x] `app/Http/Controllers/PromoterRatioController.php` (87 lines) — 2 admin endpoints (get-ratios, update-ratios), imports `App\Models\PromoterRatio`
- [x] `app/Http/Controllers/PromoterTrackingController.php` (95 lines) — 1 endpoint (POST promoter/track-visit), imports `App\Models\Promoter`, `App\Models\PromotionActivity`
- [x] `app/Http/Controllers/PromotionActivityController.php` (419 lines) — 7 endpoints (promotion-visit, promoter-activities, promoter-data, top-promoters-data, promoter-activities-by-type, top-referred-buyers), imports `App\Models\PromotionActivity`, `App\Models\Promoter`, `App\Models\PromoterRatio`, module models `User`/`Organization`, request `StorePromoterActivity`
- [x] Models: `Offer` (imports `Organization`), `OfferUsage` (**unreferenced dead model**), `Promoter` (imports `TextNormalizer`, `User`), `PromoterRatio` (standalone), `PromotionActivity` (imports `Organization`, `User`) — all in `App\Models`
- [x] Requests: `StoreOfferRequest`, `UpdateOfferRequest`, `StorePromoterRequest`, `StorePromoterActivity` extend `FormRequest`, in `App\Http\Requests`
- [x] Service already migrated: `App\Modules\Promotion\Services\PromotionService` — imports `App\Models\Promoter`, `App\Models\PromotionActivity`, `App\Models\ProvisionalData`

### Cross-cutting

- [x] Routes: `routes/api.php` — imports for `CouponController` (L16), `OfferController` (L25), `PromoterController` (L34), `PromoterRatioController` (L48), `PromoterTrackingController` (L49), `PromotionActivityController` (L50); route definitions: L177 (promotion-visit), L428-429, L491-493, L501, L621-624, L632-634, L804-805, L820-823, L862-868, L926-933, L942-947. **No per-module route files exist in this project** — precedent (Payment/Card/Service/Article/Organization) keeps all routes in root `routes/api.php`, updating only controller imports
- [x] Tests: zero references to Coupon/Offer/Promoter/PromotionActivity anywhere in `tests/`
- [x] Policies: none exist in the project
- [x] Factories: only `UserFactory` exists — no references
- [x] Events/Listeners/Jobs/Mail: zero references to these domains
- [x] OpenApi schemas (`CouponStoreRequestSchema`, `OfferSchema`, `OfferStoreRequestSchema`, `PromotionActivitySchema`, etc.): standalone OA attribute classes, zero model imports, string-only schema refs — stay global (AGENTS.md §21), no changes
- [x] Migrations: table-based, no model namespaces — untouched (AGENTS.md §42)
- [x] Composer: `"App\\": "app/"` PSR-4 already covers `app/Modules` — no composer.json change needed
- [x] No string-literal class references (`'App\Models\...'`) anywhere in app/, routes/, database/, tests/, config/

## Phase 2 — Domain Mapping (DONE)

**Moves into `App\Modules\Coupon`:** 2 controllers, 5 models, 2 requests.
**Moves into `App\Modules\Promotion`:** 5 controllers, 5 models, 4 requests (Offer is grouped into Promotion per the user's checklist: "Offer / Promotion — services moved to `app/Modules/Promotion/Services`").

**Stays global (must NOT move):**
- `app/OpenApi/Schemas/*`, `app/OpenApi/Responses/*` — shared infrastructure (AGENTS.md §21)
- `app/Http/Controllers/Controller.php`, `app/Http/Traits/ApiResponse.php`, `app/Http/Services/ImageService.php`, `app/Http/Requests/BaseFormRequest.php`, `app/Helpers/TextNormalizer.php` — global infra
- `routes/api.php` — route definitions untouched; 6 controller imports updated only
- `database/seeders/*` — seeders stay in `Database\Seeders`; import updates only
- `app/Models/ProvisionalData.php` — shared between Payment and Promotion code, not in scope
- `app/Modules/Organization/...`, `app/Modules/User/...`, `app/Modules/Payment/...`, `app/Modules/Service/...`, `app/Modules/Auth/...` — stay in their modules; model imports updated

## Phase 3 — Target Structure

### Move table

| Current path | New path | New namespace |
|---|---|---|
| app/Http/Controllers/CouponController.php | app/Modules/Coupon/Controllers/CouponController.php | App\Modules\Coupon\Controllers |
| app/Http/Controllers/CouponUsageController.php | app/Modules/Coupon/Controllers/CouponUsageController.php | App\Modules\Coupon\Controllers |
| app/Models/Coupon.php | app/Modules/Coupon/Models/Coupon.php | App\Modules\Coupon\Models |
| app/Models/CouponCategory.php | app/Modules/Coupon/Models/CouponCategory.php | App\Modules\Coupon\Models |
| app/Models/CouponOrganization.php | app/Modules/Coupon/Models/CouponOrganization.php | App\Modules\Coupon\Models |
| app/Models/CouponUsage.php | app/Modules/Coupon/Models/CouponUsage.php | App\Modules\Coupon\Models |
| app/Models/CouponUser.php | app/Modules/Coupon/Models/CouponUser.php | App\Modules\Coupon\Models |
| app/Http/Requests/StoreCouponRequest.php | app/Modules/Coupon/Requests/StoreCouponRequest.php | App\Modules\Coupon\Requests |
| app/Http/Requests/UpdateCouponRequest.php | app/Modules/Coupon/Requests/UpdateCouponRequest.php | App\Modules\Coupon\Requests |
| app/Http/Controllers/OfferController.php | app/Modules/Promotion/Controllers/OfferController.php | App\Modules\Promotion\Controllers |
| app/Http/Controllers/PromoterController.php | app/Modules/Promotion/Controllers/PromoterController.php | App\Modules\Promotion\Controllers |
| app/Http/Controllers/PromoterRatioController.php | app/Modules/Promotion/Controllers/PromoterRatioController.php | App\Modules\Promotion\Controllers |
| app/Http/Controllers/PromoterTrackingController.php | app/Modules/Promotion/Controllers/PromoterTrackingController.php | App\Modules\Promotion\Controllers |
| app/Http/Controllers/PromotionActivityController.php | app/Modules/Promotion/Controllers/PromotionActivityController.php | App\Modules\Promotion\Controllers |
| app/Models/Offer.php | app/Modules/Promotion/Models/Offer.php | App\Modules\Promotion\Models |
| app/Models/OfferUsage.php | app/Modules/Promotion/Models/OfferUsage.php | App\Modules\Promotion\Models |
| app/Models/Promoter.php | app/Modules/Promotion/Models/Promoter.php | App\Modules\Promotion\Models |
| app/Models/PromoterRatio.php | app/Modules/Promotion/Models/PromoterRatio.php | App\Modules\Promotion\Models |
| app/Models/PromotionActivity.php | app/Modules/Promotion/Models/PromotionActivity.php | App\Modules\Promotion\Models |
| app/Http/Requests/StoreOfferRequest.php | app/Modules/Promotion/Requests/StoreOfferRequest.php | App\Modules\Promotion\Requests |
| app/Http/Requests/UpdateOfferRequest.php | app/Modules/Promotion/Requests/UpdateOfferRequest.php | App\Modules\Promotion\Requests |
| app/Http/Requests/StorePromoterRequest.php | app/Modules/Promotion/Requests/StorePromoterRequest.php | App\Modules\Promotion\Requests |
| app/Http/Requests/StorePromoterActivity.php | app/Modules/Promotion/Requests/StorePromoterActivity.php | App\Modules\Promotion\Requests |

### Routes wiring

No module route files are created. All route definitions stay verbatim in the root `routes/api.php` (project precedent from Payment/Card/Service/Article/Organization refactors). Only the 6 `use` lines for the moving controllers are rewritten to their new namespaces.

## Phase 4 — References to update (import-only edits, files do not move)

- `routes/api.php` — 6 controller imports (lines 16, 25, 34, 48, 49, 50)
- `app/Modules/Coupon/Services/CouponAuthorizationService.php` — Coupon, CouponOrganization, CouponUser
- `app/Modules/Coupon/Services/CouponFetchService.php` — Coupon
- `app/Modules/Coupon/Services/CouponService.php` — Coupon, CouponCategory, CouponOrganization, CouponUser
- `app/Modules/Coupon/Services/CouponUsageService.php` — Coupon, CouponOrganization, CouponUsage, CouponUser
- `app/Modules/Coupon/Services/CouponValidationService.php` — Coupon, CouponOrganization, CouponUsage
- `app/Modules/Promotion/Services/PromotionService.php` — Promoter, PromotionActivity (ProvisionalData stays)
- `app/Http/Controllers/DashboardMainPageController.php` — Coupon, Offer, Promoter
- `app/Modules/User/Models/User.php` — Coupon, Promoter (relationship imports)
- `app/Modules/Organization/Models/Organization.php` — Coupon, Offer (relationship imports)
- `app/Modules/Auth/Controllers/AuthController.php` — PromotionActivity
- `app/Modules/User/Controllers/UserController.php` — Promoter, PromoterRatio, PromotionActivity
- `app/Modules/Organization/Services/CreateOrganizationService.php` — Promoter, PromotionActivity, PromoterRatio
- `app/Modules/Payment/Services/ProcessCardsPaymentService.php` — PromoterRatio, PromotionActivity
- `app/Modules/Payment/Services/ProcessServiceDealPayment.php` — PromoterRatio, PromotionActivity
- `app/Modules/Payment/Services/ProcessServicePayment.php` — PromoterRatio, PromotionActivity
- `app/Modules/Service/Services/StoreServiceOrderService.php` — PromoterRatio, PromotionActivity
- `database/seeders/CouponSeeder.php` — Coupon, CouponCategory
- `database/seeders/OfferSeeder.php` — Offer
- `database/seeders/PromoterSeeder.php` — Promoter
- `database/seeders/PromotionActivitySeeder.php` — PromotionActivity, Promoter
- `database/seeders/promoterRatioSeeder.php` — PromoterRatio

## Verification plan (apply phase)

```bash
composer dump-autoload
php artisan optimize:clear
php artisan route:list
php artisan test
```

Then `git diff` / `git status` review — expected diff: file moves, namespace changes, import updates only.

## Uncertain / needs a decision

1. **Offer inside `Promotion` module** — Offer could arguably be its own module, but the user's checklist explicitly groups it under Promotion/Services, so Promotion is the plan. Flagged in case a separate `Offer` module is preferred.
2. **`CouponUsageController`** — fully empty stub (all 10 methods blank), not registered in any route. Still coupon-domain, so moving it is structural and harmless; flagged only because it is dead code.
3. **`OfferUsage` model** — referenced by nothing in the codebase (dead model). Moves with Offer for cohesion; no import updates needed.
4. **`ProvisionalData`** stays in `App\Models` — shared between Payment and Promotion code, not in scope.

## Pre-existing issues noticed (report only, not fixed)

- `PromotionService::process()` (app/Modules/Promotion/Services/PromotionService.php) — comment admits uncertainty about `metadata` being array vs JSON string; the read path (`is_string` check + decode) and write path (`json_encode`) can double-encode if the model cast is array. Potential data-corruption bug.
- `PromoterRatioController::getRatiosRatio()` — `PromoterRatio::findOrFail(1)` hardcodes row ID 1; 404/500s if the row doesn't exist. Same hardcoded pattern in `UserController` (`PromoterRatio::find(1)`).
- `StorePromoterActivity` request class name lacks the `Request` suffix (inconsistent naming) — renaming is out of scope per AGENTS.md §40.
- Route `POST /promotion-visit` is declared at routes/api.php:177 outside the auth-protected group containing the other promoter routes — may be unauthenticated vs its siblings; out of scope.
