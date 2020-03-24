<?php
/**
 * GetResponse handler of the plugin.
 *
 * @package    Blossomthemes_Email_Newsletter
 * @subpackage Blossomthemes_Email_Newsletter/includes
 * @author    blossomthemes
 */
class Blossomthemes_Email_Newsletter_GetResponse {

    function bten_getresponse_action( $email,$sid,$fname)
    {
        if(!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL) === false)
        {
            $blossomthemes_email_newsletter_settings = get_option( 'blossomthemes_email_newsletter_settings', true );
            
            require BLOSSOMTHEMES_EMAIL_NEWSLETTER_BASE_PATH . '/includes/jsonRPCClient.php';
            $api_key = $blossomthemes_email_newsletter_settings['getresponse']['api-key']; //Place API key here
            $api_url = 'http://api2.getresponse.com';
            $client = new jsonRPCClient($api_url);
            $list = array();
            
            try{

                if( ! empty( $api_key ))
                {
                    $obj = new BlossomThemes_Email_Newsletter_Settings;
                    $data = $obj->getresponse_lists();

                    if( ! empty( $data ) )
                    {
                        $listids = get_post_meta($sid,'blossomthemes_email_newsletter_setting',true);                  

                        if(!isset($listids['getresponse']['list-id']))
                        {
                            $listids = $blossomthemes_email_newsletter_settings['getresponse']['list-id'];
                            $result_contact = $client->add_contact(
                                $api_key,
                                array (
                                'campaign' => $listids,
                                'name'     => $fname,
                                'email'    => $email
                                )
                            );
                            $list['response'] = '200' ;
                        }
                        else
                        {
                            foreach ($listids['getresponse']['list-id'] as $key => $value) {
                                $result_contact = $client->add_contact(
                                    $api_key,
                                    array (
                                    'campaign' => $key,
                                    'name'     => $fname,
                                    'email'    => $email
                                    )
                                );
                            }
                            $list['response'] = '200' ;
                        }
                    }
                }
            }

            catch (Exception $e) {
                $list['log']['errorMessage'] = $e->getMessage();
            }      
        }
        return $list;
    }
}
new Blossomthemes_Email_Newsletter_GetResponse;