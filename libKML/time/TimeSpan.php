<?php
namespace libKML;

/**
 *  TimeSpan class
 */

class TimeSpan extends TimePrimitive {

  private $begin;
  private $end;

  public function toJSON() {
    $json_data = array();

    if (isset($this->id)) {
      $json_data['id'] = $this->id;
    }

    if (isset($this->begin)) {
      $json_data['begin'] = $this->begin->toJSON();
    }

    if (isset($this->end)) {
      $json_data['end'] = $this->end->toJSON();
    }

    return $json_data;
  }

  public function __toString() {
    $parent_string = parent::__toString();

    $output = array();
    $output[] = sprintf("<TimeSpan%s>",
                        isset($this->id)?sprintf(" id=\"%s\"", $this->id):"");
    $output[] = $parent_string;

    $output[] = "</TimeSpan>";

    return implode("\n", $output);
  }

  public function getBegin() {
    return $this->begin;
  }

  public function setBegin($begin) {
    $this->begin = $begin;
  }

  public function getEnd() {
    return $this->end;
  }

  public function setEnd($end) {
    $this->end = $end;
  }

}
?>