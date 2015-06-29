 /*options
  useView
  useLayerControl
  mode
*/

function Map(id, mapContainerId, options){
  var that;

  this.id = id;
  this.options = {};
  for(key in options){ this.options[key] = options[key]; }
  this.map = L.map(mapContainerId, {
    attributionControl: false
  }).setView([0,0],0)

  this.tileLayerList = {};
  this.viewList = {};
  this.iconList = {};
  this.markerList = {};
  this.polylineList = {};
  this.sortedTileLayerList = [];

  this._curLayer = null;

  that = this;
  this.map.on('zoomend', function (){
    if(!that._curLayer) return;
    this.removeLayer(that._curLayer.mainLayer);
    that._curLayer.setMainLayer(this.getZoom());
    this.addLayer(that._curLayer.mainLayer);
  });

  this.map.on('baselayerchange', function (ev){
    var key, mainView;

    key = ev.layer.id;
    that.changeLayer(key);
    mainView = that.tileLayerList[key].options.mainView;
    that.map.setView(mainView.latlng, mainView.zoom, {animate:false});
  });
}

Map.prototype.addMarker = function(id, latlng, userOptions){
  var key, newMarker, that, options = {
    type: 'marker'
  };

  //id 확인
  if(this.markerList[id]){
    console.error('ID duplication');
    return false;
  }

  if(latlng.constructor.name == "Array") 
    latlng = L.latLng(latlng[0], latlng[1]);
  else if(latlng.constructor.name == "Object")
    latlng = L.latLng(latlng.lat, latlng.lng);

  for(key in userOptions){ options[key] = userOptions[key]; }
  
  if(options.icon !== undefined){
    if(this.iconList[options.icon])
      options.icon = this.iconList[options.icon];
    else 
      delete options.icon;
  }

  newMarker = new Marker(id, latlng, options);
  if(!newMarker){
    console.error('Fail to create new marker');
    return false;
  }
  this.markerList[id] = newMarker;
  
  if(options.layerId !== undefined){
    this.tileLayerList[options.layerId].addObject(newMarker);
  }
  that = this;

  newMarker.on('changeOption', function(ev){
    if(ev.key == 'minLevel' || ev.key == 'maxLevel'){
      that.tileLayerList[this.options.layerId].resetObject(this);
    }
  });

  return newMarker;
}
Map.prototype.delMarker = function(id){
  var oldMarker;

  oldMarker = this.markerList[id];
  delete this.markerList[id];
  if(oldMarker && oldMarker.options.layerId !== undefined){
    this.tileLayerList[oldMarker.options.layerId].delObject(oldMarker);
  }

  return oldMarker;
}

Map.prototype.addTileLayer = function(id, tileUrl, userOptions){
  var key, i, newTileLayer, options = {};

  for(key in userOptions){ options[key] = userOptions[key]; }
  newTileLayer = new TileLayer(id, tileUrl, options);
  if(!newTileLayer){
    console.error('Fail to create new tileLayer');
    return false;
  }
  this.tileLayerList[id] = newTileLayer;

  if(newTileLayer.options.order===undefined){
    this.sortedTileLayerList.push(newTileLayer);
  }
  else{
    for(i=0; i<this.sortedTileLayerList.length; i++){
      if(this.sortedTileLayerList[i].options.order >= options.order){
        this.sortedTileLayerList.splice(i, 0, newTileLayer);
        break;
      }
    }
    if(i == this.sortedTileLayerList.length){
      this.sortedTileLayerList.push(newTileLayer);
    }
    for(i=0; i<this.sortedTileLayerList.length; i++){
      this.sortedTileLayerList[i].options.order = i;
    }
  }

  return newTileLayer;
}
Map.prototype.delTileLayer = function(id){
  var oldLayer, objectList, i;

  oldLayer = this.tileLayerList[id];  
  
  if(oldLayer == this._curLayer){
    this._curLayer = null;    
    this.clearMap();    
  }

  //delete the objects in the tile layer
  objectList = oldLayer.totalLayer.getLayers();
  for(i=0; i<objectList.length; i++){
    if(objectList[i].options){
      switch(objectList[i].options.type){
        case "marker":
        this.delMarker(objectList[i].id); break;

        case "lineLayer":
        this.delPolyline(objectList[i].id);
        break;
      }
    }    
  }

  for(i=0; i<this.sortedTileLayerList.length; i++){
    if(this.sortedTileLayerList[i].id == id){
      this.sortedTileLayerList.splice(i, 1);
      break;
    }
  }
  for(i=0; i<this.sortedTileLayerList.length; i++){
    this.sortedTileLayerList[i].options.order = i;
  }

  delete this.tileLayerList[id];  
  return oldLayer;
}
Map.prototype.changeTileLayerOrder = function(id, idx){
  var i, curLayer;

  for(i=0; i<this.sortedTileLayerList.length; i++){
    if(this.sortedTileLayerList[i].id == id){
      curLayer = this.sortedTileLayerList[i];
      this.sortedTileLayerList.splice(i, 1);
      break;
    }
  }
  this.sortedTileLayerList.splice(idx, 0, curLayer);
  for(i=0; i<this.sortedTileLayerList.length; i++){
    this.sortedTileLayerList[i].options.order = i;
  }
}


