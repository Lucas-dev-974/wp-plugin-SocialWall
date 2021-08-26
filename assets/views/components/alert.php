<?php if(isset($_GET['erreur'])):?>
    <div class="notice notice-error is-dismisable">
        <p><?= $_GET['erreur'] ?></p>
    </div>

<?php endif; ?>