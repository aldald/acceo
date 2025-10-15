<?php
function wps_yoast_breadcrumb_bootstrap()
{
    if (function_exists('yoast_breadcrumb')) {
        $breadcrumb = yoast_breadcrumb(
            '<ul class="breadcrumb"><li class="breadcrumb-item">',
            '</li></ul>',
            false
        );

        echo str_replace(
            'xxx',
            '</li><li class="breadcrumb-item">',
            $breadcrumb
        );
    } else {
        echo '<ul class="breadcrumb"><li>Missing function "yoast_breadcrumb"</li></ul>';
    }
}
