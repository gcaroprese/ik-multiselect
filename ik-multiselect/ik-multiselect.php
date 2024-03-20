<?php
/*
Plugin Name: Inforket Multiselector
Description: Add class ".ikmultiselect" to your select field to activate multiselect
Version: 1.1.1
Author: Gabriel Caroprese / Inforket
Author URI: https://inforket.com/
*/ 

add_action('wp_footer', 'ik_multiselect_addscript');
function ik_multiselect_addscript(){
    include('js/jsfile.php');
}

?>