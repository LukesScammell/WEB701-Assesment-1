<?php

/**
 * Plugin Name: Pixel Pals
 * Description: Pixel Pals prototype providing user registration, login, account information and token transactions.
 * Version: 1.0.0
 * Author: Pixel Pals
 */

if (!defined('ABSPATH')) {
    exit;
}

function pixel_pals_register_shortcode()
{
    $message = '';

    if (isset($_POST['pixel_pals_register'])) {

        if (
            !isset($_POST['pixel_pals_register_nonce']) ||
            !wp_verify_nonce($_POST['pixel_pals_register_nonce'], 'pixel_pals_register_action')
        ) {
            $message = 'Registration could not be verified.';
        } else {
            $name = sanitize_text_field($_POST['pixel_pals_name']);
            $email = sanitize_email($_POST['email']);
            $password = $_POST['password'];

            if (empty($name) || empty($email) || empty($password)) {
                $message = 'All fields are required.';
            } elseif (!is_email($email)) {
                $message = 'Please enter a valid email address.';
            } elseif (email_exists($email)) {
                $message = 'An account with this email already exists.';
            } elseif (strlen($password) < 8) {
                $message = 'Password must be at least 8 characters.';
            } else {
                $user_id = wp_create_user($email, $password, $email);

                if (is_wp_error($user_id)) {
                    $message = $user_id->get_error_message();
                } else {
                    wp_update_user([
                        'ID' => $user_id,
                        'display_name' => $name,
                        'first_name' => $name,
                    ]);

                    update_user_meta($user_id, 'pixel_pals_tokens', 100);

                    $message = 'Registration successful! You have received 100 tokens.';
                }
            }
        }
    }

    ob_start();
    ?>

    <div style="max-width: 500px; margin: 50px auto; font-family: Arial;">
        <h1>Pixel Pals</h1>
        <h2>Create Account</h2>

        <?php if ($message): ?>
            <p><?php echo esc_html($message); ?></p>
        <?php endif; ?>

        <form method="POST">
            <?php wp_nonce_field('pixel_pals_register_action', 'pixel_pals_register_nonce'); ?>

            <div style="margin-bottom: 15px;">
                <label>Name</label><br>
                <input type="text" name="pixel_pals_name" style="width: 100%; padding: 8px;" required>
            </div>

            <div style="margin-bottom: 15px;">
                <label>Email</label><br>
                <input type="email" name="email" style="width: 100%; padding: 8px;" required>
            </div>

            <div style="margin-bottom: 15px;">
                <label>Password</label><br>
                <input type="password" name="password" style="width: 100%; padding: 8px;" required>
            </div>

            <button type="submit" name="pixel_pals_register">Register</button>
        </form>
    </div>

    <?php

    return ob_get_clean();
}

add_shortcode('pixel_pals_register', 'pixel_pals_register_shortcode');

function pixel_pals_login_shortcode()
{
    $message = '';

    if (isset($_POST['pixel_pals_login'])) {

        if (
            !isset($_POST['pixel_pals_login_nonce']) ||
            !wp_verify_nonce($_POST['pixel_pals_login_nonce'], 'pixel_pals_login_action')
        ) {
            $message = 'Login could not be verified.';
        } else {
            $email = sanitize_email($_POST['pixel_pals_email']);
            $password = $_POST['pixel_pals_password'];

            if (empty($email) || empty($password)) {
                $message = 'Email and password are required.';
            } else {
                $user = wp_signon([
                    'user_login' => $email,
                    'user_password' => $password,
                    'remember' => true,
                ], false);

                if (is_wp_error($user)) {
                    $message = 'Invalid email or password.';
                } else {
                    $message = 'Login successful! Welcome ' . $user->display_name . '.';
                }
            }
        }
    }

    ob_start();
    ?>

    <div style="max-width: 500px; margin: 50px auto; font-family: Arial;">
        <h1>Pixel Pals</h1>
        <h2>Login</h2>

        <?php if ($message): ?>
            <p><?php echo esc_html($message); ?></p>
        <?php endif; ?>

        <?php if (is_user_logged_in()): ?>

            <p>You are currently logged in.</p>

        <?php else: ?>

            <form method="POST">
                <?php wp_nonce_field('pixel_pals_login_action', 'pixel_pals_login_nonce'); ?>

                <div style="margin-bottom: 15px;">
                    <label>Email</label><br>
                    <input type="email" name="pixel_pals_email" style="width: 100%; padding: 8px;" required>
                </div>

                <div style="margin-bottom: 15px;">
                    <label>Password</label><br>
                    <input type="password" name="pixel_pals_password" style="width: 100%; padding: 8px;" required>
                </div>

                <button type="submit" name="pixel_pals_login">Login</button>
            </form>

        <?php endif; ?>
    </div>

    <?php

    return ob_get_clean();
}

