<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://cmachowski.com
 * @since      1.0.0
 *
 * @package    Slaf_Polylang
 * @subpackage Slaf_Polylang/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Slaf_Polylang
 * @subpackage Slaf_Polylang/includes
 * @author     Paweł Ćmachowski <pawel.cmachowski@gmail.com>
 */
class Slaf_Polylang_i18n
{


    /**
     * Load the plugin text domain for translation.
     *
     * @since    1.0.0
     */
    public function load_plugin_textdomain()
    {

        load_plugin_textdomain(
            'slaf-polylang',
            false,
            dirname(dirname(plugin_basename(__FILE__))) . '/languages/'
        );

    }


}
