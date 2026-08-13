# AGENTS.md

# Laravel 12 Backend — Structural Refactoring Only

## CRITICAL WARNING

> **DO NOT CHANGE APPLICATION CODE, BUSINESS LOGIC, OR BEHAVIOR.**
>
> This task is **ONLY a structural refactoring / code organization task**.
>
> The existing application behavior must remain exactly the same.
>
> **Do not fix bugs.**
>
> **Do not improve business logic.**
>
> **Do not optimize queries.**
>
> **Do not change validation rules.**
>
> **Do not change API responses.**
>
> **Do not change database behavior.**
>
> **Do not change authentication or authorization.**
>
> **Do not change route behavior.**
>
> **Do not change business rules.**
>
> **Do not rewrite existing implementations.**
>
> **Do not introduce new functionality.**
>
> **Do not remove functionality.**
>
> The only purpose of this task is to reorganize the existing code into a cleaner, domain/feature-oriented structure.

---

# 1. Project

This is a **Laravel 12** backend application.

The current application is functional but has become difficult to navigate because domain-specific code is distributed across global technical directories.

The current structure is primarily organized by technical responsibility:

```text
app/
├── Console/
├── DTOs/
├── Events/
├── Helpers/
├── Http/
├── Jobs/
├── Listeners/
├── Mail/
├── Models/
├── OpenApi/
└── Providers/
```

The goal is to reorganize the application into a **domain/feature-oriented structure**.

---

# 2. Current HTTP Structure

The current `app/Http` structure is:

```text
app/Http/
├── Controllers/
├── Middleware/
├── Requests/
├── Resources/
├── Services/
└── Traits/
```

The current controllers are heavily concentrated inside:

```text
app/Http/Controllers/
```

The project contains many controllers belonging to different business domains, including:

```text
AboutController.php
AppointmentController.php
ArticleCategoryController.php
ArticleCommentController.php
ArticleController.php
ArticleInteractionsController.php
ArticleTagController.php
AuthController.php
CardCategoryController.php
CardController.php
CategoryController.php
ContactMessageController.php
ConversationBlockController.php
ConversationController.php
CouponController.php
CouponUsageController.php
CurrencyController.php
DashboardMainPageController.php
FamilyMemberController.php
FooterLinkController.php
HomePageController.php
InvoiceController.php
KeywordController.php
MemberController.php
MessageController.php
NewsletterController.php
NotificationController.php
OfferController.php
OrganizationController.php
OrganizationPrivacyPolicyController.php
OrganizationReviewController.php
OrganizationSubCategoryController.php
OrganizationTermsConditionController.php
OwnedCardController.php
PaymentController.php
PendingServiceOrderFileController.php
PrivacyPolicyController.php
PromoterController.php
PromoterRatioController.php
PromoterTrackingController.php
PromotionActivityController.php
QuestionAnswerController.php
ReferralController.php
ReviewLikesCheckController.php
ServiceCategoryController.php
ServiceFormController.php
ServiceFormFieldController.php
ServiceFormSubmissionController.php
ServiceOrderController.php
ServicePageContactMessageController.php
ServicePageController.php
ServiceTrackingController.php
ServiceTrackingFileController.php
SlideController.php
SMSController.php
SocialAccountController.php
SubCategoryController.php
TagController.php
TempUploadController.php
TermsConditionController.php
TodoController.php
TransactionController.php
UserArticleInteractionController.php
UserController.php
VariableDataController.php
WalletController.php
WebsiteVideoController.php
WithdrawRequestController.php
```

This list is only a representation of the current codebase.

The agent MUST inspect the actual repository before deciding final module boundaries.

---

# 3. Target Architecture

The desired architecture is **domain/feature-oriented organization**.

The preferred high-level structure is:

```text
app/
├── Modules/
│   ├── Auth/
│   ├── User/
│   ├── Article/
│   ├── Organization/
│   ├── Service/
│   ├── Card/
│   ├── Payment/
│   ├── Wallet/
│   ├── Coupon/
│   ├── Promotion/
│   ├── Conversation/
│   ├── Notification/
│   └── ...
│
├── Console/
├── Helpers/
├── Http/
│   └── Middleware/
├── OpenApi/
└── Providers/
```

These module names are **examples**, not a fixed list.

The agent must inspect the existing project and determine the correct domain boundaries.

---

# 4. Core Architectural Rule

The project should be organized by **business domain**, not by technical type.

