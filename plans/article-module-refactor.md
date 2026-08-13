# Plan — Article Module Refactor

**Status:** PLANNED — awaiting execution.
**Scope:** Structural refactor of the "articles" domain into `app/Modules/Article/` per AGENTS.md rules (move code, don't rewrite it; behavior must remain identical).

---

## Phase 1 — Inspection (DONE)

- [x] Identified all article-domain files in the actual tree (not the AGENTS.md example list)
- [x] `app/Models/Article.php` — already imports `App\Modules\User\Models\User` (partial module migration in progress); references `ArticleCategory`, `ArticleInteractions`, `ArticleComment` (same namespace) and `Tag` (global, implicit same-namespace ref — will need an explicit `use`)
- [x] `app/Models/ArticleCategory.php`, `ArticleComment.php`, `ArticleInteractions.php`, `ArticleTag.php`, `UserArticleInteraction.php` — article-domain models; `ArticleComment` + `UserArticleInteraction` import the already-migrated `App\Modules\User\Models\User`
- [x] Controllers (6): `ArticleController` (571 lines, 11 endpoints), `ArticleCategoryController`, `ArticleCommentController`, `ArticleInteractionsController`, `ArticleTagController` + `UserArticleInteractionController` (both empty CRUD scaffolds, **not registered in routes**)
- [x] Requests (3): `StoreArticleRequest`, `UpdateArticleRequest`, `StoreArticleComment` — all extend global `BaseFormRequest`
- [x] No article services, resources, DTOs, events, listeners, jobs, mail, policies, factories, or tests exist
- [x] No article model referenced from providers, config, middleware, traits, helpers, factories, or tests
- [x] OpenAPI article schemas (`ArticleSchema`, `ArticleCategorySchema`, `ArticleCommentSchema`, `ArticleStoreRequestSchema`) are pure string-based annotations — no PHP class imports — and per AGENTS.md §21 `OpenApi/` stays global
- [x] Composer PSR-4 `App\` → `app/` already covers `App\Modules\...` — no composer changes needed

## Phase 2 — Domain Mapping (DONE)

**Moves into `App\Modules\Article`:** 6 models, 6 controllers, 3 requests (15 files).

**Stays global (must NOT move):**
- `app/Http/Controllers/Controller.php`, `app/Http/Traits/ApiResponse.php`, `app/Http/Requests/BaseFormRequest.php`, `app/Http/Services/ImageService.php`, `app/Helpers/TextNormalizer.php` — shared infrastructure
- `app/Http/Requests/StoreCategoryRequest.php`, `UpdateCategoryRequest.php` — **shared** by `ArticleCategoryController`, `CategoryController`, `CardCategoryController`, `ServiceCategoryController`
- `app/Models/Tag.php` + `app/Http/Controllers/TagController.php` — referenced by `Article::tags()` (pivot `article_tags`) but belong to a broader Tag concept; Article module keeps only the `ArticleTag` pivot model
- `app/Models/Category.php` + `CategoryController.php` — separate domain
- `app/OpenApi/**` — includes `ArticleSchema`, `ArticleCategorySchema`, `ArticleCommentSchema`, `ArticleStoreRequestSchema`; controllers reference them only as string refs (`#/components/schemas/Article`), so keeping them global breaks nothing
- All migrations (table-based, no class refs); `database/seeders/ArticleCategorySeeder.php`, `CommentSeeder.php` (use `DB::table(...)`, no model imports — no change needed)
- Other-domain features not in scope: `Category`, `Tag`, `Service*`, `Card*`, `Organization*`, etc.

## Phase 3 — Target Structure

```
app/Modules/Article/
├── Controllers/
│   ├── ArticleController.php
│   ├── ArticleCategoryController.php
│   ├── ArticleCommentController.php
│   ├── ArticleInteractionsController.php
│   ├── ArticleTagController.php
│   └── UserArticleInteractionController.php
├── Models/
│   ├── Article.php
│   ├── ArticleCategory.php
│   ├── ArticleComment.php
│   ├── ArticleInteractions.php
│   ├── ArticleTag.php
│   └── UserArticleInteraction.php
└── Requests/
    ├── StoreArticleRequest.php
    ├── UpdateArticleRequest.php
    └── StoreArticleComment.php
```

## Phase 4 — Move Table (validation complete)

| # | Old path | New path | New namespace | References to update |
|---|---|---|---|---|
| 1 | `app/Models/Article.php` | `app/Modules/Article/Models/Article.php` | `App\Modules\Article\Models` | **add `use App\Models\Tag;`** (was same-namespace implicit; `Tag` stays global); `User` import unchanged (`App\Modules\User\Models\User`); `ArticleCategory`/`ArticleInteractions`/`ArticleComment` become same-namespace |
| 2 | `app/Models/ArticleCategory.php` | `app/Modules/Article/Models/ArticleCategory.php` | `App\Modules\Article\Models` | `Article` becomes same-namespace |
| 3 | `app/Models/ArticleComment.php` | `app/Modules/Article/Models/ArticleComment.php` | `App\Modules\Article\Models` | `Article` same-namespace; `User` import unchanged |
| 4 | `app/Models/ArticleInteractions.php` | `app/Modules/Article/Models/ArticleInteractions.php` | `App\Modules\Article\Models` | `Article` same-namespace |
| 5 | `app/Models/ArticleTag.php` | `app/Modules/Article/Models/ArticleTag.php` | `App\Modules\Article\Models` | `Article` same-namespace |
| 6 | `app/Models/UserArticleInteraction.php` | `app/Modules/Article/Models/UserArticleInteraction.php` | `App\Modules\Article\Models` | `Article` same-namespace; `User` import unchanged |
| 7 | `app/Http/Controllers/ArticleController.php` | `app/Modules/Article/Controllers/ArticleController.php` | `App\Modules\Article\Controllers` | add `use App\Http\Controllers\Controller;` (was same-namespace); model imports → module; request imports → module; `ImageService`/`ApiResponse`/`TextNormalizer`/OpenApi responses unchanged |
| 8 | `app/Http/Controllers/ArticleCategoryController.php` | `app/Modules/Article/Controllers/ArticleCategoryController.php` | `App\Modules\Article\Controllers` | add base `Controller` import; `ArticleCategory` → module; `StoreCategoryRequest`/`UpdateCategoryRequest` **stay** `App\Http\Requests\...` (shared) |
| 9 | `app/Http/Controllers/ArticleCommentController.php` | `app/Modules/Article/Controllers/ArticleCommentController.php` | `App\Modules\Article\Controllers` | add base `Controller` import; `ArticleComment` + `StoreArticleComment` → module |
| 10 | `app/Http/Controllers/ArticleInteractionsController.php` | `app/Modules/Article/Controllers/ArticleInteractionsController.php` | `App\Modules\Article\Controllers` | add base `Controller` import; both models → module |
| 11 | `app/Http/Controllers/ArticleTagController.php` | `app/Modules/Article/Controllers/ArticleTagController.php` | `App\Modules\Article\Controllers` | add base `Controller` import; `ArticleTag` → module |
| 12 | `app/Http/Controllers/UserArticleInteractionController.php` | `app/Modules/Article/Controllers/UserArticleInteractionController.php` | `App\Modules\Article\Controllers` | add base `Controller` import; `UserArticleInteraction` → module |
| 13 | `app/Http/Requests/StoreArticleRequest.php` | `app/Modules/Article/Requests/StoreArticleRequest.php` | `App\Modules\Article\Requests` | only `ArticleController:6`; `BaseFormRequest` import unchanged |
| 14 | `app/Http/Requests/UpdateArticleRequest.php` | `app/Modules/Article/Requests/UpdateArticleRequest.php` | `App\Modules\Article\Requests` | only `ArticleController:7`; `BaseFormRequest` import unchanged |
| 15 | `app/Http/Requests/StoreArticleComment.php` | `app/Modules/Article/Requests/StoreArticleComment.php` | `App\Modules\Article\Requests` | only `ArticleCommentController:6`; `BaseFormRequest` import unchanged |

### Phase 4b — Update-only files (no moves; import/reference changes)

- `routes/api.php:6-9` — 4 controller imports (`ArticleCategoryController`, `ArticleCommentController`, `ArticleController`, `ArticleInteractionsController`) → `App\Modules\Article\Controllers\...`. URLs/methods/names/middleware untouched.
- `database/seeders/ArticleSeeder.php:5-6` — `App\Models\Article`, `App\Models\ArticleTag` → module
- `database/seeders/ArticleInteractionSeeder.php:5` — `App\Models\ArticleInteractions` → module

**Config check (no change needed):** `config/l5-swagger.php` already scans `app_path('Modules')` (added during the Auth refactor) — moved controllers/attributes remain in the OpenAPI document. Composer PSR-4 already covers `app/Modules/`.

## Phase 5 — Execution (PENDING — run with build agent)

- [ ] Move 15 files (Phase 4 table)
- [ ] Update namespaces + imports in moved files (incl. new `use App\Http\Controllers\Controller;` in all 6 controllers, new `use App\Models\Tag;` in `Article`, keep `use App\Http\Requests\BaseFormRequest;` in requests)
- [ ] Update `routes/api.php` imports (lines 6–9) — URLs/methods/names/middleware untouched
- [ ] Update the 2 seeders (Phase 4b)
- [ ] `grep` for remaining `App\Models\Article*` / old request-namespace references — zero matches expected
- [ ] `composer dump-autoload`
- [ ] `php artisan optimize:clear`
- [ ] `php artisan route:list` — confirm all `/articles*`, `/article-categories*`, `/article-comments*`, `/add-comment`, `/update-comment/{id}`, `/like-comment/{id}`, `/unlike-comment/{id}`, interaction routes intact
- [ ] `php artisan test`
- [ ] `git diff` / `git status` — moves + namespace/import changes only

## Phase 6 — Flagged / Uncertain

- `StoreCategoryRequest` / `UpdateCategoryRequest` — shared with `CategoryController`, `CardCategoryController`, `ServiceCategoryController`; stays global; `ArticleCategoryController` keeps importing from `App\Http\Requests`
- `Tag` model + `TagController` + `TagSchema` — referenced by `Article::tags()` but a broader Tag concept; stays global. Revisit when the Tag domain is planned.
- `Category` model + `CategoryController` — separate domain; stays global
- OpenAPI article schemas — kept global per AGENTS.md §21 (OpenApi = global infra); string refs keep working from any location under `app/`
- `ArticleTagController` / `UserArticleInteractionController` — empty CRUD scaffolds, unrouted dead code; moved per AGENTS.md §10 example. Safe to move (no route/binding references); alternatively could be deleted (deletion out of scope — report only)

## Phase 7 — Pre-existing Issues (report only, NOT fixed)

- [x] `ArticleComment` uses `HasFactory` but no `ArticleCommentFactory` exists anywhere and no `::factory()` call sites — latent breakage if ever used
- [x] `ArticleCategoryController.php:11` — unused import `use App\Models\Category;`
- [x] `ArticleInteractionsController::updateInteraction()` returns 404 with the message "لقد قمت بالتفاعل مع هذا المقال مره بالفعل ." ("you have already interacted") when the interaction is **not found** — inverted/misleading message
- [x] `ArticleTagController` / `UserArticleInteractionController` — unrouted dead scaffolds
- [x] `ArticleController::getArticlesBySearch()` duplicates search logic from `getPublishedArticlesBySearch()` — duplication noted, behavior preserved

---

**Plan only — no files were changed. If this looks correct, run `/laravel-refactor-apply @app/Models/Article.php` to execute it with the build agent.**
