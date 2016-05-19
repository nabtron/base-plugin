<?php
/*
Plugin Name: Dojo
Plugin URI: http://nabtron.com/wp-server-plugin/
Description: Show average server load and uptime for last 1, 5 and 15 minutes of your linux server on top in admin panel with 2 modes to select from. 
Tags: show, server, load, average, wordpress, processes, website
Version: 0.1
Author: Nabtron
Author URI: http://nabtron.com
Min WP Version: 2.5
Max WP Version: 4.4.1
*/
add_action( 'init', 'create_post_type_dojo' );
function create_post_type_dojo() {
  register_post_type( 'dojo',
    array(
      'labels' => array(
        'name' => __( 'Dojos' ),
        'singular_name' => __( 'Dojo' ),
	'add_new' => __( 'Add New Dojo' ),
	'add_new_item' => __( 'Add New Dojo' ),
	'edit_item' => __( 'Edit Dojo' ),
	'new_item' => __( 'Add New Dojo' ),
	'view_item' => __( 'View Dojo' ),
	'search_items' => __( 'Search Dojo' ),
	'not_found' => __( 'No dojos found' ),
	'not_found_in_trash' => __( 'No dojos found in trash' )
	),
      'public' => true,
      'has_archive' => true,
      'rewrite' => array( 'slug' => 'dojo','with_front' => FALSE),
      'register_meta_box_cb' => 'add_dojos_metaboxes'
    )
  );
}

add_action( 'init', 'create_dojo_taxonomies' );

function create_dojo_taxonomies() {
	register_taxonomy('country','dojo',array('label' => 'Countries', 'singular_name' => 'Country', 'hierarchical' => false,));
	register_taxonomy('city','dojo',array('label' => 'Cities', 'singular_name' => 'City', 'hierarchical' => false,));
}

function add_dojos_metaboxes(){
	add_meta_box('dojo_address', 'Address (without city & country)', 'dojo_address_meta', 'dojo', 'side', 'default');
	add_meta_box('dojo_details', 'Dojo details', 'dojo_details_meta', 'dojo', 'normal', 'high');
	add_meta_box('dojo_instructor', 'Instructor details', 'dojo_instructor_meta', 'dojo', 'normal', 'high');
}

// The Event Location Metabox
function dojo_address_meta() {
	global $post;
	echo '<input type="hidden" name="dojo_noncename" id="dojo_noncename" value="' . wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
	echo '<textarea rows="4" name="dojo_address" id="dojo_address" class="widefat">' . get_post_meta($post->ID, 'dojo_address', true) . '</textarea>';
}

function dojo_details_meta() {
	global $post;
	echo '
	<table cellpadding="20">
		<tr>
			<td width="30%">Dojo Name:</td>
			<td>
				<input type="text" name="dojo_details_fullname" value="' . get_post_meta($post->ID, 'dojo_details_fullname', true) . '" class="widefat" />
			</td>
		</tr>
		<tr>
			<td width="30%">Indoor or Outdoor?:</td>
			<td>
				<input type="text" name="dojo_details_door" value="' . get_post_meta($post->ID, 'dojo_details_door', true) . '" class="widefat" />
			</td>
		</tr>
		<tr>
			<td width="30%">Days & Timings:</td>
			<td>
				<textarea rows="4" type="text" name="dojo_details_daystimings" class="widefat" />' . get_post_meta($post->ID, 'dojo_details_daystimings', true) . '</textarea>
			</td>
		</tr>
		<tr>
			<td>Dojo started in year:</td>
			<td>
				<input type="text" name="dojo_details_started" value="' . get_post_meta($post->ID, 'dojo_details_started', true) . '" class="widefat" />
			</td>
		</tr>
		<tr>
			<td>Awards:</td>
			<td>
				<textarea rows="4" type="text" name="dojo_details_awards" class="widefat" />' . get_post_meta($post->ID, 'dojo_details_awards', true) . '</textarea>
			</td>
		</tr>
		<tr>
			<td>Affiliated with:</td>
			<td>
				<textarea rows="4" type="text" name="dojo_details_affiliations" class="widefat" />' . get_post_meta($post->ID, 'dojo_details_affiliations', true) . '</textarea>
			</td>
		</tr>
		<tr>
			<td>Skills taught:</td>
			<td>
				<textarea rows="4" type="text" name="dojo_details_skills" class="widefat" />' . get_post_meta($post->ID, 'dojo_details_skills', true) . '</textarea>
			</td>
		</tr>
		<tr>
			<td>Branch of (if applicable):</td>
			<td>
				<input type="text" name="dojo_details_branchof" value="' . get_post_meta($post->ID, 'dojo_details_branchof', true) . '" class="widefat" />
			</td>
		</tr>
		<tr>
			<td width="30%">Phone number:</td>
			<td>
				<input type="text" name="dojo_details_phone" value="' . get_post_meta($post->ID, 'dojo_details_phone', true) . '" class="widefat" />
			</td>
		</tr>
		<tr>
			<td width="30%">Email address:</td>
			<td>
				<input type="text" name="dojo_details_email" value="' . get_post_meta($post->ID, 'dojo_details_email', true) . '" class="widefat" />
			</td>
		</tr>
		<tr>
			<td width="30%">Website:</td>
			<td>
				<input type="text" name="dojo_details_website" value="' . get_post_meta($post->ID, 'dojo_details_website', true) . '" class="widefat" />
			</td>
		</tr>
		<tr>
			<td width="30%">Facebook:</td>
			<td>
				<input type="text" name="dojo_details_facebook" value="' . get_post_meta($post->ID, 'dojo_details_facebook', true) . '" class="widefat" />
			</td>
		</tr>
		<tr>
			<td width="30%">Twitter:</td>
			<td>
				<input type="text" name="dojo_details_twitter" value="' . get_post_meta($post->ID, 'dojo_details_twitter', true) . '" class="widefat" />
			</td>
		</tr>
	</table>
	';
}

