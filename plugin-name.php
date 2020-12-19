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
declare(strict_types=1);

//: https://www.php-fig.org/psr/psr-4/#2-specification
namespace Company\WordPress\PluginName;

//: Prevent direct execution
if (! defined('ABSPATH')) {
    exit;
}

//: Check requirements
if ( // Should be PHP 5.3.2 compatible!
    (new Requirements())
        ->php('7.4')
        ->wp('4.9')
        ->multisite(false)
        ->plugins(['polylang/polylang.php'])
        ->packages(['psr/container', 'psr/log-implementation'])
        ->passes()
    ) {
//    require_once __DIR__ . '/vendor/autoload.php';
    \add_action('plugins_loaded', __NAMESPACE__ . '\\boot', 10, 0);
}

