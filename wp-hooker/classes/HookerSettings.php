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
	/**
	 * Container for currently active settings for WP Hooker
	 * @var object
	 */
	private $currentSettings;
	function __construct()
	{
		global $wp_hooker_options;
		$this->currentSettings = $wp_hooker_options; 	
	}
	/**
	 * Return the specified if it exists, or false it not
	 * @param  string $option Name of the wanted option
	 * @return any         
	 */
	public function getOption($option='')
	{
		if( !empty($this->currentSettings[$option]) )
			return $this->currentSettings[$option];
		return false;
	}
}
?>