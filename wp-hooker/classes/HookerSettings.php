<?php
namespace WPHooker\Classes;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( !class_exists( 'ReduxFramework' ) && file_exists( dirname( __FILE__ ) . '/lib/ReduxFramework/admin-init.php' ) ) {
	require_once( dirname( __FILE__ ) . '/lib/ReduxFramework/admin-init.php' );
}


/**
* Settings class for WPHooker 
*/
class HookerSettings
{
	function __construct()
	{
		
	}
}
?>