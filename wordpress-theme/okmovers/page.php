<?php
get_header();

if (have_posts()) {
    the_post();
}

$has_sections = okmovers_has_flexible_sections(get_the_ID());
?>
<?php if ($has_sections) : ?>
    <?php okmovers_render_flexible_sections(get_the_ID()); ?>
<?php else : ?>
    <?php get_template_part('template-parts/content/page', 'header'); ?>
    <section class="page-section container page-layout<?php echo okmovers_has_section_navigation(get_the_ID()) ? ' page-layout--sidebar' : ''; ?>">
        <?php okmovers_render_section_navigation(get_the_ID()); ?>
        <article <?php post_class('entry-content prose'); ?>>
            <?php the_content(); ?>
        </article>
    </section>
<?php endif; ?>
<?php
get_footer();
