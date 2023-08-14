<?php
/**
 * Register oEmbed Widget.
 *
 * Include widget file and register widget class.
 *
 * @since 1.0.0
 * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
 * @return void
 */
function register_relivery_widget( $widgets_manager ) {

	require_once( __DIR__ . '/widgets/testimonial-widget.php' );
	require_once( __DIR__ . '/widgets//package-widget.php' );

	$widgets_manager->register( new \Elementor_testimonial_Widget() );
	$widgets_manager->register( new \Elementor_package_Widget() );

}
add_action( 'elementor/widgets/register', 'register_relivery_widget' );

function add_elementor_widget_categories( $elements_manager ) {

	$elements_manager->add_category(
		'relivery',
		[
			'title' => esc_html__( 'Relivery', 'hello-elementor' ),
			'icon' => 'fa fa-plug',
		]
	);

}
add_action( 'elementor/elements/categories_registered', 'add_elementor_widget_categories' );
/**
 * Register scripts and styles for Elementor test widgets.
 */
function elementor_testimonial_widgets_dependencies() {

	/* Scripts */
    wp_register_script( 'jquery', get_stylesheet_directory_uri().'/assets/js/jquery.min.js' );
	wp_register_script( 'owl-corusal', get_stylesheet_directory_uri().'/assets/js/owl.carousel.min.js' );
	wp_register_script( 'custom', get_stylesheet_directory_uri().'/assets/js/custom.js',['jquery'] );
    /* Styles */
	wp_register_style( 'owl-corusal-css', get_stylesheet_directory_uri().'/assets/css/owl.carousel.min.css' );
	wp_register_style( 'testimonial-css', get_stylesheet_directory_uri().'/assets/css/testimonial.css' );
	wp_register_style( 'package-css', get_stylesheet_directory_uri().'/assets/css/package.css' );
}
add_action( 'wp_enqueue_scripts', 'elementor_testimonial_widgets_dependencies' );

