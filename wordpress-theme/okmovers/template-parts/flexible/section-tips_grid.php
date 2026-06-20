<?php
$section = $args['section'] ?? [
    'title' => okmovers_get_field_value('title', null, __('Kolimisnouanded', 'okmovers')),
    'intro' => okmovers_get_field_value('intro', null, ''),
    'parent_page' => okmovers_get_field_value('parent_page', null, 0),
    'count' => (int) okmovers_get_field_value('count', null, 14),
    'button' => okmovers_get_field_value('button', null, [
        'url' => home_url('/kolimisnouanded/'),
        'title' => __('Koik artiklid', 'okmovers'),
    ]),
];

$limit = max(1, min(24, (int) ($section['count'] ?? 14)));
$parent_page_id = (int) ($section['parent_page'] ?? 0);

if ($parent_page_id <= 0) {
    $fallback_parent = get_page_by_path('kolimisnouanded');

    if ($fallback_parent instanceof WP_Post) {
        $parent_page_id = (int) $fallback_parent->ID;
    }
}

$tips = [];

if ($parent_page_id > 0) {
    $tips = get_pages([
        'child_of' => $parent_page_id,
        'parent' => $parent_page_id,
        'sort_column' => 'menu_order,post_title',
        'number' => $limit,
    ]);
}
?>
<section class="page-section page-section--muted">
    <div class="container stack-lg">
        <div class="section-heading stack-sm">
            <?php okmovers_render_section_title((string) ($section['title'] ?? ''), 'tips_grid'); ?>
            <?php if (! empty($section['intro'])) : ?>
                <div class="section-intro prose"><?php echo wp_kses_post((string) $section['intro']); ?></div>
            <?php endif; ?>
        </div>

        <?php if (! empty($tips)) : ?>
            <div class="tips-grid">
                <?php foreach ($tips as $tip_page) : ?>
                    <?php
                    $tip_id = (int) $tip_page->ID;
                    $thumbnail_url = get_the_post_thumbnail_url($tip_id, 'thumbnail');
                    $tip_title = get_the_title($tip_id);
                    ?>
                    <article class="tip-card">
                        <a class="tip-card__link" href="<?php echo esc_url(get_permalink($tip_id)); ?>">
                            <span class="tip-card__media">
                                <?php if ($thumbnail_url) : ?>
                                    <img src="<?php echo esc_url($thumbnail_url); ?>" alt="<?php echo esc_attr($tip_title); ?>">
                                <?php else : ?>
                                    <span class="tip-card__media-placeholder"><?php echo esc_html(strtoupper(function_exists('mb_substr') ? mb_substr($tip_title, 0, 1) : substr($tip_title, 0, 1))); ?></span>
                                <?php endif; ?>
                            </span>
                            <h3 class="tip-card__title"><?php echo esc_html($tip_title); ?></h3>
                        </a>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php okmovers_render_button($section['button'] ?? [], 'button button-secondary'); ?>
    </div>
</section>
