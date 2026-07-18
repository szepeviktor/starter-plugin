<?php

/**
 * Plugin.php - Procedural part of Plugin Name.
 *
 * @author Your Name <username@example.com>
 * @license GPL-2.0-or-later http://www.gnu.org/licenses/gpl-2.0.txt
 * @link https://example.com/plugin-name
 */

declare(strict_types=1);

namespace Company\WordPress\PluginName;

use Company\WordPress\PluginName\Cli\ExampleCommand;
use WP_CLI;

use function current_user_can;
use function esc_html__;
use function esc_url;
use function load_plugin_textdomain;

/**
 * Plugin functions.
 */
class Plugin
{
    private function __construct()
    {
    }

    public static function loadTextDomain(): void
    {
        $pluginBasename = Config::get('baseName');
        load_plugin_textdomain('plugin-slug', false, sprintf('%s/%s', dirname($pluginBasename), 'languages'));
    }

    public static function activate(): void
    {
        // Run database migrations, initialize WordPress options etc.
    }

    public static function deactivate(): void
    {
        // Do something related to deactivation.
    }

    public static function uninstall(): void
    {
        // Remove custom database tables, WordPress options etc.
    }

    public static function printRequirementsNotice(): void
    {
        // phpcs:ignore Generic.PHP.ForbiddenFunctions.Found
        error_log('Plugin Name requirements are not met. Please read the Installation instructions.');

        if (! current_user_can('activate_plugins')) {
            return;
        }

        printf(
            '<div class="notice notice-error"><p>%1$s <a href="%2$s" target="_blank">%3$s</a> %4$s</p></div>',
            esc_html__('Plugin Name activation failed! Please read', 'plugin-slug'),
            esc_url('https://github.com/szepeviktor/starter-plugin#installation'),
            esc_html__('the Installation instructions', 'plugin-slug'),
            esc_html__('for list of requirements.', 'plugin-slug')
        );
    }

    public static function registerCliCommands(): void
    {
        WP_CLI::add_command('example', ExampleCommand::class);
    }

    /**
     * Start!
     */
    public static function boot(): void
    {
        $classInstance = new ClassName();
        $classInstance->do();
    }
}
