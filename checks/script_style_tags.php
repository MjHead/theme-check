<?php
class ScriptStyleTags implements themecheck {

	protected $error = array();

	function check( $php_files, $css_files, $other_files ) {

		$ret = true;

		$checks = array(
			'/(\<script(.|\n)*?\<\/script\>)|(\<style(.|\n)*?\<\/style\>)/' => __( 'Do not use <b>script</b> and <b>style</b> tags in template files', 'theme-check' )
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
						'<span class="tc-lead tc-warning">' . __( 'WARNING','theme-check' ) . '</span>: ' . __( 'Script or Style tags was found in the file %1$s.', 'theme-check' ),
						'<strong>' . $filename . '</strong>'
					);
				}
			}
		}
		return $ret;
	}

	function getError() { return $this->error; }
}

$themechecks[] = new ScriptStyleTags;