# Plan — Member Module Refactor

**Status:** PLANNED — awaiting execution.
**Scope:** Structural refactor of the "member" (newsletter subscriber) domain into `app/Modules/Member/` per AGENTS.md rules (move code, don't rewrite it; behavior must remain identical).

---

## Phase 1 — Inspection (DONE)

- [x] `app/Models/Member.php` — trivial model (10 lines), `$fillable = ['email']`, `members` table by convention, no relationships
- [x] `app/Http/Controllers/MemberController.php` — 4 endpoints (`index`, `getMembersEmails`, `subscribe`, `unsubscribe`), all operations on `Member`
- [x] `database/seeders/MemberSeeder.php` — seeds 50 fake emails, imports `App\Models\Member`
- [x] `app/OpenApi/Schemas/MemberSchema.php` — OpenAPI schema `'Member'`; referenced only as string (`PaginatedOkResponse('Member')`), zero imports of the class anywhere
- [x] `routes/api.php` — import at line 22; routes at 413 (`POST /subscribe`, public), 1161–1165 (`GET /members`, `GET /get-members-emails`, `DELETE /unsubscribe/{id}`, admin group)
- [x] Migration `2025_03_20_075151_create_members_table.php` — untouched (AGENTS.md §42)
- [x] No requests, resources, services, DTOs, events, listeners, jobs, mail, policies, factories, or tests exist for Member
- [x] `FamilyMember`'s `member` relationship points at `User`, not this model — unaffected
- [x] Grep across all PHP: only `MemberController`, `MemberSeeder`, and `Member.php` itself reference `App\Models\Member`

## Phase 2 — Domain Mapping (DONE)

**Moves into `App\Modules\Member`:** `Member` model, `MemberController`.

**Stays global (must NOT move):**
- `app/OpenApi/Schemas/MemberSchema.php` — OpenApi is shared infrastructure (AGENTS.md §21); string refs work from any location under `app/`
- `database/seeders/MemberSeeder.php` — seeder stays in `Database\Seeders`; import update only
- `database/migrations/2025_03_20_075151_create_members_table.php` — database, untouched
- `routes/api.php` — import update only
- `NewsletterController` / `Newsletter` model / `NewsletterSchema` — distinct entity (newsletter content), same `Newsletters` OpenAPI tag but different table/model/controller; NOT in this module

## Phase 3 — Target Structure

```
app/Modules/Member/
├── Controllers/
│   └── MemberController.php
└── Models/
    └── Member.php
```

Only the two directories that contain files. (Module convention mirrors existing `App\Modules\FamilyMember\...`.)

## Phase 4 — Move Table (validation complete)

| # | Old path | New path | New namespace | References to update |
|---|---|---|---|---|
| 1 | `app/Models/Member.php` | `app/Modules/Member/Models/Member.php` | `App\Models` → `App\Modules\Member\Models` | `use App\Models\Member` in `MemberController.php:6` and `MemberSeeder.php:6` |
| 2 | `app/Http/Controllers/MemberController.php` | `app/Modules/Member/Controllers/MemberController.php` | `App\Http\Controllers` → `App\Modules\Member\Controllers` | `routes/api.php:22` import (`use App\Modules\Member\Controllers\MemberController;`); add `use App\Http\Controllers\Controller;` (was same-namespace); re-point model import to module |

**Update-only (no moves):**
- `database/seeders/MemberSeeder.php:6` — `use App\Models\Member;` → `use App\Modules\Member\Models\Member;` (`DatabaseSeeder.php:35` uses `MemberSeeder::class` — unchanged)
- `routes/api.php:22` — one import line; URLs/methods/names/middleware at 413, 1161–1165 untouched

**No change needed:**
- Composer PSR-4 `App\` → `app/` already covers `App\Modules\Member\...` — no composer.json edit
- `MemberSchema` — zero class imports; `PaginatedOkResponse('Member')` is a string schema ref
- `config/l5-swagger.php` already scans `app_path('Modules')` (added during the Auth refactor) — moved controller's OA attributes remain in the OpenAPI document

## Phase 5 — Execution (PENDING — run with build agent)

- [ ] Move 2 files (Phase 4 table)
- [ ] Update namespaces + imports in moved files (incl. new `use App\Http\Controllers\Controller;` in `MemberController`)
- [ ] Update `routes/api.php` import (line 22)
- [ ] Update `MemberSeeder` import (line 6)
- [ ] `grep` for remaining `App\Models\Member` / `App\Http\Controllers\MemberController` references — zero matches expected
- [ ] `composer dump-autoload`
- [ ] `php artisan optimize:clear`
- [ ] `php artisan route:list` — confirm `/members`, `/get-members-emails`, `/subscribe`, `/unsubscribe/{id}` intact
- [ ] `php artisan test`
- [ ] `git diff` / `git status` — moves + namespace/import changes only

## Phase 6 — Flagged / Uncertain

- **Module name `Member` vs `Newsletter`:** OpenAPI tag is `Newsletters`, but the entity is `Member` and renaming business concepts is forbidden (AGENTS.md §40) — module is `Member`. If a `Newsletter` module is preferred later, `Member` stays separate (distinct entity/table).
- **OpenAPI schema placement:** `MemberSchema` kept global per AGENTS.md §21, consistent with `NewsletterSchema` and all other schemas.
- `Newsletter` entity/controller/mail — related tag, separate feature; NOT included in this module.

## Phase 7 — Pre-existing Issues (report only, NOT fixed)

- [x] `MemberController::index()` and `unsubscribe()` run `$request->validate()` / `findOrFail` inside `try/catch (\Exception)` — a `ValidationException` / `ModelNotFoundException` is caught and returned as a **500** instead of 422 / 404
- [x] `MemberController::subscribe()` returns a raw `response()->json(...)` while sibling methods use `$this->successResponse(...)` — inconsistent response style
- [x] `MemberSeeder` uses `Faker\Factory::create()` directly (project already ships `fakerphp/faker`)
- [x] `Member` model itself has no issues (trivial, 10 lines)

---

**Plan only — no files were changed. If this looks correct, run `/laravel-refactor-apply @app/Models/Member.php` to execute it with the build agent.**
