<?php
$section = $args['section'] ?? [
    'title' => okmovers_get_field_value('title', null, __('Korduma kippuvad kusimused', 'okmovers')),
    'items' => okmovers_get_field_value('items', null, []),
];

$items = is_array($section['items'] ?? null) ? $section['items'] : [];
?>
<?php if ($items) : ?>
    <section class="page-section">
        <div class="container stack-lg">
            <div class="section-heading stack-sm">
                <h2><?php echo esc_html($section['title'] ?? ''); ?></h2>
            </div>

            <div class="faq-list">
                <?php foreach ($items as $index => $item) : ?>
                    <article class="faq-item">
                        <button class="faq-item__trigger" type="button" aria-expanded="false" aria-controls="faq-panel-<?php echo esc_attr((string) $index); ?>">
                            <span><?php echo esc_html($item['question'] ?? ''); ?></span>
                        </button>
                        <div class="faq-item__panel" id="faq-panel-<?php echo esc_attr((string) $index); ?>" hidden>
                            <?php echo wp_kses_post((string) ($item['answer'] ?? '')); ?>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>
