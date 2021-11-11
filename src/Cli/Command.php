<?php 

namespace SternerStuffWordPress\Cli;

abstract class Command {

	public $name;

	/**
	 * Optional args
	 * public $args = [
		@type callable $before_invoke Callback to execute before invoking the command.
		@type callable $after_invoke Callback to execute after invoking the command.
		@type string $shortdesc Short description (80 char or less) for the command.
		@type string $longdesc Description of arbitrary length for examples, etc.
		@type string $synopsis The synopsis for the command (string or array).
		@type string $when Execute callback on a named WP-CLI hook (e.g. before_wp_load).
		@type bool $is_deferred Whether the command addition had already been deferred.
	 * ];
	 */

	public static function register() {
		$instance = new static;
		\WP_CLI::add_command( $instance->name, $instance, $instance->args ?? null );
	}

}