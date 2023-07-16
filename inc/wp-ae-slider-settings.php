<?php 

if (!class_exists('WP_AE_Slider_SETTINGS')) {
    class WP_AE_Slider_SETTINGS{
        public static $options;

        public function __construct(){
            self::$options = get_option( 'wp_ae_slider_options' );

            add_action( 'admin_init', array($this, 'wp_ae_slider_admin_init') );
        }

        public function wp_ae_slider_admin_init(){
            register_setting( 'wp_ae_slider_group', 'wp_ae_slider_options', array($this, 'wp_ae_slider_validation') );

            add_settings_section(
                'wp_ae_slider_settings_sec',
                'WP AE Slider Options', 
                null, 
                'wp_ae_slider_sec_page' );

            add_settings_field(
                'wp_ae_slider_title', 
                'Slider Title', 
                array($this, 'wp_ae_slider_title_callback'), 
                'wp_ae_slider_sec_page', 
                'wp_ae_slider_settings_sec',
                array('label_for'=> 'wp_ae_slider_title') );

            add_settings_field(
                'wp_ae_slider_bullets', 
                'Display Bullets', 
                array($this, 'wp_ae_slider_bullets_callback'), 
                'wp_ae_slider_sec_page', 
                'wp_ae_slider_settings_sec',
                array('label_for'=> 'wp_ae_slider_bullets') );

            add_settings_field(
                'wp_ae_slider_style', 
                'Choose a Style', 
                array($this, 'wp_ae_slider_styles_callback'), 
                'wp_ae_slider_sec_page', 
                'wp_ae_slider_settings_sec',
                array(
                    'label_for'=> 'wp_ae_slider_style',
                    'items' => array('style-1', 'style-2')) );
        }

        public function wp_ae_slider_title_callback($args){
            ?>
            <input 
                type="text" 
                name="wp_ae_slider_options[wp_ae_slider_title]" 
                id="wp_ae_slider_title"
                value="<?php echo isset(self::$options['wp_ae_slider_title']) ? esc_attr(self::$options['wp_ae_slider_title']) : ''; ?>">
            <?php 
        }

        public function wp_ae_slider_bullets_callback($args){
            ?>
            <input 
                type="checkbox" 
                name="wp_ae_slider_options[wp_ae_slider_bullets]" 
                id="wp_ae_slider_bullets"
                value="1"
                <?php 
                if(isset(self::$options['wp_ae_slider_bullets'])) {
                    checked( '1', self::$options['wp_ae_slider_bullets'], true );
                }?> >

            <label for="wp_ae_slider_bullets">Display bullets or not</label>
            <?php 
        }

        public function wp_ae_slider_styles_callback($args){
            ?>
            <select name="wp_ae_slider_options[wp_ae_slider_style]" id="wp_ae_slider_style">
                <?php 
                foreach ($args['items'] as $style) {
                    ?>
                    <option value="<?php echo  esc_attr($style);?>" 
                    <?php isset(self::$options['wp_ae_slider_style']) ? selected(  $style , self::$options['wp_ae_slider_style'], true ) : ''; ?> ><?php echo esc_html(ucfirst($style));?></option>
                    <?php 
                }
                ?>
                </select>
                <?php 
        }

        public function wp_ae_slider_validation($input){
            $new_input = array();
            foreach ($input as $key => $value) {
                switch ($key) {
                    case 'wp_ae_slider_title':
                        if(empty($value)){
                            $value = esc_html("Please add text her...");
                            add_settings_error( 'wp_ae_slider_options', 'wp_ae_slider_messsage', 'Title can not be empty', 'error' );
                        }
                        $new_input[$key] = sanitize_text_field($value);
                        break;
                    default:
                        $new_input[$key] = sanitize_text_field($value);
                        break;
                }
            }
            return $new_input;
        }
    }
}