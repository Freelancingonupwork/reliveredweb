<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Elementor oEmbed Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class Elementor_package_Widget extends \Elementor\Widget_Base
{
    /**
     * Get widget name.
     *
     * Retrieve oEmbed widget name.
     *
     * @since 1.0.0
     * @access public
     * @return string Widget name.
     */
    public function get_name()
    {
        return 'package';
    }

    /**
     * Get widget title.
     *
     * Retrieve oEmbed widget title.
     *
     * @since 1.0.0
     * @access public
     * @return string Widget title.
     */
    public function get_title()
    {
        return esc_html__('Package Relivery', 'elementor-oembed-widget');
    }

    /**
     * Get widget icon.
     *
     * Retrieve oEmbed widget icon.
     *
     * @since 1.0.0
     * @access public
     * @return string Widget icon.
     */
    public function get_icon()
    {
        return 'eicon-price-list';
    }

    /**
     * Get custom help URL.
     *
     * Retrieve a URL where the user can get more information about the widget.
     *
     * @since 1.0.0
     * @access public
     * @return string Widget help URL.
     */
    public function get_custom_help_url()
    {
        return 'https://developers.elementor.com/docs/widgets/';
    }

    public function get_script_depends()
    {
        return [];
    }

    public function get_style_depends()
    {
        return ['package-css'];
    }

    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the oEmbed widget belongs to.
     *
     * @since 1.0.0
     * @access public
     * @return array Widget categories.
     */
    public function get_categories()
    {
        return ['relivery'];
    }

    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the oEmbed widget belongs to.
     *
     * @since 1.0.0
     * @access public
     * @return array Widget keywords.
     */
    public function get_keywords()
    {
        return ['oembed', 'url', 'link'];
    }

    /**
     * Register oEmbed widget controls.
     *
     * Add input fields to allow the user to customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function register_controls()
    {
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__('Content', 'textdomain'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );


        $this->add_control(
            'title',
            [

                'label' => esc_html__('Title', 'textdomain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__('title', 'textdomain'),
                'default' => esc_html__("Don't Need Packaging", 'textdomain'),
            ]
        );
        $this->add_control(
            'description',
            [
                'label' => esc_html__('Pricing Content', 'textdomain'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'rows' => 10,
                'default' => esc_html__('Select your pickup method by pressing Place Return...', 'textdomain'),
                'placeholder' => esc_html__('Type your description here', 'textdomain'),
            ],
        );
        $this->add_control(
            'currency',
            [

                'label' => esc_html__('Currency', 'textdomain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__('$', 'textdomain'),
                'default' => esc_html__("$", 'textdomain'),
            ],
        );
        $this->add_control(
            'price',
            [

                'label' => esc_html__('Price', 'textdomain'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'placeholder' => esc_html__('5', 'textdomain'),
                'default' => esc_html__("5", 'textdomain'),
            ],
        );
        $this->add_control(
            'returntext',
            [

                'label' => esc_html__('Return', 'textdomain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__('Return', 'textdomain'),
                'default' => esc_html__("Return", 'textdomain'),
            ]
        );
        $this->add_control(
            'buttontext',
            [

                'label' => esc_html__('Purchase Button Text', 'textdomain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__('Purchase', 'textdomain'),
                'default' => esc_html__("Purchase", 'textdomain'),
            ]
        );


        $this->add_control(
            'features',
            [
                'label' => esc_html__('Features', 'textdomain'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => [
                    [
                        'name' => 'feature',
                        'label' => esc_html__('Feature', 'textdomain'),
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'placeholder' => esc_html__('Free Label Printing', 'textdomain'),
                        'default' => esc_html__('Free Label Printing', 'textdomain'),
                    ],

                ],
                'title_field' => '{{{ feature }}}',
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render oEmbed widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render()
    {
        $settings = $this->get_settings_for_display();

        ob_start();
        ?>
        <div class="pricing-item">
            <h5 class="pricing-title"><?php  echo $settings['title']; ?></h5>
            <p class="pricing-content"><?php  echo $settings['description']; ?></p>
            <div class="pricing-price"><span class="price-symbol"><?php  echo $settings['currency']; ?></span><span><?php  echo $settings['price']; ?>/</span><?php  echo $settings['returntext']; ?></div>
            <div class="pricing-list">
                <ul>
                    <?php foreach ($settings['features'] as $key => $feature) {
                        ?>
                       <li><i class="fas fa-check"></i> <?php echo $feature['feature'];  ?> </li>
                    <?php
                    }  ?>
                 
    
                </ul>
            </div>
            <div class="pricing-btn">
                <a class="btn" href="#"><?php echo $settings['buttontext'];    ?></a>
            </div>
        </div>
        <?php
        $output = ob_get_clean();
        echo $output;
    }
}
