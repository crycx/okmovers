<?php
$section = $args['section'] ?? [
    'title'         => okmovers_get_field_value('title', null, __('Vota uhendust', 'okmovers')),
    'text'          => okmovers_get_field_value('text', null, ''),
    'form_mode'     => okmovers_get_field_value('form_mode', null, 'contact'),
    'form_shortcode'=> okmovers_get_field_value('form_shortcode', null, ''),
];
?>
<section class="page-section page-section--muted">
    <div class="container contact-block">
        <div class="stack-md prose">
            <h2><?php echo esc_html($section['title'] ?? ''); ?></h2>
            <?php echo wp_kses_post((string) ($section['text'] ?? okmovers_get_contact_details_markup())); ?>
            <div class="contact-details prose">
                <?php echo wp_kses_post(okmovers_get_contact_details_markup()); ?>
            </div>
        </div>
        <div>
            <?php if (($section['form_mode'] ?? 'contact') === 'shortcode' && ! empty($section['form_shortcode'])) : ?>
                <?php echo do_shortcode((string) $section['form_shortcode']); ?>
            <?php else : ?>
                <?php okmovers_render_contact_form(($section['form_mode'] ?? 'contact') === 'quote' ? 'quote' : 'contact'); ?>
            <?php endif; ?>
        </div>
    </div>
</section>
