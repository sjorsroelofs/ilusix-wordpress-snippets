<?php

$ilusixMyPluginMetaKeyName          = 'ilusix_my_plugin';
$ilusixMyPluginSettingsFieldName    = $ilusixMyPluginMetaKeyName . '_settings_field';
$ilusixMyPluginSettingsOptionName   = $ilusixMyPluginMetaKeyName . '_plugin_settings';


// Create a settings page
add_action('admin_menu', 'ilusix_create_my_plugin_settings_page');
function ilusix_create_my_plugin_settings_page() {
    global $ilusixMyPluginMetaKeyName;

    add_options_page(
        'My plugin options',
        'My plugin options',
        'manage_options',
        $ilusixMyPluginMetaKeyName,
        'ilusix_my_plugin_settings_page_callback'
    );
}


// Settings page callback
function ilusix_my_plugin_settings_page_callback() {
    global $ilusixMyPluginSettingsFieldName;
    global $ilusixMyPluginMetaKeyName;

    echo '<div class="wrap">';
        echo '<h2>My plugin settings</h2>';
        echo '<form action="options.php" method="post">';

            settings_fields( $ilusixMyPluginSettingsFieldName );
            do_settings_sections( $ilusixMyPluginMetaKeyName );

            echo '<input name="Submit" type="submit" class="button button-primary" value="' . __('Save Changes') . '" />';
        echo '</form>';
    echo '</div><!-- div.wrap -->';
}


// Set the settings
add_action( 'admin_init', 'ilusix_my_plugin_add_settings' );
function ilusix_my_plugin_add_settings() {
    global $ilusixMyPluginSettingsFieldName;
    global $ilusixMyPluginSettingsOptionName;
    global $ilusixMyPluginMetaKeyName;

    register_setting( $ilusixMyPluginSettingsFieldName, $ilusixMyPluginSettingsOptionName );

    // Add the global settings section
    add_settings_section(
        $ilusixMyPluginMetaKeyName . '_global_plugin_settings',
        'Section title',
        function() {},
        $ilusixMyPluginMetaKeyName
    );

    // Add a section field for the like text
    add_settings_field(
        $ilusixMyPluginSettingsOptionName . '_value_1',
        'Value 1',
        function() {
            global $ilusixMyPluginSettingsOptionName;

            $options = get_option( $ilusixMyPluginSettingsOptionName );
            echo '<input name="' . $ilusixMyPluginSettingsOptionName . '[' . $ilusixMyPluginSettingsOptionName . '_value_1' . ']" size="20" type="text" value="' . (isset( $options[$ilusixMyPluginSettingsOptionName . '_value_1'] ) ? $options[$ilusixMyPluginSettingsOptionName . '_value_1'] : '') . '" />';
        },
        $ilusixMyPluginMetaKeyName,
        $ilusixMyPluginMetaKeyName . '_global_plugin_settings'
    );
}