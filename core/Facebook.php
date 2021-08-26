<?php

class Facebook{
    public function __construct($app_id, $app_secret, $access_token){
        global $wpdb;
        global $tablename;
        global $app_credentials;
        try{
            $this->facebook = new \Facebook\Facebook([
                'app_id' => $app_id,
                'app_secret' => $app_secret,
                'default_graph_version' => 'v11.0',
                'default_access_token'  => $access_token
            ]);

            $this->profile = [
                'name' => null,
                'last_name' => null,
                'email'     => null,
                'profile_pict' => null,
                'pages'        => null
            ];
            $this->pages = array();   
            // $this->setLongLiveToken($app_credentials, $tablename);
            $this->get_facebookUserInforamtions();
            

        }catch(Facebook\Exceptions\FacebookSDKException $e){
            $wpdb->delete($tablename, ['id' => $app_credentials->id]);
        }catch(Facebook\Exceptions\FacebookAuthenticationException $e){
            $wpdb->delete($tablename, ['id' => $app_credentials->id]);
        }catch(Facebook\Exceptions\FacebookResponseException $e){
            $wpdb->delete($tablename, ['id' => $app_credentials->id]);
        }
    }

    public function setLongLiveToken($app_credentials, $tablename){
        global $wpdb;
        $token = json_decode($this->sendRequest("oauth/access_token?grant_type=fb_exchange_token&client_id=$app_credentials->app_id&client_secret=$app_credentials->app_secret&fb_exchange_token=$app_credentials->app_token")->getBody());
        $wpdb->update($tablename, ['app_token' => $token->access_token], $app_credentials->id);
        $this->facebook->setDefaultAccessToken($token->access_token);
    }

    public function get_facebookUserInforamtions(){
        $user_informations = $this->sendRequest('/me?fields=id,name,email,last_name');
        $picture           = $this->sendRequest('/me/picture');
        $pages             = $this->sendRequest('/me/accounts');
        $me = $user_informations->getGraphUser();

        $this->profile['name'] = $me->getName();
        $this->profile['last_name'] = $me->getLastName();
        $this->profile['email'] = $me->getEmail();
        $this->profile['profile_pict'] = $picture->getHeaders()['location'];  
        $this->profile['pages']  = json_decode($pages->getBody());

        $this->SetPages(json_decode($pages->getBody())->data);
    }

    public function getProfile(){
        return $this->profile;
    }

    function getPages(){
        return $this->pages;
    }


    private function sendRequest($url ){
        try{    
            $data = $this->facebook->get($url);
            return $data;
        }catch(Error $e){
            return $e;
        }
    }

    private function SetPages($data_request){
        foreach($data_request as $page){
            $this->pages += array_merge($this->pages, [$page->name => [
                'name' => $page->name,
                'category' => $page->category,
                'accessToken' => $page->access_token,
                'id'          => $page->id
            ]]);
        }
    }

    private function getPageId($page_name){
        foreach($this->pages as $pagename => $data){
            if($page_name === $pagename){
                return $data['id'];
            }
        }
        return 'Une erreur c produite';
    }

    
    public function getPagesFeed($page_name){
        $id = $this->getPageId($page_name);
        $url = "/$id/feed?fields=actions,message,from,attachments";
        $feed = $this->sendRequest($url);
        return json_decode($feed->getBody())->data;
    }

    public function getPostLikes($post_id){
        $url = "/$post_id/likes?&summary=total_count";
        $likes = json_decode($this->sendRequest($url)->getBody())->summary->total_count;
        return $likes;
    }
}