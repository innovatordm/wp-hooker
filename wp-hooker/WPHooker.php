<?php
use WPHooker\Classes\HookerSettings;
/*
Plugin Name: WordPress Hooker
Plugin URI: http://www.innovator.se
Description: Generates a diagram of all active hooked functions
Version: 0.1
Author: Innovator Digital Markets AB
Author URI: http://www.innovator.se
Text Domain: wp-hooker
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once( 'classes/HookerSettings.php');

/**
 * Main Class for WP Hooker
 */
class WPHooker
{
	/**
	 * Instance variable
	 * @var object
	 */
	private static $_instance;
	/*
	 * Class variables
	 */
	private $hooks,
			$settings,
			$hookLog;
	
	function __construct()
	{
		
		//add_action( 'wp_enqueue_scripts', array($this, 'enqueueScripts') );
	}
	/**
	 * Initiate all necessary functions for WP-Hooker
	 * @return void 
	 */
	public function init()
	{
		global $wp_filter;
		
		$this->settings = new HookerSettings();

		$this->registerPostType();

		$this->hooks = array_keys($wp_filter);
		// Run only if status is set to active
		if($this->settings->getOption('wp-hooker-status')) {
			for ($i=0; $i < count($this->hooks); $i++) { 
				if($hook !== 'init')
					add_filter( $this->hooks[$i], __CLASS__ . '::execLog', 0);
			}
			add_action( 'shutdown', __CLASS__ . '::execSave' );
		}
	}

	/**
	 * Register wp_hooker post type
	 * @return void
	 */
	function registerPostType() {
	  register_post_type( 'wp_hooker',
	    array(
	      'labels' => array(
	        'name' => __( 'Sessions' ),
	        'singular_name' => __( 'Session' )
	      ),
	      'public' => true,
	      'has_archive' => false, 
	    )
	  );
	}

	/**
	 * Check if an instance of the class exists, and either creates a new one or returns the existing one
	 * @return object returns an instance of the class
	 */
	public static function getInstance() {
	  if ( ! isset( self::$_instance ) ) {
	    self::$_instance = new WPHooker();
	  }
	  return self::$_instance;
	}

	/**
	 * Logs the submitted hookname to the class variable $hookLog
	 * @param  string $hookname name of the hook to be logged
	 * @return void
	 */
	private function logger($hookName='')
	{
		if(!empty($hookName))
			$this->hookLog[microtime(true) . '-' . uniqid()] = $hookName;	
	}

	/**
	 * Hook function for logger
	 * @param  string $value optional return value for filters
	 * @return any           Returns any submitted parameter 
	 */
	public static function execLog($value='')
	{
		// Get current hook
		$currentHook = current_filter();
		// Log to class
		self::getInstance()->logger($currentHook);
		// Return any passed variable
		return $value;
	}

	/**
	 * Saves the session data to WP
	 * @return void
	 */
	public function saveToWP()
	{
		
		// Generate a unique ID for the session
		$sessionId = uniqid();
		$post = array(
			'post_name'      => $sessionId,
			'post_title'     => 'Session: ' . $sessionId,
			'post_status'    => 'publish', // Default 'draft'.
			'post_type'      => 'wp_hooker',
			'post_author'    => 1 // Temporary id, change to user who activated the session recording
		);
		// Save session data as post
		$postId = wp_insert_post($post);
		add_post_meta( $postId, '_session_data', $this->hookLog, true );
	}

	/**
	 * Hook function for saveToWP
	 * @return void
	 */
	public static function execSave()
	{
		self::getInstance()->saveToWP();
	}

	public function enqueueScripts()
	{
		wp_enqueue_style( 'hooker-joint-style', plugins_url('assets/css/joint.min.css', __FILE__ ), array() );
		wp_enqueue_script( 'hooker-joint', plugins_url('assets/js/lib/joint.min.js', __FILE__ ), array() );
		wp_enqueue_script( 'hooker-joint-erd', plugins_url('assets/js/lib/joint.shapes.erd.min.js', __FILE__ ), array('hooker-joint') );
		wp_enqueue_script( 'hooker-joint-diagram', plugins_url('assets/js/diagram.js', __FILE__ ), array('hooker-joint', 'jquery'), '1.0', true );
		global $wp_filter;
		wp_localize_script( 'hooker-joint-diagram', 'wpHookers', $wp_filter);
	}
}
/**
 * Initiate WPHooker
 * @return void
 */
function initWPHooker()
{
	WPHooker::getInstance()->init();
}
add_action( 'init', 'initWPHooker' );
?>