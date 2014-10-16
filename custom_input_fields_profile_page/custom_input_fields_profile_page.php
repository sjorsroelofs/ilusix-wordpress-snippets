<?php

/**
 * The code below adds a new contact method field
 */

// Add LinkedIn to the list of contact methods
function ilusix_modify_contact_methods( $profile_fields ) {
    $profile_fields['linkedin'] = 'LinkedIn profiel URL';

    return $profile_fields;
}
add_filter('user_contactmethods', 'ilusix_modify_contact_methods');



/**
 * The code below adds a new section with custom html
 */

// Add input field to the user profile
function ilusix_add_extra_profile_info_fields( $user ) {
    echo '
        <h3>Extra profile information</h3>
        <table class="form-table">
            <tr>
                <th><label for="extra_field_1">Extra field 1</label></th>
                <td>
                    <input type="text" name="extra_field_1" value="' . esc_attr( get_the_author_meta( 'extra_field_1', $user->ID ) ) . '" class="regular-text" />
                </td>
            </tr>
        </table>
    ';
}
add_action( 'show_user_profile', 'ilusix_add_extra_profile_info_fields' );
add_action( 'edit_user_profile', 'ilusix_add_extra_profile_info_fields' );

function ilusix_save_extra_profile_info_fields( $user_id ) {
    if(!current_user_can( 'edit_user', $user_id )) return false;
    update_user_meta( $user_id, 'extra_field_1', $_POST['extra_field_1'] );
}
add_action( 'personal_options_update', 'ilusix_save_extra_profile_info_fields' );
add_action( 'edit_user_profile_update', 'ilusix_save_extra_profile_info_fields' );