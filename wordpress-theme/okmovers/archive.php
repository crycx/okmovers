<?php
get_header();
?>
<section class="page-hero page-hero--compact">
    <div class="container stack-md">
        <p class="section-eyebrow"><?php esc_html_e('Artiklid', 'okmovers'); ?></p>
        <h1><?php the_archive_title(); ?></h1>
        <?php if (get_the_archive_description()) : ?>
            <div class="prose"><?php echo wp_kses_post(get_the_archive_description()); ?></div>
        <?php endif; ?>
    </div>
</section>

<section class="page-section container stack-lg">
    <?php if (have_posts()) : ?>
        <div class="cards-grid">
            <?php while (have_posts()) : the_post(); ?>
                <?php get_template_part('template-parts/content/entry', 'card'); ?>
            <?php endwhile; ?>
        </div>

        <div class="pagination-row">
            <?php the_posts_pagination(); ?>
        </div>
    <?php else : ?>
        <p><?php esc_html_e('Articles not found.', 'okmovers'); ?></p>
    <?php endif; ?>
</section>
<?php
get_footer();
