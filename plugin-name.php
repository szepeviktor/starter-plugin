<?php

/**
 * Plugin Name
 *
 * @package           company/smallproject
 * @author            Your Name <username@example.com>
 * @copyright         2019 Your Name or Company Name
 * @license           GPL-2.0-or-later http://www.gnu.org/licenses/gpl-2.0.txt
 * @link              https://example.com/plugin-name
 *
 * @wordpress-plugin
 * Plugin Name:       Plugin Name
 * Plugin URI:        https://example.com/plugin-name
 * Description:       Description of the plugin.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.4
 * Author:            Your Name
 * Author URI:        https://example.com
 * Text Domain:       plugin-slug
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

declare(strict_types=1);

namespace Company\WordPress\PluginName;

use function add_action;
use function current_user_can;
use function deactivate_plugins;
use function esc_html;
use function esc_html__;
use function plugin_basename;
use function register_activation_hook;
use function register_deactivation_hook;
use function register_uninstall_hook;

// Prevent direct execution.
if (! defined('ABSPATH')) {
    exit;
}

// Load autoloader.
if (! class_exists(Config::class) && is_file(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}

// Prevent double activation.
if (Config::get('version') !== null) {
    add_action(
        'admin_notices',
        static function () {
            // phpcs:ignore Squiz.PHP.DiscouragedFunctions.Discouraged
            error_log('Plugin Name double activation. Please remove all but one copies. ' . __FILE__);

            if (! current_user_can('activate_plugins')) {
                return;
            }

            printf(
                '<div class="notice notice-warning"><p>%1$s<br>%2$s&nbsp;<code>%3$s</code></p></div>',
                esc_html__('Plugin Name already installed! Please deactivate all but one copies.', 'plugin-slug'),
                esc_html__('Current plugin path:', 'plugin-slug'),
                esc_html(__FILE__)
            );
        },
        0,
        0
    );
    return;
}

// Define constant values.
Config::init(
    [
        'version' => '1.0.0',
        'filePath' => __FILE__,
        'baseName' => plugin_basename(__FILE__),
        'slug' => 'plugin-slug',
        // Textdomain should be a literal string everywhere.
        // Adding 'url' here makes it unfilterable. E.g. for CDN usage.
    ]
);

// Load translations.
add_action('init', __NAMESPACE__ . '\\loadTextDomain', 10, 0);

// Check requirements.
if (
    (new Requirements())
        ->php('7.4')
        ->wp('5.2')
        ->multisite(false)
        ->plugins(['polylang/polylang.php'])
        ->theme('Avada')
        ->packages(['psr/container', 'psr/log-implementation'])
        ->met()
) {
    // Hook plugin activation functions.
    register_activation_hook(__FILE__, __NAMESPACE__ . '\\activate');
    register_deactivation_hook(__FILE__, __NAMESPACE__ . '\\deactivate');
    register_uninstall_hook(__FILE__, __NAMESPACE__ . '\\uninstall');
    add_action('plugins_loaded', __NAMESPACE__ . '\\boot', 10, 0);

    // Support WP-CLI.
    if (defined('WP_CLI') && \WP_CLI === true) {
        registerCliCommands();
    }
} else {
    // Suppress "Plugin activated." notice.
    unset($_GET['activate']); // phpcs:ignore WordPress.Security.NonceVerification.Recommended

    add_action('admin_notices', __NAMESPACE__ . '\\printRequirementsNotice', 0, 0);

    require_once \ABSPATH . 'wp-admin/includes/plugin.php';
    deactivate_plugins([Config::get('baseName')], true);
}
