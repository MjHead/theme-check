<?php
class TextdomainName implements themecheck {
	protected $error = array();

	function check( $php_files, $css_files, $other_files ) {

		$ret = true;

		global $themename;

		if ( 'blank' === $themename ) {
			return $ret;
		}

		$theme_data  = wp_get_theme( $themename );
		$text_domain = $theme_data->get( 'TextDomain' );

		checkcount();

		if ( $themename !== $text_domain ) {
			$this->error[] = sprintf(
				'<span class="tc-lead tc-warning">' . __( 'WARNING','theme-check' ) . '</span>: ' . __( 'Textdomain must be %1$s, your - %2$s.', 'theme-check' ),
				'<strong>' . $themename . '</strong>',
				'<strong>' . $text_domain . '</strong>'
			);
			$ret = false;
		}

		return $ret;
	}

	function getError() { return $this->error; }
}
$themechecks[] = new TextdomainName;
