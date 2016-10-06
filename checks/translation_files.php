<?php
class TranslationFiles implements themecheck {
	protected $error = array();

	function check( $php_files, $css_files, $other_files ) {

		$ret = true;

		global $themename;

		$theme_data  = wp_get_theme( $themename );
		$text_domain = $theme_data->get( 'TextDomain' );

		checkcount();

		foreach ( $other_files as $other_key => $otherfile ) {
			if ( false !== strpos( $other_key, '.pot' ) ) {
				$filename = basename( $other_key );
				if ( $filename !== $text_domain . '.pot' ) {
					$this->error[] = sprintf(
						'<span class="tc-lead tc-warning">' . __( 'WARNING','theme-check' ) . '</span>: ' . __( 'Transltion file must be named %1$s, your file named - %2$s.', 'theme-check' ),
						'<strong>' . $text_domain . '.pot</strong>',
						'<strong>' . $filename . '</strong>'
					);
					$ret = false;
				}
			}
		}

		return $ret;
	}

	function getError() { return $this->error; }
}
$themechecks[] = new TranslationFiles;
