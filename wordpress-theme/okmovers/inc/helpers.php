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

function okmovers_normalize_link($link, array $fallback = []): array
{
    if (is_array($link) && ! empty($link['url'])) {
        return [
            'url'    => $link['url'],
            'title'  => $link['title'] ?? __('Learn more', 'okmovers'),
            'target' => $link['target'] ?? '_self',
        ];
    }

    return [
        'url'    => $fallback['url'] ?? '#',
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
    $children = get_pages([
        'child_of'    => $root_id,
        'parent'      => $root_id,
        'sort_column' => 'menu_order,post_title',
    ]);

    return ! empty($children);
}

function okmovers_render_section_navigation(?int $post_id = null): void
{
    $post_id = $post_id ?: get_the_ID();

    if (! okmovers_has_section_navigation($post_id)) {
        return;
    }

    $root_id = okmovers_get_page_root_id($post_id);
    $children = get_pages([
        'child_of'    => $root_id,
        'parent'      => $root_id,
        'sort_column' => 'menu_order,post_title',
    ]);
    ?>
    <aside class="section-nav" aria-label="<?php esc_attr_e('Section navigation', 'okmovers'); ?>">
        <p class="section-nav__label"><?php echo esc_html(get_the_title($root_id)); ?></p>
        <ul class="section-nav__list">
            <li class="section-nav__item<?php echo $post_id === $root_id ? ' is-current' : ''; ?>">
                <a href="<?php echo esc_url(get_permalink($root_id)); ?>"><?php echo esc_html(get_the_title($root_id)); ?></a>
            </li>
            <?php foreach ($children as $child) : ?>
                <li class="section-nav__item<?php echo $post_id === (int) $child->ID ? ' is-current' : ''; ?>">
                    <a href="<?php echo esc_url(get_permalink($child)); ?>"><?php echo esc_html($child->post_title); ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </aside>
    <?php
}

function okmovers_get_contact_details_markup(): string
{
    $phone = okmovers_get_option_field('company_phone', '+372 504 7187');
    $email = okmovers_get_option_field('company_email', 'info@okmovers.ee');
    $address = okmovers_get_option_field('company_address', 'Tallinn, Eesti');
    $hours = okmovers_get_option_field('company_hours', __('Mon-Fri 08:00-18:00', 'okmovers'));

    $items = [
        '<p><strong>' . esc_html__('Telefon', 'okmovers') . ':</strong> <a href="tel:' . esc_attr(preg_replace('/\s+/', '', (string) $phone)) . '">' . esc_html($phone) . '</a></p>',
        '<p><strong>' . esc_html__('E-post', 'okmovers') . ':</strong> <a href="mailto:' . esc_attr($email) . '">' . esc_html($email) . '</a></p>',
        '<p><strong>' . esc_html__('Aadress', 'okmovers') . ':</strong> ' . esc_html($address) . '</p>',
        '<p><strong>' . esc_html__('Lahtiolekuajad', 'okmovers') . ':</strong> ' . esc_html($hours) . '</p>',
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
        [
            'quote'  => __('Töö oli täpne, kiire ja kogu protsess sujus ilma stressita. Soovitame.', 'okmovers'),
            'author' => 'OK Movers klient',
            'role'   => __('Kodukolimine', 'okmovers'),
        ],
        [
            'quote'  => __('Meeskond saabus õigel ajal, pakkis hoolikalt ja suhtlus oli väga selge.', 'okmovers'),
            'author' => 'OK Movers klient',
            'role'   => __('Kontori kolimine', 'okmovers'),
        ],
        [
            'quote'  => __('Hinnapäringule vastati kiiresti ja teenus vastas täpselt kokkulepitule.', 'okmovers'),
            'author' => 'OK Movers klient',
            'role'   => __('Rahvusvaheline kolimine', 'okmovers'),
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
