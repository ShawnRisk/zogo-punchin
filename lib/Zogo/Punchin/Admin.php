<?php

class Zogo_Punchin_Admin {
    
    public function __construct() {
        
        add_action( 'add_meta_boxes', array( $this, 'meta_boxes' ) );
    }
    
    public function meta_boxes() {
        
        add_meta_box( 
            'zogo_punchin_main_metabox', 
            __( 'Timecard Details', 'zogo-punchin-domain' ), 
            array( $this, 'view_main_metabox' ), 
            'zogo_punchin', 
            'advanced', 
            'high' 
        );
    }
    
    public function view_main_metabox() {
        
        $view = new Pronamic_Base_View( ZOGO_PUNCHIN_ROOT . '/views/Zogo_Punchin_Admin' );
        $view
            ->set_view( 'view_main_metabox' )
            ->set( 'nonce', $nonce )
            ->render();   
    }
    
    public function save_main_metabox() {
        
    }
}