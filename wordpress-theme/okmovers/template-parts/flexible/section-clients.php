<?php
$section = $args['section'] ?? [
    'title' => okmovers_get_field_value('title', null, __('Meie kliendid', 'okmovers')),
    'intro' => okmovers_get_field_value('intro', null, ''),
    'items' => okmovers_get_field_value('items', null, okmovers_get_fallback_clients()),
];

$items = is_array($section['items'] ?? null) ? $section['items'] : okmovers_get_fallback_clients();
$section_id = 'clients-carousel-' . wp_unique_id();
?>
<section class="page-section clients-section" id="<?php echo esc_attr($section_id); ?>">
    <div class="container stack-lg">
        <div class="section-heading stack-sm">
            <?php okmovers_render_section_title((string) ($section['title'] ?? ''), 'clients'); ?>
            <?php if (! empty($section['intro'])) : ?>
                <div class="section-intro prose"><?php echo wp_kses_post((string) $section['intro']); ?></div>
            <?php endif; ?>
        </div>

        <!-- <div class="clients-section__underline" aria-hidden="true"></div> -->

        <div class="clients-carousel" data-clients-carousel>
            <button class="clients-carousel__button clients-carousel__button--prev" type="button" data-clients-prev aria-label="<?php esc_attr_e('Eelmised kliendid', 'okmovers'); ?>"></button>

            <div class="clients-carousel__viewport" aria-live="polite">
                <div class="clients-carousel__track" data-clients-track>
                    <?php foreach ($items as $item) : ?>
                        <?php
                        $logo_url = okmovers_get_image_url($item['logo'] ?? [], 'medium');
                        $name = trim((string) ($item['name'] ?? ''));
                        $initial = strtoupper(function_exists('mb_substr') ? mb_substr($name ?: 'K', 0, 1) : substr($name ?: 'K', 0, 1));
                        $client_link = okmovers_normalize_link($item['link'] ?? [], [
                            'title' => $name ?: __('Klient', 'okmovers'),
                        ]);
                        ?>
                        <article class="clients-carousel__item" data-clients-item>
                            <?php if($client_link['url']): ?>
                                <a class="clients-carousel__logo-link" href="<?php echo esc_url($client_link['url']); ?>" target="<?php echo esc_attr($client_link['target']); ?>" aria-label="<?php echo esc_attr($name ?: __('Klient', 'okmovers')); ?>">
                            <?php else: ?>
                                  <div class="clients-carousel__logo-link"
                                  aria-label="<?php echo esc_attr($client_link['title']); ?>">
                            <?php endif; ?>
                                <?php if ($logo_url) : ?>
                                    <img class="clients-carousel__logo" src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr($name); ?>" loading="lazy">
                                <?php else : ?>
                                    <span class="clients-carousel__placeholder"><?php echo esc_html($initial); ?></span>
                                <?php endif; ?>
                            <?php if($client_link['url']): ?></a><?php else: ?></div><?php endif; ?>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>

            <button class="clients-carousel__button clients-carousel__button--next" type="button" data-clients-next aria-label="<?php esc_attr_e('Järgmised kliendid', 'okmovers'); ?>"></button>
        </div>
    </div>
</section>
