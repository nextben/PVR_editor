Line.prototype = new L.Polyline([[0,0], [0,0]]);
Line.prototype.constructor = Line;

function Line(latlngs, length, polyline, timeline){
  	L.Polyline.call(this, [latlngs[0], latlngs[1]], {weight:9});

	//polyline의 시작점에서 부터의 거리
	this.distFromStart = length;
	//이 line을 포함하는 polyline
	this.parentPolyline = polyline;
	//이 line을 포함하는 timeline
	this.parentTimeline = timeline;
    this.on('click', function(ev){
        var polyline = this.parentPolyline;
        var timeline = this.parentTimeline;
        
        //이 polyline에 저장된 video url이 없다면 return.
        if(!polyline.video || polyline.video.url == "null") return;

        //현재 이 polyline의 video가 실행되던 중이라면 timestamp 조정
        if(polyline.floor.contents.videoPlayer.getPolyline() == polyline){
          	var latlng = this.adjustLatLng(ev.latlng);

            var dist = this.getPathDistByLatLng(latlng);
            var per = timeline.getPerByDist(dist);
            if(per>=1) return;
            polyline.floor.contents.videoPlayer.setByPer(per);

            polyline.addTimeStamp(latlng);
        }
        //현재 이 polyline의 video가 실행되던 것이 아니라면 
        //동영상을 처음부터 재생(시간 조정 X)
        else if(polyline.floor.contents.videoPlayer.getPolyline() != polyline){
         	polyline.addTimeStamp(polyline.timelines[0].lines[0].getLatLngs()[0]);
            polyline.floor.contents.videoPlayer.setByPolyline(polyline);
        }
	})
    //선분을 우클릭시 새로운 timeline 생성
    .on('contextmenu', function(ev){
        var polyline = this.parentPolyline;
        var latlng = ev.latlng;
        var per = polyline.floor.contents.videoPlayer.getPer();

        if(polyline.floor.contents.videoPlayer.getPolyline() != polyline) return;   
        
        if(polyline.divideTimeline(per, latlng, this)){
         	polyline.addTimeStamp(latlng);
          	polyline.addMidPoint(this.adjustLatLng(latlng));
        }
    });
    /*.on('dblclick', function(ev){
        var polyline = this.parentPolyline;
        var r=confirm("경로를 삭제 하시겠습니까?");
    	if(!r) return;
    	
        polyline.hide();
    	polyline.fire('delete');
    });*/

	
	this.getAngle = function(){
	    var latlngs = this.getLatLngs();
        var map = this.parentPolyline.floor.contents.map;

	    var p0 = map.project(latlngs[0], 0);
	    var p1 = map.project(latlngs[1], 0);
	    return twoPointsAngle(p0, p1);
	};

	this.getDist = function(latlng){
	    var latlngs = this.getLatLngs();
        var map = this.parentPolyline.floor.contents.map;

	    var p0 = map.project(latlngs[0], 0);
	    var p1 = latlng? 
	                map.project(latlng, 0): 
	                map.project(latlngs[1], 0);
	    return getDistance(p0, p1);
	};
	        
	//클릭 latlng을 통하여 timeline시작점으로 부터 거리를 구하는 함수
	this.getPathDistByLatLng = function(latlng){
	    return this.distFromStart + this.getDist(latlng);
	};

	//timeline시작점으로 부터 거리를 통하여 latlng을 구하는 함수
	this.getLatLngByPathDist = function(pathDist){
        var map = this.parentPolyline.floor.contents.map;

	    var basePoint = map.project(this.getLatLngs()[0], 0);
	    var dist = pathDist - this.distFromStart;
	    var angle = this.getAngle();
	    var x = basePoint.x + dist*Math.cos(angle);
	    var y = basePoint.y + dist*Math.sin(angle);

	    return map.unproject([x, y], 0);
	};
	//주어진 latlng이 선의 양 끝과 가까운지 판단하는 함수
	this.isLatLngAtEnd = function(latlng){
	    var latlngs = this.getLatLngs();
        var map = this.parentPolyline.floor.contents.map;

	    var p0 = map.project(latlngs[0], map.getZoom());
	    var p1 = map.project(latlngs[1], map.getZoom());
	    var p2 = map.project(latlng, map.getZoom());
	    //시작점과 가깝다면 1을 return
	    if(getDistance(p0, p2)<10)  return 1;
	    //끝점과 가깝다면 2를 return
	    if(getDistance(p1, p2)<10)  return 2;
	    //끝점과 가깝지 않다면 0을 return
	    return 0;
	};
  	//선분 근처의 좌표를 선분로 오도록 조정해 주는 함수
  	this.adjustLatLng = function(latlng){
        //선분 시작점으로 부터의 거리를 구하고
        var dist = this.getPathDistByLatLng(latlng);
        //이 거리로 다시 선분 위의 latlng을 얻는다.
        var newLatLng = this.getLatLngByPathDist(dist);
        //이 latlng이 선분의 양 끝과 가까운지 판단하여
        var ret = this.isLatLngAtEnd(newLatLng);
        //충분히 가깝다면 양 끝으로 이동시킨다.
        if(ret == 1)  newLatLng = this.getLatLngs()[0];
        if(ret == 2)  newLatLng = this.getLatLngs()[1];
        return newLatLng;                 
    };
    
    //선분을 제거
    this.remove = function(){
        if(this._map) this._map.removeLayer(this);
        this.parentTimeline.length -= this.getDist();
    };

    this.hide = function(){
        if(this._map) this._map.removeLayer(this);
    };

    this.show = function(map){        
        this.addTo(map);
    };
    this.showForView = function(map){
        this.off('dblclick');
        this.off('contextmenu');
        this.addTo(map);
    };
    this.preventDefault = function(){

    };
}

