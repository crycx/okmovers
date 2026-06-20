<?php

function okmovers_get_field_value(string $field_name, ?int $post_id = null, $default = null)
{
    if (! function_exists('get_field')) {
        return $default;
    }

    $value = get_field($field_name, $post_id ?: get_the_ID());

    if ($value === null || $value === '') {
        return $default;
    }

    return $value;
}

function okmovers_get_option_field(string $field_name, $default = null)
{
    if (! function_exists('get_field')) {
        return $default;
    }

    $value = get_field($field_name, 'option');

    if ($value === null || $value === '') {
        return $default;
    }

    return $value;
}

function okmovers_primary_menu_fallback(): void
{
    echo '<ul class="site-navigation__menu">';
    wp_list_pages([
        'title_li'    => '',
        'depth'       => 1,
        'sort_column' => 'menu_order,post_title',
    ]);
    echo '</ul>';
}

function okmovers_normalize_link($link, array $fallback = []): array
{
    if (is_array($link) && !empty($link['url'])) {
        return [
            'url'    => $link['url'],
            'title'  => $link['title'] ?? $fallback['title'] ?? __('Learn more', 'okmovers'),
            'target' => $link['target'] ?? $fallback['target'] ?? '_self',
        ];
    }

    return [
        'url'    => '',
        'title'  => $fallback['title'] ?? __('Learn more', 'okmovers'),
        'target' => $fallback['target'] ?? '_self',
    ];
}

function okmovers_render_button($link, string $class_name = 'button button-primary'): void
{
    $button = okmovers_normalize_link($link);

    if (empty($button['url']) || $button['url'] === '#') {
        return;
    }
    ?>
    <a class="<?php echo esc_attr($class_name); ?>" href="<?php echo esc_url($button['url']); ?>" target="<?php echo esc_attr($button['target']); ?>">
        <?php echo esc_html($button['title']); ?>
    </a>
    <?php
}

function okmovers_get_image_url($image, string $size = 'full'): string
{
    if (is_array($image) && ! empty($image['sizes'][$size])) {
        return (string) $image['sizes'][$size];
    }

    if (is_array($image) && ! empty($image['url'])) {
        return (string) $image['url'];
    }

    if (is_numeric($image)) {
        $url = wp_get_attachment_image_url((int) $image, $size);

        return $url ?: '';
    }

    return '';
}

function okmovers_get_embed_video_url(string $url): string
{
    $raw_url = trim($url);

    if ($raw_url === '') {
        return '';
    }

    $sanitized_url = esc_url_raw($raw_url);

    if ($sanitized_url === '') {
        return '';
    }

    $parts = wp_parse_url($sanitized_url);
    $host = strtolower((string) ($parts['host'] ?? ''));
    $path = (string) ($parts['path'] ?? '');
    $query = (string) ($parts['query'] ?? '');

    parse_str($query, $query_args);

    if (strpos($host, 'youtube.com') !== false || strpos($host, 'youtu.be') !== false) {
        $video_id = '';

        if (! empty($query_args['v'])) {
            $video_id = (string) $query_args['v'];
        } elseif (strpos($host, 'youtu.be') !== false) {
            $video_id = trim($path, '/');
        } elseif (preg_match('#^/embed/([^/?]+)#', $path, $matches) === 1) {
            $video_id = (string) $matches[1];
        } elseif (preg_match('#^/shorts/([^/?]+)#', $path, $matches) === 1) {
            $video_id = (string) $matches[1];
        }

        $video_id = preg_replace('/[^A-Za-z0-9_-]/', '', $video_id ?: '');

        if ($video_id === '') {
            return '';
        }

        return 'https://www.youtube.com/embed/' . $video_id . '?rel=0';
    }

    if (strpos($host, 'vimeo.com') !== false) {
        $segments = array_values(array_filter(explode('/', trim($path, '/'))));
        $video_id = '';

        foreach ($segments as $segment) {
            if (ctype_digit($segment)) {
                $video_id = $segment;
                break;
            }
        }

        if ($video_id === '') {
            return '';
        }

        return 'https://player.vimeo.com/video/' . $video_id;
    }

    if (strpos($path, '/embed/') !== false) {
        return $sanitized_url;
    }

    return '';
}

