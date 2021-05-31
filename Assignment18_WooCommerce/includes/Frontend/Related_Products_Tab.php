<?php


namespace A18_WooCommerce\Frontend;

/**
 *
 * Class Related_Products_Tab
 *
 * @package A18_WooCommerce\Frontend
 */
class Related_Products_Tab {
	/**
	 * Constructor
	 */
	public function __construct() {
		add_filter( 'woocommerce_product_tabs', array( $this, 'related_products_tab' ) );
	}

	/**
	 * Products Tab callback
	 *
	 * @param [array] $tabs array of available tabs.
	 * @return array
	 */
	public function related_products_tab( $tabs ) {
		$tabs['a18_wc_rpt'] = array(
			'title'    => __( 'Related Products', 'a18-woocommerce-td' ),
			'callback' => array( $this, 'tab_content' ),
		);

		return $tabs;
	}

	/**
	 * A function to prepare and render content of the tab
	 *
	 * @param [string] $slug slug of the page.
	 * @param [string] $tab the tab name.
	 * @return void
	 */
	public function tab_content( $slug, $tab ) {
		global $product;
		$categories = get_the_terms( $product->get_id(), 'product_cat' );
		$categories = array_map( fn( $cat ) => $cat->name, $categories );
		$args       = wc_get_products(
			array(
				'status'    => 'publish',
				'post_type' => 'product',
				'category'  => $categories,
				'limit'     => 5,
				'orderby'   => 'rand',
				'exclude'   => array( $product->get_id() ),
			)
		);
		?>
		<div style="display: flex; flex-wrap: wrap">
			<?php
			if ( count( $args ) === 0 ) {
				echo '<h3>No other products found</h3>';
			} else {
				foreach ( $args as $rp ) {
					$url         = wp_get_attachment_image_url( $rp->get_image_id(), );
					$description = $rp->get_description();
					$name        = $rp->get_name();
					?>
					<div style="width: 48%; padding: 1%; margin: 1%; border: 1px black dashed; border-radius: 5px">
						<img style="width: 100%; padding: 1%; object-fit: contain" src="<?php echo esc_attr( $url ); ?>"
							alt="product"/>
						<p><a href="/product/<?php echo esc_attr( $rp->get_slug() ); ?>"> <?php echo esc_html( $name ); ?></a></p>
						<p style="overflow: hidden;
								text-overflow: ellipsis;
								display: -webkit-box;
								-webkit-line-clamp: 4;
								-webkit-box-orient: vertical;
								text-align: justify"><?php echo esc_attr( $description ); ?></p>
					</div>
					<?php
				}
			}
			?>
		</div>
		<?php
	}
}
