<?php 

namespace SternerStuffWordPress\Commands;

use WP_CLI;

class SyncDB extends Command
{

	public $name = 'sync-db';

	/**
     * Pulls production database using WP Migrate, if available
	 * * 
	 * ## OPTIONS
	 * 
	 * [--env=<env>]
	 * : The environment to sync with.
	 * ---
	 * default: prod
     */
	public function __invoke( $args, $assoc_args )
	{
		// If plugin isn't activated, we can handle that.
		$return = WP_CLI::runcommand('plugin is-active wp-migrate-db-pro', [
			'exit_error' => false,
			'return' => 'return_code',
		]);

		if($return) {
			WP_CLI::runcommand('plugin activate wp-migrate-db-pro');
		}

		// If WP Migrate DB command is missing, quit.
		$return = WP_CLI::runcommand('cli has-command "migratedb"', [
			'exit_error' => false,
			'return' => 'return_code',
		]);

		if($return) {
			WP_CLI::error('Missing WP Migrate locally.');
			exit;
		}

		$env = '@' . $assoc_args['env'];

		// Make sure alias is valid
		$return = WP_CLI::runcommand("cli alias get $env", [
			'exit_error' => false,
			'return' => 'return_code',
		]);

		if($return) {
			WP_CLI::error("Missing alias $env");
			exit;
		}

		// Find the connection key on the remote install
		$secret_key = WP_CLI::runcommand("$env migratedb setting get connection-key", [
			'exit_error' => false,
			'return' => true,
		]);

		// Get the WordPress URL for the remote install
		$remote_url = WP_CLI::runcommand("$env option get siteurl", [
			'exit_error' => false,
			'return' => true,
		]);

		// Run!
		WP_CLI::runcommand("migratedb pull $remote_url $secret_key");

	}

}