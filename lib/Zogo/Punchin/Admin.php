<?php

class Zogo_Punchin_Admin {
    
    public function __construct() {
        
        add_action( 'add_meta_boxes', array( $this, 'meta_boxes' ) );
    }
    
    public function meta_boxes() {
        
    }
}