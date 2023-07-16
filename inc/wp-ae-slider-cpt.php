<?php

if (!class_exists('WP_AE_Slider_CPT')) {
    class WP_AE_Slider_CPT{
        function __construct()
        {
            add_action( 'init', array( $this,'create_cpt' ));
            add_action( 'add_meta_boxes', array( $this,'add_slider_meta_boxes' ));
            add_action( 'save_post', array( $this,'save_post_slider' ), 10, 2);
            add_filter( 'manage_wp-ae-slider_posts_columns', array( $this,'wp_ae_slider_cpt_columns' ));
            add_action( 'manage_wp-ae-slider_posts_custom_column', array( $this,'wp_ae_slider_cpt_custom_columns' ), 10, 2);
            add_filter( 'manage_edit-wp-ae-slider_sortable_columns', array( $this,'wp_ae_slider_sortable_cpt_columns' ));
        }

        public function create_cpt(){
            register_post_type( 'wp-ae-slider', array(
                'label'                =>__('Slider'),
                'description'          =>__('Sliders CPT'),
                'labels'               =>array(
                                            'name'=>__('Sliders'),
                                            'singular_name'=>__('Slider')
                                        ),
                'public'               =>true,
                'supports'             => array( 'title', 'editor', 'thumbnail'),
                'show_in_rest'         => true,
                'publicly_queryable'   => true,
                'show_ui'              => true,
                'show_in_menu'         => false,
                'can_export'           => true,
                'has_archive'          => false,
                'hierarchical'         => false,
                'menu_position'        => 5,
                'show_in_admin_bar'    => true,
                'show_in_nav_menus'    => true,
                'exclude_from_search'  => false,
                'menu_icon' => 'dashicons-images-alt2'
        
            ) );
        }

        public function add_slider_meta_boxes(){
            add_meta_box( 
                'wp_ae_slider_meta_boxes', 
                __('Slider Link'), 
                array($this, 'wp_ae_slider_meta_boxe_form'), 
                'wp-ae-slider', 
                'normal', 
                'high');
        }

        public function wp_ae_slider_meta_boxe_form($post){
            require_once(WP_AE_Slider_PATH . 'inc/wp-ae-slider-metabox-form.php');
        }

        public function save_post_slider($post_id){
            //verify nonce token
            if (isset($_POST['wp_ae_slider_nonce'])) {
                if (!wp_verify_nonce( $_POST['wp_ae_slider_nonce'] , 'wp_ae_slider_nonce' )) {
                    return;
                }
            }
            //Prevent auto save
            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
                return;
            }
            //verify who can edit cpt
            if (isset($_POST['post_type']) && $_POST['post_type'] = 'wp_ae_slider') {
                if (!current_user_can('edit_page', $post_id)) {
                    return;
                }
                if (!current_user_can('edit_post', $post_id)) {
                    return;
                }
            }

            if (isset($_POST['action']) && $_POST['action'] == 'editpost') {
                $old_slider_link_text = get_post_meta($post_id, 'wp_ae_slider_link_text', true);
                $new_slider_link_text = $_POST['wp_ae_slider_link_text'];
                $old_slider_link_url = get_post_meta($post_id, 'wp_ae_slider_link_url', true);
                $new_slider_link_url = $_POST['wp_ae_slider_link_url'];

                if (empty($new_slider_link_text)) {
                    update_post_meta($post_id, 'wp_ae_slider_link_text', 'Add link text');
                }else{
                    update_post_meta($post_id, 'wp_ae_slider_link_text', sanitize_text_field($new_slider_link_text), $old_slider_link_text);
                }

                if (empty($new_slider_link_url)) {
                    update_post_meta($post_id, 'wp_ae_slider_link_url', '#');
                }else{
                    update_post_meta($post_id, 'wp_ae_slider_link_url', esc_url_raw($new_slider_link_url), $old_slider_link_url);
                }
            }
        }

        public function wp_ae_slider_cpt_columns($columns){
            $columns['wp_ae_slider_link_text'] = esc_html__( 'Link Text', 'wp-ae-slider');
            $columns['wp_ae_slider_link_url'] = esc_html__( 'Link URL', 'wp-ae-slider');
            return $columns;
        }

        public function wp_ae_slider_cpt_custom_columns($columns, $post_id){
            switch ($columns) {
                case 'wp_ae_slider_link_text':
                    echo esc_html( get_post_meta( $post_id, 'wp_ae_slider_link_text', true ) );
                    break;
                
                case 'wp_ae_slider_link_url':
                    echo esc_url( get_post_meta( $post_id, 'wp_ae_slider_link_url', true ) );
                    break;
            }
        }

        public function wp_ae_slider_sortable_cpt_columns($columns){
            $columns['wp_ae_slider_link_text'] = 'wp_ae_slider_link_text';
            $columns['wp_ae_slider_link_url'] = 'wp_ae_slider_link_url';
            return $columns;
        }
    }
}