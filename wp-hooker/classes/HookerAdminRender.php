<?php
namespace WPHooker\Classes;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'AdminPageFramework')  && file_exists( dirname( __FILE__ ) . '/lib/AdminPageFramework/admin-page-framework.min.php' ) ) {
    require_once( dirname( __FILE__ ) . '/lib/AdminPageFramework/admin-page-framework.min.php' );
}

/**
* Class for rendering Hooker Admin pages, extends Admin Page framework class
*/
class HookerAdminRender extends AdminPageFramework
{
	
	function __construct()
	{
		$this->init();

		parent::__construct();
	}

	public function init() {
      
        // Create the root menu - specifies to which parent menu to add.
        $this->setRootMenuPage( 'WP Hooker Sessions' );  
 
        // Add the sub menus and the pages.
        $this->addSubMenuItems(
            array(
                'title'     => 'All Hooker Sessions',  // page and menu title
                'page_slug' => 'all_hooker_sessions'     // page slug
            )
        );
    }

    public function all_hooker_sessions()
    {
    	?>
	    <h3>Action Hook</h3>
	    <p>This is inserted by the 'do_' + page slug method.</p>
	    <?php
    }
}
?>