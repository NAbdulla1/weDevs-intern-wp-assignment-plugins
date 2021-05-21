<?php


namespace A15_Customer_Reg_Form;


class Installer {
	public function run() {
		$this->install_time();
		$this->create_customer_role();
		$this->create_customer_register_page();
	}

	private function install_time() {
		$installed = get_option( 'a15_customer_reg_form_installed', false );
		if ( ! $installed ) {
			update_option( 'a15_customer_reg_form_installed', time() );
		}
		update_option( 'a15_customer_reg_form_version', A15_CUSTOMER_REG_FORM_VERSION );
	}

	private function create_customer_role() {
		$capabilities = array( 'read' => true, );
		add_role( 'a15_crf_customer', __( 'Customer', A15_CUSTOMER_REG_FORM_TD ), $capabilities );
	}

	private function create_customer_register_page() {
		$page_slug    = get_option( 'a15_customer_reg_form_page_option', false );
		$page_content = file_get_contents( __DIR__ . "/views/customer_register_page.php" );
		$page_content = str_replace( '__action__', esc_url( admin_url( 'admin-post.php' ) ), $page_content );
		if ( false === $page_slug ) {
			$args    = array(
				'post_title'   => 'Register Customer',
				'post_name'    => 'a15-customer-reg-form-woeirundflsj',
				'post_content' => $page_content,
				'post_status'  => 'published',
				'post_author'  => 1,
				'post_type'    => 'page',
			);
			$page_id = wp_insert_post( $args );
			$slug    = get_post( $page_id )->post_name;
			update_option( 'a15_customer_reg_form_page_option', $slug );
			if ( is_wp_error( $page_id ) ) {
				//handle failed to create page
			}
		} else {
			$post    = get_posts( array( 'post_name' => $page_slug, 'post_type' => 'page', 'numberposts' => 1 ) );
			$id      = $post[0]->ID;
			$title   = $post[0]->post_title;
			$content = $page_content;
			$author  = $post[0]->post_author;
			$status  = $post[0]->post_status;
			$type    = $post[0]->post_type;
			$args    = array(
				'ID'           => $id,
				'post_title'   => $title,
				'post_name'    => $page_slug,
				'post_content' => $content,
				'post_status'  => $status,
				'post_author'  => $author,
				'post_type'    => $type,
			);
			wp_insert_post( $args );
		}
	}
}