add_shortcode('pixel_pals_login', 'pixel_pals_login_shortcode');

function pixel_pals_account_shortcode()
{
    if (!is_user_logged_in()) {
        return '
            <div style="max-width: 500px; margin: 50px auto; font-family: Arial;">
                <h1>Pixel Pals</h1>
                <h2>Account</h2>
                <p>You must be logged in to view your account.</p>
            </div>
        ';
    }

    $user = wp_get_current_user();
    $tokens = get_user_meta($user->ID, 'pixel_pals_tokens', true);

    if ($tokens === '') {
        $tokens = 0;
    }

    ob_start();
    ?>

    <div style="max-width: 500px; margin: 50px auto; font-family: Arial;">
        <h1>Pixel Pals</h1>
        <h2>Account</h2>

        <p><strong>Name:</strong> <?php echo esc_html($user->display_name); ?></p>

        <p><strong>Email:</strong> <?php echo esc_html($user->user_email); ?></p>

        <p><strong>Token Balance:</strong> <?php echo esc_html($tokens); ?></p>
    </div>

    <?php

    return ob_get_clean();
}

add_shortcode('pixel_pals_account', 'pixel_pals_account_shortcode');

function pixel_pals_transaction_shortcode()
{
    if (!is_user_logged_in()) {
        return '<p>You must be logged in to make a transaction.</p>';
    }

    $user_id = get_current_user_id();
    $tokens = (int) get_user_meta($user_id, 'pixel_pals_tokens', true);
    $message = '';

    if (isset($_POST['pixel_pals_transaction'])) {

        if (
            !isset($_POST['pixel_pals_transaction_nonce']) ||
            !wp_verify_nonce($_POST['pixel_pals_transaction_nonce'], 'pixel_pals_transaction_action')
        ) {
            $message = 'Transaction could not be verified.';
        } else {
            $amount = intval($_POST['amount']);

            if ($amount <= 0) {
                $message = 'Please enter a valid token amount.';
            } elseif ($amount > $tokens) {
                $message = 'You do not have enough tokens.';
            } else {
                $tokens = $tokens - $amount;

                update_user_meta($user_id, 'pixel_pals_tokens', $tokens);

                $message = 'Transaction successful! You spent ' . $amount . ' tokens.';
            }
        }
    }

    ob_start();
    ?>

    <div style="max-width: 500px; margin: 50px auto; font-family: Arial;">
        <h1>Pixel Pals</h1>
        <h2>Token Transaction</h2>

        <p>Current Balance: <?php echo esc_html($tokens); ?> tokens</p>

        <?php if ($message): ?>
            <p><?php echo esc_html($message); ?></p>
        <?php endif; ?>

        <form method="POST">
            <?php wp_nonce_field('pixel_pals_transaction_action', 'pixel_pals_transaction_nonce'); ?>

            <div style="margin-bottom: 15px;">
                <label>Amount</label><br>
                <input type="number" name="amount" min="1" style="width: 100%; padding: 8px;" required>
            </div>

            <button type="submit" name="pixel_pals_transaction">Spend Tokens</button>
        </form>
    </div>

    <?php

    return ob_get_clean();
}

add_shortcode('pixel_pals_transaction', 'pixel_pals_transaction_shortcode');