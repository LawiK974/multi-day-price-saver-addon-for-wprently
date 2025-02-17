<?php

if( ! defined('ABSPATH') ){die('exit');}
if( ! class_exists('RBFW_Additional_Day_Price') ){
    class RBFW_Additional_Day_Price{
        public function __construct()
        {
            add_action( 'rbfw_after_general_price_table', [$this,'rbfw_additional_day_price'], 10, 1 );
            add_action( 'save_post', [$this,'rbfw_rbfw_additional_day_price_save'], 20, 1 );
        }

        public function section_header(){
            ?>
                <h2 class="mp_tab_item_title"><?php echo esc_html__('Additional Day Price Configuration', 'multi-day-price-saver-addon-for-wprently' ); ?></h2>
                <p class="mp_tab_item_description"><?php echo esc_html__('Here you can configure Additional Day price.', 'multi-day-price-saver-addon-for-wprently' ); ?></p>

            <?php
        }

        public function panel_header($title,$description){
            ?>
                <section class="bg-light mt-5">
                    <div>
                        <label>
                            <?php echo sprintf(__("%s",'booking-and-rental-manager-for-woocommerce'), $title ); ?>
                        </label>
                        <span><?php echo sprintf(__("%s",'booking-and-rental-manager-for-woocommerce'), $description ); ?></span>
                    </div>
                </section>
            <?php
        }

        public function rbfw_additional_day_price( $post_id ) {
            ?>
            <div class="mp_settings_area mpStyle rbfw_seasonal_price_config_wrapper">
                <?php $this->panel_header('Additional Day Price','Additional Day Price'); ?>
                <section>
                    <div class="w-100">
                        <div class="mp_item_insert ">
                            <?php
                                $additional_day_prices = get_post_meta( $post_id, 'rbfw_additional_day_prices', true ) ? get_post_meta( $post_id, 'rbfw_additional_day_prices', true ) : [];



                                if ( sizeof( $additional_day_prices ) > 0 ) {
                                    foreach ( $additional_day_prices as $prices ) {
                                        $this->rbfw_after_week_price_table_seasonal_price_item( $prices );
                                    }
                                }
                            ?>
                        </div>
                        <p>
                            <span class="ppof-button mp_add_item">
                                <i class="fa-solid fa-circle-plus"></i>&nbsp;
                                <?php esc_html_e( 'Add New Additional Day Pricing', 'rbfw-sp' ); ?>
                            </span>
                        </p>
                    </div>
                    <div class="mp_hidden_content">
                        <div class="mp_hidden_item" >
                            <?php $this->rbfw_after_week_price_table_seasonal_price_item(); ?>
                        </div>
                    </div>
                </section>
            </div>
            <?php
        }

        public function rbfw_after_week_price_table_seasonal_price_item( $sp = array() ) {
            $rbfw_start_day =  isset($sp['rbfw_start_day'])?$sp['rbfw_start_day']:'';
            $rbfw_end_day   = isset($sp['rbfw_end_day'])?$sp['rbfw_end_day']:'';
            $rbfw_daily_price =  isset($sp['rbfw_daily_price'])?$sp['rbfw_daily_price']:'';
            ?>
            <section class="mp_remove_area">
                <div class="w-100 me-5">
                    <div class=" d-flex justify-content-between mb-2">
                        <div class="w-30 d-flex justify-content-between align-items-center">
                            <label for=""><?php esc_html_e( 'Start Day', 'rbfw-sp' ); ?></label>
                            <div class=" d-flex justify-content-between align-items-center">
                                <input class="formControl" name="rbfw_start_day[]" value="<?php echo esc_attr( $rbfw_start_day ); ?>"  placeholder="<?php esc_html_e( 'Start Day', 'multi-day-price-saver-addon-for-wprently' ); ?>"/>
                            </div>
                        </div>
                        <div class="w-30 ms-5 d-flex justify-content-between align-items-center">
                            <label for=""><?php esc_html_e( 'End Day', 'rbfw-sp' ); ?></label>
                            <div class=" d-flex justify-content-between align-items-center">
                                <input class="formControl" name="rbfw_end_day[]" value="<?php echo esc_attr( $rbfw_end_day ); ?>"  placeholder="<?php esc_html_e( 'End Day', 'multi-day-price-saver-addon-for-wprently' ); ?>"/>
                            </div>
                        </div>
                        <div class="w-30 ms-5 d-flex justify-content-between align-items-center">
                            <label for=""><?php esc_html_e( 'Daily Rate', 'rbfw-sp' ); ?></label>
                            <div class=" d-flex justify-content-between align-items-center">
                                <input class="formControl" name="rbfw_daily_price[]" value="<?php echo esc_attr( $rbfw_daily_price ); ?>" placeholder="<?php esc_html_e( 'Daily Rate', 'rbfw-sp' ); ?>"/>
                            </div>
                        </div>
                    </div>
                </div>
                <span class="button " onclick="jQuery(this).parent().remove()"><i class="fa-solid fa-trash-can"></i></span>
            </section>
            <?php
        }


        public function rbfw_rbfw_additional_day_price_save( $post_id ) {
            if ( get_post_type( $post_id ) == 'rbfw_item' ) {

                $rules = [
                    'name' => 'sanitize_text_field',
                    'email' => 'sanitize_email',
                    'age' => 'absint',
                    'preferences' => [
                        'color' => 'sanitize_text_field',
                        'notifications' => function ($value) {
                            return $value === 'yes' ? 'yes' : 'no';
                        }
                    ]
                ];
                $input_data_sabitized = sanitize_post_array($_POST, $rules);


                $additional_day_price        = array();
                $rbfw_start_day = isset( $input_data_sabitized['rbfw_start_day'] ) ?  $input_data_sabitized['rbfw_start_day']  : [];
                $rbfw_end_day = isset( $input_data_sabitized['rbfw_end_day'] ) ?  $input_data_sabitized['rbfw_end_day']  : [];
                $rbfw_daily_price = isset( $input_data_sabitized['rbfw_daily_price'] ) ?  $input_data_sabitized['rbfw_daily_price']  : [];

                $count         = count( $rbfw_start_day);

                if ( $count > 1 ) {
                    for ( $i = 0; $i < $count; $i ++ ) {
                        if ( $rbfw_start_day[ $i ] && $rbfw_start_day[ $i ] &&  $rbfw_start_day[ $i ]  <=  $rbfw_end_day[ $i ] ) {
                            $additional_day_price[ $i ]['rbfw_start_day'] = $rbfw_start_day[ $i ];
                            $additional_day_price[ $i ]['rbfw_end_day']   = $rbfw_end_day[ $i ];
                            $additional_day_price[ $i ]['rbfw_daily_price'] = $rbfw_daily_price[ $i ];
                        }
                    }
                }

                if ( ! empty( $additional_day_price ) ) {
                    update_post_meta( $post_id, 'rbfw_additional_day_prices', $additional_day_price );
                }
            }
        }
    }
    $seasonal_prices = new RBFW_Additional_Day_Price();
}



