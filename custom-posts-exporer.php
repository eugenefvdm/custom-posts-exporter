<?php

/**
 * Plugin Name: Custom Posts Exporter
 * Plugin URI: https://fintechsystems.net
 * Description: Export custom posts to a third party API using JSON
 * Version: 0.0.1
 * Author: Eugene van der Merwe
 * Author URI: https://github.com/eugenefvdm
 * Licence: MIT
 */

/**
 * Initialize variables for this plugin
 */
$plugin_name = "Custom Posts Exporter";

require_once('debugger.php');
require_once('main.php');

/**
 * Register settings and adds an admin_init action
 *
 * Before you can have a working form with settings, you have to add them to this fil first.
 * 
 * Settings available:
 *
 * custom_posts_exporter_post_type
 * custom_posts_exporter_option_enable_debugger
 * 
 */
function custom_posts_exporter_register_settings()
{
    debugger("custom_posts_exporter_register_settings() was called");

    add_option('custom_posts_exporter_post_type', '');
    register_setting(
        'custom_posts_exporter_options_group',
        'custom_posts_exporter_post_type',
        'custom_posts_exporter_callback'
    );

    add_option('custom_posts_exporter_limit', '');
    register_setting(
        'custom_posts_exporter_options_group',
        'custom_posts_exporter_limit',
        'custom_posts_exporter_callback'
    );
}
add_action('admin_init', 'custom_posts_exporter_register_settings');

/**
 * Adds a new menu under Settings to manage Forms API Settings
 */
function custom_posts_exporter_register_options_page()
{
    add_options_page(
        'Custom Posts Exporter Settings',
        'Custom Posts Exporter',
        'manage_options',
        'custom-forms-exporter-settings',
        'custom_posts_exporter_options_page'
    );
}
add_action('admin_menu', 'custom_posts_exporter_register_options_page');

/**
 * Output the options for the settings page
 */
function custom_posts_exporter_options_page()
{
    $enable_debugger = get_option('custom_posts_exporter_enable_debugger');
    global $plugin_name;
?>
    <div>
        <h2><?php echo $plugin_name ?> Settings</h2>

        <form method="post" action="options.php">
            <?php settings_fields('custom_posts_exporter_options_group'); ?>
            <table>

                <tr>
                    <td>Post Type</td>
                    <td>
                        <label>
                            <input type="text"
                                   name="custom_posts_exporter_post_type"
                                   size="70"
                                   value="<?php echo get_option('custom_posts_exporter_post_type'); ?>"
                                   placeholder="E.g. knowledgebase"
                            />
                        </label>
                    </td>
                </tr>

                <tr>
                    <td>Limit</td>
                    <td>
                        <label>
                            <input type="text"
                                   name="custom_posts_exporter_limit"
                                   size="70"
                                   value="<?php echo get_option('custom_posts_exporter_limit'); ?>"
                                   placeholder="E.g. 10"
                            />
                        </label>
                    </td>
                </tr>

                <tr>
                    <td><label for="enable_debugger_checkbox">Enable debugger<label></td>
                    <td>
                        <input type="checkbox"
                               id="enable_debugger_checkbox"
                               name="custom_posts_exporter_enable_debugger"
                               value="1" <?php echo ($enable_debugger == true) ? 'checked' : '' ?>
                        />
                    </td>
                </tr>

            </table>
            <?php submit_button(); ?>
        </form>
    </div>
<?php
} ?>
