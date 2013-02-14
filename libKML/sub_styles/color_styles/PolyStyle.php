<?php
namespace libKML;

/**
 *  PolyStyle class
 */

class PolyStyle extends ColorStyle {

  private $fill;
  private $outline;

  public function toJSON() {
    $json_data = array();

    if (isset($this->id)) {
      $json_data['id'] = $this->id;
    }

    if (isset($this->fill)) {
      $json_data['fill'] = $this->fill;
    }

    if (isset($this->outline)) {
      $json_data['outline'] = $this->outline;
    }

    return $json_data;
  }

  public function __toString() {
    $parent_string = parent::__toString();

    $output = array();
    $output[] = sprintf("<PolyStyle%s>",
                        isset($this->id)?sprintf(" id=\"%s\"", $this->id):"");
    $output[] = $parent_string;

    if (isset($this->fill)) {
      $output[] = sprintf("\t<fill>%i</fill>", $this->fill);
    }

    if (isset($this->outline)) {
      $output[] = sprintf("\t<width>%i</width>", $this->outline);
    }

    $output[] = "</PolyStyle>";

    return implode("\n", $output);
  }

  public function getFill() {
    return $this->fill;
  }

  public function setFill($fill) {
    $this->fill = $fill;
  }

  public function getOutline() {
    return $this->outline;
  }

  public function setOutline($outline) {
    $this->outline = $outline;
  }

}
?>