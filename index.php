<!DOCTYPE html>
<html>
    <head>
        <title>Facebook Friends Demo</title>
        <meta charset="UTF-8">
        <style>
            html{
                background:#fff;
            }
            body{ 
                width:800px;
                margin:0 auto;
                background: #efefef;
                padding: 15px;
                font-size: 12px;
                font-family: verdana;
            }

            #console{
                margin-top:10px;
                padding:5px;
                border-top:2px solid blueviolet;
                background: #eee;
                font-family:monospace;
                position:fixed;
                bottom:0;
                min-height:200px;
                width:100%;
                left:0;
                right:0;
            }

            #info{
                margin-top:10px;
                border:2px solid orangered;
            }

            code{
                border:1px solid gray;
                background: #fff;
                padding:0 3px;
                border-radius: 3px;
                text-align: center;
            }
        </style>
    </head>


    <body>
        <script>
            // This is called with the results from from FB.getLoginStatus().
            function statusChangeCallback(response) {
                console.log(response);
                // The response object is returned with a status field that lets the
                // app know the current login status of the person.
                // Full docs on the response object can be found in the documentation
                // for FB.getLoginStatus().
                if (response.status === 'connected') {
                    // Logged into your app and Facebook.
                    testAPI();
                } else if (response.status === 'not_authorized') {
                    // The person is logged into Facebook, but not your app.
                    document.getElementById('status').innerHTML = 'Please log ' +
                            'into this app.';
                } else {
                    // The person is not logged into Facebook, so we're not sure if
                    // they are logged into this app or not.
                    document.getElementById('status').innerHTML = 'Please log ' +
                            'into Facebook.';
                }
            }

            // This function is called when someone finishes with the Login
            // Button.  See the onlogin handler attached to it in the sample
            // code below.
            function checkLoginState() {
                FB.getLoginStatus(function (response) {
                    statusChangeCallback(response);
                });
            }

            // Here we run a very simple test of the Graph API after login is
            // successful.  See statusChangeCallback() for when this call is made.
            function testAPI() {
                log('Welcome!  Fetching your information.... ');
                log('[DEBUG] calling /me');
                FB.api('/me', function (response) {
                    log('Successful login for: ' + response.name);
                    console.log(response);

                    document.getElementById('status').innerHTML =
                            'Thanks for logging in, ' + response.name + '!';



                    getFriends();
                });
            }

            function getFriends() {
                log('Fetching your friends');
                /* make the API call */
                log('[DEBUG] calling /me/friends?fields=about,address,bio,birthday,cover,first_name,last_name,name&limit=150');
                FB.api("/me/friends?fields=about,address,bio,birthday,cover,first_name,last_name,name&limit=150",
                        function (response) {
                            console.log(response);
                            if (response && !response.error) {
                                log('You have ' + response.summary.total_count + ' friends');
                                response.data.forEach(function (friend) {
                                    log(friend.name);
                                });
                            }
                        }
                );
            }

            /* just a logger to show whay happening */
            function log(message) {
                var console = document.getElementById('console');
                console.innerHTML = console.innerHTML + '<br>&gt; ' + message;
            }

            window.fbAsyncInit = function () {
                FB.init({
                    appId: '552609414832678',
                    cookie: true, // enable cookies to allow the server to access 
                    // the session
                    xfbml: true, // parse social plugins on this page
                    version: 'v2.3' // use version 2.3
                });
                
                log('loading Facebook JavaScript SDK: appId: 552609414832678');

                // Now that we've initialized the JavaScript SDK, we call 
                // FB.getLoginStatus().  This function gets the state of the
                // person visiting this page and can return one of three states to
                // the callback you provide.  They can be:
                //
                // 1. Logged into your app ('connected')
                // 2. Logged into Facebook, but not your app ('not_authorized')
                // 3. Not logged into Facebook and can't tell if they are logged into
                //    your app or not.
                //
                // These three cases are handled in the callback function.

                FB.getLoginStatus(function (response) {
                    statusChangeCallback(response);
                });

            };




            // Load the SDK asynchronously
            (function (d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id))
                    return;
                js = d.createElement(s);
                js.id = id;
                js.src = "//connect.facebook.net/en_US/sdk.js";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));


        </script>  

        <!--
          Below we include the Login Button social plugin. This button uses
          the JavaScript SDK to present a graphical Login button that triggers
          the FB.login() function when clicked.
        -->

    <fb:login-button scope="public_profile,email,user_friends" onlogin="checkLoginState();">
    </fb:login-button>

    <div id="status">
    </div>






    <div id="info">
        <h3>Note: Only friends who installed this app are returned in API v2.0 and higher. total_count in summary represents the total number of friends, including those who haven't installed the app.</h3>
        <ol>
            <li>Create an app at developers.facebook.com</li>
            <li>Login with facebook (check this article https://developers.facebook.com/docs/facebook-login/login-flow-for-web/v2.3)</li>
            <li>request at least the following permissions <code>public_profile</code>,<code>email</code>,<code>user_friends</code></li>
            <li>Fetch the friend list (https://developers.facebook.com/docs/graph-api/reference/friend-list)</li>
        </ol>
    </div>

    <div id="console"></div>
</body> 
</html>