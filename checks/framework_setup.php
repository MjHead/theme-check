<?php
class FrameworkSetup implements themecheck {

	protected $error = array();

	function check( $php_files, $css_files, $other_files ) {

		$ret = true;
		global $chery_core_version;

		$message = '<span class="tc-lead tc-warning">' . __( 'WARNING','theme-check' ) . '</span>: ' . __( 'Cherry Framework not included correctly.', 'theme-check' );
		$message .= ' <strong>' . __( 'Ignore this, if you check not active theme!','theme-check' ) . '</strong>';

		if ( empty( $chery_core_version ) || ! is_array( $chery_core_version  ) ) {
			$this->error[] = $message;
			return false;
		}

		$chery_core_version = array_map( 'wp_normalize_path', $chery_core_version );

		global $themename;
		$theme_found = false;

		foreach ( $chery_core_version as $version => $path ) {
			if ( false !== strpos( $path, 'wp-content/themes/' . $themename ) ) {
				$theme_found = true;
			}
		}

		if ( ! $theme_found ) {
			$this->error[] = $message;
			$ret = false;
		}

		return $ret;
	}

	function getError() { return $this->error; }
}

$themechecks[] = new FrameworkSetup;
