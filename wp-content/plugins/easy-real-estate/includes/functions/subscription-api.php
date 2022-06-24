<?php

if ( ! class_exists( 'ERE_Subscription_API' ) ) {
	class ERE_Subscription_API {

		public $subscription_id;

		static $status;

		public function __construct() {

			$this->subscription_id = new ERE_Purchase_API();

			if ( ! wp_next_scheduled( 'ere_subscription_api' ) ) {
				wp_schedule_event( time(), 'ere-subscription-interval', 'ere_subscription_api' );
			}

			add_filter( 'cron_schedules', array( $this, 'subscription_recurrence' ) );
			add_filter( 'ere_subscription_api', array( $this, 'subscription_registration' ) );

			self::$status = $this->subscription_id::status();
		}

		static function status() {
			return self::$status;
		}

		public function subscription_registration() {

			$existing_purchase_code = get_option( 'envato_purchase_code_5373914' );
		
			if ( ! empty( $existing_purchase_code ) ) {
				$item_purchase = $this->subscription_id->verify_purchase_code( $existing_purchase_code );
		
				if ( is_wp_error( $item_purchase ) || true !== $item_purchase ) {
		
					$verification_attempt = get_option( 'ere_subscription_attempt', 'ere-subscription-interval' );
					if ( empty( $verification_attempt ) || 'ere-subscription-interval' === $verification_attempt ) {
						update_option( 'ere_subscription_attempt', 'first_24hrs' );
						wp_clear_scheduled_hook( 'ere_subscription_api' );
						wp_schedule_event( strtotime( '10am tomorrow' ), 'daily', 'ere_subscription_api' );
					} elseif ( 'first_24hrs' === $verification_attempt ) {
						update_option( 'ere_subscription_attempt', 'second_24hrs' );
						wp_clear_scheduled_hook( 'ere_subscription_api' );
						wp_schedule_event( strtotime( '10am tomorrow' ), 'daily', 'ere_subscription_api' );
					} elseif ( 'second_24hrs' === $verification_attempt ) {
						update_option( 'ere_subscription_attempt', 'reset_data' );
						wp_clear_scheduled_hook( 'ere_subscription_api' );
						wp_schedule_event( strtotime( '10am tomorrow' ), 'daily', 'ere_subscription_api' );
					} else {
						delete_option( 'envato_purchase_code_5373914' );
						delete_option( 'inspiry_realhomes_registered' );
						update_option( 'ere_subscription_attempt', 'ere-subscription-interval' );
						update_option( 'realhomes_verification_attempt_notice', 'true' );
						wp_clear_scheduled_hook( 'ere_subscription_api' );
					}
				}
			} else {
				delete_option( 'inspiry_realhomes_registered' );
			}
		}

		public function subscription_recurrence( $schedules ) {
			$schedules['ere-subscription-interval'] = array(
				'display'  => esc_html__( 'ERE Subscription Interval', 'easy-real-estate' ),
				'interval' => 604800,
			);
			return $schedules;
		}
	}

}

new ERE_Subscription_API();
