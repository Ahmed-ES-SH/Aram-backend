<?php

use App\Http\Controllers\AffiliateCardTypeController;
use App\Http\Controllers\AffiliateServiceController;
use App\Http\Controllers\ArmaCardController;
use App\Http\Controllers\ArticalCategoryController;
use App\Http\Controllers\ArticleReactionController;
use App\Http\Controllers\Authcontroller;
use App\Http\Controllers\BalanceController;
use App\Http\Controllers\BellController;
use App\Http\Controllers\BlockedUserController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CardTypeCategoryController;
use App\Http\Controllers\CardTypeController;
use App\Http\Controllers\CardVisitController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CompanyDetailesController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\CoponeController;
use App\Http\Controllers\FooterController;
use App\Http\Controllers\MainpageController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\ServiceCategoryController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\PrivacyPolicyOrganizationController;
use App\Http\Controllers\PrivacyPolicyUserController;
use App\Http\Controllers\TermsConditionOrganizationController;
use App\Http\Controllers\TermsConditionUserController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\QuestionAnswerController;
use App\Http\Controllers\FinancialTransactionsController;
use App\Http\Controllers\OrganizationReviewController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\WithdrawalrequestController;
use App\Http\Controllers\ReviewLikesCheckController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\PointCooperationController;
use App\Http\Controllers\PromoterNewUserController;
use App\Http\Controllers\PromotionalCardController;
use Illuminate\Support\Facades\Route;


// -------------------------
//  Auth Routes -----------
// -------------------------

Route::post('/login', [Authcontroller::class, "login"]);

Route::middleware('auth:sanctum')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('/currentuser', 'currentUser'); // إضافة دالة لاسترجاع المستخدم الحالي
        Route::post('/logout', 'logout');
    });
});


// -------------------------------------
//  Password Forgeten Routes -----------
// -------------------------------------

Route::post('/send-verification-code', [ForgotPasswordController::class, 'sendVerificationCode']);
Route::post('/verify-code', [ForgotPasswordController::class, 'verifyCode']);
Route::post('/update-password', [ForgotPasswordController::class, 'updatePassword']);

// -------------------------
//  google Routes -----------
// -------------------------

