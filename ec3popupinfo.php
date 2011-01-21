<?php
/*
Plugin Name: Ec3popupinfo
Plugin URI: http://takeai.silverpigeon.jp/
Description: Ec3popupinfo is a plugin that popup message on mouse over the event-calendar plugin.
Author: AI.Takeuchi
Version: 0.1.3
Author URI: http://takeai.silverpigeon.jp/
*/

// -*- Encoding: utf8n -*-
// If you notice a my mistake(Program, English...), Please tell me.

/*  Copyright 2009 AI Takeuchi (email: takeai@silverpigeon.jp)

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
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

//load_plugin_textdomain('ec3popupinfo');
load_plugin_textdomain( 'ec3popupinfo',
		'wp-content/plugins/ec3popupinfo/lang', 'ec3popupinfo/lang' );

if (is_admin()) {
    $wpEc3popupinfo = & new WpEc3popupinfo();
    // Registration of management screen header output function.
    add_action('admin_head', array(&$wpEc3popupinfo, 'addAdminHead'));
    // Registration of management screen function.
    add_action('admin_menu', array(&$wpEc3popupinfo, 'addAdminMenu'));
} else {
    wp_enqueue_script('jquery');
    //require_once('module/add_wp_head.php');
    //add_action('wp_head', 'add_wp_head');
    require_once('module/ec3popupinfo_wp_head.php');
    add_action('wp_head', 'ec3popupinfo_wp_head');
    //add_shortcode('ec3popupinfo', 'ec3popupinfo');
    // Can use the short-code in sidebar widget
    //add_filter('widget_text', 'do_shortcode');
}

/* Data model */
class WpEc3popupinfoModel {
    // member variable
    var $version = '0.1.0';
    var $data = '';
    var $holiday = '';
    var $holidayCss = 'background:#ffffcc;';
    
    // constructor
    function WpEc3popupinfoModel() {
        // default value
    }
    
    //
    function setData($str) {
        $this->data = $str;
    }
    function getData() {
        return $this->data;
    }
    //
    function setHoliday($str) {
        $this->holiday = $str;
    }
    function getHoliday() {
        return $this->holiday;
    }
    //
    function setHolidayCss($str) {
        $this->holidayCss = $str;
    }
    function getHolidayCss() {
        return $this->holidayCss;
    }
}

/* main class */
class WpEc3popupinfo {
    var $view;
    var $model;
    var $request;
    var $plugin_name;
    var $plugin_uri;

    // constructor
    function WpEc3popupinfo() {
        $this->plugin_name = 'ec3popupinfo';
        
        $this->plugin_uri  = get_settings('siteurl');
        $this->plugin_uri .= '/wp-content/plugins/ec3popupinfo/';

        $this->model = $this->getModelObject();
    }
    
    // create model object
    function getModelObject() {
        $data_clear = 0; // Debug: 1: Be empty to data
        
        // get option from Wordpress
        $option = $this->getWpOption();
        
        //printf("<p>Debug[%s, %s]</p>", strtolower(get_class($option)), strtolower('WpEc3popupinfoModel'));
        
        // Restore the model object if it is registered
        if (strtolower(get_class($option)) === strtolower('WpEc3popupinfoModel') && $data_clear == 0) {
            $model = $option;
        } else {
            // create model instance if it is not registered,
            // register it to Wordpress
            $model = & new WpEc3popupinfoModel();
            $this->addWpOption($model);
        }
        return $model;
    }
    
    function getWpOption() {
        $option = get_option($this->plugin_name);
        
        if(!$option == false) {
            $OptionValue = $option;
        } else {
            $OptionValue = false;
        }
        return $OptionValue;
    }

    /* be add plug-in data to Wordpresss */
    function addWpOption(&$model) {
        $option_description = $this->plugin_name . " Options";
        $OptionValue = $model;
        //print_r($OptionValue);
        add_option(
            $this->plugin_name,
            $OptionValue,
            $option_description);
    }

    /* update plug-in data */
    function updateWpOption(&$OptionValue) {
        $option_description = $this->plugin_name . " Options";
        $OptionValue = $OptionValue;
        //$OptionValue = $this->model;
        
        update_option(
            $this->plugin_name,
            $OptionValue,
            $option_description);
    }
    
    /*
     * management screen header output
     * reading javascript and css
     */
    function addAdminHead() {
        echo '<link type="text/css" rel="stylesheet" href="';
        echo $this->plugin_uri . 'ec3popupinfo.css" />' . "\n";;
        
        //echo '<script type="text/javascript" src="';
        //echo $this->plugin_uri . 'js/ec3popupinfo.js">';
        //echo '</script>'  . "\n";

        //echo '<script type="text/javascript">';
        //require_once('module/js.php');
        //echo '</script>';
    }

    function addAdminMenu() {
        add_options_page(
            'Ec3popupinfo Options',
            'Ec3popupinfo',
            6,//8,
            'ec3popupinfo.php',
            array(&$this, 'executeAdmin')
            );
    }

    function executeAdmin() {
        require_once('module/execute_admin.php');
        execute_admin($this);
    }
}
?>
