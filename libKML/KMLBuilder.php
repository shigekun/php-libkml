<?php
namespace libKML;

/**
 *  KMLBuilder
 *
 *  Builds KML Objects
 */
  
  function processKMLObject(&$object, $objectXMLObject) {
    $attributes = $objectXMLObject->attributes();
        
    if (isset($attributes['id'])) {
      $object->setId((string)$attributes['id']);
    }
  }
  
  function processAbstractView(&$abstractView, $abstractViewXMLObject) {
    processKMLObject($abstractView, $abstractViewXMLObject);
  }
  
  
  function processFeature(&$feature, $featureXMLObject) {
    processKMLObject($feature, $featureXMLObject);
    
    $featureContent = $featureXMLObject->children();
    
    $simple_properties = array('name', 'visibility', 'open', 'address', 'phoneNumber',
                               'Snippet', 'description', 'styleUrl');
    $object_properties = array('Region');
    
    foreach($featureContent as $key => $value) {
      if (in_array($key, $simple_properties)) {
        call_user_func(array($feature, 'set'. ucfirst($key)), $value->__toString());
      } elseif (in_array($key, $object_properties)) {
        call_user_func(array($feature, 'set'. ucfirst($key)),
                       call_user_func('libKML\build'. ucfirst($key), $value)
                       );
      } elseif ($key == 'Camera' || $key == 'LookAt') {
        $feature->setAbstractView(call_user_func('libKML\build'. $key, $value));
      } elseif ($key == 'TimeStamp' || $key == 'TimeSpan') {
        $feature->setTimePrimitive(call_user_func('libKML\build'. $key, $value));
      } elseif ($key == 'Style' || $key == 'StyleMap') {
        $feature->setStyleSelector(call_user_func('libKML\build'. $key, $value));
      } elseif ($key == 'atom:author') {
        $feature->setAuthor(buildAuthor($value));
      }
    }    
  }
  
  function buildNetworkLink($networkLinkXMLObject) {
    $networkLink = new NetworkLink();
    processFeature($networkLink, $networkLinkXMLObject);
    
    
    return $networkLink;
  }

  function processContainer(&$container, $containerXMLObject) {
    processFeature($container, $containerXMLObject);
    
    $containerContent = $containerXMLObject->children();
    
    $object_properties = array('NetworkLink', 'Placemark', 'PhotoOverlay', 'ScreenOverlay', 'GroundOverlay',
                               'Folder');
    
    foreach($containerContent as $key => $value) {
      if (in_array($key, $object_properties)) {
        $container->addFeature(call_user_func('libKML\build'. ucfirst($key), $value));
      }
    }
  }
  
  function buildDocument($documentXMLObject) {
    $document = new Document();
    
    processContainer($document, $documentXMLObject);
    
    return $document;
  }
  
  function buildFolder($folderXMLObject) {
    $folder = new Folder();
    
    processContainer($folder, $folderXMLObject);
    
    return $folder;
  }
  
  function buildLatLonBox($latLonBoxXMLObject) {
    $latLonBox = new LatLonBox();
    processKMLObject($latLonBox, $latLonBoxXMLObject);
    
    $latLonBoxContent = $latLonBoxXMLObject->children();
    
    $simple_properties = array('north', 'east', 'west', 'south', 'rotation');
    foreach($latLonBoxContent as $key => $value) {
      if (in_array($key, $simple_properties)) {
        call_user_func(array($latLonBox, 'set'. ucfirst($key)), $value->__toString());
      }
    }
    
    return $latLonBox;
  }
  
  function processOverlay(&$overlay, $overlayXMLObject) {
    processFeature($overlay, $overlayXMLObject);
    
    $overlayContent = $overlayXMLObject->children();
    
    foreach($overlayContent as $key => $value) {
      if ($key == 'color') {
        $overlay->setColor($value->__toString());
      } elseif ($key == 'drawOrder') {
        $overlay->setDrawOrder($value->__toString());
      } elseif ($key == 'Icon') {
        $overlay->setIcon(buildIcon($value));
      }
    }
    
  }
  
  function buildGroundOverlay($groundOverlayXMLObject) {
    $groundOverlay = new GroundOverlay();
    processOverlay($groundOverlay, $groundOverlayXMLObject);
    
    $groundOverlayContent = $groundOverlayXMLObject->children();
    
    foreach($groundOverlayContent as $key => $value) {
      if ($key == 'altitude') {
        $groundOverlay->setAltitude($value->__toString());
      } elseif ($key == 'altitudeMode') {
        $groundOverlay->setAltitudeMode(buildAltitudeMode($value));
      } elseif ($key == 'LatLonBox') {
        $groundOverlay->setLatLonBox(buildLatLonBox($value));
      }
    }
    
    return $groundOverlay;
  }
  
  function buildScreenOverlay($screenOverlayXMLObject) {
    $screenOverlay = new ScreenOverlay();
    
    processOverlay($screenOverlay, $screenOverlayXMLObject);
    
    return $screenOverlay;    
  }
  
  function buildCamera($cameraXMLObject) {
    $camera = new Camera();    
    processAbstractView($camera, $cameraXMLObject);
    
    return $camera;  
  }
  
  function buildLookAt($lookAtXMLObject) {
    $lookAt = new LookAt();    
    processAbstractView($lookAt, $lookAtXMLObject);
    
    $lookAtContent = $lookAtXMLObject->children();
    
    $simple_properties = array('longitude', 'latitude', 'altitude', 'heading', 'tilt', 'range');
    
    foreach($lookAtContent as $key => $value) {
      if (in_array($key, $simple_properties)) {
        call_user_func(array($lookAt, 'set'. ucfirst($key)), $value->__toString());
      } elseif ($key == 'altitudeMode') {
        $lookAt->setAltitudeMode(buildAltitudeMode($value));
      }
    }
    
    return $lookAt;
  }
  
  function buildPlacemark($placemarkXMLObject) {
    $placemark = new Placemark();
   
    processFeature($placemark, $placemarkXMLObject);
    $placemarkContent = $placemarkXMLObject->children();
    
    $geometry_properties = array('Point', 'LineString', 'LinearRing', 'Polygon', 'MultiGeometry', 'Model');
    
    foreach($placemarkContent as $key => $value) {
      if (in_array($key, $geometry_properties)) {
        $placemark->setGeometry(call_user_func('libKML\build'. $key, $value));
      }
    }
    
    return $placemark;
  }
  
  function processGeometry(&$geometry, $geometryXMLObject) {
    processKMLObject($geometry, $geometryXMLObject);  
  }
  
  function buildPoint($pointXMLObject) {
    $point = new Point();
    
    processGeometry($point, $pointXMLObject);
    $pointContent = $pointXMLObject->children();
    
    foreach ($pointContent as $key => $value) {
      if ($key == 'extrude') {
        $point->setExtrude($value);
      } elseif ($key == 'altitudeMode') {
        $point->setAltitudeMode(buildAltitudeMode($value));
      } elseif ($key == 'coordinates') {
        $point->setCoordinates(buildCoordinates($value));
      }
    }
    
    return $point;
  }
  
  function buildLineString($lineStringXMLObject) {
    $lineString = new LineString(); 
    processGeometry($lineString, $lineStringXMLObject);
    
    $lineStringContent = $lineStringXMLObject->children();
    
    $simple_properties = array('extrude', 'tessellate');
    
    foreach ($lineStringContent as $key => $value) {
      if (in_array($key, $simple_properties)) {
        call_user_func(array($lineString, 'set'. ucfirst($key)), $value->__toString());
      } elseif ($key == 'altitudeMode') {
        $lineString->setAltitudeMode(buildAltitudeMode($value));
      } elseif ($key == 'coordinates') {
        $coordinates = explode(" ", trim($value->__toString()));
        foreach ($coordinates as $coord) {
          if (strlen($coord)) {
            $lineString->addCoordinate(buildCoordinates($coord));
          }
        }
      }
    }
    
    return $lineString;
  }
  
  function buildLinearRing($linearRingXMLObject) {
    $linearRing = new LinearRing();
    processGeometry($linearRing, $linearRingXMLObject);
    
    $linearRingContent = $linearRingXMLObject->children();
    
    $simple_properties = array('extrude', 'tessellate');
    
    foreach ($linearRingContent as $key => $value) {      
      if (in_array($key, $simple_properties)) {
        call_user_func(array($linearRing, 'set'. ucfirst($key)), $value->__toString());
      } elseif ($key == 'altitudeMode') {
        $linearRing->setAltitudeMode(buildAltitudeMode($value));
      } elseif ($key == 'coordinates') {
        $coordinates = explode(" ", trim($value->__toString()));
        foreach ($coordinates as $coord) {
          if (strlen($coord)) {
            $linearRing->addCoordinate(buildCoordinates($coord));
          }
        }
      }
    }
    
    return $linearRing; 
  }
  
  function buildPolygon($polygonXMLObject) {
    $polygon = new Polygon();
    processGeometry($polygon, $polygonXMLObject);
    
    $polygonContent = $polygonXMLObject->children();
    
    $simple_properties = array('extrude', 'tessellate');
    
    foreach ($polygonContent as $key => $value) {
      if (in_array($key, $simple_properties)) {
        call_user_func(array($polygon, 'set'. ucfirst($key)), $value->__toString());
      } elseif ($key == 'altitudeMode') {
        $polygon->setAltitudeMode(buildAltitudeMode($value));
      } elseif ($key == 'outerBoundaryIs' || $key == 'innetBoundaryIs') {
        call_user_func(array($polygon, 'set'. ucfirst($key)), buildLinearRing($value->children()));
      }
    }
    
    return $polygon;
  }
  
  function buildAltitudeMode($altitudeModeXMLObject) {
    $altitudeMode = new AltitudeMode();
    $altitudeMode->setModeFromString($altitudeModeXMLObject);
    
    return $altitudeMode;
  }
  
  function buildRefreshMode($refreshModeXMLObject) {
    $refreshMode = new RefreshMode();
    $refreshMode->setModeFromString($refreshModeXMLObject);
    
    return $refreshMode;
  }
  
  function buildCoordinates($coordinatesXMLObject) {
    $coordinates = new Coordinates();
    
    $coordinates_string = $coordinatesXMLObject;  
    if (is_object($coordinatesXMLObject)) {
      $coordinates_string = $coordinatesXMLObject->__toString();
    }
      
    $coordinates_array = explode(",", $coordinates_string);
    
    if (isset($coordinates_array[0])) {
      $coordinates->setLongitude($coordinates_array[0]);
    }
    
    if (isset($coordinates_array[1])) {
      $coordinates->setLatitude($coordinates_array[1]);
    }
    
    if (isset($coordinates_array[2])) {
      $coordinates->setAltitude($coordinates_array[2]);
    }
    
    return $coordinates;
  }
  
  function processStyleSelector(&$styleSelector, $styleSelectorXMLObject) {
    processKMLObject($styleSelector, $styleSelectorXMLObject);
  }
  
  function buildStyle($styleXMLObject) {
    $style = new Style();
    processStyleSelector($style, $styleXMLObject);
    
    $styleContent = $styleXMLObject->children();
    
    $object_properties = array('BalloonStyle', 'IconStyle', 'LabelStyle', 'LineStyle',
                               'ListStyle', 'PolyStyle');
    foreach($styleContent as $key => $value) {
      if (in_array($key, $object_properties)) {
        call_user_func(array($style, 'set'. ucfirst($key)),
                       call_user_func('libKML\build'. ucfirst($key), $value)
                       );
      }
    }
    
    return $style;
  }
  
  function buildStyleMap($styleMapXMLObject) {
    $styleMap = new StyleMap();
    processStyleSelector($styleMap, $styleMapXMLObject);
    
    
    
    return $styleMap;
  }
  
  function processSubStyle(&$subStyle, $subStyleXMLObject) {
    processKMLObject($subStyle, $subStyleXMLObject);
  }
  
  function buildBalloonStyle($balloonStyleXMLObject) {
    $balloonStyle = new BalloonStyle();
    processSubStyle($balloonStyle, $balloonStyleXMLObject);
    
    $balloonStyleContent = $balloonStyleXMLObject->children();
    $simple_properties = array('bgColor', 'textColor', 'text');
    foreach($balloonStyleContent as $key => $value) {
      if (in_array($key, $simple_properties)) {
        call_user_func(array($balloonStyle, 'set'. ucfirst($key)), $value->__toString());
      } elseif ($key == 'displayMode') {
        
      }
    }
    
    return $balloonStyle;
  }
  
  function buildColorMode($colorModeXMLObject) {
    $colorMode = new ColorMode();
    $colorMode->setModeFromString($colorModeXMLObject);
    
    return $colorMode;
  }
  
  function processColorStyle(&$colorStyle, $colorStyleXMLObject) {
    processSubStyle($colorStyle, $colorStyleXMLObject);
    
    $colorStyleContent = $colorStyleXMLObject->children();
    
    foreach($colorStyleContent as $key => $value) {
      if ($key == 'color') {
        $colorStyle->setColor($value->__toString());
      } elseif ($key == 'colorMode') {
        $colorStyle->setColorMode(buildColorMode($value));
      }
    }
  }
  
  function buildLineStyle($lineStyleXMLOject) {
    $lineStyle = new LineStyle();
    processColorStyle($lineStyle, $lineStyleXMLOject);
    
    $lineStyleContent = $lineStyleXMLObject->children();
    
    foreach($lineStyleContent as $key => $value) {
      if ($key == 'width') {
        $lineStyle->setWidth((string)$value);
      }
    }
    
    return $labelStyle;
    
    return $lineStyle;
  }
  
  function buildIconStyle($iconStyleXMLObject) {
    $iconStyle = new IconStyle();
    processColorStyle($iconStyle, $iconStyleXMLObject);
    
    $iconStyleContent = $iconStyleXMLObject->children();
    $simple_properties = array('scale', 'heading', 'hotSpot');
    foreach($iconStyleContent as $key => $value) {
      if (in_array($key, $simple_properties)) {
        call_user_func(array($iconStyle, 'set'. ucfirst($key)), $value->__toString());
      } elseif ($key == 'Icon') {
        $iconStyle->setIcon(buildIcon($value));
      }
    }
    
    return $iconStyle;
  }
  
  
  function buildLabelStyle($labelStyleXMLObject) {
    $labelStyle = new LabelStyle();
    processColorStyle($labelStyle, $labelStyleXMLObject);
    
    $labelStyleContent = $labelStyleXMLObject->children();
    
    foreach($labelStyleContent as $key => $value) {
      if ($key == 'scale') {
        $labelStyle->setScale((string)$value);
      }
    }
    
    return $labelStyle;
  }
  
  function buildPolyStyle($polyStyleXMLObject) {
    $polyStyle = new PolyStyle();
    processColorStyle($polyStyle, $polyStyleXMLObject);
    
    $polyStyleContent = $polyStyleXMLObject->children();
    
    foreach($polyStyleContent as $key => $value) {
      if ($key == 'fill') {
        $polyStyle->setFill((string)$value);
      } elseif ($key == 'outline') {
        $polyStyle->setOutline((string)$value);
      }
    }
    
    return $polyStyle;
  }
  
  function buildRegion($regionXMLObject) {
    $region = new Region();
    processKMLObject($region, $regionXMLObject);
    
    $regionContent = $regionXMLObject->children();
    
    foreach($regionContent as $key => $value) {
      if ($key == 'LatLonAltBox') {
        $region->setLatLonAltBox(buildLatLonAltBox($value));
      } elseif ($key == 'Lod') {
        $region->setLod(buildLod($value));
      }
    }
    
    return $region;
  }
  
  function buildIcon($iconXMLObject) {
    $icon = new Icon();
    processKMLObject($icon, $iconXMLObject);    
    
    $iconContent = $iconXMLObject->children();
    
    $simple_properties = array('href', 'refreshInterval', 'viewRefreshTime', 'viewBoundScale',
                               'viewFormat', 'httpQuery');
    $object_properties = array('refreshMode', 'viewRefreshMode');
    
    foreach($iconContent as $key => $value) {
      if (in_array($key, $simple_properties)) {
        call_user_func(array($icon, 'set'. ucfirst($key)), $value->__toString());
      } elseif (in_array($key, $object_properties)) {
        call_user_func(array($icon, 'set'. ucfirst($key)),
                       call_user_func('libKML\build'. ucfirst($key), $value)
                       );
      }
    }
    
    return $icon;
  }
  
  function buildAuthor($authorXMLObject) {
    $author = new Author();
    
    $author->setName($authorXMLObject->name);
    $author->setUri($authorXMLObject->uri);
    $author->setEmail($authorXMLObject->email);
    
    return $author;
  }
  
  function buildKML($kmlXMLObject) {
    $kml = new KML();
    
    $featureXMLObject = $kmlXMLObject->children();
    if (isset($featureXMLObject)) {
      $kml->setFeature(call_user_func('libKML\build'. $featureXMLObject->getName(), $featureXMLObject));
    }
    
    return $kml;
  }
  


?>