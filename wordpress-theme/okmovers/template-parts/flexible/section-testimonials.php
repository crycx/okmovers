<?php
$section = $args['section'] ?? [
    'title' => okmovers_get_field_value('title', null, __('Kliendid raagivad', 'okmovers')),
    'items' => okmovers_get_field_value('items', null, okmovers_get_fallback_reviews()),
];

$items = is_array($section['items'] ?? null) ? $section['items'] : okmovers_get_fallback_reviews();
$section_id = 'testimonials-carousel-' . wp_unique_id();
?>
<section class="page-section page-section--muted">
    <div class="container stack-lg">
        <div class="section-heading stack-sm">
            <?php okmovers_render_section_title((string) ($section['title'] ?? ''), 'testimonials'); ?>
        </div>

        <div class="testimonials-carousel" id="<?php echo esc_attr($section_id); ?>" data-testimonials-carousel>
            <button class="testimonials-carousel__button testimonials-carousel__button--prev" type="button" data-testimonials-prev aria-label="<?php esc_attr_e('Eelmised tagasisided', 'okmovers'); ?>"></button>

            <div class="testimonials-carousel__viewport" aria-live="polite">
                <div class="testimonials-carousel__track" data-testimonials-track>
                    <?php foreach ($items as $item) : ?>
                        <?php $image_url = okmovers_get_image_url($item['image'] ?? [], 'thumbnail'); ?>
                        <blockquote class="testimonial-card testimonials-carousel__item" data-testimonials-item>
                            <?php if ($image_url) : ?>
                                <img class="testimonial-card__avatar" src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($item['author'] ?? ''); ?>">
                            <?php endif; ?>
                            <div class="testimonial-card__quote"><?php echo wp_kses_post((string) ($item['quote'] ?? '')); ?></div>
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

            <button class="testimonials-carousel__button testimonials-carousel__button--next" type="button" data-testimonials-next aria-label="<?php esc_attr_e('Järgmised tagasisided', 'okmovers'); ?>"></button>
        </div>
    </div>
</section>
