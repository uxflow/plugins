<?php  
  function seo () {
    $page_id = get_queried_object_id();

    $manager = get_post_meta($page_id, '_manager', true);
    $noscript = get_post_meta($page_id, '_noscript', true);
    $analytics = get_post_meta($page_id, '_analytics', true);  

    function save ($page_id) {
      // verify nonce
      if (empty($_POST['id_nonce']) || !wp_verify_nonce($_POST['id_nonce'], basename(__FILE__)))
        return $page_id;

      // check autosave
      if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return $page_id;

      // check permissions
      if (!current_user_can('edit_post', $page_id ))
        return $page_id;
    }

    ?>
      <form method="POST">
        <input type="hidden" name="id_nonce" value="<?php echo wp_create_nonce(basename( __FILE__ )); ?>" />

        <div class="mt-24">
          <h6 class="text-h6 font-semibold">Google Analytics</h6>
          <small class="text-small">Insira seu código Analytics para ser implementado ao seu site.</small>

          <div class="input is-sm is-secondary is-rounded-sm mt-16">
            <div class="input-wrapper">
              <label for="analytics" class="input-label">Digite o código do analytics</label>

              <textarea class="input-target" name="analytics" value="<?php echo $analytics ?>"></textarea>
            </div>
          </div>
        </div>

        <div class="mt-32">
          <h6 class="text-h6 font-semibold">Google Tag Manager</h6>
          <small class="text-small">Insira seu código GTM para ser implementado ao seu site.</small>

          <div class="input is-sm is-secondary is-rounded-sm mt-16">
            <div class="input-wrapper">
              <label for="manager" class="input-label">Digite o código do GTM (head)</label>

              <textarea class="input-target" name="manager" value="<?php echo $manager ?>"></textarea>
            </div>
          </div>

          <div class="input is-sm is-secondary is-rounded-sm mt-16">
            <div class="input-wrapper">
              <label for="noscript" class="input-label">Digite o código do GTM (noscript)</label>

              <textarea class="input-target" name="noscript" value="<?php echo $noscript ?>"></textarea>
            </div>
          </div>
        </div> 

        <?php  
          submit_button(__('Salvar'), 'button is-xs is-rounded-sm');
        ?>
      </form>
    <?php
  }
?>
