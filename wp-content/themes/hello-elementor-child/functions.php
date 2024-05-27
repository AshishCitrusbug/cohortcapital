<?php
/**
 * Theme functions and definitions.
 *
 * For additional information on potential customization options,
 * read the developers' documentation:
 *
 * https://developers.elementor.com/docs/hello-elementor-theme/
 *
 * @package HelloElementorChild
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'HELLO_ELEMENTOR_CHILD_VERSION', '2.0.0' );

/**
 * Load child theme scripts & styles.
 *
 * @return void
 */
function hello_elementor_child_scripts_styles() {

	wp_enqueue_style(
		'hello-elementor-child-style',
		get_stylesheet_directory_uri() . '/style.css',
		[
			'hello-elementor-theme-style',
		],
		HELLO_ELEMENTOR_CHILD_VERSION
	);
	wp_enqueue_style('home-style', get_stylesheet_directory_uri() . '/assets/css/home-banner.css');
	wp_enqueue_style( 'aos-style', 'https://unpkg.com/aos@next/dist/aos.css');
	wp_enqueue_script( 'aos-script', 'https://unpkg.com/aos@2.3.1/dist/aos.js', array('jquery-core') );
	wp_enqueue_script( 'custom', get_stylesheet_directory_uri() . '/assets/js/custom.js', array('jquery-core'), '1.0.0' );
	wp_enqueue_script( 'banner-script', get_stylesheet_directory_uri() . '/assets/js/banner-script.js', array(), '1.0.0' );

}
add_action( 'wp_enqueue_scripts', 'hello_elementor_child_scripts_styles', 20 );

add_filter('use_block_editor_for_post', '__return_false');

include get_stylesheet_directory() . '/inc/custom-shortcode.php';

/* ==================================  Add A custm dob select must be 18 years old  =======================*/

add_filter('wpcf7_validate_date*', 'custom_dob_validation', 20, 2);
function custom_dob_validation($result, $tag) {
    $name = $tag->name;

    if ($name === 'borrower-date') {
        $dob = $_POST[$name];
        $dobDate = new DateTime($dob);
        $today = new DateTime();
        $age = $today->diff($dobDate)->y;

        if ($age < 18) {
            $result->invalidate($tag, 'You must be at least 18 years old.');
        }
    }

    return $result;
}
