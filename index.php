<?php
/**
 * Plugin Name: @uxoctopus
 * Plugin URI: https://www.estudioflow.com.br
 * Description: SEO for admin wordpress.
 * Version: 0.0.1
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Author: Yuri Martins
 * Author URI: https://www.yumartins.com.br
 * Text Domain: @uxoctopus
 */

require_once('lib/tabs.php');
require_once('lib/theme.php');
require_once('lib/callback.php');

// include dirname(__FILE__) . '/lib/recaptcha.php';
include dirname(__FILE__) . '/lib/controllers.php';

// Include theme.
theme();

function menu () {
  add_menu_page(
    __('Octopus', 'uxoctopus'),
    __('Octopus', 'uxoctopus'),
    'manage_options',
    'uxoctopus',
    'admin_page',
    'dashicons-schedule',
    'options',
    65
  );
}

function options () {
  // Check user capabilities
  if (! current_user_can('manage_options')) {
    wp_die(__('Você não tem permissões para acessar essa página.'));
  }

  ?>
    <div class="p-4 pl-0 w-4/6">
      <h1 class="text-h3 font-bold">Acesso negado.</h1>

      <p class="text-p mt-8">Habilite as permissões para acessar essa página.</p>
    </div>
  <?php
}
  
function admin_page () {
  // Get the active tab from the $_GET param
  $tab = isset($_GET['tab']) ? $_GET['tab'] : 'seo';
  ?>
  
  <div class="p-4 pl-0 w-4/6">
    <h1 class="text-h3 font-bold">
      <?php esc_html_e(get_admin_page_title()); ?> 
    </h1>

    <p class="text-p mt-8">
      <?php
        switch ($tab):
          case 'seo':
            echo 'Insira os scripts do Google Analytics e Google Tag Manager.';
            break;

          case 'auth':
            echo 'Você precisa <a href="https://www.google.com/recaptcha/admin" rel="external">registrar seu domínio</a> e pegar as chaves para o plugin funcionar.';
            break;

          case 'theme':
            echo 'Ative o tema padrão da flow.';
            break;

          default:
            break;

        endswitch;
      ?>
    </p>

    <?php 
      settings_errors();
    
      tabs($tab);
    ?>

    <div class="tab-content">
      <form method="post" action="options.php">
        <?php 
          switch($tab):
            case 'seo':
              settings_fields('uxoctopus-seo');
              do_settings_sections('uxoctopus-seo');
              break;

            case 'auth':
              settings_fields('uxoctopus-auth');
              do_settings_sections('uxoctopus-auth');
              break;

            case 'theme':
              settings_fields('uxoctopus-theme');
              do_settings_sections('uxoctopus-theme');
              break;

            default:
              break;
              
          endswitch; 

          submit_button(__('Salvar alterações'), 'button button-primary is-xs is-rounded-xs');
        ?>
      </form>
    </div>
  </div>
  
  <?php  
}
  
function load_scripts ($hook) {
  // Load only on ?page=sample-page
  if($hook != 'toplevel_page_uxoctopus') {
    return;
  }

  wp_enqueue_media();

  wp_register_script('jquery', plugins_url('dist/jquery.js', __FILE__));
  wp_register_script('main', plugins_url('dist/main.js', __FILE__), array('jquery'));

  wp_enqueue_script('jquery');
  wp_enqueue_script('main');
}

function uxoctopus_options () {
  $settings = array(
    'seo' => array(
      'slug'=>'uxoctopus-seo',
      'title'=>'SEO',
      'fields' => array(
        array(
          'id' => 'analytics',
          'type' => 'textarea',
          'title' =>'Analytics',
          'callback' => 'callback'
        ),
        array(
          'id' => 'manager',
          'type' => 'textarea',
          'title' =>'Google Tag Manager (Head)',
          'callback' => 'callback'
        ),
        array(
          'id' => 'noscript',
          'type' => 'textarea',
          'title' => 'Google Tag Manager (Noscript)',
          'callback' => 'callback'
        ),
      ),
    ),
    'auth' => array(
      'slug'=>'uxoctopus-auth',
      'title'=>'Auth',
      'fields' => array(
        array(
          'id' => 'site_key',
          'type' => 'input',
          'title' =>'Site key',
          'callback' => 'callback'
        ),
        array(
          'id' => 'secret_key',
          'type' => 'input',
          'title' =>'Secret key',
          'callback' => 'callback'
        ),
      ),
    ),
    'theme' => array(
      'slug'=>'uxoctopus-theme',
      'title'=>'Tema',
      'fields' => array(
        array(
          'id' => 'enabled',
          'type' => 'checkbox',
          'title' =>'Habilitar tema?',
          'callback' => 'callback'
        ),
        array(
          'id' => 'logo',
          'type' => 'upload',
          'title' =>'Adicionar logo',
          'callback' => 'callback'
        ),
      ),
    ),
  );

  foreach ($settings as $id => $values) {
    add_settings_section (
      $id,
      '', // $values['title']
      false,
      $values['slug'],
    );

    foreach ($values['fields'] as $field) {
      add_settings_field (
        $field['id'],
        $field['title'],
        $field['callback'],
        $values['slug'],
        $id,
        array(
          $field['id'],
          $field['type'],
          $values['slug'],
        )
      );
    }

    register_setting($values['slug'], $values['slug']);
  }
}

add_action('admin_menu', 'menu');
add_action('admin_init', 'uxoctopus_options');
add_action('admin_enqueue_scripts', 'load_scripts');
?>
