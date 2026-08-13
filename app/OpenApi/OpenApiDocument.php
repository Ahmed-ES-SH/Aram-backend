<?php

namespace App\OpenApi;

use OpenApi\Attributes as OA;

#[OA\Info(
    title: 'Aram API',
    version: '1.0.0',
    description: 'Aram backend API. Public endpoints are open, authenticated endpoints require a Sanctum bearer token (Authorization: Bearer <token>), admin endpoints additionally require an admin account.',
)]
#[OA\Tag(name: 'Auth', description: 'Authentication (login, OTP, password reset, social login).')]
#[OA\Tag(name: 'Users', description: 'User accounts and profiles.')]
#[OA\Tag(name: 'Categories', description: 'Main categories (public + admin).')]
#[OA\Tag(name: 'Sub Categories', description: 'Sub categories (public + admin).')]
#[OA\Tag(name: 'Service Categories', description: 'Service categories (public + admin).')]
#[OA\Tag(name: 'Card Categories', description: 'Card categories (public + admin).')]
#[OA\Tag(name: 'Article Categories', description: 'Article categories (public + admin).')]
#[OA\Tag(name: 'Currencies', description: 'Currencies (public + admin).')]
#[OA\Tag(name: 'Cards', description: 'Cards (public + protected + admin).')]
#[OA\Tag(name: 'Organizations', description: 'Organizations (public + protected + admin).')]
#[OA\Tag(name: 'Articles', description: 'Articles (public + protected + admin).')]
#[OA\Tag(name: 'Tags', description: 'Article tags.')]
#[OA\Tag(name: 'Keywords', description: 'Search keywords (public + admin).')]
#[OA\Tag(name: 'Coupons', description: 'Coupons (protected + admin).')]
#[OA\Tag(name: 'Offers', description: 'Offers (public + protected + admin).')]
#[OA\Tag(name: 'Wallet & Transactions', description: 'Wallet balance, deposits and user transactions.')]
#[OA\Tag(name: 'Withdraw Requests', description: 'Withdrawal requests (user + admin).')]
#[OA\Tag(name: 'Appointments', description: 'Appointments and available times (public + protected).')]
#[OA\Tag(name: 'Conversations & Messages', description: 'Chat conversations and messages (protected).')]
#[OA\Tag(name: 'Service Pages', description: 'Landing service pages (public + admin).')]
#[OA\Tag(name: 'Service Forms', description: 'Service form schemas and submissions (public + protected + admin).')]
#[OA\Tag(name: 'Service Orders', description: 'Service orders (protected + admin).')]
#[OA\Tag(name: 'Service Tracking', description: 'Service tracking (protected + admin).')]
#[OA\Tag(name: 'Organization Reviews', description: 'Organization reviews and likes (public + protected).')]
#[OA\Tag(name: 'Notifications', description: 'Push / in-app notifications (protected + admin).')]
#[OA\Tag(name: 'SMS', description: 'SMS sending (internal + protected).')]
#[OA\Tag(name: 'Family Members', description: 'Family member management (protected).')]
#[OA\Tag(name: 'Home Page', description: 'Home page sections and hero (public + admin).')]
#[OA\Tag(name: 'Slides', description: 'Sliders (public + admin).')]
#[OA\Tag(name: 'Variable Data', description: 'Global site variables and main sections (public + admin).')]
#[OA\Tag(name: 'Newsletters & Members', description: 'Newsletter subscriptions and members (public + admin).')]
#[OA\Tag(name: 'Contact Messages', description: 'Contact form messages (public + admin).')]
#[OA\Tag(name: 'FAQs', description: 'Questions & answers (public + admin).')]
#[OA\Tag(name: 'Footer Links', description: 'Footer link lists (public + admin).')]
#[OA\Tag(name: 'Policies & Terms', description: 'Privacy policies and terms & conditions (public + admin).')]
#[OA\Tag(name: 'About', description: 'About details, logo and cooperation file (public + admin).')]
#[OA\Tag(name: 'Social Accounts', description: 'Social contact info (public + admin).')]
#[OA\Tag(name: 'Website Videos', description: 'Site videos (public + admin).')]
#[OA\Tag(name: 'Promoters', description: 'Promoters and promoter codes (protected).')]
#[OA\Tag(name: 'Promotion Activities', description: 'Promotion tracking and referral activities (public + protected + admin).')]
#[OA\Tag(name: 'Dashboard', description: 'Admin dashboard stats and charts.')]
#[OA\Tag(name: 'Payments', description: 'Checkout sessions and webhooks (protected).')]
#[OA\Tag(name: 'Temp Uploads', description: 'Temporary file uploads (protected).')]
#[OA\Tag(name: 'Todos', description: 'To-do list (protected).')]
class OpenApiDocument
{
}