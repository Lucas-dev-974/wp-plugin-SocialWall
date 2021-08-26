<?php
global $fbManager;
function FacebookFeed($atts){
    global $wpdb;
    $tablename = $wpdb->prefix . 'swc_facebookapp_credentials';
    $app_credentials = $wpdb->get_results("SELECT * FROM $tablename")[0];
    $on_page = $atts['page'];

    try{
        $fbManager = new Facebook($app_credentials->app_id, $app_credentials->app_secret, $app_credentials->app_token);
        $feed = $fbManager->getPagesFeed($on_page);
        return buildFeed($feed, $atts, $fbManager);
    }catch(Error $e){
        return $e;
    }
}

function buildFeed($feed, $atts, $fbManager){
    $options = (isset($atts['options'])) ? $atts['options'] : null;
    if(sizeof($feed) > 0){
        $ui_feed = '<div class="masonry">';
        foreach($feed as $post){
            $likes = (isset($atts['likes']) && $atts['likes'] == true) ? "<span class='facebook-card-mix-like'>" . $fbManager->getPostLikes($post->id) . "</span>" : null;
            if(isset($post->message) || isset($post->attachments)){
                if($options !== null){
                    switch($options){
                        case 'img-only':
                            $ui_feed = $ui_feed . ReturnFacebookImgCard($post);
                            break;
                        case 'mix':
                            $ui_feed = $ui_feed . ReturnFacebookMixCard($post, $fbManager, $likes);
                            break;
                    }
                }else{
                    $ui_feed = $ui_feed . ReturnFacebookMessageCard($post);
                }
            }
        }
        $ui_feed = $ui_feed . '</div>';
        return $ui_feed; 
    }
}

function ReturnFacebookMessageCard($post){
    if(!isset($post->attachments)){
        return "
            <div class='masonry-brick Fb-message-card'>
                <p>$post->message</p>
            </div>
        ";
    }

}

function ReturnFacebookImgCard($post){
    if(isset($post->attachments)){
        $media = $post->attachments->data[0]->media->image;
        return " <img class='masonry-brick' src='$media->src'> ";
    }
}

function ReturnFacebookMixCard($post, $fbManager,$likes){
    if(isset($post->attachments)){
        $media = $post->attachments->data[0]->media->image;
        $message = (isset($post->message) && !empty($post->message)) ? "<p class='facebook-card-image-text'>$post->message</p>" : '';
        $composant = "
            <div class='masonry-brick'>
                <div class='swc-card-label-facebook'> 
                    <i class='fa fa-facebook-square' aria-hidden='true'></i>
                    <span class='swc-card-likes'>
                        $likes
                        <i class='fa fa-thumbs-o-up' aria-hidden='true'></i>
                    </span>
                </div>
                <img class=' swc-image masonry-brick' src='$media->src'>
                $message
            </div>
        ";
        return $composant;
    }
}



add_shortcode( 'SWC_facebookFeed', 'FacebookFeed' );
