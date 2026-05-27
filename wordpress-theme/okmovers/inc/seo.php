<?php

add_action('wp_head', 'okmovers_output_meta_tags', 1);
function okmovers_output_meta_tags(): void
{
    if (is_admin() || defined('WPSEO_VERSION') || defined('RANK_MATH_VERSION')) {
        return;
    }

    $post_id = get_queried_object_id();

    if (! $post_id || ! is_singular()) {
        return;
    }

    $meta_description = okmovers_get_field_value('seo_description', $post_id, '');

    if (! $meta_description) {
        if (has_excerpt($post_id)) {
            $meta_description = get_the_excerpt($post_id);
        } else {
            $meta_description = wp_trim_words(wp_strip_all_tags((string) get_post_field('post_content', $post_id)), 30);
        }
    }

    $canonical = okmovers_get_field_value('canonical_url', $post_id, get_permalink($post_id));
    $og_title = okmovers_get_field_value('og_title', $post_id, get_the_title($post_id));
    $og_description = okmovers_get_field_value('og_description', $post_id, $meta_description);
    $og_image = okmovers_get_image_url(okmovers_get_field_value('og_image', $post_id, get_post_thumbnail_id($post_id)), 'okmovers-hero');
    $noindex = (bool) okmovers_get_field_value('noindex', $post_id, false);

    if ($meta_description) {
        echo '<meta name="description" content="' . esc_attr($meta_description) . '">' . "\n";
    }

    if ($canonical) {
        echo '<link rel="canonical" href="' . esc_url($canonical) . '">' . "\n";
    }

    if ($noindex) {
        echo '<meta name="robots" content="noindex,follow">' . "\n";
    }

    echo '<meta property="og:type" content="article">' . "\n";
    echo '<meta property="og:title" content="' . esc_attr($og_title) . '">' . "\n";
    echo '<meta property="og:description" content="' . esc_attr($og_description) . '">' . "\n";
    echo '<meta property="og:url" content="' . esc_url(get_permalink($post_id)) . '">' . "\n";

    if ($og_image) {
        echo '<meta property="og:image" content="' . esc_url($og_image) . '">' . "\n";
    }
}
