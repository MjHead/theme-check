<?php
class CommentedCode implements themecheck {

	protected $error = array();

	function check( $php_files, $css_files, $other_files ) {

		$ret = true;

		global $commented_code;

		if ( empty( $commented_code ) ) {
			return $ret;
		}

		foreach ( $commented_code as $file ) {
			$this->error[] = sprintf(
				'<span class="tc-lead tc-warning">' . __('WARNING','theme-check') . '</span>: ' . esc_html__( 'Maybe commented code in %s', 'theme-check' ),
				'<strong>' . $file . '</strong>'
			);
		}

		return $ret;
	}

	/**
	 * Check matches
	 */
	public function check_comment( $matches ) {

		return '';

	}

	function getError() { return $this->error; }
}

$themechecks[] = new CommentedCode;
