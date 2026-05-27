<article <?php post_class('entry-card'); ?>>
    <a class="entry-card__link" href="<?php the_permalink(); ?>">
        <?php if (has_post_thumbnail()) : ?>
            <div class="entry-card__media">
                <?php the_post_thumbnail('okmovers-card'); ?>
            </div>
        <?php endif; ?>
        <div class="entry-card__body">
            <p class="entry-card__meta"><?php echo esc_html(get_the_date()); ?></p>
            <h2 class="entry-card__title"><?php the_title(); ?></h2>
            <div class="entry-card__excerpt"><?php the_excerpt(); ?></div>
        </div>
    </a>
</article>
