<?php  
  function seo_controller () {
    $data = new stdClass();
    $data->manager = get_option('uxoctopus-seo')['manager'];
    $data->noscript = get_option('uxoctopus-seo')['noscript'];
    $data->analytics = get_option('uxoctopus-seo')['analytics'];

    return $data;
  }

  add_action('rest_api_init', function () {
    register_rest_route('uxoctopus', 'seo', array(
      'methods' => 'GET',
      'callback' => 'seo_controller'
    ));
  });
?>
