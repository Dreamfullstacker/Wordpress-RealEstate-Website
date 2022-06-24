<?php
/**
 * Contains Operating_System_Browser Class.
 *
 * @since 3.10
 * @package easy_real_estate
 */

/**
 * This class provides Opertaing System and browser informatoin.
 */
class Operating_System_Browser {

	/**
	 * User agent information.
	 *
	 * @var string $agent
	 */
	private $agent = '';

	/**
	 * Operating System and browser informatoin.
	 *
	 * @var array $info
	 */
	private $info = array();

	/**
	 * Set new instance data.
	 */
	public function __construct() {
		$this->agent = isset( $_SERVER['HTTP_USER_AGENT'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_USER_AGENT'] ) ) : null;
		$this->get_browser();
		$this->get_os();
	}

	/**
	 * Return browser Information.
	 */
	public function get_browser() {
		$browser = array(
			'Internet Explorer' => 'MSIE',
			'Edge'              => 'Edge',
			'Firefox'           => 'Firefox',
			'Opera'             => 'OPR',
			'Chrome'            => 'Chrome',
			'Safari'            => 'Safari',
		);

		foreach ( $browser as $key => $value ) {
			if ( preg_match( '/' . $value . '/i', $this->agent ) ) {
				$this->info = array_merge( $this->info, array( 'browser' => $key ) );
				$this->info = array_merge( $this->info, array( 'browser_id' => $value ) );
				$this->info = array_merge( $this->info, array( 'version' => $this->get_version() ) );
				break;
			} else {
				$this->info = array_merge( $this->info, array( 'browser' => 'Unknown' ) );
				$this->info = array_merge( $this->info, array( 'version' => 'Unknown' ) );
			}
		}

		return $this->info['browser'];
	}

	/**
	 * Return Operating System Information.
	 */
	public function get_os() {
		$os = array(
			// mobile.
			'Android'        => '/Android/i',
			'iPad'           => '/iPad;/i',
			'iPhone'         => '/iPhone;/i',
			'BlackBerry'     => '/BlackBerry/i',
			'Windows Mobile' => '/Windows Mobile;/i',
			// desktop.
			'Windows'        => '/Windows NT/i',
			'Linux'          => '/Linux/i',
			'Unix'           => '/Unix/i',
			'MacOS'          => '/Macintosh;/i',
			'ChromeOS'       => '/crOS/i',
		);

		foreach ( $os as $key => $value ) {
			if ( preg_match( $value, $this->agent ) ) {
				$this->info = array_merge( $this->info, array( 'os' => $key ) );
				break;
			} else {
				$this->info = array_merge( $this->info, array( 'os' => 'Unknown' ) );
			}
		}

		return $this->info['os'];
	}

	/**
	 * Return browser version.
	 */
	public function get_version() {
		$browser_id = $this->info['browser_id'];
		$string     = $this->agent;

		if ( 'Safari' === $browser_id ) {
			$browser_id = 'Version';
		}

		preg_match_all( '/' . $browser_id . '\/[\d.]+/', $string, $match );
		return empty( $match[0][0] ) ? 'Unknown' : str_replace( $browser_id . '/', '', $match[0][0] );
	}

	/**
	 * Return Operating System and browser information.
	 *
	 * @param string $switch Type of needed information.
	 */
	public function show_info( $switch ) {
		$switch = strtolower( $switch );
		switch ( $switch ) {
			case 'browser':
				return $this->info['browser'];
			case 'os':
				return $this->info['os'];
			case 'version':
				return $this->info['version'];
			case 'all':
				return array(
					$this->info['version'],
					$this->info['os'],
					$this->info['browser'],
				);
			default:
				return 'Unknown';

		}
	}
}