Map.prototype.addView = function(id, latlng, zoom, userOptions){
  var key, newView, options = {};

  for(key in userOptions){ options[key] = userOptions[key]; }
  newView = new View(id, latlng, zoom, options);
  if(!newView){
    console.error('Fail to create new view');
    return false;
  }
  this.viewList[id] = newView;
  return newView;
}

Map.prototype.addIcon = function(id, userOptions){
  var key, newIcon, options = {};

  if(this.iconList[id]){
    console.error('ID duplication');
    return false;
  }

  for(key in userOptions){
    options[key] = userOptions[key];
  }
  options.iconAnchor = L.point(options.iconAnchor.x, options.iconAnchor.y);
  newIcon = new Icon(id, options);
  if(!newIcon){
    console.error('Fail to create new icon');
    return false;
  }
  this.iconList[id] = newIcon;
  
  return this.iconList[id];
}
Map.prototype.delIcon = function(id){
  var oldIcon = this.iconList[id], i, delMarkerList = [];
  delete this.iconList[id];

  for(i in this.markerList){    
    if(this.markerList[i].options.icon.id == id){
      delMarkerList.push(this.markerList[i].id);
    }
  }
  for(i=0; i<delMarkerList.length; i++){
    this.delMarker(delMarkerList[i]);
  }
  return oldIcon;
}

Map.prototype.drawLayerController = function(){ 
  var i, id, name;

  if(this.layerController){
    //한번 control에 속했던 레이어를 다시 쓰기 위해서는 
    //control에서 해제해 주어야 한다.
    for(i=0; i<this.layerController._layers.length; i++)
      this.layerController.removeLayer(this.layerController._layers[i]);
    this.map.removeControl(this.layerController);
  }                    
    
  this.layerController = L.control.layers().addTo(this.map);
  
  for(i=0; i<this.sortedTileLayerList.length; i++){
    id = this.sortedTileLayerList[i].id;
    name = this.sortedTileLayerList[i].options.name;

    //layer를 순서대로 추가해 주면 control에 layer가 순서대로표시된다.
    this.layerController.addBaseLayer(this.tileLayerList[id].tile, name);    
  }
}


Map.prototype.changeLayer = function(id){
  if((this._curLayer && this._curLayer.id != id) || !this._curLayer){
    if(this._curLayer) this._curLayer.hide();
    this._curLayer = this.tileLayerList[id];
    this._curLayer.addTo(this.map);
  }
}

Map.prototype.moveToView = function(id){  
  this.changeLayer(this.viewList[id].options.layerId);  
  this.map.setView(this.viewList[id].latlng, this.viewList[id].zoom, {animate:false});
}

Map.prototype.clearMap = function(){
  var layerList = this.map._layers;

  for(key in layerList){
    this.map.removeLayer(layerList[key]);  
  }
  this._curLayer = null;
}

Map.prototype.addPolyline = function (id, layerId, userOptions) {
  var key, newPolyline, options, layer, video, midpointLayer, line, timelines;

  //id duplication check
  if(this.polylineList[id]){
    console.error('ID duplication');
    return false;
  }

  //move content of userOptions to options
  options = {};
  for(key in userOptions) {
    options[key] = userOptions[key];
  }

  //set variables for Polyline parameters
  layer = this.tileLayerList[layerId];
  //change layer data for polyline
  layer.contents = options.contents;
  levelBound = options.levelBound;
  video = options.video;
    
  //make polyline object and insert that to list
  newPolyline = new Polyline(id, layer, levelBound, video);
  if(!newPolyline) {
    console.error('Fail to create new polyline');
    return false;
  }

  //add midpointLayer and lineLayer to layer
  midpointLayer = newPolyline.midPointLayer;
  midpointLayer.options = {
    type: 'midpointLayer'
  };;
  midpointLayer.id = id;
  midpointLayer.levelBound = newPolyline.levelBound;
  layer.addObject(midpointLayer);

  lineLayer = newPolyline.lineLayer;
  lineLayer.options = {
    type: 'lineLayer'
  };
  lineLayer.id = id;
  lineLayer.levelBound = newPolyline.levelBound;
  layer.addObject(lineLayer);

  this.polylineList[id] = newPolyline;
  
  return newPolyline;
};

Map.prototype.delPolyline = function (id) {
  var oldPolyline, oldMidpointLayer, oldLineLayer;

  if(!this.polylineList[id]){
    return;
  }

  oldPolyline = this.polylineList[id];
  delete this.polylineList[id];

  // remove map layers from tile layer group
  if(oldPolyline && oldPolyline.floor.id !== undefined){
    oldMidpointLayer = oldPolyline.midPointLayer;
    oldLineLayer = oldPolyline.lineLayer;

    this.tileLayerList[oldPolyline.floor.id].delObject(oldMidpointLayer);
    this.tileLayerList[oldPolyline.floor.id].delObject(oldLineLayer);
  }

  return oldPolyline;
};

/** 
 * refresh
 *  redraw the tile layer and object on the map
 */
Map.prototype.refresh = function () {
  var curLayer;
  if(this._curLayer){
    //save the curLayer object
    curLayer = this._curLayer;
    this.clearMap();
    this.changeLayer(curLayer.id);
  }
};