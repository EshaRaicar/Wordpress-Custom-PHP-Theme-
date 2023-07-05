<?php
    function esharaicar_setup(){
      
        add_theme_support('custom-background');
        add_theme_support('custom-header');
        add_theme_support('post-thumbnails', array( 'post','page' ));
 
        register_nav_menus(array('menu1' => 'Primary Menu', 'menu2' => 'Secondary Menu'));
    }

    add_action('after_setup_theme', 'esharaicar_setup');
    
    function styles_and_scripts(){
        wp_enqueue_style('main-stylesheet', get_template_directory_uri(). '/style.css');

        wp_enqueue_script('jquery-ui-datepicker');
        wp_register_style('jquery-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css');
        wp_enqueue_style('jquery-ui');

    }

    add_action('wp_enqueue_scripts', 'styles_and_scripts');

?>