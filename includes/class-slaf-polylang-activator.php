<?php

/**
 * Fired during plugin activation
 *
 * @link       http://cmachowski.com
 * @since      1.0.0
 *
 * @package    Slaf_Polylang
 * @subpackage Slaf_Polylang/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Slaf_Polylang
 * @subpackage Slaf_Polylang/includes
 * @author     Paweł Ćmachowski <pawel.cmachowski@gmail.com>
 */
require_once(ABSPATH . 'wp-admin/includes/plugin.php');

class Slaf_Polylang_Activator
{

    /**
     * Fires, when plugin is installed
     *
     * @since    1.0.0
     */
    public static function activate()
    {

        if (!is_plugin_active("polylang/polylang.php")) {
            die(__('Please install and activate Polylang plugin first.', 'slaf-polylang'));
        }

    }


}