## Bad

```text
app/
├── Models/
├── DTOs/
├── Services/
├── Controllers/
├── Requests/
└── Resources/
```

where all unrelated features are mixed together.

## Desired

```text
app/
└── Modules/
    ├── Article/
    │   ├── Controllers/
    │   ├── Models/
    │   ├── Requests/
    │   ├── Resources/
    │   ├── Services/
    │   └── DTOs/
    │
    ├── Organization/
    │   ├── Controllers/
    │   ├── Models/
    │   ├── Requests/
    │   ├── Resources/
    │   └── Services/
    │
    └── User/
        ├── Controllers/
        ├── Models/
        ├── Requests/
        ├── Resources/
        └── Services/
```

The goal is:

> Find the domain first, then find everything belonging to that domain.

---

# 5. Important: This Is NOT a Rewrite

Moving a class from:

```text
app/Http/Controllers/ArticleController.php
```

to:

```text
app/Modules/Article/Controllers/ArticleController.php
```

is acceptable.

Changing the implementation of `ArticleController` is NOT the goal.

For example, this is a structural change:

```text
Old:
App\Http\Controllers\ArticleController

New:
App\Modules\Article\Controllers\ArticleController
```

The implementation should otherwise remain unchanged unless a namespace/import must be updated because of the move.

---

# 6. Absolute Refactoring Rules

The agent MUST follow these rules.

## Allowed

- Move files.
- Create domain directories.
- Update namespaces when required by file movement.
- Update `use` statements when required.
- Update route imports/references when required.
- Update references caused by namespace changes.
- Update Composer autoload configuration only if absolutely necessary.
- Run `composer dump-autoload`.
- Run tests.
- Run Laravel route checks.
- Preserve existing behavior.

## Forbidden

- Rewrite business logic.
- Refactor algorithms.
- Change database queries.
- Optimize Eloquent queries.
- Change relationships.
- Change model behavior.
- Change validation rules.
- Change request authorization logic.
- Change API response formats.
- Change Resource serialization.
- Change authentication logic.
- Change authorization logic.
- Change middleware behavior.
- Change policies.
- Change events behavior.
- Change jobs behavior.
- Change listeners behavior.
- Change mail behavior.
- Change queue behavior.
- Change transactions.
- Change exception handling behavior.
- Change route URLs.
- Change HTTP methods.
- Change route names.
- Change route middleware.
- Change database schema.
- Change migrations.
- Add features.
- Remove features.
- Replace packages.
- Upgrade packages.
- Downgrade packages.
- Introduce a modular architecture package.
- Introduce repositories without an existing need.
- Introduce interfaces without an existing need.
- Introduce CQRS.
- Introduce Event Sourcing.
- Introduce Hexagonal Architecture layers.
- Introduce generic base classes.
- Introduce generic base services.
- Introduce generic base repositories.
- Perform unrelated cleanup.

---

# 7. Bug Fixing Is Out of Scope

If the agent discovers an existing bug:

**DO NOT FIX IT.**

Instead, report it separately.

Example:

```text
Found existing issue:
ArticleController::foo() appears to have an unrelated validation problem.

No change was made because bug fixing is outside the scope of this refactor.
```

The agent must not use the refactor as an excuse to modify unrelated code.

---

# 8. Code Cleanup Is Out of Scope

Do not perform opportunistic cleanup.

If the agent sees code that could be simplified, do not simplify it.

If an existing method is large, do not split it.

If an existing controller is large, do not rewrite it.

If a service has many responsibilities, do not redesign it.

Move and organize first.

Any future code-quality refactoring must be treated as a separate task.

---

# 9. Domain Discovery

Before moving anything, inspect the existing project.

The agent should inspect:

```text
app/Models/
app/Http/Controllers/
app/Http/Requests/
app/Http/Resources/
app/Http/Services/
app/DTOs/
app/Events/
app/Listeners/
app/Jobs/
app/Mail/
routes/
tests/
database/
composer.json
```

Also inspect:

- model relationships
- controller dependencies
- service dependencies
- route references
- event/listener relationships
- job references
- policy references
- OpenAPI references
- tests
- factories
- service provider bindings

The purpose is to determine which classes belong together.

---

# 10. Domain Grouping

The agent must group related classes into cohesive modules.

For example, the following controllers are likely part of the `Article` domain:

