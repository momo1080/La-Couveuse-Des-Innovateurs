<?php

class PeepSoAdminSocialLogin
{

	/** 
	 * Displays profile fields mapping.
	 */
	public static function administration() {
		if ($_GET['page'] == 'peepso-manage' && $_GET['tab'] == 'social-login' && !empty($_POST)) {
			$options = get_option('peepso_social_field_mapping', array());

			if ($_POST['social_field'] == 'avatar') {
				$config = PeepSoConfigSettings::get_instance();
				$config->set_option('social_login_import_avatar', absint($_POST['peepso_field']));
				echo $_POST['peepso_field'];
			} else {
				$options[$_POST['social_field']] = absint($_POST['peepso_field']);
				update_option('peepso_social_field_mapping', $options);
			}
			
			die();
		}

		self::enqueue_scripts();

		$social_login_fields = [
			'first_name',
			'last_name',
			'birthdate'
		];

		$PeepSoUser = PeepSoUser::get_instance(0);
		$profile_fields = new PeepSoProfileFields($PeepSoUser);
		$fields = $profile_fields->load_fields();

		PeepSoTemplate::exec_template('admin','social_login', [
			'social_login_fields' => $social_login_fields,
			'fields' => $fields,
			'option' => get_option('peepso_social_field_mapping', array())
		]);
	}

	public static function enqueue_scripts() {
		wp_enqueue_script('peepso-admin-manage-social-login', PeepSo::get_asset('js/admin/manage-social-login.js'),
			array('peepso'), PeepSo::PLUGIN_VERSION, TRUE);
	}
}