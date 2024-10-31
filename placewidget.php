<?php
/*
Plugin Name: PlaceWidget for Wordpress
Plugin URI: http://www.placewidget.com/wordpress
Description: Embed Foursquare venue widgets from PlaceWidget.com on your Wordpress blog
Version: 1.1
Author: Brad Kellett
Author URI: http://bradkellett.com
*/

/*  Copyright 2010  Brad Kellett  (email : bck@bradkellett.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

$PW_PLUGIN_DIR = str_replace(basename(__FILE__),"",plugin_basename(__FILE__));
require(WP_PLUGIN_DIR.'/'.$PW_PLUGIN_DIR."placewidget_admin.php");
add_action('admin_menu', 'pw_add_menu');
add_action("plugins_loaded", "pw_widget_init");

function pw_add_menu() {
    add_options_page("PlaceWidget Settings", "PlaceWidget", "switch_themes", "placewidget", "show_admin");
}

function widget_placeWidget($args) {
    if(get_option("pw_embed_code")) {
        extract($args);
        echo $before_widget;
        echo $before_title."Foursquare".$after_title;
        echo stripslashes(get_option("pw_embed_code"));
        echo $after_widget;
    }
}

function pw_widget_init() {
    wp_register_sidebar_widget("placewidget", "PlaceWidget", 'widget_placeWidget', array(
        'description' => 'Show your venue\'s Foursquare details on your Wordpress blog. Configure under the settings menu first.')
    );
}

