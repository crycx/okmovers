<?php
$section = $args['section'] ?? [
    'title' => okmovers_get_field_value('title', null, __('Miks valida meid', 'okmovers')),
    'intro' => okmovers_get_field_value('intro', null, ''),
    'items' => okmovers_get_field_value('items', null, []),
];

$items = is_array($section['items'] ?? null) ? $section['items'] : [];
?>
<section class="page-section">
    <div class="container stack-lg">
        <div class="section-heading stack-sm">
            <?php okmovers_render_section_title((string) ($section['title'] ?? ''), 'benefits'); ?>
            <?php if (! empty($section['intro'])) : ?>
                <div class="section-intro prose"><?php echo wp_kses_post((string) $section['intro']); ?></div>
            <?php endif; ?>
        </div>

        <div class="benefits-grid">
            <?php foreach ($items as $item) : ?>
                <article class="benefit-card">
                    <h3><?php echo esc_html($item['title'] ?? ''); ?></h3>
                    <div class="prose"><?php echo wp_kses_post((string) ($item['text'] ?? '')); ?></div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
