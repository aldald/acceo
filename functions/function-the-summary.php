<?php

function replace_ca($matches){
    return '<h2'.$matches[1].' id="'.sanitize_title($matches[2]).'">'.$matches[2].'</h2>';
}

function add_anchor_to_title($content){
    if(is_singular('post')){
        $pattern = "/<h2(.*?)>(.*?)<\/h2>/i";

        $content = preg_replace_callback($pattern, 'replace_ca', $content);
        return $content;
    }else{
        return $content;
    }
}
add_filter('the_content', 'add_anchor_to_title', 12);

function the_summary(){
    global $post;
    $obj = '<ul id="post-summary" class="summary-list collapse show">';
    $original_content = $post->post_content;

    $patt = "/<h2(.*?)>(.*?)<\/h2>/i";
    preg_match_all($patt, $original_content, $results);

    // Vérification pour éviter l'erreur
    if (empty($results) || !isset($results[2]) || count($results[2]) === 0) {
        echo '<!-- Aucun titre trouvé pour le sommaire -->';
        return;
    }

    $lvl1 = 0;
    $lvl2 = 0;
    $lvl3 = 0;

    foreach ($results[2] as $k=> $r) {
        $lvl1++;
        $niveau = '<span class="title_lvl">'.$lvl1.'/</span>';

        $obj .= '<li class="list-item list-item-1"><a href="#'.sanitize_title($r).'">'.$r.'</a></li>';
    }

    $obj .= '</ul>';

    echo $obj;
}
