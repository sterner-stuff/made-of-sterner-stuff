<?php 

namespace SternerStuffWordPress\Commands;

use WP_CLI;

class Deploy extends Command
{

	public $name = 'deploy';

	/**
     * Deploys from Git. Designed for remote usage on Kinsta.
     */
	public function __invoke()
	{
		// Move to Bedrock's root
		// chdir(WP_CONTENT_DIR . '../..');

		$git_branch = trim(exec('git rev-parse --abbrev-ref HEAD'));

		// Pull branch.
		exec("git pull origin $git_branch");

		// Install dependencies.
		exec('composer install --no-ansi --no-dev --no-interaction --no-progress --optimize-autoloader');

		// Flush the object cache
		WP_CLI::runcommand('cache flush');

		// Update the core database
		WP_CLI::runcommand('core update-db');

		// Maybe update WooCommerce database
		if(is_plugin_active('woocommerce/woocommerce.php')) {
			WP_CLI::runcommand('wc update');
		}

		// Maybe update Redirection database
		if(is_plugin_active('redirection/redirection.php')) {
			WP_CLI::runcommand('redirection database upgrade');
		}

		// Maybe flush WP-Rocket, which will clear the Kinsta cache if both are installed.
		if(is_plugin_active('wp-rocket/wp-rocket.php')) {
			WP_CLI::runcommand('rocket clean --confirm');
		}
		// Otherwise, directly flush Kinsta if the plugin is active.
		else if(class_exists('Kinsta\KMP')) {
			WP_CLI::runcommand('kinsta cache purge --all', ['exit_error' => false]);
		}

		// Maybe flush Cloudflare
		if(is_plugin_active('cloudflare/cloudflare.php')) {
			WP_CLI::runcommand('cloudflare cache_purge');
		}

	}

}
