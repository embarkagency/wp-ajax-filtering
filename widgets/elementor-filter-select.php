<?php

require_once(plugin_dir_path( __FILE__ ) . '/elementor-filter.php');

class Elementor_AJF_Filter_Select_Widget extends Elementor_AJF_Filter_Widget {

	public function __construct($data = [], $args = null) {

		$this->filter_type = 'select';
		$this->default_label = 'Number of items';
		$this->default_slug = 'count';

		parent::__construct($data, $args);
	}
	
	public function add_filter_controls() {
		
	}
}