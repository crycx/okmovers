<?php

add_action('admin_post_nopriv_okmovers_submit_contact', 'okmovers_handle_contact_form');
add_action('admin_post_okmovers_submit_contact', 'okmovers_handle_contact_form');
add_action('admin_post_nopriv_okmovers_submit_quote', 'okmovers_handle_quote_form');
add_action('admin_post_okmovers_submit_quote', 'okmovers_handle_quote_form');

function okmovers_get_form_messages(): array
{
    return [
        'contact_success' => __('Aitah. Teie kiri on saadetud.', 'okmovers'),
        'quote_success'   => __('Aitah. Hinnapäring on saadetud.', 'okmovers'),
        'validation'      => __('Palun täitke kõik nõutud väljad.', 'okmovers'),
        'send_error'      => __('Saatmine ebaõnnestus. Proovige uuesti või võtke meiega otse ühendust.', 'okmovers'),
    ];
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

function okmovers_handle_contact_form(): void
{
    $name = sanitize_text_field((string) wp_unslash($_POST['name'] ?? ''));
    $email = sanitize_email((string) wp_unslash($_POST['email'] ?? ''));
    $message = sanitize_textarea_field((string) wp_unslash($_POST['message'] ?? ''));

    if (! wp_verify_nonce((string) wp_unslash($_POST['okmovers_contact_nonce'] ?? ''), 'okmovers_contact_form')) {
        wp_safe_redirect(okmovers_get_form_redirect_url('error', 'send_error'));
        exit;
    }

    if (! $name || ! $email || ! $message) {
        wp_safe_redirect(okmovers_get_form_redirect_url('error', 'validation'));
        exit;
    }

    $recipient = okmovers_get_option_field('contact_recipient_email', get_option('admin_email'));
    $subject = sprintf(__('Kontaktivorm: %s', 'okmovers'), $name);
    $body = "Nimi: {$name}\nE-post: {$email}\n\nSisu:\n{$message}";
    $headers = ['Reply-To: ' . $name . ' <' . $email . '>'];

    $sent = wp_mail($recipient, $subject, $body, $headers);

    wp_safe_redirect(okmovers_get_form_redirect_url($sent ? 'success' : 'error', $sent ? 'contact_success' : 'send_error'));
    exit;
}

function okmovers_handle_quote_form(): void
{
    $fields = [
        'name'         => sanitize_text_field((string) wp_unslash($_POST['name'] ?? '')),
        'email'        => sanitize_email((string) wp_unslash($_POST['email'] ?? '')),
        'phone'        => sanitize_text_field((string) wp_unslash($_POST['phone'] ?? '')),
        'move_date'    => sanitize_text_field((string) wp_unslash($_POST['move_date'] ?? '')),
        'from_details' => sanitize_text_field((string) wp_unslash($_POST['from_details'] ?? '')),
        'to_details'   => sanitize_text_field((string) wp_unslash($_POST['to_details'] ?? '')),
        'inventory'    => sanitize_textarea_field((string) wp_unslash($_POST['inventory'] ?? '')),
    ];

    if (! wp_verify_nonce((string) wp_unslash($_POST['okmovers_quote_nonce'] ?? ''), 'okmovers_quote_form')) {
        wp_safe_redirect(okmovers_get_form_redirect_url('error', 'send_error'));
        exit;
    }

    foreach ($fields as $value) {
        if (! $value) {
            wp_safe_redirect(okmovers_get_form_redirect_url('error', 'validation'));
            exit;
        }
    }

    $recipient = okmovers_get_option_field('quote_recipient_email', get_option('admin_email'));
    $subject = sprintf(__('Hinnapäring: %s', 'okmovers'), $fields['name']);
    $body = implode("\n", [
        'Nimi: ' . $fields['name'],
        'E-post: ' . $fields['email'],
        'Telefon: ' . $fields['phone'],
        'Kolimise kuupäev: ' . $fields['move_date'],
        'Pealelaadimine: ' . $fields['from_details'],
        'Mahalaadimine: ' . $fields['to_details'],
        '',
        'Asjade loetelu:',
        $fields['inventory'],
    ]);
    $headers = ['Reply-To: ' . $fields['name'] . ' <' . $fields['email'] . '>'];

    $sent = wp_mail($recipient, $subject, $body, $headers);

    wp_safe_redirect(okmovers_get_form_redirect_url($sent ? 'success' : 'error', $sent ? 'quote_success' : 'send_error'));
    exit;
}

function okmovers_render_contact_form(string $mode = 'contact'): void
{
    $response = okmovers_get_form_response();
    $is_quote = $mode === 'quote';
    ?>
    <div class="contact-form" id="form-response">
        <?php if ($response['status'] && $response['message']) : ?>
            <div class="form-response form-response--<?php echo esc_attr($response['status']); ?>">
                <?php echo esc_html($response['message']); ?>
            </div>
        <?php endif; ?>

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
                    <input type="text" name="name" required>
                </label>
                <label>
                    <span><?php esc_html_e('E-post', 'okmovers'); ?></span>
                    <input type="email" name="email" required>
                </label>

                <?php if ($is_quote) : ?>
                    <label>
                        <span><?php esc_html_e('Telefon', 'okmovers'); ?></span>
                        <input type="text" name="phone" required>
                    </label>
                    <label>
                        <span><?php esc_html_e('Kolimise kuupäev', 'okmovers'); ?></span>
                        <input type="text" name="move_date" required>
                    </label>
                    <label>
                        <span><?php esc_html_e('Pealelaadimise aadress / korrus / lift', 'okmovers'); ?></span>
                        <input type="text" name="from_details" required>
                    </label>
                    <label>
                        <span><?php esc_html_e('Mahalaadimise aadress / korrus / lift', 'okmovers'); ?></span>
                        <input type="text" name="to_details" required>
                    </label>
                    <label class="contact-form__full">
                        <span><?php esc_html_e('Asjade loetelu ja lisainfo', 'okmovers'); ?></span>
                        <textarea name="inventory" rows="7" required></textarea>
                    </label>
                <?php else : ?>
                    <label class="contact-form__full">
                        <span><?php esc_html_e('Sõnum', 'okmovers'); ?></span>
                        <textarea name="message" rows="6" required></textarea>
                    </label>
                <?php endif; ?>
            </div>

            <button class="button button-primary" type="submit">
                <?php echo esc_html($is_quote ? __('Saada hinnapäring', 'okmovers') : __('Saada kiri', 'okmovers')); ?>
            </button>
        </form>
    </div>
    <?php
}
