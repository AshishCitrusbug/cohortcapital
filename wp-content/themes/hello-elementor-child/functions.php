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
	wp_enqueue_style('owl-carousel', get_stylesheet_directory_uri() . '/assets/css/owl.carousel.min.css');
	wp_enqueue_style('owl-theme', get_stylesheet_directory_uri() . '/assets/css/owl.theme.default.css');
	wp_enqueue_style( 'aos-style', 'https://unpkg.com/aos@next/dist/aos.css');
	wp_enqueue_script( 'aos-script', 'https://unpkg.com/aos@2.3.1/dist/aos.js', array('jquery-core') );
	wp_enqueue_script( 'custom', get_stylesheet_directory_uri() . '/assets/js/custom.js', array('jquery-core'), '1.0.0' );
	wp_enqueue_script( 'banner-script', get_stylesheet_directory_uri() . '/assets/js/banner-script.js', array(), '1.0.0' );
	wp_enqueue_script( 'owl-carousel', get_stylesheet_directory_uri() . '/assets/js/owl.carousel.min.js', array(), );

	// Localize script to pass AJAX URL
    wp_localize_script('custom', 'ajax_search_params', array(
        'ajax_url' => admin_url('admin-ajax.php')
    ));

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


// AJAX handler function
function ajax_search() {
    $query_data = isset($_POST['search_data']) ? sanitize_text_field($_POST['search_data']) : '';

    $args = array(
        'post_type' => 'article',
        's' => $query_data,
        'posts_per_page' => 10,
        'post_status' => 'publish',
    );

    $search_query = new WP_Query($args);

    if ($search_query->have_posts()) {
        while ($search_query->have_posts()) {
            $search_query->the_post();
            ?>
            <div class="insights__main--box">
                <div class="insights__main--box-img">
                    <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="">
                </div>
                <div class="insights__main--box-cont">
                    <div class="insights__main--box-cont--title">
                        <h4><?php the_title(); ?></h4>
                        <span>2 min read</span>
                    </div>
                    <div class="insights__main--box-cont--date">
                        <span><?php the_date(); ?>, by <?php the_author(); ?></span>
                    </div>
                    <div class="insights__main--box-cont--content">
                        <p><?php the_excerpt(); ?></p>
                    </div>
                    <a href="<?php the_permalink(); ?>" class="insights__main--box-cont--link">
                        Read Article
                        <img src="/cohortcapital/wp-content/uploads/2024/05/post-arrow.svg" alt="">
                    </a>
                </div>
            </div>
            <?php
        }
    } else {
        echo '<p>No results found</p>';
    }

    wp_reset_postdata();
    die();
}

add_action('wp_ajax_nopriv_ajax_search', 'ajax_search');
add_action('wp_ajax_ajax_search', 'ajax_search');