function okmovers_has_flexible_sections(?int $post_id = null): bool
{
    $post_id = $post_id ?: get_the_ID();

    if (! function_exists('have_rows')) {
        return false;
    }

    return have_rows('page_sections', $post_id);
}

function okmovers_render_flexible_sections(?int $post_id = null): void
{
    $post_id = $post_id ?: get_the_ID();

    if (
        ! function_exists('have_rows')
        || ! function_exists('the_row')
        || ! function_exists('get_row_layout')
        || ! have_rows('page_sections', $post_id)
    ) {
        return;
    }

    while (have_rows('page_sections', $post_id)) {
        call_user_func('the_row');

        $layout = (string) call_user_func('get_row_layout');
        get_template_part('template-parts/flexible/section', $layout, [
            'post_id' => $post_id,
        ]);
    }
}

function okmovers_get_flexible_sections_by_layout(?int $post_id = null): array
{
    $post_id = $post_id ?: get_the_ID();

    if (! function_exists('get_field') || ! $post_id) {
        return [];
    }

    $rows = get_field('page_sections', $post_id);

    if (! is_array($rows) || empty($rows)) {
        return [];
    }

    $sections = [];

    foreach ($rows as $row) {
        if (! is_array($row)) {
            continue;
        }

        $layout = sanitize_key((string) ($row['acf_fc_layout'] ?? ''));

        if ($layout === '') {
            continue;
        }

        unset($row['acf_fc_layout']);
        $sections[$layout][] = $row;
    }

    return $sections;
}

function okmovers_should_show_section_tags(): bool
{
    return is_user_logged_in() && current_user_can('manage_options');
}

function okmovers_render_section_title(string $title, string $tag = '', string $level = 'h2', string $class_name = ''): void
{
    $allowed_levels = ['h1', 'h2', 'h3'];
    $heading_level = in_array($level, $allowed_levels, true) ? $level : 'h2';
    $classes = trim('section-title-with-tag ' . $class_name);

    echo '<' . esc_html($heading_level) . ' class="' . esc_attr($classes) . '">';
    echo esc_html($title);

    if ($tag !== '' && okmovers_should_show_section_tags()) {
        echo ' <span class="section-layout-tag" aria-hidden="true">#' . esc_html(sanitize_key($tag)) . '</span>';
    }

    echo '</' . esc_html($heading_level) . '>';
}

function okmovers_get_page_root_id(int $post_id): int
{
    $ancestors = get_post_ancestors($post_id);

    if (! empty($ancestors)) {
        return (int) end($ancestors);
    }

    return $post_id;
}

function okmovers_has_section_navigation(?int $post_id = null): bool
{
    $post_id = $post_id ?: get_the_ID();

    if (! $post_id || get_post_type($post_id) !== 'page') {
        return false;
    }

    $root_id = okmovers_get_page_root_id($post_id);
    $menu_items = okmovers_get_section_navigation_menu_items($root_id);

    if (! empty($menu_items)) {
        return true;
    }

    $children = get_pages([
        'child_of'    => $root_id,
        'parent'      => $root_id,
        'sort_column' => 'menu_order,post_title',
    ]);

    return ! empty($children);
}

function okmovers_get_menu_page_order_map(int $menu_id): array
{
    static $cache = [];

    if (isset($cache[$menu_id])) {
        return $cache[$menu_id];
    }

    $cache[$menu_id] = [];

    if (! $menu_id || ! function_exists('wp_get_nav_menu_items')) {
        return $cache[$menu_id];
    }

    $items = wp_get_nav_menu_items($menu_id, [
        'update_post_term_cache' => false,
    ]);

    if (! is_array($items) || empty($items)) {
        return $cache[$menu_id];
    }

    foreach ($items as $index => $item) {
        if (! isset($item->object_id)) {
            continue;
        }

        $page_id = (int) $item->object_id;

        if ($page_id > 0 && ! isset($cache[$menu_id][$page_id])) {
            $cache[$menu_id][$page_id] = $index;
        }
    }

    return $cache[$menu_id];
}

