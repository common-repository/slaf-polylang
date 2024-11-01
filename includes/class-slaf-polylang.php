<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://cmachowski.com
 * @since      1.0.0
 *
 * @package    Slaf_Polylang
 * @subpackage Slaf_Polylang/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Slaf_Polylang
 * @subpackage Slaf_Polylang/includes
 * @author     Paweł Ćmachowski <pawel.cmachowski@gmail.com>
 */
class Slaf_Polylang
{

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Slaf_Polylang_Loader $loader Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string $plugin_name The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string $version The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct()
    {
        if (defined('SLAF_POLYLANG_VERSION')) {
            $this->version = SLAF_POLYLANG_VERSION;
        } else {
            $this->version = '1.0.0';
        }
        $this->plugin_name = 'slaf-polylang';

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();

    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - Slaf_Polylang_Loader. Orchestrates the hooks of the plugin.
     * - Slaf_Polylang_i18n. Defines internationalization functionality.
     * - Slaf_Polylang_Admin. Defines all hooks for the admin area.
     * - Slaf_Polylang_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies()
    {

        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-slaf-polylang-loader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-slaf-polylang-i18n.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-slaf-polylang-admin.php';

        /**
         * The class responsible for defining all additional fields for user in the admin area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-slaf-polylang-additional-fields.php';

        $this->loader = new Slaf_Polylang_Loader();

    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Slaf_Polylang_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale()
    {

        $plugin_i18n = new Slaf_Polylang_i18n();

        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');

    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks()
    {

        $plugin_admin = new Slaf_Polylang_Admin($this->get_plugin_name(), $this->get_version());
        $plugin_admin_additional_fields = new Slaf_Polylang_Additional_Fields($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
        $this->loader->add_action('wp_ajax_all_available_languages', $plugin_admin, 'all_available_languages');

        $this->loader->add_filter('pll_after_languages_cache', $plugin_admin, 'filter_languages_list');

        $plugin_admin_additional_fields->init_fields();

    }


    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run()
    {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_plugin_name()
    {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    Slaf_Polylang_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader()
    {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version()
    {
        return $this->version;
    }

}
