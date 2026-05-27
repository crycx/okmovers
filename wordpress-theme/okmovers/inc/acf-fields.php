<?php

add_action('acf/init', 'okmovers_register_acf_fields');
function okmovers_register_acf_fields(): void
{
    if (! function_exists('acf_add_local_field_group')) {
        return;
    }

    if (function_exists('acf_add_options_page')) {
        acf_add_options_page([
            'page_title' => __('OK Movers Settings', 'okmovers'),
            'menu_title' => __('OK Movers', 'okmovers'),
            'menu_slug'  => 'okmovers-settings',
            'capability' => 'edit_posts',
            'redirect'   => false,
        ]);
    }

    acf_add_local_field_group([
        'key' => 'group_okmovers_site_settings',
        'title' => 'OK Movers Site Settings',
        'fields' => [
            ['key' => 'field_okmovers_company_phone', 'label' => 'Company phone', 'name' => 'company_phone', 'type' => 'text'],
            ['key' => 'field_okmovers_company_email', 'label' => 'Company email', 'name' => 'company_email', 'type' => 'email'],
            ['key' => 'field_okmovers_company_address', 'label' => 'Company address', 'name' => 'company_address', 'type' => 'text'],
            ['key' => 'field_okmovers_company_hours', 'label' => 'Company hours', 'name' => 'company_hours', 'type' => 'text'],
            ['key' => 'field_okmovers_contact_recipient', 'label' => 'Contact recipient email', 'name' => 'contact_recipient_email', 'type' => 'email'],
            ['key' => 'field_okmovers_quote_recipient', 'label' => 'Quote recipient email', 'name' => 'quote_recipient_email', 'type' => 'email'],
            ['key' => 'field_okmovers_footer_left', 'label' => 'Footer left column', 'name' => 'footer_left_column', 'type' => 'wysiwyg', 'tabs' => 'visual'],
            ['key' => 'field_okmovers_footer_middle', 'label' => 'Footer middle column', 'name' => 'footer_middle_column', 'type' => 'wysiwyg', 'tabs' => 'visual'],
            ['key' => 'field_okmovers_footer_right', 'label' => 'Footer right column', 'name' => 'footer_right_column', 'type' => 'wysiwyg', 'tabs' => 'visual'],
            [
                'key' => 'field_okmovers_social_links',
                'label' => 'Social links',
                'name' => 'social_links',
                'type' => 'repeater',
                'button_label' => 'Add social link',
                'sub_fields' => [
                    ['key' => 'field_okmovers_social_label', 'label' => 'Label', 'name' => 'label', 'type' => 'text'],
                    ['key' => 'field_okmovers_social_url', 'label' => 'URL', 'name' => 'url', 'type' => 'url'],
                ],
            ],
        ],
        'location' => [[['param' => 'options_page', 'operator' => '==', 'value' => 'okmovers-settings']]],
    ]);

    acf_add_local_field_group([
        'key' => 'group_okmovers_page_builder',
        'title' => 'OK Movers Page Builder',
        'fields' => [
            [
                'key' => 'field_okmovers_page_sections',
                'label' => 'Page sections',
                'name' => 'page_sections',
                'type' => 'flexible_content',
                'button_label' => 'Add section',
                'layouts' => [
                    'layout_okmovers_hero_section' => [
                        'key' => 'layout_okmovers_hero_section',
                        'name' => 'hero',
                        'label' => 'Hero section',
                        'display' => 'block',
                        'sub_fields' => [
                            ['key' => 'field_okmovers_hero_eyebrow', 'label' => 'Eyebrow', 'name' => 'eyebrow', 'type' => 'text'],
                            ['key' => 'field_okmovers_hero_title', 'label' => 'Title', 'name' => 'title', 'type' => 'text'],
                            ['key' => 'field_okmovers_hero_intro', 'label' => 'Intro', 'name' => 'intro', 'type' => 'textarea'],
                            ['key' => 'field_okmovers_hero_primary', 'label' => 'Primary button', 'name' => 'primary_button', 'type' => 'link'],
                            ['key' => 'field_okmovers_hero_secondary', 'label' => 'Secondary button', 'name' => 'secondary_button', 'type' => 'link'],
                            ['key' => 'field_okmovers_hero_image', 'label' => 'Image', 'name' => 'image', 'type' => 'image', 'return_format' => 'array'],
                            ['key' => 'field_okmovers_hero_video', 'label' => 'Video URL', 'name' => 'video_url', 'type' => 'url'],
                        ],
                    ],
                    'layout_okmovers_text_image' => [
                        'key' => 'layout_okmovers_text_image',
                        'name' => 'text_image',
                        'label' => 'Text + image',
                        'display' => 'block',
                        'sub_fields' => [
                            ['key' => 'field_okmovers_ti_title', 'label' => 'Title', 'name' => 'title', 'type' => 'text'],
                            ['key' => 'field_okmovers_ti_text', 'label' => 'Text', 'name' => 'text', 'type' => 'wysiwyg', 'tabs' => 'visual'],
                            ['key' => 'field_okmovers_ti_image', 'label' => 'Image', 'name' => 'image', 'type' => 'image', 'return_format' => 'array'],
                            ['key' => 'field_okmovers_ti_position', 'label' => 'Image position', 'name' => 'image_position', 'type' => 'select', 'choices' => ['left' => 'Left', 'right' => 'Right']],
                        ],
                    ],
                    'layout_okmovers_services_grid' => [
                        'key' => 'layout_okmovers_services_grid',
                        'name' => 'services_grid',
                        'label' => 'Services grid',
                        'display' => 'block',
                        'sub_fields' => [
                            ['key' => 'field_okmovers_services_title', 'label' => 'Title', 'name' => 'title', 'type' => 'text'],
                            ['key' => 'field_okmovers_services_intro', 'label' => 'Intro', 'name' => 'intro', 'type' => 'textarea'],
                            [
                                'key' => 'field_okmovers_services_items',
                                'label' => 'Items',
                                'name' => 'items',
                                'type' => 'repeater',
                                'button_label' => 'Add item',
                                'sub_fields' => [
                                    ['key' => 'field_okmovers_services_item_title', 'label' => 'Title', 'name' => 'title', 'type' => 'text'],
                                    ['key' => 'field_okmovers_services_item_text', 'label' => 'Text', 'name' => 'text', 'type' => 'textarea'],
                                    ['key' => 'field_okmovers_services_item_icon', 'label' => 'Icon image', 'name' => 'icon', 'type' => 'image', 'return_format' => 'array'],
                                    ['key' => 'field_okmovers_services_item_link', 'label' => 'Link', 'name' => 'link', 'type' => 'link'],
                                ],
                            ],
                        ],
                    ],
                    'layout_okmovers_benefits' => [
                        'key' => 'layout_okmovers_benefits',
                        'name' => 'benefits',
                        'label' => 'Benefits section',
                        'display' => 'block',
                        'sub_fields' => [
                            ['key' => 'field_okmovers_benefits_title', 'label' => 'Title', 'name' => 'title', 'type' => 'text'],
                            ['key' => 'field_okmovers_benefits_intro', 'label' => 'Intro', 'name' => 'intro', 'type' => 'textarea'],
                            [
                                'key' => 'field_okmovers_benefits_items',
                                'label' => 'Items',
                                'name' => 'items',
                                'type' => 'repeater',
                                'button_label' => 'Add benefit',
                                'sub_fields' => [
                                    ['key' => 'field_okmovers_benefits_item_title', 'label' => 'Title', 'name' => 'title', 'type' => 'text'],
                                    ['key' => 'field_okmovers_benefits_item_text', 'label' => 'Text', 'name' => 'text', 'type' => 'textarea'],
                                ],
                            ],
                        ],
                    ],
                    'layout_okmovers_cta' => [
                        'key' => 'layout_okmovers_cta',
                        'name' => 'cta',
                        'label' => 'CTA section',
                        'display' => 'block',
                        'sub_fields' => [
                            ['key' => 'field_okmovers_cta_title', 'label' => 'Title', 'name' => 'title', 'type' => 'text'],
                            ['key' => 'field_okmovers_cta_text', 'label' => 'Text', 'name' => 'text', 'type' => 'textarea'],
                            ['key' => 'field_okmovers_cta_button', 'label' => 'Button', 'name' => 'button', 'type' => 'link'],
                        ],
                    ],
                    'layout_okmovers_testimonials' => [
                        'key' => 'layout_okmovers_testimonials',
                        'name' => 'testimonials',
                        'label' => 'Testimonials',
                        'display' => 'block',
                        'sub_fields' => [
                            ['key' => 'field_okmovers_testimonials_title', 'label' => 'Title', 'name' => 'title', 'type' => 'text'],
                            [
                                'key' => 'field_okmovers_testimonials_items',
                                'label' => 'Testimonials',
                                'name' => 'items',
                                'type' => 'repeater',
                                'button_label' => 'Add testimonial',
                                'sub_fields' => [
                                    ['key' => 'field_okmovers_testimonial_quote', 'label' => 'Quote', 'name' => 'quote', 'type' => 'textarea'],
                                    ['key' => 'field_okmovers_testimonial_author', 'label' => 'Author', 'name' => 'author', 'type' => 'text'],
                                    ['key' => 'field_okmovers_testimonial_role', 'label' => 'Role', 'name' => 'role', 'type' => 'text'],
                                ],
                            ],
                        ],
                    ],
                    'layout_okmovers_faq' => [
                        'key' => 'layout_okmovers_faq',
                        'name' => 'faq',
                        'label' => 'FAQ',
                        'display' => 'block',
                        'sub_fields' => [
                            ['key' => 'field_okmovers_faq_title', 'label' => 'Title', 'name' => 'title', 'type' => 'text'],
                            [
                                'key' => 'field_okmovers_faq_items',
                                'label' => 'Questions',
                                'name' => 'items',
                                'type' => 'repeater',
                                'button_label' => 'Add question',
                                'sub_fields' => [
                                    ['key' => 'field_okmovers_faq_question', 'label' => 'Question', 'name' => 'question', 'type' => 'text'],
                                    ['key' => 'field_okmovers_faq_answer', 'label' => 'Answer', 'name' => 'answer', 'type' => 'wysiwyg', 'tabs' => 'visual'],
                                ],
                            ],
                        ],
                    ],
                    'layout_okmovers_contact_block' => [
                        'key' => 'layout_okmovers_contact_block',
                        'name' => 'contact_block',
                        'label' => 'Contact block',
                        'display' => 'block',
                        'sub_fields' => [
                            ['key' => 'field_okmovers_contact_title', 'label' => 'Title', 'name' => 'title', 'type' => 'text'],
                            ['key' => 'field_okmovers_contact_text', 'label' => 'Text', 'name' => 'text', 'type' => 'wysiwyg', 'tabs' => 'visual'],
                            ['key' => 'field_okmovers_contact_form_mode', 'label' => 'Form mode', 'name' => 'form_mode', 'type' => 'select', 'choices' => ['contact' => 'Contact form', 'quote' => 'Quote form', 'shortcode' => 'Shortcode']],
                            ['key' => 'field_okmovers_contact_shortcode', 'label' => 'Form shortcode', 'name' => 'form_shortcode', 'type' => 'text'],
                        ],
                    ],
                    'layout_okmovers_quote_form' => [
                        'key' => 'layout_okmovers_quote_form',
                        'name' => 'quote_form',
                        'label' => 'Quote request form',
                        'display' => 'block',
                        'sub_fields' => [
                            ['key' => 'field_okmovers_quote_title', 'label' => 'Title', 'name' => 'title', 'type' => 'text'],
                            ['key' => 'field_okmovers_quote_text', 'label' => 'Text', 'name' => 'text', 'type' => 'textarea'],
                        ],
                    ],
                    'layout_okmovers_article_feed' => [
                        'key' => 'layout_okmovers_article_feed',
                        'name' => 'article_feed',
                        'label' => 'Article feed',
                        'display' => 'block',
                        'sub_fields' => [
                            ['key' => 'field_okmovers_articles_title', 'label' => 'Title', 'name' => 'title', 'type' => 'text'],
                            ['key' => 'field_okmovers_articles_intro', 'label' => 'Intro', 'name' => 'intro', 'type' => 'textarea'],
                            ['key' => 'field_okmovers_articles_category', 'label' => 'Category', 'name' => 'category', 'type' => 'taxonomy', 'taxonomy' => 'category', 'field_type' => 'select', 'return_format' => 'id'],
                            ['key' => 'field_okmovers_articles_count', 'label' => 'Number of posts', 'name' => 'count', 'type' => 'number', 'default_value' => 3, 'min' => 1, 'max' => 6],
                            ['key' => 'field_okmovers_articles_button', 'label' => 'Archive button', 'name' => 'button', 'type' => 'link'],
                        ],
                    ],
                ],
            ],
        ],
        'location' => [
            [['param' => 'post_type', 'operator' => '==', 'value' => 'page']],
            [['param' => 'post_type', 'operator' => '==', 'value' => 'post']],
        ],
    ]);

    acf_add_local_field_group([
        'key' => 'group_okmovers_seo_fields',
        'title' => 'OK Movers SEO',
        'fields' => [
            ['key' => 'field_okmovers_seo_description', 'label' => 'Meta description', 'name' => 'seo_description', 'type' => 'textarea'],
            ['key' => 'field_okmovers_canonical_url', 'label' => 'Canonical URL', 'name' => 'canonical_url', 'type' => 'url'],
            ['key' => 'field_okmovers_og_title', 'label' => 'Open Graph title', 'name' => 'og_title', 'type' => 'text'],
            ['key' => 'field_okmovers_og_description', 'label' => 'Open Graph description', 'name' => 'og_description', 'type' => 'textarea'],
            ['key' => 'field_okmovers_og_image', 'label' => 'Open Graph image', 'name' => 'og_image', 'type' => 'image', 'return_format' => 'array'],
            ['key' => 'field_okmovers_noindex', 'label' => 'Noindex', 'name' => 'noindex', 'type' => 'true_false', 'ui' => 1],
        ],
        'location' => [
            [['param' => 'post_type', 'operator' => '==', 'value' => 'page']],
            [['param' => 'post_type', 'operator' => '==', 'value' => 'post']],
        ],
    ]);
}
