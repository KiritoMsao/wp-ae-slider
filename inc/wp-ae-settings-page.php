<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    <form action="options.php" method="post">
        <?php 
        settings_fields( 'wp_ae_slider_group' );
        do_settings_sections( 'wp_ae_slider_sec_page' );
        submit_button( 'Save Settings' );
        ?>
    </form>
</div>