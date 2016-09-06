<?php
class RewriteBreadcrumbs implements themecheck {

	protected $error = array();

	function check( $php_files, $css_files, $other_files ) {

		$ret = true;

		$checks = array(
			'/add_filter\(\s?[\'\"](cherry_breadcrumb_args)|add_filter\(\s?[\'\"]([a-z\-\_0-9]+_breadcrumbs_settings)/' => __( 'Do not use filters for breadcrumbs in theme', 'theme-check' )
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

		unset( $matches[0] );

		foreach ( $matches as $match ) {

			$found = '';

			if ( ! empty( $match[0] ) ) {
				$found = $match[0];
			} elseif ( ! empty( $match[1] ) ) {
				$found = $match[1];
			}

			if ( ! $found ) {
				continue;
			}

			$filename = tc_filename( $php_key );
			$error = ltrim( $found, '(' );
			$error = rtrim( $error, '(' );
			$grep = tc_grep( $error, $php_key );
			$this->error[] = sprintf('<span class="tc-lead tc-warning">'.__('WARNING','theme-check').'</span>: '.__('%1$s was found in the file %2$s %3$s.%4$s', 'theme-check'), '<strong>' . $error . '</strong>', '<strong>' . $filename . '</strong>', $check, $grep ) ;
		}

	}

	function getError() { return $this->error; }
}

$themechecks[] = new RewriteBreadcrumbs;