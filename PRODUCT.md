# Product

<!-- impeccable:product-schema 1 -->

## Platform

web

## Users

- **Primary: consumers (clients)** in the Gulf region looking for cosmetic procedures, healthcare services, and medical cards they can use at affiliated centers. Their job: find a trusted center/service, compare options and offers, buy (procedures, medical cards, related products) through a cart with online payment, and manage the experience after purchase (reviews, notifications, conversations).
- **Partner centers / organizations:** healthcare and cosmetic centers that get listed with profiles, ratings, reviews, offers, and locations on the map; they operate in the platform's directory and register through their own signup flow.
- **Operators:** staff and admin panels (user control panel, center control panel) manage users, centers, cards, and content.

## Product Purpose

Aram Gulf Ltd. (شركة آرام الخليج المحدودة) is a comprehensive platform that connects consumers with trusted healthcare and cosmetic centers in the Gulf region: search and browse services and partner centers, compare offers, buy medical cards and procedures, pay online, and stay connected afterwards. Success is the consumer completing a purchase with confidence.

## Positioning

An all-in-one platform for cosmetic and healthcare services: discovery, comparison, booking, payment, and aftercare (reviews, notifications, conversations) in one trusted place, available in Arabic first with English support.

## Operating Context

- Bilingual site: Arabic (primary, RTL) and English.
- Consumer journey: home -> search services or browse centers (filters: category, rating, location, time) -> service/center detail pages with galleries, offers, reviews -> cart -> online payment -> success/failure feedback.
- Medical-card product line purchased through the cart, redeemable at affiliated centers.
- Centers publish offers; users receive real-time notifications (Pusher) and can chat with the platform/centers.
- Embedded n8n chat widget for support conversations.
- Live location selection on organization pages (Leaflet maps).

## Capabilities and Constraints

- Next.js 16 (App Router) with i18n routing, Tailwind CSS v4, Redux Toolkit state, TypeScript.
- Auth for users and centers (cookie-based, encrypted token).
- Cart + payment flow with success and failure pages; promo codes supported.
- Blog (articles), about, terms & privacy suites for both users and organizations.
- Backend is a separate API (NEXT_PUBLIC_API_BASE_URL) with an HTTP proxy; frontend is deployed via Docker.
- SEO artifacts present: sitemap, robots, per-locale metadata.

## Brand Commitments

- **Gulf region focus:** Arabic-first with English secondary; RTL primary reading direction.
- **Existing identity to keep:** current brand assets live in `public/` (`logo.png`, favicon set, `about.png`), and the brand palette is defined as CSS custom properties in `app/globals.css` (`--primary`, `--primary-red`, `--primary-blue`, etc.). The incumbent visual identity is considered binding until a redesign is explicitly requested.
- **Medical-grade trust:** the brand must read as credible, clinical, and trustworthy for healthcare and cosmetic services — not flashy marketplace styling.
- Company legal name used verbatim: "Aram Gulf Ltd." / "شركة آرام الخليج المحدودة".

## Evidence on Hand

- Full bilingual copy in `app/messages/en.json` and `app/messages/ar.json` (metadata, page copy, labels).
- Real brand assets in `public/` (logo, favicon set, hero/about imagery, card and service images).
- Provider data shapes in `app/components/_website/_servicesPage/service.ts` and fetch helpers (`app/helpers/`).
- No DESIGN.md exists yet; the incumbent visual world lives in the code (globals.css tokens, components).
- No confirmed testimonials, case studies, or press assets were found; do not fabricate them.

## Product Principles

1. **Consumer confidence first:** the experience must make buying medical and cosmetic services feel safe and legitimate, never like a risky impulse purchase.
2. **Gulf-context authenticity:** design and copy must feel native to a Gulf audience — Arabic-first, RTL-correct, regionally relevant.
3. **One platform, one journey:** discovery, comparison, offers, payment, and aftercare should feel like a single connected flow, not stitched-together pages.
4. **Trust the data:** real listings, ratings, offers, and reviews drive decisions; the UI should surface evidence (verified centers, real offers) over decoration.
5. **Medical-grade restraint:** credibility trumps flash; polish lives in precision, clarity, and consistency.

## Accessibility & Inclusion

- Arabic and English language support with RTL/LTR switching — layout must mirror cleanly, not just translate.
- Mobile-web is a core usage context (burger menus, bottom-sheet style components, mobile-first sections exist throughout).