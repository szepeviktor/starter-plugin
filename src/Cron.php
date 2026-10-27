<?php

/**
 * Cron.php
 *
 * @author Your Name <username@example.com>
 * @license GPL-2.0-or-later http://www.gnu.org/licenses/gpl-2.0.txt
 * @link https://example.com/plugin-name
 */

declare(strict_types=1);

namespace Company\WordPress\PluginName;

use function add_action;
use function wp_clear_scheduled_hook;
use function wp_next_scheduled;
use function wp_schedule_event;

/**
 * Schedule and run the plugin's recurring task.
 */
final class Cron
{
    private const HOOK = 'plugin_slug_hourly_task';

    public function register(): void
    {
        add_action(self::HOOK, [$this, 'run'], 10, 0);
        add_action('init', [self::class, 'schedule'], 10, 0);
    }

    public static function schedule(): void
    {
        if (wp_next_scheduled(self::HOOK) !== false) {
            return;
        }

        wp_schedule_event(time(), 'hourly', self::HOOK);
    }

    public static function unschedule(): void
    {
        wp_clear_scheduled_hook(self::HOOK);
    }

    public function run(): void
    {
        // Run the scheduled task.
    }
}
