<?php 

namespace SternerStuffWordPress;

class FastlyIps extends ProxyIps {

	public $endpoint = 'https://api.fastly.com/public-ip-list';
	public $slug = 'fastly';

	protected function toString( $ips ) {
		$ips = json_decode( $ips, true );
		$ips_string = implode(',', $ips['addresses']) . ',' . implode(',', $ips['ipv6_addresses']);
		return $ips_string;
	}

}