/*timeline이란 timestamp가 같은 속력으로 이동하는 선분의 모임
처음 polyline은 하나의 timeline을 가지고 우클릭시마다 timeline이 생성된다.*/
function Timeline(perAtStart, perAtEnd, polyline){
    this.lines = [];
    //timeline의 시작점과 대응되는 동영상의 진행 퍼센트값
    this.perAtStart = perAtStart;
    this.perAtEnd = perAtEnd;
    this.length = 0;
    this.parentPolyline = polyline;

    this.getDistByPer = function(per){
        if(this.perAtEnd-this.perAtStart == 0) return 0;
        return (per-this.perAtStart)/(this.perAtEnd-this.perAtStart)*this.length;
    };
    this.getPerByDist = function(dist){
        if(this.length == 0) return this.perAtStart;
        return (dist/this.length)*(this.perAtEnd-this.perAtStart)+this.perAtStart;
    };
        
    this.getLineByDist =  function(dist){
        for(var i=0; i<this.lines.length && dist>=this.lines[i].distFromStart; i++);
        if(i != 0)  return this.lines[i-1];
        else        return this.lines[0];                
    };

    this.addLine = function(latlngs, lineEvents){
        var newLine = new Line(latlngs, this.length, this.parentPolyline, this);
        var name, i;

        this.length += newLine.getDist();
        this.lines.push(newLine);
        this.parentPolyline.lineLayer.addLayer(newLine);

        if(lineEvents){
            for(name in lineEvents){
                for(i=0; i<lineEvents[name].length; i++){
                    newLine.on(name, lineEvents[name][i].action, lineEvents[name][i].context);
                }                
            }
        }
        

        return newLine;
    };   
    
    this.getIndexOfLine = function(line){
        for(var i=0; i<this.lines.length && this.lines[i]!=line; i++);
        if(i == this.lines.length) return false;
        return i;
    };

    this.addLatLng = function(latlng, lineEvents){
        var lines = this.lines;
        //가장 처음 timeline의 시작시에는 점이 찍히지만
        //이후에는 점이 찍히지 않는다.
        //모든 timeline의 첫번째 line은 시작 점이다.
        if(lines.length == 0)   this.addLine([latlng, latlng], lineEvents);
        else{
            if(lines.length == 1 && lines[0].getLatLngs()[0].lat == lines[0].getLatLngs()[1].lat  &&
                lines[0].getLatLngs()[0].lng == lines[0].getLatLngs()[1].lng){
                this.addLine([lines[lines.length-1].getLatLngs()[1], latlng], lineEvents)
                lines[0].remove();
                lines.splice(0, 1);                
            }   
            else this.addLine([lines[lines.length-1].getLatLngs()[1], latlng], lineEvents);
        }
    };

    this.getLatLngs = function(){
        var retLatLngs = [];
        if(this.lines.length == 0) return retLatLngs;

        retLatLngs.push(this.lines[0].getLatLngs()[0])    

        if(this.lines.length > 1 || this.lines[0].getLatLngs()[0] != this.lines[0].getLatLngs()[1]){
            for(var j=0; j<this.lines.length; j++)
                retLatLngs.push(this.lines[j].getLatLngs()[1]);
        }
                
        return retLatLngs;
    };
}

Timeline.prototype.hide = function(){
    var i;
    for(i=0; i<this.lines.length; i++)
        this.lines[i].hide();
}

Timeline.prototype.show = function(map){
    var i;
    for(i=0; i<this.lines.length; i++)
        this.lines[i].show(map);
}
Timeline.prototype.showForView = function(map){
    var i;
    for(i=0; i<this.lines.length; i++)
         this.lines[i].showForView(map);
}


