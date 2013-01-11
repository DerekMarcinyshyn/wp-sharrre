/**
 * WP Sharrre Upload
 * @author: Derek Marcinyshyn <derek@marcinyshy.com>
 */
jQuery(document).ready(function($) {
    $('#upload_logo_button').click(function() {
        tb_show('Upload a logo', 'media-upload.php?referer=wp-sharrre&type=image&TB_iframe=true&post_id=0', false);
        return false;
    });
});