<?php
namespace libKML;

/**
 *  BalloonStyle class
 */

class BalloonStyle extends SubStyle {

  private $bgColor;
  private $textColor;
  private $text;
  private $displayMode;

  public function toJSON() {
    $json_data = array();

    if (isset($this->id)) {
      $json_data['id'] = $this->id;
    }

    if (isset($this->bgColor)) {
      $json_data['bgColor'] = $this->bgColor;
    }

    if (isset($this->textColor)) {
      $json_data['textColor'] = $this->textColor;
    }

    if (isset($this->text)) {
      $json_data['text'] = $this->text;
    }

    if (isset($this->displayMode)) {
      $json_data['displayMode'] = $this->displayMode->toJSON();
    }

    return $json_data;
  }

  public function __toString() {
    $output = array();
    $output[] = sprintf("<BalloonStyle%s>",
                        isset($this->id)?sprintf(" id=\"%s\"", $this->id):"");

    if (isset($this->bgColor)) {
      $output[] = sprintf("\t<bgColor>%s</bgColor>", $this->bgColor);
    }

    if (isset($this->textColor)) {
      $output[] = sprintf("\t<textColor>%s</textColor>", $this->textColor);
    }

    if (isset($this->text)) {
      $output[] = sprintf("\t<text><![CDATA[%s]]></text>", $this->text);
    }

    if (isset($this->displayMode)) {
      $output[] = $this->displayMode->__toString();
    }

    $output[] = "</BalloonStyle>";

    return implode("\n", $output);
  }

  public function getBgColor() {
    return $this->bgColor;
  }

  public function setBgColor($bgColor) {
    $this->bgColor = $bgColor;
  }

  public function getTextColor() {
    return $this->textColor;
  }

  public function setTextColor($textColor) {
    $this->textColor = $textColor;
  }

  public function getText() {
    return $this->text;
  }

  public function setText($text) {
    $this->text = $text;
  }

  public function getDisplayMode() {
    return $this->displayMode;
  }

  public function setDisplayMode($displayMode) {
    $this->displayMode = $displayMode;
  }

}
?>