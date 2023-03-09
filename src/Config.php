<?php

/**
 * Config.php
 *
 * @package company/plugin
 * @author Your Name <username@example.com>
 * @copyright 2019 Your Name or Company Name
 * @license GPL-2.0-or-later http://www.gnu.org/licenses/gpl-2.0.txt
 * @link https://example.com/plugin-name
 */

declare(strict_types=1);

namespace Company\WordPress\PluginName;

/**
 * Immutable configuration.
 */
final class Config
{
    /** @var array<string, mixed>|null */
    private static $container;

    /**
     * @param array<string, mixed> $container
     * @return void
     */
    public static function init(array $container)
    {
        if (isset(self::$container)) {
            return;
        }

        self::$container = $container;
    }

    /**
     * @return mixed
     */
    public static function get(string $key)
    {
        if (! isset(self::$container) || ! array_key_exists($key, self::$container)) {
            return null;
        }

        return self::$container[$key];
    }
}
