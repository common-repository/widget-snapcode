<?php
/*
Plugin Name: Snapchat Widget
Plugin URI: https://riotweb.nl
Description: Easily add your Snapchat Snapcode to your Wordpress website.
Version: 1.0
Author: Riotweb.nl
Author URI: https://riotweb.nl
License: GPL2
*/
/*
Copyright 2017

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
*/
if ( !defined('ABSPATH') )
  die('-1');

#Define
define( 'SW_VER',1.0);
define( 'SW_DOMAIN','snapchat-widget');
define( 'SW_NAME', 'Snapchat Widget' );
define( 'SW_DESC', 'Add your snapcode.' );

#Load Widget Class
include_once(sprintf("%s/widget.php",dirname(__FILE__)));

# Check if class already exits
if(!class_exists("snapchat_widget")){
	/**
	* Class : snapchat_widget
	*/
	class snapchat_widget
	{

		public function __construct()
		{
			
			add_action( 'widgets_init', array( &$this, 'load_widget' ) );
			add_action( 'admin_enqueue_scripts', array( &$this, 'load_admin_style' ) );

		} # END Function : __construct

		function load_admin_style( $hook ) {

			if( 'widgets.php' != $hook )
				return;

			wp_enqueue_media();
        	wp_enqueue_script( 'upload-script', plugin_dir_url( __FILE__ ) . 'js/upload-media.js', false, SW_VER );

		}


		/*
		* Register and load the widget
		*/
		function load_widget() {
			register_widget( 'snapchatwidget' );
		}


		/**
		* Activate plugin
		*/
		public static function activate(){} # END Function : activate

		/**
		* Deactivate plugin
		*/
		public static function deactivate(){} # END of function : deactivate

	} # END Class : snapchat_widget
} # END : if(!class_exits("snapchat_widget"))


if(class_exists("snapchat_widget")){

	# Installation and uninstallation Hooks
	register_activation_hook(__FILE__,array("snapchat_widget","activate"));
	register_deactivation_hook(__FILE__,array("snapchat_widget","deactivate"));

	# instantiate Plugin Class
	$snapchat_widget = new snapchat_widget();

} #END : if(class_exists("snapchat_widget"))
