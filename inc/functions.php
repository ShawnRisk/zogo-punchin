<?php

///////////////
// FUNCTIONS //
///////////////

/**
 * Gets all recorded timesheet information for the user
 * 
 * @param  int $user_id | The user you want to query (or null gets current user)
 * @return array        | The timecard data
 */
function zogo_punchin_timecard( $user_id = null ) {
    
    if ( ! is_user_logged_in() && ! $user_id )
        return false;
    
    if ( ! $user_id )
        $user_id = get_current_user_id();
    
    $timecard = get_the_author_meta( 'zogo_punchin_timecard', $user_id );
    
    if ( ! is_array( $timecard ) || empty( $timecard ) )
        $timecard = array();
    
    return $timecard;
}

/**
 * Returns the current status of the passed user id
 * ( whether they are checked in or out )
 * 
 * @param  int $user_id | The user id ( or null for current user )
 * @return int          | 1 for in, 0 for not
 */
function zogo_punchin_status( $user_id = null ) {
    
    if ( ! is_user_logged_in() && ! $user_id )
        return false;
    
    if ( ! $user_id )
        $user_id = get_current_user_id();    
    
    $status = get_the_author_meta( 'zogo_punchin_status', $user_id );
    
    return $status;
}


/**
 * Returns the last checkin unix time
 * 
 * @param  int $user_id | The user id
 * @return int | Unix time
 */
function zogo_punchin_last_checkin( $user_id = null ) {
    
    $timecard = zogo_punchin_timecard( $user_id );
    
    if ( isset( $timecard['in'] ) ) {
        
        $reversed_timecard = array_reverse( $timecard['in'] );
        
        return $reversed_timecard[0];
        
    } else {
        
        return false;
        
    }
}