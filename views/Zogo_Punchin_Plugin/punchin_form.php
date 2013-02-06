<form action="" method="POST">
    <?php echo $nonce; ?>
    <?php if ( $last_checkin ) : ?>
        <p>Currently clocked in at <?php echo date( 'd m y h:i:s', $last_checkin ); ?></p>
    <?php endif;?>
    <input type="submit" value="<?php echo $button; ?>" />
</form>