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
            <h2><?php echo esc_html($section['title'] ?? ''); ?></h2>
            <?php if (! empty($section['intro'])) : ?>
                <p class="section-intro"><?php echo esc_html($section['intro']); ?></p>
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
                    <p><?php echo esc_html($item['text'] ?? ''); ?></p>
                    <?php okmovers_render_button($item['link'] ?? [], 'text-link'); ?>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
