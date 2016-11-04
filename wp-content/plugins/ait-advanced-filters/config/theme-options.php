<?php

return array(
	'raw' => array(
		'itemAdvancedFilters' => array(
			'title' => __('Advanced Filters', 'ait-advanced-filters'),
			'options' => array(
				'enabled' => array(
					'label' 	=> __('Enabled', 'ait-advanced-filters'),
					'type'		=> 'on-off',
					'default'	=> true,
				),
				'filterColumns' => array(
					'label' 	=> __('Filter Columns', 'ait-advanced-filters'),
					'type'		=> 'select',
					'default'	=> array(
						'2'	=> '2',
						'3'	=> '3',
						'4' => '4',
						'5'	=> '5',
					),
					'selected' => '4',
					'help'		=> __("Number of columns displayed on frontend", 'ait-advanced-filters')
				),
			),
		),
	),
	'defaults' => array(
		'itemAdvancedFilters' => array(
			'enabled' => true,
			'filterColumns' => '4'
		)
	)
);