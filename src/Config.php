<?php

declare(strict_types=1);

namespace Company\WordPress\PluginName;

class Config
{
    /** @var array<string, mixed> */
    private static array $container;

    /**
     * @param array<string, mixed> $container
     */
    public static function init(array $container): void
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
