<?php
class LowercaseFilenames implements themecheck {
	protected $error = array();

	function check( $php_files, $css_files, $other_files ) {

		$ret = true;
		$filenames = array();

		checkcount();

		foreach ( $other_files as $other_key => $otherfile ) {
			$filename = tc_filename( $other_key );
			if ( $filename !== strtolower( $filename ) ) {
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
