<?php

class PeepSoConfigSectionMarkdown extends PeepSoConfigSectionAbstract
{
	// Builds the groups array
	public function register_config_groups()
	{
		$this->context='left';
		$this->group_left();

		$this->context='right';
        if(class_exists('PeepSoMessages')) {
            #$this->group_chat();
        }

        if(class_exists('PeepSoGroupsPlugin')) {
           # $this->group_groups();
        }

        $this->group_readme();
	}


	/**
	 * General Settings Box
	 */
	private function group_left()
	{
        $this->set_field(
            'md_post',
            __('Enable in posts','peepso-core'),
            'yesno_switch'
        );

        $this->set_field(
            'md_comment',
            __('Enable in comments','peepso-core'),
            'yesno_switch'
        );

        $this->args('default', 1);
        $this->args('descript', __('When active, this setting will disable paragraph rendering and treat every new line as a line break. For details, see <a href="https://www.markdownguide.org/basic-syntax#paragraphs-1" target="_blank" title="a link">this link</a>.', 'peepso-core'));
        $this->set_field(
            'md_no_paragraph',
            __('Disable paragraph', 'peepso-core'),
            'yesno_switch'
        );

		$this->set_group(
			'peepso_md_general',
			__('General', 'peepsommd')
		);
	}

	public function group_chat() {
        $this->set_field(
            'md_chat',
            __('Enable in messages','peepso-core'),
            'yesno_switch'
        );

        $this->set_group(
            'peepso_md_chat',
            __('Chat', 'peepsommd')
        );
    }

    public function group_groups()
    {
        $this->set_field(
            'md_groups_about',
            __('Enable in Groups "about"','peepso-core'),
            'yesno_switch'
        );

        $this->set_group(
            'md_groups',
            __('Groups', 'peepso-core')
        );
    }

    public function group_readme() {

        $this->set_field(
            'md_readme',
            __('Markdown is a lightweight markup language with plain text formatting syntax. It is designed so that it can be converted to HTML and many other formats', 'peepsomd') . ' ' .
            '(<a href="https://en.wikipedia.org/wiki/Markdown" target="_blank">Wikipedia</a>)<br/><br/>' .
            '**bold text** for <b>bold text</b><br/>' .
            '*italic text* for <i>italic text</i><br/>' .
            '`inline code` for <code>inline code</code><br/>' .
            '~~strikethrough~~` for <del>strikethrough</del><br/>' .
            '[link](https://PeepSo.com)` for <a href="https://PeepSo.com">link</a><br/>' .
            ''
            ,
            'message'
        );

        $this->set_group(
            'peepso_md_groups',
            __('About Markdown', 'peepso-core')
        );
    }
}