<?php

namespace Company\WordPress\PluginName;

use WP_CLI;

/**
 * @return void
 */
function activate()
{
    // FIXME Move reqs+deactivation here???
    \deactivate_plugins([Config::get('baseName')], true);

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
        \esc_html__('PluginName activation failed! Please read', 'plugin-slug'),
        \esc_url('https://github.com/szepeviktor/small-project#readme'),
        \esc_html__('the Installation instructions', 'plugin-slug'),
        \esc_html__('for list of requirements.', 'plugin-slug')
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
