<?php

/**
 * @param $atts
 * @param string $content
 * @return string
 */
function permalink_func( $atts, $content = "" ) {
    $permalink = '';
    if($atts) {
        if(intval($atts["wpid"])){
            $wpid = intval($atts["wpid"]);
        } else {
            $wpid = '';
        }
        if(sanitize_text_field($atts['target'])){
            $target = sanitize_text_field($atts["target"]);
        } else {
            $target = '_self';
        }

        if(sanitize_text_field($atts['type'])){
            $type = sanitize_text_field($atts["type"]);
        } else {
            $type = '_self';
        }

        // todo
        if ($type == 'page') {$permalink = get_permalink($wpid);}
        elseif ($type == 'post') {$permalink = get_permalink($wpid);}
        elseif ($type == 'tag') {$permalink = get_tag_link($wpid);}
        elseif ($type == 'cat') {$permalink = get_category_link($wpid);}
        else { return;}



        if($permalink) {
            $url_construct = '<a href="' . $permalink . '" title="' . sanitize_text_field($content) . '" target="' . $target . '">';
            $url_construct .= sanitize_text_field($content);
            $url_construct .= '</a>';
        } else {
            $url_construct .= sanitize_text_field($content);
        }
    } else {
        $url_construct = sanitize_text_field($content);
    }
    return $url_construct;
}
add_shortcode( 'permalink', 'permalink_func' );