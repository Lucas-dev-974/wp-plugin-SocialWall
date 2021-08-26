<?php

function scw_app_credentials_submission(){
    global $wpdb;
    global $tablename;
    
    if(isset($_POST['scw_submit_appcred']) && isset($_POST['app_secret']) && isset($_POST['app_id']) && isset($_POST['access_token'])){
        if(!empty($_POST['app_secret']) && !empty($_POST['app_id']) && !empty($_POST['access_token'])){
            if (wp_verify_nonce($_POST['fb_app_cred-verif'], 'fb_app_cred')) {    
    
                $app_id     = htmlspecialchars($_POST['app_id']);
                $app_secret = htmlspecialchars($_POST['app_secret']);
                $app_token  = htmlspecialchars($_POST['access_token']);
               
                $data = $wpdb->insert($tablename, [
                    'app_id' => $app_id,
                    'app_secret' => $app_secret,
                    'app_token'  => $app_token
                ]);
                
                $_SESSION['ui_setting']['show_facebook_profile'] = true;
                $url = ($_GET['erreur']) ? remove_query_arg('erreur', wp_get_referer()) : add_query_arg('', '', wp_get_referer());
                wp_safe_redirect($url);
                exit();
            }
        }else{
            $url = add_query_arg('erreur', 'Des champs sont manquant', wp_get_referer());
            wp_safe_redirect($url);
            exit();
        }
    }
}

add_action('init', 'scw_app_credentials_submission');