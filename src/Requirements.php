<?php

/**
 * Must be PHP 5.3.2 compatible.
 */

// declare(strict_types=1);

namespace Company\WordPress\PluginName;

use Composer\InstalledVersions;

class Requirements
{
    /** @var bool */
    protected $passes;

    /**
     * @return void
     */
    public function __construct()
    {
        // By default there is no problem.
        $this->passes = true;
    }

    /**
     * @return bool
     */
    public function passes(): bool
    {
        return $this->passes;
    }

    /**
     * @param string $minVersion
     * @return self
     */
    public function php($minVersion)
    {
        $this->passes = $this->passes && version_compare(PHP_VERSION, $minVersion, '>=');

        return $this;
    }

    /**
     * @param string $minVersion
     * @return self
     */
    public function wp($minVersion)
    {
        // Makes $wp_version available locally.
        require ABSPATH . WPINC . '/version.php';

        /** @var string $wp_version */
        $this->passes = $this->passes && version_compare($wp_version, $minVersion, '>=');

        return $this;
    }

    /**
     * @param bool $required
     * @return self
     */
    public function multisite($required)
    {
        $this->passes = $this->passes && (!$required || \is_multisite());

        return $this;
    }

    /**
     * @param list<string> $plugins
     * @return self
     */
    public function plugins($plugins)
    {
        $this->passes = $this->passes && array_reduce(
            $plugins,
            function ($active, $plugin) {
                return $active && $this->isPluginActive($plugin);
            },
            true
        );

        return $this;
    }

    /**
     * @param list<string> $packages
     * @return self
     */
    public function packages($packages)
    {
        $this->passes = $this->passes && array_reduce(
            $packages,
            function ($installed, $package) {
                return $installed && InstalledVersions::isInstalled($package);
            },
            true
        );

        return $this;
    }

    /**
     * Copy of core's is_plugin_active()
     *
     * @param string $plugin
     * @return bool
     */
    protected function isPluginActive($plugin)
    {
        return in_array($plugin, (array)\get_option('active_plugins', []), true)
            || \is_plugin_active_for_network($plugin);
    }
}
