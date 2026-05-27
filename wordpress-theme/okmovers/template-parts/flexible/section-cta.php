<?php
$section = $args['section'] ?? [
    'title'  => okmovers_get_field_value('title', null, __('Valmis kolimiseks?', 'okmovers')),
    'text'   => okmovers_get_field_value('text', null, ''),
    'button' => okmovers_get_field_value('button', null, []),
];
?>
<section class="page-section">
    <div class="container">
        <div class="cta-box stack-md">
            <h2><?php echo esc_html($section['title'] ?? ''); ?></h2>
            <?php if (! empty($section['text'])) : ?>
                <p><?php echo esc_html($section['text']); ?></p>
            <?php endif; ?>
            <?php okmovers_render_button($section['button'] ?? [], 'button button-primary'); ?>
        </div>
    </div>
</section>
