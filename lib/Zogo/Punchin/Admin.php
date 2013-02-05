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
        
    }
    
    public function save_main_metabox() {
        
    }
}