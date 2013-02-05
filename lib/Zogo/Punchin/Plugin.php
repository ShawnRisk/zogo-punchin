<?php

class Zogo_Punchin_Plugin {
    
    public function __construct() {
        
        add_action( 'init', array( $this, 'init' ) );
    }
    
    public function init() {
        
    }
}