```text
ArticleController
ArticleCategoryController
ArticleCommentController
ArticleInteractionsController
ArticleTagController
UserArticleInteractionController
```

Potential structure:

```text
app/
└── Modules/
    └── Article/
        ├── Controllers/
        │   ├── ArticleController.php
        │   ├── ArticleCategoryController.php
        │   ├── ArticleCommentController.php
        │   ├── ArticleInteractionsController.php
        │   ├── ArticleTagController.php
        │   └── UserArticleInteractionController.php
        │
        ├── Models/
        ├── Requests/
        ├── Resources/
        ├── Services/
        ├── DTOs/
        ├── Events/
        ├── Listeners/
        └── Jobs/
```

Only create directories that are actually needed.

---

# 11. Organization Example

These controllers likely belong to the same domain:

```text
OrganizationController
OrganizationPrivacyPolicyController
OrganizationReviewController
OrganizationSubCategoryController
OrganizationTermsConditionController
```

Potential structure:

```text
app/
└── Modules/
    └── Organization/
        ├── Controllers/
        ├── Models/
        ├── Requests/
        ├── Resources/
        ├── Services/
        └── DTOs/
```

The exact contents must be determined by inspecting the repository.

---

# 12. Service Domain Example

The following controllers may represent one larger service-related domain:

```text
ServiceCategoryController
ServiceFormController
ServiceFormFieldController
ServiceFormSubmissionController
ServiceOrderController
ServicePageController
ServicePageContactMessageController
ServiceTrackingController
ServiceTrackingFileController
```

Potential structure:

```text
app/
└── Modules/
    └── Service/
        ├── Controllers/
        ├── Models/
        ├── Requests/
        ├── Resources/
        ├── Services/
        └── DTOs/
```

However, do not assume this is correct without inspecting relationships and dependencies.

---

# 13. Module Structure

A typical module may look like:

```text
app/
└── Modules/
    └── Article/
        ├── Controllers/
        │   ├── ArticleController.php
        │   ├── ArticleCommentController.php
        │   └── ArticleCategoryController.php
        │
        ├── Models/
        │   ├── Article.php
        │   ├── ArticleComment.php
        │   └── ArticleCategory.php
        │
        ├── Requests/
        │   ├── StoreArticleRequest.php
        │   └── UpdateArticleRequest.php
        │
        ├── Resources/
        │   ├── ArticleResource.php
        │   └── ArticleCommentResource.php
        │
        ├── Services/
        │   └── ArticleService.php
        │
        ├── DTOs/
        │   └── ...
        │
        ├── Events/
        │   └── ...
        │
        ├── Listeners/
        │   └── ...
        │
        └── Jobs/
            └── ...
```

Do NOT create empty directories unnecessarily.

---

# 14. Models

Domain-specific models should be moved into their corresponding modules.

Example:

```text
app/Models/Article.php
```

becomes:

```text
app/Modules/Article/Models/Article.php
```

with the namespace changed accordingly.

For example:

```php
namespace App\Modules\Article\Models;
```

All references must then be updated.

The actual model implementation must remain unchanged.

Do not modify:

- relationships
- casts
- scopes
- accessors
- mutators
- events
- boot methods
- attributes
- query logic

unless a namespace change itself requires an import update.

---

# 15. Controllers

Controllers should be moved into their owning module.

Example:

```text
app/Http/Controllers/ArticleController.php
```

becomes:

```text
app/Modules/Article/Controllers/ArticleController.php
```

The controller's implementation must remain unchanged.

Only structural changes are allowed:

- namespace
- imports
- references required by the move

Do not use this task to make controllers "better".

---

# 16. Requests

Feature-specific Form Requests should move with their domain.

Example:

```text
app/Http/Requests/StoreArticleRequest.php
```

may become:

```text
app/Modules/Article/Requests/StoreArticleRequest.php
```

Do not change:

- validation rules
- validation messages
- authorization logic
- preparation logic
- validation hooks

Only update namespaces/imports as necessary.

---

# 17. Resources

Feature-specific API Resources should live inside the relevant module.

Example:

```text
app/Http/Resources/ArticleResource.php
```

becomes:

```text
app/Modules/Article/Resources/ArticleResource.php
```

Do not change the JSON response structure.

Do not rename response properties.

Do not change conditional fields.

Do not change relationships included in the Resource.

Only change namespace/imports when necessary.

---

# 18. DTOs

Domain-specific DTOs should move into their corresponding module.

