<?php
/**
 * Contact page template.
 *
 * Used automatically for the page with slug "kontakt".
 */

get_header();

if (have_posts()) {
    the_post();
}

$intro = has_excerpt() ? get_the_excerpt() : '';
?>

<section class="page-hero page-hero--compact kontakt-hero">
    <div class="container stack-md">
        <h1><?php the_title(); ?></h1>
    </div>
</section>

<?php if (has_post_thumbnail() || $intro) : ?>
    <section class="kontakt-header">
        <div class="container kontakt-header__inner">
            <?php if (has_post_thumbnail()) : ?>
                <div class="kontakt-header__logo">
                    <?php the_post_thumbnail('thumbnail'); ?>
                </div>
            <?php endif; ?>

            <?php if ($intro) : ?>
                <div class="kontakt-header__text prose">
                    <?php echo wp_kses_post(wpautop($intro)); ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php endif; ?>

<section class="page-section container kontakt-page">
    <div class="kontakt-page__details prose">
        <?php if (trim((string) get_the_content())) : ?>
            <?php the_content(); ?>
        <?php else : ?>
            <?php echo wp_kses_post(okmovers_get_contact_details_markup()); ?>
        <?php endif; ?>
    </div>

    <div class="kontakt-page__form">
        <?php okmovers_render_contact_form(); ?>
    </div>
</section>

<?php
get_footer();
