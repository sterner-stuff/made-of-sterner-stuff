<?php

namespace SternerStuffWordPress;

use Roots\WPConfig\Config;

abstract class ProxyIps {

	public $endpoint;
	public $slug;

	/**
	 * Format the proxy API response for the WPFail2Ban constant
	 * 
	 * @param $ips The unformatted response from the proxy's API
	 * @return A comma-seperated string of IP addresses and ranges
	 */
	abstract protected function toString( $ips );

	public function __construct() {

		Config::define( 'WP_FAIL2BAN_PROXIES', $this->getIps() );

		/**
		 * Apply new constants
		 */
		Config::apply();
	}

	/**
	 * Retrieve IP addresses from transient
	 */
	protected function getIps() {
		$ips = ( get_transient( $this->slug . '_ips' ) ?: $this->fetchIps() );
		return $ips;
	}

	/**
	 * Fetch IP addresses from source and store
	 */
	protected function fetchIps() {
		$response = wp_remote_get( $this->endpoint );
		$ips = wp_remote_retrieve_body( $response );
		$ips = $this->toString( $ips );
		$this->storeIps( $ips );
		return $ips;
	}

	/**
	 * Update transient with a set of IPs
	 */
	protected function storeIps( $ips ) {
		set_transient( $this->slug . '_ips', $ips, DAY_IN_SECONDS * 2 );
	}

}