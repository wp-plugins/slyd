<?php
/*
Plugin Name: Slyd
Plugin URI: http://trezy.com/portfolio/slyd
Description: Slyd is an animated slider to display your latest blog posts.
Version: 1.3.5
Author: Trezy
Author URI: http://trezy.com
License: GPL3

	--------------------------------------------------------------------
	------------------ GNU General Public License v3 -------------------
	--------------------------------------------------------------------
	Slyd: A Wordpress plugin.
	Copyright (C) 2012  Trezy.com
	
	This program is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.
	
	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.
	
	See <http://www.gnu.org/licenses/gpl.html> for the full license.
*/
	// Add Slyd Image to Edit Post page
	function slyd_add_edit_form_multipart_encoding() {
		echo ' enctype="multipart/form-data"';
	}
	
	function slyd_render_image_attachment_box( $post ) {
		// Use nonce for verification
    	echo '<input type="hidden" name="slyd_image-upload" value="', wp_create_nonce(basename(__FILE__)), '" />';
		
		// See if there's an existing image. (We're associating images with posts by saving the image's 'attachment id' as a post meta value)
		// Incidentally, this is also how you'd find any uploaded files for display on the frontend.
		$existing_image_id = get_post_meta( $post->ID, '_slyd_attached_image', true );
		if( is_numeric( $existing_image_id ) ) {
			$arr_existing_image = wp_get_attachment_image_src( $existing_image_id, 'large' );
			$existing_image_url = $arr_existing_image[0];
			
			echo
			  '<table><tbody><tr><td>'
			. '	<div>'
			. "		<img style='max-height: 150px;' src='{$existing_image_url}' />"
			. '	</div>'
			. '</td><td valign="top">';
		}
		echo 'Upload an image:<br /><input type="file" name="slyd_image" id="slyd_image" />';
		echo '</td></tr></tbody></table>';
		
		// See if there's a status message to display (we're using this to show errors during the upload process, though we should probably be using the WP_error class)
		$status_message = get_post_meta( $post->ID, '_slyd_attached_image_upload_feedback', true );
		
		// Show an error message if there is one
		if( $status_message ) {
			echo "<div class='upload_status_message'>{$status_message}</div>";
		}
		
		// Put in a hidden flag. This helps differentiate between manual saves and auto-saves (in auto-saves, the file wouldn't be passed).
		echo '<input type="hidden" name="slyd_manual_save_flag" value="true" />';
	}
	
	function slyd_setup_meta_boxes() {
		// Add the box to a particular custom content type page
		add_meta_box(
			'slyd_image_box',
			'Slyd Image',
			'slyd_render_image_attachment_box',
			'post',
			'normal',
			'high'
		);
	}
	
	function slyd_update_post( $post_id, $post ) {
		// Verify nonce
		if ( !wp_verify_nonce( $_POST['slyd_image-upload'], basename(__FILE__) ) ) {
			return $post_id;
		}
		
		// Get the post type. Since this function will run for ALL post saves (no matter what post type), we need to know this.
		// It's also important to note that the save_post action can run multiple times on every post save, so you need to check
		// and make sure the post type in the passed object isn't "revision"
		$post_type = $post->post_type;
	
		// Make sure our flag is in there, otherwise it's an autosave and we should bail.
		if( $post_id && isset( $_POST['slyd_manual_save_flag'] ) ) {
			// Logic to handle specific post types
			switch( $post_type ) {
				// If this is a post. You can change this case to reflect your custom post slug
				case 'post':
					// HANDLE THE FILE UPLOAD
					// If the upload field has a file in it
					if ( isset( $_FILES['slyd_image'] ) && ( $_FILES['slyd_image']['size'] > 0 ) ) {
	
						// Get the type of the uploaded file. This is returned as "type/extension"
						$arr_file_type = wp_check_filetype( basename( $_FILES['slyd_image']['name'] ) );
						$uploaded_file_type = $arr_file_type['type'];
	
						// Set an array containing a list of acceptable formats
						$allowed_file_types = array( 'image/jpg','image/jpeg','image/gif','image/png' );
	
						// If the uploaded file is the right format
						if ( in_array( $uploaded_file_type, $allowed_file_types ) ) {
	
							// Options array for the wp_handle_upload function. 'test_upload' => false
							$upload_overrides = array( 'test_form' => false ); 
	
							// Handle the upload using WP's wp_handle_upload function. Takes the posted file and an options array
							$uploaded_file = wp_handle_upload( $_FILES['slyd_image'], $upload_overrides );
	
							// If the wp_handle_upload call returned a local path for the image
							if ( isset( $uploaded_file['file'] ) ) {
	
								// The wp_insert_attachment function needs the literal system path, which was passed back from wp_handle_upload
								$file_name_and_location = $uploaded_file['file'];
	
								// Generate a title for the image that'll be used in the media library
								$file_title_for_media_library = 'Slyd Image';
	
								// Set up options array to add this file as an attachment
								$attachment = array(
									'post_mime_type' => $uploaded_file_type,
									'post_title' => 'Uploaded image ' . addslashes( $file_title_for_media_library ),
									'post_content' => '',
									'post_status' => 'inherit'
								);
	
								// Run the wp_insert_attachment function. This adds the file to the media library and
								// generates the thumbnails. If you wanted to attach this image to a post, you could pass
								// the post id as a third param and it'd magically happen.
								$attach_id = wp_insert_attachment( $attachment, $file_name_and_location, $post_id );
								require_once( ABSPATH . "wp-admin" . '/includes/image.php' );
								$attach_data = wp_generate_attachment_metadata( $attach_id, $file_name_and_location );
								wp_update_attachment_metadata( $attach_id,  $attach_data );
	
								// Before we update the post meta, trash any previously uploaded image for this post.
								// You might not want this behavior, depending on how you're using the uploaded images.
								$existing_uploaded_image = ( int ) get_post_meta( $post_id, '_slyd_attached_image', true );
								if ( is_numeric( $existing_uploaded_image ) ) {
									wp_delete_attachment( $existing_uploaded_image );
								}
	
								// Now, update the post meta to associate the new image with the post
								update_post_meta( $post_id, '_slyd_attached_image', $attach_id );
								
								// Set the feedback flag to false, since the upload was successful
								$upload_feedback = false;
							} else {
								// wp_handle_upload returned some kind of error. the return does contain error details, so you can use it here if you want.
								$upload_feedback = 'There was a problem with your upload.';
								update_post_meta( $post_id, '_slyd_attached_image', $attach_id );
							}
						} else {
							// wrong file type
							$upload_feedback = 'Please upload only image files (jpg, gif or png).';
							update_post_meta( $post_id, '_slyd_attached_image', $attach_id );
						}
					} else {
						// No file was passed
						$upload_feedback = false;
					}
					// Update the post meta with any feedback
					update_post_meta( $post_id, '_slyd_attached_image_upload_feedback', $upload_feedback );
					break;
				default:
			}
			return;
		}
		return;
	}
	
	// Convert $category from a name to an ID
	function get_category_id( $cat_name ) {
		$term = get_term_by( 'name', $cat_name, 'category' );
		return $term->term_id;
	}
	
	function slyd( $category, $slydcount, $nav, $height, $width, $outline, $show_titles, $show_captions, $caption_length, $autoadvance, $speed, $use_featured, $no_links, $custom_loading_image, $nav_images, $nav_prev, $nav_next ) {
		// Add the stylesheet and javascript to the queue; javascript will only load if jQuery is loaded
		wp_enqueue_style( 'slyd_css', plugins_url( 'slyd.css', __FILE__ ) );
		wp_enqueue_script( 'slyd_js', plugins_url( 'slyd.js', __FILE__ ), array( 'jquery' ) );
		wp_enqueue_script( 'dotimeout', plugins_url( 'jquery.dotimeout.js', __FILE__ ), array( 'jquery' ) );

		global $post;
		
		if ( $category == 'all' || $category == '' ) {
			$args = array(
				'numberposts'		=>	$slydcount
			);
		} else {
			$args = array(
				'category'			=>	get_category_id($category),
				'numberposts'		=>	$slydcount
			);
		}
		
		$slydposts				=	get_posts( $args );
		$tmp_post				=	$post;
		$slyd_height			=	'';
		$slyd_nav				=	'';
		$slyd_outline			=	'';
		$slyd_titles			=	'';
		$slyd_captions			=	'';
		$ret					=	'';
		$i						=	0;
		
		
		if ( $height != 'auto' ) { $slyd_height = $height; }
		if ( $nav ) { $nav_js = "var slyd_nav = '{$nav}'; "; }
		if ( $outline != 'none' ) { $slyd_outline = "outline: 1px solid {$outline};"; }
		if ( $show_titles ) { $slyd_titles = "var slyd_titles = {$show_titles}; "; }
		if ( $show_captions ) { $slyd_captions = "var slyd_captions = {$show_captions}; "; }
		if ( $autoadvance ) { $slyd_autoadvance_js = "var slyd_autoadvance = true; "; }
		if ( $speed ) { $slyd_speed_js = "var slyd_speed = {$speed}; "; }
		
		if ( !$nav_images || !$nav_prev || !$nav_next ) {
			$slyd_previous		=	plugins_url( 'previous.png', __FILE__ );
			$slyd_next			=	plugins_url( 'next.png', __FILE__ );
		} else if ( $nav_images ) {
			$slyd_previous		=	$nav_images + 'previous.png';
			$slyd_next			=	$nav_images + 'next.png';
		} else {
			$slyd_previous		=	$nav_prev;
			$slyd_next			=	$nav_next;
		}
		
		if ( !$custom_loading_image ) {
			$loading_image		=	plugins_url( 'loading.gif', __FILE__ );
		} else {
			$loading_image		=	$custom_loading_image;
		}
		
		foreach ( $slydposts as $post ) : setup_postdata($post);
			// Get the post's title
			$post_title			=	get_the_title();
			
			// Get the post's content
			if ( $show_captions ) {
				$post_content	=	'<div class="slyd_caption">' . substr( apply_filters( 'the_content', get_the_content('', '', '') ), 0, $caption_length ) . '</div>';
			} else {
				$post_content	=	'';
			}
			
			// Get the post's permalink
			$post_permalink		=	get_permalink();
			
			// Get the post's Slyd image src
			$post_slyd_image	=	get_post_meta( $post->ID, '_slyd_attached_image', true );
			
			// Get the post's featured image src
			$post_slyd_src		= 	wp_get_attachment_image_src( $post_slyd_image, 'full' );
			$post_featured_src	=	wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
			$post_thumb			=	'';
			$slyd_margin		=	'';
			$slyd_links_open	=	'';
			$slyd_links_close	=	'';
			$slyd_no_img		=	'';
			
			if ( $i > 0 ) {
				$margin_left = " style='margin-left: {$i}00%;'";
			} else {
				$margin_left = ' style="margin-left: 0%;"';
			}
			
			switch ( $use_featured ) {
				case 'noslyd':
					if ( $post_slyd_src[0] ) {
						$post_thumb = "<img src='{$post_slyd_src[0]}' />";
						if ( $height == 'auto' ) {
							$post_thumb_size = getimagesize( $post_slyd_src[0] );
							if ( $post_thumb_size[1] > $slyd_height ) {
								$slyd_height = $post_thumb_size[1];
							}
						}
					} else if ( $post_featured_src[0] ) {
						$post_thumb = "<img src='{$post_featured_src[0]}' />";
						if ( $height == 'auto' ) {
							$post_thumb_size = getimagesize( $post_featured_src[0] );
							if ( $post_thumb_size[1] > $slyd_height ) {
								$slyd_height = $post_thumb_size[1];
							}
						}
					} else {
						$args['numberposts']++;
						$i--;
						$slyd_no_img = ' slyd_hide';
					}
					break;
				case 'always':
					if ( $post_featured_src[0] ) {
						$post_thumb = "<img src='{$post_featured_src[0]}' />";
						if ( $height == 'auto' ) {
							$post_thumb_size = getimagesize( $post_featured_src[0] );
							if ( $post_thumb_size[1] > $slyd_height ) {
								$slyd_height = $post_thumb_size[1];
							}
						}
					} else if ( $post_slyd_src[0] ) {
						$post_thumb = "<img src='{$post_slyd_src[0]}' />";
						if ( $height == 'auto' ) {
							$post_thumb_size = getimagesize( $post_slyd_src[0] );
							if ( $post_thumb_size[1] > $slyd_height ) {
								$slyd_height = $post_thumb_size[1];
							}
						}
					} else {
						$args['numberposts']++;
						$i--;
						$slyd_no_img = ' slyd_hide';
					}
					break;
				case 'never':
					if ( $post_slyd_src[0] ) {
						$post_thumb = "<img src='{$post_slyd_src[0]}' />";
						if ( $height == 'auto' ) {
							$post_thumb_size = getimagesize( $post_slyd_src[0] );
							if ( $post_thumb_size[1] > $slyd_height ) {
								$slyd_height = $post_thumb_size[1];
							}
						}
					} else {
						$args['numberposts']++;
						$i--;
						$slyd_no_img = ' slyd_hide';
					}
					break;
			}
			
			if ( !$no_links ) {
				$slyd_links_open	=	"<a href='{$post_permalink}'>";
				$slyd_links_close	=	'</a>';
			} else {
				$slyd_links_open	=	'';
				$slyd_links_close	=	'';
			}
			
			$ret .= 
				  "	<div class='a_slyd{$slyd_no_img}'{$margin_left}>"
				. $slyd_links_open
				. '		<div class="slyd_content">'
				. "			{$post_thumb}"
				. "			<h2 class='slyd_title'>{$post_title}</h2>"
				. "			{$post_content}..."
				. '		</div>'
				. $slyd_links_close
				. '	</div>';
			$i++;
			wp_reset_query();
		endforeach;
		
		$post			=	$tmp_post;	// Empty $post once Slyd is done with it
		$slyd_js		=	"<script type='text/javascript'> var slyd_posts = {$i}; var slyd_height = {$slyd_height}; {$nav_js}{$slyd_titles}{$slyd_captions}{$slyd_speed_js}{$slyd_autoadvance_js}</script>";
			
		return 
			  "{$slyd_js}"
			. "<div class='slyd' style='height: {$slyd_height}px; width: {$width}; {$slyd_outline}'>"
			. "	<div class='slyd_wrapper' style='height: {$slyd_height}px;'>"
			. "		{$ret}"
			. '	</div>'
			. "	<div class='slyd_nav' style='height: {$slyd_height}px;'>"
			. "		<a class='slyd_previous' style='background: url({$slyd_previous}) center no-repeat; display:none;'></a>"
			. "		<a class='slyd_next' style='background: url({$slyd_next}) center no-repeat;'></a>"
			. '	</div>'
			. '</div>';
	}
	
	// Create the shortcode
	function slyd_shortcode( $atts ) {		
		// Retrieve attributes set by the shortcode and set defaults for unregistered attributes. 
		extract( shortcode_atts( array(
			'category'				=>	'all',
			'slydcount'				=>	5,
			'nav'					=>	'hover',
			'height'				=>	'auto',
			'width'					=>	'100%',
			'outline'				=>	'#000',
			'show_titles'			=>	true,
			'show_captions'			=>	true,
			'caption_length'		=>	150,
			'autoadvance'			=>	true,
			'speed'					=>	4000,
			'use_featured'			=>	'never',
			'no_links'				=>	false,
			'custom_loading_image'	=>	false,
			'nav_images'			=>	false,
			'nav_prev'				=>	false,
			'nav_next'				=>	false
		), $atts ) );
		
		if ( !is_admin() ) {
			return slyd( $category, $slydcount, $nav, $height, $width, $outline, $show_titles, $show_captions, $caption_length, $autoadvance, $speed, $use_featured, $no_links, $custom_loading_image, $nav_images, $nav_prev, $nav_next );
		}
	}
		
	add_shortcode( 'slyd', 'slyd_shortcode' );
	add_action( 'post_edit_form_tag', 'slyd_add_edit_form_multipart_encoding' );
	add_action( 'admin_init', 'slyd_setup_meta_boxes' );
	add_action( 'save_post', 'slyd_update_post', 1, 2 );

?>