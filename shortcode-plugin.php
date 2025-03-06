<?php

/**
 * Plugin Name: Shortcode Plugin
 * Description: This is our second plugin which gives idea about shortcode basics.
 * Version: 1.0
 * Author: Mehedi Hassan Shovo
 * Author URI: https://mehedisshovo.com
 * Plugin URI: https://example.com
 */

//  basic shortcode
 add_shortcode('message', 'sp_show_static_message');

 function sp_show_static_message() {
    return '<p style="color:red;font-size:36px;font-weight:bold;">Hello, I am a simple shortcode message.</p>';
 }

//  shortcode with parameters
// [student name='Mehedi Hassan Shovo' email='mehedi@gmail.com']

add_shortcode('student', 'sp_handle_student_data');

function sp_handle_student_data($attributes) {
    $attributes = shortcode_atts(array(
        'name' => 'Mehedi Hassan Shovo',
        'email' => 'mehedi@gmail.com'
    ), $attributes, 'student');

    return "<h3 style='color:blue;'>Student Data: Name - ".$attributes['name'].", Email - ".$attributes['email']."</h3>";
}

// shortcode with database operations

add_shortcode('post-list', 'sp_handle_list_posts_with_wp_query_class');

function sp_handle_list_posts() {
    global $wpdb;
    $table_prefix = $wpdb->prefix;
    $table_name = $table_prefix . 'posts';

    // get post where post_type = 'post' and post_status = 'publish'
    $posts = $wpdb->get_results(
        "SELECT post_title FROM {$table_name} WHERE post_type = 'post' AND post_status = 'publish'"
    );

    if(count($posts) > 0) {
        $outputHtml = "<ul>";
        foreach($posts as $post) {
            $outputHtml .= "<li>{$post->post_title}</li>";
        }
        $outputHtml .= "</ul>";
        return $outputHtml;
    }

    return "<p>No posts found.</p>";
}

// same logic using WP_Query

function sp_handle_list_posts_with_wp_query_class($attributes) {
    $attributes = shortcode_atts(array(
        'number' => 5,
    ), $attributes, 'list-posts');

    $query = new WP_Query(array(
        "post_per_page" => $attributes['number'],
        "post_status" => "publish",
        "post_type" => "post"
    ));

    if($query->have_posts()) {
        $outputHtml = "<ul>";
        while($query->have_posts()) {
            $query->the_post();
            $outputHtml .= "<li><a href='".get_the_permalink()."' target='_blank'>".get_the_title()."</a></li>";
        }
        $outputHtml .= "</ul>";
        return $outputHtml;
    }

    return "<p>No posts found.</p>";
}