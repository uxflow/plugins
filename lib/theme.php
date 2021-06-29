<?php 
  function theme () {
    /**
     * Custom head auth.
     */
    function login_head() {     
      echo '<style>';
      echo '.login #nav a, .login #backtoblog a { color: # !important; }'; //Login page link color
      echo '.login h1 a { background:url("' . get_bloginfo('stylesheet_directory') . '/images/IMAGE GOES HERE"); width: px; height: px; }'; //Login page logo
      echo '.login .button-primary { background:#; border-color:#; }'; //Login page button color
      echo '</style>'; 
    }
    
    /**
     * Auth theme.
     */
    function auth () {
      wp_enqueue_style ('auth-theme', plugins_url ('dist/main.css', __FILE__));
    }

    /**
     * Admin theme.
     */
    function admin () {
      wp_enqueue_style ('admin-theme', plugins_url ('dist/main.css', __FILE__));
    }

    /**
     * Add actions.
     */
    add_action('login_head', 'login_head');
    add_action ('login_enqueue_scripts', 'auth');
    add_action ('admin_enqueue_scripts', 'admin');
  }
?>
