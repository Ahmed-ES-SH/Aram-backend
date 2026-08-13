# API Routes Refactor Checklist

> Source: `routes/api.php` — controllers imported/used by routes.
> `[x]` = already moved to `app/Modules/<Module>/`; `[ ]` = still in `app/Http/Controllers/`.

## Auth — [x] DONE
- [x] AuthController (`app/Modules/Auth`)

## User — [x] DONE
- [x] UserController (`app/Modules/User`)
- [x] FamilyMemberController (`app/Modules/FamilyMember`)
- [x] MemberController (`app/Modules/Member`, newsletter subscribers)

## Article
- [x] ArticleController
- [x] ArticleCategoryController
- [x] ArticleCommentController
- [x] ArticleInteractionsController
- [x] TagController (`app/Modules/Article`)
- [x] KeywordController (`app/Modules/Keyword`)

## Keyword — [x] DONE
- [x] KeywordController (`app/Modules/Keyword`)

## Organization — [x] DONE
- [x] OrganizationController (`app/Modules/Organization`)
- [x] OrganizationReviewController (`app/Modules/Organization`)
- [x] OrganizationPrivacyPolicyController (`app/Modules/Organization`)
- [x] OrganizationTermsConditionController (`app/Modules/Organization`)
- [x] ReviewLikesCheckController (`app/Modules/Organization`)

## Service — [x] DONE
- [x] ServicePageController (`app/Modules/Service/Controllers`)
- [x] ServicePageContactMessageController (`app/Modules/Service/Controllers`)
- [x] ServiceCategoryController (`app/Modules/Service/Controllers`)
- [x] ServiceFormController (`app/Modules/Service/Controllers`)
- [x] ServiceFormFieldController (`app/Modules/Service/Controllers`)
- [x] ServiceFormSubmissionController (`app/Modules/Service/Controllers`)
- [x] ServiceOrderController (`app/Modules/Service/Controllers`)
- [x] ServiceTrackingController (`app/Modules/Service/Controllers`)
- [x] AppointmentController (`app/Modules/Service/Controllers`)
- [x] PendingServiceOrderFileController (`app/Modules/Service/Controllers`)
- [x] ServiceTrackingFileController (`app/Modules/Service/Controllers`)

## Card — [x] DONE
- [x] CardController (`app/Modules/Card/Controllers`)
- [x] CardCategoryController (`app/Modules/Card/Controllers`)
- [x] OwnedCardController (`app/Modules/Card/Controllers`)
- [x] CurrencyController (`app/Modules/Card/Controllers`)

## Wallet / Payment — [x] services moved to `app/Modules/Payment/Services`
- [ ] WalletController
- [ ] TransactionController
- [ ] PaymentController
- [ ] WithdrawRequestController

## Coupon — [x] services moved to `app/Modules/Coupon/Services`
- [ ] CouponController

## Offer / Promotion — [x] services moved to `app/Modules/Promotion/Services`
- [ ] OfferController
- [ ] PromoterController
- [ ] PromoterRatioController
- [ ] PromoterTrackingController
- [ ] PromotionActivityController

## Conversation / Messaging — [x] services moved to `app/Modules/Conversation/Services`
- [ ] ConversationController
- [ ] MessageController
- [ ] NotificationController
- [ ] SMSController
- [ ] SocialAccountController

## Content / Static Pages
- [ ] AboutController
- [ ] HomePageController
- [ ] DashboardMainPageController
- [ ] SlideController
- [ ] WebsiteVideoController
- [ ] NewsletterController
- [ ] ContactMessageController
- [ ] QuestionAnswerController
- [ ] PrivacyPolicyController
- [ ] TermsConditionController
- [ ] FooterLinkController
- [ ] CategoryController
- [ ] SubCategoryController
- [ ] VariableDataController

## Misc / Shared
- [ ] TodoController
- [ ] TempUploadController

---
**Totals:** 62 controllers — 31 refactored `[x]`, 31 pending `[ ]`.

> Services: 22 of 26 moved to `app/Modules/*/Services` (`Service` 6, `Payment` 8, `Coupon` 5, `Promotion` 1, `Conversation` 2). Remaining global (shared): `ImageService`, `NotificationService`, `TempUploadService`, `SMSService`.