function okmovers_find_section_navigation_menu_id(int $root_id): int
{
    static $cache = [];

    if (isset($cache[$root_id])) {
        return $cache[$root_id];
    }

    $cache[$root_id] = 0;

    if (! function_exists('wp_get_nav_menus')) {
        return $cache[$root_id];
    }

    $root_title = trim((string) get_the_title($root_id));
    $candidate_names = array_filter([
        $root_title !== '' ? $root_title . ' külgriba' : '',
        $root_title !== '' ? $root_title . ' kulgriba' : '',
        $root_title,
    ]);
    $candidate_slugs = array_unique(array_filter(array_map('sanitize_title', $candidate_names)));
    $menus = wp_get_nav_menus();

    if (is_array($menus)) {
        foreach ($candidate_names as $candidate_index => $candidate_name) {
            $candidate_slug = $candidate_slugs[$candidate_index] ?? sanitize_title($candidate_name);

            foreach ($menus as $menu) {
                $menu_name = isset($menu->name) ? trim((string) $menu->name) : '';
                $menu_slug = isset($menu->slug) ? (string) $menu->slug : '';

                if ($menu_name === $candidate_name || $menu_slug === $candidate_slug) {
                    $cache[$root_id] = isset($menu->term_id) ? (int) $menu->term_id : 0;
                    return $cache[$root_id];
                }
            }
        }
    }

    return $cache[$root_id];
}

function okmovers_get_section_navigation_page_order_map(int $root_id): array
{
    $menu_id = okmovers_find_section_navigation_menu_id($root_id);

    if (! $menu_id) {
        return [];
    }

    return okmovers_get_menu_page_order_map($menu_id);
}

function okmovers_get_section_navigation_menu_items(int $root_id): array
{
    $menu_id = okmovers_find_section_navigation_menu_id($root_id);

    if (! $menu_id || ! function_exists('wp_get_nav_menu_items')) {
        return [];
    }

    $items = wp_get_nav_menu_items($menu_id, [
        'update_post_term_cache' => false,
    ]);

    if (! is_array($items) || empty($items)) {
        return [];
    }

    $root_permalink = untrailingslashit((string) get_permalink($root_id));
    $filtered_items = [];

    foreach ($items as $item) {
        $item_object_id = isset($item->object_id) ? (int) $item->object_id : 0;
        $item_url = isset($item->url) ? untrailingslashit((string) $item->url) : '';

        if ($item_object_id === $root_id || ($root_permalink !== '' && $item_url === $root_permalink)) {
            continue;
        }

        $filtered_items[] = $item;
    }

    return $filtered_items;
}

function okmovers_is_section_navigation_menu_item_current($item, int $post_id): bool
{
    $item_object_id = isset($item->object_id) ? (int) $item->object_id : 0;

    if ($item_object_id > 0 && $item_object_id === $post_id) {
        return true;
    }

    $item_url = isset($item->url) ? untrailingslashit((string) $item->url) : '';
    $current_url = untrailingslashit((string) get_permalink($post_id));

    return $item_url !== '' && $current_url !== '' && $item_url === $current_url;
}

function okmovers_sort_pages_by_section_menu_order(array $pages, int $root_id): array
{
    if (empty($pages)) {
        return $pages;
    }

    $order_map = okmovers_get_section_navigation_page_order_map($root_id);

    if (empty($order_map)) {
        return $pages;
    }

    usort($pages, static function ($a, $b) use ($order_map): int {
        $a_id = isset($a->ID) ? (int) $a->ID : 0;
        $b_id = isset($b->ID) ? (int) $b->ID : 0;

        $a_pos = $order_map[$a_id] ?? PHP_INT_MAX;
        $b_pos = $order_map[$b_id] ?? PHP_INT_MAX;

        if ($a_pos === $b_pos) {
            return strcasecmp((string) ($a->post_title ?? ''), (string) ($b->post_title ?? ''));
        }

        return $a_pos <=> $b_pos;
    });

    return $pages;
}