function Polyline(id, floor, levelBound, video){
    if( Object.prototype.toString.call( levelBound ) === '[object Array]'  && levelBound.length == 2 )
        this.levelBound = {
            min: levelBound[0],
            max: levelBound[1]
        }
    else if(typeof levelBound == "object")
        this.levelBound = levelBound;

    this.floor = floor;
    this.id = id;
	this.timelines = [];
    this.midPointLayer = L.layerGroup().addTo(this.floor.contents.map);
    this.lineLayer = L.layerGroup();
	this.eventForLines = {};
    this.video = video;
    this.event = {};
    this.options = {};
    this.lineEvents = {};
}

Polyline.prototype.addTimeline = function(perAtStart, perAtEnd, latlngs){
    var isFirst = this.timelines.length == 0? true: false;        
    var newTimeline = new Timeline(perAtStart, perAtEnd, this);
    var i;  
    
    for(i=0; latlngs && i<latlngs.length; i++)
        newTimeline.addLatLng(latlngs[i], this.lineEvents);
    
    this.timelines.push(newTimeline);
    this.hide();
    this.show(this.floor.contents.map);

    //timeline이 추가된다면 mid point 역시 추가되어야함
    if(!isFirst) this.addMidPoint(latlngs[0]);
    return newTimeline;
}
Polyline.prototype.addLatLng = function(latlng){
    var isFirst = this.timelines.length == 0? true: false;
    
    if(isFirst)     this.addTimeline(0, 1);
    this.timelines[this.timelines.length-1].addLatLng(latlng, this.lineEvents);

    this.hide();
    this.show(this.floor.contents.map);

    return this;
}

//Polyline.prototype.addTSByPer = function(per){
Polyline.prototype.getLatLngByPer = function(per){
	var timeline = this.getTimelineByPer(per);    
    var dist = timeline.getDistByPer(per);
    var line = timeline.getLineByDist(dist);
    return line.getLatLngByPathDist(dist);
}

Polyline.prototype.addTimeStamp = function(latlng){
    var timestampLayer = this.floor.contents.videoPlayer.timestampLayer;

	if(!this.floor.contents.map.hasLayer(timestampLayer)) timestampLayer.addTo(this.floor.contents.map);
    timestampLayer.clearLayers();
    timestampLayer.addLayer(L.marker(latlng, {icon: L.icon({iconUrl:"source/marker.png", iconSize:[19.5, 40], iconAnchor: [10, 40]})}));
}

Polyline.prototype.getIndexOfTimeline = function(timeline){
    for(var i=0; i<this.timelines.length && this.timelines[i]!=timeline; i++);
    return i;
}

Polyline.prototype.getTimelineByPer = function(per){
    for(var i=0; i<this.timelines.length && per>=this.timelines[i].perAtStart; i++);
    if(i > 0) return this.timelines[i-1];
    else      return this.timelines[0];
}


/*	우클릭시 polyline내에 새로운 timeline 추가 
    per 	: 이전 timeline의 끝점과 새 timeline의 시작점과 대응되는 퍼센트
    latlng 	: timeline 경계의 좌표
    line 	: latlng이 속해있는 선분*/         
Polyline.prototype.divideTimeline = function(per, latlng, line){
    var timeline = line.parentTimeline;
    
    if(timeline.perAtStart > per || timeline.perAtEnd < per || 
            timeline.perAtStart == timeline.perAtEnd) return false;

    //분할점의 위치를 조정한다. 
    var ret = line.isLatLngAtEnd(latlng);
    latlng = line.adjustLatLng(latlng);
    
    //폴리라인에서 해당 타임라인의 인덱스를 획득한다.         
    var i  = this.getIndexOfTimeline(timeline);


    //새로운 타임라인을 생성한다.  
    var newTimeline = new Timeline(per, this.timelines[i].perAtEnd, this); 
    //기존 타임라인의 끝을 비디오의 현재 지점으로 설정한다.
    this.timelines[i].perAtEnd = per;

    newTimeline.addLatLng(latlng, this.lineEvents);
    //타임라인 배열에 새 항목을 추가한다.
    this.timelines.splice(i+1, 0, newTimeline);
    

    var j = this.timelines[i].getIndexOfLine(line);

    //분할된 라인은 제거하고, 이전 타임라인의 라인들을 새로운 타임 라인으로 넘겨준다.
    for(var k=j; k<timeline.lines.length; k++) timeline.lines[k].remove();
    //timeline.lines[j].hide();
    var temp = this.timelines[i].lines.splice(j, timeline.lines.length-j+1);
    if(j==0) this.timelines[i].addLatLng(temp[0].getLatLngs()[0], this.lineEvents);


    this.timelines[i].length = line.distFromStart;            
            
    if(ret != 1) this.timelines[i].addLatLng(latlng, this.lineEvents);
    if(ret == 2) temp.shift();
    while(temp.length > 0){
        newTimeline.addLatLng(temp.shift().getLatLngs()[1], this.lineEvents);
    }
    this.show(this.floor.contents.map);
    return true;
}

