<?php
/*
Plugin Name: Bulk User Register
Plugin URI: http://spais.co.jp/%e3%83%97%e3%83%ad%e3%83%80%e3%82%af%e3%83%88-product/bulk-user-register/
Description: Many users are registered at a time.
Author: HAYASHI Ryo
Author URI: http://spais.co.jp/
Version: 0.1.0
*/

/**
 * bulk_user_register class
 *
 * @author HAYASHI Ryo<ryo@spais.co.jp>
 * @version 0.1.0
 */
class bulk_user_register{
    function display(){
        $file = basename(__FILE__);
        add_settings_section('general', __('Register form', __CLASS__), array(&$this, 'display_section'), $file);
        add_settings_field('columns', __('Registration column name', __CLASS__), array(&$this, 'display_columns'), $file, 'general');
        add_settings_field('users', __('Registration users', __CLASS__), array(&$this, 'display_users'), $file, 'general');
        add_settings_field('options', __('Registration options', __CLASS__), array(&$this, 'display_options'), $file, 'general');
        ?>
        <div class="wrap">
            <?php screen_icon()?><h2><?php _e('Bulk User Register', __CLASS__)?></h2>
            <?php settings_fields(__CLASS__)?>
            <?php do_settings_sections($file)?>
            <p class="submit">
                <input type="submit" class="button-primary" value="<?php _e('Save')?>" />
                <input type="button" class="button" value="<?php _e('Preview')?>" />
            </p>
        </div>
        <?php
    }

    function display_section(){}

    function display_columns(){
        //username, mailaddress, password, first_name, last_name, role
        $fixed = array('username', 'mailaddress', 'password', 'role', 'first_name', 'last_name');
        printf('<ul id="fixed_cols" class="bur_columns"><li>%s</li></ul>', implode('</li><li>', $fixed));
    }

    function display_users(){
        ?>
        <textarea style="width:95%;" rows="12" cols="60"></textarea>
        <?php
    }

    function display_options(){
        ?>
        <ul>
            <li>
                <label><input type="checkbox" name="gmail" /><?php _e('Gmail is used', __CLASS__)?></label>
                <label for="gmail_rcpt">RCPT: </label><input type="text" name="gmail_rcpt" id="gmail_rcpt" />
            </li>
            <li><label><input type="checkbox" name="sendmail" /><?php _e('After registration, mail is sent', __CLASS__)?></label></li>
            <li><label><input type="checkbox" name="duplicate" /><?php _e('Duplicate user to override', __CLASS__)?></label></li>
        </ul>
        <?php
    }

    function validation(){}

    function action(){}

    function action_init(){
        load_plugin_textdomain(__CLASS__, false, 'bulk-user-register/languages');
    }

    function action_admin_init(){
        if(!isset($_GET) || !isset($_GET['page']) || $_GET['page'] !== 'bulk-user-register/bulk-user-register.php') return;
        wp_enqueue_script(__CLASS__, plugin_dir_url(__FILE__) . 'script.js', array('jquery'), null, true);
        wp_enqueue_style(__CLASS__, plugin_dir_url(__FILE__) . 'style.css');
    }

    function action_admin_menu(){
        add_options_page('Bulk User Register', __('Bulk User Register', __CLASS__), 'create_users', __FILE__, array(&$this, 'display'));
    }

    function bulk_user_register(){
        add_action('init', array(&$this, 'action_init'));
        add_action('admin_init', array(&$this, 'action_admin_init'));
        add_action('admin_menu', array(&$this, 'action_admin_menu'));
    }
}
new bulk_user_register;