<?php
/**
 * The Conference Template Hooks.
 *
 * @package The Conference 
 */

/** Import content data*/
if ( ! function_exists( 'the_conference_import_files' ) ) :
function the_conference_import_files() {
  $upload_dir = wp_upload_dir();
    return array(
        array(
            'import_file_name'             => 'The Conference Demo',
            'local_import_file'            => $upload_dir['basedir'] . '/rara-demo-pack/the-conference-demo-content/content/theconference.xml',
            'local_import_widget_file'     => $upload_dir['basedir'] . '/rara-demo-pack/the-conference-demo-content/content/theconference.wie',
            'local_import_customizer_file' => $upload_dir['basedir'] . '/rara-demo-pack/the-conference-demo-content/content/theconference.dat',
            'import_preview_image_url'     => get_template_directory() .'/screenshot.png',
            'import_notice'                => __( 'Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'the-conference' ),
        ),
    );       
}
add_filter( 'rrdi/import_files', 'the_conference_import_files' );
endif;

/** Programmatically set the front page and menu */
if ( ! function_exists( 'the_conference_after_import' ) ) :

function the_conference_after_import( $selected_import ) {
      
      //Set Menu
      $primary   = get_term_by('name', 'Primary', 'nav_menu');
      set_theme_mod( 'nav_menu_locations' , array( 
            'primary'   => $primary->term_id
           ) 
      );
   
      /** Set Front page */
      $page = get_page_by_path('home'); /** This need to be slug of the page that is assigned as Front page */
      if ( isset( $page->ID ) ) {
        update_option( 'page_on_front', $page->ID );
        update_option( 'show_on_front', 'page' );
      }
           
      /** Blog Page */
      $postpage = get_page_by_path('blog'); /** This need to be slug of the page that is assigned as Posts page */
      if( $postpage ){
        $post_pgid = $postpage->ID;
        update_option( 'page_for_posts', $post_pgid );
      }

}
add_action( 'rrdi/after_import', 'the_conference_after_import' );
endif;

function the_conference_import_msg(){
    return __( 'Before you begin, make sure all recommended plugins are activated.', 'the-conference' );
}
add_filter( 'rrdi_before_import_msg', 'the_conference_import_msg' );