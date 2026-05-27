<?php
$section = $args['section'] ?? [
    'title' => okmovers_get_field_value('title', null, __('Hinnaparing', 'okmovers')),
    'text'  => okmovers_get_field_value('text', null, ''),
];
?>
<section class="page-section">
    <div class="container contact-block">
        <div class="stack-md prose">
            <h2><?php echo esc_html($section['title'] ?? ''); ?></h2>
            <?php if (! empty($section['text'])) : ?>
                <p><?php echo esc_html($section['text']); ?></p>
            <?php endif; ?>
            <div class="contact-details prose">
                <?php echo wp_kses_post(okmovers_get_contact_details_markup()); ?>
            </div>
        </div>
        <div>
            <?php okmovers_render_contact_form('quote'); ?>
        </div>
    </div>
</section>
