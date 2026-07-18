<?php

/**
 * Config.php
 *
 * @author Your Name <username@example.com>
 * @license GPL-2.0-or-later http://www.gnu.org/licenses/gpl-2.0.txt
 * @link https://example.com/plugin-name
 */

declare(strict_types=1);

namespace Company\WordPress\PluginName;

/**
 * Immutable configuration.
 *
 * @phpstan-type ConfigShape array{
 *     version: string,
 *     filePath: string,
 *     baseName: string,
 *     slug: string
 * }
 */
final class Config
{
    /** @var ConfigShape|null */
    private static ?array $container = null;

    /**
     * @param ConfigShape $container
     */
    public static function init(array $container): void
    {
        if (isset(self::$container)) {
            return;
        }

        self::$container = $container;
    }

    public static function isInitialized(): bool
    {
        return isset(self::$container);
    }

    /**
     * @template TKey of key-of<ConfigShape>
     *
     * @param TKey $name
     * @return ConfigShape[TKey]
     */
    public static function get(string $name)
    {
        if (! isset(self::$container) || ! array_key_exists($name, self::$container)) {
            throw new \LogicException('Config is not initialized or the requested key does not exist.');
        }

        return self::$container[$name];
    }
}
