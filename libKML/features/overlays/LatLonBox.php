<?php
namespace libKML;

/**
 *  LatLonBox class
 */

class LatLonBox extends KMLObject {
  
  private $north;
  private $south;
  private $east;
  private $west;
  private $rotation;
  
  public function __toString() {
    $output = array();
    
    if (isset($this->north, $this->south,
              $this->east, $this->west)) {
      $output[] = '<LanLonBox>';
      
      $output[] = sprintf("\t<north>%f</north>", $this->north);
      $output[] = sprintf("\t<south>%f</south>", $this->south);
      $output[] = sprintf("\t<east>%f</east>", $this->east);
      $output[] = sprintf("\t<west>%f</west>", $this->west);
      
      if (isset($this->rotation)) {
        $output[] = sprintf("\t<rotation>%f</rotation>", $this->rotation);
      }
      
      $output[] = '</LanLonBox>';
    }
    
    return implode("\n", $output);
  }
  
  public function getNorth() {
    return $this->north;
  }
  
  public function setNorth($north) {
    $this->north = $north;
  }
  
  public function getSouth() {
    return $this->south;
  }
  
  public function setSouth($south) {
    $this->south = $south;
  }

  public function getEast() {
    return $this->east;
  }
  
  public function setEast($east) {
    $this->east = $east;
  }
  
  public function getWest() {
    return $this->west;
  }
  
  public function setWest($west) {
    $this->west = $west;
  }
  
  public function getRotation() {
    return $this->rotation;
  }
  
  public function setRotation($rotation) {
    $this->rotation = $rotation;
  }
  
}

?>