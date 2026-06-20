<?php
get_header();

$static_front_page_id = (int) get_option('page_on_front');
$source_page_id = (int) okmovers_get_option_field('front_page_source_page', 0);
$resolved_page_id = 0;

if ($static_front_page_id > 0) {
    $resolved_page_id = $static_front_page_id;
} elseif ($source_page_id > 0) {
    $resolved_page_id = $source_page_id;
}

$sections_by_layout = $resolved_page_id > 0 ? okmovers_get_flexible_sections_by_layout($resolved_page_id) : [];
$resolve_section = static function (string $layout, array $fallback) use ($sections_by_layout): array {
    if (! isset($sections_by_layout[$layout][0]) || ! is_array($sections_by_layout[$layout][0])) {
        return $fallback;
    }

    return array_replace_recursive($fallback, $sections_by_layout[$layout][0]);
};
$hidden_sections = okmovers_get_option_field('front_page_hidden_sections', []);
$hidden_sections = is_array($hidden_sections) ? array_map('sanitize_key', $hidden_sections) : [];
$is_hidden = static function (string $layout) use ($hidden_sections): bool {
    return in_array($layout, $hidden_sections, true);
};

$tips_parent_page = get_page_by_path('kolimisnouanded');
$tips_parent_page_id = $tips_parent_page instanceof WP_Post ? (int) $tips_parent_page->ID : 0;

if (! $is_hidden('hero')) {
    get_template_part('template-parts/flexible/section', 'hero', [
        'section' => $resolve_section('hero', [
            'eyebrow' => __('Kolimisteenused üle Eesti', 'okmovers'),
            'title' => __('Usaldusväärne kolimispartner kodudele ja ettevõtetele', 'okmovers'),
            'intro' => __('Rebuild the current OK Movers front page with native WordPress editing, selge sisustruktuur ja kiire hinnapäring.', 'okmovers'),
            'primary_button' => ['url' => home_url('/hinnaparing/'), 'title' => __('Esita hinnapäring', 'okmovers')],
            'secondary_button' => ['url' => home_url('/kolimisnouanded/'), 'title' => __('Vaata kolimisnõuandeid', 'okmovers')],
        ]),
    ]);
}

if (! $is_hidden('testimonials')) {
    get_template_part('template-parts/flexible/section', 'testimonials', [
        'section' => $resolve_section('testimonials', [
            'title' => __('Kliendid räägivad', 'okmovers'),
            'items' => okmovers_get_fallback_reviews(),
        ]),
    ]);
}

if (! $is_hidden('services_grid')) {
    get_template_part('template-parts/flexible/section', 'services_grid', [
        'section' => $resolve_section('services_grid', [
            'title' => __('Teenused', 'okmovers'),
            'intro' => __('Hoia peamised teenused ja maandumislehed selges WordPressi lehestruktuuris.', 'okmovers'),
            'items' => okmovers_get_fallback_services(),
        ]),
    ]);
}

if (! $is_hidden('benefits')) {
    get_template_part('template-parts/flexible/section', 'benefits', [
        'section' => $resolve_section('benefits', [
            'title' => __('Miks valida OK Movers', 'okmovers'),
            'intro' => __('Uus teema keskendub hallatavusele, kiirusele ja paremale kasutuskogemusele.', 'okmovers'),
            'items' => [
                ['title' => __('Selge haldus', 'okmovers'), 'text' => __('ACF sektsioonid teevad igast sisublokist eraldi muudetava osa.', 'okmovers')],
                ['title' => __('SEO baas', 'okmovers'), 'text' => __('Meta kirjeldused, canonical, Open Graph ja semantiline HTML on arvestatud.', 'okmovers')],
                ['title' => __('Ilma eraldi frontendita', 'okmovers'), 'text' => __('Nuxti runtime ja katkised proxy-kihid kaovad tootmisest.', 'okmovers')],
            ],
        ]),
    ]);
}

if (! $is_hidden('clients')) {
    get_template_part('template-parts/flexible/section', 'clients', [
        'section' => $resolve_section('clients', [
            'title' => __('Meie kliendid', 'okmovers'),
            'items' => okmovers_get_fallback_clients(),
        ]),
    ]);
}

if (! $is_hidden('tips_grid')) {
    get_template_part('template-parts/flexible/section', 'tips_grid', [
        'section' => $resolve_section('tips_grid', [
            'title' => __('Kolimisnõuanded', 'okmovers'),
            'intro' => __('Halda kolimisnõuandeid eraldi alalehtedena ja kuva need parent-lehe alt automaatselt.', 'okmovers'),
            'parent_page' => $tips_parent_page_id,
            'count' => 14,
            'button' => ['url' => home_url('/kolimisnouanded/'), 'title' => __('Kõik artiklid', 'okmovers')],
        ]),
    ]);
}

if (! $is_hidden('cta')) {
    get_template_part('template-parts/flexible/section', 'cta', [
        'section' => $resolve_section('cta', [
            'title' => __('Vajad kiiret hinnapakkumist?', 'okmovers'),
            'text' => __('Kasuta sisseehitatud hinnapäringu vormi või seo see eelistatud vormipluginaga shortcode kaudu.', 'okmovers'),
            'button' => ['url' => home_url('/hinnaparing/'), 'title' => __('Alusta siit', 'okmovers')],
        ]),
    ]);
}

get_footer();
