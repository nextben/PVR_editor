var PvrPlayer = (function(){
	function PvrPlayer(krpanoObj, krpanoObjName, options){		
	    this.krpano = krpanoObj;
	    this.krpanoName = krpanoObjName;
	    this.vtourList = {};
	    this.sceneList = {};
	    this.iconList = {};
	    this.hotspotList = {};
	    this.textfieldList = {};
	    this.options = options;

	    this.view = null;
	    this.scene = null;

	    this.curXmlPath = null;
	}

	PvrPlayer.prototype.getView = function(){
	  var view = {};
	  view.hlookat = this.krpano.get('view.hlookat');
	  view.vlookat = this.krpano.get('view.vlookat');
	  view.fov = this.krpano.get('view.fov');

	  return view;
	}
	PvrPlayer.prototype.getMousePosition = function(){
		this.krpano.call('screentosphere(mouse.x, mouse.y, toh, tov)');
		return {
		  	atv: this.krpano.get('tov'),
		  	ath: this.krpano.get('toh')
		}
	}
	PvrPlayer.prototype.saveCurState = function(){
		this.view = this.getView();
		this.scene = this.krpano.get('xml.scene');
	}
	PvrPlayer.prototype.loadPrevState = function(){
		if(this.view && this.scene){
			this.krpano.call('loadscene("'+this.scene+'")');
			this.krpano.call('lookat('+this.view.hlookat+','+this.view.vlookat+','+this.view.fov+')');
		}
	}
	PvrPlayer.prototype.refresh = function(){
		if(this.curXmlPath)
			this.changeXml(this.curXmlPath);
	}
	PvrPlayer.prototype.addScene = function(id, userOptions, changeXml){
		var key, newScene, options={};
		changeXml = changeXml===undefined? true: changeXml;

		if(this.sceneList[id]){
		  	console.error('ID duplication');
		  	return false;
		}

		for(key in userOptions) options[key] = userOptions[key];
		if(options.vtourId!==undefined)	options.vtour = this.vtourList[options.vtourId];
		
		newScene = new Scene(id, options);
		if(!newScene){
		  	console.error('Fail to create new Scene');
		  	return false;
		}

		this.sceneList[id] = newScene;

		if(changeXml){
			$.ajax({
			  	url: 'xml.php',
			   	async : false,	    	
			  	data:{
			   		req:'addScene',
			   		data: {
			   			id: 's'+id,
			   			xmlUrl: options.vtour.xmlPath,
			  			krpanoName: this.krpanoName,
			   			options: newScene.getSimpleOptions()
			   		}	      		
			   	},
			   	type: 'get'
			});
		}

		return newScene;
	}
	PvrPlayer.prototype.delScene = function(id, modXml){
		var key, oldScene;
		modXml = modXml===undefined? true: modXml;

		oldScene = this.sceneList[id];
		for(key in oldScene.hotspotList){
			this.delHotspot(key, modXml);
		}		
		delete this.sceneList[id];

		if(modXml){
			$.ajax({
			  	url: 'xml.php',
			   	async : false,	    	
			  	data:{
			   		req:'delScene',
			   		data: {
			   			id: 's'+id,
			  			xmlUrl: oldScene.options.vtour.xmlPath,
			   		}	      		
			   	},
			   	type: 'get'
			});
		}
		
		return oldScene;
	}
	PvrPlayer.prototype.showScene = function(id){
		var scene = this.sceneList[id];

		if(!scene) return;

		if(this.curXmlPath != scene.options.vtour.xmlPath){
			this.changeXml(scene.options.vtour.xmlPath, true);
		}
		this.krpano.call('loadscene("s'+id+'")');
		this.krpano.call('skin_update_scene_infos()');
	}
	PvrPlayer.prototype.getCurSceneId = function(id){
		return this.krpano.get('xml.scene').replace('s', '');
	}

	PvrPlayer.prototype.addHotspot = function(id, ath, atv, userOptions, changeXml){
		var key, newHotspot, options={};
		changeXml = changeXml===undefined? true: changeXml;

		if(this.hotspotList[id]){
		  	console.error('ID duplication');
		  	return false;
		}

		//사용자 option을 적용시킴
		for(key in userOptions) options[key] = userOptions[key];
		if(options.sceneId!==undefined) 	options.scene = this.sceneList[options.sceneId];
		if(options.icon!==undefined)	options.icon = this.iconList[options.icon];
		else{
			options.icon = {
				options: {
					iconUrl: 'source/circle.png'
				}
			};
		}

		newHotspot = new Hotspot(id, ath, atv, options);
		if(!newHotspot){
		  	console.error('Fail to create new Scene');
		  	return false;
		}

		this.hotspotList[id] = newHotspot;

		if(changeXml){
			$.ajax({
				async : false,
			  	url: 'xml.php',
			  	type: 'get',			   
			  	data:{
			   		req:'addHotspot',
			   		data: {
			   			xmlUrl: options.scene.options.vtour.xmlPath,
			   			krpanoName: this.krpanoName,
			   			scene: 's'+options.scene.id,
			   			iconUrl: "%HTMLPATH%/"+options.icon.options.iconUrl,
			   			id: 'h'+id,
			  			ath: ath,
			  			atv: atv, 			  			
			   			options: newHotspot.getSimpleOptions()
			   		}	      		
			   	}			   	
			});
			$.ajax({
			  	url: 'xml.php',
			   	async : false,	    	
			  	data:{
			   		req:'addTextfield',
			   		data: {
			   			name: 'tf'+id,
			   			sceneName: 's'+options.scene.id,
			  			xmlUrl: options.scene.options.vtour.xmlPath,
			   			hotspotName: 'h'+id,
			   			options: {
			   				text: options.text
			   			}
			   		}
			   	},
			   	type: 'get'
			});
		}
		return newHotspot;
	}
	PvrPlayer.prototype.delHotspot = function(id, modXml){
		var key, oldHotspot;
		modXml = modXml===undefined? true: modXml;

		this.krpano.call('removehotspot(h'+id+')');
		oldHotspot = this.hotspotList[id];
		delete this.hotspotList[id];

		if(modXml){
			$.ajax({
			  	url: 'xml.php',
			   	async : false,	    	
			  	data:{
			   		req:'delHotspot',
			   		data: {
			   			id: 'h'+id,
			  			xmlUrl: oldHotspot.options.scene.options.vtour.xmlPath,
			   		}	      		
			   	},
			   	type: 'get'
			});
		}		
		return oldHotspot;
	}
	
	PvrPlayer.prototype.addIcon = function(id, options){
		this.iconList[id] = new HotspotIcon(id, options);
		return this.iconList[id];
	}
	PvrPlayer.prototype.delIcon = function(id){
		var oldIcon = this.iconList[id];
		delete this.iconList[id];
		return oldIcon;
	}

	PvrPlayer.prototype.changeXml = function(xmlPath, clearAll){
		var flag = clearAll? 'IGNOREKEEP': '';
		this.krpano.call('loadpano("%HTMLPATH%/'+xmlPath+'?'+(new Date()).getTime()+'", "", '+flag+')');
		this.curXmlPath = xmlPath;
	}

	PvrPlayer.prototype.addVtour = function(id, xmlPath, userOptions){
		var key, newVtour, options={};

		if(this.vtourList[id]){
		  	console.error('ID duplication');
		  	return false;
		}

		//사용자 option을 적용시킴
		for(key in userOptions) options[key] = userOptions[key];
		if(options.scene!==undefined) 	options.scene = this.sceneList[options.scene];
		
		newVtour = new Vtour(id, xmlPath, options);
		if(!newVtour){
		  	console.error('Fail to create new Vtour');
		  	return false;
		}

		this.vtourList[id] = newVtour;
		return newVtour;
	}
	PvrPlayer.prototype.delVtour = function(id){
		var key, oldVtour;

		oldVtour = this.vtourList[id];

		while(key in this.sceneList){
			if(this.sceneList[key].options.vtourId == id){
				this.delScene(key, false);
			}
		}
		delete this.vtourList[id];
		return oldVtour;
	}

	PvrPlayer.prototype.setView = function(ath, atv, fov){
		fov = fov || this.krpano.get('view.fov');

		this.krpano.call("lookto("+ath+","+atv+","+fov+", tween())")
	}

	PvrPlayer.prototype.clearScreen = function(){
		if(this.curXmlPath != 'template/krpano.xml')
			this.changeXml('template/krpano.xml', true);
	}

	PvrPlayer.prototype.startDraggingHotspot = function(id){
		this.krpano.call('draghotspot("", h'+id+');');
	}

	PvrPlayer.prototype.setForVtour = function(id){
		if(!this.vtourList[id]) return false;

		if(this.curXmlPath != this.vtourList[id].xmlPath){
			this.changeXml(this.vtourList[id].xmlPath, true);
		}
	}

	PvrPlayer.prototype.addTextfield = function(id, userOptions, changeXml){
		var key, options={}, newTextfield, scene;
		changeXml = changeXml===undefined? true: changeXml;

		if(this.textfieldList[id]){
		  	console.error('ID duplication');
		  	return false;
		}

		for(key in userOptions) options[key] = userOptions[key];
		if(options.hotspotId!==undefined)	options.hotspot = this.hotspotList[options.hotspotId];
		
		newTextfield = new Textfield(id, options);
		if(!newTextfield){
		  	console.error('Fail to create new textfield');
		  	return false;
		}

		scene = options.hotspot.options.scene;
		this.textfieldList[id] = newTextfield;

		if(changeXml){
			$.ajax({
			  	url: 'xml.php',
			   	async : false,	    	
			  	data:{
			   		req:'addTextfield',
			   		data: {
			   			name: 't'+id,
			  			xmlUrl: scene.options.vtour.xmlPath,
			  			sceneName: 's'+scene.id,
			  			hotspotName: 'h'+options.hotspotId, 
			   			options: newTextfield.getSimpleOptions()
			   		}	      		
			   	},
			   	type: 'get'
			});
		}

		return newTextfield;
	}

	return PvrPlayer;
})();

