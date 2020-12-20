<?php

//: https://developer.wordpress.org/plugins/plugin-basics/header-requirements/#header-fields
/**
 * Plugin Name
 *
 * @package           PluginPackage
 * @author            Your Name
 * @copyright         2019 Your Name or Company Name
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Plugin Name
 * Plugin URI:        https://example.com/plugin-name
 * Description:       Description of the plugin.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Your Name
 * Author URI:        https://example.com
 * Text Domain:       plugin-slug
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

//: https://www.php.net/manual/en/language.types.declarations.php#language.types.declarations.strict
// declare(strict_types=1);

//: https://www.php-fig.org/psr/psr-4/#2-specification
namespace Company\WordPress\PluginName;

//: Prevent direct execution
if (! defined('ABSPATH')) {
    exit;
}

//: Define constants
define('PLUGIN_NAME_TEXTDOMAIN', 'plugin-name');

//: Load autoloader
if (! class_exists(Requirements::class) && is_file(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}

//: Load translations
\add_action(
    'init',
    function () {
        \load_plugin_textdomain(\PLUGIN_NAME_TEXTDOMAIN, false, dirname(\plugin_basename(__FILE__)) . '/languages');
    },
    10,
    0
);

//: Check requirements
if ((new Requirements())
        ->php('7.4')
        ->wp('4.9')
        ->multisite(false)
        ->plugins(['polylang/polylang.php'])
        ->packages(['psr/container', 'psr/log-implementation'])
        ->passes()
) {
    //: Hook plugin state callback functions.
    \register_activation_hook(__FILE__, __NAMESPACE__ . '\\activate');
    \register_deactivation_hook(__FILE__, __NAMESPACE__ . '\\deactivate');
    \register_uninstall_hook(__FILE__, __NAMESPACE__ . '\\uninstall');
    \add_action('plugins_loaded', __NAMESPACE__ . '\\boot', 10, 0);
    //: Support WP-CLI.
    if (defined('WP_CLI') && \WP_CLI === true) {
        registerCliCommands();
    }
} else {
    \add_action('admin_notices', __NAMESPACE__ . '\\printRequirementsNotice');
}

