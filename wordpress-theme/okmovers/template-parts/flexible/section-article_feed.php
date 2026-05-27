<?php
$section = $args['section'] ?? [
    'title'    => okmovers_get_field_value('title', null, __('Viimased artiklid', 'okmovers')),
    'intro'    => okmovers_get_field_value('intro', null, ''),
    'category' => okmovers_get_field_value('category', null, 0),
    'count'    => (int) okmovers_get_field_value('count', null, 3),
    'button'   => okmovers_get_field_value('button', null, []),
];

$query_args = [
    'post_type'      => 'post',
    'posts_per_page' => max(1, (int) ($section['count'] ?? 3)),
];

if (! empty($section['category'])) {
    $query_args['cat'] = (int) $section['category'];
}

$articles = new WP_Query($query_args);
?>
<section class="page-section">
    <div class="container stack-lg">
        <div class="section-heading stack-sm">
            <h2><?php echo esc_html($section['title'] ?? ''); ?></h2>
            <?php if (! empty($section['intro'])) : ?>
                <p class="section-intro"><?php echo esc_html($section['intro']); ?></p>
            <?php endif; ?>
        </div>

        <?php if ($articles->have_posts()) : ?>
            <div class="cards-grid">
                <?php while ($articles->have_posts()) : $articles->the_post(); ?>
                    <?php get_template_part('template-parts/content/entry', 'card'); ?>
                <?php endwhile; ?>
            </div>
            <?php wp_reset_postdata(); ?>
        <?php endif; ?>

        <?php okmovers_render_button($section['button'] ?? [], 'button button-secondary'); ?>
    </div>
</section>
