<?php
class SidebarExists implements themecheck {

	protected $error = array();

	function check( $php_files, $css_files, $other_files ) {

		$ret            = true;
		$sidebar_exists = false;

		checkcount();

		foreach ( $php_files as $php_key => $phpfile ) {
			if ( 'sidebar.php' === basename( $php_key ) ) {
				$sidebar_exists = true;
			}
		}

		if ( false === $sidebar_exists ) {
			$this->error[] = '<span class="tc-lead tc-warning">' . __( 'WARNING','theme-check' ) . '</span>: ' . __( '<strong>sidebar.php</strong> is required for all themes.', 'theme-check' );
		}

		return $ret;
	}

	function getError() { return $this->error; }
}

$themechecks[] = new SidebarExists;