function okmovers_render_section_navigation(?int $post_id = null): void
{
    $post_id = $post_id ?: get_the_ID();

    if (! okmovers_has_section_navigation($post_id)) {
        return;
    }

    $root_id = okmovers_get_page_root_id($post_id);
    $nav_id = 'section-nav-' . $root_id;
    $menu_items = okmovers_get_section_navigation_menu_items($root_id);
    $children = [];

    if (empty($menu_items)) {
        $children = get_pages([
            'child_of'    => $root_id,
            'parent'      => $root_id,
            'sort_column' => 'menu_order,post_title',
        ]);
        $children = okmovers_sort_pages_by_section_menu_order($children, $root_id);
    }

    $is_root_current = $post_id === $root_id;
    ?>
    <button class="section-nav-toggle" type="button" aria-expanded="false" aria-controls="<?php echo esc_attr($nav_id); ?>">
        <?php esc_html_e('Ava alammenüü', 'okmovers'); ?>
    </button>
    <aside class="section-nav" id="<?php echo esc_attr($nav_id); ?>" aria-label="<?php esc_attr_e('Section navigation', 'okmovers'); ?>">
        <p class="section-nav__label">
            <a class="section-nav__label-link<?php echo $is_root_current ? ' is-current' : ''; ?>" href="<?php echo esc_url(get_permalink($root_id)); ?>">
                <?php echo esc_html(get_the_title($root_id)); ?>
            </a>
        </p>
        <ul class="section-nav__list">
            <?php if (! empty($menu_items)) : ?>
                <?php foreach ($menu_items as $item) : ?>
                    <li class="section-nav__item<?php echo okmovers_is_section_navigation_menu_item_current($item, $post_id) ? ' is-current' : ''; ?>">
                        <a href="<?php echo esc_url((string) ($item->url ?? '')); ?>"><?php echo esc_html((string) ($item->title ?? '')); ?></a>
                    </li>
                <?php endforeach; ?>
            <?php else : ?>
                <?php foreach ($children as $child) : ?>
                    <li class="section-nav__item<?php echo $post_id === (int) $child->ID ? ' is-current' : ''; ?>">
                        <a href="<?php echo esc_url(get_permalink($child)); ?>"><?php echo esc_html($child->post_title); ?></a>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </aside>
    <?php
}

function okmovers_get_contact_details_markup(): string
{
    $phone = okmovers_get_option_field('company_phone', '+372 504 7187');
    $email = okmovers_get_option_field('company_email', 'info@okmovers.ee');
    $address = okmovers_get_option_field('company_address', 'Tallinn, Eesti');
    $registration_code = okmovers_get_option_field('company_registration_code', '11428959');
    $kmkr_code = okmovers_get_option_field('company_kmkr_code', 'EE101185934');
    // $hours = okmovers_get_option_field('company_hours', __('Mon-Fri 08:00-18:00', 'okmovers'));

    $items = [
        '<p><strong>' . esc_html__('Telefon', 'okmovers') . ':</strong> <a href="tel:' . esc_attr(preg_replace('/\s+/', '', (string) $phone)) . '">' . esc_html($phone) . '</a></p>',
        '<p><strong>' . esc_html__('E-post', 'okmovers') . ':</strong> <a href="mailto:' . esc_attr($email) . '">' . esc_html($email) . '</a></p>',
        '<p><strong>' . esc_html__('Aadress', 'okmovers') . ':</strong> ' . esc_html($address) . '</p>',
        '<p><strong>' . esc_html__('Registrikood', 'okmovers') . ':</strong> ' . esc_html($registration_code) . '</p>',
        '<p><strong>' . esc_html__('KMKR nr', 'okmovers') . ':</strong> ' . esc_html($kmkr_code) . '</p>',
        // '<p><strong>' . esc_html__('Lahtiolekuajad', 'okmovers') . ':</strong> ' . esc_html($hours) . '</p>',
    ];

    return implode('', $items);
}

