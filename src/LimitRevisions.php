<?php

namespace SternerStuffWordPress;

use SternerStuffWordPress\Interfaces\FilterHookSubscriber;

/**
 * Only allow 3 revisions of posts to be saved
 */
class LimitRevisions implements FilterHookSubscriber {

	public static function get_filters() {
		return [
			'wp_revisions_to_keep' => 'wp_revisions_to_keep',
		];
	}

	public function wp_revisions_to_keep( $num ) {
		return 3;
	}
}
