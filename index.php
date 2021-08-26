<?php
/**
 * Plugin Name: SocialWall 
 * Description: Build your own socialwall with your bussiness instagram account
 * Version: 1.0
 * Author: lcs-lvn
 * 
 */


session_start();
global $wpdb;
global $tablename;


$tablename = $wpdb->prefix . 'swc_facebookapp_credentials';

require_once('vendor/autoload.php');
require_once('admin/form_traitment.php');
require_once('core/init_databse_tables.php');
require_once('core/setup_scw.php');

$GLOBALS['scw_base_dir']   = dirname(__FILE__); 
$GLOBALS['scw_script_dir'] = dirname(__FILE__).'/assets/js';
$GLOBALS['scw_style_dir']  = dirname(__FILE__).'/assets\css';
$GLOBALS['scw_views_dir']  = dirname(__FILE__).'\assets\views';

require_once('core/Facebook.php');
require_once('core/ShortCode.php');



    
scw_init();