Polyline.prototype.addMidPoint = function(latlng){
    var midPoint = L.circleMarker(latlng).setRadius(10);
    this.midPointLayer.addLayer(midPoint);
    //timeline경계점을 맨 뒤로 보냅니다.
    midPoint.bringToBack();
}

Polyline.prototype.hide = function(){
    var i;

    for(i=0; i<this.timelines.length; i++){
        this.timelines[i].hide();
    }
    this.floor.contents.map.removeLayer(this.midPointLayer);
    if(this.floor.contents.videoPlayer.getPolyline() == this){
        this.floor.contents.videoPlayer.clearTimeInterval();
        this.floor.contents.videoPlayer.clearVideo();
    }
}

Polyline.prototype.show = function(map){
    var i;
    for(i=0; i<this.timelines.length; i++)
         this.timelines[i].show(map);
    this.floor.contents.map.addLayer(this.midPointLayer);
}       

Polyline.prototype.showForView = function(map){
    var i;
    for(i=0; i<this.timelines.length; i++)
         this.timelines[i].showForView(map);
    this.floor.contents.map.addLayer(this.midPointLayer);
}

Polyline.prototype.getLevelBound = function(){
    return this.levelBound;
}
Polyline.prototype.setVideo = function(video){
    this.video = video;
}

/*Polyline.prototype.on = function(type, func){
    if      (type=="delete")        this.remove = func;
    else if (type=="latlngadd")     this.latlngadd = func;
    else if (type=="timelineadd")   this.timelineadd = func;
}*/

Polyline.prototype.on = function(name, func, context){
    if(!this.event[name]) this.event[name] = [];
    this.event[name].push({action: func, context: context?context:this});
}

Polyline.prototype.off = function(name){
    if(!this.event[name]) this.event[name] = [];
    this.event[name].pop();
}

Polyline.prototype.fire = function(name){
    var i;
    if(!this.event[name]) return;
    for(i=0; i<this.event[name].length; i++){
        this.event[name][i].action.call(this.event[name][i].context);
    }
}

Polyline.prototype.onToLine = function(name, func){
    var i, j;

    if(!this.lineEvents[name]) this.lineEvents[name] = [];
    this.lineEvents[name].push({action: func, context: null});

    for(i=0; i<this.timelines.length; i++){
        for(j=0; j<this.timelines[i].lines.length; j++){
            this.timelines[i].lines[j].on(name, func);
        }
    }
}

Polyline.prototype.offToLine = function(name, func){
    var i, j;

    if(!this.lineEvents[name]) this.lineEvents[name] = [];
    this.lineEvents[name].pop();

    for(i=0; i<this.timelines.length; i++){
        for(j=0; j<this.timelines[i].lines.length; j++){
            this.timelines[i].lines[j].off(name, func);
        }
    }
}

Polyline.prototype.setStyle = function(options){
    var i, j;

    this.options = options;
    for(i=0; i<this.timelines; i++){
        for(j=0; j<this.timelines[i].lines; j++){
            this.timelines[i].lines[j].setStyle(options);
        }
    }
}

/*Polyline.prototype.changeColor = function(color){
    var i, j;
    this.hide();
    for(i=0; i<this.timelines.length; i++){
        for(j=0; j<this.timelines[i].lines.length; j++){

            this.thimelines[i].lines[j].option.color = color;
        }
    }
    this.show(this.floor.contents.map);
}*/

var PI = Math.PI;
function getDistance(p1, p2){
    return Math.sqrt(Math.pow((p2.x - p1.x), 2) + Math.pow((p2.y - p1.y), 2));
}
function twoPointsAngle(point1, point2){
    var relpoint = {'x':point2.x - point1.x, 'y':point2.y - point1.y};

    if(relpoint.x > 0 && relpoint.y >= 0)
        return Math.atan(relpoint.y/relpoint.x);
    if(relpoint.x == 0 && relpoint.y > 0) return PI/2;
    if(relpoint.x < 0 && relpoint.y > 0)
        return Math.atan(relpoint.y/relpoint.x)+PI;
    if(relpoint.x < 0 && relpoint.y <= 0)
        return Math.atan(relpoint.y/relpoint.x)+PI;
    if(relpoint.x == 0 && relpoint.y < 0) return 3*PI/2;
    if(relpoint.x > 0 && relpoint.y < 0)
        return Math.atan(relpoint.y/relpoint.x);
    if(relpoint.x == 0 && relpoint.y == 0) return 0;
}

