<?php
class CustomizerDefaults implements themecheck {

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

		if ( ! function_exists( $prefix . '_get_customizer_options' ) ) {
			return $ret;
		}

		$options = call_user_func( $prefix . '_get_customizer_options' );

		if ( empty( $options ) || ! is_array( $options ) ) {
			return $ret;
		}

		$allowed = array(
			'retina_header_logo_url',
			'mailchimp_list_id',
			'mailchimp_api_key',
			'header_bg_image',
			'h6_letter_spacing',
			'h5_letter_spacing',
			'h4_letter_spacing',
			'h3_letter_spacing',
			'h2_letter_spacing',
			'h1_letter_spacing',
			'breadcrumbs_letter_spacing',
			'body_letter_spacing',
			'ads_post_before_content',
			'ads_post_before_comments',
			'ads_home_before_loop',
			'ads_header',
		);

		checkcount();

		foreach ( $options['options'] as $option => $val ) {

			if ( in_array( $option, $allowed ) ) {
				continue;
			}

			if ( 'control' === $val['type'] && ( ! isset( $val['default'] ) || '' === $val['default'] ) ) {
				$this->error[] = sprintf(
					'<span class="tc-lead tc-warning">' . __( 'WARNING','theme-check' ) . '</span>: ' . __( 'No default value for %1$s customizer option.', 'theme-check' ),
					'<strong>' . $option . '</strong>'
				);
			}
		}

		return $ret;
	}

	function getError() { return $this->error; }
}

$themechecks[] = new CustomizerDefaults;
