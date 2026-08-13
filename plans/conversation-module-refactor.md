# Plan — Conversation / Messaging Module Refactor

**Status:** PLANNED — awaiting execution.
**Scope:** Structural refactor of the conversation/messaging domain (ConversationController, ConversationBlockController, MessageController, NotificationController, SMSController, SocialAccountController + clearly-owned support classes) into `app/Modules/Conversation/` per AGENTS.md rules (move code, don't rewrite it; behavior must remain identical). The Conversation module already exists with its services moved (`app/Modules/Conversation/Services/`).

---

## Phase 1 — Inspection (DONE)

- [x] `app/Http/Controllers/ConversationController.php` — 7 endpoints (`POST /start-conversation`, `GET /conversation/show`, `POST /active-conversation`, `POST /clear-active-conversation`, `GET /user/{id}/conversations`, `POST /conversations/{conversationId}/block`, `DELETE /conversations/{conversationId}/unblock`), OA tag `Conversations`, deps: `ConversationService` (module), 4 requests in `app/Http/Requests/Conversation/`, `ApiResponse`; routes at `routes/api.php:655-661`, import at `:15`
- [x] `app/Http/Controllers/MessageController.php` — 3 endpoints (`POST /send-message`, `DELETE /messages/{messageId}`, `POST /conversation/mark-as-read`), OA tag `Messages`, deps: `ChatService` (module), `ImageService` (global), `StoreMessageRequest`, `Conversation`, `Message`, `ApiResponse`; routes at `routes/api.php:671-674`, import at `:23`
- [x] `app/Http/Controllers/NotificationController.php` — 5 endpoints (`POST /send-notification`, `POST /send-multiple-notification`, `GET /notifications/{id}/{type}`, `POST /make-notifications-readed/{id}`, `GET /last-ten-notifications/{id}/{type}`), OA tag `Notifications`, deps: `NotificationService` (global), `SendNotificationRequest`, `Notification`, `User`, `Organization`, `ApiResponse`; routes at `routes/api.php:598-602` and `:839`, import at `:24`
- [x] `app/Http/Controllers/SMSController.php` — 1 endpoint (`POST /send-sms`, also served at `/internal/send-sms`), OA tag `SMS`, self-contained (inline gateway payload, no model/service deps); routes at `routes/api.php:234,416,543`, import at `:44`
- [x] `app/Http/Controllers/SocialAccountController.php` — 3 endpoints (`GET /social-contact-info`, `GET /get-whatsapp-number`, `POST /update-social-contact-info`), OA tag `Settings`, deps: `UpdateSocialAccountsRequest`, `SocialAccount`, `ApiResponse`; routes at `routes/api.php:128-130` and `:1150`, import at `:29`
- [x] `app/Http/Controllers/ConversationBlockController.php` — scaffold stub (all 7 methods empty), zero routes, deps: `ConversationBlock`; NOT in original checkbox list, user-confirmed to include (clearly Conversation domain)
- [x] Models: `Conversation` (morphTo participants, hasMany `Message`, hasOne `ConversationBlock`), `ConversationBlock` (belongsTo `Conversation`, `User`), `Message` (belongsTo `Conversation`, morphTo sender/receiver), `Notification` (morphTo sender/recipient), `SocialAccount` (plain)
- [x] Requests: `app/Http/Requests/Conversation/{BlockUserRequest,GetConversationRequest,SetActiveConversationRequest,StoreConversationRequest}` (plain FormRequests), `StoreMessageRequest` + `UpdateSocialAccountsRequest` (extend `BaseFormRequest`), `SendNotificationRequest` (plain FormRequest)
- [x] Services: `ChatService` + `ConversationService` already in `app/Modules/Conversation/Services`; `app/Http/Services/SMSService.php` — unreferenced dead code (SMSController duplicates its payload inline); `app/Http/Services/NotificationService.php` — injected by 11+ classes outside this module (Service x7, Payment x3, FamilyMember x1, `SendSubscriptionExpiredNotification` listener, `NotificationController`)
- [x] `app/Events/NotificationSent.php` — ShouldBroadcastNow event, never dispatched (NotificationService triggers Pusher directly with event-name strings); stays global (user-confirmed)
- [x] Routes: `routes/api.php` imports the 5 checked controllers + `ContactMessageController`; `ConversationBlockController` has no route references; URLs/methods/names/middleware untouched
- [x] Seeders: `ConversationMessageSeeder` imports `App\Models\Message`; `SocialContactInfoSeeder` imports `App\Models\SocialAccount`; `ContactMessagesSeeder` imports `App\Models\ContactMessage` (Contact domain — no change)
- [x] Tests: zero references to moved classes (only Laravel's `Illuminate\Support\Facades\Notification` in Auth tests)
- [x] Factories: none exist for these models
- [x] Migrations: table-based, no model namespaces — untouched (AGENTS.md §42)
- [x] OpenApi: schemas `MessageResponseSchema`, `NotificationSchema`, `ContactMessageSchema` are standalone OA attribute classes, string-only refs, zero model imports → shared infrastructure, stay global
- [x] Providers/Console/Helpers: no references to moved classes (`AppServiceProvider` registers `SubscriptionExpired` + listener only — both stay global)
- [x] `composer.json` PSR-4 `"App\\": "app/"` already covers `App\Modules\Conversation\...` — no composer change needed

## Phase 2 — Domain Mapping (DONE)

Domain = **`Conversation`** (module already established by the services move; messaging + notifications + SMS + social contact info are the same "messaging/contact" business area per the checkbox list).

**Tier 1 — core (the 5 checked controllers + confirmed ConversationBlockController):**
- `ConversationController`, `MessageController`, `NotificationController`, `SMSController`, `SocialAccountController`, `ConversationBlockController` → `App\Modules\Conversation\Controllers`

**Tier 2 — clearly Conversation-owned support classes:**
- Models: `Conversation`, `ConversationBlock`, `Message`, `Notification`, `SocialAccount` → `App\Modules\Conversation\Models`
- Requests: `BlockUserRequest`, `GetConversationRequest`, `SetActiveConversationRequest`, `StoreConversationRequest`, `StoreMessageRequest`, `SendNotificationRequest`, `UpdateSocialAccountsRequest` → `App\Modules\Conversation\Requests`
- `SMSService` → `App\Modules\Conversation\Services` (SMS domain, unreferenced — zero breakage risk)

**Stays global (must NOT move):**
- `app/Http/Services/NotificationService.php` — shared infrastructure injected by Service/Payment/FamilyMember modules; only its `use App\Models\Notification;` import is updated (user-confirmed to keep global)
- `app/Http/Services/ImageService.php` — used by ~20 classes across modules
- `app/Http/Requests/BaseFormRequest.php` — base class extended by two moved requests
- `app/Events/NotificationSent.php` — unreferenced broadcast infra (user-confirmed)
- `ContactMessageController` + `ContactMessage` model + `StoreContactMessageRequest` + `ContactMessagesSeeder` — "Contact & FAQ" domain (OA tags), excluded (user-confirmed)
- `app/Http/Controllers/Controller.php` (base controller), `app/Http/Traits/ApiResponse.php`
- `app/OpenApi/*`, `routes/channels.php`, `app/Providers/*` — no class refs to moved code
- `database/seeders/ContactMessagesSeeder.php` — Contact domain

## Phase 3 — Target Structure

```
app/Modules/Conversation/
├── Controllers/
│   ├── ConversationController.php
│   ├── ConversationBlockController.php
│   ├── MessageController.php
│   ├── NotificationController.php
│   ├── SMSController.php
│   └── SocialAccountController.php
├── Models/
│   ├── Conversation.php
│   ├── ConversationBlock.php
│   ├── Message.php
│   ├── Notification.php
│   └── SocialAccount.php
├── Requests/
│   ├── BlockUserRequest.php
│   ├── GetConversationRequest.php
│   ├── SendNotificationRequest.php
│   ├── SetActiveConversationRequest.php
│   ├── StoreConversationRequest.php
│   ├── StoreMessageRequest.php
│   └── UpdateSocialAccountsRequest.php
└── Services/
    ├── ChatService.php          (already moved)
    ├── ConversationService.php  (already moved)
    └── SMSService.php           (moves in this run)
```

## Phase 4 — Validation (DONE)

### File-by-file move table

| # | Old path | New path | New namespace |
|---|----------|----------|---------------|
| 1 | `app/Http/Controllers/ConversationController.php` | `app/Modules/Conversation/Controllers/ConversationController.php` | `App\Modules\Conversation\Controllers` |
| 2 | `app/Http/Controllers/ConversationBlockController.php` | `app/Modules/Conversation/Controllers/ConversationBlockController.php` | `App\Modules\Conversation\Controllers` |
| 3 | `app/Http/Controllers/MessageController.php` | `app/Modules/Conversation/Controllers/MessageController.php` | `App\Modules\Conversation\Controllers` |
| 4 | `app/Http/Controllers/NotificationController.php` | `app/Modules/Conversation/Controllers/NotificationController.php` | `App\Modules\Conversation\Controllers` |
| 5 | `app/Http/Controllers/SMSController.php` | `app/Modules/Conversation/Controllers/SMSController.php` | `App\Modules\Conversation\Controllers` |
| 6 | `app/Http/Controllers/SocialAccountController.php` | `app/Modules/Conversation/Controllers/SocialAccountController.php` | `App\Modules\Conversation\Controllers` |
| 7 | `app/Models/Conversation.php` | `app/Modules/Conversation/Models/Conversation.php` | `App\Modules\Conversation\Models` |
| 8 | `app/Models/ConversationBlock.php` | `app/Modules/Conversation/Models/ConversationBlock.php` | `App\Modules\Conversation\Models` |
| 9 | `app/Models/Message.php` | `app/Modules/Conversation/Models/Message.php` | `App\Modules\Conversation\Models` |
| 10 | `app/Models/Notification.php` | `app/Modules/Conversation/Models/Notification.php` | `App\Modules\Conversation\Models` |
| 11 | `app/Models/SocialAccount.php` | `app/Modules/Conversation/Models/SocialAccount.php` | `App\Modules\Conversation\Models` |
| 12 | `app/Http/Requests/Conversation/BlockUserRequest.php` | `app/Modules/Conversation/Requests/BlockUserRequest.php` | `App\Modules\Conversation\Requests` |
| 13 | `app/Http/Requests/Conversation/GetConversationRequest.php` | `app/Modules/Conversation/Requests/GetConversationRequest.php` | `App\Modules\Conversation\Requests` |
| 14 | `app/Http/Requests/Conversation/SetActiveConversationRequest.php` | `app/Modules/Conversation/Requests/SetActiveConversationRequest.php` | `App\Modules\Conversation\Requests` |
| 15 | `app/Http/Requests/Conversation/StoreConversationRequest.php` | `app/Modules/Conversation/Requests/StoreConversationRequest.php` | `App\Modules\Conversation\Requests` |
| 16 | `app/Http/Requests/StoreMessageRequest.php` | `app/Modules/Conversation/Requests/StoreMessageRequest.php` | `App\Modules\Conversation\Requests` |
| 17 | `app/Http/Requests/SendNotificationRequest.php` | `app/Modules/Conversation/Requests/SendNotificationRequest.php` | `App\Modules\Conversation\Requests` |
| 18 | `app/Http/Requests/UpdateSocialAccountsRequest.php` | `app/Modules/Conversation/Requests/UpdateSocialAccountsRequest.php` | `App\Modules\Conversation\Requests` |
| 19 | `app/Http/Services/SMSService.php` | `app/Modules/Conversation/Services/SMSService.php` | `App\Modules\Conversation\Services` |

(Already in module, no action: `Services/ChatService.php`, `Services/ConversationService.php`.)

### Reference updates required (imports only, no behavior change)

- **`routes/api.php`** — rewrite 6 `use` imports to `App\Modules\Conversation\Controllers\...` (ConversationController, MessageController, NotificationController, SMSController, SocialAccountController; `ContactMessageController` import stays). Route bodies/URLs/methods/names/middleware untouched.
- **All 6 moved controllers** — add `use App\Http\Controllers\Controller;` (base controller no longer resolves in the new namespace). Per-controller rewrites:
  - `ConversationController`: 4 request imports → `App\Modules\Conversation\Requests\...`
  - `MessageController`: `StoreMessageRequest` → module Requests; `App\Models\Conversation`/`App\Models\Message` → module Models; `ChatService` (module) + `ImageService` (global) unchanged
  - `NotificationController`: `SendNotificationRequest` → module Requests; `App\Models\Notification` → module Models; `NotificationService` (global), `User`, `Organization` unchanged
  - `SocialAccountController`: `UpdateSocialAccountsRequest` → module Requests; `App\Models\SocialAccount` → module Models
  - `SMSController`: base Controller import only
- **Moved models** — no internal import churn: they only reference same-module models (`Conversation`/`Message`/`ConversationBlock` resolve within `App\Modules\Conversation\Models`); `ConversationBlock` keeps its existing `App\Modules\User\Models\User` import.
- **External import rewrites** (files stay in place):
  - `app/Modules/User/Models/User.php` — Conversation, Message, Notification
  - `app/Modules/Organization/Models/Organization.php` — Conversation, Message, Notification
  - `app/Modules/Auth/Controllers/AuthController.php` — Notification
  - `app/Modules/Conversation/Services/ConversationService.php` — Conversation, ConversationBlock, Message
  - `app/Modules/Conversation/Services/ChatService.php` — Conversation, Message
  - `app/Http/Services/NotificationService.php` — Notification (stays global)
  - `database/seeders/ConversationMessageSeeder.php` — Message
  - `database/seeders/SocialContactInfoSeeder.php` — SocialAccount

### No changes needed

`composer.json` (PSR-4 covers Modules), `AppServiceProvider`/event registrations, `routes/channels.php`, `app/OpenApi/**`, `tests/`, migrations, factories (none exist).

### Verification after apply

```bash
composer dump-autoload
php artisan optimize:clear
php artisan route:list
php artisan test
```

Then `git diff`/`git status` — expect only file moves, namespace changes, import changes, and reference updates.

## Ambiguities / Decisions (user-confirmed)

- **`NotificationService` stays in `app/Http/Services`** — shared by Service/Payment/FamilyMember modules; moving it into Conversation would create cross-module dependencies. A future dedicated `Notification` module could house it.
- **`ConversationBlockController` included** — dead scaffold (empty methods, zero routes) but clearly Conversation domain; namespace/import-only change.
- **`ContactMessageController` / `ContactMessage` / `StoreContactMessageRequest` excluded** — "Contact & FAQ" domain (OA tags), belongs in a future Content/Contact run.
- **`app/Events/NotificationSent` stays global** — never dispatched anywhere.

## Pre-existing bugs / code-quality issues (report only, NOT fixed)

1. `MessageController::destroy()` (`app/Http/Controllers/MessageController.php:128`): `response()->json(['message' => 'Message deleted successfully', 200])` — bare `200` inside the array yields `{"message":...,"0":200}` in the body; also ignores the `{messageId}` route param in favor of a `message_id` body field.
2. `NotificationController::getLastTenNotifications()`: duplicate `$notifications->isEmpty()` check after the transform (lines 269-270 and 312-313); second block is dead code.
3. `NotificationController::sendMultipleNotification()`: `'user_ids' => 'required'` without `array` rule (comment says it should be an array) while validating `user_ids.*`; `SendNotificationRequest::messages()` defines `user_id.required`/`user_id.exists` keys that can never match the `user_ids` rule.
4. `SMSService` is entirely unreferenced dead code, and `SMSController` duplicates its gateway payload inline (also uses `env()` directly rather than `config()`).
5. `app/Events/NotificationSent` is defined but never dispatched (Pusher triggers are done directly in `NotificationService` with event-name strings).
6. `ChatService` and `NotificationService` each instantiate a Pusher client with duplicated config.