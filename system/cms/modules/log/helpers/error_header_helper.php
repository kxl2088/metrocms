<?php
if (!function_exists('error_header')) {
    function error_header($header, $header_images)
    {
        $header_slug = strtolower(url_title(trim($header)));
        if (array_key_exists($header_slug, $header_images)) {
            $image_src = $header_images[$header_slug];
            return $result = img(
                array(
                    'src'   => $image_src,
                    'title' => trim($header),
                    'class' => 'tooltip-s ' . $header_slug
                )
            );
        }
        else {
            return trim('<span class="' . $header_slug . '">' . $header . '</span>');
        }
    }
}
?>