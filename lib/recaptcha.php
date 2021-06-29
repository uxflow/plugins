<?php  
  function recaptcha_script () { 
    wp_register_script("recaptcha_login", "https://www.google.com/recaptcha/api.js"); 
    
    wp_enqueue_script("recaptcha_login"); 
  } 

  function login_captcha () { 
    ?> 
      <div class="g-recaptcha" data-sitekey="<?php echo get_option('uxoctopus-auth')['site_key']; ?>"></div>
    <?php 
  } 

  function verify_login_captcha ($user, $password) { 
    if (isset($_POST['g-recaptcha-response'])) { 
    $recaptcha_secret = get_option('uxoctopus-auth')['secret_key']; 
    $response = wp_remote_get("https://www.google.com/recaptcha/api/siteverify?secret=". $recaptcha_secret ."&response=". $_POST['g-recaptcha-response']); 
    $response = json_decode($response["body"], true); 

      if (true == $response["success"]) { 
        return $user; 
      } else { 
        return new WP_Error("Captcha Invalid", __("<strong>ERROR</strong>: You are a bot")); 
      }  
      
    } else { 
      return new WP_Error("Captcha Invalid", __("<strong>ERROR</strong>: Habilite o Javascript no browser.")); 
    }   
  } 

  add_action("login_form", "login_captcha"); 
  add_action("lostpassword_form", "login_captcha");
  add_action("login_enqueue_scripts", "recaptcha_script"); 
  add_action("lostpassword_post", "verify_login_captcha");
  add_filter("wp_authenticate_user", "verify_login_captcha", 10, 2);
?>
