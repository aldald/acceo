<?php
function pagination($pages = '', $range = 2)
{
    $showitems = ($range * 2) + 1;
    global $paged;
    if (empty($paged)) $paged = 1;
    if ($pages == '') {
        global $wp_query;
        $pages = $wp_query->max_num_pages;
        if (!$pages) {
            $pages = 1;
        }
    }
    if (1 != $pages) {
        echo '<nav aria-label="Posts navigation"><ul class="pagination">';

        echo '<li class="page-item"><a class="btn btn-nav btn-prev" href="' . get_pagenum_link(1) . '" data-toggle="tooltip" data-placement="top" data-tooltip-class="tooltip-primary" title="" data-original-title="Première page">';
        the_icon('icon-left', array('width' => 20, 'height' => 20));
        echo '</a></li>';

        if ($paged > 1 && $showitems < $pages) {
            echo '<li class="page-item"><a class="previous page-link" href="' . get_pagenum_link($paged - 1) . '" data-toggle="tooltip" data-placement="top" data-tooltip-class="tooltip-primary" title="" data-original-title="Page précédente">';
            the_icon('caret-left', array('width' => 16, 'height' => 16));
            echo '</a></li>';
        }

        for ($i = 1; $i <= $pages; $i++) {
            if (1 != $pages && (!($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems)) {
                echo ($paged == $i) ? '<li class="page-item active"><span aria-current="page" class="page-link current" data-toggle="tooltip" data-placement="top" data-tooltip-class="tooltip-primary" title="" data-original-title="Page actuelle">' . $i . '</span></li>' : '<li class="page-item"><a class="page-link" href="' . get_pagenum_link($i) . '">' . $i . '</a></li>';
            }
        }

        echo '<li class="page-item"><a class="btn btn-nav btn-next" href="' . get_pagenum_link($paged + 1) . '" data-toggle="tooltip" data-placement="top" data-tooltip-class="tooltip-primary" title="" data-original-title="Page suivante">';
        the_icon('icon-right', array('width' => 20, 'height' => 20));
        echo '</a></li>';

        echo '</ul></nav>';
    }
}
