<?php

declare(strict_types=1);

namespace Company\WordPress\PluginName;

class Config
{
    private static ?self $instance = null;

    /** @var array<string, mixed> */
    private static array $container = [];

    private function __construct()
    {
    }

    /**
     * @param array<string, mixed> $container
     */
    public static function init(array $container): void
    {
        if (self::$instance instanceof self) {
            return;
        }

        self::$instance = new self;
        self::$container = $container;
    }

    /**
     * @return mixed
     */
    public static function get(string $key)
    {
        if (! array_key_exists($key, self::$container)) {
            return null;
        }

        return self::$container[$key];
    }
}
