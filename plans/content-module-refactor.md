# Plan — Content Module Refactor

**Status:** PLANNED — awaiting execution.
**Scope:** Structural refactor of the "Content / Static Pages" domain into `app/Modules/Content/` per AGENTS.md rules (move code, don't rewrite it; behavior must remain identical).

---

## Phase 1 — Inspection (DONE)

- [x] All 14 target controllers exist in `app/Http/Controllers/` (namespace `App\Http\Controllers`): `AboutController`, `HomePageController`, `DashboardMainPageController`, `SlideController`, `WebsiteVideoController`, `NewsletterController`, `ContactMessageController`, `QuestionAnswerController`, `PrivacyPolicyController`, `TermsConditionController`, `FooterLinkController`, `CategoryController`, `SubCategoryController`, `VariableDataController`
- [x] Domain models in `app/Models/` (namespace `App\Models`): `About`, `HomePage`, `Slide`, `WebsiteVideo`, `Newsletter`, `ContactMessage`, `QuestionAnswer`, `PrivacyPolicy`, `TermsCondition`, `FooterLink`, `FooterList`, `VariableData`, `Category`, `SubCategory` — all plain models; only cross-module refs are `Category`/`SubCategory` → `App\Modules\Organization\Models\Organization` (unchanged)
- [x] `DashboardMainPageController` has no model of its own; reads other modules' models (`Coupon`, `Offer`, `Organization`, `Promoter`, `ServicePage`, `User`)
- [x] Requests in `app/Http/Requests/`: `StoreContactMessageRequest`, `StoreQuestionAnswerRequest`, `StoreFooterListLinkRequest`, `StoreSlideRequest`, `UpdateSlideRequest`, `UpdateAboutContentRequest`, `StoreSubCategoryRequest`, `UpdateSubCategoryRequest` — only referenced by their own controllers
- [x] `StoreCategoryRequest` / `UpdateCategoryRequest` — **shared** by `CategoryController`, `ArticleCategoryController`, `CardCategoryController`, `ServiceCategoryController` (prior refactors kept them global — stay global)
- [x] Resources: `app/Http/Resources/MainSectionResource.php` — only used by `VariableDataController`
- [x] Mail: `app/Mail/NewsletterMail.php` — only used by `NewsletterController::send()`
- [x] `app/Jobs/SendNewsletterJob.php` + `app/Mail/NewsletterEmail.php` — unreferenced dead code (nothing dispatches the job; `NewsletterEmail` used only by the job) — left in place, flagged
- [x] Routes: all 14 controllers referenced in `routes/api.php` (imports at top + route groups); URLs/methods/names unchanged by this refactor
- [x] Seeders importing domain models (13): `AboutSeeder`, `SlideSeeder`, `FooterListSeeder` (FooterLink+FooterList), `TermsConditionSeeder`, `PrivacyPolicySeeder`, `StatsSectionSeeder`, `OrganizationsHeaderSeeder`, `ServicesHeaderSeeder`, `CardsHeaderSeeder`, `ContactMessagesSeeder`, `NewsletterSeeder`, `QuestionAnswerSeeder`, `RealOrganizationCategorySeeder` + `RealOrganizationdSeeder` (Category)
- [x] Cross-module model imports to re-point: `ServicePageController.php:13` (`WebsiteVideo`, used at 144/284), `Organization.php:7,13` (`Category`/`SubCategory`), `Coupon.php:5,6` (`Category`/`SubCategory`), `Offer.php:5` (`Category`)
- [x] `ArticleCategoryController.php:12` — `use App\Models\Category;` is **unused**; moving the model cannot break it
- [x] No tests, policies, factories, providers, or commands reference any moved class; `app/OpenApi/**` uses string-name schema refs only (no class imports)
- [x] Composer PSR-4 `App\` → `app/` already covers `App\Modules\...` — no composer changes needed

## Phase 2 — Domain Mapping (DONE)

**Moves into `App\Modules\Content`:** 14 controllers, 14 models, 8 requests, 1 resource, 1 mail (38 files).

**Stays global (must NOT move):**
- `app/Http/Controllers/Controller.php`, `app/Http/Traits/ApiResponse.php`, `app/Http/Requests/BaseFormRequest.php`, `app/Http/Services/ImageService.php`, `app/Helpers/TextNormalizer.php` — shared infrastructure
- `app/Http/Requests/StoreCategoryRequest.php`, `UpdateCategoryRequest.php` — **shared** by 4 controllers across 4 modules (per prior plan precedent)
- `app/Jobs/SendNewsletterJob.php`, `app/Mail/NewsletterEmail.php` — unreferenced dead code; `SendNewsletterJob` takes a `$subscriber` (possibly Member/Subscription domain) — conservative: leave in place
- `app/OpenApi/**` — string-name schema refs only
- All migrations (table-based, no class refs); `app/Models/Invoice.php`, `Order.php`, `ProvisionalData.php`, `Referral.php`, `Todo.php` + `InvoiceController`, `ReferralController`, `TempUploadController`, `TodoController` — other domains, out of scope
- Other-domain features not in scope: `Article*`, `Service*`, `Card*`, `Organization*`, `Payment*`, `Coupon*`, `Promotion*`, `Conversation*`, etc.

## Phase 3 — Target Structure

```
app/Modules/Content/
├── Controllers/
│   ├── AboutController.php
│   ├── HomePageController.php
│   ├── DashboardMainPageController.php
│   ├── SlideController.php
│   ├── WebsiteVideoController.php
│   ├── NewsletterController.php
│   ├── ContactMessageController.php
│   ├── QuestionAnswerController.php
│   ├── PrivacyPolicyController.php
│   ├── TermsConditionController.php
│   ├── FooterLinkController.php
│   ├── CategoryController.php
│   ├── SubCategoryController.php
│   └── VariableDataController.php
├── Models/
│   ├── About.php
│   ├── HomePage.php
│   ├── Slide.php
│   ├── WebsiteVideo.php
│   ├── Newsletter.php
│   ├── ContactMessage.php
│   ├── QuestionAnswer.php
│   ├── PrivacyPolicy.php
│   ├── TermsCondition.php
│   ├── FooterLink.php
│   ├── FooterList.php
│   ├── VariableData.php
│   ├── Category.php
│   └── SubCategory.php
├── Requests/
│   ├── StoreContactMessageRequest.php
│   ├── StoreQuestionAnswerRequest.php
│   ├── StoreFooterListLinkRequest.php
│   ├── StoreSlideRequest.php
│   ├── UpdateSlideRequest.php
│   ├── UpdateAboutContentRequest.php
│   ├── StoreSubCategoryRequest.php
│   └── UpdateSubCategoryRequest.php
├── Resources/
│   └── MainSectionResource.php
└── Mail/
    └── NewsletterMail.php
```

## Phase 4 — Move Table (validation complete)

### Controllers — `App\Http\Controllers` → `App\Modules\Content\Controllers`

| # | Old path | New path |
|---|---|---|
| 1 | `app/Http/Controllers/AboutController.php` | `app/Modules/Content/Controllers/AboutController.php` |
| 2 | `app/Http/Controllers/HomePageController.php` | `app/Modules/Content/Controllers/HomePageController.php` |
| 3 | `app/Http/Controllers/DashboardMainPageController.php` | `app/Modules/Content/Controllers/DashboardMainPageController.php` |
| 4 | `app/Http/Controllers/SlideController.php` | `app/Modules/Content/Controllers/SlideController.php` |
| 5 | `app/Http/Controllers/WebsiteVideoController.php` | `app/Modules/Content/Controllers/WebsiteVideoController.php` |
| 6 | `app/Http/Controllers/NewsletterController.php` | `app/Modules/Content/Controllers/NewsletterController.php` |
| 7 | `app/Http/Controllers/ContactMessageController.php` | `app/Modules/Content/Controllers/ContactMessageController.php` |
| 8 | `app/Http/Controllers/QuestionAnswerController.php` | `app/Modules/Content/Controllers/QuestionAnswerController.php` |
| 9 | `app/Http/Controllers/PrivacyPolicyController.php` | `app/Modules/Content/Controllers/PrivacyPolicyController.php` |
| 10 | `app/Http/Controllers/TermsConditionController.php` | `app/Modules/Content/Controllers/TermsConditionController.php` |
| 11 | `app/Http/Controllers/FooterLinkController.php` | `app/Modules/Content/Controllers/FooterLinkController.php` |
| 12 | `app/Http/Controllers/CategoryController.php` | `app/Modules/Content/Controllers/CategoryController.php` |
| 13 | `app/Http/Controllers/SubCategoryController.php` | `app/Modules/Content/Controllers/SubCategoryController.php` |
| 14 | `app/Http/Controllers/VariableDataController.php` | `app/Modules/Content/Controllers/VariableDataController.php` |

Each controller: change namespace, add `use App\Http\Controllers\Controller;` (per prior refactor convention), re-point model/request/resource/mail imports to the Content module namespace.

### Models — `App\Models` → `App\Modules\Content\Models`

| # | Old path | New path |
|---|---|---|
| 15 | `app/Models/About.php` | `app/Modules/Content/Models/About.php` |
| 16 | `app/Models/HomePage.php` | `app/Modules/Content/Models/HomePage.php` |
| 17 | `app/Models/Slide.php` | `app/Modules/Content/Models/Slide.php` |
| 18 | `app/Models/WebsiteVideo.php` | `app/Modules/Content/Models/WebsiteVideo.php` |
| 19 | `app/Models/Newsletter.php` | `app/Modules/Content/Models/Newsletter.php` |
| 20 | `app/Models/ContactMessage.php` | `app/Modules/Content/Models/ContactMessage.php` |
| 21 | `app/Models/QuestionAnswer.php` | `app/Modules/Content/Models/QuestionAnswer.php` |
| 22 | `app/Models/PrivacyPolicy.php` | `app/Modules/Content/Models/PrivacyPolicy.php` |
| 23 | `app/Models/TermsCondition.php` | `app/Modules/Content/Models/TermsCondition.php` |
| 24 | `app/Models/FooterLink.php` | `app/Modules/Content/Models/FooterLink.php` |
| 25 | `app/Models/FooterList.php` | `app/Modules/Content/Models/FooterList.php` |
| 26 | `app/Models/VariableData.php` | `app/Modules/Content/Models/VariableData.php` |
| 27 | `app/Models/Category.php` | `app/Modules/Content/Models/Category.php` |
| 28 | `app/Models/SubCategory.php` | `app/Modules/Content/Models/SubCategory.php` |

(`Category`/`SubCategory` keep their `App\Modules\Organization\Models\Organization` imports — that module doesn't move.)

### Requests — `App\Http\Requests` → `App\Modules\Content\Requests`

| # | Old path | New path |
|---|---|---|
| 29 | `app/Http/Requests/StoreContactMessageRequest.php` | `app/Modules/Content/Requests/StoreContactMessageRequest.php` |
| 30 | `app/Http/Requests/StoreQuestionAnswerRequest.php` | `app/Modules/Content/Requests/StoreQuestionAnswerRequest.php` (keeps global `BaseFormRequest` import) |
| 31 | `app/Http/Requests/StoreFooterListLinkRequest.php` | `app/Modules/Content/Requests/StoreFooterListLinkRequest.php` |
| 32 | `app/Http/Requests/StoreSlideRequest.php` | `app/Modules/Content/Requests/StoreSlideRequest.php` |
| 33 | `app/Http/Requests/UpdateSlideRequest.php` | `app/Modules/Content/Requests/UpdateSlideRequest.php` |
| 34 | `app/Http/Requests/UpdateAboutContentRequest.php` | `app/Modules/Content/Requests/UpdateAboutContentRequest.php` |
| 35 | `app/Http/Requests/StoreSubCategoryRequest.php` | `app/Modules/Content/Requests/StoreSubCategoryRequest.php` |
| 36 | `app/Http/Requests/UpdateSubCategoryRequest.php` | `app/Modules/Content/Requests/UpdateSubCategoryRequest.php` |

### Resources & Mail

| # | Old path | New path | New namespace |
|---|---|---|---|
| 37 | `app/Http/Resources/MainSectionResource.php` | `app/Modules/Content/Resources/MainSectionResource.php` | `App\Modules\Content\Resources` |
| 38 | `app/Mail/NewsletterMail.php` | `app/Modules/Content/Mail/NewsletterMail.php` | `App\Modules\Content\Mail` (re-points `Newsletter` import to module) |

## Phase 5 — Reference Updates (validation complete)

| File | Change |
|---|---|
| `routes/api.php` | 14 `use App\Http\Controllers\XController;` imports → `App\Modules\Content\Controllers\...` (lines 3, 13, 14, 18, 20, 28, 30, 31, 33, 38, 39, 43, 52, 53). Route URLs/methods/names/groups untouched. |
| `app/Modules/Service/Controllers/ServicePageController.php:13` | `use App\Models\WebsiteVideo;` → `use App\Modules\Content\Models\WebsiteVideo;` — used at lines 144, 284 |
| `app/Modules/Organization/Models/Organization.php:7,13` | `Category`, `SubCategory` imports → `App\Modules\Content\Models\...` |
| `app/Modules/Coupon/Models/Coupon.php:5,6` | `Category`, `SubCategory` imports → `App\Modules\Content\Models\...` |
| `app/Modules/Promotion/Models/Offer.php:5` | `Category` import → `App\Modules\Content\Models\...` |
| `app/Mail/NewsletterMail.php:5` | moves with file; `Newsletter` → `App\Modules\Content\Models\Newsletter` |
| Seeders (13 files) | AboutSeeder, SlideSeeder, FooterListSeeder (FooterLink+FooterList), TermsConditionSeeder, PrivacyPolicySeeder, StatsSectionSeeder, OrganizationsHeaderSeeder, ServicesHeaderSeeder, CardsHeaderSeeder, ContactMessagesSeeder, NewsletterSeeder, QuestionAnswerSeeder, RealOrganizationCategorySeeder, RealOrganizationdSeeder (Category) — all re-point to `App\Modules\Content\Models\...` |

**Verified safe (no changes needed):** `app/OpenApi/**` (string-name schema refs only, no class imports), `ArticleCategoryController.php:12` (`use App\Models\Category;` is unused — moving the model cannot break it), tests (only Auth tests exist; none reference these classes), no policies/factories/providers/commands reference any moved class, `composer.json` PSR-4 `App\ → app/` already covers `Modules/` — no autoload change needed.

## Phase 6 — Execution Order

1. Move 14 models → `app/Modules/Content/Models/`; update namespaces
2. Move 8 requests + 1 resource + 1 mail → module; update namespaces (keep global `BaseFormRequest` import where used)
3. Move 14 controllers → `app/Modules/Content/Controllers/`; add `use App\Http\Controllers\Controller;`; re-point all imports to module classes
4. Update `routes/api.php` imports (14) and the 5 cross-module import sites + 13 seeders
5. Verify: `composer dump-autoload`, `php artisan optimize:clear`, `php artisan route:list`, `php artisan test`
6. Review `git diff` — expect only moves + namespace/import changes

## Uncertain / Conservative Calls

- `StoreCategoryRequest` / `UpdateCategoryRequest` — **stay global** (`App\Http\Requests`). Shared by 4 controllers across 4 modules; prior refactors explicitly kept them global.
- `SendNewsletterJob` (`app/Jobs`) + `NewsletterEmail` (`app/Mail`) — **left in place**. Both unreferenced dead code; `SendNewsletterJob` takes a `$subscriber` (possibly Member/Subscription domain). Conservative: do not move this run.
- `Category`/`SubCategory` in `Content` creates dependencies Organization/Coupon/Promotion → Content. User-confirmed placement; alternative (own `Category` module) rejected.

## Pre-existing Issues (report only — NOT to be fixed)

1. `app/Modules/Article/Controllers/ArticleCategoryController.php:12` — unused `use App\Models\Category;` import
2. `app/Http/Controllers/SlideController.php:13` — `use function PHPUnit\Framework\isEmpty;` odd/unused import
3. `app/Http/Controllers/SubCategoryController.php:258-266` — `show()` returns before the try/catch; catch block is dead code
4. `app/Http/Controllers/PrivacyPolicyController.php:38` — `errorResponse("Faild Error", ['message' => ...], 500)` stray first arg; typo "Faild"
5. `app/Http/Controllers/VariableDataController.php:94` — returns raw string `'File type not supported'` instead of an error response
6. `app/Http/Controllers/QuestionAnswerController.php` — inconsistent error handling; `update()` reuses `StoreQuestionAnswerRequest`
7. `app/Http/Controllers/TermsConditionController.php` — duplicated OA annotations for org/user term variants on one method
8. `NewsletterController::send()` sends synchronously in a loop; `SendNewsletterJob`/`NewsletterEmail` exist but are unused
9. `routes/api.php` — duplicate `POST /send-sms` route (public + protected); outside this domain, untouched