<?php 

namespace SternerStuffWordPress\Complianz;

use SternerStuffWordPress\Interfaces\FilterHookSubscriber;

class DisableAutoUpdateWarning implements FilterHookSubscriber {

	public static function get_filters(): array {
		return [
			'cmplz_warning_types' => ['cmplz_warning_types', 15, ],
		];
	}

	/**
	 * Disable the auto-update warning for the Complianz plugin.
	 *
	 * @param array $warnings The warning types.
	 * @return array
	 */
	public function cmplz_warning_types($warnings) 
	{
		$key = 'auto-updates-not-enabled1';
		if( defined('DISALLOW_FILE_MODS') && \DISALLOW_FILE_MODS && isset($warnings[$key]) ) {
			unset($warnings[$key]);
		}
		return $warnings;
	}
}