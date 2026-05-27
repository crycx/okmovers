<?php
get_header();

if (have_posts()) {
    the_post();
}
?>
<?php get_template_part('template-parts/content/page', 'header', ['eyebrow' => get_the_date()]); ?>
<section class="page-section container page-layout">
    <article <?php post_class('entry-content prose'); ?>>
        <?php if (has_post_thumbnail()) : ?>
            <figure class="entry-media">
                <?php the_post_thumbnail('okmovers-hero'); ?>
            </figure>
        <?php endif; ?>

        <?php the_content(); ?>
    </article>
</section>
<?php
get_footer();
