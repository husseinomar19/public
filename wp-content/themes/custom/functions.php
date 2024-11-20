<?php
function firstTheme_style(){
    wp_enqueue_style( 'core', 'style.css', false ); 
}
add_action('wp_enqueue_scripts', 'firstTheme_style');
?>