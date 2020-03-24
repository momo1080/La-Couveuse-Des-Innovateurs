<?php
require_once(PeepSo::get_plugin_dir() . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'install.php');

class PeepSoHelloInstall extends PeepSoInstall
{

	// optional default settings
	protected $default_config = array(
		#'HELLO_WORLD' => '100',
	);

	public function plugin_activation( $is_core = FALSE )
	{
		// Set some default settings
		$settings = PeepSoConfigSettings::get_instance();
		$settings->set_option('helloworld_profiles_enable', 1);
		$settings->set_option('helloworld_example_int', 1);
		$settings->set_option('helloworld_example_text', 'Custom Hello World!');
		$settings->set_option('helloworld_example_dropdown', 'two');


		parent::plugin_activation($is_core);

		return (TRUE);
	}

	// optional DB table creation
	public static function get_table_data()
	{
		$aRet = array(
			'hello' => "
				CREATE TABLE helloworld (
					hlw_id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
					PRIMARY KEY (hello_id),
				) ENGINE=InnoDB",
		);

		 return $aRet;
	}

	// optional notification emails
	public function get_email_contents()
	{
		$emails = array(
			'email_helloworld' => "Hello World!",
		);

		 return $emails;
	}

	// optional page with shortcode
	protected function get_page_data()
	{
		// default page names/locations
		$aRet = array(
			'hello' => array(
				'title' => __('PeepSo Hello World', 'peepsohello'),
				'slug' => 'helloworld',
				'content' => '[peepso_hello]'
			),
		);

		return ($aRet);
	}
}