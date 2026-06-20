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
            // ['key' => 'field_okmovers_company_hours', 'label' => 'Company hours', 'name' => 'company_hours', 'type' => 'text'],
            ['key' => 'field_okmovers_company_registration_code', 'label' => 'Company registration code', 'name' => 'company_registration_code', 'type' => 'text'],
            ['key' => 'field_okmovers_company_kmkr_code', 'label' => 'Company KMKR code', 'name' => 'company_kmkr_code', 'type' => 'text'],
            ['key' => 'field_okmovers_contact_recipient', 'label' => 'Contact recipient email', 'name' => 'contact_recipient_email', 'type' => 'email'],
            ['key' => 'field_okmovers_quote_recipient', 'label' => 'Quote recipient email', 'name' => 'quote_recipient_email', 'type' => 'email'],
            ['key' => 'field_okmovers_quote_delivery_mode', 'label' => 'Quote delivery mode', 'name' => 'quote_form_delivery_mode', 'type' => 'select', 'choices' => ['endpoint' => 'External endpoint (Vue style)', 'email' => 'Send via email'], 'default_value' => 'endpoint'],
            ['key' => 'field_okmovers_quote_endpoint_url', 'label' => 'Quote endpoint URL', 'name' => 'quote_form_endpoint_url', 'type' => 'url', 'default_value' => 'https://emailservice.ermine.ee/quote'],
            ['key' => 'field_okmovers_quote_submit_label', 'label' => 'Quote form submit button label', 'name' => 'quote_form_submit_label', 'type' => 'text', 'default_value' => 'SAADA PÄRING'],
            ['key' => 'field_okmovers_quote_placeholder_name', 'label' => 'Quote name placeholder', 'name' => 'quote_form_placeholder_name', 'type' => 'text', 'default_value' => 'Sinu nimi'],
            ['key' => 'field_okmovers_quote_placeholder_email', 'label' => 'Quote email placeholder', 'name' => 'quote_form_placeholder_email', 'type' => 'text', 'default_value' => 'E-posti aadress'],
            ['key' => 'field_okmovers_quote_placeholder_phone', 'label' => 'Quote phone placeholder', 'name' => 'quote_form_placeholder_phone', 'type' => 'text', 'default_value' => 'Telefon'],
            ['key' => 'field_okmovers_quote_placeholder_date', 'label' => 'Quote move date placeholder', 'name' => 'quote_form_placeholder_move_date', 'type' => 'text', 'default_value' => 'Orienteeruv kolimise kuupäev'],
            ['key' => 'field_okmovers_quote_placeholder_from', 'label' => 'Quote pickup details placeholder', 'name' => 'quote_form_placeholder_from_details', 'type' => 'text', 'default_value' => 'Linn, linnaosa või aadress'],
            ['key' => 'field_okmovers_quote_placeholder_to', 'label' => 'Quote delivery details placeholder', 'name' => 'quote_form_placeholder_to_details', 'type' => 'text', 'default_value' => 'Linn, linnaosa või aadress'],
            ['key' => 'field_okmovers_quote_placeholder_inventory', 'label' => 'Quote inventory placeholder', 'name' => 'quote_form_placeholder_inventory', 'type' => 'text', 'default_value' => 'Korrus, lift, asjade hulk, erisoovid'],
            ['key' => 'field_okmovers_quote_success_message', 'label' => 'Quote success message', 'name' => 'quote_form_success_message', 'type' => 'text', 'default_value' => 'Aitäh. Hinnapäring on saadetud.'],
            ['key' => 'field_okmovers_quote_validation_message', 'label' => 'Quote validation message', 'name' => 'quote_form_validation_message', 'type' => 'text', 'default_value' => 'Palun täitke kõik nõutud väljad.'],
            ['key' => 'field_okmovers_quote_error_message', 'label' => 'Quote error message', 'name' => 'quote_form_error_message', 'type' => 'text', 'default_value' => 'Saatmine ebaõnnestus. Proovige uuesti või võtke meiega otse ühendust.'],
            ['key' => 'field_okmovers_quote_shortcode_hint', 'label' => 'Quote shortcode hint', 'name' => 'quote_form_shortcode_hint', 'type' => 'message', 'message' => 'Use shortcode: [okmovers_quote_form] or [okmovers_form mode="quote"]'],
            [
                'key' => 'field_okmovers_front_page_source_page',
                'label' => 'Front page sections source page',
                'name' => 'front_page_source_page',
                'type' => 'post_object',
                'post_type' => ['page'],
                'return_format' => 'id',
                'ui' => 1,
                'instructions' => 'Use this when the homepage shows latest posts. The selected page\'s ACF "Page sections" will be rendered on front page.',
            ],
            [
                'key' => 'field_okmovers_front_page_hidden_sections',
                'label' => 'Front page hidden sections',
                'name' => 'front_page_hidden_sections',
                'type' => 'checkbox',
                'choices' => [
                    'hero' => 'Hero',
                    'testimonials' => 'Testimonials',
                    'services_grid' => 'Services grid',
                    'benefits' => 'Benefits',
                    'clients' => 'Clients',
                    'tips_grid' => 'Tips grid',
                    'cta' => 'CTA',
                ],
                'return_format' => 'value',
                'layout' => 'vertical',
                'instructions' => 'Select sections to hide on front page.',
            ],
            [
                'key' => 'field_okmovers_quote_move_types',
                'label' => 'Quote form move types',
                'name' => 'quote_form_move_types',
                'type' => 'repeater',
                'button_label' => 'Add move type',
                'sub_fields' => [
                    ['key' => 'field_okmovers_quote_move_type_label', 'label' => 'Label', 'name' => 'label', 'type' => 'text'],
                ],
            ],
            [
                'key' => 'field_okmovers_quote_move_windows',
                'label' => 'Quote form move windows',
                'name' => 'quote_form_move_windows',
                'type' => 'repeater',
                'button_label' => 'Add move window',
                'sub_fields' => [
                    ['key' => 'field_okmovers_quote_move_window_label', 'label' => 'Label', 'name' => 'label', 'type' => 'text'],
                ],
            ],
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
                            ['key' => 'field_okmovers_hero_intro', 'label' => 'Intro', 'name' => 'intro', 'type' => 'wysiwyg', 'tabs' => 'visual'],
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
                            ['key' => 'field_okmovers_services_intro', 'label' => 'Intro', 'name' => 'intro', 'type' => 'wysiwyg', 'tabs' => 'visual'],
                            [
                                'key' => 'field_okmovers_services_items',
                                'label' => 'Items',
                                'name' => 'items',
                                'type' => 'repeater',
                                'button_label' => 'Add item',
                                'sub_fields' => [
                                    ['key' => 'field_okmovers_services_item_title', 'label' => 'Title', 'name' => 'title', 'type' => 'text'],
                                    ['key' => 'field_okmovers_services_item_text', 'label' => 'Text', 'name' => 'text', 'type' => 'wysiwyg', 'tabs' => 'visual'],
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
                            ['key' => 'field_okmovers_benefits_intro', 'label' => 'Intro', 'name' => 'intro', 'type' => 'wysiwyg', 'tabs' => 'visual'],
                            [
                                'key' => 'field_okmovers_benefits_items',
                                'label' => 'Items',
                                'name' => 'items',
                                'type' => 'repeater',
                                'button_label' => 'Add benefit',
                                'sub_fields' => [
                                    ['key' => 'field_okmovers_benefits_item_title', 'label' => 'Title', 'name' => 'title', 'type' => 'text'],
                                    ['key' => 'field_okmovers_benefits_item_text', 'label' => 'Text', 'name' => 'text', 'type' => 'wysiwyg', 'tabs' => 'visual'],
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
                            ['key' => 'field_okmovers_cta_text', 'label' => 'Text', 'name' => 'text', 'type' => 'wysiwyg', 'tabs' => 'visual'],
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
                                    ['key' => 'field_okmovers_testimonial_quote', 'label' => 'Quote', 'name' => 'quote', 'type' => 'wysiwyg', 'tabs' => 'visual'],
                                    ['key' => 'field_okmovers_testimonial_author', 'label' => 'Author', 'name' => 'author', 'type' => 'text'],
                                    ['key' => 'field_okmovers_testimonial_role', 'label' => 'Role', 'name' => 'role', 'type' => 'text'],
                                    ['key' => 'field_okmovers_testimonial_image', 'label' => 'Photo', 'name' => 'image', 'type' => 'image', 'return_format' => 'array'],
                                ],
                            ],
                        ],
                    ],
                    'layout_okmovers_clients' => [
                        'key' => 'layout_okmovers_clients',
                        'name' => 'clients',
                        'label' => 'Clients logos',
                        'display' => 'block',
                        'sub_fields' => [
                            ['key' => 'field_okmovers_clients_title', 'label' => 'Title', 'name' => 'title', 'type' => 'text'],
                            ['key' => 'field_okmovers_clients_intro', 'label' => 'Intro', 'name' => 'intro', 'type' => 'wysiwyg', 'tabs' => 'visual'],
                            [
                                'key' => 'field_okmovers_clients_items',
                                'label' => 'Clients',
                                'name' => 'items',
                                'type' => 'repeater',
                                'button_label' => 'Add client',
                                'sub_fields' => [
                                    ['key' => 'field_okmovers_client_name', 'label' => 'Client name', 'name' => 'name', 'type' => 'text'],
                                    ['key' => 'field_okmovers_client_logo', 'label' => 'Logo', 'name' => 'logo', 'type' => 'image', 'return_format' => 'array'],
                                    ['key' => 'field_okmovers_client_link', 'label' => 'Link', 'name' => 'link', 'type' => 'link'],
                                ],
                            ],
                        ],
                    ],
                    'layout_okmovers_tips_grid' => [
                        'key' => 'layout_okmovers_tips_grid',
                        'name' => 'tips_grid',
                        'label' => 'Tips grid',
                        'display' => 'block',
                        'sub_fields' => [
                            ['key' => 'field_okmovers_tips_title', 'label' => 'Title', 'name' => 'title', 'type' => 'text'],
                            ['key' => 'field_okmovers_tips_intro', 'label' => 'Intro', 'name' => 'intro', 'type' => 'wysiwyg', 'tabs' => 'visual'],
                            ['key' => 'field_okmovers_tips_parent_page', 'label' => 'Parent page', 'name' => 'parent_page', 'type' => 'post_object', 'post_type' => ['page'], 'return_format' => 'id', 'ui' => 1],
                            ['key' => 'field_okmovers_tips_count', 'label' => 'Number of tips', 'name' => 'count', 'type' => 'number', 'default_value' => 14, 'min' => 1, 'max' => 24],
                            ['key' => 'field_okmovers_tips_button', 'label' => 'Archive button', 'name' => 'button', 'type' => 'link'],
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
                            ['key' => 'field_okmovers_quote_text', 'label' => 'Text', 'name' => 'text', 'type' => 'wysiwyg', 'tabs' => 'visual'],
                            ['key' => 'field_okmovers_quote_form_mode', 'label' => 'Form mode', 'name' => 'form_mode', 'type' => 'select', 'choices' => ['native' => 'Theme quote form', 'shortcode' => 'Shortcode']],
                            ['key' => 'field_okmovers_quote_form_shortcode', 'label' => 'Form shortcode', 'name' => 'form_shortcode', 'type' => 'text'],
                        ],
                    ],
                    'layout_okmovers_article_feed' => [
                        'key' => 'layout_okmovers_article_feed',
                        'name' => 'article_feed',
                        'label' => 'Article feed',
                        'display' => 'block',
                        'sub_fields' => [
                            ['key' => 'field_okmovers_articles_title', 'label' => 'Title', 'name' => 'title', 'type' => 'text'],
                            ['key' => 'field_okmovers_articles_intro', 'label' => 'Intro', 'name' => 'intro', 'type' => 'wysiwyg', 'tabs' => 'visual'],
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

add_filter('acf/fields/flexible_content/layout_title', 'okmovers_acf_layout_title_with_hash', 10, 4);
function okmovers_acf_layout_title_with_hash(string $title, array $field, array $layout, $index): string
{
    if (($field['key'] ?? '') !== 'field_okmovers_page_sections') {
        return $title;
    }

    $layout_name = sanitize_key((string) ($layout['name'] ?? ''));

    if ($layout_name === '') {
        return $title;
    }

    $tag = '#' . $layout_name;

    return $title . ' <span class="okmovers-layout-tag">' . esc_html($tag) . '</span>';
}

add_action('admin_head', 'okmovers_acf_layout_tag_admin_styles');
function okmovers_acf_layout_tag_admin_styles(): void
{
    ?>
    <style>
        .okmovers-layout-tag {
            color: #8a8f98;
            font-weight: 400;
            margin-left: 6px;
        }
    </style>
    <?php
}

add_action('acf/init', 'okmovers_seed_quote_option_defaults', 20);
function okmovers_seed_quote_option_defaults(): void
{
    if (! function_exists('update_field')) {
        return;
    }

    if (in_array(get_option('options_quote_form_delivery_mode', null), [null, ''], true)) {
        update_field('field_okmovers_quote_delivery_mode', 'endpoint', 'option');
    }

    if (in_array(get_option('options_quote_form_endpoint_url', null), [null, ''], true)) {
        update_field('field_okmovers_quote_endpoint_url', 'https://emailservice.ermine.ee/quote', 'option');
    }

    $move_types_count = get_option('options_quote_form_move_types', null);
    $move_windows_count = get_option('options_quote_form_move_windows', null);

    if (in_array($move_types_count, [null, '', '0', 0], true)) {
        update_field('field_okmovers_quote_move_types', [
            ['field_okmovers_quote_move_type_label' => 'Korter'],
            ['field_okmovers_quote_move_type_label' => 'Maja'],
            ['field_okmovers_quote_move_type_label' => 'Kontor'],
            ['field_okmovers_quote_move_type_label' => 'Üksikud esemed'],
            ['field_okmovers_quote_move_type_label' => 'Ladustamine'],
            ['field_okmovers_quote_move_type_label' => 'Tööstus/tehas'],
            ['field_okmovers_quote_move_type_label' => 'Muu'],
        ], 'option');
    }

    if (in_array($move_windows_count, [null, '', '0', 0], true)) {
        update_field('field_okmovers_quote_move_windows', [
            ['field_okmovers_quote_move_window_label' => 'Esimesel võimalusel'],
            ['field_okmovers_quote_move_window_label' => 'Sel nädalal'],
            ['field_okmovers_quote_move_window_label' => 'Järgmisel nädalal'],
            ['field_okmovers_quote_move_window_label' => 'Sel kuul'],
            ['field_okmovers_quote_move_window_label' => 'Kuupäev teada'],
        ], 'option');
    }
}

add_filter('acf/load_value/name=quote_form_move_types', 'okmovers_acf_default_quote_move_types', 10, 3);
function okmovers_acf_default_quote_move_types($value, $post_id, array $field)
{
    if (! in_array((string) $post_id, ['option', 'options'], true)) {
        return $value;
    }

    if (! empty($value)) {
        return $value;
    }

    return [
        ['label' => 'Korter'],
        ['label' => 'Maja'],
        ['label' => 'Kontor'],
        ['label' => 'Üksikud esemed'],
        ['label' => 'Ladustamine'],
        ['label' => 'Tööstus/tehas'],
        ['label' => 'Muu'],
    ];
}

add_filter('acf/load_value/name=quote_form_move_windows', 'okmovers_acf_default_quote_move_windows', 10, 3);
function okmovers_acf_default_quote_move_windows($value, $post_id, array $field)
{
    if (! in_array((string) $post_id, ['option', 'options'], true)) {
        return $value;
    }

    if (! empty($value)) {
        return $value;
    }

    return [
        ['label' => 'Esimesel võimalusel'],
        ['label' => 'Sel nädalal'],
        ['label' => 'Järgmisel nädalal'],
        ['label' => 'Sel kuul'],
        ['label' => 'Kuupäev teada'],
    ];
}

add_filter('acf/prepare_field/name=quote_form_move_types', 'okmovers_acf_prepare_quote_move_types_field');
function okmovers_acf_prepare_quote_move_types_field(array $field): array
{
    if (! empty($field['value'])) {
        return $field;
    }

    $field['value'] = [
        ['label' => 'Korter'],
        ['label' => 'Maja'],
        ['label' => 'Kontor'],
        ['label' => 'Üksikud esemed'],
        ['label' => 'Ladustamine'],
        ['label' => 'Tööstus/tehas'],
        ['label' => 'Muu'],
    ];

    return $field;
}

add_filter('acf/prepare_field/name=quote_form_move_windows', 'okmovers_acf_prepare_quote_move_windows_field');
function okmovers_acf_prepare_quote_move_windows_field(array $field): array
{
    if (! empty($field['value'])) {
        return $field;
    }

    $field['value'] = [
        ['label' => 'Esimesel võimalusel'],
        ['label' => 'Sel nädalal'],
        ['label' => 'Järgmisel nädalal'],
        ['label' => 'Sel kuul'],
        ['label' => 'Kuupäev teada'],
    ];

    return $field;
}
