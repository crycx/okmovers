<?php
$section = $args['section'] ?? [
    'title'          => okmovers_get_field_value('title', null, get_the_title()),
    'text'           => okmovers_get_field_value('text', null, ''),
    'image'          => okmovers_get_field_value('image', null, []),
    'image_position' => okmovers_get_field_value('image_position', null, 'right'),
];

$image_url = okmovers_get_image_url($section['image'] ?? [], 'okmovers-card');
$position = ($section['image_position'] ?? 'right') === 'left' ? ' text-image--reverse' : '';
?>
<section class="page-section">
    <div class="container text-image<?php echo esc_attr($position); ?>">
        <div class="stack-md prose">
            <?php okmovers_render_section_title((string) ($section['title'] ?? ''), 'text_image'); ?>
            <?php echo wp_kses_post((string) ($section['text'] ?? '')); ?>
        </div>
        <div class="text-image__media">
            <?php if ($image_url) : ?>
                <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($section['title'] ?? ''); ?>">
            <?php endif; ?>
        </div>
    </div>
</section>
