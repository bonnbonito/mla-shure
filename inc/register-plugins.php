<?php

function mlashure_register_required_plugins(){
	$plugins                    =   [

		[
			'name'              => 'Contact Form 7',
			'slug'              => 'contact-form-7',
			'required'          => false,
		],

		[
			'name'              =>  'Advanced Custom Fields Pro',
			'slug'              =>  'advanced-custom-fields-pro',
			'source'            =>  get_template_directory() . '/inc/plugins/advanced-custom-fields-pro.zip',
			'required'          =>  true
		]
	];

	$config                     =   [
		'id'                    =>  'mlashure',
		'menu'                  =>  'tgmpa-install-plugins',
		'parent_slug'           =>  'themes.php',
		'capability'            =>  'edit_theme_options',
		'has_notices'           =>  true,
		'dismissable'           =>  true
	];

	tgmpa( $plugins, $config );
}