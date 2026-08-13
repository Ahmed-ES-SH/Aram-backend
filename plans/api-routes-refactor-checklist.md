# API Routes Refactor Checklist

> Source: `routes/api.php` — controllers imported/used by routes.
> `[x]` = already moved to `app/Modules/<Module>/`; `[ ]` = still in `app/Http/Controllers/`.

## Auth — [x] DONE
- [x] AuthController (`app/Modules/Auth`)

## User — [x] DONE
- [x] UserController (`app/Modules/User`)
- [x] FamilyMemberController
- [x] MemberController (newsletter subscribers)

## Article
- [ ] ArticleController
- [ ] ArticleCategoryController
- [ ] ArticleCommentController
- [ ] ArticleInteractionsController
- [ ] TagController
- [ ] KeywordController

## Organization
- [ ] OrganizationController
- [ ] OrganizationReviewController
- [ ] OrganizationPrivacyPolicyController
- [ ] OrganizationTermsConditionController
- [ ] ReviewLikesCheckController

## Service
- [ ] ServicePageController
- [ ] ServicePageContactMessageController
- [ ] ServiceCategoryController
- [ ] ServiceFormController
- [ ] ServiceFormFieldController
- [ ] ServiceFormSubmissionController
- [ ] ServiceOrderController
- [ ] ServiceTrackingController
- [ ] AppointmentController

## Card
- [ ] CardController
- [ ] CardCategoryController
- [ ] OwnedCardController
- [ ] CurrencyController

## Wallet / Payment
- [ ] WalletController
- [ ] TransactionController
- [ ] PaymentController
- [ ] WithdrawRequestController

## Coupon
- [ ] CouponController

## Offer / Promotion
- [ ] OfferController
- [ ] PromoterController
- [ ] PromoterRatioController
- [ ] PromoterTrackingController
- [ ] PromotionActivityController

## Conversation / Messaging
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
**Totals:** 59 controllers — 3 refactored `[x]`, 56 pending `[ ]`.
