<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta Http-Equiv="Cache-Control" Content="no-cache">
    <meta Http-Equiv="Pragma" Content="no-cache">
    <meta Http-Equiv="Expires" Content="0">
    <meta Http-Equiv="Pragma-directive: no-cache">
    <meta Http-Equiv="Cache-directive: no-cache">

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>    
    <script src="http://malsup.github.com/jquery.form.js"></script>
    <script src="http://cdn.leafletjs.com/leaflet-0.7.2/leaflet.js"></script>
    <script src="leaflet.label.js"></script>
    
    <script src="fileTree.js"></script>
    <script src="marker.js"></script>
    <script src="view.js"></script>
    <script src="tileLayer.js"></script>
    <script src="icon.js"></script>
    <script src="map.js"></script>
    <script src="pvrPlayer.js"></script>
    <script src="embedpano.js"></script>
    <script src="video.js"></script>
    <script src="videoPlayer.js"></script>
    <script src="polyline.js"></script>

    <link rel="stylesheet" href="fileTree.css" />
    <link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7.1/leaflet.css" />
    <link rel="stylesheet" href="leaflet.label.css" />

    <style>
      @import url(http://fonts.googleapis.com/earlyaccess/nanumgothic.css);
      html {width:100%;height:100%;}
      body {margin:0; font-family:nanumgothic; display:inline-block; float:left; width:100%; height:100%;}

      #totalContainer {
        display: flex;
        display: -ms-flexbox;
        display: -webkit-box;
        display: -moz-box;
      }
      .halfContainer {
        flex: 1;
        -ms-flex: 1;
        -webkit-box-flex: 1;
        -moz-box-flex: 1;

        height:100%; 
        float:left;
      }
      .fullContainer {width:100%; height:100%; float:left;}
      #sizeHandler {width:10px; background-color:#EAEAEA; cursor:col-resize;}
      
      #leftContainer {width:50%; height:100%; float:left; position:relative;}
      .leaflet-container {background-color: white}

      #myKrpano>div>div:nth-child(1), #myKrpano>div>div:nth-child(2) {z-index:1000000;}

      .labelForInformation {max-width:200px; white-space:pre; word-wrap:break-word; float:left;}
      .labelForInformation .titleContainer {width:100%;float:left;clear:both;}
      .labelForInformation .imgContainer {max-width:200px; min-width:200px; max-height:150px; clear:both;margin-top:5px;}
      .labelForInformation .imgContainer img {max-width:100% !important; max-height:100%;margin:0 auto; display:block;}
      .labelForInformation .textContainer {width:100%; float:left;clear:both;font-weight:normal;margin-top:5px;}

      .hidden{display:none;}

      #linkPopupContainer {width:100%; height:100%; padding:8px; 
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
        -ms-box-sizing: border-box;
        -moz-box-sizing: borer-box;
        position:absolute;
        z-index:10000;
      }
      #linkPopupBody {width:100%; height:100%; box-shadow:5px 5px 5px;
        background-color: white;
        box-shadow:0 0 5px #666666;
        display: flex;
        display: -ms-flexbox;
        display: -webkit-box;
        display: -moz-box;
        -webkit-box-orient: vertical;
        -moz-box-orient: vertical;
        flex-direction: column;
        -ms-flex-direction: column;
      }
      #linkPopupMenuBar {width:100%; height:30px;
        -webkit-user-select:none;
        cursor:default;
      }
      #linkPopupMenuBar .closeBox {line-height:0.5; padding:4px; font-size:40px; float:right; cursor:pointer;}
      #linkPopupMenuBar .closeBox:hover {color:red;}
      #linkPopupContentWrapper {
        flex: 1;
        -ms-flex: 1;
        -webkit-box-flex: 1;
        -moz-box-flex: 1;
        width:100%; position:relative;}
      #linkPopupContent {position:absolute; width:100%; height:100%;}
      #linkPopupContent iframe {border:0; margin:0; width:100%; height:100%;}
      #linkPopupContent iframe::-webkit-scrollbar{width:5px; height:5px; background-color:rgba(0,0,0,0);}
      #linkPopupContent iframe::-webkit-scrollbar-thumb{width:5px; height:5px; background-color:#B2B7BA;border-radius:2px;}

      .transparent {
        visibility:hidden;
      }
      .layerContainer {position:relative; overflow:hidden;}
      .layer {position:absolute;}
      .leaflet-label {z-index:5000;}
      .tightenSize {overflow:hidden;}

      #commentButton{
        display: inline-block;
        font-family:Arial; font-weight:bold;
        font-size:0.8em;
        background-color: white;
        border-radius: 7px;
        padding: 5px;
        color: rgba(125, 125, 125, 1);
        cursor: pointer;
        -webkit-user-select:none;
      }
      #commentButton:hover{
        background-color: rgba(200, 200, 200, 1);
        color: white;
      }
      #commentButton.clicked{
        background-color: rgba(125, 125, 125, 1);
        color: white;
      }
      .topRight{
        position: relative;
        top: 10px;
        right: 10px;
        float: right;
      }
      .onPVR{
        position: relative;
        z-index:10000000;
      }
      #commentWindowPositioner{
        position:relative;
        display:inline-block;
        height: 95px;
      }
      #commentWindow{
        position:relative;
        display:inline-block;
        background-color: white;
        padding:10px;
        border-radius: 10px;
        left: -50%;
        top: -110px;
      }
      #commentWindow.hidden{
        display:none;
      }

      .buttonBox{ display: inline-block; margin-top:5px;}
      .buttonBox.right{        
        float: right;
      }

      .button{
        display: inline-block;
        font-family:Arial; 
        font-weight:bold;
        font-size:0.8em;
        background-color:#19BE9C;
        border-radius: 4px;
        padding: 5px;
        
        cursor: pointer;
        -webkit-user-select:none;
        margin-left: 5px;
        color:white;
        float:left;
      }
     
      .button:hover{
        background-color: #118069;
        color: #E6E6E6;
      }
      .button:active{
        background-color: #084035;
        color: #CCCCCC;
      }
      .window .title{
        font-weight: bold;
        margin-bottom: 5px;
      }

    </style>
  </head>
  <body>
    <div id="totalContainer" class="fullContainer">
      <div id="leftContainer">
        <div id="mapContainer" class="fullContainer"></div>
        <div id="linkPopupContainer" class="hidden">
          <div id="linkPopupBody">
            <div id="linkPopupMenuBar">
              <div class="closeBox">×</div>
            </div>
            <div id="linkPopupContentWrapper">
              <div id="linkPopupContent">
                <iframe></iframe>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div id="sizeHandler" class=""></div>
      <div id="rightContainer" class="halfContainer layerContainer">
        <div id="pvrContainer" class="pvrContents fullContainer layer"></div>
        <div id="videoContainer" class="tightenSize videoContents fullContainer layer"></div>
        <div id="commentButton" class="transparentButton topRight onPVR">Comment</div>
        <div id="commentWindowPositioner">
          <div id="commentWindow" class="window onPVR">
            <div class="title">Comment</div>
            <div>
              <input type="text" name="comment_text"/>            
            </div>
            <div class="buttonBox right">
              <div id="comment_input_button" class="button">Input</div>
              <div id="comment_delete_button" class="button">Delete</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script type="text/javascript">
    var file, db, curMainData, curMainIcon, projectId = null, userId, pvrPlayer, videoPlayer,
        googleTileUrl;
        
    googleTileUrl = "https://mts1.google.com/vt/lyrs=m@231000000&hl=ko&gl=KR&src=app&x={x}&y={y}&z={z}&s={s}";

    function checkDupleOfName(list, name){
      var i;
      for(i=0; i<list.length; i++)
        if(list[i].name == name)
          return true;
      return false;
    }
    function getIdxById(list, id){
      var i;
      for(i=0; i<list.length; i++)
        if(list[i].id == id)
          return i;
      return -1;
    }
    function noCacheUrl(url){
      return url+'?'+(new Date()).getTime();
    }

    $(document).ready(function(){
      map = new Map(0, "mapContainer", {
        mode  : "edit",
        useView : true
      });

      loadProject(<?php echo $_GET['project']?>);

      var isClicked = false, changeSize = false;
      $('#sizeHandler').mousedown(function(ev){
          ev.originalEvent.preventDefault();
          isClicked = true;
      });
      $('body').mouseup(function(ev){
        if(changeSize){
          isClicked = false;
          changeSize = false;
          map.map._onResize();
        }      
      });
      $('body').on('mousemove', function(ev){
        var baseWidth;
        if(isClicked){
          changeSize = true;
          baseWidth = $('#totalContainer').outerWidth();
          x = ev.pageX;
          x = Math.max(0+5, x);
          x = Math.min(baseWidth-5, x);          
          $('#leftContainer').css('width', x-5);

          if(videoPlayer) {
            videoPlayer.container.call('updatescreen()');
          }
          if(map) {
            map.map._onResize();
          }
        }  
      });

      var oldWidth = $('#totalContainer').outerWidth();
      $(window).resize(function resetSize(){
        var curWidth, ratio;      

        ratio = $('#leftContainer').css('width').replace('px','')/oldWidth;

        curWidth = $('#totalContainer').outerWidth();
        $('#leftContainer').css('width', curWidth*ratio);
        oldWidth = curWidth;
      });

      $('#linkPopupMenuBar .closeBox').click(function(){
        $('#linkPopupContainer').addClass('hidden');
      });

      initializeComment();
    });

    var db = {
      user: {},
      map: {},
      vtour: {},
      pvr: {},
      layer: {},
      markerIcon: {},
      hotspotIcon: {},
      marker: {},
      hotspot: {},
      video: {},
      polyline: {},
    };

    function loadProject(project){
      var key;

      $('#myKrpano').remove();
      $('#pathArea').html('');
      $('#anchor').addClass('hidden');
      $('.propertyElement').addClass('hidden');

      curMainData = null;
      curMainIcon = null;
      map._curLayer = null;

      for(key in db){
        if(key != "user"){
          db[key] = {};  
        }        
      }
      for(key in map.map._layers){
        map.map.removeLayer(map.map._layers[key]);
      }

      //-----------------------------
      //새로운 프로젝트 정보를 불러옴
      projectId = project;
      embedpano({
        target: "videoContainer", 
        id: "videoKrpano", 
        bgcolor: "#000000",  
        swf: "source/videoPlayer/krpano.swf",
        xml: noCacheUrl("source/videoPlayer/krpano.xml"),
        wmode: "transparent",
        html5: 'never',
        onready: setVideoPlayer
      });
      embedpano({
        target: "pvrContainer", 
        id: "myKrpano", 
        bgcolor: "#FFFFFF", 
        html5: "only", 
        xml: noCacheUrl("template/krpano.xml"),
        onready: setPvrPlayer
      });      
      
      loadData('map', projectId);
      
      map.map.on('baselayerchange', function (ev){
        var i, layerList, layer;


        setContentsOfRightContainer('pvr');

        i = ev.layer.id;
        layer = loadData('layer', i); 
        console.log("이 문장은 두번 출력 됩니다.", layer.options.mainPvr);
        if(layer.options.mainPvr){
          loadData('pvr', layer.options.mainPvr)
          pvrPlayer.showScene(layer.options.mainPvr);
        }
        else {
          pvrPlayer.clearScreen();
        }
      });

      //load every layer of project from server and add layer controller to map
      for(i=0; i<db.map[projectId].options.layerList.length; i++){
        loadData('layer', db.map[projectId].options.layerList[i].id);
      }
      map.drawLayerController(db.map[projectId].options.layerList);

      //load every marker icon of project from server
      $.ajax({
        async: false,
        type: 'get',
        url: 'getData.php', 
        data:{
          req: "getMarkerIconList", 
          data: {
            projectId: projectId
          }
        },
        dataType: 'json',
        success: function (data){
          var i, newNode,
              midX, midY;

          for(i=0; i<data.length; i++){
            newNode = data[i];

            midX = data[i].options.size.x/2;
            midY = data[i].options.size.y/2;

            newNode.options.iconAnchor = {x:midX, y:midY};
            newNode.options.type = "markerIcon";

            db[newNode.options.type][newNode.id] = newNode;          
            map.addIcon(newNode.id, newNode.options); 
          }
        }
      });
      
      //load every marker of project from server
      $.get('getData.php', {
        req: "getMarkerList", 
        data: {
          projectId: projectId
        }
      }, function (data){
        var i, newNode, newMarker, midX, midY;        

        for(i=0; i<data.length; i++){
        	newNode = data[i];

        	loadData('layer', newNode.options.layerId);
        	db[newNode.options.type][newNode.id] = newNode; 

        	newNode.options.draggable = false;          

        	newMarker = map.addMarker(newNode.id, newNode.latlng, newNode.options);          
          newMarker.on('click', function (){
            var linkedPvr, linkedVtour, markerName = null;
          
            setContentsOfRightContainer('pvr');

            if(curMainIcon && curMainIcon.id != this.id){
              map.markerList[curMainIcon.id].unbindLabel();
            } 

            curMainIcon = db['marker'][this.id];

            if(this.options.actionType == 'linkToPvr'){
              if(this.options.linkedPvr || this.options.linkedPvr ===0){
                linkedPvr = loadData('pvr', this.options.linkedPvr);
                showPvrData(linkedPvr);

                if(this.options.informTitle){
                  markerName = this.options.informTitle;
                }
                else {
                  markerName = ""+linkedPvr.options.name;
                }
              }
              else {
                pvrPlayer.clearScreen();
              } 

              if(this.options.informTitle){
                markerName = this.options.informTitle;
              }     
            }
            else if(this.options.actionType == 'linkToVtour' && (this.options.linkedVtour || this.options.linkedVtour ===0)){
              linkedVtour = loadData('vtour', this.options.linkedVtour);
              markerName = ""+linkedVtour.options.name;

              if(linkedVtour.options.pvrList.length){
                linkedPvr = loadData('pvr', linkedVtour.options.pvrList[0].id);
                showPvrData(linkedPvr);       
              }
              else {
                pvrPlayer.setForVtour(linkedVtour.id);
              }       
            }
            else if(this.options.actionType == 'showInform'){
              markerName = this.options.informTitle;
              pvrPlayer.clearScreen();      
            }
            else{
              pvrPlayer.refresh();
            }

            if(this.options.actionType == 'linkToPvr' || this.options.actionType == 'linkToVtour' || this.options.actionType == 'showInform'){
              if(!this.label && markerName){
                this.bindLabel(markerName, {noHide: true, clickable: true}).showLabel();
                this.label.on('click', (function (){
                  var labelMode = "title", labelTitle = markerName;
                  return function(){
                    var htmlForLabel, htmlForText;

                    if(labelMode == "title"){
                      labelMode = "inform";

                      if(this._source.options.informType == "text"){
                        htmlForLabel = '<div class="labelForInformation">';
                        if(this._source){
                          htmlForLabel += '<div class="titleContainer">'+labelTitle+'</div>';
                
                          if(this._source.options.informImgUrl){
                            htmlForLabel += '<div class="imgContainer"><img src="'+this._source.options.informImgUrl+'"></div>';
                          }
                          if(this._source.options.informText){
                            htmlForText = this._source.options.informText.replace(/\n/g, '<br>');
                            htmlForLabel += '<div class="textContainer">'+htmlForText+'</div>';
                          }
                        }
                        htmlForLabel += '</div>';
                        this.setContent(htmlForLabel);
                      }
                      else if(this._source.options.informType == "url"){
                        labelMode = "title";
                        $('#linkPopupContainer').removeClass('hidden');
                        $('#linkPopupBody iframe').attr('src', this._source.options.linkedUrl);
                      }         
                    }
                    else if(labelMode == "inform"){
                      labelMode="title";

                      htmlForLabel = labelTitle;
                      this.setContent(htmlForLabel);
                    }
                  }
                })());
              }
              else {
                this.unbindLabel();
              } 
            }
            map.map.setView(this.getLatLng(), map.map.getZoom());
          });			
        }
      }, 'json');      
    }


    function loadData(type, id){
      if(!db[type][id]){
        $.ajax({
          async   :false,
          data    :{
            req     :"getNodeData",
            data    :{
              type    :type,
              id      :id
            } 
          },
          dataType:'json',
          type    :'get',
          url     :'getData.php',
          success : function(newData){
            if(type == 'map'){
            }
            if(type == 'layer'){
              if(newData.options.tileImageType == 'presetMap')
                newData.options.maxNativeZoom = 22;
              else
                newData.options.maxNativeZoom = '0';

              map.addTileLayer(newData.id, noCacheUrl(newData.tileUrl), newData.options);
              loadData('map', newData.options.mapId);
            }
            if(type == 'vtour'){
              map.addView(newData.id, newData.latlng, newData.zoom, newData.options);
              pvrPlayer.addVtour(newData.id, newData.xmlPath, newData.options);
              loadData('layer', newData.options.layerId);
            }
            if(type == 'pvr'){
              loadData('vtour', newData.options.vtourId);
              pvrPlayer.addScene(newData.id, newData.options, false);
            }
            db[type][id] = newData;
          }
        });
      }
      return db[type][id];
    }

    function setPvrPlayer(){
      var layer;

      pvrPlayer = new PvrPlayer(myKrpano, "pvrPlayer");
      pvrPlayer.refresh();

      $.ajax({
        async: false,
        type: 'get',
        url: 'getData.php', 
        data:{
          req: "getHotspotIconList", 
          data: {
            projectId: projectId
          }
        },
        dataType: 'json',
        success: function (data){
          var i, newNode,
              midX, midY;

          for(i=0; i<data.length; i++){
            newNode = data[i];

            midX = data[i].options.size.x/2;
            midY = data[i].options.size.y/2;

            newNode.options.iconAnchor = {x:midX, y:midY};
            newNode.options.type = "hotspotIcon";

            db[newNode.options.type][newNode.id] = newNode;          
            pvrPlayer.addIcon(newNode.id, newNode.options); 
          }
        }
      });

      $.get('getData.php', {
        req: "getHotspotList", 
        data: {
          projectId: projectId
        }
      }, function (data){
        var i, newNode, newHotspot;

        for(i=0; i<data.length; i++){
          newNode = data[i];

          loadData('pvr', newNode.options.sceneId);
          db[newNode.options.type][newNode.id] = newNode;
          newHotspot = pvrPlayer.addHotspot(newNode.id, newNode.ath, newNode.atv, newNode.options, false);
          setHotspot(newHotspot);

          /*newHotspot.on('click', function (){
            curMainIcon = db['hotspot'][this.id];
            showIconData(curMainIcon);
            //pvrPlayer.set

            $('#anchor').addClass('forMarker');
            $('.iconBox.clicked').removeClass('clicked');
            $('#anchor').removeClass('hidden');
          });*/
        }
      }, 'json');      
    }

    function setHotspot(hotspot){
      hotspot.on('click', function(){
        if(this.options.actionType == "linkToPvr"){
          if(this.options.linkedPvr){
            loadData('pvr', this.options.linkedPvr);          

            pvrPlayer.krpano.call("tween(hotspot[h"+this.id+"].scale,0.25,0.5); tween(hotspot[h"+this.id+"].oy,-40,0.5); tween(hotspot[h"+this.id+"].alpha,0,0.5);");
            pvrPlayer.krpano.call("looktohotspot(h"+this.id+")");
            pvrPlayer.showScene(this.options.linkedPvr);
          }          
        }
        else if(this.options.actionType == "showInform"){
          var ath, atv;
          // reduce the length of coordi
          ath = pvrPlayer.krpano.get("hotspot[h"+hotspot.id+"].ath").toFixed(6);
          atv = pvrPlayer.krpano.get("hotspot[h"+hotspot.id+"].atv").toFixed(6);
          pvrPlayer.krpano.call("lookto("+ath+", "+atv+")");

          handleHotspotWithComment(this);
        }
        else if(this.options.actionType == "none"){
          var ath, atv;
          // reduce the length of coordi
          ath = pvrPlayer.krpano.get("hotspot[h"+hotspot.id+"].ath").toFixed(6);
          atv = pvrPlayer.krpano.get("hotspot[h"+hotspot.id+"].atv").toFixed(6);  
          pvrPlayer.krpano.call("lookto("+ath+", "+atv+")");
        }
      })
    }

    function showLayerData(newData){
      var mapData, newId;

      $('#anchor.forMarker').addClass('hidden');
      $('.filetreeProp').addClass('hidden');
      $('.layerProperty').removeClass('hidden');

      mapData = db['map'][newData.options.mapId];
      $('#pathArea').html(
        mapData.options.name + 
        " > " + newData.options.name);

      map.changeLayer(newData.id);

      map.map.setView(newData.options.mainView.latlng, newData.options.mainView.zoom, {animate:false});
      pvrPlayer.showScene(newData.options.mainPvr);

      if(curMainIcon){
        newId = curMainIcon.options.type=="markerIcon"?"mic":"hic";
        newId += curMainIcon.id;
        $('#'+newId).click();
      }
      

      $('.layerProperty').removeClass('hidden');
      //이름
      $('#propertyForm input[name|=name]').val(newData.options.name);
      //이미지 타입
      $('#propertyForm input[name|=tileImageType]:checked').removeAttr('checked')
      $('#propertyForm input[name|=tileImageType][value|='+newData.options.tileImageType+']').click();

      $('#propertyForm input.tileImageInput[type|=file]').val(null);


      $('#propertyForm input[name|=mapMinZoom]').val(newData.options.minZoom);
      $('#propertyForm input[name|=mapMaxZoom]').val(newData.options.maxZoom);

      $('#propertyForm input[name|=initialLat]').val(newData.options.mainView.latlng.lat);
      $('#propertyForm input[name|=initialLng]').val(newData.options.mainView.latlng.lng);
      $('#propertyForm input[name|=initialZoom]').val(newData.options.mainView.zoom);
    }
    function showVtourData(newData){
      var pvrList = db['vtour'][newData.id].options.pvrList,
          layer, mapData;

      $('#anchor.forMarker').addClass('hidden');
      $('.filetreeProp').addClass('hidden');
      $('.vtourProperty').removeClass('hidden');

      layer = db['layer'][newData.options.layerId];
      mapData = db['map'][layer.options.mapId];

      $('#pathArea').html( 
        mapData.options.name + 
        " > " + layer.options.name +
        " > " + newData.options.name);

      //map.moveToView(newData.id);
      if(newData.options.mainPvr){
        pvrPlayer.showScene(newData.options.mainPvr);
      }
      else{
        pvrPlayer.refresh();
      }

      if(curMainIcon){
        newId = curMainIcon.options.type=="markerIcon"?"mic":"hic";
        newId += curMainIcon.id;
        $('#'+newId).click();
      }

      $('.vtourProperty').removeClass('hidden');
      $('#propertyForm input[name|=name]').val(db['vtour'][newData.id].options.name);
      $('#propertyForm select[name|=mainPvr]>option').remove();
      
      for(i=0; i<pvrList.length; i++){
        $('#propertyForm select[name|=mainPvr]').append(
          '<option value="'+pvrList[i].id+'">'+pvrList[i].name+'</option>'
        );         
      }
      $('#propertyForm select[name|=mainPvr]').val(newData.options.mainPvr);
      /*
      $('#propertyForm input[name|=initialLat]').val(newData.latlng.lat);
      $('#propertyForm input[name|=initialLng]').val(newData.latlng.lng);
      $('#propertyForm input[name|=initialZoom]').val(newData.zoom); */     
    }
    function showPvrData(newData){
      var vtour, layer, map;

      $('.filetreeProp').addClass('hidden');
      $('.pvrProperty').removeClass('hidden');
      $('input[type|="radio"][name|="pvrImageType"][value|="picture"]').click();

      vtour = db['vtour'][newData.options.vtourId];
      layer = db['layer'][vtour.options.layerId];
      mapData = db['map'][layer.options.mapId];

      $('#pathArea').html(
        mapData.options.name +  
        " > " + layer.options.name +
        " > " + vtour.options.name +
        " > " + newData.options.name);

      pvrPlayer.showScene(newData.id);
      $('.pvrProperty').removeClass('hidden');
      $('#propertyForm input[name|=name]').val(db['pvr'][newData.id].options.name);
      $('#propertyForm input[name|="pvrImageFile[]"]').val('');      
    }
    function showMapData(newData){
      $('#pathArea').html(newData.options.name);
    }
    function deleteNode(type, id){
      var oldNode, IdForFileTree, i, pvrList;

      if(!db[type][id]) loadData(type,id);
      oldNode = db[type][id];

      /*if(oldNode.options.type == "map"){ 
        file.deleteNode('map'+id);
        delete db[type][id];        
      }*/
      if(type == "layer"){ 
        while(oldNode.options.vtourList.length)
          deleteNode('vtour', oldNode.options.vtourList[0].id);
        

        file.deleteNode('l'+id);
        map.delTileLayer(id);
        layerList = db['map'][oldNode.options.mapId].options.layerList;
        layerList.splice(getIdxById(layerList, id), 1);
        setOrderByIdx('layer', layerList);

        delete db[type][id];
      }

      if(type == "vtour"){ 
        while(oldNode.options.pvrList.length)
          deleteNode('pvr', oldNode.options.pvrList[0].id);

        file.deleteNode('vt'+id);
        //map.delView(id);
        vtourList = db['layer'][oldNode.options.layerId].options.vtourList;
        vtourList.splice(getIdxById(vtourList, id), 1);
        setOrderByIdx('vtour', vtourList);        

        delete db[type][id];        
      }

      if(type == "pvr"){ 
        file.deleteNode('pvr'+id);
        pvrPlayer.delScene(id);

        pvrList = db['vtour'][oldNode.options.vtourId].options.pvrList;
        pvrList.splice(getIdxById(pvrList, id), 1);
        setOrderByIdx('pvr', pvrList);

        if(db['vtour'][oldNode.options.vtourId].options.mainPvr == id)
          db['vtour'][oldNode.options.vtourId].options.mainPvr = 
            pvrList.length>0? pvrList[0].id: null;

        delete db[type][id];
      }

      //화면을 지워야 하는데?    
      if(type == curMainData.options.type && id == curMainData.id){
        $('.filetreeProp').addClass('hidden');
        curMainData = null;
        //property 및 mainContents를 지워버리는 함수 
      }

      //db에 저장
      delData(oldNode);
    }
    function deleteIcon(type, id){
      var oldNode, IdForFileTree, i, pvrList, newId, iconList;

      if(!db[type][id]) loadData(type,id);
      oldNode = db[type][id];

      /*if(oldNode.options.type == "map"){ 
        file.deleteNode('map'+id);
        delete db[type][id];        
      }*/
      if(type == "markerIcon"){ 
        iconId = "mic"+id;
        console.log(newId);

        map.delIcon(id);
        iconList = $('#markerIconArea .iconBox:not(.first) img');
        for(i=0; i<iconList.length; i++){ 
          newId = iconList[i].id.replace('mic', '');
          db['markerIcon'][newId].options.order = i;
          saveData({
            id: newId,
            options: {
              type: 'markerIcon',
              order: i
            }
          });
        }

        $('#'+iconId).parent().remove();
        delete db[type][id];                
      }

      if(type == 'marker'){
        map.delMarker(id);
        delete db[type][id];
      }  

      if(type == curMainIcon.options.type && curMainIcon.id == id){
        $('#anchor').addClass('hidden');
        curMainIcon = null;
      }         
      
      delData(oldNode);
    }
    function getNewId(type){
      var newId, options={};

      if(type=='project'){
        options['userId'] = userId;
      }

      $.ajax({
        async   :false,
        data    :{
          req     :"getNewId",
          data    :{
            type    :type,
            options :options            
          } 
        },
        dataType:'json',
        type    :'get',
        url     :'getData.php',
        success : function(id){
          newId = id;
        }        
      });

      return newId;
      //return newId = Math.round(Math.random()*1000);
    }
    

    function drawInputAreaByActionType(actionType, options){
      var html,
          vtourList, pvrList,
          i, j;
      
      $('.iconActionInput').remove();
      if(actionType=="linkToPvr"){
        html = '<select name="linkedPvr" class="propSelectWidth iconActionInput">';

        if(!isNaN(options.layerId)){
          vtourList = loadData('layer', options.layerId).options.vtourList;

          for(i=0; i<vtourList.length; i++){
            html += '<optgroup label="'+vtourList[i].name+'">';

            if(!db['vtour'][vtourList[i].id]) loadData('vtour', vtourList[i].id);
            pvrList = db['vtour'][vtourList[i].id].options.pvrList;
            for(j in pvrList){
              html += '<option value="'+pvrList[j].id+'">'+pvrList[j].name+'</option>';
            }
            html += '</optgroup>';
          }
        }
        
        html += '</select>';
        $('select[name|="iconActionType"]').after(html);
        
        $('select[name|="linkedPvr"]').change(function (){
          if(curMainIcon.options.type == "markerIcon"){
            newVal = $(this).val();
            curMainIcon.options.linkedPvr = newVal;
            map.iconList[curMainIcon.id].setOption('linkedPvr', newVal);
          }
        });
        
        if(options.type == "markerIcon"){
          if(!curMainIcon.options.linkedPvr) 
            curMainIcon.options.linkedPvr = $('select[name|="linkedPvr"]').val();
          $('select[name|="linkedPvr"]').val(curMainIcon.options.linkedPvr);
          if($('select[name|="linkedPvr"]').val() != curMainIcon.options.linkedPvr){
            $('select[name|="linkedPvr"] option:first').attr('selected', '');
            curMainIcon.options.linkedPvr = $('select[name|="linkedPvr"]').val();
          }
        }
        else if(options.type == "marker"){
          $('select[name|="linkedPvr"]').val(curMainIcon.options.linkedPvr);
        }       
      }
    }

    function showIconData(data){
      options = {};

      $('textarea[name|="iconDesc"]').val(data.options.desc);
      $('select[name|="iconActionType"]').val(data.options.actionType);

      if(data.options.type == "markerIcon"){
        $('.iconProp').addClass('hidden');
        $('.markerIconProperty').removeClass('hidden');
        if(map._curLayer) options.layerId = map._curLayer.id;
        options.linkedPvr = data.options.linkedPvr;
        options.type = data.options.type;
      }
      if(data.options.type == "marker"){
        $('.iconProp').addClass('hidden');
        $('.markerProperty').removeClass('hidden');
        options.layerId = data.options.layerId;
        options.linkedPvr = data.options.linkedPvr;
        options.type = data.options.type;
      }
      drawInputAreaByActionType(data.options.actionType, options);
    }

    function setOrderByIdx(type, list){
      for(i=0; i<list.length; i++){
        loadData(type, list[i].id);
        db[type][list[i].id].options.order = i;
        saveData({
          id: list[i].id,
          options: {
            type: type,
            order: i
          }
        })
      }
    }

    var dropData = null;
    function drop(ev){
      var iconId = ev.dataTransfer.getData("text");
      dropData = Number(iconId);      
      ev.preventDefault();
    }
    function drag(ev) {
      ev.dataTransfer.setData("text", ev.target.id.replace('mic','').replace('hic',''));  
    }
    function allowDrop(ev) { 
      ev.preventDefault();  
    }

    var commentView = {
      activeCommentButton: function(){
        $('#commentButton').addClass('clicked');
      },
      inactiveCommentButton: function(){
        $('#commentButton').removeClass('clicked');
      },
      showCommentWindow: function(){
        $('#commentWindow').removeClass('hidden');
      },
      hideCommentWindow: function(){
        $('#commentWindow').addClass('hidden');
      },
      moveCommentWindow: function(x, y){
        $('#commentWindowPositioner').css('top', y);
        $('#commentWindowPositioner').css('left', x);
      },
      setCommentInput: function(text){
        $('input[name|="comment_text"]').val(text.toString());
      }
    };

    var commentModel = {
      isCommentModeOn: false,
      isCommentWindowOpened: false,
      commentPosition: {
        x: null,
        y: null
      },
      turnOnCommentMode: function(){
        this.isCommentModeOn = true;
        commentView.activeCommentButton();
      },
      turnOffCommentMode: function(){
        this.isCommentModeOn = false;
        this.closeCommentWindow();
        commentView.inactiveCommentButton();
      },
      openCommentWindow: function(x, y, text){
        if(!this.isCommentWindowOpened){
          this.isCommentWindowOpened = true;
          commentView.showCommentWindow();      
        }
        this.commentPosition.x = x;
        this.commentPosition.y = y;
        commentView.moveCommentWindow(x, y);
        commentView.setCommentInput(text);
      },
      closeCommentWindow: function(){
        this.isCommentWindowOpened = false;
        commentView.hideCommentWindow();
      }
    };
    var user = {
      id: null,
      mail: null
    };

    function handleHotspotWithComment(hotspot){
      if(commentModel.isCommentModeOn){
        commentModel.openCommentWindow("50%", "50%", hotspot.options.textInfo);
      }      
    }

    function initializeComment(){
      var dragging = false;
      var ath, atv;

      $('#commentButton').on('click', function(){
        if(commentModel.isCommentModeOn){
          commentModel.turnOffCommentMode();
        }
        else{
          commentModel.turnOnCommentMode();
        }
      });
      $('#pvrContainer').on('mousedown', function(){
        dragging = false;
        commentModel.closeCommentWindow();
      });
      $('#pvrContainer').on('mousemove', function(){
        dragging = true;
      });
      $('#pvrContainer').on('dblclick', function(ev){
        var parentOffset = $(this).parent().offset(); 
        var relX = ev.pageX - parentOffset.left;
        var relY = ev.pageY - parentOffset.top;

        if(commentModel.isCommentModeOn && dragging == false){
          var position = pvrPlayer.getMousePosition();

          commentModel.openCommentWindow(relX, relY, '');
        }        
      });
      $('#comment_input_button').on('click', function(){
        var text = $('input[name|="comment_text"]').val();
        var newId = getNewId('hotspot');
        var hotspotIcon;

        for(ele in pvrPlayer.iconList){
          hotspotIcon = ele;
          break;
        }
        var options = {
          sceneId: pvrPlayer.getCurSceneId(),
          actionType: "showInform",
          text: text,
          textInfo: text,
          type: "hotspot"
        };
        db['hotspot'][newId] = {
          id: newId,
          ath: ath,
          atv: atv,
          options: options
        };

        pvrPlayer.saveCurState();
        newHotspot = pvrPlayer.addHotspot(newId, db['hotspot'][newId].ath, db['hotspot'][newId].atv, options);
        setHotspot(newHotspot);

        saveData(db['hotspot'][newId]);
        pvrPlayer.refresh();
        pvrPlayer.loadPrevState();

        commentModel.closeCommentWindow();
      })
    }

    function saveData(data){
      $.ajax({
        type: 'post',
        url: 'setData.php', 
        data: {
          req: 'setData',
          data: data
        }, 
        success: function(){
        }
      });
    }
    function delData(data){
      $.ajax({
        async: false,
        type: 'post',
        url: 'setData.php', 
        data: {
          req: 'delData',
          data: data
        }, 
        success: function(){
        }
      });
    }


    /**
     * setContentsOfRightContainer
     *  change the contents that are  shown on the right container
     *
     * @param type
     *  type of contents
     */

    function setContentsOfRightContainer(type) {
      switch(type) {
        case "pvr":
        $('.pvrContents').removeClass('transparent');
        $('.videoContents').addClass('transparent');
        if(videoPlayer) {
          videoPlayer.clearVideo();
        }        
        break;

        case "video":
        $('.videoContents').removeClass('transparent');
        $('.pvrContents').addClass('transparent');
        if(curMainIcon) {
          map.markerList[curMainIcon.id].unbindLabel();
          curMainIcon = null;
        }        
        break;
      }
    }

    /**
     * setVideoPlayer
     *  used as the callback of embedpano
     */

    function setVideoPlayer() {
      var newLayerId;

      videoPlayer = new VideoPlayer(videoKrpano, {
        mode: "krpano"
      });

      //load every video of project from server
      loadDataListFromServer('video');
      //videoPlayer must be defined for polyline
      //load every polyline of project from server
      loadDataListFromServer('polyline');

      //after the polylines are loaded, tile layer is shown on the map
      newLayerId = db.map[projectId].options.layerList[0].id;
      layer = loadData('layer', newLayerId);
      showLayerData(db.layer[newLayerId]);
      loadData('pvr', layer.options.mainPvr);
      pvrPlayer.showScene(layer.options.mainPvr);
    }

    /**
     * loadDataListFromServer
     *  load videolist, polyline list
     *
     * @param type
     *  type of data to load
     */
    function loadDataListFromServer(type){
      var str, allowedType;

      allowedType = ['video', 'polyline'];
      if($.inArray(type, allowedType) === -1) {
        console.error('loadDataListFromServer: input wrong data type')
        return false;
      }

      //change first character to upper case
      str = type.charAt(0).toUpperCase() + type.slice(1);
      $.ajax({
        async: false,
        url: 'getData.php',
        type: 'get',
        data: {
          req: 'get' + str + 's',
          data: {
            projectId: projectId
          }
        },
        dataType: 'json',
        success: function (dataList) {
          var i, j, data, newPolyline;

          for(i=0; i<dataList.length; i++) {
            data = dataList[i];
            
            //insert data to js global db
            db[type][data.id] = data;

            //make a object from returned data from server
            switch(type) {
              //video don't have extra object that controls it.\
              case 'video':
              break;

              case 'polyline':
              //insert video object for polyline
              data.options.video = db.video[data.options.videoId];
              //insert contents object for polyline
              data.options.contents = {
                map: map.map,
                videoPlayer: videoPlayer
              };
              //add polyline to map object
              newPolyline = map.addPolyline(data.id, data.layerId, data.options);
              //add timeline of the polyline add to map
              for(j=0; j<data.options.timelineList.length; j++) {
                timeline = data.options.timelineList[j];
                newPolyline.addTimeline(timeline.perAtStart, timeline.perAtEnd, timeline.latlng);
              }
              //when the line cliked, right container show 360 video 
              newPolyline.onToLine('click', function(){
                setContentsOfRightContainer('video');
              });

              //when the line is remove from map, the related video have to be stopped
              newPolyline.timelines[0].lines[0].on('remove', function () {
                var curActivePolyline;
                curActivePolyline = videoPlayer.getPolyline();
                if(curActivePolyline && curActivePolyline.id == this.parentPolyline.id){
                  videoPlayer.clearVideo();
                }
              });

              newPolyline.hide();
              break;
            }
          }
        }
      });
    }

    </script>
  </body>
  <head>
    <meta Http-Equiv="Cache-Control" Content="no-cache">
    <meta Http-Equiv="Pragma" Content="no-cache">
    <meta Http-Equiv="Expires" Content="0">
    <meta Http-Equiv="Pragma-directive: no-cache">
    <meta Http-Equiv="Cache-directive: no-cache">
  </head>
</html>