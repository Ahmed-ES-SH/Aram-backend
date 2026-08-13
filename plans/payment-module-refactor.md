# Plan — Payment / Wallet Module Refactor

**Status:** PLANNED — awaiting execution.
**Scope:** Structural refactor of the payment/wallet domain (PaymentController, TransactionController, WalletController, WithdrawRequestController + clearly-owned support classes) into `app/Modules/Payment/` per AGENTS.md rules (move code, don't rewrite it; behavior must remain identical). The Payment module already exists with its services moved (`app/Modules/Payment/Services/`).

---

## Phase 1 — Inspection (DONE)

- [x] `app/Http/Controllers/WalletController.php` — 4 endpoints (`GET /wallet`, `POST /wallet/deposit`, `/wallet/add-pending`, `/wallet/release-pending`), OA tag `Wallet & Transactions`, deps: `Wallet`, `Transaction`, `WithdrawRequest` (unused import, line 10), `User`, `Organization`, `ApiResponse` trait; routes at `routes/api.php:549-552`, import at `:37`
- [x] `app/Http/Controllers/TransactionController.php` — 1 endpoint (`GET /user-transactions`), OA tag `Wallet & Transactions`, deps: `Transaction`, `ApiResponse`; route at `routes/api.php:553`, import at `:35`
- [x] `app/Http/Controllers/PaymentController.php` — 3 endpoints (`POST /payment/create-session`, `/payment/webhook`, `/payment/callback`), OA tag `Payments`, deps: `Invoice`, Payment-module services (`PaymentService`, `ProcessCardsPaymentService`, `ProcessBookPaymentService`, `ProcessServicePayment`, `ProcessServiceDealPayment`), `ProcessPaymentJob`, `ApiResponse`; routes at `routes/api.php:474-476`, import at `:41`
- [x] `app/Http/Controllers/WithdrawRequestController.php` — 5 endpoints (`POST /wallet/withdraw`, `GET /withdraw-requests`, `GET /withdraw-requests/{id}`, `POST /admin/withdraw-requests/{id}/approve`, `/reject`), OA tag `Wallet & Transactions`, deps: `Transaction`, `WithdrawRequest`, `User`, `Organization`, `ApiResponse`; routes at `routes/api.php:483,954-957`, import at `:46`
- [x] Models: `Wallet` (belongsTo `User`/`Organization`), `Transaction` (belongsTo `User`), `WithdrawRequest` (belongsTo `User`, hasOne `Transaction` — see bug #3), `Invoice` (plain, cross-module), `ProvisionalData` (plain, cross-module)
- [x] `app/DTOs/PaymentDTO.php` — `fromRequest()` static factory; used by 5 Payment services + `PromotionService` (Promotion module)
- [x] `app/Jobs/ProcessPaymentJob.php` — dispatched only by `PaymentController`; injects Payment-module services only
- [x] OpenApi schemas `WalletSchema`, `TransactionSchema`, `WithdrawRequestSchema` — standalone OA attribute classes, string-only refs, zero model imports → shared infrastructure, stay global (Card/Article precedent)
- [x] `app/OpenApi/OpenApiDocument.php:27` — OA tag `Wallet & Transactions` is a string, no change
- [x] Seeders: `TransactionSeeder` uses `DB::table` only, no model import → no change; referenced by `DatabaseSeeder.php:48` by class name
- [x] Tests: zero references to Wallet/Transaction/WithdrawRequest/Invoice/Payment anywhere in `tests/`
- [x] Factories: only `UserFactory` exists, no payment/wallet factories
- [x] Migrations: table-based, no model namespaces — untouched (AGENTS.md §42)
- [x] Providers/Console/Helpers: no references to the moved classes
- [x] `composer.json` PSR-4 `"App\\": "app/"` already covers `App\Modules\Payment\...` — no composer change needed

## Phase 2 — Domain Mapping (DONE)

Domain = **`Payment`** (module already established by the services move; OA tag "Wallet & Transactions" confirms wallet/withdrawals are the same business area).

**Tier 1 — core (the 4 controllers):**
- `WalletController`, `TransactionController`, `PaymentController`, `WithdrawRequestController` → `App\Modules\Payment\Controllers`

**Tier 2 — clearly Payment-owned support classes (recommended, consistent with Card/Article/Organization precedent):**
- `Wallet`, `Transaction`, `WithdrawRequest` models → `App\Modules\Payment\Models`
- `PaymentDTO` → `App\Modules\Payment\DTOs`
- `ProcessPaymentJob` → `App\Modules\Payment\Jobs`

**Tier 3 — ambiguous (AGENTS.md §36); do NOT move without explicit approval:**
- `app/Models/Invoice.php` — primary owner is Payment (5 payment services + PaymentController) but Service module imports it too (`ServiceOrder`, `ServiceTracking`, `StoreServiceOrderService`) plus `InvoiceController`
- `app/Models/ProvisionalData.php` — Payment services (5 files) + `PromotionService` (Promotion module)
- `app/Http/Controllers/InvoiceController.php` — empty resource stub, zero routes, outside the stated 4-controller scope

**Stays global (must NOT move):**
- `app/Http/Controllers/Controller.php` (base controller), `app/Http/Traits/ApiResponse.php`
- `app/OpenApi/Schemas/WalletSchema|TransactionSchema|WithdrawRequestSchema`, `app/OpenApi/Responses/*`, `app/OpenApi/OpenApiDocument.php`
- `database/seeders/TransactionSeeder.php`, `DatabaseSeeder.php` — no model imports
- `routes/api.php` — controller imports updated only; route bodies use `::class`
- `routes/console.php` — no refs
- `app/Modules/User/Models/User.php`, `app/Modules/Organization/Models/Organization.php`, `app/Modules/Promotion/Services/PromotionService.php`, `app/Modules/Service/Models/ServiceOrder.php`, `app/Modules/Service/Models/ServiceTracking.php`, `app/Modules/Service/Services/StoreServiceOrderService.php` — stay in their modules; imports updated where a moved class is imported

## Phase 3 — Target Structure

```
app/Modules/Payment/
├── Controllers/
│   ├── PaymentController.php
│   ├── TransactionController.php
│   ├── WalletController.php
│   └── WithdrawRequestController.php
├── Models/            (Tier 2)
│   ├── Transaction.php
│   ├── Wallet.php
│   └── WithdrawRequest.php
├── DTOs/              (Tier 2)
│   └── PaymentDTO.php
├── Jobs/              (Tier 2)
│   └── ProcessPaymentJob.php
└── Services/          (already moved)
```

Only the directories that contain files.

## Phase 4 — Move Table (validation complete)

| # | Old path | New path | New namespace | References to update |
|---|---|---|---|---|
| 1 | `app/Http/Controllers/WalletController.php` | `app/Modules/Payment/Controllers/WalletController.php` | `App\Http\Controllers` → `App\Modules\Payment\Controllers` | `routes/api.php:37`; add `use App\Http\Controllers\Controller;`; re-point `Wallet` (→ T2 path), `Transaction` (→ T2 path), `WithdrawRequest` (→ T2 path) imports |
| 2 | `app/Http/Controllers/TransactionController.php` | `app/Modules/Payment/Controllers/TransactionController.php` | same | `routes/api.php:35`; add base-Controller import; re-point `Transaction` |
| 3 | `app/Http/Controllers/PaymentController.php` | `app/Modules/Payment/Controllers/PaymentController.php` | same | `routes/api.php:41`; add base-Controller import; re-point `Invoice` (Tier 3, only if moved) and `ProcessPaymentJob` (→ T2 path); Payment-service imports already module-prefixed |
| 4 | `app/Http/Controllers/WithdrawRequestController.php` | `app/Modules/Payment/Controllers/WithdrawRequestController.php` | same | `routes/api.php:46`; add base-Controller import; re-point `Transaction`, `WithdrawRequest` |
| 5 | `app/Models/Wallet.php` (T2) | `app/Modules/Payment/Models/Wallet.php` | `App\Models` → `App\Modules\Payment\Models` | `use App\Models\Wallet` in `User.php:14`, `Organization.php:14`, `ProcessBookPaymentService.php:13`, `WalletController.php:9` |
| 6 | `app/Models/Transaction.php` (T2) | `app/Modules/Payment/Models/Transaction.php` | same | `use App\Models\Transaction` in `WalletController:7`, `TransactionController:6`, `WithdrawRequestController:7`, `WithdrawRequest.php:34` (self-relation), `ProcessServicePayment:17`, `ProcessBookPaymentService:11`, `ProcessServiceDealPayment:13` |
| 7 | `app/Models/WithdrawRequest.php` (T2) | `app/Modules/Payment/Models/WithdrawRequest.php` | same | `use App\Models\WithdrawRequest` in `WalletController:10`, `WithdrawRequestController:9` |
| 8 | `app/DTOs/PaymentDTO.php` (T2) | `app/Modules/Payment/DTOs/PaymentDTO.php` | `App\DTOs` → `App\Modules\Payment\DTOs` | `use App\DTOs\PaymentDTO` in `PaymentService:5`, `InvoiceService:5`, `ThawaniService:5`, `ProvisionalService:5`, `ProcessServicePayment:5`, `PromotionService:5` |
| 9 | `app/Jobs/ProcessPaymentJob.php` (T2) | `app/Modules/Payment/Jobs/ProcessPaymentJob.php` | `App\Jobs` → `App\Modules\Payment\Jobs` | `PaymentController:15` (moves together); no other refs |
| 10 | `app/Models/Invoice.php` (T3 — only if approved) | `app/Modules/Payment/Models/Invoice.php` | `App\Models` → `App\Modules\Payment\Models` | `PaymentController:6`, `ProcessServicePayment:8`, `ProcessCardsPaymentService:6`, `InvoiceService:6`, `ProcessBookPaymentService:8`, `ProcessServiceDealPayment:7`, `ServiceOrder:5`, `ServiceTracking:6`, `StoreServiceOrderService:7`, `InvoiceController:5` |
| 11 | `app/Models/ProvisionalData.php` (T3 — only if approved) | `app/Modules/Payment/Models/ProvisionalData.php` | same | `ProcessServicePayment:12`, `ProcessCardsPaymentService:10`, `ProcessBookPaymentService:10`, `ProcessServiceDealPayment:10`, `ProvisionalService:6`, `PromotionService:8` |
| 12 | `app/Http/Controllers/InvoiceController.php` (T3 — only if approved) | `app/Modules/Payment/Controllers/InvoiceController.php` | `App\Http\Controllers` → `App\Modules\Payment\Controllers` | no routes reference it; re-point `use App\Models\invoice` (lowercase) |

Route URLs, HTTP methods, route names, middleware, and controller bodies remain byte-identical apart from namespace/import lines.

## Phase 5 — Validation Notes

- No tests/factories/seeders/policies/OpenAPI schemas reference the moved classes → no hidden breakage
- `composer.json` PSR-4 already covers `App\Modules\Payment\...` → only `composer dump-autoload` required
- Cross-module imports (User/Organization → Wallet, Promotion → PaymentDTO/ProvisionalData, Service → Invoice) are the established pattern (Card models are already imported cross-module)

## Phase 6 — Verification (apply phase)

```bash
composer dump-autoload
php artisan optimize:clear
php artisan route:list
php artisan test
```

## Uncertain / Flagged

1. **Invoice, ProvisionalData, InvoiceController (Tier 3)** — cross-module (Service/Promotion) or out-of-scope stub. Conservative default: leave global this run; moving is safe (import updates only) but requires explicit approval
2. Module naming: everything lands in the existing **`Payment`** module (per task); AGENTS.md lists separate `Wallet/` + `Payment/` examples, but the repo has already committed to `Payment` — stay with it

## Pre-existing Issues (report only — NOT fixed, AGENTS.md §7)

1. `PaymentController::callback()` — `$e->getCode() ?? 500` never falls back (getCode() returns 0, not null) → `errorResponse($msg, 0)` sends status 0 for non-422 exceptions
2. `routes/api.php:474-476` — `/payment/webhook` and `/payment/callback` sit inside the `auth:sanctum` group (starts line 460) → Thawani's server-to-server webhook/callback require a user token, likely unreachable by the gateway (verify with `route:list` during apply)
3. `app/Models/WithdrawRequest.php:32-37` — `transaction()` passes a Closure as the 2nd arg of `hasOne()` (the `$foreignKey` slot) → relation evaluation will fail with a Closure-to-string error; latent (unused by controllers)
4. `WithdrawRequestController::withdraw()` line 96 — `'bank_number' => 'required|'` trailing pipe with empty rule
5. `WithdrawRequestController::reject()` line 258 — `$withdraw->user->wallet` null-dereference risk (no user relation for organization-type requests; missing wallet row throws); `note` overwritten with nullable `$request->note`
6. `WithdrawRequestController::withdraw()` — insufficient-balance check runs outside the DB transaction (TOCTOU race); balance updates not row-locked
7. `WalletController::deposit()/addPending()` — `'user_id' => 'required'` without `integer` rule (inconsistent with `releasePending`)
8. `WalletController.php:10` — unused `use App\Models\WithdrawRequest;` import (re-pointed on move, not removed — no cleanup per AGENTS.md §44)