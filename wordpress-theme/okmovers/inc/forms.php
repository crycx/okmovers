<?php



add_action('admin_post_nopriv_okmovers_submit_contact', 'okmovers_handle_contact_form');

add_action('admin_post_okmovers_submit_contact', 'okmovers_handle_contact_form');

add_action('admin_post_nopriv_okmovers_submit_quote', 'okmovers_handle_quote_form');

add_action('admin_post_okmovers_submit_quote', 'okmovers_handle_quote_form');

add_action('wp_ajax_nopriv_okmovers_submit_contact_ajax', 'okmovers_handle_contact_form_ajax');

add_action('wp_ajax_okmovers_submit_contact_ajax', 'okmovers_handle_contact_form_ajax');

add_action('wp_ajax_nopriv_okmovers_submit_quote_ajax', 'okmovers_handle_quote_form_ajax');

add_action('wp_ajax_okmovers_submit_quote_ajax', 'okmovers_handle_quote_form_ajax');

add_action('init', 'okmovers_register_form_shortcodes');



function okmovers_register_form_shortcodes(): void

{

    add_shortcode('okmovers_quote_form', static function (): string {

        ob_start();

        okmovers_render_contact_form('quote');



        return (string) ob_get_clean();

    });



    add_shortcode('okmovers_contact_form', static function (): string {

        ob_start();

        okmovers_render_contact_form('contact');



        return (string) ob_get_clean();

    });



    add_shortcode('okmovers_form', static function ($atts): string {

        $attributes = shortcode_atts([

            'mode' => 'quote',

        ], is_array($atts) ? $atts : []);



        $mode = sanitize_key((string) ($attributes['mode'] ?? 'quote'));

        $mode = $mode === 'contact' ? 'contact' : 'quote';



        ob_start();

        okmovers_render_contact_form($mode);



        return (string) ob_get_clean();

    });

}



function okmovers_get_form_messages(): array

{

    $quote_success = (string) okmovers_get_option_field('quote_form_success_message', __('Aitah. Hinnapäring on saadetud.', 'okmovers'));

    $quote_validation = (string) okmovers_get_option_field('quote_form_validation_message', __('Palun täitke kõik nõutud väljad.', 'okmovers'));

    $quote_error = (string) okmovers_get_option_field('quote_form_error_message', __('Saatmine ebaõnnestus. Proovige uuesti või võtke meiega otse ühendust.', 'okmovers'));



    return [

        'contact_success' => __('Aitah. Teie kiri on saadetud.', 'okmovers'),

        'quote_success'   => $quote_success,

        'validation'      => __('Palun täitke kõik nõutud väljad.', 'okmovers'),

        'send_error'      => __('Saatmine ebaõnnestus. Proovige uuesti või võtke meiega otse ühendust.', 'okmovers'),

        'quote_validation' => $quote_validation,

        'quote_send_error' => $quote_error,

    ];

}



function okmovers_get_quote_form_ui_config(): array

{

    return [

        'submit_label' => (string) okmovers_get_option_field('quote_form_submit_label', __('Saada hinnapäring', 'okmovers')),

        'submit_loading_label' => __('Saadan...', 'okmovers'),

        'placeholder_name' => (string) okmovers_get_option_field('quote_form_placeholder_name', __('Sinu nimi', 'okmovers')),

        'placeholder_email' => (string) okmovers_get_option_field('quote_form_placeholder_email', __('E-posti aadress', 'okmovers')),

        'placeholder_phone' => (string) okmovers_get_option_field('quote_form_placeholder_phone', __('Telefon', 'okmovers')),

        'placeholder_from_details' => (string) okmovers_get_option_field('quote_form_placeholder_from_details', __('Peale laadimise aadress/korrus/lift?', 'okmovers')),

        'placeholder_to_details' => (string) okmovers_get_option_field('quote_form_placeholder_to_details', __('Maha laadimise aadress/korrus/lift?', 'okmovers')),

        'placeholder_inventory' => (string) okmovers_get_option_field('quote_form_placeholder_inventory', __('Siia palume sisestada võimalikult täpse asjade loetelu, kas on vaja midagi demonteerida, kas soovite kolimiskaste jne', 'okmovers')),

    ];

}



function okmovers_submit_quote_to_endpoint(array $fields): bool

