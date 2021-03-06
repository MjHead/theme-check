<?php
class Screenshot_Checks implements themecheck {
	protected $error = array();

	function check( $php_files, $css_files, $other_files ) {

		$ret = true;
		$filenames = array();

		checkcount();

		$screen_found = false;

		foreach ( $other_files as $other_key => $otherfile ) {

			if ( basename( $other_key ) === 'screenshot.png' || basename( $other_key ) === 'screenshot.jpg' ) {
				// we have or screenshot!
				$image = getimagesize( $other_key );
				$screen_found = true;

				if ( $image[0] > 1200 || $image[1] > 900 ) {
					$this->error[] = sprintf('<span class="tc-lead tc-warning">'. __( 'WARNING','theme-check' ) . '</span>: ' . __( 'Screenshot is wrong size! Detected: %1$sx%2$spx. Maximum allowed size is 1200x900px.', 'theme-check' ), '<strong>' . $image[0], $image[1] . '</strong>' );
				}
				if ( $image[1] / $image[0] != 0.75 ) {
					$this->error[] = '<span class="tc-lead tc-warning">'.__('WARNING','theme-check').'</span>: '.__('Screenshot dimensions are wrong! Ratio of width to height should be 4:3.', 'theme-check');
				}
				if ( $image[0] != 1200 || $image[1] != 900 ) {
					$this->error[] = '<span class="tc-lead tc-warning">'.__('WARNING','theme-check').'</span>: '.__('Screenshot size should be 1200x900, to account for HiDPI displays. Any 4:3 image size is acceptable, but 1200x900 is preferred.', 'theme-check');
				}

				return $ret;
			}
		}

		if ( false === $screen_found ) {
			$this->error[] = '<span class="tc-lead tc-warning">'.__('WARNING','theme-check').'</span>: '.__('No screenshot detected! Please include a screenshot.png or screenshot.jpg.', 'theme-check' );
			$ret = false;
		}

		return $ret;
	}

	function getError() { return $this->error; }
}
$themechecks[] = new Screenshot_Checks;
