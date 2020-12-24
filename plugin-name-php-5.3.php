<?php

/**
 * Plugin Name
 *
 * @package           PluginPackage
 * @author            Your Name
 * @copyright         2019 Your Name or Company Name
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Plugin Name loader with PHP 5.3 support
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

if (! defined('ABSPATH')) {
    exit;
}

// Check PHP version.
if (version_compare(PHP_VERSION, '7.4', '>=')) {
    require dirname(__FILE__) . '/plugin-name.php';
} else {
    // Load translations for admin notice.
    add_action(
        'init',
        function () {
            load_plugin_textdomain(
                'plugin-slug',
                false,
                dirname(plugin_basename(__FILE__)) . '/languages'
            );
        },
        10,
        0
    );
    add_action(
        'admin_notices',
        function () {
            $message = __('PluginName cannot run on PHP versions older than %1$s. Please contact your host and ask them to upgrade.', 'plugin-slug');
            printf('<div class="notice notice-error"><p>%1$s</p></div>', esc_html(sprintf($message, '7.4')));
        },
        0,
        0
    );
    require_once ABSPATH . 'wp-admin/includes/plugin.php';
    \deactivate_plugins(array(plugin_basename(__FILE__)), true);
}