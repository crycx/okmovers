<?php
get_header();

if (have_posts()) {
    the_post();
}

if (okmovers_has_flexible_sections(get_the_ID())) {
    okmovers_render_flexible_sections(get_the_ID());
} else {
    get_template_part('template-parts/flexible/section', 'hero', [
        'section' => [
            'eyebrow' => __('Kolimisteenused ule Eesti', 'okmovers'),
            'title' => __('Usaldusvaarne kolimispartner kodudele ja ettevotetele', 'okmovers'),
            'intro' => __('Rebuild the current OK Movers front page with native WordPress editing, selge sisustruktuur ja kiire hinnaparing.', 'okmovers'),
            'primary_button' => ['url' => home_url('/hinnaparing/'), 'title' => __('Esita hinnaparing', 'okmovers')],
            'secondary_button' => ['url' => home_url('/kolimisnouanded/'), 'title' => __('Vaata kolimisnouandeid', 'okmovers')],
        ],
    ]);

    get_template_part('template-parts/flexible/section', 'services_grid', [
        'section' => [
            'title' => __('Teenused', 'okmovers'),
            'intro' => __('Hoia peamised teenused ja maandumislehed selges WordPressi lehestruktuuris.', 'okmovers'),
            'items' => okmovers_get_fallback_services(),
        ],
    ]);

    get_template_part('template-parts/flexible/section', 'benefits', [
        'section' => [
            'title' => __('Miks valida OK Movers', 'okmovers'),
            'intro' => __('Uus teema keskendub hallatavusele, kiirusele ja paremale kasutuskogemusele.', 'okmovers'),
            'items' => [
                ['title' => __('Selge haldus', 'okmovers'), 'text' => __('ACF sektsioonid teevad igast sisublokist eraldi muudetava osa.', 'okmovers')],
                ['title' => __('SEO baas', 'okmovers'), 'text' => __('Meta kirjeldused, canonical, Open Graph ja semantiline HTML on arvestatud.', 'okmovers')],
                ['title' => __('Ilma eraldi frontendita', 'okmovers'), 'text' => __('Nuxti runtime ja katkised proxy-kihid kaovad tootmisest.', 'okmovers')],
            ],
        ],
    ]);

    get_template_part('template-parts/flexible/section', 'testimonials', [
        'section' => [
            'title' => __('Kliendid raagivad', 'okmovers'),
            'items' => okmovers_get_fallback_reviews(),
        ],
    ]);

    get_template_part('template-parts/flexible/section', 'article_feed', [
        'section' => [
            'title' => __('Kolimisnouanded', 'okmovers'),
            'intro' => __('Kasuta WordPressi standardseid postitusi blogi ja nouannete jaoks.', 'okmovers'),
            'count' => 3,
            'button' => ['url' => get_post_type_archive_link('post') ?: home_url('/blogi/'), 'title' => __('Koik artiklid', 'okmovers')],
        ],
    ]);

    get_template_part('template-parts/flexible/section', 'cta', [
        'section' => [
            'title' => __('Vajad kiiret hinnapakkumist?', 'okmovers'),
            'text' => __('Kasuta sisseehitatud hinnaparingu vormi voi seo see eelistatud vormipluginaga shortcode kaudu.', 'okmovers'),
            'button' => ['url' => home_url('/hinnaparing/'), 'title' => __('Alusta siit', 'okmovers')],
        ],
    ]);
}

get_footer();
