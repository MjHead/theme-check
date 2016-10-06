<?php
class GetTextUsage implements themecheck {

	protected $error = array();

	function check( $php_files, $css_files, $other_files ) {

		global $data, $themename;

		$theme_data = wp_get_theme( $themename );
		$tex_domain = $theme_data->get( 'TextDomain' );

		$ret = true;

		if ( ! $tex_domain ) {
			return $ret;
		}

		$prefix = str_replace( '-', '_', strtolower( $tex_domain ) );

		$checks = array(
			'/_[_e]\([\s]?[\'\"](\<\w|[a-zA-Z ]*\<\w)/' => __( 'HTML not allowed in translation functions.', 'theme-check' ),
			'/_[_e]\([\s]?[\'\"](\$\w|[a-zA-Z ]*\$\w)/' => __( 'Variables not allowed in translation functions.', 'theme-check' ),
			'/_[_e]\([\s]?[\'\"].*?[\'\"]\,[\s]?[a-zA-Z\$]*[\s]?\)/' => __( 'Variables and constants not allowed as textdomain.', 'theme-check' ),
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
						'<span class="tc-lead tc-warning">' . __( 'WARNING','theme-check' ) . '</span>: ' . __( 'Maybe wrong translation function usage in %1$s. %2$s', 'theme-check' ),
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

$themechecks[] = new GetTextUsage;
