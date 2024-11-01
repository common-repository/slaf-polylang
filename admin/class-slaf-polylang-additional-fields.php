<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://cmachowski.com
 * @since      1.0.0
 *
 * @package    Polylang_Sla
 * @subpackage Polylang_Sla/additional-fields
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines extra fields for user create and update.
 *
 * @package    Polylang_Sla
 * @subpackage Polylang_Sla/additional-fields
 * @author     Paweł Ćmachowski <pawel.cmachowski@gmail.com>
 */
class Slaf_Polylang_Additional_Fields
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
     * List of pre-definied available languages
     *
     * @since    1.0.0
     * @access   private
     * @var     array $available_languages List of pre-definied available languages
     */
    private $available_languages = array();

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
     * Register all hooks for custom field in user details area for creation and updating.
     * Handle validation errors.
     *
     * @since    1.0.0
     */
    public function init_fields()
    {
        add_action('user_register', array($this, 'slaf_user_register'));
        add_action('user_new_form', array($this, 'slaf_admin_registration_form'));
        add_action('user_profile_update_errors', array($this, 'slaf_user_profile_update_errors'), 10, 3);
        add_action('edit_user_created_user', array($this, 'slaf_user_register'));

        add_action('show_user_profile', array($this, 'slaf_show_extra_profile_fields'));
        add_action('edit_user_profile', array($this, 'slaf_show_extra_profile_fields'));

        add_action('personal_options_update', array($this, 'slaf_update_profile_fields'));
        add_action('edit_user_profile_update', array($this, 'slaf_update_profile_fields'));
    }

    /**
     * Update user meta on save
     *
     * @since    1.0.0
     */
    function slaf_user_register($user_id)
    {
        if (!empty($_POST['restricted_language'])) {
            update_user_meta($user_id, 'restricted_language', $_POST['restricted_language']);
        }
    }

    /**
     * Show extra field on user create page
     *
     * @since    1.0.0
     */
    function slaf_admin_registration_form($operation)
    {
        if ('add-new-user' !== $operation) {
            return;
        }

        $current_restricted = 'all';
        $current_restricted = !empty($_POST['restricted_language']) ? $_POST['restricted_language'] : '';

        ?>
        <h3><?php esc_html_e('Languages restrictions', 'slaf-polylang'); ?></h3>

        <table class="form-table">
            <tr>
                <th>
                    <label for="restricted_language"><?php esc_html_e('User can view and edit:', 'slaf-polylang'); ?></label>
                </th>
                <td>
                    <select id="restricted_language" name="restricted_language"
                            data-current="<?php echo $current_restricted; ?>">
                        <?php foreach ($this->available_languages as $languageValue => $languageName): ?>
                            <option value="<?php echo $languageValue; ?>"><?php echo $languageName; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
        </table>
        <?php
    }

    /**
     * Handle errors, when restricted language is empty
     *
     * @since    1.0.0
     */
    function slaf_user_profile_update_errors($errors, $update, $user)
    {
        if (empty($_POST['restricted_language'])) {
            $errors->add('restricted_language_error', __('<strong>ERROR</strong>: Please select language restriction.', 'crf'));
        }

    }

    /**
     * Show extra field on user edit page
     *
     * @since    1.0.0
     */
    function slaf_show_extra_profile_fields($user)
    {
        $current_restricted = 'all';
        $current_restricted = get_the_author_meta('restricted_language', $user->ID);
        ?>
        <h3><?php esc_html_e('Languages restrictions', 'slaf-polylang'); ?></h3>

        <table class="form-table">
            <tr>
                <th>
                    <label for="restricted_language"><?php esc_html_e('User can view and edit:', 'slaf-polylang'); ?></label>
                </th>
                <td>
                    <select id="restricted_language" name="restricted_language"
                            data-current="<?php echo $current_restricted; ?>">
                        <?php foreach ($this->available_languages as $languageValue => $languageName): ?>
                            <option value="<?php echo $languageValue; ?>"><?php echo $languageName; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
        </table>
        <?php
    }

    /**
     * Update user meta on edit
     *
     * @since   1.0.0
     */
    function slaf_update_profile_fields($user_id)
    {
        if (!current_user_can('edit_user', $user_id)) {
            return false;
        }

        if (!empty($_POST['restricted_language'])) {
            update_user_meta($user_id, 'restricted_language', $_POST['restricted_language']);
        }
    }

}
