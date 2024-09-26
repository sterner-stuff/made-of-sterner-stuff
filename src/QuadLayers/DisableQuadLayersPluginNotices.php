<?php 

namespace SternerStuffWordPress\QuadLayers;

use SternerStuffWordPress\Interfaces\FilterHookSubscriber;

class DisableQuadLayersPluginNotices implements FilterHookSubscriber {

	public static function get_filters(): array
	{
		return [
			'get_user_metadata' => ['disable_quadlayers_notice', 10, 3],
		];
	}

	public function disable_quadlayers_notice($value, $object_id, $meta_key) 
	{
		if(str_contains($meta_key, 'quadlayers') && str_contains($meta_key, '_notice_hidden_')) {
			return true;
		}

		return $value;
	}

}

