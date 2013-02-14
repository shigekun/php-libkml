<?php
namespace libKML;

/**
 *  ItemIcon class
 */

class ItemIcon extends KMLObject {

  private $href;
  private $state;

  public function toJSON() {
    $json_data = array();

    if (isset($this->id)) {
      $json_data['id'] = $this->id;
    }

    if (isset($this->href)) {
      $json_data['href'] = $this->href;
    }

    if (isset($this->state)) {
      $json_data['state'] = $this->state->toJSON();
    }

    return $json_data;
  }

  public function __toString() {

    $output = array();

    $output[] = sprintf("<ItemIcon%s>",
                        isset($this->id)?sprintf(" id=\"%s\"", $this->id):"");

    if (isset($this->href)) {
      $output[] = sprintf("\t<href>%s</href>", $this->href);
    }

    if (isset($this->state)) {
      $output[] = sprintf("\t<state>%s</state>", $this->state->__toString());
    }

    $output[] = "</ItemIcon>";

    return implode("\n", $output);
  }

  public function getHref() {
    return $this->href;
  }

  public function setHref($href) {
    $this->href = $href;
  }

  public function getState() {
    return $this->state;
  }

  public function setState($state) {
    $this->state = $state;
  }

}