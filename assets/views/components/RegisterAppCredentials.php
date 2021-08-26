<div id="app_credentials">
    <h2>Entrer les informations de votre App Facebook</h2>
    <form action="" method="POST">
        <?php wp_nonce_field('fb_app_cred', 'fb_app_cred-verif'); ?>
        <span class="label-group">
            <label for="app_id">App ID</label>
            <input type="text" name="app_id" id="app_id">
        </span>
        <span class="label-group">  
            <label for="app_secret">App Secret</label>
            <input type="password" name="app_secret" id="app_secret">
        </span>
        <span class="label-group">
            <label for="access_token"><fb:login-button id="facebook_btn_login" scope="public_profile,email" onlogin="checkLoginState();"> </fb:login-button></label>
            <input type="text" name="access_token" id="access_token" placeholder="Access Token ou connecter vous à facebook">
        </span>
        
        <input type="submit" value="Valider" name="scw_submit_appcred">
    </form>
</div>