function dojo_instructor_meta() {
	global $post;
	echo '
	<table cellpadding="20">
		<tr>
			<td width="30%">Full Name:</td>
			<td>
				<input type="text" name="dojo_instructor_fullname" value="' . get_post_meta($post->ID, 'dojo_instructor_fullname', true) . '" class="widefat" />
			</td>
		</tr>
		<tr>
			<td>Age:</td>
			<td>
				<input type="text" name="dojo_instructor_age" value="' . get_post_meta($post->ID, 'dojo_instructor_age', true) . '" class="widefat" />
			</td>
		</tr>
		<tr>
			<td>Started practicing martial arts in year:</td>
			<td>
				<input type="text" name="dojo_instructor_studentsince" value="' . get_post_meta($post->ID, 'dojo_instructor_studentsince', true) . '" class="widefat" />
			</td>
		</tr>
		<tr>
			<td>Learnt martial arts from (teacher name):</td>
			<td>
				<input type="text" name="dojo_instructor_teacher" value="' . get_post_meta($post->ID, 'dojo_instructor_teacher', true) . '" class="widefat" />
			</td>
		</tr>
		<tr>
			<td>Started teaching martial arts in year:</td>
			<td>
				<input type="text" name="dojo_instructor_teachingsince" value="' . get_post_meta($post->ID, 'dojo_instructor_teachingsince', true) . '" class="widefat" />
			</td>
		</tr>
		<tr>
			<td>Awards:</td>
			<td>
				<textarea rows="4" type="text" name="dojo_instructor_awards" class="widefat" />' . get_post_meta($post->ID, 'dojo_instructor_awards', true) . '</textarea>
			</td>
		</tr>
		<tr>
			<td>Skills:</td>
			<td>
				<textarea rows="4" type="text" name="dojo_instructor_skills" class="widefat" />' . get_post_meta($post->ID, 'dojo_instructor_skills', true) . '</textarea>
			</td>
		</tr>
	</table>
	';
}

