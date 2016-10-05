<?php
class DeprecatedFiles implements themecheck {

	protected $error = array();

	function check( $php_files, $css_files, $other_files ) {

		$ret = true;

		$deprecated_files = array(
			'.gitignore',
			'.gitmodules',
			'README.md',
			'.jscsrc',
			'.jshintignore',
			'.travis.yml',
			'codesniffer.ruleset.xml',
			'README.md',
		);

		$deprecated_php = array(
			'cherry-page-builder.php',
		);

		foreach ( $other_files as $php_key => $phpfile ) {
			foreach ( $deprecated_files as $file ) {
				if ( false !== strpos( $php_key, $file ) ) {
					$this->error[] = sprintf(
						'<span class="tc-lead tc-warning">' . __( 'WARNING','theme-check' ) . '</span>: ' . __( 'File %1$s not allowed in theme.', 'theme-check' ),
						'<strong>' . $file . '</strong>'
					);
				}
			}
		}
		foreach ( $php_files as $php_key => $phpfile ) {
			foreach ( $deprecated_php as $file ) {
				if ( false !== strpos( $php_key, $file ) ) {
					$this->error[] = sprintf(
						'<span class="tc-lead tc-warning">' . __( 'WARNING','theme-check' ) . '</span>: ' . __( 'File %1$s not allowed in theme.', 'theme-check' ),
						'<strong>' . $file . '</strong>'
					);
				}
			}
		}
		return $ret;
	}

	function getError() { return $this->error; }
}

$themechecks[] = new DeprecatedFiles;
