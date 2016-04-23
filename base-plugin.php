<?php
/*
Plugin Name: Base Plugin
Plugin URI: http://nabtron.com/base-plugin/
Description: Base plugin to be modified
Tags: show, base, plugin, options
Version: 0.1
Author: Nabtron
Author URI: http://nabtron.com
Min WP Version: 4.4
Max WP Version: 4.5
*/

// search and replace 'baseplugin' with your own WordPress plugins keyword

/* registering activation and uninstall hooks */
register_activation_hook( __FILE__, array( 'baseplugin_main', 'activation' ) );
register_uninstall_hook( __FILE__, array('baseplugin_main', 'uninstall') );

if (!class_exists('baseplugin_main')) {
	class baseplugin_main {

		private $show_wp_server_status;

		// PHP 4 Compatible Constructor
		public function baseplugin_main(){$this->__construct();}

		// PHP 5 Constructor
		public function __construct(){
			add_action( 'admin_init', array( $this, 'page_init' ) );
			add_action( 'admin_menu', array( $this, 'baseplugin_add_menu' ) );
		}

		public function page_init() {
			// get saved options value like this
			$baseplugin_one = get_option( 'baseplugin_one' );

            if ( !wp_verify_nonce( $_POST['baseplugin_noncename'], plugin_basename(__FILE__) )) {
                return;
            }
            if ( !current_user_can( 'manage_options' )){
                return;
            }
			// Update routines
			if ('insert' == $_POST['action_baseplugin']) {
				update_option( 'baseplugin_one', $_POST['baseplugin_one'] );
			}
		}

		static function activation() {
			// set this options value by default
			if(!get_option( 'baseplugin_one' )) {
				update_option( 'baseplugin_one' , '1' );
			}
		}

		// Admin menu page
		public function baseplugin_add_menu() {
			add_options_page('baseplugin options', 'baseplugin', 'manage_options', __FILE__, array( $this, 'baseplugin_option_page') );
		}

		public function baseplugin_option_page() {
		$baseplugin_urltosubmit = $_SERVER["REQUEST_URI"];
		?>
		<!-- Start Options Admin area -->
		<div class="wrap">
			<h2>baseplugin Options</h2>
			<div style="margin-top:20px;">
				<div class="baseplugin_main_options_section" style="">
				<form method="post" action="<?php echo $baseplugin_urltosubmit; ?>&amp;updated=true">
					<h3>Settings</h3>
					<p>
						<label for="baseplugin_one">label for baseplugin_one</label>
						<input type="text" name="baseplugin_one" value="<?php echo get_option( 'baseplugin_one' ); ?>" id="baseplugin_one" />
						<i>Description for baseplugin_one, output by: &lt;?php echo get_option('baseplugin_one'); ?&gt;</i>
					</p>
					<p>
					<p class="submit_baseplugin">
                        <input type="hidden" name="baseplugin_noncename" id="baseplugin_noncename" value="<?php echo wp_create_nonce( plugin_basename(__FILE__) ); ?>" />
						<input name="submit_baseplugin" type="submit" class="button-primary" id="submit_baseplugin" value="Save changes">
						<input class="submit" name="action_baseplugin" value="insert" type="hidden" />
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
		} // End method baseplugin_option_page()

		static function uninstall() {
			delete_option( 'baseplugin_one');
		}
	}
}

//instantiate the class
if (class_exists('baseplugin_main')) {
	$baseplugin_main = new baseplugin_main();
}
?>