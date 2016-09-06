<?php
class EmptyTranslations implements themecheck {

	protected $error = array();

	function check( $php_files, $css_files, $other_files ) {

		$ret = true;

		$checks = array(
			'/(_[_e]\(\s?[\'\"][\'\"])/' => __( 'Translation string can\'t be empty', 'theme-check' )
		);

		foreach ( $php_files as $php_key => $phpfile ) {
			foreach ( $checks as $key => $check ) {
				checkcount();
				if ( preg_match_all( $key, $phpfile, $matches ) ) {
					$this->add_errors( $matches, $check, $php_key );
				}
			}
		}
		return $ret;
	}

	/**
	 * Adds all breadcrums errors
	 */
	function add_errors( $matches, $check, $php_key ) {

		if ( empty( $matches[1] ) ) {
			return;
		}

		foreach ( $matches[1] as $match ) {

			$filename = tc_filename( $php_key );
			$error    = ltrim( $match, '(' );
			$error    = rtrim( $error, '(' );
			$grep     = tc_grep( $error, $php_key );

			$this->error[] = sprintf(
				'<span class="tc-lead tc-warning">'.__('WARNING','theme-check').'</span>: '.__('Empty translation string was found in the file %1$s %2$s.%3$s', 'theme-check'),
				'<strong>' . $filename . '</strong>',
				$check,
				$grep
			);
		}

	}

	function getError() { return $this->error; }
}

$themechecks[] = new EmptyTranslations;
