<?php
namespace libKML;

/**
 *  ListStyle class
 */

class ListStyle extends SubStyle {

  private $listItemType;
  private $bgColor;
  private $itemIcons = array();
  private $maxSnippetLines;


  public function addItemIcon($itemIcon) {
    $this->itemIcons[] = $itemIcon;
  }

  public function clearItemIcons() {
    $this->itemIcons = array();
  }

  public function toJSON() {
    $json_data = array();

    if (isset($this->id)) {
      $json_data['id'] = $this->id;
    }

    if (isset($this->listItemType)) {
      $json_data['listItemType'] = $this->listItemType->toJSON();
    }

    if (isset($this->bgColor)) {
      $json_data['bgColor'] = $this->bgColor;
    }

    if (isset($this->maxSnippetLines)) {
      $json_data['maxSnippetLines'] = $this->maxSnippetLines;
    }

    if (count($this->itemIcons)) {
      $json_data['itemIcons'] = array();
      foreach($this->itemIcons as $itemIcon) {
        $json_data['itemIcons'][] = $itemIcon->toJSON();
      }
    }

    return $json_data;
  }

  public function __toString() {

    $output = array();
    $output[] = sprintf("<ListStyle%s>",
                        isset($this->id)?sprintf(" id=\"%s\"", $this->id):"");

    if (isset($this->listItemType)) {
      $output[] = sprintf("<listItemType>%s</listItemType>", $this->listItemType->__toString());
    }

    if (isset($this->bgColor)) {
      $output[] = sprintf("<bgColor>%s</bgColor>", $this->bgColor);
    }

    if (isset($this->maxSnippetLines)) {
      $output[] = sprintf("<maxSnippetLines>%s</maxSnippetLines>", $this->maxSnippetLines);
    }

    if (count($this->itemIcons)) {
      foreach($this->itemIcons as $itemIcon) {
        $output[] = $itemIcon->__toString();
      }
    }

    $output[] = "</ListStyle>";

    return implode("\n", $output);
  }

  public function getListItemType() {
    return $this->listItemType;
  }

  public function setListItemType($listItemType) {
    $this->listItemType = $listItemType;
  }

  public function getBgColor() {
    return $this->bgColor;
  }

  public function setBgColor($bgColor) {
    $this->bgColor = $bgColor;
  }

  public function getItemIcons() {
    return $this->itemIcons;
  }

  public function setItemIcons($itemIcons) {
    $this->itemIcons = $itemIcons;
  }

  public function setMaxSnippetLines($maxSnippetLines) {
    $this->maxSnippetLines = $maxSnippetLines;
  }

  public function getMaxSnippetLines() {
    return $this->maxSnippetLines;
  }

}
?>