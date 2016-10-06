<?php
class CheckFrameworkVersion implements themecheck {

	protected $error  = array();
	protected $api    = 'https://raw.githubusercontent.com/CherryFramework/cherry-framework/%s/config.json';
	protected $branch = 'master';


	function check( $php_files, $css_files, $other_files ) {

		$config = get_transient( 'framework-config' );
		if ( ! $config ) {
			$response = wp_remote_get( esc_url( sprintf( $this->api, $this->branch ) ) );
			$config   = wp_remote_retrieve_body( $response );
			$config = json_decode( $config, true );
			set_transient( 'framework-config', $config, DAY_IN_SECONDS / 2 );
		}

		$this->check_framework_version( $config );
		$this->check_modules_version( $config );

		$ret = true;

		return $ret;
	}

	function theme_path( $path = null ) {
		global $themename;
		$root = get_theme_root( $themename ) . "/$themename";

		if ( $path ) {
			return trailingslashit( $root ) . $path;
		} else {
			return $root;
		}
	}

	/**
	 * Check if theme contain outdated Cherry Modules.
	 *
	 * @param  array $config Framework config data
	 * @return void
	 */
	function check_modules_version( $config ) {

		if ( empty( $config['modules'] ) ) {
			return;
		}

		foreach ( $config['modules'] as $module => $actual_data ) {

			$file = $this->theme_path( sprintf( 'cherry-framework/modules/%1$s/%1$s.php', $module ) );

			if ( ! file_exists( $file ) || empty( $actual_data['version'] ) ) {
				continue;
			}

			$user_data = get_file_data( $file, array( 'version' => 'Version' ) );

			if ( empty( $user_data['version'] ) ) {
				$user_data['version'] = '1.0.0';
			}

			$is_actual = version_compare( $actual_data['version'], $user_data['version'], '==' );

			if ( $is_actual ) {
				continue;
			}

			$this->error[] = sprintf( '<span class="tc-lead tc-warning">'.__('WARNING','theme-check').'</span>: '.__('You use <strong>%1$s</strong> module version <strong>%2$s</strong>. Actual version is <strong>%3$s</strong>', 'theme-check'), $module, $user_data['version'], $actual_data['version'] );
		}

	}

	/**
	 * Check if theme contain outdated Cherry Framework version
	 *
	 * @param  array $config Framework config data
	 * @return void
	 */
	function check_framework_version( $config ) {

		if ( empty( $config['version'] ) ) {
			return;
		}

		$core = $this->theme_path( 'cherry-framework/cherry-core.php' );

		if ( ! file_exists( $core ) ) {
			return;
		}

		$data = get_file_data( $core, array( 'version' => 'Version' ) );

		if ( empty( $data['version'] ) ) {
			$data['version'] = '1.0.0';
		}

		$is_actual = version_compare( $config['version'], $data['version'], '==' );

		if ( $is_actual ) {
			return;
		}

		$this->error[] = sprintf( '<span class="tc-lead tc-warning">'.__('WARNING','theme-check').'</span>: '.__('You use framework version <strong>%1$s</strong>. Actual version is <strong>%2$s</strong>', 'theme-check'), $data['version'], $config['version'] );
	}

	function getError() { return $this->error; }
}

$themechecks[] = new CheckFrameworkVersion;
