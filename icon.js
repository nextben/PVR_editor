function Icon(id, options){
    L.Icon.call(this, options);
	this.id = id;
	this.event = {};	
}

Icon.prototype = new L.Icon();
Icon.prototype.constructor = Icon;

Icon.prototype.setOption = function(key, val){
	var oldVal = this.options[key];
	this.options[key] = val;
	this.fire('changeOption', key, oldVal, val);
}

Icon.prototype.on = function(name, func, context){
    if(!this.event[name]) this.event[name] = [];
    this.event[name].push({action: func, context: context?context:this});
}

Icon.prototype.off = function(name){
    if(!this.event[name]) this.event[name] = [];
    this.event[name].pop();
}

Icon.prototype.fire = function(name, data){
    var i, ev = {};

    ev.type = name;
    ev.target = this;

    if(!this.event[name]) return;
    for(i=0; i<this.event[name].length; i++){
        this.event[name][i].action.call(this.event[name][i].context, ev);
    }
}
