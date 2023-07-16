<?php 
    $link_text = get_post_meta($post->ID, 'wp_ae_slider_link_text', true);
    $link_url = get_post_meta($post->ID, 'wp_ae_slider_link_url', true);
?>

<table class="form-table wp-ae-slider-metabox"> 
<input type="hidden" name="wp_ae_slider_nonce" value="<?php echo wp_create_nonce( "wp_ae_slider_nonce" ); ?>">
    <tr>
        <th>
            <label for="wp_ae_slider_link_text"><?php esc_html_e( 'Sider Link Text', 'wp-ae-slider' ); ?></label>
        </th>
        <td>
            <input 
                type="text" 
                name="wp_ae_slider_link_text" 
                id="wp_ae_slider_link_text" 
                class="regular-text link-text"
                value="<?php echo (isset($link_text)) ? esc_html($link_text) : '' ?>"
                required
            >
        </td>
    </tr>
    <tr>
        <th>
            <label for="wp_ae_slider_link_url"><?php esc_html_e( 'Sider Link URL', 'wp-ae-slider' ); ?></label>
        </th>
        <td>
            <input 
                type="url" 
                name="wp_ae_slider_link_url" 
                id="wp_ae_slider_link_url" 
                class="regular-text link-url"
                value="<?php echo (isset($link_url)) ? esc_url($link_url) : '' ?>"
                required
            >
        </td>
    </tr>               
</table>