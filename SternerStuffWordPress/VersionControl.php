<?php

namespace SternerStuffWordPress;

use SternerStuffWordPress\Version\PluginUpdate;

class VersionControl {
  //Holds a PluginUpdate instance so we can pass it around
  public $updater;

  public function __construct() {
    //Call later so we can filter out functionality
    add_action('after_setup_theme', [$this, 'after_setup_theme']);
  }

  public function after_setup_theme() {
    if(apply_filters('SternerStuffWordPress/VersionControl/UseVersionControl', true)) {
      add_action('upgrader_process_complete', [$this, 'plugin_install_update'], 10, 2);

  		add_action('pre_uninstall_plugin', [$this, 'plugin_uninstall'], 10, 2);

  		add_action('webspec_git_update', [$this, 'flush_w3tc']);
    }
  }

  function plugin_uninstall($plugin, $uninstallable_plugins) {
		$plugin = explode('/', $plugin)[0];
		$composer_file = get_home_path().'/composer.json';
		$composer = json_decode(file_get_contents($composer_file), true);
		unset($composer['require']['wpackagist-plugin/'.$plugin]);
		file_put_contents($composer_file, json_encode($composer, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
	}

  function plugin_install_update($upgrader, $extras) {
    //Only do on plugins
    if(isset($extras['type']) && $extras['type'] == 'plugin') {
      $updater = new PluginUpdate($upgrader, $extras);

      //Hook into a very late action. This is because $upgrader does not contain information about the new version of the plugin. We wait until the site continues the request.
      $this->updater = $updater;
      add_action('shutdown', [$this, 'after_plugin_install_update']);
    } //Only do plugins

    return;
	}

  public function after_plugin_install_update() {
    $updater = $this->updater;

    //Only run with WordPress plugins
    if($updater->isWordPressPlugin()) {
      //Grab the plugin that was updated
      $slug = $updater->getPluginSlug();
      $newVersion = $updater->getNewVersion();

      $composer_file = untrailingslashit(get_home_path()).'/composer.json';
      $composer = json_decode(file_get_contents($composer_file), true);
      $composer['require'][$updater->getComposerSlug()] = '>='.$newVersion;
      file_put_contents($composer_file, json_encode($composer, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }
  }

	function flush_w3tc() {
		if (function_exists('w3tc_flush_all')) {
			w3tc_flush_all();
		}
	}
}
