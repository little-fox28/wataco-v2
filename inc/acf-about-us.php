<?php
/**
 * ACF Field Group: About Us Culture
 */

if ( function_exists( 'acf_add_local_field_group' ) ) :

	$fields = array(
		array(
			'key'               => 'field_wataco_about_culture_tab',
			'label'             => 'Culture',
			'name'              => '',
			'type'              => 'tab',
			'instructions'      => '',
			'required'          => 0,
			'conditional_logic' => 0,
			'wrapper'           => array(
				'width' => '',
				'class' => '',
				'id'    => '',
			),
			'placement'         => 'top',
			'endpoint'          => 0,
		),
	);

	for ( $i = 1; $i <= 6; $i ++ ) {
		$fields[] = array(
			'key'               => "field_wataco_culture_{$i}_img",
			'label'             => "Culture Item {$i} Image",
			'name'              => "culture_{$i}_img",
			'type'              => 'image',
			'instructions'      => '',
			'required'          => 0,
			'conditional_logic' => 0,
			'wrapper'           => array(
				'width' => '33.33',
				'class' => '',
				'id'    => '',
			),
			'return_format'     => 'id',
			'preview_size'      => 'medium',
			'library'           => 'all',
			'min_width'         => '',
			'min_height'        => '',
			'min_size'          => '',
			'max_width'         => '',
			'max_height'        => '',
			'max_size'          => '',
			'mime_types'        => '',
		);
		$fields[] = array(
			'key'               => "field_wataco_culture_{$i}_cat",
			'label'             => "Culture Item {$i} Category",
			'name'              => "culture_{$i}_cat",
			'type'              => 'text',
			'instructions'      => '',
			'required'          => 0,
			'conditional_logic' => 0,
			'wrapper'           => array(
				'width' => '33.33',
				'class' => '',
				'id'    => '',
			),
			'default_value'     => '',
			'placeholder'       => '',
			'prepend'           => '',
			'append'            => '',
			'maxlength'         => '',
		);
		$fields[] = array(
			'key'               => "field_wataco_culture_{$i}_title",
			'label'             => "Culture Item {$i} Title",
			'name'              => "culture_{$i}_title",
			'type'              => 'text',
			'instructions'      => '',
			'required'          => 0,
			'conditional_logic' => 0,
			'wrapper'           => array(
				'width' => '33.33',
				'class' => '',
				'id'    => '',
			),
			'default_value'     => '',
			'placeholder'       => '',
			'prepend'           => '',
			'append'            => '',
			'maxlength'         => '',
		);
	}

	acf_add_local_field_group(
		array(
			'key'                   => 'group_wataco_about_page_culture',
			'title'                 => 'About Us Page - Culture',
			'fields'                => $fields,
			'location'              => array(
				array(
					array(
						'param'    => 'page_template',
						'operator' => '==',
						'value'    => 'page-templates/template-about-us.php',
					),
				),
			),
			'menu_order'            => 0,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen'        => '',
			'active'                => true,
			'description'           => '',
		)
	);

endif;
