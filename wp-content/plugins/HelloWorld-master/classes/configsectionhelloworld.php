<?php

class PeepSoConfigSectionHelloworld extends PeepSoConfigSectionAbstract
{
	// Builds the groups array
	public function register_config_groups()
	{
		$this->context='left';
		$this->profiles();

		$this->context='right';
		$this->examples();
	}


	/**
	 * General Settings Box
	 */
	private function profiles()
	{
        // # Enable profile integration
        $this->args('descript', __('Enabled: HelloWorld tab will show in user profiles.','peepsohello'));
        $this->set_field(
            'helloworld_profiles_enable',
            __('Enabled', 'peepsohello'),
            'yesno_switch'
        );

        // # Show to owner only
        $this->args('descript', __('Enabled: users will see the HelloWorld tab only on their own profiles.','peepsohello'));
        $this->set_field(
            'helloworld_profiles_owner_only',
            __('Profile owner only', 'peepsohello'),
            'yesno_switch'
        );

        // # Label
        $this->args('descript', __('Leave empty for default.','peepsohello'));
        $this->set_field(
            'helloworld_profiles_label',
            __('Menu label', 'peepsohello'),
            'text'
        );

        // # Slug
        $this->args('descript', __('Leave empty for default. Be careful not to use a slug that is already taken, for example "photos", "videos" etc.','peepsohello'));
        $this->set_field(
            'helloworld_profiles_slug',
            __('Menu slug', 'peepsohello'),
            'text'
        );

        // # Icon
        $this->args('descript', __('Icon CSS class override. Leave empty for default','peepsohello'));
        $this->set_field(
            'helloworld_profiles_icon',
            __('Menu icon', 'peepsohello'),
            'text'
        );


		$this->set_group(
			'peepso_helloworld_general',
			__('Profile integration', 'peepsohello')
		);
	}

	/**
	 * Custom Greeting Box
	 */
	private function examples()
	{
	    // # EXAMPLE DROP-DOWN
        // Add "options" parameter (array) to the next field
        $options = array(
            'one' => __('Option 1', 'peepsohello'),
            'two' => __('Option 2', 'peepsohello'),
            'three' => __('Option 3', 'peepsohello'),
        );

        // args(key, value)
        $this->args('options', $options);

        // set_field() will take all previously set args and reset them after the field is rendered
        $this->set_field(
            'helloworld_example_dropdown',
            __('Eample drop-down', 'peepsohello'),
            'select'
        );


        // # EXAMPLE TEXT FIELD
		$this->set_field(
			'helloworld_example_text',
			__('Example text field', 'peepsohello'),
			'text'
		);

		// #EXAMPLE INT FIELS
        // The next has to be a number
        $this->args('int', TRUE);
        $this->args('validation', array('required','numeric'));

        // If we didn't specify a default during plugin activation, we can do it now
        $this->args('default', 1);

        // Once again the args will be included automatically. Note that args set before previous field are gone
        $this->set_field(
            'helloworld_example_int',
            __('Example int field', 'peepsohello'),
            'text'
        );

		$this->set_group(
			'helloworld_examples',
			__('Example config options', 'peepsohello')
		);
	}
}