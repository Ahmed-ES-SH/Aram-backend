# Plan — Card Module Refactor

**Status:** PLANNED — awaiting execution.
**Scope:** Structural refactor of the card domain (Card, CardCategory, OwnedCard, Currency) into `app/Modules/Card/` per AGENTS.md rules (move code, don't rewrite it; behavior must remain identical).

---

## Phase 1 — Inspection (DONE)

- [x] `app/Http/Controllers/CardController.php` — 7 endpoints (admin + public card CRUD), `ImageService` + `ApiResponse` + `TextNormalizer` deps, OA tag `Cards`, refs `CardStoreRequest`/`Card` schemas (string refs)
- [x] `app/Http/Controllers/CardCategoryController.php` — 9 endpoints (card category CRUD), uses **generic** `StoreCategoryRequest`/`UpdateCategoryRequest` (shared with unmigrated Category domain) and OA `CategoryStoreRequest`/`CategoryUpdateRequest` schema refs, OA tag `Card Categories`
- [x] `app/Http/Controllers/OwnedCardController.php` — 1 endpoint (`GET /cards-account`, paginated owned cards for user/organization), OA tag `Cards`, imports `App\Modules\User\Models\User` + `App\Modules\Organization\Models\Organization` (already module-namespaced)
- [x] `app/Http/Controllers/CurrencyController.php` — 5 admin endpoints (currency CRUD), OA tag `Currencies`
- [x] Models: `Card` (belongsTo `CardCategory`, belongsToMany `Keyword` via `card_keywords`, hasMany `CardBenefit`), `CardCategory` (hasMany `Card`), `OwnedCard` (belongsTo `Card`), `Currency`, `CardBenefit` (belongsTo `Card`), `CardKeyword` (empty, **unreferenced** pivot model)
- [x] Requests: `StoreCardRequest`/`UpdateCardRequest` extend `FormRequest`; `StoreCurrencyRequest`/`UpdateCurrencyRequest` extend global `BaseFormRequest`
- [x] `app/Console/Commands/ExpireCardsCommand.php` — expires `OwnedCard` rows; signature `app:expire-cards-command`, scheduled in `routes/console.php:17` by string only
- [x] OpenApi schemas `CardSchema`, `CardCategorySchema`, `CardStoreRequestSchema`, `CurrencySchema`, `CurrencyStoreRequestSchema` — standalone OA attribute classes, zero model imports, string-only `#/components/schemas/...` refs (inter- and cross-referenced)
- [x] Seeders: `CardsTableSeeder` (imports `Card`, `CardBenefit`), `CardCategorySeeder` / `CurrencySeeder` (DB::table only), `CardsHeaderSeeder` (imports `VariableData`); referenced by `DatabaseSeeder.php:21,30,31` and `VariableDataSeeder.php:15` by class name
- [x] Tests: zero references to Card/Currency/OwnedCard anywhere in `tests/`
- [x] Migrations: table-based, no model namespaces — untouched (AGENTS.md §42)
- [x] Cross-module importers of Card models: `CouponUsageService` (Card, OwnedCard), `ProcessCardsPaymentService` (OwnedCard), `OrganizationBenefit` (Card), `Keyword` (Card, ×2)
- [x] `app/Jobs/ProcessPaymentJob.php` references only `ProcessCardsPaymentService` (Payment module) — no Card-model import, no change

## Phase 2 — Domain Mapping (DONE)

**Moves into `App\Modules\Card`:** 4 controllers, 6 models, 4 requests.

**Stays global (must NOT move):**
- `app/OpenApi/Schemas/CardSchema|CardCategorySchema|CardStoreRequestSchema|CurrencySchema|CurrencyStoreRequestSchema` — OpenApi is shared infrastructure (AGENTS.md §21); string refs work from any location; consistent with Article/Organization precedent
- `app/OpenApi/Responses/*`, `app/Http/Controllers/Controller.php`, `app/Http/Traits/ApiResponse.php`, `app/Http/Services/ImageService.php`, `app/Http/Requests/BaseFormRequest.php`, `app/Helpers/TextNormalizer.php` — global infra
- `app/Console/Commands/ExpireCardsCommand.php` — Console commands are global infra (AGENTS.md §37); import update only
- `database/seeders/*` — seeders stay in `Database\Seeders`; `CardsTableSeeder` import update only
- `routes/api.php` — 4 controller imports updated; route bodies use `::class`
- `routes/console.php` — schedules by signature string, no class ref, unchanged
- `app/Http/Requests/StoreCategoryRequest|UpdateCategoryRequest` — shared with unmigrated Category domain, stay global
- `app/Modules/Keyword/Models/Keyword.php`, `app/Modules/Organization/Models/OrganizationBenefit.php`, `app/Modules/Payment/Services/ProcessCardsPaymentService.php`, `app/Modules/Coupon/Services/CouponUsageService.php` — stay in their modules; Card-model imports updated

## Phase 3 — Target Structure

```
app/Modules/Card/
├── Controllers/
│   ├── CardController.php
│   ├── CardCategoryController.php
│   ├── OwnedCardController.php
│   └── CurrencyController.php
├── Models/
│   ├── Card.php
│   ├── CardCategory.php
│   ├── OwnedCard.php
│   ├── Currency.php
│   ├── CardBenefit.php
│   └── CardKeyword.php
└── Requests/
    ├── StoreCardRequest.php
    ├── UpdateCardRequest.php
    ├── StoreCurrencyRequest.php
    └── UpdateCurrencyRequest.php
```

Only the three directories that contain files.

## Phase 4 — Move Table (validation complete)

| # | Old path | New path | New namespace | References to update |
|---|---|---|---|---|
| 1 | `app/Http/Controllers/CardController.php` | `app/Modules/Card/Controllers/CardController.php` | `App\Http\Controllers` → `App\Modules\Card\Controllers` | `routes/api.php:12`; add `use App\Http\Controllers\Controller;`; re-point `Card`, `StoreCardRequest`, `UpdateCardRequest` imports to module |
| 2 | `app/Http/Controllers/CardCategoryController.php` | `app/Modules/Card/Controllers/CardCategoryController.php` | `App\Http\Controllers` → `App\Modules\Card\Controllers` | `routes/api.php:11`; add `use App\Http\Controllers\Controller;`; re-point `CardCategory` import; `StoreCategoryRequest`/`UpdateCategoryRequest` stay global |
| 3 | `app/Http/Controllers/OwnedCardController.php` | `app/Modules/Card/Controllers/OwnedCardController.php` | `App\Http\Controllers` → `App\Modules\Card\Controllers` | `routes/api.php:47`; add `use App\Http\Controllers\Controller;`; re-point `OwnedCard` import |
| 4 | `app/Http/Controllers/CurrencyController.php` | `app/Modules/Card/Controllers/CurrencyController.php` | `App\Http\Controllers` → `App\Modules\Card\Controllers` | `routes/api.php:17`; add `use App\Http\Controllers\Controller;`; re-point `Currency`, `StoreCurrencyRequest`, `UpdateCurrencyRequest` imports |
| 5 | `app/Models/Card.php` | `app/Modules/Card/Models/Card.php` | `App\Models` → `App\Modules\Card\Models` | `use App\Models\Card` in `CardController.php`, `CouponUsageService.php:5`, `OrganizationBenefit.php:5`, `Keyword.php:5`, `CardsTableSeeder.php:5` |
| 6 | `app/Models/CardCategory.php` | `app/Modules/Card/Models/CardCategory.php` | `App\Models` → `App\Modules\Card\Models` | `use App\Models\CardCategory` in `CardCategoryController.php` |
| 7 | `app/Models/OwnedCard.php` | `app/Modules/Card/Models/OwnedCard.php` | `App\Models` → `App\Modules\Card\Models` | `use App\Models\OwnedCard` in `OwnedCardController.php`, `ExpireCardsCommand.php:5`, `ProcessCardsPaymentService.php:7`, `CouponUsageService.php:10` |
| 8 | `app/Models/Currency.php` | `app/Modules/Card/Models/Currency.php` | `App\Models` → `App\Modules\Card\Models` | `use App\Models\Currency` in `CurrencyController.php` |
| 9 | `app/Models/CardBenefit.php` | `app/Modules/Card/Models/CardBenefit.php` | `App\Models` → `App\Modules\Card\Models` | `use App\Models\CardBenefit` in `CardsTableSeeder.php:6` |
| 10 | `app/Models/CardKeyword.php` | `app/Modules/Card/Models/CardKeyword.php` | `App\Models` → `App\Modules\Card\Models` | none (unreferenced) |
| 11 | `app/Http/Requests/StoreCardRequest.php` | `app/Modules/Card/Requests/StoreCardRequest.php` | `App\Http\Requests` → `App\Modules\Card\Requests` | `CardController.php:6` |
| 12 | `app/Http/Requests/UpdateCardRequest.php` | `app/Modules/Card/Requests/UpdateCardRequest.php` | `App\Http\Requests` → `App\Modules\Card\Requests` | `CardController.php:7` |
| 13 | `app/Http/Requests/StoreCurrencyRequest.php` | `app/Modules/Card/Requests/StoreCurrencyRequest.php` | `App\Http\Requests` → `App\Modules\Card\Requests` | `CurrencyController.php:5`; `BaseFormRequest` import stays global |
| 14 | `app/Http/Requests/UpdateCurrencyRequest.php` | `app/Modules/Card/Requests/UpdateCurrencyRequest.php` | `App\Http\Requests` → `App\Modules\Card\Requests` | `CurrencyController.php:6`; `BaseFormRequest` import stays global |

**Update-only (no moves):**
- `routes/api.php:11,12,17,47` — 4 controller imports; URLs/methods/names/middleware untouched (lines 209–213, 229, 259, 467, 876, 1008, 1036)
- `app/Modules/Coupon/Services/CouponUsageService.php:5,10` — Card + OwnedCard imports
- `app/Modules/Payment/Services/ProcessCardsPaymentService.php:7` — OwnedCard import
- `app/Modules/Organization/Models/OrganizationBenefit.php:5` — Card import
- `app/Modules/Keyword/Models/Keyword.php:5` — Card import
- `app/Console/Commands/ExpireCardsCommand.php:5` — OwnedCard import
- `database/seeders/CardsTableSeeder.php:5,6` — Card + CardBenefit imports (`DatabaseSeeder.php:21,30,31` uses class names — unchanged)

**No change needed:**
- Composer PSR-4 `App\` → `app/` already covers `App\Modules\Card\...` — no composer.json edit
- Model cross-references (`Card`↔`CardCategory`↔`CardBenefit`↔`OwnedCard`) resolve within the single new namespace
- OpenApi schemas — no class imports of models/controllers
- `config/l5-swagger.php:49` already scans `app_path('Modules')` — moved controllers' OA attributes remain in the OpenAPI document
- `routes/console.php` — string signature only
- Migrations, tests, `ProcessPaymentJob`, seeders `CardCategorySeeder`/`CurrencySeeder`/`CardsHeaderSeeder` — untouched

## Phase 5 — Execution (PENDING — run with build agent)

- [ ] Move 14 files (Phase 4 table)
- [ ] Update namespaces + imports in moved files (incl. new `use App\Http\Controllers\Controller;` in all 4 controllers; `use App\Modules\Card\Models\...`; `use App\Modules\Card\Requests\...`)
- [ ] Update `routes/api.php` imports (lines 11, 12, 17, 47)
- [ ] Update imports in 6 stay-in-place files (CouponUsageService, ProcessCardsPaymentService, OrganizationBenefit, Keyword, ExpireCardsCommand, CardsTableSeeder)
- [ ] `grep` for remaining `App\Models\Card` / `App\Models\OwnedCard` / `App\Models\Currency` / `App\Http\Controllers\Card*Controller` references — zero matches expected
- [ ] `composer dump-autoload`
- [ ] `php artisan optimize:clear`
- [ ] `php artisan route:list` — confirm `/cards`, `/card-categories`, `/currencies`, `/cards-account` route groups intact
- [ ] `php artisan test`
- [ ] `git diff` / `git status` — moves + namespace/import changes only

## Phase 6 — Flagged / Uncertain

- **Currency placement:** standalone admin CRUD, not strictly card logic; grouped into `Card` per the task list and used in card pricing flows. Easy to split into its own module later if desired.
- **OwnedCard is cross-cutting:** used by Payment, Coupon, and Console modules — but it is an owned instance of `Card`, so it belongs in the Card module; all 7 external importers enumerated above.
- **ExpireCardsCommand:** card-domain logic but Console is global infra (AGENTS.md §37); no existing module has a Console dir — stays global, import updated.
- **CardKeyword:** completely unreferenced empty model; moved with the domain rather than left orphaned.
- **CardCategoryController uses generic `StoreCategoryRequest`/`UpdateCategoryRequest`** shared with the unmigrated Category domain — those stay global; only the controller moves.
- **OpenAPI schemas kept global** per AGENTS.md §21, consistent with all prior module migrations.

## Phase 7 — Pre-existing Issues (report only, NOT fixed)

- [x] `app/Modules/Organization/Models/OrganizationBenefit.php:18` — `organization()` returns `belongsTo(Card::class)`; almost certainly a copy-paste error (a benefit belongs to an Organization, not a Card)
- [x] `CardCategoryController::update()` (line 315) — `$category->load('sub_categories')`; `CardCategory` has no `sub_categories` relation (that's on the generic `Category`), so the endpoint likely throws `BadMethodCallException` and always returns 500; `$category->fresh()` result is also discarded
- [x] `CardController` store vs update keyword handling is inconsistent (store uses `keyword_id` keys, update uses `id` keys)
- [x] `CardController::index()` — `$active = $request->input('active')` then `where('active', $active)`; string `"false"` is truthy, so `?active=false` filtering is unreliable

---

**Plan only — no files were changed. If this looks correct, run `/laravel-refactor-apply ## Card
- [ ] CardController
- [ ] CardCategoryController
- [ ] OwnedCardController
- [ ] CurrencyController ` to execute it with the build agent.**