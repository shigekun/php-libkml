<?php
namespace libKML;

/**
 *  LineStyle class
 */

class LineStyle extends ColorStyle {

  private $width;

  public function toJSON() {
    $json_data = array();

    if (isset($this->id)) {
      $json_data['id'] = $this->id;
    }

    if (isset($this->width)) {
      $json_data['width'] = $this->width;
    }

    return $json_data;
  }

  public function __toString() {
    $parent_string = parent::__toString();

    $output = array();
    $output[] = sprintf("<LineStyle%s>",
                        isset($this->id)?sprintf(" id=\"%s\"", $this->id):"");
    $output[] = $parent_string;

    if (isset($this->width)) {
      $output[] = sprintf("\t<width>%s</width>", $this->width);
    }

    $output[] = "</LineStyle>";

    return implode("\n", $output);
  }

  public function setWidth($width) {
    $this->width = $width;
  }

  public function getWidth() {
    return $this->width;
  }

}
?>