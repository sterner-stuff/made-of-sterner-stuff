<?php 

namespace SternerStuffWordPress;

class CloudflareIps extends ProxyIps {

	public $endpoint = 'https://www.cloudflare.com/ips-v4';
	public $endpoint2 = 'https://www.cloudflare.com/ips-v6';
	public $slug = 'cloudflare';

	protected function toString( $ips ) {
		$ips = str_replace(PHP_EOL, ',', $ips);
		return $ips;
	}

	/**
	 * Overloaded to handle two endpoints
	 */
	protected function fetchIps() {
		$response_v4 = wp_remote_get( $this->endpoint );
		$response_v6 = wp_remote_get( $this->endpoint2 );
		$ips_v4 = wp_remote_retrieve_body( $response_v4 );
		$ips_v6 = wp_remote_retrieve_body( $response_v6 );
		$this->storeIps( $this->toString( $ips_v4 . $ips_v6 ) );
		return $ips;
	}

}