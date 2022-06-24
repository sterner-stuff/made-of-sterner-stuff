<?php

namespace SternerStuffWordPress\Commands;

use WP_CLI;

class Update extends Command {

	public $name = 'update';

	/**
	 * Update dependencies and spit out a table.
	 */
	public function __invoke() {

		if (!$this->isWordPress()) {
			WP_CLI::error('This command can only be run in a WordPress environment.');
		}

		$this->old_plugins = $this->getPlugins();
		$this->old_themes = $this->getThemes();
		$this->old_core = $this->getCore();

		$this->updateComposer();
		$this->updatePlugins();
		$this->updateThemes();

		$this->new_plugins = $this->getPlugins();
		$this->new_themes = $this->getThemes();
		$this->new_core = $this->getCore();

		if ($this->old_core != $this->new_core) {
			$this->updateInfo[] = [
				'WordPress [core]',
				$this->old_core,
				$this->new_core,
			];
		}

		$this->updateInfo = array_merge($this->updateInfo, $this->diffPlugins() ?: []);
		$this->updateInfo = array_merge($this->updateInfo, $this->diffThemes() ?: []);
		dd($this->updateInfo);
		\WP_CLI\Utils\format_items('table', $this->updateInfo, ['Item', 'Old Version', 'New Version']);

	}

	private function updateComposer() {
		exec('composer update --no-interaction');
	}

	private function updateThemes() {
		return WP_CLI::runcommand('theme update --all');
	}

	private function updatePlugins() {
		return WP_CLI::runcommand('plugin update --all');
	}

	private function getPlugins() {
		return WP_CLI::runcommand('plugin list --format=json', [
			'parse' => 'json',
		]);
	}

	private function getThemes() {
		return WP_CLI::runcommand('theme list --format=json', [
			'parse' => 'json',
		]);
	}

	private function getCore() {
		return WP_CLI::runcommand('core version');
	}

	private function diffPlugins() {
		if (!$this->old_plugins || !$this->new_plugins) {
			return false;
		}
		return $this->diff($this->old_plugins, $this->new_plugins, 'plugin');
	}

	private function diffThemes() {
		if (!$this->old_themes || !$this->new_themes) {
			return false;
		}
		return $this->diff($this->old_themes, $this->new_themes, 'theme');
	}

	public function isWordPress() {
		return false !== WP_CLI::runcommand('core is-installed');
	}

	private function diff($oldThings, $newThings, $type = false) {
		$updateInfo = [];
		$installed = [];
		foreach ($newThings as $new) {
			$installed[$new->name] = $new->version;
			$found = false;
			foreach ($oldThings as $old) {
				if ($old->name == $new->name) {
					$found = true;
					if ($old->version == $new->version) {
						break;
					}
					$updateInfo[] = [
						$old->name . ($type ? ' [' . $type . ']' : ''),
						$old->version,
						$new->version,
					];
					break;
				}
			}
			if (!$found) {
				$updateInfo[] = [
					$new->name . ($type ? ' [' . $type . ']' : ''),
					'installed',
					$new->version,
				];
			}
		}
		foreach ($oldThings as $old) {
			if (!array_key_exists($old->name, $installed)) {
				$updateInfo[] = [
					$old->name . ($type ? ' [' . $type . ']' : ''),
					'removed',
					'N/A',
				];
			}
		}
		return $updateInfo;
	}

}