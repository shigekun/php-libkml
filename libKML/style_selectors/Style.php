<?php
namespace libKML;

/**
 *  Style class
 */

class Style extends StyleSelector {

  private $iconStyle;
  private $labelStyle;
  private $lineStyle;
  private $polyStyle;
  private $balloonStyle;
  private $listStyle;

  public function toJSON() {
    $json_data = array();

    if (isset($this->id)) {
      $json_data['id'] = $this->id;
    }

    if (isset($this->iconStyle)) {
      $json_data['iconStyle'] = $this->iconStyle->toJSON();
    }

    if (isset($this->labelStyle)) {
      $json_data['labelStyle'] = $this->labelStyle->toJSON();
    }

    if (isset($this->lineStyle)) {
      $json_data['lineStyle'] = $this->lineStyle->toJSON();
    }

    if (isset($this->polyStyle)) {
      $json_data['polyStyle'] = $this->polyStyle->toJSON();
    }

    if (isset($this->balloonStyle)) {
      $json_data['balloonStyle'] = $this->balloonStyle->toJSON();
    }

    if (isset($this->listStyle)) {
      $json_data['listStyle'] = $this->listStyle->toJSON();
    }

    return $json_data;
  }

  public function __toString() {
    $output = array();
    $output[] = sprintf("<Style%s>",
                        isset($this->id)?sprintf(" id=\"%s\"", $this->id):"");

    if (isset($this->iconStyle)) {
      $output[] = $this->iconStyle->__toString();
    }

    if (isset($this->labelStyle)) {
      $output[] = $this->labelStyle->__toString();
    }

    if (isset($this->lineStyle)) {
      $output[] = $this->lineStyle->__toString();
    }

    if (isset($this->polyStyle)) {
      $output[] = $this->polyStyle->__toString();
    }

    if (isset($this->balloonStyle)) {
      $output[] = $this->balloonStyle->__toString();
    }

    if (isset($this->listStyle)) {
      $output[] = $this->listStyle->__toString();
    }

    $output[] = "</Style>";

    return implode("\n", $output);
  }

  public function getIconStyle() {
    return $this->iconStyle;
  }

  public function setIconStyle($iconStyle) {
    $this->iconStyle = $iconStyle;
  }

  public function getLabelStyle() {
    return $this->labelStyle;
  }

  public function setLabelStyle($labelStyle) {
    $this->labelStyle = $labelStyle;
  }

  public function getLineStyle() {
    return $this->lineStyle;
  }

  public function setLineStyle($lineStyle) {
    $this->lineStyle = $lineStyle;
  }

  public function getPolyStyle() {
    return $this->polyStyle;
  }

  public function setPolyStyle($polyStyle) {
    $this->polyStyle = $polyStyle;
  }

  public function getBalloonStyle() {
    return $this->balloonStyle;
  }

  public function setBalloonStyle($balloonStyle) {
    $this->balloonStyle = $balloonStyle;
  }

  public function getListStyle() {
    return $this->listStyle;
  }

  public function setListStyle($listStyle) {
    $this->listStyle = $listStyle;
  }

}

?>