function okmovers_get_social_links(): array
{
    $links = okmovers_get_option_field('social_links', []);

    return is_array($links) ? $links : [];
}

function okmovers_get_fallback_reviews(): array
{
    return [
        // [
        //     'quote'  => __('Töö oli täpne, kiire ja kogu protsess sujus ilma stressita. Soovitame.', 'okmovers'),
        //     'author' => 'OK Movers klient',
        //     'role'   => __('Kodukolimine', 'okmovers'),
        //     'image'  => [],
        // ],
        // [
        //     'quote'  => __('Meeskond saabus õigel ajal, pakkis hoolikalt ja suhtlus oli väga selge.', 'okmovers'),
        //     'author' => 'OK Movers klient',
        //     'role'   => __('Kontori kolimine', 'okmovers'),
        //     'image'  => [],
        // ],
        // [
        //     'quote'  => __('Hinnapäringule vastati kiiresti ja teenus vastas täpselt kokkulepitule.', 'okmovers'),
        //     'author' => 'OK Movers klient',
        //     'role'   => __('Rahvusvaheline kolimine', 'okmovers'),
        //     'image'  => [],
        // ],
    ];
}

function okmovers_get_fallback_clients(): array
{
    return [
        [
            'name' => 'Horton International Eesti',
            'logo' => [],
            'link' => ['url' => home_url('/ettevottest/'), 'title' => __('Klient', 'okmovers')],
        ],
        [
            'name' => 'Bayer OÜ',
            'logo' => [],
            'link' => ['url' => home_url('/ettevottest/'), 'title' => __('Klient', 'okmovers')],
        ],
        [
            'name' => 'Advokaadibüroo VARUL',
            'logo' => [],
            'link' => ['url' => home_url('/ettevottest/'), 'title' => __('Klient', 'okmovers')],
        ],
        [
            'name' => 'Datel AS',
            'logo' => [],
            'link' => ['url' => home_url('/ettevottest/'), 'title' => __('Klient', 'okmovers')],
        ],
        [
            'name' => 'Kalev Spa',
            'logo' => [],
            'link' => ['url' => home_url('/ettevottest/'), 'title' => __('Klient', 'okmovers')],
        ],
        [
            'name' => 'Kalev Chocolate Factory',
            'logo' => [],
            'link' => ['url' => home_url('/ettevottest/'), 'title' => __('Klient', 'okmovers')],
        ],
    ];
}

function okmovers_get_fallback_services(): array
{
    return [
        [
            'title' => __('Kolimisteenused erakliendile', 'okmovers'),
            'text'  => __('Korterite, majade ja üksikute esemete kolimine üle Eesti.', 'okmovers'),
            'link'  => ['url' => home_url('/kolimisteenused/'), 'title' => __('Vaata teenuseid', 'okmovers')],
        ],
        [
            'title' => __('Kolimisteenused ettevõtetele', 'okmovers'),
            'text'  => __('Kontorite, ladude ja töökohtade kolimised minimaalse seisakuga.', 'okmovers'),
            'link'  => ['url' => home_url('/ettevottest/'), 'title' => __('Loe lähemalt', 'okmovers')],
        ],
        [
            'title' => __('Pakkimine ja ladustamine', 'okmovers'),
            'text'  => __('Pakkematerjalid, pakkimisteenus ja turvaline ajutine hoiustamine.', 'okmovers'),
            'link'  => ['url' => home_url('/ladustamisteenused/'), 'title' => __('Vaata võimalusi', 'okmovers')],
        ],
    ];
}
