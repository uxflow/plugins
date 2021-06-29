/**
 * Import styles.
 */
import '@uxoctopus/styles';
import '../scss/auth.scss';
import '../scss/admin.scss';
import '../scss/index.scss';
import '../scss/custom.scss';


/**
 * Main.
 */
jQuery(document).ready(function ($) {
  /**
   * Variables.
   */
  var frame,
    box = $('#uxoctopus-upload.upload'),
    add = box.find('.button-upload'),
    del = box.find('.button-delete'),
    input = box.find('input[name="uxoctopus-theme[logo]"]'),
    container = box.find('.upload-image');

  /**
   * Add image link.
   */
  add.click(function (e) {
    e.preventDefault();

    // var send_attachment = wp.media.editor.send.attachment;

    // var button = $(this);

    // wp.media.editor.send.attachment = function (props, attachment) {
    //   $(button).next().next().attr('src', attachment.url);
    //   $(button).prev().val(attachment.url);
    //   wp.media.editor.send.attachment = send_attachment;
    // }

    // wp.media.editor.open(button);

    // return false;

    /**
     * If the media frame already exists, reopen it.
     */
    if (frame) {
      frame.option();

      return;
    }

    frame = wp.media({
      title: 'Selecione uma mídia',
      button: {
        text: 'Selecionar',
      },
      multiple: false,
    });

    /**
     * When an image is selected in the media frame...
     */
    frame.on('select', function () {
      /**
       * Get media attachment details from the frame state.
       */
      var attachment = frame.state().get('selection').first().toJSON();

      /**
       * Send the attachment URL to our custom image input field.
       */
      container.append('<img src="' + attachment.url + '" alt="" style="max-width:100%;"/>');

      /**
       * Send the attachment id to our hidden input.
       */
      input.val(attachment.url);

      /**
       * Hide the add image link and
       * unhide the remove image link.
       */
      add.addClass('hidden');
      del.removeClass('hidden');
    });

    /**
     * Finally, open the modal on click.
     */
    frame.open();
  });

  /**
   * Delete image link.
   */
  del.click(function (e) {
    e.preventDefault();

    /**
     * Clear out the preview image.
     */
    container.html('');

    /**
     * Hide the remove image link and
     * unhide the add image link.
     */
    del.addClass('hidden');
    add.removeClass('hidden');

    /**
     * Delete the image id from the hidden input.
     */
    input.val('');
  });
})