// Save the Metabox Data
function wpt_save_events_meta($post_id, $post) {
	
	// verify this came from the our screen and with proper authorization,
	// because save_post can be triggered at other times
	if ( !wp_verify_nonce( $_POST['dojo_noncename'], plugin_basename(__FILE__) )) {
	return $post->ID;
	}

	// Is the user allowed to edit the post or page?
	if ( !current_user_can( 'edit_post', $post->ID ))
		return $post->ID;

	// OK, we're authenticated: we need to find and save the data
	// We'll put it into an array to make it easier to loop though.
	
	$dojo['dojo_instructor_fullname'] = $_POST['dojo_instructor_fullname'];
	$dojo['dojo_instructor_age'] = $_POST['dojo_instructor_age'];
	$dojo['dojo_instructor_studentsince'] = $_POST['dojo_instructor_studentsince'];
	$dojo['dojo_instructor_teachingsince'] = $_POST['dojo_instructor_teacher'];
	$dojo['dojo_instructor_teachingsince'] = $_POST['dojo_instructor_teachingsince'];
	$dojo['dojo_instructor_awards'] = $_POST['dojo_instructor_awards'];
	$dojo['dojo_instructor_skills'] = $_POST['dojo_instructor_skills'];

	$dojo['dojo_details_fullname'] = $_POST['dojo_details_fullname'];
	$dojo['dojo_details_door'] = $_POST['dojo_details_door'];
	$dojo['dojo_details_daystimings'] = $_POST['dojo_details_daystimings'];
	$dojo['dojo_details_started'] = $_POST['dojo_details_started'];
	$dojo['dojo_details_awards'] = $_POST['dojo_details_awards'];
	$dojo['dojo_details_affiliations'] = $_POST['dojo_details_affiliations'];
	$dojo['dojo_details_skills'] = $_POST['dojo_details_skills'];
	$dojo['dojo_details_branchof'] = $_POST['dojo_details_branchof'];
	$dojo['dojo_details_phone'] = $_POST['dojo_details_phone'];
	$dojo['dojo_details_email'] = $_POST['dojo_details_email'];
	$dojo['dojo_details_website'] = $_POST['dojo_details_website'];
	$dojo['dojo_details_website'] = $_POST['dojo_details_facebook'];
	$dojo['dojo_details_website'] = $_POST['dojo_details_twitter'];
	
	$dojo['dojo_address'] = $_POST['dojo_address'];
	
	// Add values of $events_meta as custom fields
	
	foreach ($dojo as $key => $value) { // Cycle through the $events_meta array!
		if( $post->post_type == 'revision' ) return; // Don't store custom data twice
		$value = implode(',', (array)$value); // If $value is an array, make it a CSV (unlikely)
		if(get_post_meta($post->ID, $key, FALSE)) { // If the custom field already has a value
			update_post_meta($post->ID, $key, $value);
		} else { // If the custom field doesn't have a value
			add_post_meta($post->ID, $key, $value);
		}
		if(!$value) delete_post_meta($post->ID, $key); // Delete if blank
	}

}
add_action('save_post', 'wpt_save_events_meta', 1, 2); // save the custom fields

add_action( 'init', 'dojo_remove_post_type_support', 999 );
function dojo_remove_post_type_support() {
    remove_post_type_support( 'dojo', 'editor' );
}

//function for outputting our data on custom post type
add_filter('the_content', 'dojo_the_content');
function dojo_the_content($content)
{
    if (is_singular('dojo') && in_the_loop()) {
    global $post;
        $content = '
        <style>b{font-weight:bold;}</style>
        <div id="dojo-single-item">
        	<h2>Martial Arts Club\'s Details</h2>
        	<p><b>Dojo\'s name:</b> '.get_post_meta($post->ID, 'dojo_details_fullname', true).'</p>
        	<p><b>Training area is:</b>  '.get_post_meta($post->ID, 'dojo_details_door', true).'</p>
        	<p><b>Training Days & Timings:</b></p><p>'.get_post_meta($post->ID, 'dojo_details_daystimings', true).'</p>
        	<p><b>Dojo first started in:</b>  '.get_post_meta($post->ID, 'dojo_details_started', true).'</p>
        	<p><b>Awards won by Dojo team:</b></p><p>'.get_post_meta($post->ID, 'dojo_details_awards', true).'</p>
        	<p><b>Affiliated with:</b></p><p>'.get_post_meta($post->ID, 'dojo_details_affiliations', true).'</p>
        	<p><b>Skills taught:</b></p><p>'.get_post_meta($post->ID, 'dojo_details_skills', true).'</p>
        	<p><b>Dojo is a branch of:</b>  '.get_post_meta($post->ID, 'dojo_details_branchof', true).'</p>
        	<h2>Instructor\'s Details</h2>
        	<p><b>Instructor\'s name:</b> '.get_post_meta($post->ID, 'dojo_instructor_fullname', true).'</p>
        	<p><b>Instructor\'s age:</b> '.get_post_meta($post->ID, 'dojo_instructor_age', true).'</p>
        	<p><b>Instructor started learning martial arts in:</b> '.get_post_meta($post->ID, 'dojo_instructor_studentsince', true).'</p>
        	<p><b>Instructor learnt martial arts from:</b> '.get_post_meta($post->ID, 'dojo_instructor_teacher', true).'</p>
        	<p><b>Instructor is teaching martial arts since:</b> '.get_post_meta($post->ID, 'dojo_instructor_teachingsince', true).'</p>
        	<p><b>Awards won by instructor:</b></p><p>'.get_post_meta($post->ID, 'dojo_instructor_awards', true).'</p>
        	<p><b>Instructor is skilled in:</b></p><p>'.get_post_meta($post->ID, 'dojo_instructor_skills', true).'</p>
        	<h2>Contact Details</h2>
        	<p><b>Phone number:</b> '.get_post_meta($post->ID, 'dojo_details_phone', true).'</p>
        	<p><b>Email:</b> '.get_post_meta($post->ID, 'dojo_details_email', true).'</p>
        	<p><b>Website:</b> '.get_post_meta($post->ID, 'dojo_details_website', true).'</p>
        	<p><b>Facebook:</b> '.get_post_meta($post->ID, 'dojo_details_facebook', true).'</p>
        	<p><b>Twitter:</b> '.get_post_meta($post->ID, 'dojo_details_twitter', true).'</p>
        </div>
        ';
    }
    return $content;
}