var Scene = (function(){
	function Scene(id, options){
		var key, optionsForServer = {};

		this.id = id;
		this.options = {
			initialAtv: 0,
			initialAth: 0,
			initialFov: 90
		};
		this.hotspotList = {};
		for(key in options) this.options[key] = options[key];		
	}

	Scene.prototype.setOption = function(key, val){
		this.options[key] = val;

		if(key == "pvrPath" || key == "initialAth" || key == "initialAtv" || key == "initialFov" || key=="name"){
			$.ajax({
			  	url: 'xml.php',
			   	async : false,	    	
			  	data:{
			   		req:'setScene',
			   		data: {
			   			id: 's'+this.id,
			  			xmlUrl: this.options.vtour.xmlPath,
			   			key: key,
			   			val: val
			   		}
			   	},
			   	type: 'get'
			});
		}
	}
	Scene.prototype.getSimpleOptions = function(){
		var key, simpleOptions = {};

		for(key in this.options){
			simpleOptions[key] = this.options[key];
		}
		delete simpleOptions.pvrPlayer;
		if(simpleOptions.vtour)	simpleOptions.vtour = simpleOptions.vtour.id;
		
		return simpleOptions;
	}
	Scene.prototype.addHotspot = function(hotspot){
		this.hotspotList[hotspot.id] = hotspot;
	}
	return Scene;
})();

