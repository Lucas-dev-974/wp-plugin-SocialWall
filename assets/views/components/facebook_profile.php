<?php 
global $wpdb;
global $app_credentials;
?>

<div id="facebook_account">
    <h1>Compte facebook</h1>

    <div id="profile_section">
        <div class="profile_picture">
            <img src="<?php echo $fbManager->getProfile()['profile_pict']; ?>" alt="">
        </div>
        <div class="fb-infos">
            <span class="label-group-inline">
                <h3>Prénom:</h3><p id="facebook_lastname"><?php echo $fbManager->getProfile()['last_name']; ?></p>
            </span>
            <span class="label-group-inline">
                <h3>Nom:</h3><p id="facebook_name"><?php echo $fbManager->getProfile()['name']; ?></p>
            </span>

            <span class="label-group-inline">
                <h3>Email:</h3><p id="facebook_email"><?php echo $fbManager->getProfile()['email']; ?></p>
            </span>
        </div>
    </div>

    <div id="pages-section">
        <h3>Les pages du compte</h3>
        <?php foreach($fbManager->getPages() as $page_name => $page_data): ?>
            <label class="pages"> <?= $page_name?> </label>
        <?php endforeach?>
    </div>

    
    <div class="shortcodes">
        <h3>Les shortcodes</h3>
        <p>[SWC_facebookFeed page="ma page"] Affiche un feed de message</p>
        <p>[SWC_facebookFeed page="ma page" options="img-only"] Affiche un feed d'image</p>
        <p>[SWC_facebookFeed page="ma page" options="mix"] Affiche un feed d'image et message</p>
        <p>L'options likes permet l'affichage du nombre de like</p>
    </div>

</div>