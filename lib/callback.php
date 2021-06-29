<?php
  function callback ($args) {
    $id = $args[0];
    $type = $args[1];
    $name = $args[2] .'['. $args[0] .']';
  
    $options = get_option($args[2]);
  
    $value = ! empty($options[$args[0]]) ? $options[$args[0]] : null;
  
    ?>
      <div class="input is-sm is-secondary is-rounded-sm mt-16">
        <div class="input-wrapper">
          <?php  
            if ($type != 'checkbox'):
              ?>
                <label for="<?php echo $id ?>" class="input-label">Digite o código.</label>
              <?php
            endif;

            switch ($type):
              case 'input':
                echo '<input class="input-target" id="'. $id .'" name="'. $name .'" value="'. $value .'" />';
                break;

              case 'radio':
                echo '
                  <input type="radio" name="'. $name .'" value="1" '. ($value == 1 ? "checked" : "") .' /> Sim
                  <input type="radio" name="'. $name .'" value="0" '. ($value == 0 ? "checked" : "") .' /> Não
                ';
                break;

              case 'checkbox':
                echo '<input type="checkbox" name="'. $name .'" value="1" '. checked($value, 1, false) .' />';
                break;

              case 'textarea':
                echo '<textarea rows="6" class="input-target" id="'. $id .'" name="'. $name .'">'. $value .'</textarea>';
                break;
  
              default:
                break;
            endswitch;
          ?>
        </div>
      </div>
    <?php
  }
?>
