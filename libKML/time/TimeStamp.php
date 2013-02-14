<?php
namespace libKML;

/**
 *  TimeStamp class
 */

class TimeStamp extends TimePrimitive {

  private $when;

  public function toJSON() {
    $json_data = array();

    if (isset($this->id)) {
      $json_data['id'] = $this->id;
    }

    if (isset($this->when)) {
      $json_data['when'] = $this->when->toJSON();
    }

    return $json_data;
  }

  public function __toString() {
    $parent_string = parent::__toString();

    $output = array();
    if (isset($this->when)) {
      $output[] = sprintf("<TimeStamp%s>",
                          isset($this->id)?sprintf(" id=\"%s\"", $this->id):"");
      $output[] = $parent_string;

      $output[] = $this->when->__toString();

      $output[] = "</TimeStamp>";
    }

    return implode("\n", $output);
  }

  public function getWhen() {
    return $this->when;
  }

  public function setWhen($when) {
    $this->when = $when;
  }

}
?>