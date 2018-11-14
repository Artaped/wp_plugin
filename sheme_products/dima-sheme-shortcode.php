<?php
function my_shortcode_function($atts) {
    $post_id = $atts ? $atts : get_the_ID();
    extract(shortcode_atts(array(
        "post_id" => "$post_id"
    ), $atts));
    $meta_value = get_post_meta( $post_id );
    return  '<div itemprop="name"><h1>'.$meta_value["meta-name"][0].'</h1></div>
                <div itemprop="description">'.$meta_value["meta-description"][0].'</div>
                   <a itemprop="image" href=​"../">
                     <img src='.$meta_value["meta-image"][0].' title="Кровать Мелисса с мягкой спинкой">
                   </a>
                <div> '.$meta_value["meta-price"][0].'</div>
              <div>'.$meta_value["meta-priceCurrency"][0].'</div>';


}
//Регистрация шорткода
add_shortcode('myshortcode', 'my_shortcode_function');