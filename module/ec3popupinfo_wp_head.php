<?php
function ec3popupinfo_wp_head() {
    echo '<link type="text/css" rel="stylesheet" href="';
    echo WP_PLUGIN_URL . '/ec3popupinfo/ec3popupinfo.css" />' . "\n";;
    
    //echo '<script type="text/javascript">';
    require_once('ec3popupinfo.js.php');
    //echo '</script>';
}
?>