/**
 * WP Sharrre Upload
 * @author: Derek Marcinyshyn <derek@marcinyshyn.com>
 */
jQuery(document).ready(function($) {

    $('#upload_logo_button').click(function() {

        var send_attachment_bkp = wp.media.editor.send.attachment;
        var button = $(this);

        // escape square brackets with single backslash unlike double backslash when just hardcoded
        var image_field = $(this).prevAll()[0].id.replace(/[[]/g, '\\[');
        var img_field = "#" + image_field.replace(/]/g, '\\]');

        wp.media.editor.send.attachment = function(props, attachment) {
            $(img_field).val(attachment.url);
         };

        wp.media.editor.open(button);
        return false;
    });
});