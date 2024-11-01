<?php

/**
 * @link              http://cmachowski.com
 * @since             1.0.0
 * @package           Slaf_Polylang
 *
 * @wordpress-plugin
 * Plugin Name:       Specified language access for Polylang
 * Plugin URI:        http://cmachowski.com
 * Description:       Plugin allows restrict users to edit content on wp-admin only with specified selected language.
 * Version:           1.1.2
 * Author:            Paweł Ćmachowski
 * Author URI:        http://cmachowski.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       slaf-polylang
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('SLAF_POLYLANG_VERSION', '1.1.2');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-slaf-polylang-activator.php
 */
function slaf_polylang_activate()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-slaf-polylang-activator.php';
    Slaf_Polylang_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-slaf-polylang-deactivator.php
 */
function slaf_polylang_deactivate()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-slaf-polylang-deactivator.php';
    Slaf_Polylang_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'slaf_polylang_activate');
register_deactivation_hook(__FILE__, 'slaf_polylang_deactivate');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-slaf-polylang.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function slaf_polylang_run()
{

    $plugin = new Slaf_Polylang();
    $plugin->run();

}

slaf_polylang_run();
