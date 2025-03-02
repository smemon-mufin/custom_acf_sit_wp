<?php
// disables WP scaled images
add_filter( 'big_image_size_threshold', '__return_false' );

// prevents WP default images from being generated
add_filter('intermediate_image_sizes_advanced', 'pdm_remove_default_image_sizes');
function pdm_remove_default_image_sizes( $sizes) {
	unset( $sizes['thumbnail']);
	unset( $sizes['small']);
	unset( $sizes['medium']);
	unset( $sizes['medium_large']);
	unset( $sizes['large']);
	return $sizes;
}

// removes scaled images from being generated
remove_image_size( '1536x1536' );
remove_image_size( '2048x2048' );

//add more image sizes for bigger screens
add_image_size( 'xxs', 128);
add_image_size( 'xs', 160);
add_image_size( 'sm', 320);
add_image_size( 'md', 640);
add_image_size( 'lg', 960);
add_image_size( 'xl', 1440);
add_image_size( 'xxl', 2048);

// adds custom image sizes to dropdowns
add_filter('image_size_names_choose', 'pdm_image_size_names');
function pdm_image_size_names( $sizes ) {
	$sizes['xxs'] = __( '2X Small' );
	$sizes['xs'] = __( 'X Small' );
	$sizes['sm'] = __( 'Small' );
	$sizes['md'] = __( 'Medium' );
	$sizes['lg'] = __( 'Large' );
	$sizes['xl'] = __( 'X Large' );
	$sizes['xxl'] = __( '2X Large' );
	return $sizes;
}

//Pass in the image id, max width in pixels if wanted or else pass false, and alt tag if wanted.
function getIMG($id, $size = "lg", $return_src = false, $img_attr = array()) {
	$default_attr = array('loading' => 'lazy');
	$attr = array_merge($default_attr, $img_attr);
	// $img_src = !empty(wp_get_attachment_image_src($id, $size)) ? wp_get_attachment_image_src($id, $size)[0] : '';
	list($img_src) = wp_get_attachment_image_src($id, $size);

	$img_srcset = array();

	$img_classes = array();
	if(isset($attr['class'])) $img_classes[] = $attr['class'];

	if(isset($attr['lazy']) && $attr['lazy'] == false){
		$attr['loading'] = false;
		unset($attr['lazy']);
	}
    if (empty($attr['alt'])) {
        $post_title = get_the_title();
        $attr['alt'] = $post_title;
    }

	$image_sizes = wp_get_additional_image_sizes();
	$size_index = array_search($size ,array_keys($image_sizes))+1;
	$srcset_sizes = array_splice($image_sizes, 0, $size_index);

	foreach($srcset_sizes as $ss_size => $val) {
		$meta = wp_get_attachment_image_src( $id, $ss_size );
		if(!empty($meta[1])) $img_srcset[] = $meta[0] . ' ' . $meta[1] .'w';
	}

	$str_srcset = join(', ', $img_srcset);
	$attr['srcset'] = $str_srcset;

	if($return_src == true){
		return buildAttr(array(
			'data-bg' => $img_src
		));
	} else {
		if($attr['loading'] == 'lazy'){
			$attr['src'] = '';
			$attr['srcset'] = ' '; // space needs to be here in order to be empty on tag, not sure why
			$attr['data-src'] = $img_src;
			$attr['data-srcset'] = $str_srcset;
			$attr['loading'] = false;
			$img_classes[] = 'lazy';
		}

		if(!empty($img_classes)) $attr['class'] = implode(' ', $img_classes);

		return wp_get_attachment_image( $id, $size, false, $attr );
	}
}