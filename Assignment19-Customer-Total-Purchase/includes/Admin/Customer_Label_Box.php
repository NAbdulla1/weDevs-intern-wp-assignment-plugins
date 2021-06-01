<?php


namespace A19_Custom_Total_Purchase\Admin;

class Customer_Label_Box {
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'customer_label_box' ) );
	}

	public function customer_label_box() {
		add_meta_box(
			'a19_customer_total_purchase_box_1',
			'Customer Total Purchase',
			array( $this, 'box_content' ),
			'shop_order',
			'side',
			'high'
		);
	}

	public function box_content( \WP_Post $order ) {
		$order_id       = $order->ID;
		$customer_id    = get_post_meta( $order_id, '_customer_user', true );
		$total_purchase = $this->total_purchased_by_user( $customer_id );
		$label          = '';
		if ( $total_purchase > 10000 ) {
			$label = 'Diamond';
		} else if ( $total_purchase > 5000 ) {
			$label = 'Gold';
		} else if ( $total_purchase > 1000 ) {
			$label = 'Silver';
		}
		$user = get_user_by( 'ID', $customer_id );
		?>
        <div>
            <p>Customer Name:
				<?php if ( false === $user ) {
					echo 'Guest (anonymous user)';
				} else {
					echo $user->display_name;
				} ?>
            </p>
            <p>Total Purchase: <?php echo sprintf( "%.2f", $total_purchase ); ?>/-</p>
			<?php if ( ! empty( $label ) ) {
				?>
                <p>Customer Status: <?php echo $label ?></p>
				<?php
			} ?>
        </div>
		<?php
	}

	/**
	 * @param $customer_id
	 *
	 * @return double|mixed
	 */
	private function total_purchased_by_user( $customer_id ) {
		$all_orders_of_customer = wc_get_orders(
			array(
				'status__in' => array( 'wc-completed', 'wc-processing' ),
				'limit'      => - 1,
				'customer'   => $customer_id,
			)
		);

		$total_purchase = 0;
		foreach ( $all_orders_of_customer as $order ) {
			$total_purchase += $order->data['total'];
		}

		return $total_purchase;
	}
}
