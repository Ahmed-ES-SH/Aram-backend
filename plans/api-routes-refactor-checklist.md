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
- [x] ArticleController
- [x] ArticleCategoryController
- [x] ArticleCommentController
- [x] ArticleInteractionsController
- [x] TagController (`app/Modules/Article`)
- [ ] KeywordController

## Keyword — [x] DONE
- [x] KeywordController (`app/Modules/Keyword`)

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
**Totals:** 59 controllers — 9 refactored `[x]`, 50 pending `[ ]`.