{

    $endpoint_url = (string) okmovers_get_option_field('quote_form_endpoint_url', '');



    if ($endpoint_url === '') {

        return false;

    }



    $payload = [

        'name' => $fields['name'] ?? '',

        'email' => $fields['email'] ?? '',

        'phone' => $fields['phone'] ?? '',

        'date' => $fields['move_window'] ?? '',

        'start_floor' => $fields['from_details'] ?? '',

        'end_floor' => $fields['to_details'] ?? '',

        'list' => implode("\n", array_filter([

            ! empty($fields['move_type']) ? 'Teenuse tüüp: ' . $fields['move_type'] : '',

            ! empty($fields['move_window']) ? 'Kolimise aeg: ' . $fields['move_window'] : '',

            ! empty($fields['from_details']) ? 'Kust: ' . $fields['from_details'] : '',

            ! empty($fields['to_details']) ? 'Kuhu: ' . $fields['to_details'] : '',

            ! empty($fields['inventory']) ? 'Lisainfo: ' . $fields['inventory'] : '',

        ])),

        'move_type' => $fields['move_type'] ?? '',

        'move_window' => $fields['move_window'] ?? '',

    ];



    $response = wp_remote_post($endpoint_url, [

        'timeout' => 20,

        'body' => $payload,

    ]);



    if (is_wp_error($response)) {

        return false;

    }



    $status_code = (int) wp_remote_retrieve_response_code($response);



    return $status_code >= 200 && $status_code < 300;

}



function okmovers_should_use_quote_mailservice(): bool
{
    $use_mailservice = get_option('options_quote_form_use_mailservice', null);

    if (! in_array($use_mailservice, [null, ''], true)) {
        return in_array($use_mailservice, [true, 1, '1', 'yes', 'on'], true);
    }

    $legacy_delivery_mode = sanitize_key((string) get_option('options_quote_form_delivery_mode', 'endpoint'));

    return $legacy_delivery_mode !== 'email';
}

function okmovers_get_quote_form_choice_list(string $option_field, array $fallback): array
{

    $rows = okmovers_get_option_field($option_field, []);



    if (! is_array($rows) || empty($rows)) {

        return $fallback;

    }



    $choices = [];



    foreach ($rows as $row) {

        $label = trim((string) ($row['label'] ?? ''));



        if ($label !== '') {

            $choices[] = $label;

        }

    }



    return ! empty($choices) ? $choices : $fallback;

}



function okmovers_get_form_response(): array

{

    $messages = okmovers_get_form_messages();

    $status = sanitize_key((string) wp_unslash($_GET['form-status'] ?? ''));

    $message_id = sanitize_key((string) wp_unslash($_GET['form-message'] ?? ''));



    if (! $status || ! isset($messages[$message_id])) {

        return ['status' => '', 'message' => ''];

    }



    return [

        'status'  => $status,

        'message' => $messages[$message_id],

    ];

}



function okmovers_get_form_redirect_url(string $status, string $message_id): string

{

    $url = wp_get_referer();



    if (! $url) {

        $url = home_url('/');

    }



    $url = add_query_arg([

        'form-status'  => $status,

        'form-message' => $message_id,

    ], $url);



    return $url . '#form-response';

}



function okmovers_send_form_response(bool $is_ajax, bool $success, string $message_id): void

{

    $messages = okmovers_get_form_messages();

    $message = (string) ($messages[$message_id] ?? '');



    if ($is_ajax) {

        if ($success) {

            wp_send_json_success(['message' => $message]);

        }



        wp_send_json_error(['message' => $message], 400);

    }



    wp_safe_redirect(okmovers_get_form_redirect_url($success ? 'success' : 'error', $message_id));

    exit;

}



function okmovers_handle_contact_form(): void

{

    okmovers_process_contact_form(false);

}



function okmovers_handle_contact_form_ajax(): void

{

    okmovers_process_contact_form(true);

}



function okmovers_process_contact_form(bool $is_ajax): void

{

    $name = sanitize_text_field((string) wp_unslash($_POST['name'] ?? ''));

    $email = sanitize_email((string) wp_unslash($_POST['email'] ?? ''));

    $message = sanitize_textarea_field((string) wp_unslash($_POST['message'] ?? ''));



    if (! wp_verify_nonce((string) wp_unslash($_POST['okmovers_contact_nonce'] ?? ''), 'okmovers_contact_form')) {

        okmovers_send_form_response($is_ajax, false, 'send_error');

    }



    if (! $name || ! $email || ! $message) {

        okmovers_send_form_response($is_ajax, false, 'validation');

    }



    $recipient = okmovers_get_option_field('contact_recipient_email', get_option('admin_email'));

    $subject = sprintf(__('Kontaktivorm: %s', 'okmovers'), $name);

    $body = "Nimi: {$name}\nE-post: {$email}\n\nSisu:\n{$message}";

    $headers = ['Reply-To: ' . $name . ' <' . $email . '>'];



    $sent = wp_mail($recipient, $subject, $body, $headers);



    okmovers_send_form_response($is_ajax, $sent, $sent ? 'contact_success' : 'send_error');

}



