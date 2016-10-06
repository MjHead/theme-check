<?php
class BlankPrefixes implements themecheck {

	protected $error = array();

	function check( $php_files, $css_files, $other_files ) {

		$ret = true;

		global $themename;

		if ( 'blank' === $themename ) {
			return $ret;
		}

		$deprected_prefixes = array(
			'__tm',
		);

		foreach ( $php_files as $php_key => $phpfile ) {

			if ( false !== strpos( $php_key, 'cherry-framework' ) ) {
				continue;
			}

			foreach ( $deprected_prefixes as $prefix ) {
				checkcount();

				if ( false !== strpos( $phpfile, $prefix ) ) {
					$filename = tc_filename( $php_key );
					$this->error[] = sprintf(
						'<span class="tc-lead tc-warning">' . __( 'WARNING','theme-check' ) . '</span>: ' . __( 'Prefix %1$s was found in the file %2$s.', 'theme-check' ),
						'<strong>' . $prefix . '</strong>',
						'<strong>' . $filename . '</strong>'
					);
				}
			}
		}
		return $ret;
	}

	function getError() { return $this->error; }
}

$themechecks[] = new BlankPrefixes;