var HotspotIcon = (function(){
	function HotspotIcon(id, options){
		this.id = id;
		this.options = options
	}
	HotspotIcon.prototype.setOption = function(key, val){
		this.options[key] = val;		
	}
	
	return HotspotIcon;
})();

var Vtour = (function(){
	function Vtour(id, xmlPath, options){
		this.id = id;
		this.xmlPath = xmlPath;
		this.options = options;
	}	
	return Vtour;
})();

var Hotspot = (function(){
	function Hotspot(id, ath, atv, options){
		this.id = id;
		this.ath = ath;
		this.atv = atv;
		this.options = options;
		this.event = {};
	}
	Hotspot.prototype.getSimpleOptions = function(){
		var key, simpleOptions = {};

		for(key in this.options){ simpleOptions[key] = this.options[key]; }
		if(simpleOptions.scene)	delete simpleOptions.scene;
		if(simpleOptions.icon)	simpleOptions.icon = simpleOptions.icon.id;
		
		return simpleOptions;
	}
	Hotspot.prototype.setOption = function(key, val){
		this.options[key] = val;

		if(key == "textInfo"){
			$.ajax({
			  	url: 'xml.php',
			   	async : false,	    	
			  	data:{
			   		req:'setTextfield',
			   		data: {
			   			name: 'tf'+this.id,
			   			sceneName: 's'+this.options.scene.id,
			  			xmlUrl: this.options.scene.options.vtour.xmlPath,
			   			hotspotName: 'h'+this.id,
			   			options: {
			   				text: val
			   			}
			   		}
			   	},
			   	type: 'get'
			});
		}
	}
	Hotspot.prototype.setAthAtv = function(ath, atv){
		this.ath = ath;
		this.atv = atv;

		$.ajax({
		  	url: 'xml.php',
		   	async : false,	    	
		  	data:{
		   		req:'setHotspot',
		   		data: {
		   			id: 'h'+this.id,
		   			scene: this.options.sceneid,
		  			xmlUrl: this.options.scene.options.vtour.xmlPath,
		   			ath: ath,
		   			atv: atv
		   		}
		   	},
		   	type: 'get'
		});		
	}
	Hotspot.prototype.on = function(name, func, context){
		if(!this.event[name]) this.event[name] = [];
		this.event[name].push({action: func, context: context?context:this});
	}
	Hotspot.prototype.off = function(name){
		if(!this.event[name]) this.event[name] = [];
		this.event[name].pop();
	}
	Hotspot.prototype.fire = function(name, data){
		var i, ev={};

		ev.type = name;
		ev.target = this;
		if(name == "addNewNode" || name == "moveNode" || name ==" deleteNode" ||
			name == "changeNodeAttr" || name == "clickNode"){
			if(!data) return false;
			ev.node = data;
		}

		if(!this.event[name]) return;
		for(i=0; i<this.event[name].length; i++){
		    this.event[name][i].action.call(this.event[name][i].context, ev);
		}
	}
	return Hotspot;
})();

