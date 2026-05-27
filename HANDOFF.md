# OK Movers Handoff

Viimane uuendus: 2026-05-27
Staatus: WordPressi teema esmane scaffold on loodud, sisuränne ja live WordPressi sidumine on veel pooleli.

## Selle faili eesmärk

See fail peab olema projekti jooksev handoff-logi.

Iga järgmise muudatuse järel uuenda siin vähemalt neid punkte:
- mis muudeti
- millistes failides muudeti
- miks muudeti
- kuidas kontrolliti
- mis jäi veel pooleli

Kui töö liigub teise arvutisse, siis alusta alati sellest failist.

## Projekti eesmärk

Asendada olemasolev Nuxt.js frontend standardse, hooldatava WordPressi custom theme lahendusega.

Põhinõuded:
- ei mingit Nuxt/Vue/Next runtime sõltuvust produktsioonis
- WordPress custom theme
- ACF paindlike sisusektsioonide jaoks
- sisustruktuuri ja URL-loogika säilitamine nii palju kui mõistlik
- lihtne administreerimine kliendile
- tehniline SEO baas
- robots.txt, llms.txt, sitemap tugi

## Mis olemasolevast repo-st välja selgitati

Praegune Nuxt projekt on sisuliselt WordPressi sisu-proxy, mitte eraldiseisev rakendus.

Leitud peamised route'id:
- `/` homepage
- `/kolimisteenused`
- `/kolimisteenused/[slug]`
- `/lisateenused`
- `/lisateenused/[slug]`
- `/ladustamisteenused`
- `/ladustamisteenused/[slug]`
- `/kolimisnouanded`
- `/kolimisnouanded/[slug]`
- `/ettevottest`
- `/ettevottest/[slug]`
- `/hinnaparing`
- `/kontakt`

Leitud peamised taaskasutatavad frontend-osad:
- navbar
- footer
- sidebar menüüd
- homepage hero
- teenuste grid/plokid
- testimonial/review plokk
- nõuannete/artiklite plokk
- contact form
- quote form

Leitud WordPress/CMS sõltuvused:
- WordPress REST API: `https://cms.okmovers.ee/wp-json/wp/v2/`
- custom menu endpoint: `https://cms.okmovers.ee/wp-json/wp-api-menus/v2/menus/{id}`
- vormide väline endpoint vanas lahenduses: `https://emailservice.ermine.ee/contact` ja `https://emailservice.ermine.ee/quote`

Oluline järeldus:
- uus lahendus peab need frontend-proxy kihid eemaldama
- menüüd tuleb tuua WordPress native menüüde või page hierarchy peale
- vormid tuleb tuua WordPressi sisse või siduda kontrollitud pluginaga

## Soovitatud WordPressi ülesehitus

Valitud suund:
- WordPress custom theme
- PHP template failid
- ACF flexible content
- native WordPress menus
- native pages + posts
- minimaalne JavaScript
- ilma väliste CDN-ideta

Page model:
- Pages: avaleht, teenuste landingud, kontakt, hinnapäring, ettevõttest
- Posts: kolimisnõuanded / blogi artiklid
- Child pages: teenuse detaililehed ja vajadusel alajaotused

## Loodud failid

Root:
- `HANDOFF.md`
- `wordpress-theme/DEPLOYMENT.md`
- `wordpress-theme/robots.txt`
- `wordpress-theme/llms.txt`

Teema root:
- `wordpress-theme/okmovers/style.css`
- `wordpress-theme/okmovers/functions.php`
- `wordpress-theme/okmovers/header.php`
- `wordpress-theme/okmovers/footer.php`
- `wordpress-theme/okmovers/front-page.php`
- `wordpress-theme/okmovers/page.php`
- `wordpress-theme/okmovers/single.php`
- `wordpress-theme/okmovers/archive.php`
- `wordpress-theme/okmovers/index.php`

Inc failid:
- `wordpress-theme/okmovers/inc/setup.php`
- `wordpress-theme/okmovers/inc/helpers.php`
- `wordpress-theme/okmovers/inc/forms.php`
- `wordpress-theme/okmovers/inc/seo.php`
- `wordpress-theme/okmovers/inc/acf-fields.php`

