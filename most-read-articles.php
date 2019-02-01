<?php

/*
Plugin Name: MostReadWidget
Plugin URI: https://www.advancedcustomfields.com/
Description: Customize WordPress with most read articles per category.
Version: 5.7.8
Author: auLAB
Author URI: http://www.elliotcondon.com/
Copyright: auLAB
*/

require_once plugin_dir_path(__FILE__) . 'MostReadWidget.php';

add_action('widgets_init', 'loadMyWidget');

function loadMyWidget() {
	register_widget('MostReadWidget');
}

function loadWidget() {
	$widget = new MostReadWidget();
}

loadWidget();

//register widget css
function add_css_file() {
   wp_enqueue_style('css', get_template_directory_uri() . '/style-mostreadarticles.css');
}

add_action('wp_enqueue_scripts', 'add_css_file');


?>
