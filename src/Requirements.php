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
    protected $met;

    /**
     * @return void
     */
    public function __construct()
    {
        // By default there is no problem.
        $this->met = true;
    }

    /**
     * @return bool
     */
    public function met()
    {
        return $this->met;
    }

    /**
     * @param string $minVersion
     * @return self
     */
    public function php($minVersion)
    {
        $this->met = $this->met && version_compare(PHP_VERSION, $minVersion, '>=');

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
        $this->met = $this->met && version_compare($wp_version, $minVersion, '>=');

        return $this;
    }

    /**
     * @param bool $required
     * @return self
     */
    public function multisite($required)
    {
        $this->met = $this->met && (!$required || \is_multisite());

        return $this;
    }

    /**
     * @param list<string> $plugins
     * @return self
     */
    public function plugins($plugins)
    {
        $this->met = $this->met && array_reduce(
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
        $this->met = $this->met && array_reduce(
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
            || $this->isPluginActiveForNetwork($plugin);
    }

    /**
     * Copy of core's is_plugin_active_for_network()
     *
     * @param string $plugin
     * @return bool
     */
    protected function isPluginActiveForNetwork($plugin)
    {
        if (! \is_multisite()) {
            return false;
        }

        $plugins = \get_site_option('active_sitewide_plugins');
        if (isset($plugins[$plugin])) {
            return true;
        }

        return false;
    }
}
