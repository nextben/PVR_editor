function Video(id, name, url){
	this.id = id;
	this.name = name;
	this.url = url;
}

Video.prototype.getId 		= function(){ return this.id }
Video.prototype.getName 	= function(){ return this.name }
Video.prototype.getUrl 		= function(){ return this.url }
Video.prototype.setName 	= function(newName){ this.name = newName }
Video.prototype.setUrl 		= function(newUrl){ this.url = newUrl }

