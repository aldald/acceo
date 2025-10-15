<?php
function get_image_alt($id)
{
    return get_post_meta($id, '_wp_attachment_image_alt', true);
}
