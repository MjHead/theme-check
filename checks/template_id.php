<?php
class TemplateId implements themecheck {

	protected $error = array();

	function check( $php_files, $css_files, $other_files ) {

		global $data, $themename;

		$theme_data = wp_get_theme( $themename );
		$tex_domain = $theme_data->get( 'TextDomain' );

		$ret = true;

		checkcount();

		foreach ( $css_files as $css_key => $cssfile ) {
			if ( false !== strpos( $css_key, 'style.css' ) ) {

				$filedata = get_file_data(
					$css_key,
					array( 'template_id' => 'Template Id' )
				);

				if ( empty( $filedata['template_id'] ) ) {

						$this->error[] = '<span class="tc-lead tc-warning">' . __( 'WARNING','theme-check' ) . '</span>: ' . __( 'Template Id header in style.css are empty or not exists.', 'theme-check' );

				}

				return;
			}
		}
		return $ret;
	}

	function getError() { return $this->error; }
}

$themechecks[] = new TemplateId;
