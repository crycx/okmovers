<?php
$section = $args['section'] ?? [
    'eyebrow'          => okmovers_get_field_value('eyebrow'),
    'title'            => okmovers_get_field_value('title', null, get_the_title()),
    'intro'            => okmovers_get_field_value('intro', null, ''),
    'primary_button'   => okmovers_get_field_value('primary_button', null, []),
    'secondary_button' => okmovers_get_field_value('secondary_button', null, []),
    'image'            => okmovers_get_field_value('image', null, []),
    'video_url'        => okmovers_get_field_value('video_url', null, ''),
];

$image_url = okmovers_get_image_url($section['image'] ?? [], 'okmovers-hero');
$video_embed_url = okmovers_get_embed_video_url((string) ($section['video_url'] ?? ''));
?>
<section class="page-hero">
    <div class="container page-hero__grid">
        <div class="stack-md">
            <?php if (! empty($section['eyebrow'])) : ?>
                <p class="section-eyebrow"><?php echo esc_html($section['eyebrow']); ?></p>
            <?php endif; ?>
            <?php okmovers_render_section_title((string) ($section['title'] ?? ''), 'hero', 'h1'); ?>
            <?php if (! empty($section['intro'])) : ?>
                <div class="prose page-hero__intro"><?php echo wp_kses_post((string) $section['intro']); ?></div>
            <?php endif; ?>
            <div class="button-row">
                <?php okmovers_render_button($section['primary_button'] ?? [], 'button button-primary'); ?>
                <?php okmovers_render_button($section['secondary_button'] ?? [], 'button button-secondary'); ?>
            </div>
            <div id="evul-top">
              <a href="https://evul.ee/liikmed/11428959-OK-MOVERS-OU/sertifikaat" title="Vaata EVUL sertifikaati" target="_blank" style="position: relative;display: block;">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/margis.svg" alt="EVUL sertifikaat">
                <span style="position: absolute; bottom: 0; right: 0; font-size: 1em; line-height: 1; color: #000000; white-space: nowrap;">®</span>
              </a>
            </div>
        </div>

        <div class="page-hero__media">
            <?php if ($video_embed_url !== '') : ?>
                <div class="responsive-video">
                    <iframe src="<?php echo esc_url($video_embed_url); ?>" title="<?php esc_attr_e('Hero video', 'okmovers'); ?>" loading="lazy" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                </div>
            <?php elseif ($image_url) : ?>
                <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($section['title'] ?? get_bloginfo('name')); ?>">
            <?php else : ?>
                <div class="page-hero__placeholder">
                    <span><?php esc_html_e('OK Movers', 'okmovers'); ?></span>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