Template parts:
- `wordpress-theme/okmovers/template-parts/content/page-header.php`
- `wordpress-theme/okmovers/template-parts/content/entry-card.php`
- `wordpress-theme/okmovers/template-parts/flexible/section-hero.php`
- `wordpress-theme/okmovers/template-parts/flexible/section-text_image.php`
- `wordpress-theme/okmovers/template-parts/flexible/section-services_grid.php`
- `wordpress-theme/okmovers/template-parts/flexible/section-benefits.php`
- `wordpress-theme/okmovers/template-parts/flexible/section-cta.php`
- `wordpress-theme/okmovers/template-parts/flexible/section-testimonials.php`
- `wordpress-theme/okmovers/template-parts/flexible/section-faq.php`
- `wordpress-theme/okmovers/template-parts/flexible/section-contact_block.php`
- `wordpress-theme/okmovers/template-parts/flexible/section-quote_form.php`
- `wordpress-theme/okmovers/template-parts/flexible/section-article_feed.php`

Assets:
- `wordpress-theme/okmovers/assets/css/main.css`
- `wordpress-theme/okmovers/assets/js/main.js`
- `wordpress-theme/okmovers/assets/img/.gitkeep`

## Mis täpselt implementeeriti

### 1. Theme bootstrap

Failid:
- `wordpress-theme/okmovers/style.css`
- `wordpress-theme/okmovers/functions.php`

Tehtud:
- loodi WordPress theme metadata
- ühendati theme failid `inc/` kataloogist

### 2. Theme setup ja asset loading

Fail:
- `wordpress-theme/okmovers/inc/setup.php`

Tehtud:
- registreeriti theme supportid
- registreeriti menüüd: primary, footer, legal
- lisati image sizes
- lisati CSS/JS enqueue
- lisati `body_class` abi
- lisati excerpt vaikeseaded

### 3. Helperid ja sektsioonide renderdus

Fail:
- `wordpress-theme/okmovers/inc/helpers.php`

Tehtud:
- ACF field helperid
- options helperid
- linkide normaliseerimine
- button render helper
- pildi URL helper
- flexible content render helper
- section navigation page hierarchy põhjal
- fallback teenused ja testimonialid
- kontaktandmete markup helper

### 4. Vormid toodi WordPressi sisse

Fail:
- `wordpress-theme/okmovers/inc/forms.php`

Tehtud:
- contact form handler `admin-post.php` kaudu
- quote form handler `admin-post.php` kaudu
- nonce kontrollid
- lihtne serveripoolne valideerimine
- `wp_mail()` põhine saatmine
- success/error redirect teated
- frontendi render helper nii kontakti kui hinnapäringu jaoks

Märkus:
- see asendab vana välise `emailservice.ermine.ee` sõltuvuse vähemalt baaslahendusena
- kui live keskkonnas on vaja pluginat või SMTP-d, tuleb see eraldi seadistada

### 5. SEO baas

Fail:
- `wordpress-theme/okmovers/inc/seo.php`

Tehtud:
- meta description fallback
- canonical URL output
- basic Open Graph väljad
- `noindex` ACF välja tugi
- kaitse, et kui Yoast või Rank Math on peal, siis dubleerimist ei tekiks

### 6. ACF field groupid

Fail:
- `wordpress-theme/okmovers/inc/acf-fields.php`

Tehtud:
- options page
- site settings väljad
- flexible content page builder
- SEO helper väljad

Registreeritud ACF sektsioonid:
- hero
- text + image
- services grid
- benefits
- CTA
- testimonials
- FAQ
- contact block
- quote form
- article feed

### 7. Template failid

Failid:
- `wordpress-theme/okmovers/front-page.php`
- `wordpress-theme/okmovers/page.php`
- `wordpress-theme/okmovers/single.php`
- `wordpress-theme/okmovers/archive.php`
- `wordpress-theme/okmovers/index.php`
- `wordpress-theme/okmovers/header.php`
- `wordpress-theme/okmovers/footer.php`

Tehtud:
- avalehe fallback layout ilma ACF sisuta
- lehtede layout flexible content või default content vaates
- blogi/post single mall
- archive mall
- header nav + kontaktid
- footer koos option väljade ja legal menu toega

### 8. Reusable template parts

Failid:
- `wordpress-theme/okmovers/template-parts/content/*`
- `wordpress-theme/okmovers/template-parts/flexible/*`

Tehtud:
- page header partial
- entry card partial
- kõik ACF flexible section partialid

### 9. CSS ja JS

Failid:
- `wordpress-theme/okmovers/assets/css/main.css`
- `wordpress-theme/okmovers/assets/js/main.js`

Tehtud:
- responsive base layout
- header/nav
- hero
- gridid
- sidebar nav
- forms
- footer
- FAQ toggle JS
- mobile menu JS

### 10. Deployment ja SEO lisafailid

Failid:
- `wordpress-theme/DEPLOYMENT.md`
- `wordpress-theme/robots.txt`
- `wordpress-theme/llms.txt`

Tehtud:
- deploymenti juhend
- robots.txt näidis
- llms.txt näidis

## ACF field groupide kokkuvõte

