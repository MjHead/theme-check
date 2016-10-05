<?php
class TGMPAVersion implements themecheck {

	protected $error = array();

	function check( $php_files, $css_files, $other_files ) {

		$ret = true;

		$tgmpa = get_transient( 'tgmpa' );

		if ( ! $tgmpa ) {

			$response = wp_remote_get( 'https://api.github.com/repos/TGMPA/TGM-Plugin-Activation/releases/latest' );
			$tgmpa    = wp_remote_retrieve_body( $response );
			$tgmpa    = json_decode( $tgmpa, true );

			if ( $tgmpa ) {
				set_transient( 'tgmpa', $tgmpa, 60*60*4 );
			}

		}

		if ( empty( $tgmpa ) || ! isset( $tgmpa['name'] ) ) {
			return $ret;
		}

		if ( ! class_exists( 'TGM_Plugin_Activation' ) || ! defined( 'TGM_Plugin_Activation::TGMPA_VERSION' ) ) {
			return $ret;
		}

		$result = version_compare( $tgmpa['name'], TGM_Plugin_Activation::TGMPA_VERSION, 'eq' );

		if ( ! $result ) {
			$this->error[] = sprintf(
				'<span class="tc-lead tc-warning">' . __( 'WARNING','theme-check' ) . '</span>: ' . __( 'Please use latest TGM Plugin Activation version. Latest version - %1$s. Your version - %2$s', 'theme-check' ),
				'<strong>' . $tgmpa['name'] . '</strong>',
				'<strong>' . TGM_Plugin_Activation::TGMPA_VERSION . '</strong>'
			);
		}

		return $ret;
	}

	function getError() { return $this->error; }
}

$themechecks[] = new TGMPAVersion;
