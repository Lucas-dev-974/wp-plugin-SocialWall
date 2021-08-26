<?php
global $wpdb;
$plugin_name_db_version = '1.0';
$table_name = $wpdb->prefix . "swc_facebookApp_credentials"; 
$charset_collate = $wpdb->get_charset_collate();

$sql = "CREATE TABLE $table_name (
		  id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
		  app_id varchar(255) ,
		  app_secret varchar(255) ,
		  app_token varchar(255) 
		) $charset_collate;";

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

dbDelta( $sql );
add_option( 'plugin_name_db_version', $plugin_name_db_version );