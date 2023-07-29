# Ultimate WordPress Plugin Main File

_How to leave legacy technologies behind_

Source code in [`plugin-name.php`](/plugin-name.php) needs PHP 7 which is present on more than
[90% of WordPress installations](https://wordpress.org/about/stats/#php_versions).

## Support my work

Please consider sponsoring me monthly if you use my packages in an agency.

[![Sponsor](https://github.com/szepeviktor/.github/raw/master/.github/assets/github-like-sponsor-button.svg)](https://github.com/sponsors/szepeviktor)

## Parts of plugin main file

- [Header comment](https://developer.wordpress.org/plugins/plugin-basics/header-requirements/#header-fields)
- [PHP strict types](https://www.php.net/manual/en/language.types.declarations.php#language.types.declarations.strict)
- [PHP namespaces](https://www.php-fig.org/psr/psr-4/#2-specification)
- Prevent direct execution
- Load autoloader
- Prevent double activation
- Define constant values in an immutable container
- Load translations
- Check requirements
  - PHP and WordPress minimum version
  - Multisite installation
  - Other plugins
  - Current theme
  - Composer packages
- Hook plugin activation functions
- Support [WP-CLI](https://wp-cli.org/)
- Display admin notice and deactivate plugin on error

:bulb: Anything else goes into a separate file.

## What to avoid

- :x: Global constants
- :x: Global functions
- :x: Classes without namespace
- :x: Loading PHP files with `require`
- :x: Code with [side-effects](https://www.php-fig.org/psr/psr-1/#23-side-effects) outside the main file
- :x: Immediate execution without `add_action` in the main file
- :x: Conditional function or class definitions

---

![Required PHP Version](https://img.shields.io/wordpress/plugin/required-php/bbpress)
![Required WP Version](https://img.shields.io/wordpress/plugin/wp-version/bbpress)

## Installation

1. Get the plugin ZIP from ...
1. Upload to Plugins / Add new / Upload `/wp-admin/plugin-install.php?tab=upload`

## Usage

1. Adjust settings ...
1. Or add a hook `add_filter('project/enable', '__return_true');` to `functions.php`
