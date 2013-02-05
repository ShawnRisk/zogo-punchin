<?php

class Zogo_Punchin_Admin {
    
    public function __construct() {
        
        add_action( 'admin_menu', array( $this, 'menu' ) );
        
    }
    
    public function menu() {
        
        add_menu_page( 
            __( 'Timecards', 'zogo-punchin-domain' ),
             __( 'Timecards', 'zogo-punchin-domain' ), 
             'manage_options', 
             'zogo-punchin-timecards', 
             array( $this, 'view_timecards_page' ) 
        );
    }
    
    public function view_timecards_page() {
        
        // Get all users with timecard details
        $user_query = new WP_User_Query( array(
            'meta_query' => array(
                array(
                    'key' => 'zogo_punchin_timecard',
                    'compare' => 'EXISTS'
                )
            )
        ) );
        
        $view = new Pronamic_Base_View( ZOGO_PUNCHIN_ROOT . '/views/Zogo_Punchin_Admin' );
        $view
            ->set_view( 'view_timecards_page' )
            ->set( 'users', $user_query->results )
            ->render();
    }
}