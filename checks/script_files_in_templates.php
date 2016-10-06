<?php
class ScriptFilesInTemplates implements themecheck {

	protected $error = array();

	function check( $php_files, $css_files, $other_files ) {

		$ret = true;

		$checks = array(
			'/(\<link.+stylesheet.+?>)|(\<script.+src.+?>)/' => __( 'Do not use paste CSS and JS files directly into templates', 'theme-check' )
			);

		foreach ( $php_files as $php_key => $phpfile ) {

			if ( false !== strpos( $php_key, 'cherry-framework' ) || false !== strpos( $php_key, 'class-tgm-plugin-activation' ) ) {
				continue;
			}

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
			$this->error[] = sprintf('<span class="tc-lead tc-warning">'.__('WARNING','theme-check').'</span>: '.__('Script or stylesheet link was found in the file %1$s %2$s.', 'theme-check'), '<strong>' . $filename . '</strong>', $check ) ;
		}

	}

	function getError() { return $this->error; }
}

$themechecks[] = new ScriptFilesInTemplates;