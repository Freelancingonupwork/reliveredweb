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
class Elementor_testimonial_Widget extends \Elementor\Widget_Base
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
		return 'testimonial';
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
		return esc_html__('Testimonial Relivery', 'elementor-oembed-widget');
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
		return 'eicon-testimonial';
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
		return ['jquery', 'owl-corusal', 'custom'];
	}

	public function get_style_depends()
	{
		return ['owl-corusal-css','testimonial-css'];
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
			'testimonials',
			[
				'label' => esc_html__('Testimonial', 'textdomain'),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => [
					[

						'name' => 'rating',
						'type' => \Elementor\Controls_Manager::NUMBER,
						'label' => esc_html__('Ratings', 'textdomain'),
						'placeholder' => '1',
						'min' => 1,
						'max' => 5,
						'step' => 1,
						'default' => 1,

					],
					[
						'name' => 'name',
						'label' => esc_html__('Name', 'textdomain'),
						'type' => \Elementor\Controls_Manager::TEXT,
						'placeholder' => esc_html__('Name', 'textdomain'),
						'default' => esc_html__('Name', 'textdomain'),
					],
					[
						'name' => 'designation',
						'label' => esc_html__('Designation', 'textdomain'),
						'type' => \Elementor\Controls_Manager::TEXT,
						'placeholder' => esc_html__('Designation', 'textdomain'),
						'default' => esc_html__('MCA', 'textdomain'),
					],
					[
						'name' => 'description',
						'label' => esc_html__('Description', 'textdomain'),
						'type' => \Elementor\Controls_Manager::TEXTAREA,
						'rows' => 10,
						'default' => esc_html__('Default description', 'textdomain'),
						'placeholder' => esc_html__('Type your description here', 'textdomain'),
					],
					[
						'name' => 'image',
						'label' => esc_html__('Add Images', 'textdomain'),
						'type' => \Elementor\Controls_Manager::MEDIA,
						'show_label' => false,
						'default' => [],

					]

				],
				'title_field' => '{{{ name }}}',
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
				<div class="row">
					<div class="large-12 columns">
						<div class="owl-carousel owl-theme">
							<?php
							foreach ($settings['testimonials'] as $testimonial) {
							?>
								<div class="item">
									<div class="testimonial">
										<div class="testimonial-star-icon">
											<ul>
												<?php 
													for ($i=0; $i <$testimonial['rating'] ; $i++) { 
														?>
															<li><i class="fas fa-star"></i></li>
														<?php
													}
												?>
										
											</ul>
										</div>
										<div class="testimonial-content">
											<p><?php echo  $testimonial['description'] ?></p>
										</div>
										<div class="testimonial-name">
											<h6 class="author-tittle"><?php echo  $testimonial['name'] ?></h6>
											<span class=""><?php echo  $testimonial['designation'] ?></span>
										</div>
										<div class="testimonial-author">
											<img class="img-fluid" src="<?php echo  $testimonial['image']['url'] ?>" alt="">
										</div>
									</div>
								</div>
							<?php
							}
							?>
						</div>
					</div>
				</div>
		<?php
		$output = ob_get_clean();
		echo $output;
	}

	
}
