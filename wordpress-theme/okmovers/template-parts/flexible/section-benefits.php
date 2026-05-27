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
            <h2><?php echo esc_html($section['title'] ?? ''); ?></h2>
            <?php if (! empty($section['intro'])) : ?>
                <p class="section-intro"><?php echo esc_html($section['intro']); ?></p>
            <?php endif; ?>
        </div>

        <div class="benefits-grid">
            <?php foreach ($items as $item) : ?>
                <article class="benefit-card">
                    <h3><?php echo esc_html($item['title'] ?? ''); ?></h3>
                    <p><?php echo esc_html($item['text'] ?? ''); ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
