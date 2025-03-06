<?php

/**
 * Plugin Name: Shortcode Plugin
 * Description: This is our second plugin which gives idea about shortcode basics.
 * Version: 1.0
 * Author: Mehedi Hassan Shovo
 * Author URI: https://mehedisshovo.com
 * Plugin URI: https://example.com
 */

 add_shortcode('message', 'sp_show_static_message');

 function sp_show_static_message() {
    return '<p style="color:red;font-size:36px;font-weight:bold;">Hello, I am a simple shortcode message.</p>';
 }

//  pass parameter to shortcode
// [student name='Mehedi Hassan Shovo' email='mehedi@gmail.com']

add_shortcode('student', 'sp_handle_student_data');

function sp_handle_student_data($attributes) {
    $attributes = shortcode_atts(array(
        'name' => 'Mehedi Hassan Shovo',
        'email' => 'mehedi@gmail.com'
    ), $attributes, 'student');

    return "<h3>Student Data: Name - {$attributes['name']}, Email - {$attributes['email']}</h3>";
}