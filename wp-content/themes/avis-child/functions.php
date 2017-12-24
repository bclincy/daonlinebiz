<?php
// Avis Child Theme fucntion declaration file

add_action( 'wp_enqueue_scripts', 'avis_enqueue_styles' );
function avis_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );

}

?>