<?php

/**
 * Requirements.php
 *
 * @package PluginPackage
 * @author Your Name <username@example.com>
 * @copyright 2019 Your Name or Company Name
 * @license GPL-2.0-or-later http://www.gnu.org/licenses/gpl-2.0.txt
 * @link https://example.com/plugin-name
 */

declare(strict_types=1);

namespace Company\WordPress\PluginName;

use Composer\InstalledVersions;

/**
 * Check plugin requirements.
 */
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

    public function met(): bool
    {
        return $this->met;
    }

    public function php(string $minVersion): self
    {
        $this->met = $this->met && version_compare(PHP_VERSION, $minVersion, '>=');

        return $this;
    }

    public function wp(string $minVersion): self
    {
        // Makes $wp_version available locally.
        require ABSPATH . WPINC . '/version.php';

        /** @var string $wp_version */
        $this->met = $this->met && version_compare($wp_version, $minVersion, '>=');

        return $this;
    }

    public function multisite(bool $required): self
    {
        $this->met = $this->met && (!$required || \is_multisite());

        return $this;
    }

    /**
     * @param list<string> $plugins
     */
    public function plugins(array $plugins): self
    {
        $this->met = $this->met && array_reduce(
            $plugins,
            function (bool $active, string $plugin): bool {
                return $active && $this->isPluginActive($plugin);
            },
            true
        );

        return $this;
    }

    /**
     * @param list<string> $packages
     */
    public function packages(array $packages): self
    {
        $this->met = $this->met && array_reduce(
            $packages,
            static function (bool $installed, string $package): bool {
                return $installed && InstalledVersions::isInstalled($package);
            },
            true
        );

        return $this;
    }

    /**
     * Copy of core's is_plugin_active()
     */
    protected function isPluginActive(string $plugin): bool
    {
        return in_array($plugin, (array)\get_option('active_plugins', []), true)
            || $this->isPluginActiveForNetwork($plugin);
    }

    /**
     * Copy of core's is_plugin_active_for_network()
     */
    protected function isPluginActiveForNetwork(string $plugin): bool
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
