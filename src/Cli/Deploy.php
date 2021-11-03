<?php 

namespace SternerStuffWordPress\Cli;

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

		// Reset to the master branch.
		exec('git reset origin master');

		// Install dependencies.
		exec('composer install --no-interaction --prefer-dist --optimize-autoloader');

		// Flush the object cache
		WP_CLI::runcommand('wp cache flush');

		// Update the core database
		WP_CLI::runcommand('wp core update-db');

		// Maybe update WooCommerce database
		if(is_plugin_active('woocommerce/woocommerce.php')) {
			WP_CLI::runcommand('wp wc update');
		}

		// Maybe update Redirection database
		if(is_plugin_active('redirection/redirection.php')) {
			WP_CLI::runcommand('wp redirection database upgrade');
		}

		// Maybe flush WP-Rocket, also handles Kinsta
		if(is_plugin_active('wp-rocket/wp-rocket.php')) {
			WP_CLI::runcommand('wp rocket clean --confim');
		}

		// Maybe flush Cloudflare
		if(is_plugin_active('cloudflare/cloudflare.php')) {
			WP_CLI::runcommand('wp cloudflare cache_purge');
		}

	}

}