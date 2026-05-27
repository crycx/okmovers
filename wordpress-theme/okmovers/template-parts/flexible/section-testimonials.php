<?php
$section = $args['section'] ?? [
    'title' => okmovers_get_field_value('title', null, __('Kliendid raagivad', 'okmovers')),
    'items' => okmovers_get_field_value('items', null, okmovers_get_fallback_reviews()),
];

$items = is_array($section['items'] ?? null) ? $section['items'] : okmovers_get_fallback_reviews();
?>
<section class="page-section page-section--muted">
    <div class="container stack-lg">
        <div class="section-heading stack-sm">
            <h2><?php echo esc_html($section['title'] ?? ''); ?></h2>
        </div>

        <div class="cards-grid cards-grid--testimonials">
            <?php foreach ($items as $item) : ?>
                <blockquote class="testimonial-card">
                    <p class="testimonial-card__quote">&ldquo;<?php echo esc_html($item['quote'] ?? ''); ?>&rdquo;</p>
                    <footer>
                        <strong><?php echo esc_html($item['author'] ?? ''); ?></strong>
                        <?php if (! empty($item['role'])) : ?>
                            <span><?php echo esc_html($item['role']); ?></span>
                        <?php endif; ?>
                    </footer>
                </blockquote>
            <?php endforeach; ?>
        </div>
    </div>
</section>
