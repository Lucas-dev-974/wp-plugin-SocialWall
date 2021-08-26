<?php
function register_script(){
    wp_enqueue_script('jquery');
    wp_register_script('scw-script', plugin_dir_url($GLOBALS['scw_script_dir']).'js/index.js', array('jquery'), '1.0', true);
    wp_enqueue_script('scw-script');
    
}

function registerAdmin_style(){
    wp_register_style('scw-style', plugin_dir_url($GLOBALS['scw_style_dir']).'css/style.css');
    wp_enqueue_style('scw-style');
}

function registerClient_style(){
    wp_register_style('scw-ui_style', plugin_dir_url($GLOBALS['scw_style_dir']).'css/ui_style.css');
    wp_enqueue_style('scw-ui_style');
}

function registerClientScripts(){
    wp_register_script('client-swc-script', plugin_dir_url($GLOBALS['scw_script_dir']).'js/jsClient.js', array('jquery'), '1.0', true);
    wp_enqueue_script('client-swc-script');
}

function render_admin_page(){
    require($GLOBALS['scw_views_dir'] . '\admin_view.php');
}



function setup_scw_admin_link(){
    add_menu_page('SocialWall', 'SocialWall', 'manage_options', 'social-wall', 'render_admin_page', 'dashicons-tagcloud', 1);
}


function scw_init(){
    add_action('admin_menu', 'setup_scw_admin_link');
    add_action('admin_enqueue_scripts', 'register_script'); 
    add_action('admin_enqueue_scripts', 'registerAdmin_style'); 
    add_action('wp_enqueue_scripts', 'registerClient_style');
    add_action('wp_enqueue_scripts', 'registerClientScripts');
}