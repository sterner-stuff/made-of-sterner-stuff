<?php

namespace WebspecWordPress\Version;

class PluginUpdate {
  public $upgrader;
  public $extras = [];
  public $action = '';

  public $isWordPressPlugin = null;

  public function __construct(\Plugin_Upgrader $upgrader, $extras) {
    $this->upgrader = $upgrader;
    $this->extras = $extras;
    $this->action = $extras['action'];
  }

  public function isUpdate() {
    return $this->action == 'update';
  }

  public function isInstall() {
    return $this->action == 'install';
  }

  public function getPluginSlug() {
    if(isset($this->upgrader->result['destination_name'])) {
      return $this->upgrader->result['destination_name'];
    }
  }

  public function getPluginPath() {
    return $this->upgrader->plugin_info();
  }

  public function getComposerSlug() {
    if($this->isWordPressPlugin()) {
      return 'wpackagist-plugin/'.$this->getPluginSlug();
    }
  }

  public function isWordPressPlugin() {
    if(null === $this->isWordPressPlugin) {
      $slug = $this->getPluginSlug();
      if($slug == '') {
        $this->isWordPressPlugin = false;
        return $this->isWordPressPlugin;
      }
      $handle = curl_init("https://wordpress.org/plugins/$slug");
      curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);

      /* Get the HTML or whatever is linked in $url. */
      $response = curl_exec($handle);

      /* Check for 404 (file not found). */
      $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
      curl_close($handle);

      if($httpCode != 404) {
        $this->isWordPressPlugin = true;
      }
      else {
        $this->isWordPressPlugin = false;
      }

    }

    return $this->isWordPressPlugin;
  }

  public function getNewVersion() {
    $data = get_plugin_data(WP_PLUGIN_DIR.'/'.$this->getPluginPath(), false, false);
    return $data['Version'];
  }
}
