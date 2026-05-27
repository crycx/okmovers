<?php
$args = wp_parse_args(
    $args ?? [],
    [
        'eyebrow' => '',
        'title'   => get_the_title(),
        'intro'   => has_excerpt() ? get_the_excerpt() : '',
    ]
);
?>
<section class="page-hero page-hero--compact">
    <div class="container stack-md">
        <?php if ($args['eyebrow']) : ?>
            <p class="section-eyebrow"><?php echo esc_html($args['eyebrow']); ?></p>
        <?php endif; ?>
        <h1><?php echo esc_html($args['title']); ?></h1>
        <?php if ($args['intro']) : ?>
            <div class="prose page-hero__intro"><?php echo wp_kses_post(wpautop($args['intro'])); ?></div>
        <?php endif; ?>
    </div>
</section>
