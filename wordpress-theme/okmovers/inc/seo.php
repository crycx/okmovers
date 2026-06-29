<?php

add_action('wp_head', 'okmovers_output_meta_tags', 1);
function okmovers_output_meta_tags(): void
{
    if (is_admin() || defined('WPSEO_VERSION') || defined('RANK_MATH_VERSION')) {
        return;
    }

    $post_id = get_queried_object_id();

    if (! $post_id || ! is_singular()) {
        return;
    }

    $meta_description = okmovers_get_field_value('seo_description', $post_id, '');

    if (! $meta_description) {
        if (has_excerpt($post_id)) {
            $meta_description = get_the_excerpt($post_id);
        } else {
            $meta_description = wp_trim_words(wp_strip_all_tags((string) get_post_field('post_content', $post_id)), 30);
        }
    }

    $canonical = okmovers_get_field_value('canonical_url', $post_id, get_permalink($post_id));
    $og_title = okmovers_get_field_value('og_title', $post_id, get_the_title($post_id));
    $og_description = okmovers_get_field_value('og_description', $post_id, $meta_description);
    $og_image = okmovers_get_image_url(okmovers_get_field_value('og_image', $post_id, get_post_thumbnail_id($post_id)), 'okmovers-hero');
    $noindex = (bool) okmovers_get_field_value('noindex', $post_id, false);

    if ($meta_description) {
        echo '<meta name="description" content="' . esc_attr($meta_description) . '">' . "\n";
    }

    if ($canonical) {
        echo '<link rel="canonical" href="' . esc_url($canonical) . '">' . "\n";
    }

    if ($noindex) {
        echo '<meta name="robots" content="noindex,follow">' . "\n";
    }

    echo '<meta property="og:type" content="article">' . "\n";
    echo '<meta property="og:title" content="' . esc_attr($og_title) . '">' . "\n";
    echo '<meta property="og:description" content="' . esc_attr($og_description) . '">' . "\n";
    echo '<meta property="og:url" content="' . esc_url(get_permalink($post_id)) . '">' . "\n";

    if ($og_image) {
        echo '<meta property="og:image" content="' . esc_url($og_image) . '">' . "\n";
    }
}

