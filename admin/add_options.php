<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


/**
 * add options
 */
function plksc_add_options() {

    $version_plksc = 'version_plksc';
    $new_version_plksc = sanitize_text_field(PLKSC_VERSION);
    if ( get_option( $version_plksc ) !== false ) {

        // The option already exists, so we just update it.
        update_option( $version_plksc, $new_version_plksc );

    } else {

        // The option hasn't been added yet. We'll add it with $autoload set to 'no'.
        $deprecated = null;
        $autoload = 'no';
        add_option( $version_plksc, $new_version_plksc, $deprecated, $autoload );
    }

}
add_action('init', 'plksc_add_options');