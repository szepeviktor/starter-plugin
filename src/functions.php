<?php

namespace Company\WordPress\PluginName;

use WP_CLI;

/**
 * @return void
 */
function activate()
{
    // FIXME Move reqs+deactivation here???
    \deactivate_plugins([plugin_basename(__FILE__)], true);

    // Run database migrations, initialize WordPress options etc.
}

/**
 * @return void
 */
function deactivate()
{
    // Do something related to deactication.
}

/**
 * @return void
 */
function uninstall()
{
    // Remove custom database tables, WordPress options etc.
}

/**
 * @return void
 */
function printRequirementsNotice()
{
    printf(
        '<div class="notice notice-error"><p>%1$s <a href="%2$s" target="_blank">%3$s</a> %4$s</p></div>',
        \esc_html__('PluginName activation failed! Please read', PLUGIN_NAME_TEXTDOMAIN),
        \esc_url('https://github.com/szepeviktor/small-project#readme'),
        \esc_html__('the Installation instructions', PLUGIN_NAME_TEXTDOMAIN),
        \esc_html__('for list of requirements.', PLUGIN_NAME_TEXTDOMAIN)
    );
}

/**
 * @return void
 */
function registerCliCommands()
{
    // WP_CLI::add_command('example', 'ExampleCommand');
}

/**
 * Start!
 *
 * @return void
 */
function boot()
{
    new ClassName();
}
