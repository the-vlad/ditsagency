<?php
/**
 * underscore functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package underscore
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function underscore_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on underscore, use a find and replace
		* to change 'underscore' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'underscore', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'underscore' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'underscore_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'underscore_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function underscore_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'underscore_content_width', 640 );
}
add_action( 'after_setup_theme', 'underscore_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function underscore_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'underscore' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'underscore' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'underscore_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function underscore_scripts() {
	wp_enqueue_style( 'underscore-style', get_stylesheet_uri(), array(), _S_VERSION );
  wp_enqueue_style( 'underscore-additional-style', get_template_directory_uri() . '/additional-style.css', array(), _S_VERSION );
	wp_style_add_data( 'underscore-style', 'rtl', 'replace' );

	wp_enqueue_script( 'underscore-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'underscore_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}



if (!defined('ABSPATH')) {
    die;
}

require_once __DIR__ . '/vendor/autoload.php';

use StoutLogic\AcfBuilder\FieldsBuilder;


require_once get_template_directory() . '/cpt/DA_Location.php';
require_once get_template_directory() . '/cpt/DA_Template.php';
// $template_fields = new FieldsBuilder('template_fields');
// $template_fields
// 	->addImage('hero_image', [
// 		'label' => 'Background Image',
// 		'instructions' => '',
// 		'required' => 0,
// 		'return_format' => 'url',
// 	])

// 	->addText('hero_title',[
// 		'label'=>__('Extra HTML or JS Code for Head','iqs')
// 	])

// 	->addTextarea('hero_description',[
// 		'label'=>__('Extra Code for Footer','iqs')
// 	]);

// $template_fields
// 	->setLocation('page_template','==','page-filter.php');
// 	acf_add_local_field_group($template_fields->build());






final class DA_Init
{
    private static function init(): array
    {
       return [
           DA_Location::class,
		   DA_Template::class,
       ];
    }

    public static function register() : void
    {
        foreach (self::init() as $class)
        {
            new $class();
        }
    }
}


DA_Init::register();

// Enqueue the necessary scripts
function enqueue_filter_scripts() {
    wp_enqueue_script('ajax-filter', get_template_directory_uri() . '/js/ajax-filter.js', array('jquery'), null, true);
    wp_localize_script('ajax-filter', 'ajax_filter_params', array(
        'ajax_url' => admin_url('admin-ajax.php'),
		'default_term_id' => get_default_term_id() // Add this line
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_filter_scripts');



function get_default_term_id() {
    $terms = get_terms(array(
        'taxonomy' => 'county',
        'orderby' => 'name',
        'order' => 'ASC',
        'hide_empty' => false,
        'number' => 1
    ));
    if (!empty($terms) && !is_wp_error($terms)) {
        return $terms[0]->term_id;
    }
    return 0; // Fallback if no terms found
}

// AJAX handler to filter posts with pagination
function ajax_filter_posts() {
    // Get the selected term ID and current page
    $term_id = isset($_POST['term_id']) ? intval($_POST['term_id']) : 0;
    $paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;

    // Query to get posts based on the selected term with pagination
    $args = array(
        'post_type' => 'location',
        'tax_query' => array(
            array(
                'taxonomy' => 'county',
                'field'    => 'term_id',
                'terms'    => $term_id,
            ),
        ),
		'orderby' => 'date',
		'order' => 'ASC',
        'posts_per_page' => 3,
        'paged' => $paged,
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
			echo '<div class="location-box">';
            echo '<h2>' . get_the_title() . '</h2>';
			$title = get_field('location_title');
			$image = get_field('location_featured_image');
			$image_cover = get_field('location_cover_image');
			$short_description = get_field('location_short_description');
			$full_description= get_field('location_full_description');
			echo '<img class="img-featured" src="'. $image .'"/>';
			echo '<div class="short-desc">' . $short_description . '</div>';
			echo '<img class="img-cover" src="'. $image_cover .'"/>';
			echo '<div class="full-desc">' . $full_description . '</div>';
			echo '</div>';

			if( have_rows('contact') ): ?>
				<div class="contact">
				<?php while( have_rows('contact') ): the_row(); 
					$name = get_sub_field('name');
					$address = get_sub_field('address');
					$phone = get_sub_field('phone');
					$image = get_sub_field('image');
		
					?>
					<h3>Contact Info</h3>
					<div class="contact-box">
				
						<div class="contact-box-info">
							<?php if($phone) { ?> 
							<img class="ico" src="<?php echo get_template_directory_uri() . '/img/contact.png'?>"/>
							<?php } ?>
							<h5><?php echo $name; ?></h5>
							<p><?php echo $address; ?></p>
							<a href="tel:<?php echo $phone;?>"><?php echo $phone; ?></a>
						</div>
					</div>
				<?php endwhile; ?>
			</div>
			<?php endif; 
        endwhile;

        // Pagination
        $total_pages = $query->max_num_pages;
        if ($total_pages > 1) {
            echo '<div class="pagination">';
            for ($i = 1; $i <= $total_pages; $i++) {
                echo '<a href="#" class="page-link" data-page="' . $i . '">' . $i . '</a>';
            }
            echo '</div>';
        }

        wp_reset_postdata();
    else :
        echo '<p>No locations found.</p>';
    endif;

    wp_die();
}
add_action('wp_ajax_filter_posts', 'ajax_filter_posts');
add_action('wp_ajax_nopriv_filter_posts', 'ajax_filter_posts');

function my_theme_enqueue_styles() {
    // Enqueue the pagination CSS file
    wp_enqueue_style('pagination-css', get_template_directory_uri() . '/css/pagination.css');
}

add_action('wp_enqueue_scripts', 'my_theme_enqueue_styles');

