<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://cmachowski.com
 * @since      1.0.0
 *
 * @package    Slaf_Polylang
 * @subpackage Slaf_Polylang/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Slaf_Polylang
 * @subpackage Slaf_Polylang/admin
 * @author     Paweł Ćmachowski <pawel.cmachowski@gmail.com>
 */
class Slaf_Polylang_Admin
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string $plugin_name The name of this plugin.
     * @param      string $version The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Filter language list provided by Polylang
     *
     * @since   1.0.0
     * @param   array $languages Collection of Polylang active languages.
     *
     * @return  array   Filtered collection of Polylang languages
     */
    public function filter_languages_list($languages)
    {
        if (current_user_can('administrator')) {
            return $languages;
        }

        if (is_admin()) {
            $restricted = get_user_meta(get_current_user_id(), 'restricted_language', true);

            foreach ($languages as $language) {
                if ($language->slug == $restricted) {
                    return array($language);
                }
            }
        }

        return $languages;
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since   1.0.0
     */
    public function enqueue_scripts()
    {
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/slaf-polylang-admin.js', array('jquery'), $this->version, false);
    }

    /**
     * Ajax endpoint with all available languages(for specified user) from Polylang
     *
     * @since   1.0.0
     */
    public function all_available_languages()
    {
        $language_list = array();
        if (current_user_can('administrator')) {
            $language_list = array(array('slug' => 'all', 'name' => __('All languages', 'slaf-polylang')));
        }
        $language_slugs = pll_languages_list(['fields' => 'slug']);
        $language_names = pll_languages_list(['fields' => 'name']);

        for ($i = 0; $i < count($language_slugs); $i++) {
            array_push($language_list, array('slug' => $language_slugs[$i], 'name' => $language_names[$i]));
        }

        echo json_encode($language_list);
        wp_die();
    }

}
