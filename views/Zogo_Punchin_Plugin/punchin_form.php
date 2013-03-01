<form action="" method="POST">
    <?php echo $nonce; ?>
    <?php if ( $last_checkin ) : ?>
        <p>Currently clocked in at <?php echo date( 'd m y h:i:s', $last_checkin ); ?></p>
    <?php endif;?>
    <input type="submit" value="<?php echo $button; ?>" />
</form>

<table class="widefat zogo_punchin_timecard_table">
            <thead>
                <tr>
                    <th><?php _e( 'User' ); ?></th>
                    <th><?php _e( 'Timecard', 'zogo-punchin-domain' ); ?></th>
                </tr>
            </thead>
             <tbody>
             <?php global $current_user;
      			   get_currentuserinfo();
	   			   $punchin_status = get_user_meta($current_user->ID,'zogo_punchin_timecard', true); ?>
             <tr>
                    <td><a href="#" class="zogo_punchin_timecard_user"><?php echo $current_user->display_name; ?></a></td>
                    <td class="zogo_punchin_user_time_table_element">
                        <div class="zogo_punchin_user_time_table">
							<?php foreach ( $punchin_status as $date => $in_outs ) : ?>
                            	<div class="zogo_punchin_user_date_time_table">
                                    <h2><?php echo $date; ?></h2>
                                    <?php foreach ( $in_outs as $key => $times ) : ?>
                                        <div class="zogo_punchin_time_table_list-holder">
                                            <ul>
                                                <?php foreach ( $times as $time ) : ?>
                                                    <li><?php echo date( 'd-m-Y h:i:s', $time ); ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endforeach; ?>
                    	</div>
                    </td>
             </tr>
</table>