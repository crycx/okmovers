# OK Movers WordPress Theme Deployment

## Theme location

- Theme folder: `wordpress-theme/okmovers`
- Install to: `wp-content/themes/okmovers`

## Recommended plugin stack

- Advanced Custom Fields Pro
- A trusted SEO plugin only if the client wants richer SEO controls than the built-in basics
- A backup plugin suited to the hosting environment

## Content model recommendation

- Use Pages for core landing pages and service detail pages
- Use Posts for advice articles and blog content
- Use native WordPress Menus for header, footer and legal navigation
- Use page hierarchy for service side navigation instead of external menu APIs

## Launch checklist

1. Activate the `OK Movers` theme.
2. Install and activate ACF so the local field groups become available.
3. Set logo, menus and homepage in WordPress admin.
4. Create the core pages: homepage, kolimisteenused, hinnaparing, ettevottest, kontakt, kolimisnouanded.
5. Build page layouts using the ACF flexible sections.
6. Configure contact and quote recipient emails in the OK Movers options page.
7. Copy `wordpress-theme/robots.txt` and `wordpress-theme/llms.txt` to the site root if hosting does not generate them elsewhere.
8. Confirm `https://okmovers.ee/wp-sitemap.xml` is reachable.
9. Verify titles, meta descriptions, canonical URLs and Open Graph fields on key pages.
10. Test forms, mobile navigation and responsive layouts on desktop, tablet and mobile.

## Handover checklist

1. Document which pages use flexible sections and which use the normal editor.
2. Show the client how to update hero sections, services grids, CTA blocks and contact details.
3. Confirm who receives contact and quote form emails.
4. Export menus and permalink settings.
5. Record any redirects needed from old Nuxt routes to final WordPress URLs.