add_shortcode( 'dojosubmit', 'dojo_frontend_submit' );
function dojo_frontend_submit( $atts ) {
	global $post;
	echo '
	<table cellpadding="20">
		<tr>
			<td width="30%">Full Name:</td>
			<td>
				<input type="text" name="dojo_instructor_fullname" value="' . get_post_meta($post->ID, 'dojo_instructor_fullname', true) . '" class="widefat" />
			</td>
		</tr>
		<tr>
			<td>Age:</td>
			<td>
				<input type="text" name="dojo_instructor_age" value="' . get_post_meta($post->ID, 'dojo_instructor_age', true) . '" class="widefat" />
			</td>
		</tr>
		<tr>
			<td>Started practicing martial arts in year:</td>
			<td>
				<input type="text" name="dojo_instructor_studentsince" value="' . get_post_meta($post->ID, 'dojo_instructor_studentsince', true) . '" class="widefat" />
			</td>
		</tr>
		<tr>
			<td>Learnt martial arts from (teacher name):</td>
			<td>
				<input type="text" name="dojo_instructor_teacher" value="' . get_post_meta($post->ID, 'dojo_instructor_teacher', true) . '" class="widefat" />
			</td>
		</tr>
		<tr>
			<td>Started teaching martial arts in year:</td>
			<td>
				<input type="text" name="dojo_instructor_teachingsince" value="' . get_post_meta($post->ID, 'dojo_instructor_teachingsince', true) . '" class="widefat" />
			</td>
		</tr>
		<tr>
			<td>Awards:</td>
			<td>
				<textarea rows="4" type="text" name="dojo_instructor_awards" class="widefat" />' . get_post_meta($post->ID, 'dojo_instructor_awards', true) . '</textarea>
			</td>
		</tr>
		<tr>
			<td>Skills:</td>
			<td>
				<textarea rows="4" type="text" name="dojo_instructor_skills" class="widefat" />' . get_post_meta($post->ID, 'dojo_instructor_skills', true) . '</textarea>
			</td>
		</tr>
	</table>
	';
}

add_shortcode( 'dojolist', 'dojolist_func' );
function dojolist_func( $atts ){
	$args = array( 'post_type' => 'dojo', 'posts_per_page' => 10 );
	$loop = new WP_Query( $args );
	while ( $loop->have_posts() ) : $loop->the_post();
	echo '<style>
.dojoalleach{
    background-color: #eee;
    padding: 5px;
    margin: 5px;
}
</style>';
	$currentid = get_the_id();
	  echo '<div class="dojoalleach"><h2><a href="'.get_permalink().'">'.get_the_title().'</a></h2>';
	  echo '<p>'.wp_get_post_terms( $currentid, 'city' )[0]->name.', '.wp_get_post_terms( $currentid, 'country' )[0]->name.'</p>';
	  echo '<p>'.get_post_meta($currentid, 'dojo_instructor_fullname', true).' '.get_post_meta(get_the_id(), 'dojo_details_phone', true).'</p>';
	  echo '</div>';
	endwhile;
}
