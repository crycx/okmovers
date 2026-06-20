<?php
$section = $args['section'] ?? [
    'title' => okmovers_get_field_value('title', null, __('Teenused', 'okmovers')),
    'intro' => okmovers_get_field_value('intro', null, ''),
    'items' => okmovers_get_field_value('items', null, okmovers_get_fallback_services()),
];

$items = is_array($section['items'] ?? null) ? $section['items'] : [];
?>
<section class="page-section page-section--muted">
    <div class="container stack-lg">
        <div class="section-heading stack-sm">
            <?php okmovers_render_section_title((string) ($section['title'] ?? ''), 'services_grid'); ?>
            <?php if (! empty($section['intro'])) : ?>
                <div class="section-intro prose"><?php echo wp_kses_post((string) $section['intro']); ?></div>
            <?php endif; ?>
        </div>

        <div class="cards-grid cards-grid--services">
            <?php foreach ($items as $item) : ?>
                <?php $icon_url = okmovers_get_image_url($item['icon'] ?? [], 'thumbnail'); ?>
                <article class="service-card">
                    <?php if ($icon_url) : ?>
                        <img class="service-card__icon" src="<?php echo esc_url($icon_url); ?>" alt="">
                    <?php endif; ?>
                    <h3><?php echo esc_html($item['title'] ?? ''); ?></h3>
                    <div class="prose"><?php echo wp_kses_post((string) ($item['text'] ?? '')); ?></div>
                    <?php okmovers_render_button($item['link'] ?? [], 'text-link'); ?>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
