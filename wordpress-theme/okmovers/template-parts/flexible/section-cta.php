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
            <?php okmovers_render_section_title((string) ($section['title'] ?? ''), 'cta'); ?>
            <?php if (! empty($section['text'])) : ?>
                <div class="prose"><?php echo wp_kses_post((string) $section['text']); ?></div>
            <?php endif; ?>
            <?php okmovers_render_button($section['button'] ?? [], 'button button-primary'); ?>
        </div>
    </div>
</section>
