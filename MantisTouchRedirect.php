<?php
# Copyright (c) 2014 Victor Boctor @ MantisHub.com
# Licensed under the MIT license

class MantisTouchRedirectPlugin extends MantisPlugin {
	function register() {
		$this->name = plugin_lang_get( 'title' );
		$this->description = plugin_lang_get( 'description' );
		$this->version = '1.0.0';
		$this->requires = array( 'MantisCore' => '1.3.0' );
		$this->author = 'Victor Boctor';
		$this->contact = 'https://github.com/mantishub/MantisTouchRedirect/';
		$this->url = 'http://www.mantishub.com';
		$this->page = 'config';
	}

	function config() {
		return array(
			'mantistouch_url' => '',
			);
	}

	function hooks() {
		return array(
			'EVENT_CORE_READY' => 'redirect',
		);
	}

	function redirect() {
		# Direct only if user is using a mobile browser.
		if ( !$this->is_mobile_browser() ) {
			return;
		}

		# Don't do fancy checks if plugin is loaded as part of API call, otherwise,
		# some of the functionality may fail.
		if ( strstr( $_SERVER['SCRIPT_NAME'], '/api/' ) !== false ) {
			return;
		}

		if ( !isset( $_SERVER['SCRIPT_NAME'] ) ) {
			return;
		}

		if ( strstr( $_SERVER['SCRIPT_NAME'], 'view.php' ) !== false ||
			 strstr( $_SERVER['SCRIPT_NAME'], 'bug_report_page.php' ) !== false ||
			 strstr( $_SERVER['SCRIPT_NAME'], 'bug_report_advanced_page.php' ) !== false ||
			 strstr( $_SERVER['SCRIPT_NAME'], 'bug_view_page.php' ) !== false ||
			 strstr( $_SERVER['SCRIPT_NAME'], 'bug_view_advanced_page.php' ) !== false ||
			 strstr( $_SERVER['SCRIPT_NAME'], 'login_page.php' ) !== false ||
			 strstr( $_SERVER['SCRIPT_NAME'], 'view_all_bug_page.php' ) !== false ||
			 strstr( $_SERVER['SCRIPT_NAME'], 'my_view_page.php' ) !== false ) {
			$t_mantistouch_url = plugin_config_get( 'mantistouch_url', '' );

			if ( empty( $t_mantistouch_url ) ) {
				$t_root = dirname( dirname( dirname( __FILE__ ) ) ) . '/';
				if ( file_exists( $t_root . 'm' ) ) {
					$t_mantistouch_url = $GLOBALS['g_path'] . 'm/';
				} else {
					$t_mantistouch_url = 'http://mantisbt.mobi/?url=%s';
				}
			}

			$t_url = sprintf( $t_mantistouch_url, $GLOBALS['g_path'] );

			$t_issue_id = '';
			if ( strstr( $_SERVER['SCRIPT_NAME'], 'view.php' ) !== false ) {
				$t_issue_id = (int)$_GET['id'];
			}
			else if ( strstr( $_SERVER['SCRIPT_NAME'], 'bug_view_page.php' ) !== false || strstr( $_SERVER['SCRIPT_NAME'], 'bug_view_advanced_page.php' ) !== false ) {
				$t_issue_id = (int)$_GET['bug_id'];
			}

			if ( !empty( $t_issue_id ) )  {
				if ( strstr( $t_url, 'url=' ) !== false ) {
					$t_url .= '&issue_id=' . $t_issue_id;
				} else {
					$t_url .= '?issue_id=' . $t_issue_id;
				}
			}

			$t_use_iis = isset( $GLOBALS['use_iis'] ) && $GLOBALS['use_iis'] == ON;

			if ( !$t_use_iis ) {
				header( 'Status: 302' );
			}

			header( 'Content-Type: text/html' );

			if ( $t_use_iis ) {
				header( "Refresh: 0;$t_url" );
			} else {
				header( "Location: $t_url" );
			}

			exit; # additional output can cause problems so let's just stop output here
		}
	}

	/**
	 * Detects if it's mobile browser
	 * Source: http://www.dannyherran.com/2011/02/detect-mobile-browseruser-agent-with-php-ipad-iphone-blackberry-and-others/
	 * @return boolean<p>True if Mobile Browser, False on PC Browser</p>
	 */
	function is_mobile_browser() {
		$_SERVER['ALL_HTTP'] = isset( $_SERVER['ALL_HTTP'] ) ? $_SERVER['ALL_HTTP'] : '';

		$t_mobile_browser = false;

		$t_agent = strtolower( $_SERVER['HTTP_USER_AGENT'] );

		if ( preg_match( '/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|iphone|ipad|ipod|android|xoom)/i', $t_agent ) ) {
			$t_mobile_browser = true;
		}

		if ( ( isset( $_SERVER['HTTP_ACCEPT'] ) ) && ( strpos( strtolower( $_SERVER['HTTP_ACCEPT'] ), 'application/vnd.wap.xhtml+xml' ) !== false ) ) {
			$t_mobile_browser = true;
		}

		if ( isset( $_SERVER['HTTP_X_WAP_PROFILE'] ) ) {
			$t_mobile_browser = true;
		}

		if ( isset( $_SERVER['HTTP_PROFILE'] ) ) {
			$t_mobile_browser = true;
		}

		$t_mobile_ua = substr( $t_agent, 0, 4 );
		$t_mobile_agents = array(
			'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
			'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
			'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
			'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
			'newt','noki','oper','palm','pana','pant','phil','play','port','prox',
			'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
			'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
			'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
			'wapr','webc','winw','xda','xda-'
		);

		if ( in_array( $t_mobile_ua, $t_mobile_agents ) ) {
			$t_mobile_browser = true;
		}

		if ( strpos( strtolower( $_SERVER['ALL_HTTP'] ), 'operamini' ) !== false ) {
			$t_mobile_browser = true;
		}

		// Pre-final check to reset everything if the user is on Windows
		if ( strpos( $t_agent, 'windows' ) !== false ) {
			$t_mobile_browser = false;
		}

		// But WP7 is also Windows, with a slightly different characteristic
		if ( strpos( $t_agent, 'windows phone' ) !== false ) {
			$t_mobile_browser = true;
		}

		return $t_mobile_browser;
	}
}