Example:

```text
app/DTOs/CreateArticleDTO.php
```

becomes:

```text
app/Modules/Article/DTOs/CreateArticleDTO.php
```

Do not change DTO behavior.

Do not change constructor signatures unless absolutely required by namespace movement.

---

# 19. Services

Existing services should be moved according to their domain ownership.

Example:

```text
app/Http/Services/ArticleService.php
```

becomes:

```text
app/Modules/Article/Services/ArticleService.php
```

Do not rewrite the service.

Do not split one service into multiple services.

Do not merge services.

Do not optimize service code.

Do not change service behavior.

The service is being relocated, not redesigned.

---

# 20. Events, Listeners, Jobs, and Mail

Domain-specific classes should be moved into the owning module where appropriate.

For example:

```text
app/Events/ArticlePublished.php
```

may become:

```text
app/Modules/Article/Events/ArticlePublished.php
```

Likewise:

```text
app/Listeners/...
app/Jobs/...
app/Mail/...
```

may be moved if clearly owned by a domain.

However, global infrastructure may remain global.

Do not move something simply because it can technically fit into a module.

Determine ownership first.

---

# 21. Shared Infrastructure

Some application infrastructure should remain outside modules.

For example:

```text
app/
├── Console/
├── Helpers/
├── Http/
│   └── Middleware/
├── OpenApi/
└── Providers/
```

These should not be moved unless there is a clear architectural reason.

The goal is not to force every file under `Modules/`.

---

# 22. Traits

Do not blindly move traits.

Determine whether a trait is:

- domain-specific
- shared between several modules
- infrastructure-related

Domain-specific traits may live inside their module.

Truly shared traits may remain globally available.

Do not duplicate traits.

---

# 23. Routes

Routes are sensitive.

Do not change API URLs.

Do not change:

- HTTP methods
- route names
- middleware
- prefixes
- parameters
- controller actions

If controllers move namespaces, update route references accordingly.

For example:

```php
use App\Http\Controllers\ArticleController;
```

may become:

```php
use App\Modules\Article\Controllers\ArticleController;
```

The route itself must remain behaviorally identical.

Splitting routes into domain-specific route files is allowed only if it does not change behavior and is useful for organization.

---

# 24. Namespace Changes

Moving files into modules will usually require namespace changes.

Example:

```php
namespace App\Http\Controllers;
```

becomes:

```php
namespace App\Modules\Article\Controllers;
```

This is an expected structural change.

All references to the old namespace must be updated.

Do not change class names unless absolutely required.

---

# 25. Composer

The project uses Composer and Laravel's standard PSR-4 autoloading.

After structural changes, run:

```bash
composer dump-autoload
```

If the chosen `app/Modules` structure requires an explicit Composer PSR-4 mapping, inspect the existing `composer.json` first.

Do not unnecessarily change Composer configuration.

Do not add packages.

Do not upgrade dependencies.

Do not remove dependencies.

---

# 26. Laravel 12

This project uses:

```text
Laravel 12
```

Use Laravel 12-compatible conventions.

Do not introduce architecture based on outdated Laravel versions.

Do not install a modularity package unless explicitly requested.

The module structure should be implemented using the project's existing Laravel/PHP capabilities.

---

# 27. No Third-Party Architecture Package

Do NOT install packages just to achieve this module structure.

The goal is a clean project structure using normal Laravel conventions.

---

# 28. No Overengineering

Do not introduce:

```text
Repositories
Interfaces
Factories
Abstract Services
Base Controllers
Base Repositories
Generic Managers
CQRS
Commands
Handlers
Event Sourcing
Aggregates
Ports
Adapters
```

unless they already exist or are strictly required by the existing code.

This refactor is about **organization**, not architectural reinvention.

---

# 29. Preserve Dependencies

Before moving any class, inspect its references.

Check:

```text
use statements
constructor dependencies
dependency injection
route references
service provider bindings
container bindings
events
listeners
jobs
policies
factories
tests
OpenAPI definitions
model relationships
casts
commands
notifications
mail
```

Do not assume a class is only referenced by the controller that appears related to it.

---

# 30. Tests

Tests must remain unchanged unless a namespace/reference must be updated because of a moved class.

Do not rewrite tests.

Do not remove tests.

Do not weaken tests.

Do not skip tests to make the refactor pass.

If tests reference moved namespaces, update the references only.

---

# 31. Verification

