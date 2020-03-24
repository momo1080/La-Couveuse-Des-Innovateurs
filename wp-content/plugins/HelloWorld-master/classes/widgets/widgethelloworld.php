<?php


class PeepSoWidgetHelloworld extends WP_Widget
{

    /**
     * Set up the widget name etc
     */
    public function __construct($id = null, $name = null, $args= null) {
        if(!$id)    $id     = 'PeepSoWidgetHelloWorld';
        if(!$name)  $name   = __( 'PeepSo Hello World', 'peepsohello' );
        if(!$args)  $args   = array( 'description' => __( 'PeepSo Hello World Widget', 'peepsohello' ), );

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

        $view_id = get_current_user_id();

        if(isset($instance['is_profile_widget']))
        {
            // Use currently viewed profile
            $view_id = PeepSoProfileShortcode::get_instance()->get_view_user_id();

            // Override the HTML wrappers
            $args = apply_filters('peepso_widget_args_internal', $args);
        }

        // Additional shared adjustments
        $instance = apply_filters('peepso_widget_instance', $instance);

        if(!array_key_exists('template', $instance) || !strlen($instance['template']))
        {
            $instance['template'] = 'hello.tpl';
        }

        if(!array_key_exists('user_id', $instance))
        {
            $instance['user_id'] = $view_id;
        }

        $instance['hello'] = 'Hello World';

        PeepSoTemplate::exec_template( 'widgets', $instance['template'], array( 'args'=>$args, 'instance' => $instance ) );
    }

    /**
     * Outputs the admin options form
     *
     * @param array $instance The widget options
     */
    public function form( $instance ) {

        $instance['fields'] = array(
            // general
            'limit'     => FALSE,
            'title'     => TRUE,

            // peepso
            'integrated'   => TRUE,
            'position'  => TRUE,
            'ordering'  => TRUE,
            'hideempty' => FALSE,

        );

		if (!isset($instance['title'])) {
			$instance['title'] = __('Hello World', 'peepsohello');
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
        $instance['title']       = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['limit']       = isset($new_instance['limit']) ? (int) $new_instance['limit'] : 12;

        $instance['integrated']  = 1;
        $instance['hideempty']   = isset($new_instance['hideempty']) ? (int) $new_instance['hideempty'] : 1;
        $instance['position']    = isset($new_instance['position']) ? strip_tags($new_instance['position']) : 0;

        return $instance;
    }
}

// EOF