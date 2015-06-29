/*options
	useLevelBound
	fixObjectToTileLayer
*/	
function TileLayer(id, tileUrl, options){
	var key, i;

	this.id = id;
	this.options = {
		minZoom: 0,
		maxZoom: 18,
		mainView:{
			latlng: L.latLng(0,0),
			zoom: 0
		},
		noWrap: true
	};
	for(key in options) this.options[key] = options[key];

	this.tile = L.tileLayer(tileUrl, this.options);
	//For baselayerchange event, tile layer has id of TileLayer
	this.tile.id = id;

	this.mainLayer = null;
	this.totalLayer = L.layerGroup();
	this.levelLayer = [];


	for(i=this.options.minZoom; i<=this.options.maxZoom; i++){
		this.levelLayer[i] = L.layerGroup();
	}

	this.setMainLayer(this.options.minZoom);
}

TileLayer.prototype.addObject = function(data){
	var i, minLevel, maxLevel;

	this.totalLayer.addLayer(data);

	//polyline use levelBound field
	if(data.levelBound) {
		minLevel = data.levelBound.min;
		maxLevel = data.levelBound.max;
	}
	//marker use options.minLevel, options.maxLevel field
	else if(data.options.minLevel !== undefined) {
		minLevel = data.options.minLevel;
		maxLevel = data.options.maxLevel;
	}

	for(i=minLevel; i<=maxLevel; i++){
		this.levelLayer[i] = this.levelLayer[i] || L.layerGroup();
		this.levelLayer[i].addLayer(data);
	}
}

TileLayer.prototype.delObject = function(data){
	var i, minLevel, maxLevel;

	this.totalLayer.removeLayer(data);

	minLevel = Math.min(this.options.minZoom, data.options.minLevel);
	maxLevel = Math.max(this.options.maxZoom, data.options.maxLevel);

	for(i=minLevel; i<=maxLevel; i++){
		this.levelLayer[i] = this.levelLayer[i] || L.layerGroup();
		this.levelLayer[i].removeLayer(data);
	}
}

TileLayer.prototype.resetObject = function(data){
	this.delObject(data);
	this.addObject(data);
	return this;
}

TileLayer.prototype.setOption = function(key, value){
	var map, i;

	this.options[key] = value;
	this.tile.options[key] = value;

	if(key == "minZoom" || key == "maxZoom" || key == "maxNativeZoom"){
		this.levelLayer[this.options.minZoom] = this.levelLayer[this.options.minZoom] || L.layerGroup();
		for(i=Number(this.options.minZoom)+1; i<=this.options.maxZoom; i++){
			this.levelLayer[i] = this.levelLayer[i] || L.layerGroup();
		}

		if(this.tile._map){
			map = this.tile._map;
			map.removeLayer(this.tile);
			this.tile.addTo(map);			
			
			map.setZoom(this.tile.options.minZoom);
		}		
	}
}

TileLayer.prototype.setMainLayer = function(level){
	this.levelLayer[level] = this.levelLayer[level]||L.layerGroup();
	this.mainLayer = this.levelLayer[level];
}

TileLayer.prototype.setTileUrl = function(newTileUrl){
	this.tile.setUrl(newTileUrl);
}

TileLayer.prototype.addTo = function(map){
	this.setMainLayer( map.getZoom() );
	this.tile.addTo(map);
	this.mainLayer.addTo(map);

	return this;
}

TileLayer.prototype.hide = function(){
	if(this.mainLayer._map){
		this.mainLayer._map.removeLayer(this.tile);
		this.mainLayer._map.removeLayer(this.mainLayer);		
		return this;
	}
}