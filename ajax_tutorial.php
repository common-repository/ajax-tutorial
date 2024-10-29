<?php
/*
Plugin Name: AJAX Tutorial
Plugin URI: http://www.ultimatewebtips.com/create-a-custom-ajax-action-with-json-response-to-your-wordpress-plugin/
Description: Quick tutorial how to implement an AJAX call in a plugin, works the same in themes
Version: 1.0.0
Author: Joakim Ling
Author URI: http://www.ultimatewebtips.com
*/

class AJAX_Tutorial {
	static $_o = null;
	static public function init() {
		if (self::$_o === null)
			self::$_o = new self;
		return self::$_o;
	}
	
	public function __construct() {
		// Add the 2 buttons
		add_filter('the_content', array(&$this, 'add_buttons'));
		
		// Add AJAX hooks for none logged in users, REMOVE nopriv for logged in users
		add_action('wp_ajax_nopriv_ajaxtutorial_get', array(&$this, 'load_data'));
		add_action('wp_ajax_nopriv_ajaxtutorial_save', array(&$this, 'save_data'));
		
		// Load script file
		wp_enqueue_script('AJAX-tutorial-script', plugins_url('ajax_tutorial/ajax_tutorial.js'), array('jquery'), false, true);
		
		// AJAX url for front-end, feel free to create your own file to handle requests as well.
		if (! is_admin())
			add_action('wp_head', array(&$this, 'ajaxurl'));
	}
	
	public function ajaxurl() {
?>
<script type="text/javascript">
var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
</script>
<?php
	}
	
	public function add_buttons($content) {
		// add to simple buttons to trig our actions
		global $post;
?>
		<div class="AJAX_Tutorial">
			<button class="AJAX_Tutorial_Get" rel="<?php echo $post->ID; ?>">Get</button>
			<button class="AJAX_Tutorial_Save" rel="<?php echo $post->ID; ?>">Save</button>
		</div>
<?php 		
	}
	
	public function load_data() {
		// create a JSON array, default vales
		$data = array('status'=>false, 'data'=>array());
		
		// get post_id
		$post_id = isset($_REQUEST['post_id']) ? (int)$_REQUEST['post_id'] : false;
		
		// if found
		if (false !== $post_id) {
			// add your data to JSON repsonse, in this case the all post data
			$data['data'] = get_post($post_id, ARRAY_A);
			
			// change status to ok, just to make it easy to validate in your Javascript file
			$data['status'] = 'OK';
		}
		echo json_encode($data);
		// Must exit here when call is done
		die();
	}
	
	public function save_data() {
		// create a JSON array, default vales
		$data = array('status'=>false, 'data'=>array());
		
		// get post_id
		$post_id = isset($_REQUEST['post_id']) ? (int)$_REQUEST['post_id'] : false;
		if (false !== $post_id) {
			// Save something
			// ....
			$data['status'] = 'SAVED';
		}
		echo json_encode($data);
		// Must exit here when call is done
		die();
	}
}

add_action('init', array('AJAX_Tutorial', 'init'));