After each meaningful module migration, run:

```bash
php artisan optimize:clear
composer dump-autoload
php artisan route:list
php artisan test
```

If the project has additional test commands, use the existing project commands as well.

The purpose is to verify that structural changes did not alter behavior.

---

# 32. Incremental Migration

Do NOT move the entire application blindly in one operation.

Use incremental migration.

Recommended process:

```text
1. Inspect
2. Map domains
3. Select one module
4. Move its files
5. Update namespaces/imports
6. Verify
7. Run tests
8. Review diff
9. Continue with the next module
```

---

# 33. First Step — DO NOT MODIFY CODE

Before making any changes, inspect the repository.

The first task is analysis only.

Inspect:

```text
app/
app/Models/
app/Http/Controllers/
app/Http/Requests/
app/Http/Resources/
app/Http/Services/
app/DTOs/
app/Events/
app/Listeners/
app/Jobs/
app/Mail/
routes/
tests/
database/
composer.json
```

Then produce a proposed domain map.

Example:

```text
Article
├── Controllers
│   ├── ArticleController
│   ├── ArticleCategoryController
│   ├── ArticleCommentController
│   └── ...
├── Models
│   ├── Article
│   ├── ArticleCategory
│   └── ...
├── Requests
├── Resources
├── Services
└── DTOs
```

Do not start moving files until the domain boundaries are understood.

---

# 34. Domain Mapping Requirements

The domain map should explain:

```text
Module
├── Controllers
├── Models
├── Requests
├── Resources
├── Services
├── DTOs
├── Events
├── Listeners
├── Jobs
└── Other domain-specific classes
```

Only include directories that actually contain relevant files.

---

# 35. Example Domain Map

A possible result might be:

```text
Modules/
├── Auth/
├── User/
├── Article/
├── Organization/
├── Service/
├── Card/
├── Payment/
├── Wallet/
├── Coupon/
├── Promotion/
├── Conversation/
├── Notification/
└── Content/
```

Again:

> This is an example, not a predetermined architecture.

The actual repository determines the final module boundaries.

---

# 36. Handling Ambiguous Classes

If a class could reasonably belong to multiple modules:

Do not guess silently.

Inspect:

- imports
- dependencies
- model relationships
- routes
- business purpose
- tests

If it is still ambiguous, report the ambiguity and recommend the most conservative location.

Do not duplicate the class across modules.

---

# 37. Global vs Module-Specific

A class should be moved into a module when:

```text
it clearly belongs to one business domain
```

A class should remain global when:

```text
it is shared infrastructure
```

Examples of likely global infrastructure:

```text
Middleware
Providers
Helpers
Console commands
Global framework integrations
Shared infrastructure
```

Examples of likely module-specific code:

```text
ArticleController
Article
ArticleResource
ArticleService
StoreArticleRequest
ArticlePublished
```

---

# 38. File Movement Rules

When moving a file:

1. Move the file.
2. Update its namespace.
3. Search for references to its old namespace.
4. Update imports.
5. Update route references if applicable.
6. Update bindings if applicable.
7. Update tests if necessary.
8. Run autoload.
9. Run tests.

Do not modify unrelated code.

---

# 39. Namespace Migration Example

Before:

```php
namespace App\Http\Controllers;

use App\Models\Article;
use App\Http\Requests\StoreArticleRequest;
```

After:

```php
namespace App\Modules\Article\Controllers;

use App\Modules\Article\Models\Article;
use App\Modules\Article\Requests\StoreArticleRequest;
```

Only namespace/import changes should be made as part of this example.

The controller body should remain the same.

---

# 40. Important: Do Not Rename Business Concepts

Do not rename:

```text
Article
Organization
Service
Payment
User
Wallet
```

or any existing domain classes simply because another name seems cleaner.

Do not rename database tables.

Do not rename database columns.

Do not rename API fields.

Do not rename route names.

Do not rename endpoints.

The purpose is structural organization only.

---

# 41. Important: Do Not Change APIs

The API contract must remain identical.

Preserve:

```text
URLs
HTTP methods
request fields
validation
response fields
status codes
pagination
authentication
authorization
error responses
headers
middleware
```

If moving a controller requires updating its namespace, that is acceptable.

Changing its behavior is not.

---

# 42. Important: Do Not Change Database

This task does not require database changes.

Do not modify:

```text
migrations
tables
columns
indexes
foreign keys
constraints
seeders
factories
database relationships
```

