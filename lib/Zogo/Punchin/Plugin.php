<?php

class Zogo_Punchin_Plugin {
    
    public function __construct() {
        
        add_shortcode( 'punchin-form', array( $this, 'punchin_form' ) );
        
        add_action( 'init', array( $this, 'handle_checkout' ) );
        add_action( 'init', array( $this, 'handle_checkin' ) );
        
    }
    
    public function punchin_form( $atts ) {
        
        $timecard = zogo_punchin_timecard();
        $status = zogo_punchin_status();
        
        if ( 1 == $status ) {
            
            // User is currently checked in
            $last_checkin = zogo_punchin_last_checkin();
            $nonce = wp_nonce_field( 'zogo_punchin_form_checkout', 'zogo_punchin_form_checkout_nonce', true, false );    
            $button = __( 'Check Out', 'zogo-punchin-domain' );
            
        } else {
            
            // User is not checked in
            $last_checkin = false;
            $nonce = wp_nonce_field( 'zogo_punchin_form_checkin', 'zogo_punchin_form_checkin_nonce', true, false );    
            $button = __( 'Check In', 'zogo-punchin-domain' );
            
        }
        
        $view = new Pronamic_Base_View( ZOGO_PUNCHIN_ROOT . '/views/Zogo_Punchin_Plugin' );
        
        return $view
            ->set_view( 'punchin_form' )
            ->set( 'nonce', $nonce )
            ->set( 'button', $button )
            ->set( 'last_checkin', $last_checkin )
            ->retrieve();
        
    }
    
    public function handle_checkout() {
        
        // Check this submission has someone logged in
        if ( ! is_user_logged_in() )
            return;
        
        if ( 0 == zogo_punchin_status() )
            return;
        
        // Check its part of the checkout form
        if ( ! isset( $_POST['zogo_punchin_form_checkout_nonce'] ) )
            return;
        
        // Check its valid
        if ( ! wp_verify_nonce( $_POST['zogo_punchin_form_checkout_nonce'], 'zogo_punchin_form_checkout' ) )
            return;
        
        // User id
        $user_id = get_current_user_id();
         
        // Get current timecard information
        $timecard = get_the_author_meta( 'zogo_punchin_timecard', $user_id );
        
        if ( ! is_array( $timecard ) || empty( $timecard ) )
            $timecard = array();
        
        if ( ! isset( $timecard['out'] ) )
            $timecard['out'] = array();
        
        $timecard['out'][] = time();
        
        // Add an entry to his timecard
        update_user_meta( $user_id, 'zogo_punchin_timecard', $timecard );
        
        // Set him to checked out
        update_user_meta( $user_id, 'zogo_punchin_status', 0 );
        
    }
    
    public function handle_checkin() {
        
        // Check this submission has someone logged in
        if ( ! is_user_logged_in() )
            return;
        
        if ( 1 == zogo_punchin_status() )
            return;
        
        // Check its part of the checkout form
        if ( ! isset( $_POST['zogo_punchin_form_checkin_nonce'] ) )
            return;
        
        // Check its valid
        if ( ! wp_verify_nonce( $_POST['zogo_punchin_form_checkin_nonce'], 'zogo_punchin_form_checkin' ) )
            return;
        
        // User id
        $user_id = get_current_user_id();
         
        // Get current timecard information
        $timecard = get_the_author_meta( 'zogo_punchin_timecard', $user_id );
        
        if ( ! is_array( $timecard ) || empty( $timecard ) )
            $timecard = array();
        
        if ( ! isset( $timecard['in'] ) )
            $timecard['in'] = array();
        
        // Add an entry
        $timecard['in'][] = time();
        
        // Add an entry to his timecard
        update_user_meta( $user_id, 'zogo_punchin_timecard', $timecard );
        
        // Set him to checked out
        update_user_meta( $user_id, 'zogo_punchin_status', 1 );
        
    }
}