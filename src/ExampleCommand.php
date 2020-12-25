<?php

/**
 * ExampleCommand.php
 *
 * @package PluginPackage
 * @author Your Name <username@example.com>
 * @copyright 2019 Your Name or Company Name
 * @license GPL-2.0-or-later http://www.gnu.org/licenses/gpl-2.0.txt
 * @link https://example.com/plugin-name
 */

declare(strict_types=1);

namespace Company\WordPress\PluginName;

use WP_CLI;

/**
 * Implements WP-CLI example command.
 */
class ExampleCommand
{
    /**
     * Prints a greeting.
     *
     * ## OPTIONS
     *
     * <name>
     * : The name of the person to greet.
     *
     * [--type=<type>]
     * : Whether or not to greet the person with success or error.
     * ---
     * default: success
     * options:
     *   - success
     *   - error
     * ---
     *
     * ## EXAMPLES
     *
     *     wp example hello Newman
     *
     * @when after_wp_load
     *
     * @param list<string> $args
     * @param array<string, string> $assocArgs
     * @return void
     * phpcs:disable
     */
    public function hello(array $args, array $assocArgs)
    {
        list($name) = $args;

        // Print the message with type.
        $type = $assocArgs['type'];
        WP_CLI::$type(sprintf('Hello, %1$s!', $name));
    }
}
