<?php
get_header();
?>
<section class="page-section container stack-lg">
    <?php if (have_posts()) : ?>
        <div class="cards-grid">
            <?php while (have_posts()) : the_post(); ?>
                <?php get_template_part('template-parts/content/entry', 'card'); ?>
            <?php endwhile; ?>
        </div>
    <?php else : ?>
        <p><?php esc_html_e('Content not found.', 'okmovers'); ?></p>
    <?php endif; ?>
</section>
<?php
get_footer();
