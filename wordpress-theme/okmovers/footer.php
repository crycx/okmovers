    </main>
    <footer class="site-footer">
        <div class="site-footer__inner container">
            <div class="site-footer__columns">
                <div class="site-footer__column">
                    <?php echo wp_kses_post((string) okmovers_get_option_field('footer_left_column', okmovers_get_contact_details_markup())); ?>
                </div>
                <div class="site-footer__column">
                    <?php echo wp_kses_post((string) okmovers_get_option_field('footer_middle_column', '<p><strong>OK Movers</strong></p><p>Kolimine, transport, ladustamine</p>')); ?>
                </div>
                <div class="site-footer__column">
                    <?php echo wp_kses_post((string) okmovers_get_option_field('footer_right_column', '<p><strong>Vota uhendust</strong></p><p>Kiire hinnaparing ja usaldusvaarsed kolimislahendused.</p>')); ?>

                    <?php $social_links = okmovers_get_social_links(); ?>
                    <?php if ($social_links) : ?>
                        <div class="site-footer__socials">
                            <?php foreach ($social_links as $social_link) : ?>
                                <a href="<?php echo esc_url($social_link['url'] ?? '#'); ?>" target="_blank" rel="noreferrer noopener">
                                    <?php echo esc_html($social_link['label'] ?? __('Link', 'okmovers')); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="site-footer__bottom">
                <p>&copy; <?php echo esc_html(wp_date('Y')); ?> <?php bloginfo('name'); ?></p>
                <?php
                wp_nav_menu([
                    'theme_location' => 'legal',
                    'container'      => false,
                    'menu_class'     => 'site-footer__menu',
                    'fallback_cb'    => false,
                ]);
                ?>
            </div>
        </div>
    </footer>
</div>
<?php wp_footer(); ?>
</body>
</html>