function okmovers_handle_quote_form(): void

{

    okmovers_process_quote_form(false);

}



function okmovers_handle_quote_form_ajax(): void

{

    okmovers_process_quote_form(true);

}



function okmovers_process_quote_form(bool $is_ajax): void

{

    $fields = [

        'name'         => sanitize_text_field((string) wp_unslash($_POST['name'] ?? '')),

        'email'        => sanitize_email((string) wp_unslash($_POST['email'] ?? '')),

        'phone'        => sanitize_text_field((string) wp_unslash($_POST['phone'] ?? '')),

        'move_type'    => sanitize_text_field((string) wp_unslash($_POST['move_type'] ?? '')),

        'move_window'  => sanitize_text_field((string) wp_unslash($_POST['move_window'] ?? '')),

        'from_details' => sanitize_text_field((string) wp_unslash($_POST['from_details'] ?? '')),

        'to_details'   => sanitize_text_field((string) wp_unslash($_POST['to_details'] ?? '')),

        'inventory'    => sanitize_textarea_field((string) wp_unslash($_POST['inventory'] ?? '')),

    ];



    if (! wp_verify_nonce((string) wp_unslash($_POST['okmovers_quote_nonce'] ?? ''), 'okmovers_quote_form')) {

        okmovers_send_form_response($is_ajax, false, 'quote_send_error');

    }



    $required_keys = ['name', 'move_type', 'move_window'];



    foreach ($required_keys as $key) {

        if (empty($fields[$key])) {

            okmovers_send_form_response($is_ajax, false, 'quote_validation');

        }

    }



    if ($fields['email'] === '' && $fields['phone'] === '') {

        okmovers_send_form_response($is_ajax, false, 'quote_validation');

    }



    if ($fields['email'] !== '' && ! is_email($fields['email'])) {

        okmovers_send_form_response($is_ajax, false, 'quote_validation');

    }





    if (okmovers_should_use_quote_mailservice()) {
        $sent = okmovers_submit_quote_to_endpoint($fields);

        okmovers_send_form_response($is_ajax, $sent, $sent ? 'quote_success' : 'quote_send_error');

    }



    $recipient = okmovers_get_option_field('quote_recipient_email', get_option('admin_email'));

    $subject = sprintf(__('Hinnapäring: %s', 'okmovers'), $fields['name']);

    $body = implode("\n", [

        'Nimi: ' . $fields['name'],

        'E-post: ' . ($fields['email'] !== '' ? $fields['email'] : '-'),

        'Telefon: ' . ($fields['phone'] !== '' ? $fields['phone'] : '-'),

        'Kolimise tüüp: ' . $fields['move_type'],

        'Millal kolida: ' . $fields['move_window'],

        'Pealelaadimine: ' . ($fields['from_details'] !== '' ? $fields['from_details'] : '-'),

        'Mahalaadimine: ' . ($fields['to_details'] !== '' ? $fields['to_details'] : '-'),

        '',

        'Asjade loetelu ja lisainfo:',

        ($fields['inventory'] !== '' ? $fields['inventory'] : '-'),

    ]);

    $headers = [];



    if ($fields['email'] !== '') {

        $headers[] = 'Reply-To: ' . $fields['name'] . ' <' . $fields['email'] . '>';

    }



    $sent = wp_mail($recipient, $subject, $body, $headers);



    okmovers_send_form_response($is_ajax, $sent, $sent ? 'quote_success' : 'quote_send_error');

}



function okmovers_render_contact_form(string $mode = 'contact'): void

