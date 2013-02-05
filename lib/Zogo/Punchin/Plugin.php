<?php

class Zogo_Punchin_Plugin {
    
    public function __construct() {
        
        add_action( 'init', array( $this, 'init' ) );
    }
    
    public function init() {
        
        register_post_type( 'zogo_punchin',
            array(
                'labels' => array(
                    'name'                  => _x( 'Timecards', 'plural name post type', 'zogo-punchin-domain' ),
                    'singular_name'         => _x( 'Timecard', 'singular name post type', 'zogo-punchin-domain' ),
                    'add_new'               => _x( 'Add New', 'punchin', 'zogo-punchin-domain' ),
                    'add_new_item'          => __( 'Add New Timecard', 'zogo-punchin-domain' ),
                    'edit_item'             => __( 'Edit Timecard', 'zogo-punchin-domain' ),
                    'new_item'              => __( 'New Timecard', 'zogo-punchin-domain' ),
                    'all_items'             => __( 'All Timecards', 'zogo-punchin-domain' ),
                    'view_item'             => __( 'View Timecard', 'zogo-punchin-domain' ),
                    'search_items'          => __( 'Search Timecards', 'zogo-punchin-domain' ),
                    'not_found'             => __( 'No timecards found', 'zogo-punchin-domain' ),
                    'not_found_in_trash'    => __( 'No timecards found in Trash', 'zogo-punchin-domain' ),
                    'parent_item_colon'     => '',
                    'menu_name'             => __( 'Timecards', 'zogo-punchin-domain' )
                ),
                'public'                        => true,
                'publicly_queryable'            => true,
                'show_ui'                       => true,
                'show_in_menu'                  => true,
                'query_var'                     => true,
                'rewrite'                       => array( 'slug' => __( 'timecard', 'zogo-punchin-domain' ) ),
                'capability_type'               => 'post',
                'has_archive'                   => true,
                'hierarchical'                  => false,
                'menu_position'                 => null,
                'supports'                      => array( '' )
            )
        );
    }
}