var Textfield = (function(){
	function Textfield(id, userOptions){
		var options={}, key;
		for(key in userOptions) options[key] = userOptions[key];

		this.id = id;
		this.options = options;
		this.event = {};
	}

	/*options에 content가 들어감*/
	function _setContentInXml(textfield, content){
		var hotspot, scene, vtour, xmlPath, options;
		if(!textfield.options.hotspot) return;
			
		hotspot = textfield.options.hotspot;
		scene = hotspot.options.scene;
		xmlPath = scene.options.vtour.xmlPath;

		$.ajax({
		  	url: 'xml.php',
		   	async: false,
		   	type: 'get',	    	
		  	data:{
		   		req:'setTextfield',
		   		data: {
		   			id: 't'+this.id,
		   			hotspotName: 'h'+this.options.hotspotId,
		  			xmlUrl: xmlPath,
		  			options: content
		   		}
		   	},
		});
	}

	Textfield.prototype.getSimpleOptions = function(){
		var key, simpleOptions = {};

		for(key in this.options){
			simpleOptions[key] = this.options[key];
		}
		delete simpleOptions.hotspot;
		//if(simpleOptions.vtour)	simpleOptions.vtour = simpleOptions.vtour.id;		
		return simpleOptions;
	}


	/*Hotspot.prototype.setContent = function(ath, atv){
		this.ath = ath;
		this.atv = atv;

		$.ajax({
		  	url: 'xml.php',
		   	async : false,	    	
		  	data:{
		   		req:'setTextfield',
		   		data: {
		   			id: 't'+this.id,
		   			hotspotId: this.options.hotspotId,
		  			xmlUrl: this.options.scene.options.vtour.xmlPath,
		   			ath: ath,
		   			atv: atv
		   		}
		   	},
		   	type: 'get'
		});		
	}
	Hotspot.prototype.on = function(name, func, context){
		if(!this.event[name]) this.event[name] = [];
		this.event[name].push({action: func, context: context?context:this});
	}
	Hotspot.prototype.off = function(name){
		if(!this.event[name]) this.event[name] = [];
		this.event[name].pop();
	}
	Hotspot.prototype.fire = function(name, data){
		var i, ev={};

		ev.type = name;
		ev.target = this;
		if(name == "addNewNode" || name == "moveNode" || name ==" deleteNode" ||
			name == "changeNodeAttr" || name == "clickNode"){
			if(!data) return false;
			ev.node = data;
		}

		if(!this.event[name]) return;
		for(i=0; i<this.event[name].length; i++){
		    this.event[name][i].action.call(this.event[name][i].context, ev);
		}
	}*/
	return Textfield;
})();