### Site Settings
- company_phone
- company_email
- company_address
- company_hours
- contact_recipient_email
- quote_recipient_email
- footer_left_column
- footer_middle_column
- footer_right_column
- social_links

### Page Builder
- page_sections
- hero: eyebrow, title, intro, primary_button, secondary_button, image, video_url
- text_image: title, text, image, image_position
- services_grid: title, intro, items
- benefits: title, intro, items
- cta: title, text, button
- testimonials: title, items
- faq: title, items
- contact_block: title, text, form_mode, form_shortcode
- quote_form: title, text
- article_feed: title, intro, category, count, button

### SEO
- seo_description
- canonical_url
- og_title
- og_description
- og_image
- noindex

## Valideerimine, mis juba tehti

Tehtud kontrollid:
- editor diagnostics: vigu ei leitud pärast helperi parandust
- `php -l` jooksutati kõigi `wordpress-theme/okmovers/**/*.php` failide peal

Tulemus:
- PHP syntax errors puuduvad

Ei ole veel kontrollitud:
- teema käitumine reaalses WordPressi installis
- ACF väljade tegelik nähtavus adminis
- `wp_mail()` toimimine hostingu peal
- responsive käitumine päris sisuga
- sitemap live saadavus

## Mis on praegu pooleli

Kõige olulisem pooleliolev töö:
- WordPressi päris installi sidumine puudub
- päris sisu ei ole veel migreeritud Nuxt/CMS struktuurist uude teemasse
- menüüd ei ole WordPressis veel loodud
- logo, featured image'd ja lõplik visuaalne polish vajavad päris sisu peal ülevaatust
- blogi/arhiivi URL-strateegia vajab kinnitamist
- võimalikud 301 redirectid vanadelt Nuxt route'idelt on kaardistamata

## Soovitatud järgmised sammud

Järgmine inimene / järgmine arvuti peaks tegema selles järjekorras:

1. Paigalda teema `wordpress-theme/okmovers` WordPressi `wp-content/themes/okmovers` alla.
2. Aktiveeri ACF.
3. Aktiveeri teema ja määra homepage.
4. Loo menüüd: primary, footer, legal.
5. Loo põhilehed:
   - Avaleht
   - Kolimisteenused
   - Hinnapäring
   - Ettevõttest
   - Kontakt
   - Kolimisnõuanded
6. Loo teenuste detailid child page-dena või kinnita, et osa neist läheb postideks.
7. Täida ACF options väljad.
8. Tõsta olemasolev sisu ACF flexible sectionitesse.
9. Testi kontakt- ja hinnapäringu vorme reaalses serveris.
10. Kontrolli canonicalid, meta descriptions, OG pildid, robots.txt ja sitemap.

## Otsused, mis vajavad kinnitamist

- kas teenuse detaililehed jäävad Page child page-deks või osa neist peaks olema CPT
- kas blogi/nõuanded kasutavad standardset `post` tüüpi või eraldi CPT-d
- kas vormid jäävad `wp_mail()` peale või minnakse üle vormiplugin + SMTP lahendusele
- kas kasutatakse SEO pluginat või jäädakse selle teema baas-SEO peale

## Jooksev muudatuste logi

### 2026-05-27 - WordPressi teema esmane scaffold

Muudeti:
- loodi uus WordPressi teema kataloogi `wordpress-theme/okmovers`
- loodi theme bootstrap, template failid, reusable section partialid, CSS/JS, ACF local field registration, forms, SEO baas
- lisati `robots.txt`, `llms.txt`, `DEPLOYMENT.md`

Peamised failid:
- `wordpress-theme/okmovers/functions.php`
- `wordpress-theme/okmovers/inc/setup.php`
- `wordpress-theme/okmovers/inc/helpers.php`
- `wordpress-theme/okmovers/inc/forms.php`
- `wordpress-theme/okmovers/inc/seo.php`
- `wordpress-theme/okmovers/inc/acf-fields.php`
- `wordpress-theme/okmovers/front-page.php`
- `wordpress-theme/okmovers/page.php`
- `wordpress-theme/okmovers/single.php`
- `wordpress-theme/okmovers/archive.php`
- `wordpress-theme/okmovers/assets/css/main.css`
- `wordpress-theme/okmovers/assets/js/main.js`

Põhjus:
- eemaldada sõltuvus Nuxt frontendist
- luua hallatav WordPressi alus, millele päris sisu peale tõsta

Kontroll:
- `php -l` kõigil PHP failidel
- editor diagnostics puhastati

Pooleli jäi:
- live WordPressi installis käivitamine
- sisu migratsioon
- menüüde ja permalinkide lõplik sidumine
- visuaalne viimistlus päris sisuga
