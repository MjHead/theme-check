<?php
class DeprecatedFunctions implements themecheck {

	protected $error = array();

	function check( $php_files, $css_files, $other_files ) {

		$ret = true;

		$deprecated_functions = array(
			'extract',
			'eval',
			'var_dump',
			'print_r',
		);

		foreach ( $php_files as $php_key => $phpfile ) {

			if ( false !== strpos( $php_key, 'cherry-framework' ) ) {
				continue;
			}

			foreach ( $deprecated_functions as $function ) {
				checkcount();
				if ( false !== strpos( $phpfile, $function . '(' ) ) {
					$filename = tc_filename( $php_key );
					$this->error[] = sprintf(
						'<span class="tc-lead tc-warning">' . __( 'WARNING','theme-check' ) . '</span>: ' . __( 'Function %1$s found %2$s. %1$s not allowed to use.', 'theme-check' ),
						'<strong>' . $function . '</strong>',
						'<strong>' . $filename . '</strong>'
					);
				}
			}
		}
		return $ret;
	}

	function getError() { return $this->error; }
}

$themechecks[] = new DeprecatedFunctions;
