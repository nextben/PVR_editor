
function View(id, latlng, zoom, options){
	if(latlng.length == 2){
		latlng = L.latlng(latlng[0], latlng[1]);	
	}
	this.id = id;
	this.latlng = latlng;
	this.zoom = zoom;
	this.options = options;
}

View.prototype.setOption = function(key, value){
	this.options[key] = value;
}