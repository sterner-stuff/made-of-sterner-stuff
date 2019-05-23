<?php

namespace SternerStuffWordPress;

/**
 * Only allow 3 revisions of posts to be saved
 */
class LimitRevisions {
	function __construct() {
		add_filter( 'wp_revisions_to_keep', [$this, 'wp_revisions_to_keep'], 10, 2 );
	}

	public function wp_revisions_to_keep($num, $post) {
		return 3;
	}
}
