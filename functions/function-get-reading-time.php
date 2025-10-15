<?php
function get_reading_time($post = 0) {
    $post = get_post( $post );
    $id = isset( $post->ID ) ? $post->ID : 0;
    $word_count = preg_match_all("/[a-z']+/i", html_entity_decode(strip_tags(get_the_content(null, false, $id)), ENT_QUOTES));
    $reading_time = ceil($word_count / 150);
    return $reading_time;
}