<?php

return array(
	'filters' => array(
		'label' 	=> __('Filters', 'ait-advanced-filters'),
		'type'		=> 'categories',
		'multiple'	=> true,
		'taxonomy'	=> 'ait-items_filters',
		'addnew'	=> false,
        'args'      => array(
            'hide_empty' => false,
            'show_count' => false,
        ),
		'default'	=> '0',
        'help' => __("Assign filters to Item", 'ait-advanced-filters'),
	),
);