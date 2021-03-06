<?php


class PeepSoWidgetOnlinemembers extends WP_Widget
{

    /**
     * Set up the widget name etc
     */
    public function __construct($id = null, $name = null, $args= null) {
        if(!$id)    $id     = 'PeepSoWidgetOnlineMembers';
        if(!$name)  $name   = __('PeepSo Online Members', 'peepso-core');
        if(!$args)  $args   = array( 'description' => __('PeepSo Online Members Widget', 'peepso-core'), );

        parent::__construct(
            $id, // Base ID
            $name, // Name
            $args // Args
        );
    }

    /**
     * Outputs the content of the widget
     *
     * @param array $args
     * @param array $instance
     */
    public function widget( $args, $instance ) {
        $instance['user_id']    = get_current_user_id();
        $instance['user']       = PeepSoUser::get_instance($instance['user_id']);

        if(isset($instance['is_profile_widget']))
        {
            // Override the HTML wrappers
            $args = apply_filters('peepso_widget_args_internal', $args);
        }

        // Additional shared adjustments
        $instance = apply_filters('peepso_widget_instance', $instance);

        if(!array_key_exists('template', $instance) || !strlen($instance['template']))
        {
            $instance['template'] = 'online-members.tpl';
        }

        PeepSoTemplate::exec_template( 'widgets', $instance['template'], array( 'args'=>$args, 'instance' => $instance ) );

        // Included in peepso bundle.
        wp_enqueue_script('peepso-widget-online-members', FALSE, array('peepso-bundle'),
            PeepSo::PLUGIN_VERSION, TRUE);
    }

    /**
     * Outputs the admin options form
     *
     * @param array $instance The widget options
     */
    public function form( $instance ) {

        $instance['fields'] = array(
            // general
            'limit'     => TRUE,
            'title'     => TRUE,

            // peepso
            'integrated'   => TRUE,
            'position'  => TRUE,
            'ordering'  => TRUE,
            'hideempty' => TRUE,
            'totalonline' => TRUE,
			'totalmember' => TRUE,
        );

		if (!isset($instance['title'])) {
			$instance['title'] = __('Online Members', 'peepso-core');
		}

        $this->instance = $instance;

        $settings =  apply_filters('peepso_widget_form', array('html'=>'', 'that'=>$this,'instance'=>$instance));
        echo $settings['html'];
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['guest_behavior'] = $new_instance['guest_behavior'];
        $instance['title']          = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['limit']       = isset($new_instance['limit']) ? (int) $new_instance['limit'] : 12;

        $instance['integrated']  = 1;
        $instance['hideempty']   = isset($new_instance['hideempty']) ? (int) $new_instance['hideempty'] : 0;
        $instance['position']    = isset($new_instance['position']) ? strip_tags($new_instance['position']): 0;
        $instance['totalmember'] = isset($new_instance['totalmember']) ? (int) $new_instance['totalmember'] : 0;
        $instance['totalonline'] = isset($new_instance['totalonline']) ? (int) $new_instance['totalonline'] : 0;

        return $instance;
    }
}

// EOF
