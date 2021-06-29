<?php
  function tabs ($current = 'seo') {
    $tabs = array(
      'seo' => __('SEO', 'uxoctopus'), 
      'auth' => __('Recaptcha', 'uxoctopus'),
      'theme' => __('Visual', 'uxoctopus')
    );

    $html = '<nav class="nav-tab-wrapper mt-32">';

    foreach($tabs as $tab => $name) {
      $class = ($tab == $current) ? 'nav-tab-active' : '';
      $html .= '<a class="nav-tab ' . $class . '" href="?page=uxoctopus&tab=' . $tab . '">' . $name . '</a>';
    }

    $html .= '</nav>';
    
    echo $html;
  }
?>
