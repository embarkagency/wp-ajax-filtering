<?php


/**
 * Elementor AJF Grid Widget.
 *
 * Elementor widget that inserts an AJF Grid (AJAX filterable Grid) onto the page.
 *
 * @since 1.0.0
 */
class Elementor_AJF_Grid_Widget extends \Elementor\Widget_Base {

    public static $slug = 'ajf-grid';

	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);
		wp_register_script( 'ajf-elementor-js', plugins_url('../js/ajf-elementor.js', __FILE__), [ 'elementor-frontend' ], '1.0.0', true );
	}
  
	public function get_script_depends() {
		return [ 'ajf-elementor-js' ];
	}

	/**
	 * Get widget name.
	 *
	 * Retrieve AJF widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return self::$slug;
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve AJF widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'AJF Grid', self::$slug );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve AJF widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'fad fa-th';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the AJF widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'general' ];
	}

	/**
	 * Register AJF widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {
        global $AJF;

		$this->start_controls_section('content_section', [
			'label' => __( 'Configuration', self::$slug ),
			'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
		]);

		//Grid Slug (text)
		//Source (select) (post_type, external_api)
		//


		$this->add_control('source', [
			'label' => __( 'Source', self::$slug ),
			'type' => \Elementor\Controls_Manager::SELECT,
			'default' => 'post',
			'options' => get_post_types([], 'names'),
		]);

		$this->add_control('unique_id', [
			'label' => __( 'Unique ID', self::$slug ),
			'type' => \Elementor\Controls_Manager::TEXT,
			'default' => __( '', self::$slug ),
			'placeholder' => __( '', self::$slug ),
			'description' => 'Set a unique ID if you have multiple grids on the same page to avoid conflicts otherwise can be left blank.',
		]);

		$this->add_control('count', [
			'label' => __( 'Count', self::$slug ),
			'type' => \Elementor\Controls_Manager::NUMBER,
			'min' => 0,
			'max' => 100,
			'step' => 1,
			'default' => 12,
			'description' => 'Set to 0 to show all results.',
		]);

		$this->add_control('pagination', [
			'label' => __( 'Pagination', self::$slug ),
			'type' => \Elementor\Controls_Manager::SWITCHER,
			'label_on' => __( 'Show', self::$slug ),
			'label_off' => __( 'Hide', self::$slug ),
			'return_value' => 'yes',
			'default' => 'yes',
		]);

		$this->add_control('has_nav', [
			'label' => __( 'Prev/Next', self::$slug ),
			'type' => \Elementor\Controls_Manager::SWITCHER,
			'label_on' => __( 'Show', self::$slug ),
			'label_off' => __( 'Hide', self::$slug ),
			'return_value' => 'yes',
			'default' => 'yes',
		]);

		$this->add_control('order_by', [
			'label' => __( 'Order By', self::$slug ),
			'type' => \Elementor\Controls_Manager::SELECT,
			'default' => 'default',
			'options' => [
				'default' => 'Default',
				'random' => 'Random',
				'id-0' => 'ID (lowest first)',
				'id-9' => 'ID (highest first)',
				'title-a' => 'Title (A-Z)',
				'title-z' => 'Title (Z-A)',
				'date-old' => 'Date Modified (oldest first)',
				'date-new' => 'Date Modified (newest first)',
			],
		]);

		$default_render = '<div class="archive-item post">
	<img src="{{thumbnail}}" />
	<h4>{{post_title}}</h4>
	<a href="{{permalink}}">View Post</a>
</div>';
		$this->add_control('render_template', [
			'label' => __( 'Render Template (with Mustache)', self::$slug ),
			'type' => \Elementor\Controls_Manager::CODE,
			'rows' => 10,
			'language' => 'html',
			'default' => __( $default_render, self::$slug ),
			'description' => 'Templating uses Mustache syntax. <br />Example variables: {{post_title}}, {{post_content}}.<br /><a href="https://mustache.github.io/mustache.5.html" target="_blank">View Documentation</a>',
			'placeholder' => __( '', self::$slug ),
		]);

		$this->add_control('debug_mode', [
			'label' => __( 'Debug Mode', self::$slug ),
			'type' => \Elementor\Controls_Manager::SWITCHER,
			'label_on' => __( 'On', self::$slug ),
			'label_off' => __( 'Off', self::$slug ),
			'return_value' => 'on',
			'default' => '',
		]);

		$this->end_controls_section();

	}

	/**
	 * Render AJF widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
        global $AJF;

		$settings = $this->get_settings_for_display();
		$shortcode = $AJF->register_from_settings($settings, true);

		if($shortcode) {
			echo do_shortcode($shortcode);
		}
	}

}