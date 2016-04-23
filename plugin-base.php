<?php
/*
Plugin Name: plugin base 
Plugin URI: http://nabtron.com/base-plugin/
Description: plugin base to be modified
Tags: show, base, plugin, options
Version: 0.1
Author: Nabtron
Author URI: http://nabtron.com
Min WP Version: 4.4
Max WP Version: 4.5
*/

// search and replace 'pluginbase' with your own WordPress plugins keyword

/* registering activation and uninstall hooks */
register_activation_hook( __FILE__, array( 'pluginbase_main', 'activation' ) );
register_uninstall_hook( __FILE__, array('pluginbase_main', 'uninstall') );

if (!class_exists('pluginbase_main')) {
	class pluginbase_main {

		// PHP 4 Compatible Constructor
		public function pluginbase_main(){$this->__construct();}

		// PHP 5 Constructor
		public function __construct(){
			add_action( 'admin_init', array( $this, 'page_init' ) );
			add_action( 'admin_menu', array( $this, 'pluginbase_add_menu' ) );
		}

		public function page_init() {
			// get saved options value like this
			$pluginbase_one = get_option( 'pluginbase_one' );

            if ( !wp_verify_nonce( $_POST['pluginbase_noncename'], plugin_basename(__FILE__) )) {
                return;
            }
            if ( !current_user_can( 'manage_options' )){
                return;
            }
			// Update routines
			if ('insert' == $_POST['action_pluginbase']) {
				update_option( 'pluginbase_one', $_POST['pluginbase_one'] );
			}
		}

		static function activation() {
			// set this options value by default
			if(!get_option( 'pluginbase_one' )) {
				update_option( 'pluginbase_one' , '1' );
			}
		}

		// Admin menu page
		public function pluginbase_add_menu() {
			add_options_page('pluginbase options', 'pluginbase', 'manage_options', __FILE__, array( $this, 'pluginbase_option_page') );
		}

		public function pluginbase_option_page() {
		$pluginbase_urltosubmit = $_SERVER["REQUEST_URI"];
		?>
		<!-- Start Options Admin area -->
		<div class="wrap">
			<h2>pluginbase Options</h2>
			<div style="margin-top:20px;">
				<div class="pluginbase_main_options_section" style="">
				<form method="post" action="<?php echo $pluginbase_urltosubmit; ?>&amp;updated=true">
					<h3>Settings</h3>
					<p>
						<label for="pluginbase_one">label for pluginbase_one</label>
						<input type="text" name="pluginbase_one" value="<?php echo get_option( 'pluginbase_one' ); ?>" id="pluginbase_one" />
						<i>Description for pluginbase_one, output by: &lt;?php echo get_option('pluginbase_one'); ?&gt;</i>
					</p>
					<p>
					<p class="submit_pluginbase">
                        <input type="hidden" name="pluginbase_noncename" id="pluginbase_noncename" value="<?php echo wp_create_nonce( plugin_basename(__FILE__) ); ?>" />
						<input name="submit_pluginbase" type="submit" class="button-primary" id="submit_pluginbase" value="Save changes">
						<input class="submit" name="action_pluginbase" value="insert" type="hidden" />
					</p>
				</form>
				</div>
			</div>
			<div style="clear:both;"></div>
			<p>&nbsp;</p>
			<hr />
			<center>
				<h4>Developed by <a href="http://nabtron.com/" target="_blank">Nabtron</a>.</h4>
			</center>
		</div>
	<?php
		} // End method pluginbase_option_page()

		static function uninstall() {
			delete_option( 'pluginbase_one');
		}
	}
}

//instantiate the class
if (class_exists('pluginbase_main')) {
	$pluginbase_main = new pluginbase_main();
}
?>
