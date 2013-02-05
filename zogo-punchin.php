<?php

/**
 * Plugin Name: Zogo Punchin
 * Author: Leon Rowland
 * Author URI: http://leon.rowland.nl
 * Version 0.0.1
 */

/////////////////
// DEFINITIONS //
/////////////////

define( 'ZOGO_PUNCHIN_ROOT', __DIR__ );
define( 'ZOGO_PUNCHIN_FOLDER', basename( ZOGO_PUNCHIN_ROOT ) );
define( 'ZOGO_PUNCHIN_URL', plugins_url( '', __FILE__ ) );


////////////////////////
// PRONAMIC FRAMEWORK //
////////////////////////

if ( ! class_exists( 'Pronamic_Base_Autoload' ) )
    include ZOGO_PUNCHIN_ROOT . '/pronamic-framework/Pronamic/Base/Autoload.php';

$autoload = Pronamic_Base_Autoload::get_instance();

$autoload->register_components( [
    "Pronamic\\Base" => ZOGO_PUNCHIN_ROOT . '/pronamic-framework',
    "Pronamic\\Helper" => ZOGO_PUNCHIN_ROOT . '/pronamic-framework'
] );

$autoload->register_folders( [
    ZOGO_PUNCHIN_ROOT . '/lib'
] );

$autoload->register();


//////////////////
// START PLUGIN //
//////////////////

$plugin = new Zogo_Punchin_Plugin();

if ( is_admin() )
    $admin = new Zogo_Punchin_Admin();