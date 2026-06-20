<?php
$section = $args['section'] ?? [
    'title' => okmovers_get_field_value('title', null, __('Hinnaparing', 'okmovers')),
    'text'  => okmovers_get_field_value('text', null, ''),
    'form_mode' => okmovers_get_field_value('form_mode', null, 'native'),
    'form_shortcode' => okmovers_get_field_value('form_shortcode', null, ''),
];
?>
<section class="page-section">
    <div class="container contact-block">
        <div class="stack-md prose">
            <?php okmovers_render_section_title((string) ($section['title'] ?? ''), 'quote_form'); ?>
            <?php if (! empty($section['text'])) : ?>
                <?php echo wp_kses_post((string) $section['text']); ?>
            <?php endif; ?>
            <div class="contact-details prose">
                <?php echo wp_kses_post(okmovers_get_contact_details_markup()); ?>
            </div>
        </div>
        <div>
            <?php if (($section['form_mode'] ?? 'native') === 'shortcode' && ! empty($section['form_shortcode'])) : ?>
                <?php echo do_shortcode((string) $section['form_shortcode']); ?>
            <?php else : ?>
                <?php okmovers_render_contact_form('quote'); ?>
            <?php endif; ?>
        </div>
    </div>
</section>
