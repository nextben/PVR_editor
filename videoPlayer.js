function VideoPlayer(container, options){
  this.polyline = null;
  this.intervalId = null;
  this.timestampLayer = L.layerGroup();
  this.mode = options?options.mode:null;
  this.event = {};
 
  if(!options || options.mode == "htmlVideo"){
    this.container = $(container);         
    
    this.play = function(){ this.container[0].play(); };
    this.stop = function(){ this.container.stop(); };
    this.pause = function(){ this.container[0].pause(); };
    this.getCurrentTime = function(){ return this.container[0].currentTime; };
    this.getDuration = function(){ return this.container[0].duration; };
    this.setCurrentTime = function(time){ this.container[0].currentTime = time };
    this.setUrl = function(url){ this.container.attr('src', url); };
  }
  else if(options.mode == "krpano"){
    this.container = container;
    //playstate: 0 재생하지 않음
    //           1 동영상 주소 설정
    //           2 동영상 재생
    this.playstate = 0;
    this.videoUrl = null;

    this.play = function(){
      if(this.playstate == 1){
        this.playstate = 2;
        // this.container.call("loadpano(krpano.xml?"+(new Date()).getTime()+")");
        this.container.call(
          "loadscene("+
            "krpano_video, "+
            "plugin[video].videourl=../../"+this.videoUrl+
          ")"
        );
      }
      else if(this.playstate == 2){
        if( this.container.get("plugin[video].loaded") )
          this.container.call("plugin[video].play()");
      }
    };
    this.stop = function(){
      if( this.container.get("plugin[video].loaded") )
        this.container.call("plugin[video].stop()");
    };
    this.pause = function(){
      if( this.container.get("plugin[video].loaded") )
        this.container.call("plugin[video].pause()");
    };
    this.getCurrentTime = function(){ return this.container.get("plugin[video].time") };
    this.getDuration = function(){ return this.container.get("plugin[video].totaltime"); };
    this.setCurrentTime = function(time){ this.container.call("plugin[video].seek(" + time + ")"); };
    this.setUrl = function(url){             
      this.videoUrl = url;
      this.playstate = 1;
    };
    this.clearDisplay = function(){
      this.container.call("loadscene(krpano_video)");
      this.playstate = 0;
      this.videoUrl = null;
    }
  }
}

VideoPlayer.prototype.getPer = function(){
  if(!this.getDuration()) return 0;
  return this.getCurrentTime()/this.getDuration();
}
VideoPlayer.prototype.getUrl = function(){
  if(this.polyline) return this.polyline.video.url;
  else              return '';
}

VideoPlayer.prototype.setByPer = function(per){
  this.setCurrentTime( this.getDuration()*per );
};

VideoPlayer.prototype.getPolyline = function(){
  return this.polyline;
};

VideoPlayer.prototype.clearVideo = function(){
  this.stop();
  this.clearDisplay();
  this.clearTimeInterval();
  this.polyline = null;
}

VideoPlayer.prototype.setByPolyline = function(polyline){
  this.clearVideo();

  if(polyline){
    this.playstate = 1;
    this.polyline = polyline;
    this.setUrl( polyline.video.url );
    this.play();
          
    var that = this;
    this.intervalId = window.setInterval(function(){
      var per = that.getPer();
      var latlng = that.polyline.getLatLngByPer(per);
      that.polyline.addTimeStamp(latlng);
    }, 700);
  }
};

VideoPlayer.prototype.clearTimeInterval = function(){
  window.clearInterval(this.intervalId);
  this.timestampLayer.clearLayers();        
};

VideoPlayer.prototype.on = function(name, func, context){
  if(!this.event[name]) this.event[name] = [];
  this.event[name].push({action: func, context: context?context:this});
}
VideoPlayer.prototype.off = function(name){
  if(!this.event[name]) this.event[name] = [];
  this.event[name].pop();
}
VideoPlayer.prototype.fire = function(name){
  var i;
  if(!this.event[name]) return;
  for(i=0; i<this.event[name].length; i++){
    this.event[name][i].action.call(this.event[name][i].context);
  }
}
