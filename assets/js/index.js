let facebook_btn_connection = document.getElementById('facebook_btn_login')
let access_token_input      = document.getElementById('access_token')

window.fbAsyncInit = function() {
    FB.init({
        appId      : '881572569456459',
        cookie     : true, 
        xfbml      : true,
        version    : 'v11.0'
    });
};

(function(d, s, id){
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {return;}
    js = d.createElement(s); js.id = id;
    js.src = "https://connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));



function checkLoginState() {
    FB.getLoginStatus(function(response) {
        if(response.status === "connected"){
            access_token_input.value = response.authResponse.accessToken
            facebook_btn_connection.style.display = 'none'
        }
    });
}


