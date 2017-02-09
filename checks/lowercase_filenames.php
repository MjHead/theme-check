<?php
class LowercaseFilenames implements themecheck {
	protected $error = array();

	function check( $php_files, $css_files, $other_files ) {

		$ret = true;

		checkcount();

		$allowed = array( 'README.md', 'LICENSE', '.git' );

		foreach ( $other_files as $other_key => $otherfile ) {

			$continue = false;

			foreach ( $allowed as $file ) {
				if ( false !== strpos( $other_key, $file ) ) {
					$continue = true;
				}
			}

			if ( $continue ) {
				continue;
			}

			$filename = tc_filename( $other_key );

			if ( $filename !== strtolower( $filename ) && ( ! in_array( $filename, $allowed ) ) ) {
				$this->error[] = sprintf(
					'<span class="tc-lead tc-warning">' . __('WARNING','theme-check') . '</span>: ' . __( '%1$s - only lowercase allowed in filenames.', 'theme-check' ),
					'<strong>' . $filename . '</strong>'
				);
			}
		}

		return $ret;
	}

	function getError() { return $this->error; }
}
$themechecks[] = new LowercaseFilenames;
