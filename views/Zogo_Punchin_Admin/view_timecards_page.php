<div class="wrap">
<?php //$users = get_users(); ?>

    <?php screen_icon(); ?>
    <h2><?php echo get_admin_page_title(); ?></h2>
    <?php if ( ! empty( $users ) ) : ?>
        <table class="widefat zogo_punchin_timecard_table">
            <thead>
                <tr>
                    <th><?php _e( 'User' ); ?></th>
                    <th><?php _e( 'Timecard', 'zogo-punchin-domain' ); ?></th>
                    <th><?php _e( 'Current Status', 'zogo-punchin-domain' ); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ( $users as $user ) : ?>
				<?php $timecard = zogo_punchin_timecard( $user->ID ); ?>
                <tr>
					<td><a href="#" class="zogo_punchin_timecard_user"><?php echo $user->display_name; ?></a></td>
					<td class="zogo_punchin_user_time_table_element">
                        <div class="zogo_punchin_user_time_table">

							<?php foreach ( $timecard as $date => $in_outs ) : ?>

								<h2><?php echo $date; ?></h2>

								<?php foreach ( $in_outs as $key => $times ) : ?>
									<div class="zogo_punchin_time_table_list-holder">
										<ul>
											<?php foreach ( $times as $time ) : ?>
												<li>date<?php echo date( 'd-m-Y h:i:s', $time ); ?></li>
											<?php endforeach;?>
										</ul>
									</div>
								<?php endforeach;?>
							<?php endforeach ;?>
                        </div>
                    </td>
                    <td>
                        <?php $status = zogo_punchin_status( $user->ID ); ?>
                        <?php if ( 1 == $status ) : ?>
                            <span class="zogo_punchin_user_status">CURRENTLY CLOCKED IN!</span>
                        <?php endif;?>
                    </td>
                </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    <?php endif;?>
</div>