<?php
class SprintfNoMacros implements themecheck {

	protected $error = array();

	function check( $php_files, $css_files, $other_files ) {

		global $data, $themename;

		$ret = true;

		$checks = array(
			'/[s]?printf\([\s]?[\'\"][^%]*?\)/' => __( 'Potentialy sprintf() or printf() without %s', 'theme-check' )
		);

		foreach ( $php_files as $php_key => $phpfile ) {

			if ( false !== strpos( $php_key, 'cherry-framework' ) || false !== strpos( $php_key, 'class-tgm-plugin-activation' ) ) {
				continue;
			}

			foreach ( $checks as $key => $check ) {
				checkcount();
				if ( preg_match_all( $key, $phpfile, $matches ) ) {
					$filename = tc_filename( $php_key );
					$this->error[] = sprintf(
						'<span class="tc-lead tc-warning">' . __( 'WARNING','theme-check' ) . '</span>: ' . __( '%2$s was found in the file %1$s.', 'theme-check' ),
						'<strong>' . $filename . '</strong>',
						$check
					);
				}
			}
		}
		return $ret;
	}

	function getError() { return $this->error; }
}

$themechecks[] = new SprintfNoMacros;
