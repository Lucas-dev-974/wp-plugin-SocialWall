<?php
global $wpdb;
global $tablename;
global $app_credentials;

$app_credentials = $wpdb->get_results("SELECT * FROM $tablename")[0];
$fbManager = new Facebook($app_credentials->app_id, $app_credentials->app_secret, $app_credentials->app_token);

?>

<div class="scw-container">
    <?php require_once($GLOBALS['scw_views_dir'] . '/components/alert.php');
        if($app_credentials == null || empty($app_credentials->app_id) || empty($app_credentials->app_secret) || empty($app_credentials->app_token)){
            require($GLOBALS['scw_views_dir'] . '/components/RegisterAppCredentials.php');
        }else{
            require($GLOBALS['scw_views_dir'] . '/components/facebook_profile.php');
        }
    ?>
    </div>
</div>