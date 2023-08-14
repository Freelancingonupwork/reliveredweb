<?php
/*
 * This is the child theme for Hello Elementor theme, generated with Generate Child Theme plugin by catchthemes.
 *
 * (Please see https://developer.wordpress.org/themes/advanced-topics/child-themes/#how-to-create-a-child-theme)
 */

define('BACKEND_URL', 'https://api.relivery.io/');
define('TOKEN', 'reliveredapp1969');
define('AUTH','Basic YjVjOTM3ZWVlZGFiYmY5ZWE1MDFhY2VkZjgwY2E0MWE6ZjM1MmUzYWQ3MDk4OGJiZGM1NDdlYzQzNzcxM2NmMTg=');
add_action( 'wp_enqueue_scripts', 'hello_elementor_child_enqueue_styles' );
function hello_elementor_child_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array('parent-style')
    );
    wp_enqueue_style( 'child-bootstrap',
        get_stylesheet_directory_uri() . '/assets/css/bootstrap.min.css',
    );
    wp_enqueue_script( 'child-bootstrap',
        get_stylesheet_directory_uri() . '/assets/js/bootstrap.min.js',
        array('jquery-core')
    );
  
    wp_register_script( 'google-maps', 'https://maps.googleapis.com/maps/api/js?key='.get_elementor_google_maps_api_key().'&callback=initMap', array(), null, true );
    wp_enqueue_script( 'google-maps' );
    // Enqueue the script
    wp_enqueue_script( 'child-custom',
    get_stylesheet_directory_uri() . '/assets/js/custom-theme.js',
    array('child-bootstrap')
    );
    wp_localize_script( 'child-custom', 'relivery', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}

function get_elementor_google_maps_api_key() {
    // Retrieve the Elementor Google Maps Embed API key
    $api_key = get_option( 'elementor_google_maps_api_key', '' );
    
    if ( empty( $api_key ) ) {
        return null;
    }
    
    return $api_key;
}

require_once( __DIR__ . '/elementor/widgets.php' );

add_action('wp_footer', 'hello_elementor_child_footer');
function hello_elementor_child_footer() {
    ob_start();
    ?>
    <div class="modal fade" id="contactformModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="contactformLabel">Contact Us</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php
                       echo do_shortcode('[contact-form-7 id="1451" title="Contact us"]');
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php
    echo  ob_get_clean();
}
add_shortcode('relivery_lockers', 'relivery_lockers');
function relivery_lockers() {
    ob_start();
 ?>
    <div id="map" style="width:100%"></div>     
   <?php
    echo  ob_get_clean();
}

add_action( 'wp_ajax_available_lockers', 'get_available_lockers' );
add_action( 'wp_ajax_nopriv_available_lockers', 'get_available_lockers' );

function get_available_lockers() {
    $api_url = BACKEND_URL.'api/available-lockers';
    
    $response = wp_remote_post( $api_url, array(
        'headers' => array(
            'token' => TOKEN,
            'Authorization' => AUTH,
        )
    ) );
    
    if ( is_wp_error( $response ) ) {
        $error_message = $response->get_error_message();
        echo "Something went wrong: $error_message";
    } else {
        $body = wp_remote_retrieve_body( $response );
        echo $body;
    }
    
    wp_die();
}

add_shortcode('relivery_plans', 'relivery_plans');
function relivery_plans()
{
    $api_url = BACKEND_URL.'api/get-plans';
    $settings_api_url = BACKEND_URL.'api/get-setting';

    // Set the headers
    $headers = array(
        'token' => TOKEN,
        // 'loginkey' => '62d6cd11894dc6d2edabfce9d60df292e9128c2a',
        'Authorization' => AUTH,
        'Cookie' => 'ci_session=0pdv7ij9s65vmbsa9t1fu27k4aq3hb7j',
    );

    // Set the form data
    $data = array(
        'notification_status' => 'YES',
    );

    // Make the API request using wp_remote_post
    $response = wp_remote_post( $api_url, array(
        'headers' => $headers,
        'body' => $data,
    ));

    $single_package_price_response = wp_remote_post( $settings_api_url, array(
        'headers' => $headers,
        'body' => ['setting_key' => 'single_package_price']
    ));

    $additional_package_price_response = wp_remote_post( $settings_api_url, array(
        'headers' => $headers,
        'body' => ['setting_key' => 'additional_package_price'],
    ));

    // Check if there was an error in the API request
    if ( is_wp_error( $response ) ) {
        $error_message = $response->get_error_message();
        echo "Something went wrong: $error_message";
    } else {
        // API request was successful, so output the response
        $api_response = json_decode( wp_remote_retrieve_body( $response ) );
        $plans = $api_response->data;

        $single_package_price = !is_wp_error( $single_package_price_response ) ? json_decode( wp_remote_retrieve_body( $single_package_price_response ) )->data : 4;
        $additional_package_price = !is_wp_error( $additional_package_price_response ) ? json_decode( wp_remote_retrieve_body( $additional_package_price_response ) )->data : 1.5;

        if ( ! empty( $plans ) ):
            ?> <div class="row d-flex justify-content-center"> <?php
            foreach ( $plans as $plan ):
                if($plan->id == "prod_NsZa4EGe0KK1qr"){
                    $plan->description = "+$".$additional_package_price." for each additional package";
                    $plan->price = $single_package_price;
                }
                ?>
                <div class="pricing col-xl-4 col-lg-5 col-md-6 col-sm-12">
                    <div class="pricing-item">
                        <h5 class="pricing-title"><?php  echo $plan->name; ?></h5>
                        <?php if ( strtolower($plan->name) != 'membership' ): ?>
                            <p class="pricing-content"><?php  echo esc_html($plan->description); ?></p>
                        <?php endif; ?>
                        <div class="pricing-price">
                            <span class="price-symbol">$</span><span><?php echo (double)$plan->price; ?>/</span><?php echo $plan->metadata->type; ?>
                        </div>
                        <div class="pricing-list">
                            <ul>
                                <?php foreach ( explode( ', ', $plan->metadata->features ) as  $feature ): ?>
                                    <li><i class="fas fa-check"></i> <?php echo $feature; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <div class="pricing-btn">
                            <a class="btn" href="#">Purchase</a>
                        </div>
                    </div>
                </div>
                <?php
            endforeach;
            ?> </div> <?php
        else:
            ?>
                <div class="row d-flex justify-content-center">
                    <div class="pricing col-xl-4 col-lg-5 col-md-6 col-sm-12">
                        <h2>No plans available</h2>
                    </div>
                </div>
            <?php
        endif;
    }
}

/**
 * Redirect to https
 */
add_action('template_redirect', 'redirect_core', 50);
add_action('init', 'redirect_core', 50);
add_action('wp_loaded', 'redirect_core', 50);
function redirect_core(){
  if (!is_ssl()) {
    wp_redirect('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], 301);
    exit();
  }
}