Route::get('/auth/google/redirect', [AuthController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);


// -------------------------
//  facebook Routes --------
// -------------------------

Route::get('/auth/facebook/redirect', [AuthController::class, 'redirectToFacebook']);
Route::get('/auth/facebook/callback', [AuthController::class, 'handleFacebookCallback']);



// -------------------------
//  Users Routes -----------
// -------------------------
Route::controller(UserController::class)->group(function () {
    Route::get('/get-user-coupones/{id}', 'getUserCoupons');
    Route::get('/get-user-ids', 'getUsersIds');
    Route::get('/verify-email/{type}/{id}',  'verifyEmail');
    Route::post('/resend-verification-email/{type}',  'resendVerificationEmail');
    Route::get('/users-by-number-of-reservations', 'usersByNumberOfReservations');
    Route::get('/users-count', 'usersCount');
    Route::post('/register', 'store');
    Route::post('/search-for-user-by-name/{name}', 'SearchByNameForUser');
    Route::get('/get-user-by-name/{name}', 'SearchByNameForUser');
    Route::post('/users/send-verification-code', 'store');
    Route::post('/update-user/{id}', 'update');
    Route::get('/user/{id}', 'show');
    Route::post('/check-password/{id}', 'checkPassword');
    Route::delete('/user/{id}', 'destroy');
});

Route::middleware(['checkAdmin'])->group(function () {
    Route::controller(UserController::class)->group(function () {
        Route::get('/users', 'index');
    });
});






// -------------------------
//  News Letter Routes -----
// -------------------------
Route::get('/members', [NewsletterController::class, 'index']);
Route::get('/members-by-email/{searchcontent}', [NewsletterController::class, 'getMembersByEmail']);
Route::get('/get-members-ids', [NewsletterController::class, 'getMembersIds']);
Route::post('/subscribe', [NewsletterController::class, 'subscribe']);
Route::post('/send-newsletter', [NewsletterController::class, 'sendNewsletter']);
Route::delete('/unsubscribe/{id}', [NewsletterController::class, 'unsubscribe']);







// -------------------------
//  mainpage Routes --------
// -------------------------
Route::controller(MainpageController::class)->group(function () {
    Route::get('/about-dash', 'about');
    Route::get('/get-videoscreen', 'getvideoscreen');
    Route::get('/get-slidermainscreen', 'getmainscreen');
    Route::get('/get-mainscreens', 'getallmainscreen');
    Route::get('/get-getdetailes/{id}', 'getdetailes');
    Route::post('/update-mainscreen/{id}', 'updateMainscreen');
    Route::post('/update-about-dash', 'updateabout');
    Route::post('/update-videoscreen', 'updatevideoscreen');
    Route::post('/update-services', 'updateservices');
});






// -------------------------
//  sliders Routes ---------
// -------------------------
Route::controller(SliderController::class)->group(function () {
    Route::get('/sliders', 'index');
    Route::get('/slider/{id}', 'show');
    Route::post('/add-slider', 'store');
    Route::post('/update-slider/{id}', 'update');
    Route::delete('/slider/{id}', 'destroy');
});

// -------------------------
//  categories Routes ------
// -------------------------
Route::controller(CategoryController::class)->group(function () {
    Route::get('/categories', 'index');
    Route::get('/category/{id}', 'show');
    Route::post('/add-category', 'store');
    Route::post('/update-category/{id}', 'update');
    Route::delete('/category/{id}', 'destroy');
});



// ---------------------------------
// services categories Routes ------
// ---------------------------------
Route::controller(ServiceCategoryController::class)->group(function () {
    Route::get('/service-categories', 'index');
    Route::get('/count-organization-categories', 'getCountOrganizationsByCategory');
    Route::get('/get-organization-categories', 'getOrganizationsByCategory');
    Route::get('/count-affilate-services-categories', 'getCountAffiliateServicesByCategory');
    Route::get('/all-service-categories', 'All');
    Route::get('/service-category/{id}', 'show');
    Route::post('/service-category', 'store');
    Route::post('/update-service-category/{id}', 'update');
    Route::delete('/service-category/{id}', 'destroy');
});



// ---------------------------------
// Articals categories Routes ------
// ---------------------------------
Route::controller(ArticalCategoryController::class)->group(function () {
    Route::get('/artical-categories', 'index');
    Route::get('/all-artical-categories', 'All');
    Route::get('/artical-category/{id}', 'show');
    Route::post('/artical-category', 'store');
    Route::post('/update-artical-category/{id}', 'update');
    Route::delete('/artical-category/{id}', 'destroy');
});

// -------------------------
//  Blogs Routes -----------
// -------------------------

Route::controller(BlogController::class)->group(function () {
    Route::get('/articals', 'index');
    Route::get('/get-articles-by-search/{text}', 'getArticlesBySearch');
    Route::get('/get-articles-by-category/{category_id}', 'getArticlesByCategory');
    Route::get('/random-five-articles', 'RandomFiveArticles');
    Route::get('/get-comments/{article_id}', 'getComments');
    Route::get('/top-articals', 'TopTenArticles');
    Route::get('/artical/{id}', 'show');
    Route::get('/artical_dash/{id}', 'show_dash');
    Route::get('/active-articals', 'activearticals');
    Route::get('/update-active-artical/{id}/{active}', 'updateactiveartical');
    Route::get('/artical/{id}/comments', 'paginateComments');
    Route::get('/artical/{id}/count', 'getcount');
    Route::post('/add-artical', 'store');
    Route::post('/update-artical/{id}', 'update');
    Route::post('/artical/{id}/update-views', 'updateViews');
    Route::delete('/artical/{id}', 'destroy');
});


Route::post('/articles/{articleId}/reactions', [ArticleReactionController::class, 'addReaction']);
Route::get('/articles/{articleId}/reactions/{userId}', [ArticleReactionController::class, 'getUserReact']);
Route::get('/articles/{articleId}/reactions', [ArticleReactionController::class, 'getArticleReactions']);
Route::delete('/articles/{articleId}/reactions', [ArticleReactionController::class, 'removeReaction']);




// -------------------------
//  Comments Routes --------
// -------------------------
Route::controller(CommentController::class)->group(function () {
    Route::get('/comment/{id}', 'show');
    Route::post('/add-comment', 'store');
    Route::post('/update-comment/{id}', 'update');
    Route::delete('/comment/{id}', 'destroy');
});

// -------------------------
//  Organizations Routes ---
// -------------------------
Route::controller(OrganizationController::class)->group(function () {
    Route::get('/organizations', 'index');
    Route::get('/organizations-by-verfiy', 'getOrgsByVerifyStatus');
    Route::get('/organizations-for-select', 'OrganizationsForSelectionTable');
    Route::get('/get-organizations-ids', 'getOrganizationsIds');
    Route::get('/published-organiztions', 'publishedOrganizations');
    Route::get('/published-organiztions-with-selected-data', 'publishedOrganizationswithSelectedData');
    Route::get('/getlocations/{categoryId}', 'getlocations');
    Route::get('/organizations-by-rateing', 'orgsByRateing');
    Route::get('/orgs-by-number-of-reservations', 'orgsbynumberofreservations');
    Route::get('/organizations-count', 'organizationsCount');
    Route::get('/organizations-by-service/{id}', 'organizationsByServiceCategory');
    Route::get('/all-organizations-by-service/{id}', 'AllorganizationsByServiceCategory');
    Route::get('/organizations-by-location/{address}', 'organizationsByLocation');
    Route::get('/organizations-by-title/{title}', 'searchOrganizations');
    Route::get('/active-organizations', 'activeorganizations');
    Route::get('/update-active-organizations/{id}/{active}', 'updateactiveorganization');
    Route::get('/organization/{id}', 'show');
    Route::post('/add-organization', 'store');
    Route::post('/search-by-title-for-organization/{title}', 'SearchByNameForOrganization');
    Route::post('/update-organization/{id}', 'update');
    Route::post('/upload-cooperation-file/{orgId}', 'UploadCooperationFile');
    Route::get('/download-cooperation-file/{orgId}', 'downloadCooperationPDF');
    Route::post('/check-org-password/{id}', 'checkOrgPassword');
    Route::delete('/organization/{id}', 'destroy');
});


// -------------------------------
//  OrganizationReviews Routes ---
// -------------------------------

Route::controller(OrganizationReviewController::class)->group(function () {
    Route::get('/org-reviews/{id}', 'ReviewsForOrg');
    Route::get('/org-reviews-numbers/{id}', 'ReviewsNumbers');
    Route::post('/add-review', 'store');
    Route::delete('/delete-review/{id}', 'store');
});


/////////////////////////////////////////
// Check reviews Likes Routes ///////////
/////////////////////////////////////////

Route::post('/react-review', [ReviewLikesCheckController::class, 'store']);
Route::get('/review-like-user/{orgId}/{userId}', [ReviewLikesCheckController::class, 'GetReviewsForUser']);
Route::delete('/review-like/{reviewId}/{userId}', [ReviewLikesCheckController::class, 'destroy']);


// -------------------------
//  Bookings Routes --------
// -------------------------

Route::controller(BookController::class)->group(function () {
    Route::get('/bookings/{id}/{account_type}', 'index');
    Route::get('/books-count', 'booksCount');
    Route::get('/booked-appointments/{id}', 'checkBookedAppointments');
    Route::get('/book/{id}', 'show');
    Route::post('/add-book', 'store');
    Route::post('/pendding-book', 'penddingBook');
    Route::post('/update-book-status/{id}', 'updateBookStatus');
    Route::post('/sendAccaptedNotification/{client_id}/{organization_id}', 'sendAccaptedNotification');
    Route::post('/sendUnAccaptedNotification/{client_id}/{organization_id}', 'sendUnAccaptedNotification');
    Route::post('/expire-bookings', 'changeBookedStatus');
    Route::post('/update-book/{id}', 'update');
    Route::post('/book/{id}/{user_id}/{organization_id}', 'destroyOneParty');
    Route::delete('/book/{id}', 'destroy');
});


// -------------------------
//  CompanyDetailes Routes -
// -------------------------
Route::controller(CompanyDetailesController::class)->group(function () {
    Route::get('/detailes', 'index');
    Route::get('/getsociallinks', 'getSocialMediaInfo');
    Route::get('/social-media-info', 'getSocialMediaInfo');
    Route::get('/get-whatsapp-number', 'getWhatsappNumber');
    Route::post('/update-detailes', 'update');
    Route::post('/upload-cooperation-pdf', 'uploadPDF');
    Route::get('/download-cooperation-pdf', 'downloadUserPDF');
});




/////////////////////////////////////////
// CardTypeCategories Routes ////////////
/////////////////////////////////////////


Route::controller(CardTypeCategoryController::class)->group(function () {
    Route::get('/all-card-type-categories', 'allCategories');
    Route::get('/card-type-categories', 'index');
    Route::get('/card-type-category/{id}', 'show');
    Route::post('/add-card-type-category', 'store');
    Route::post('/update-card-type-category/{id}', 'update');
    Route::delete('/card-type-category/{id}', 'destroy');
});


// -------------------------------
//  Cards types Routes -----------
// -------------------------------
Route::controller(CardTypeController::class)->group(function () {
    Route::get('/card-types', 'index');
    Route::get('/card-types-by-numbers', 'getCardsbyPromotionalNumber');
    Route::get('/cards-by-category/{categoryId}', 'getCardsByCategory');
    Route::get('/active-card-types', 'activecards');
    Route::get('/update-active/{id}/{active}', 'updateactivestate');
    Route::get('/card-type/{id}', 'show');
    Route::post('/add-card-type', 'store');
    Route::post('/update-card-type/{id}', 'update');
    Route::delete('/card-type/{id}', 'destroy');
});



// -------------------------------
//  PromotionalCard Routes -----------
// -------------------------------

Route::controller(PromotionalCardController::class)->group(function () {
    Route::get('/cards-statics', 'getStatics');
    Route::get('/cards-detailes-for-promoter/{promotercode}', 'getOperationsByPromoterCode');
    Route::get('/cards-statics-count-for-all-promoters', 'getOperationsCountForAllPromoters');
    Route::get('/cards-statics-count-for-promoter/{promotercode}', 'getOperationsCountByPromoterCode');
    Route::get('/card-statics/{id}', 'getStaticsByCardId');
});



// -------------------------------
//  Cards types Routes -----------
// -------------------------------
Route::controller(AffiliateCardTypeController::class)->group(function () {
    Route::get('/affiliate-card-types', 'index');
    Route::get('/affiliate-card-types-for-organization/{id}', 'AffiliateCardtypesForOrganization');
    Route::post('/affiliate-card-Type-by-search', 'AffiliateCardTypeBySearch');
    Route::post('/affiliate-card-Type-for-organization-by-search/{id}', 'getAffiliateCardsFororganizationBySearch');
    Route::get('/active-affiliate-card-types', 'allowedAffiliateCards');
    Route::get('/affiliate-card-type/{id}', 'show');
    Route::post('/add-affiliate-card-type', 'store');
    Route::post('/update-affiliate-card-type/{id}', 'update');
    Route::delete('/affiliate-card-type/{id}', 'destroy');
});



// -------------------------
//  Cards Routes -----------
// -------------------------
Route::controller(ArmaCardController::class)->group(function () {
    Route::get('/mycards/{id}', 'myCards');
    Route::get('/active-cards-count', 'activeCardsCount');
    Route::get('/card/{id}', 'show');
    Route::post('/active-card/{id}', 'activeCard');
    Route::post('/updat-expired-cards', 'updateExpiredCards');
    Route::delete('/card/{id}', 'destroy');
});


// -------------------------
//  Messages Routes --------
// -------------------------

Route::controller(ContactMessageController::class)->group(function () {
    Route::get('/problems', 'index');
    Route::get('/problem/{id}', 'show');
    Route::post('/add-problem', 'store');
    Route::post('/update-problem/{id}', 'update');
    Route::delete('/problem/{id}', 'destroy');
});

// -------------------------
//  Services Routes --------
// -------------------------

Route::controller(ServiceController::class)->group(function () {
    Route::get('/services', 'index');
    Route::get('/get-services-by-service-category/{id}', 'getServiceByServicesCategory');
    Route::get('/get-services-by-search/{text}', 'getServicesBySearch');
    Route::get('/active-services', 'activeservices');
    Route::get('/service/{id}', 'show');
    Route::post('/add-service', 'store');
    Route::get('/update-active-service/{id}/{active}', 'updateactiveservice');
    Route::post('/update-service/{id}', 'update');
    Route::delete('/service/{id}', 'destroy');
});



// -------------------------
//  Subscribers Routes -----
// -------------------------

Route::controller(ServiceController::class)->group(function () {
    Route::get('/subscribers', 'index');
    Route::get('/subscriber/{id}', 'show');
    Route::post('/add-subscriber', 'store');
    Route::post('/update-subscriber/{id}', 'update');
    Route::delete('/subscriber/{id}', 'destroy');
});



// --------------------------------
//  PrivcyPolicyUsers Routes ------
// --------------------------------

Route::controller(PrivacyPolicyUserController::class)->group(function () {
    Route::get('/users-points', 'index');
    Route::post('/add-user-point', 'store');
    Route::post('/update-user-point/{id}', 'update');
    Route::delete('/user-point/{id}', 'destroy');
});
// ---------------------------------------
//  PrivcyPolicyOrganization Routes ------
// ---------------------------------------

Route::controller(PrivacyPolicyOrganizationController::class)->group(function () {
    Route::get('/organizations-points', 'index');
    Route::post('/add-organization-point', 'store');
    Route::post('/update-organization-point/{id}', 'update');
    Route::delete('/organization-point/{id}', 'destroy');
});
// --------------------------------
//  TermsConditionUsers Routes ------
// --------------------------------

Route::controller(TermsConditionUserController::class)->group(function () {
    Route::get('/users-terms', 'index');
    Route::post('/add-user-term', 'store');
    Route::post('/update-user-term/{id}', 'update');
    Route::delete('/user-term/{id}', 'destroy');
});
// ------------------------------------------
//  TermsConditionOrganization Routes ------
// ------------------------------------------

Route::controller(TermsConditionOrganizationController::class)->group(function () {
    Route::get('/organizations-terms', 'index');
    Route::post('/add-organization-term', 'store');
    Route::post('/update-organization-term/{id}', 'update');
    Route::delete('/organization-term/{id}', 'destroy');
});



// --------------------------------
//  PointCooperation Routes ------
// --------------------------------

Route::controller(PointCooperationController::class)->group(function () {
    Route::get('/points-cooperation', 'index');
    Route::post('/add-point-cooperation', 'store');
    Route::post('/update-point-cooperation/{id}', 'update');
    Route::delete('/point-cooperation/{id}', 'destroy');
});


// -------------------------------
// Payment  routes   -------------
// -------------------------------

Route::post('/payment/initiate', [PaymentController::class, 'initiatePayment']);
Route::post('/payment/initiate-booked', [PaymentController::class, 'initiatebookedPayment']);
Route::get('/payment/bookedPayment',  [PaymentController::class, 'bookedPayment'])->name('payment.bookedcallback');
Route::post('/payment/status', [PaymentController::class, 'getPaymentStatus']);
Route::get('/payment/callback',  [PaymentController::class, 'handleCallback'])->name('payment.callback');





// -------------------------------
// Notification  routes   --------
// -------------------------------
Route::controller(NotificationController::class)->group(function () {
    Route::get('/notifications/{id}/{account_type}', 'NotifactionsByUserId');
    Route::get('/notifications-ten/{id}/{account_type}', 'getTenNotifactions');
    Route::get('/notifications-isunread/{id}/{account_type}', 'notificationsIsUnread');
    Route::post('/notifications/send', 'sendNotification');
    Route::post('/multiplenotifications/send', 'SendMultipleNotifications');
    Route::post('/notifications-user-read/{id}/{account_type}', 'markAsRead');
    Route::get('/notifications-user-unread/{id}', 'getUnreadNotificationsByUserId');
    Route::post('/notification-user/add', 'store');
    Route::get('/notification-one/{id}', 'show');
    Route::post('/notifications/{id}', 'update');
    Route::delete('/notifications/{id}', 'destroy');
});


// -------------------------------
// Conversations  routes   -------
// -------------------------------

Route::controller(ConversationController::class)->group(function () {
    Route::get('/conversation/{id}/{user_id}/{account_type}', 'getConversation');
    Route::get('/get-user-conversations-with-lastmessage/{user_id}/{account_type}', 'getUserConversationsWithLastMessage');
    Route::get('/get-conversations-messages/{id}/{user_id}/{account_type}', 'getConversationMessages');
    Route::post('/make-conversation', 'makeConversation');
    Route::post('/delete-conversation-from-one-side/{id}/{user_id}/{account_type}', 'destroyConversationFromOneParty');
    Route::post('/blocked-conversation-from-one-side/{id}/{user_id}/{account_type}', 'blokedOtherParty');
    Route::post('/unblocked-conversation-from-one-side/{id}/{user_id}/{account_type}', 'unblockOtherParty');
    Route::post('/check-blocked-conversation/{id}/{user_id}/{account_type}', 'checkBlockedConversation');
});


// -------------------------------
// Messages  routes   ------------
// -------------------------------

Route::controller(MessageController::class)->group(function () {
    Route::post('/send-message/{conversation_id}', 'sendMessage');
    Route::post('/Converstion-messages-readed/{conversation_id}', 'ConverstionMessagesReaded');
});





// -------------------------------
// Blocked  members Routes   -----
// -------------------------------

Route::middleware('auth:api')->group(function () {
    Route::post('/block-user/{blocker_id}/{blocker_type}', [BlockedUserController::class, 'blockUser']);
    Route::post('/unblock-user/{blocker_id}/{blocker_type}', [BlockedUserController::class, 'unblockUser']);
    Route::post('/Check-blocked-party', [BlockedUserController::class, 'CheckBlockedParty']);
});





//////////////////////////////
// Footer Routes /////////////
//////////////////////////////
Route::get('/footer-lists', [FooterController::class, 'index']);
Route::get('/footer-lists/{listNumber}', [FooterController::class, 'getList']);
Route::post('/footer-lists', [FooterController::class, 'updateList']);
Route::delete('/footer-lists/{listNumber}', [FooterController::class, 'deleteList']);



//////////////////////////////
// bells Routes /////////////
//////////////////////////////

Route::controller(BellController::class)->group(function () {
    Route::get('/bells', 'index');
    Route::get('/bell/{id}', 'show');
    Route::delete('/bell-delete/{id}', 'destroy');
});




//////////////////////////////
// Offers Routes /////////////
//////////////////////////////

Route::controller(OfferController::class)->group(function () {
    Route::get('/all-offers', 'index');
    Route::get('/random-offers', 'getRandomPublishedOffers');
    Route::post('/offers-for-organization-by-search/{id}', 'offersBySearchforOrganization');
    Route::post('/offers-by-search', 'offersBySearch');
    Route::post('/check-offer-date', 'updateOfferStatuses');
    Route::get('/organization-offers/{id}', 'offersByorganization');
    Route::get('/offers-by-category/{id}', 'offersByCategory');
    Route::get('/trending-offers', 'trendingOffers');
    Route::get('/active-offers', 'getPublishedOffers');
    Route::post('/check-expired-offers', 'checkExpiredOffers');
    Route::post('/add-offer', 'store');
    Route::get('/get-offer/{id}', 'show');
    Route::post('/update-offer/{id}', 'update');
    Route::delete('/delete-offer/{id}', 'destroy');
});



//////////////////////////////
// Copones Routes /////////////
//////////////////////////////
Route::controller(CoponeController::class)->group(function () {
    Route::get('/all-copones', 'index');
    Route::get('/copones-for-account/{accountId}/{type}', 'getCoponesForAccount');
    Route::post('/search-copones', 'coponesBySearch');
    Route::post('/copones-by-category/{id}', 'coponesByCategory');
    Route::post('/send-coupone', 'sendCoponeToSelectedUsers');
    Route::post('/add-copone', 'store');
    Route::get('/get-copone', 'show');
    Route::post('/update-copone/{id}', 'update');
    Route::delete('/destroy-copone/{id}', 'destroy');
    Route::post('/check-copone-for-free-card', 'CheckCopuneForFreeCard');
});



/////////////////////////////////////////
// AffiliateServices Routes /////////////
/////////////////////////////////////////

Route::controller(AffiliateServiceController::class)->group(function () {
    Route::get('/all-affiliate-services', 'index');
    Route::get('/all-affiliate-services-by-status/{status}', 'getDataByCheckState');
    Route::get('/active-affiliate-services', 'getPublishedAffiliatedServices');
    Route::get('/active-random-affiliate-services', 'getRandomPublishedAffiliatedServices');
    Route::post('/affiliate-services-by-search', 'getAffiliateServicesByText');
    Route::get('/affiliate-services-by-category/{id}', 'getAffiliateServicesByCategory');
    Route::get('/organization-affiliate-services/{id}', 'getAffiliateServicesByorganization');
    Route::post('/affiliate-services-for-organization-by-search/{id}', 'getAffiliateServicesFororganizationBySearch');
    Route::post('/add-affiliate-services', 'store');
    Route::get('/get-affiliate-service/{id}', 'show');
    Route::post('/update-affiliate-service/{id}', 'update');
    Route::delete('/delete-affiliate-service/{id}', 'destroy');
});


/////////////////////////////////////////
// QuestionAnswer Routes /////////////
/////////////////////////////////////////


Route::controller(QuestionAnswerController::class)->group(function () {
    Route::get('/questions', 'index'); // عرض جميع الأسئلة والأجوبة
    Route::get('/approved-questions',  'approvedQuestions');
    Route::post('/questions', 'store'); // إضافة سؤال وجواب جديد
    Route::get('/questions/{id}', 'show'); // عرض سؤال وجواب محدد
    Route::post('/questions/{id}', 'update'); // تحديث سؤال وجواب محدد
    Route::delete('/questions/{id}', 'destroy'); // حذف سؤال وجواب محدد
});



/////////////////////////////////////////
// Balance Routes /////////////
/////////////////////////////////////////


Route::get('/numbers/{id}/{type}', [BalanceController::class, 'getNumbersbyorganizationId']);
Route::get('/financial-transactions/{id}', [FinancialTransactionsController::class, 'getDataById']);

/////////////////////////////////////////
// visit track Routes /////////////
/////////////////////////////////////////

Route::post('/track-visit', [VisitController::class, 'store']);
Route::get('/user-visits/{userId}', [VisitController::class, 'getUserVisits']);
Route::get('/visits-count', [VisitController::class, 'getUsersWithvisitorsCount']);
Route::get('/visits-user/{id}', [VisitController::class, 'getVisitsByUserId']);
Route::get('/visits-count-user/{id}', [VisitController::class, 'getVisitCountByUserId']);



/////////////////////////////////////////
// card visit track Routes /////////////
/////////////////////////////////////////

Route::post('/track-card-visit', [CardVisitController::class, 'store']);
Route::get('/user-card-visits/{userId}', [CardVisitController::class, 'getUserVisits']);
Route::get('/card-visits-count', [CardVisitController::class, 'getUsersWithvisitorsCount']);
Route::get('/card-visits-user/{id}', [CardVisitController::class, 'getVisitsByUserId']);
Route::get('/card-visits-count-user/{id}', [CardVisitController::class, 'getVisitCountByUserId']);


/////////////////////////////////////////
// Purchase Routes //////////////////////
/////////////////////////////////////////

Route::middleware('auth:sanctum')->post('/purchase', [PurchaseController::class, 'store']);
Route::get('/user-purchases/{userId}', [PurchaseController::class, 'getPurchasesByUserId']);
Route::get('/user-purchases-count/{userId}', [PurchaseController::class, 'getPurchaseCountByUserId']);
Route::get('/user-purchases-count', [PurchaseController::class, 'getUsersWithPurchaseTotalAndCount']);



/////////////////////////////////////////
// promoternewusers Routes //////////////
/////////////////////////////////////////


Route::controller(PromoterNewUserController::class)->group(function () {
    Route::post('/promoter-new-member', 'store');
    Route::get('/new-members-by-promoter/{promoterid}', 'getAllNewUsers');
    Route::get('/new-members-count-by-promoter/{promoterid}', 'getAllNewUsersCount');
    Route::get('/new-members-count', 'getCountNewUsersForPromoter');
});




Route::controller(WithdrawalrequestController::class)->group(function () {
    // تقديم طلب سحب جديد
    Route::post('/withdrawal-request', 'store');

    // الموافقة على طلب السحب
    Route::post('/withdrawal-requests/{id}/approve', 'approve');

    // رفض طلب السحب
    Route::post('/withdrawal-requests/{id}/reject', 'reject');

    // جلب جميع طلبات السحب
    Route::get('/withdrawal-requests', 'index');

    // جلب تفاصيل طلب معين
    Route::get('/withdrawal-requests/{id}', 'show');
});
