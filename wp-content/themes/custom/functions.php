<?php
function firstTheme_style(){
    wp_enqueue_style( 'core', 'style.css', false ); 
}
add_action('wp_enqueue_scripts', 'firstTheme_style');

function mijn_menu_registreren() {
    register_nav_menus(array(
        'links_menu' => __('Links Menu', 'mijn_thema'), 
        'footer_menu' => __('Footer Menu', 'mijn_thema'),
    ));
}
add_action('init', 'mijn_menu_registreren');

function mijn_thema_add_custom_logo() {
    add_theme_support( 'custom-logo', array(
        'height'      => 200,  // De hoogte van het logo
        'width'       => 200,  // De breedte van het logo
        'flex-height' => true, // Flexibel in hoogte
        'flex-width'  => true, // Flexibel in breedte
    ) );
}
add_action( 'after_setup_theme', 'mijn_thema_add_custom_logo' );



// Registreren van de Sidebar
function greentech_register_sidebar() {
    register_sidebar(array(
        'name'          => __('GreenTech Sidebar', 'greentech'),
        'id'            => 'greentech-sidebar',
        'description'   => __('Een aangepaste sidebar voor GreenTech Solutions.', 'greentech'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
}
add_action('widgets_init', 'greentech_register_sidebar');

function thema_setup() {
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'thema_setup');



?>

