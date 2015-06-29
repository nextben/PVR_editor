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
    
    <script src="fileTree.js"></script>
    <script src="marker.js"></script>
    <script src="view.js"></script>
    <script src="tileLayer.js"></script>
    <script src="icon.js"></script>
    <script src="map.js"></script>
    <script src="pvrPlayer.js"></script>
    <script src="embedpano.js"></script>

    <link rel="stylesheet" href="fileTree.css" />
    <link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7.1/leaflet.css" />

    <style>
      @import url(http://fonts.googleapis.com/earlyaccess/nanumgothic.css);
      html {width:100%;height:100%;}
      body {margin:0; font-family:nanumgothic; display:inline-block; float:left; width:100%; height:100%;}

      .vcomplex {display: inline-flex; display: -ms-inline-flexbox; flex-direction: column; -ms-flex-direction:column;}
      .vrcomplex {display: inline-flex; display: -ms-inline-flexbox; 
        flex-direction: column-reverse; -ms-flex-direction:column-reverse;}
      .hcomplex {display: inline-flex; display: -ms-inline-flexbox; 
        flex-direction: row; -ms-flex-direction:row;}
      .restContainer {flex:1; -ms-flex:1; position:relative;}
      .restContainer .confirmSize{position:absolute;}


      .menuBar1 {width:100%;height:45px;position:relative;}
      .menuBar1 .barShadow {box-shadow: 0px 10px 5px -5px #D5D5D5 inset; position:absolute; top:45px; 
        height:10px; z-index:1000001; width:100%; pointer-events:none;}

      .leftAlign {float:left;}
      .rightAlign {float:right;}
      .area {display:inline-block; padding:10px; line-height:0;}
      .textArea {display:inline-block; padding:10px; line-height:1; font-size:25px;}
      .textArea.smalltext {font-size:20px;padding-top:15px;}
      .bold {font-weight:bold;}
      .button {
        display: inline-block;
        font-weight:bold; 
        padding:5px; background-color:#BDBDBD;
        text-align:center;
        color:white;
        cursor:pointer;
      }
      .button.width4 {width:100px;}
      .button.height1 {
        height:15px; padding-top:5px; padding-bottom:5px;
        font-size:15px; line-height:1;
      }
      .button.round {border-radius:5px;}
      .button.active {
        background-color: #8C8C8C;
        cursor: default;
      }

      .hSizeHandler {width:10px; background-color:#EAEAEA; cursor:col-resize;}
      .vSizeHandler {height:10px; background-color:#EAEAEA; cursor:row-resize;}


      .halfContainer {flex:1;height:100%; float:left;}
      .fullContainer {width:100%; height:100%;}
      
      .leaflet-container {background-color: white}

      .topBar {background-color:#E9EDEE;}
      #myKrpano>div>div:nth-child(1), #myKrpano>div>div:nth-child(2) {z-index:1000000;}
      #leftContainer {flex:initial; -ms-flex:inherit; width:50%;}

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
        flex-direction: column;
        -ms-flex-direction: column;
      }
      #linkPopupMenuBar {width:100%; height:30px;
        -webkit-user-select:none;
        cursor:default;
      }
      #linkPopupMenuBar .closeBox {line-height:0.5; padding:4px; font-size:40px; float:right; cursor:pointer;}
      #linkPopupMenuBar .closeBox:hover {color:red;}
      #linkPopupContentWrapper {flex:1; -ms-flex:1; width:100%; position:relative;}
      #linkPopupContent {position:absolute; width:100%; height:100%;}
      #linkPopupContent iframe {border:0; margin:0; width:100%; height:100%;}
      #linkPopupContent iframe::-webkit-scrollbar{width:5px; height:5px; background-color:rgba(0,0,0,0);}
      #linkPopupContent iframe::-webkit-scrollbar-thumb{width:5px; height:5px; background-color:#B2B7BA;border-radius:2px;}
    </style>
  </head>
  <body class="vcomplex">
    <div id="totalContainer" class="restContainer">
      <div class="confirmSize hcomplex fullContainer">
        <div id="leftContainer" class="restContainer">
          <div id="mapContainer" class="fullContainer confirmSize"></div>
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
        <div id="sizeHandler" class="hSizeHandler"></div>
        <div class="restContainer">
          <div id="pvrContainer" class="fullContainer confirmSize"></div>
        </div>
      </div>
    </div>

    <script type="text/javascript">
    var file, db, curMainData, curMainIcon, projectId = <?php echo isset($_GET['projectId'])?$_GET['projectId']:'null';?>, userId
        googleTileUrl = "https://mts1.google.com/vt/lyrs=m@231000000&hl=ko&gl=KR&src=app&x={x}&y={y}&z={z}&s={s}",
        map = null, pvrPlayer = null, viewMode = <?php echo isset($_GET['viewMode'])?$_GET['viewMode']:'null';?>;
    var mainMarker;

    $(document).ready(function(){
      var layerList;

      if(viewMode == 'v'){
        $('#totalContainer>div').removeClass('hcomplex');
        $('#totalContainer>div').addClass('vrcomplex');
        $('#leftContainer').css('width', '100%');
        $('#leftContainer').css('height', '50%');
        $('#sizeHandler').removeClass("hSizeHandler");
        $('#sizeHandler').addClass("vSizeHandler");
      }

      if(projectId || projectId==0){
        loadProject(projectId);  
      }
      //지도 표시
      layerList = loadData('map', projectId).options.layerList;
      for(key in layerList) {mainLayer = loadData('layer', layerList[key].id); break;}
      map.changeLayer(mainLayer.id);
      map.map.setView(mainLayer.options.mainView.latlng, mainLayer.options.mainView.zoom);

      setForSizeHandler(); 
      $('#linkPopupMenuBar .closeBox').click(function(){
        $('#linkPopupContainer').addClass('hidden');
      });
    });

    function setForSizeHandler(){
      var isClicked = false, changeSize = false, x,y,
          vratio, hratio;
      
      hratio = $('#leftContainer').outerWidth()/$('#totalContainer').outerWidth();
      vratio = $('#leftContainer').outerHeight()/$('#totalContainer').outerHeight();

      $('#sizeHandler').mousedown(function(ev){
        ev.originalEvent.preventDefault();
        isClicked = true;
      });
      $('body').mouseup(function(ev){
        isClicked = false;
        if(changeSize){          
          changeSize = false;
          if(viewMode == "h"){
            hratio = $('#leftContainer').outerWidth()/$('#totalContainer').outerWidth();
          }
          else if(viewMode =="v"){
            vratio = $('#leftContainer').outerHeight()/$('#totalContainer').outerHeight();
          }
        }      
      });

      $('body').on('mousemove', function(ev){
        var baseWidth;
        if(isClicked){
          changeSize = true;
          if(map) map.map._onResize();

          if(viewMode == "h"){
            baseWidth = $('#totalContainer').outerWidth();
            x = ev.pageX;
            x = Math.max(0+5, x);
            x = Math.min(baseWidth-5, x);          
            $('#leftContainer').css('width', x-5);
          }
          else if(viewMode == "v"){
            baseHeight = $('#totalContainer').outerHeight();
            y = ev.pageY;
            y = Math.max(0+5, y);
            y = Math.min(baseHeight-5, y);          
            $('#leftContainer').css('height', baseHeight-y-5);
          }          
        }  
      });

      $(window).resize(function(){
        if(viewMode == "h"){          
          $('#leftContainer').css('width', $('#totalContainer').outerWidth()*hratio);
        }
        else if(viewMode == "v"){
          $('#leftContainer').css('height', $('#totalContainer').outerHeight()*vratio);
        }
      });  
    }
    var db = {
      user: {},
      map: {},
      vtour: {},
      pvr: {},
      layer: {},
      markerIcon: {},
      hotspotIcon: {},
      marker: {},
      hotspot: {}
    };

    function loadProject(project){
      var key;

      $('#myKrpano').remove();
      $('#pathArea').html('');
      $('#anchor').addClass('hidden');
      $('.propertyElement').addClass('hidden');

      curMainData = null;
      curMainIcon = null;


      for(key in db){
        if(key != "user"){
          db[key] = {};  
        }        
      }
      if(map){
        map._curLayer = null;
        for(key in map.map._layers){
          map.map.removeLayer(map.map._layers[key]);
        }
        map.map.remove();
      }       
      $('.iconBox:not(.first)').remove();

      //-----------------------------
      //새로운 프로젝트 정보를 불러옴
      projectId = project;
      map = new Map(0, "mapContainer", {
        mode  : "edit",
        useView : true,
      });
      embedpano({
        target: "pvrContainer", 
        id: "myKrpano", 
        bgcolor: "#FFFFFF", 
        html5: "only", 
        swf: "krpano.swf",
        xml: noCacheUrl("template/krpano.xml"),
        onready: setPvrPlayer
      });      

      loadData('map', projectId);
      var newLayerId = db.map[projectId].options.layerList[0].id;
      loadData('layer', newLayerId);
      //showLayerData(db.layer[newLayerId]);

      //marker icon 생성
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


      $.ajax({
        async: false,
        type: 'get',
        url: 'getData.php', 
        data:{
          req: "getMarkerList", 
          data: {
            projectId: projectId
          }
        },
        dataType: 'json',
        success: function (data){
          var i, newNode, newMarker,
              midX, midY;
          for(i=0; i<data.length; i++){
            newNode = data[i];

            loadData('layer', newNode.options.layerId);
            db[newNode.options.type][newNode.id] = newNode; 

            newNode.options.draggable = false;         
            newMarker = map.addMarker(newNode.id, newNode.latlng, newNode.options);          
            newMarker.on('click', function (){
              var linkedPvr, linkedVtour, markerName = null;

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
              }
              else if(this.options.actionType == 'linkToVtour' && (this.options.linkedVtour || this.options.linkedVtour ===0)){
                linkedVtour = loadData('vtour', this.options.linkedVtour);
                markerName = ""+linkedVtour.options.name;

                if(linkedVtour.options.pvrList.length){
                  linkedPvr = loadData('pvr', linkedVtour.options.pvrList[0].id);
                  showPvrData(linkedPvr);                
                }
                else{
                  pvrPlayer.setForVtour(linkedVtour.id);
                }              
              }
              else if(this.options.actionType == 'showInform'){
                markerName = this.options.informTitle;              
              }
              else{
                pvrPlayer.refresh();
              }


              if(this.options.informType == "url"){
                $('#linkPopupContainer').removeClass('hidden');
                $('#linkPopupBody iframe').attr('src', this.options.linkedUrl);
              }
              else {
                if(this.options.actionType == 'linkToPvr' || this.options.actionType == 'linkToVtour' || this.options.actionType == 'showInform'){
                  if(!this.label && markerName){
                    this.bindLabel(markerName, {noHide: true, clickable: true}).showLabel();
                    this.label.on('click', (function (){
                      var labelMode = "title", labelTitle = markerName;
                      return function(){
                        var htmlForLabel, htmlForText;

                        if(labelMode == "title"){
                          labelMode = "inform";

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
              }
              map.map.setView(this.getLatLng(), map.map.getZoom());
            });
        }
      });  
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
      var mainVtour;

      pvrPlayer = new PvrPlayer(myKrpano, "pvrPlayer");
      pvrPlayer.refresh();

      mainVtour = loadData('vtour', <?php echo isset($_GET['vtourId'])?$_GET['vtourId']:'null';?>);
      if(mainVtour){        
        showVtourData(mainVtour);
        console.log(mainMarker);
        setViewForVtour(mainVtour);
      }

      

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

    function showPvrData(newData){
      var vtour, layer, map;

      $('.filetreeProp').addClass('hidden');
      $('#pvrProperty').addClass('hidden');
      $('input[type|="radio"][name|="pvrImageType"][value|="picture"]').click();

      vtour = db['vtour'][newData.options.vtourId];
      layer = db['layer'][vtour.options.layerId];
      mapData = db['map'][layer.options.mapId];

      pvrPlayer.showScene(newData.id);
      $('#propertyForm input[name|=name]').val(db['pvr'][newData.id].options.name);
      $('#propertyForm input[name|="pvrImageFile[]"]').val(''); 
      $('#propertyForm input[name|="initialAth"]').val(Number(newData.options.initialAth).toFixed(4));
      $('#propertyForm input[name|="initialAtv"]').val(Number(newData.options.initialAtv).toFixed(4));
      $('#propertyForm input[name|="initialFov"]').val(Number(newData.options.initialFov).toFixed(4));
    }
    function showVtourData(newData){
      var pvrList = newData.options.pvrList,
          markerId, pvrId, i, pvr;

      //이전 vtour 정보의 제거
      curMainData = null;

      curVtourId = newData.id;
      console.log(db.marker);
      for(markerId in db.marker){
        if(db.marker[markerId].options.linkedVtour == curVtourId){
          mainMarker = map.markerList[markerId];
          curMainIcon = loadData('marker', markerId);
          break;
        }
      }
      if(pvrList.length){
        loadData('pvr', pvrList[0].id);
        pvrPlayer.showScene(pvrList[0].id);
      }  
      else{
        pvrPlayer.setForVtour(newData.id);
      }
    }
    function setViewForVtour(newData){
      var marker, zoom;

      for(markerId in db.marker){
        if(db.marker[markerId].options.linkedVtour == curVtourId){
          console.log(map.markerList[markerId]);
          marker = map.markerList[markerId];
          break;
        }
      }
      if(!marker) return;

      if(marker._latlng.lat !== 0 && marker._latlng.lng !==0 ){
        zoom = mainMarker.options.maxLevel<map.map._layersMaxZoom?
          mainMarker.options.maxLevel:
          map.map._layersMaxZoom;
        map.map.setView(marker._latlng, zoom);
      }      
    }
    function noCacheUrl(url){
      return url+'?'+(new Date()).getTime();
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