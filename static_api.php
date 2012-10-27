<?php
/*
Plugin Name: Static API
Plugin URI: 
Description: Use wordpress custom post type as a static content api
Author: billynyh
Version: 0.1
Author URI: http://billynyh.com
*/


if (!defined('STATIC_API_POST_TYPE')){
    define('STATIC_API_POST_TYPE', "static_api");
}

function init_static_api(){
    $args = array(
        "label" => "Static API",
        "public" => true,
        "show_ui" => true,
        "supports" => array("editor", "title"),
        "menu_position" => 5
    );

    register_post_type(STATIC_API_POST_TYPE, $args);


}

function init_static_api_meta_boxes(){
    add_meta_box("json_viewer_box", "JSONviewer", "static_api_json_viewer", STATIC_API_POST_TYPE, "normal", "low");
}

function is_static_api(){
    global $post;
    return ( STATIC_API_POST_TYPE == get_post_type( $post ) );
}

function load_static_api_page_template( $page_template ){
    if (is_static_api()){
        $page_template = dirname( __FILE__ ) . '/template.php';
    }
    return $page_template;
}

function disable_for_cpt( $default ) {
    if (is_static_api()){
        return false;
    }
    return $default;
}

function static_api_admin_head(){
    if (is_static_api()){
        $path = plugins_url("js/json.js", __FILE__);
        echo '<script src="'.$path.'"></script>';
    }
}

function static_api_json_viewer($post, $metabox){
    echo '<pre class="container">'.$post->post_content.'</pre';
}

add_action('init', 'init_static_api');
add_action('add_meta_boxes', 'init_static_api_meta_boxes');
add_filter('user_can_richedit', 'disable_for_cpt' );
add_filter('single_template', 'load_static_api_page_template');
add_filter('admin_head', 'static_api_admin_head');

?>
