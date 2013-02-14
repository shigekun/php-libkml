<?php
namespace libKML;

/**
 *  StyleMap class
 */

class StyleMap extends StyleSelector {

  private $pairs = array();

  public function addPair(Pair $pair) {
    $this->pairs[] = $pair;
  }

  public function clearPairs() {
    $this->pairs = array();
  }

  public function toJSON() {
    $json_data = array();

    if (isset($this->id)) {
      $json_data['id'] = $this->id;
    }

    if ( isset($this->pairs) ) {
      $json_data['pairs'] = array();
      foreach($this->pairs as $pair) {
        $json_data['pairs'][] = $pair->toJSON();
      }
    }

    return $json_data;
  }

  public function __toString() {
    $output = array();
    $output[] = sprintf("<StyleMap%s>",
                        isset($this->id)?sprintf(" id=\"%s\"", $this->id):"");

    foreach($this->pairs as $pair) {
      $output[] = $pair->__toString();
    }

    $output[] = "</StyleMap>";

    return implode("\n", $output);
  }

  public function setPairs(array $pairs) {
    $this->pairs = $pairs;
  }

  public function getPairs() {
    return $this->pairs;
  }

}

?>