{

    $response = okmovers_get_form_response();

    $is_quote = $mode === 'quote';

    $quote_ui = $is_quote ? okmovers_get_quote_form_ui_config() : [];

    $quote_move_types = $is_quote ? okmovers_get_quote_form_choice_list('quote_form_move_types', [

        'Korter',

        'Maja',

        'Kontor',

        'Üksikud esemed',

        'Ladustamine',

        'Tööstus/tehas',

        'Muu',

    ]) : [];

    $quote_move_windows = $is_quote ? okmovers_get_quote_form_choice_list('quote_form_move_windows', [

        'Esimesel võimalusel',

        'Sel nädalal',

        'Järgmisel nädalal',

        'Sel kuul',

        'Kuupäev teada',

    ]) : [];

    $has_response = ! empty($response['status']) && ! empty($response['message']);

    ?>

    <div class="contact-form" id="form-response" data-contact-form>

        <div class="form-response<?php echo $has_response ? ' form-response--' . esc_attr($response['status']) : ' is-hidden'; ?>" data-form-response<?php echo $has_response ? '' : ' hidden'; ?>>

            <?php echo $has_response ? esc_html($response['message']) : ''; ?>

        </div>



        <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" class="contact-form__form">

            <input type="hidden" name="action" value="<?php echo esc_attr($is_quote ? 'okmovers_submit_quote' : 'okmovers_submit_contact'); ?>">



            <?php if ($is_quote) : ?>

                <?php wp_nonce_field('okmovers_quote_form', 'okmovers_quote_nonce'); ?>

            <?php else : ?>

                <?php wp_nonce_field('okmovers_contact_form', 'okmovers_contact_nonce'); ?>

            <?php endif; ?>



            <div class="contact-form__grid<?php echo $is_quote ? ' contact-form__grid--quote' : ''; ?>">

                <label>

                    <span><?php esc_html_e('Nimi', 'okmovers'); ?></span>

                    <input type="text" name="name" placeholder="<?php echo esc_attr($is_quote ? $quote_ui['placeholder_name'] : ''); ?>" required>

                </label>



                <?php if ($is_quote) : ?>

                    <label>

                        <span><?php esc_html_e('Telefon', 'okmovers'); ?></span>

                        <input type="text" name="phone" placeholder="<?php echo esc_attr($quote_ui['placeholder_phone']); ?>">

                    </label>

                    <label>

                        <span><?php esc_html_e('E-post', 'okmovers'); ?></span>

                        <input type="email" name="email" placeholder="<?php echo esc_attr($quote_ui['placeholder_email']); ?>">

                    </label>



                    <div class="contact-form__full quote-choice-group">

                        <p class="quote-choice-group__label"><?php esc_html_e('Kolimise tüüp', 'okmovers'); ?></p>

                        <div class="quote-choice-grid quote-choice-grid--radios">

                            <?php foreach ($quote_move_types as $index => $choice) : ?>

                                <?php $choice_id = 'quote-move-type-' . $index; ?>

                                <label class="quote-choice-option" for="<?php echo esc_attr($choice_id); ?>">

                                    <input id="<?php echo esc_attr($choice_id); ?>" type="radio" name="move_type" value="<?php echo esc_attr($choice); ?>"<?php echo $index === 0 ? ' checked' : ''; ?>>

                                    <span><?php echo esc_html($choice); ?></span>

                                </label>

                            <?php endforeach; ?>

                        </div>

                    </div>



                    <div class="contact-form__full quote-choice-group">

                        <p class="quote-choice-group__label"><?php esc_html_e('Millal kolida?', 'okmovers'); ?></p>

                        <div class="quote-choice-grid quote-choice-grid--radios">

                            <?php foreach ($quote_move_windows as $index => $choice) : ?>

                                <?php $choice_id = 'quote-move-window-' . $index; ?>

                                <label class="quote-choice-option" for="<?php echo esc_attr($choice_id); ?>">

                                    <input id="<?php echo esc_attr($choice_id); ?>" type="radio" name="move_window" value="<?php echo esc_attr($choice); ?>"<?php echo $index === 0 ? ' checked' : ''; ?>>

                                    <span><?php echo esc_html($choice); ?></span>

                                </label>

                            <?php endforeach; ?>

                        </div>

                    </div>



                    <label>

                        <span><?php esc_html_e('Kust?', 'okmovers'); ?></span>

                        <input type="text" name="from_details" placeholder="<?php echo esc_attr($quote_ui['placeholder_from_details']); ?>">

                    </label>

                    <label>

                        <span><?php esc_html_e('Kuhu?', 'okmovers'); ?></span>

                        <input type="text" name="to_details" placeholder="<?php echo esc_attr($quote_ui['placeholder_to_details']); ?>">

                    </label>

                    <label class="contact-form__full">

                        <span><?php esc_html_e('Lisainfo', 'okmovers'); ?></span>

                        <textarea name="inventory" rows="7" placeholder="<?php echo esc_attr($quote_ui['placeholder_inventory']); ?>"></textarea>

                    </label>

                <?php else : ?>

                    <label>

                        <span><?php esc_html_e('E-post', 'okmovers'); ?></span>

                        <input type="email" name="email" placeholder="">

                    </label>

                    <label class="contact-form__full">

                        <span><?php esc_html_e('Sõnum', 'okmovers'); ?></span>

                        <textarea name="message" rows="6" required></textarea>

                    </label>

                <?php endif; ?>

            </div>



            <button class="button button-primary" type="submit"<?php echo $is_quote ? ' data-submit-default-label="' . esc_attr($quote_ui['submit_label']) . '" data-submit-loading-label="' . esc_attr($quote_ui['submit_loading_label']) . '"' : ''; ?>>

                <?php echo esc_html($is_quote ? $quote_ui['submit_label'] : __('Saada kiri', 'okmovers')); ?>

            </button>

        </form>

    </div>

    <?php

}