add_action('wp_head', 'okmovers_output_json_ld', 2);
function okmovers_output_json_ld(): void
{
    if (is_admin()) {
        return;
    }

    $json_ld = okmovers_get_json_ld_graph();

    if (empty($json_ld['@graph'])) {
        return;
    }

    echo '<script type="application/ld+json">' . wp_json_encode($json_ld, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
}

function okmovers_get_json_ld_graph(): array
{
    $home_url = home_url('/');
    $organization_id = trailingslashit($home_url) . '#organization';
    $website_id = trailingslashit($home_url) . '#website';
    $site_name = get_bloginfo('name') ?: 'OK Movers';
    $description = get_bloginfo('description');
    $language = get_bloginfo('language') ?: 'et';

    $phone = okmovers_get_option_field('company_phone', '+372 504 7187');
    $email = okmovers_get_option_field('company_email', 'info@okmovers.ee');
    $address = okmovers_get_option_field('company_address', 'Tallinn, Eesti');
    $registration_code = okmovers_get_option_field('company_registration_code', '11428959');
    $kmkr_code = okmovers_get_option_field('company_kmkr_code', 'EE101185934');
    $social_links = array_values(array_filter(array_map(static function ($social_link): string {
        return is_array($social_link) ? esc_url_raw((string) ($social_link['url'] ?? '')) : '';
    }, okmovers_get_social_links())));

    $organization = okmovers_remove_empty_schema_values([
        '@type' => 'MovingCompany',
        '@id' => $organization_id,
        'name' => $site_name,
        'url' => $home_url,
        'description' => $description,
        'telephone' => $phone,
        'email' => $email,
        'address' => okmovers_remove_empty_schema_values([
            '@type' => 'PostalAddress',
            'streetAddress' => $address,
            'addressLocality' => 'Tallinn',
            'addressCountry' => 'EE',
        ]),
        'areaServed' => [
            [
                '@type' => 'Country',
                'name' => 'Eesti',
            ],
        ],
        'identifier' => $registration_code,
        'vatID' => $kmkr_code,
        'sameAs' => $social_links,
    ]);

    $website = okmovers_remove_empty_schema_values([
        '@type' => 'WebSite',
        '@id' => $website_id,
        'url' => $home_url,
        'name' => $site_name,
        'description' => $description,
        'inLanguage' => $language,
        'publisher' => [
            '@id' => $organization_id,
        ],
    ]);

    $graph = [$organization, $website];
    $webpage = okmovers_get_webpage_schema($website_id, $organization_id, $language);

    if (! empty($webpage)) {
        $graph[] = $webpage;
    }

    return [
        '@context' => 'https://schema.org',
        '@graph' => $graph,
    ];
}

function okmovers_get_webpage_schema(string $website_id, string $organization_id, string $language): array
{
    $post_id = get_queried_object_id();

    if (! $post_id || ! is_singular()) {
        return [];
    }

    $permalink = get_permalink($post_id);
    $description = okmovers_get_field_value('seo_description', $post_id, '');

    if (! $description) {
        $description = has_excerpt($post_id)
            ? get_the_excerpt($post_id)
            : wp_trim_words(wp_strip_all_tags((string) get_post_field('post_content', $post_id)), 30);
    }

    $image = okmovers_get_image_url(okmovers_get_field_value('og_image', $post_id, get_post_thumbnail_id($post_id)), 'full');
    $schema_type = get_post_type($post_id) === 'post' ? 'Article' : 'WebPage';
    $faq_items = okmovers_get_faq_schema_items($post_id);

    if (! empty($faq_items) && $schema_type === 'WebPage') {
        $schema_type = ['WebPage', 'FAQPage'];
    }

    return okmovers_remove_empty_schema_values([
        '@type' => $schema_type,
        '@id' => $permalink . '#webpage',
        'url' => $permalink,
        'name' => get_the_title($post_id),
        'description' => $description,
        'inLanguage' => $language,
        'isPartOf' => [
            '@id' => $website_id,
        ],
        'about' => [
            '@id' => $organization_id,
        ],
        'datePublished' => get_the_date(DATE_W3C, $post_id),
        'dateModified' => get_the_modified_date(DATE_W3C, $post_id),
        'primaryImageOfPage' => $image ? [
            '@type' => 'ImageObject',
            'url' => $image,
        ] : [],
        'mainEntity' => $faq_items,
    ]);
}

function okmovers_get_faq_schema_items(int $post_id): array
{
    $sections = okmovers_get_flexible_sections_by_layout($post_id);
    $faq_sections = $sections['faq'] ?? [];

    if (empty($faq_sections)) {
        return [];
    }

    $items = [];

    foreach ($faq_sections as $section) {
        if (empty($section['items']) || ! is_array($section['items'])) {
            continue;
        }

        foreach ($section['items'] as $item) {
            $question = trim(wp_strip_all_tags((string) ($item['question'] ?? '')));
            $answer = trim(wp_strip_all_tags((string) ($item['answer'] ?? '')));

            if ($question === '' || $answer === '') {
                continue;
            }

            $items[] = [
                '@type' => 'Question',
                'name' => $question,
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $answer,
                ],
            ];
        }
    }

    return $items;
}

function okmovers_remove_empty_schema_values(array $data): array
{
    foreach ($data as $key => $value) {
        if (is_array($value)) {
            $value = okmovers_remove_empty_schema_values($value);
        }

        if ($value === '' || $value === null || $value === []) {
            unset($data[$key]);
            continue;
        }

        $data[$key] = $value;
    }

    return $data;
}
