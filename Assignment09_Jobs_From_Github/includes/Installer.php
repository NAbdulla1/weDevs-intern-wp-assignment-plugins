<?php

namespace A09_Jobs_From_Github;

use A09_Jobs_From_Github\Frontend\Page_Manager;

class Installer {

	public function run() {
		$this->store_version();
		new Page_Manager();
	}

	private function store_version() {
		$installed = get_option( 'a09_jobs_from_github_installed', false );
		if ( ! $installed ) {
			update_option( 'a09_jobs_from_github_installed', time() );
		}
		update_option( 'a09_jobs_from_github_version', A09_JOBS_FROM_GITHUB_VERSION );
	}
}