unless a namespace/reference change is strictly required for application code.

---

# 43. Important: Do Not Change Business Logic

This is the most important requirement.

If existing code contains complex business logic, do not extract it into services as part of this task.

If a controller has many methods:

do not redesign it.

If a service has many responsibilities:

do not redesign it.

If a model has many relationships:

do not modify them.

Move and organize first.

Any future code-quality refactoring should be a separate task.

---

# 44. No Opportunistic Improvements

Do not combine this task with:

```text
bug fixes
performance optimization
security refactoring
database optimization
API redesign
validation improvements
naming cleanup
formatting cleanup
dead-code removal
dependency upgrades
framework upgrades
test rewrites
```

These are separate tasks.

---

# 45. Formatting

Do not reformat entire files unnecessarily.

If a file must be changed only because its namespace moved, make the smallest possible change.

Avoid huge diffs caused by:

- formatting
- indentation
- import sorting
- line wrapping
- comment changes

Minimal diffs are preferred.

---

# 46. Git Diff Discipline

After moving a file, inspect:

```bash
git diff
git status
```

The expected diff should primarily show:

- file moves
- namespace changes
- import changes
- reference changes

Unexpected business-logic changes must be reverted.

---

# 47. Definition of a Successful Refactor

The refactor is successful when:

```text
The application behaves exactly as before
```

and:

```text
Related domain code is located together
```

and:

```text
Developers can find a feature without searching the entire app directory
```

and:

```text
Namespaces correctly represent the new structure
```

and:

```text
Laravel boots successfully
```

and:

```text
Routes work
```

and:

```text
Tests pass
```

and:

```text
No business logic was changed
```

---

# 48. Final Target

The final structure should conceptually resemble:

```text
app/
├── Modules/
│   ├── Auth/
│   │   ├── Controllers/
│   │   ├── Requests/
│   │   ├── Services/
│   │   └── ...
│   │
│   ├── User/
│   │   ├── Controllers/
│   │   ├── Models/
│   │   ├── Requests/
│   │   ├── Resources/
│   │   ├── Services/
│   │   └── ...
│   │
│   ├── Article/
│   │   ├── Controllers/
│   │   ├── Models/
│   │   ├── Requests/
│   │   ├── Resources/
│   │   ├── Services/
│   │   ├── DTOs/
│   │   └── ...
│   │
│   ├── Organization/
│   ├── Service/
│   ├── Card/
│   ├── Payment/
│   ├── Wallet/
│   ├── Coupon/
│   ├── Promotion/
│   ├── Conversation/
│   └── ...
│
├── Console/
├── Helpers/
├── Http/
│   └── Middleware/
├── OpenApi/
└── Providers/
```

This is a conceptual target, not a requirement to create every directory.

---

# 49. Agent Workflow

The agent MUST follow this workflow:

## Step 1 — Inspect

Understand the current application.

## Step 2 — Map

Identify domains and dependencies.

## Step 3 — Propose

Create a module map.

## Step 4 — Validate

Check that moving each class will not break references.

## Step 5 — Refactor Structure

Move files and update namespaces/imports only.

## Step 6 — Verify

Run:

```bash
composer dump-autoload
php artisan optimize:clear
php artisan route:list
php artisan test
```

## Step 7 — Review Diff

Use:

```bash
git diff
git status
```

Ensure no business logic changed.

## Step 8 — Continue

Move the next domain.

---

# 50. Final Safety Rule

When uncertain whether a change is:

```text
structural
```

or:

```text
behavioral
```

choose the conservative option:

> **DO NOT CHANGE IT.**

Report the issue instead.

The agent must always prefer:

```text
minimal structural change
```

over:

```text
"improved" implementation
```

---

# FINAL INSTRUCTION

**This task is a refactoring of the filesystem/project architecture only.**

The existing Laravel application is the source of truth.

The agent's responsibility is to reorganize the existing code into clean, domain-oriented modules while preserving the code's behavior.

### The agent must remember:

> **MOVE CODE, DON'T REWRITE CODE.**

> **REORGANIZE, DON'T OPTIMIZE.**

> **CHANGE NAMESPACES/IMPORTS ONLY WHEN REQUIRED BY THE MOVE.**

> **PRESERVE ALL EXISTING LOGIC AND BEHAVIOR.**

> **WHEN IN DOUBT, DO NOT CHANGE THE CODE.**
