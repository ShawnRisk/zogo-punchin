<div class="wrap">
    <?php screen_icon(); ?>
    <h2><?php echo get_admin_page_title(); ?></h2>
    <?php if ( ! empty( $users ) ) : ?>
        <table class="widefat">
            <thead>
                <tr>
                    <th><?php _e( 'User' ); ?></th>
                    <th><?php _e( 'Timecard', 'zogo-punchin-domain' ); ?></th>
                    <th><?php _e( 'Current Status', 'zogo-punchin-domain' ); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ( $users as $user ) : ?>
                <tr>
                    <td><?php echo $user->display_name; ?></td>
                    <td>
                        <?php $timecard = zogo_punchin_timecard( $user->ID ); ?>
                        <table class="form-table">
                        <?php foreach ( $timecard as $state => $values ) : ?>
                            <tr>
                                <th><?php _e( ucfirst( $state ), 'zogo-punchin-domain' ); ?></th>
                                <td>
                                    <ul>
                                        <?php foreach ( $values as $unix_time ) : ?>
                                            <li><?php echo date( 'd-m-Y h:i:s', $unix_time ); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </td>
                            </tr>
                        <?php endforeach;?>
                        </table>
                    </td>
                    <td>
                        <?php $status = zogo_punchin_status( $user->ID ); ?>
                        <?php if ( 1 == $status ) : ?>
                            <p>CURRENTLY CHECKED IN!</p>
                        <?php endif;?>
                    </td>
                </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    <?php endif;?>
</div>