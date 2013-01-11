/**
 * WP Sharrre Upload
 * @author: Derek Marcinyshyn <derek@marcinyshy.com>
 */
jQuery(document).ready(function($) {
    $('#upload_logo_button').click(function() {
        tb_show('Upload your default Pinterest Image', 'media-upload.php?referer=wp-sharrre&type=image&TB_iframe=true&post_id=0', false);
        return false;
    });

    window.send_to_editor = function(html) {
        // html returns a link like this:
        // <a href="{server_uploaded_image_url}"><img src="{server_uploaded_image_url}" alt="" title="" width="" height"" class="alignzone size-full wp-image-125" /></a>
        var image_url = $('img',html).attr('src');
        //alert(html);

        // edit the line below to reflect the input id
        $('#wp_sharrre_pinterest\\[pinterest_default_image\\]').val(image_url);
        tb_remove();
        $('#upload_image_preview img').attr('src',image_url);

        $('#submit_options_form').trigger('click');
        // $('#uploaded_logo').val('uploaded');

    }
});