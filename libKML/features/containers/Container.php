<?php
namespace libKML;

/**
 *  Container abstract class
 */

abstract class Container extends Feature {

  protected $features = array();

  public function toJSON() {
    $json_data = null;

    if (count($this->features)) {
      $json_data = array();

      foreach($this->features as $feature) {
        $json_data[] = $feature->toJSON();
      }
    }

    return $json_data;
  }

  public function getAllFeatures() {
    $allFeatures = array();

$start_time = microtime(true);
    foreach($this->features as $feature) {
      $allFeatures = array_merge($allFeatures, $feature->getAllFeatures());
      $cur_time = microtime(true);
      if ($cur_time - $start_time > 300) {
error_log("time over:count=".count($allFeatures));
		break;
	  }
    }
    return $allFeatures;
  }

  public function addFeature($feature) {
    $this->features[] = $feature;
  }

  public function clearFeatures() {
    $this->features = array();
  }

  public function toWKT() {
    $output = array();

    foreach($this->features as $feature) {
      $output[] = $feature->toWKT();
    }

    return implode(",", $output);
  }

  public function toWKT2d() {
    $output = array();

    foreach($this->features as $feature) {
      $output[] = $feature->toWKT2d();
    }

    return implode(",", $output);
  }

  public function __toString() {
    $parent_string = parent::__toString();

    $output = array();
    $output[] = $parent_string;

    foreach($this->features as $feature) {
      $output[] = $feature->__toString();
    }

    return implode("\n", $output);
  }

  public function setFeatures($features) {
    $this->features = $features;
  }

  public function getFeatures() {
    return $this->features;
  }
}

?>