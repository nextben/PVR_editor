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
      html {height:100%;}
      body {width:100%; height:100%; margin:0; font-family:nanumgothic; display:inline-block; 
        display: flex;
        display: -ms-flexbox;
        display: -webkit-box;
        display: -moz-box;
        -webkit-box-orient: vertical;
        -moz-box-orient: vertical;
        flex-direction: column;
        -ms-flex-direction: column;
        overflow:hidden;
        min-width:950px;min-height:550px;}


      #menuBar {width:100%;height:30px;background-color: #E9EDEE}
      .menuButton {width:150px;color:white;background-color:#34495E;text-align: center; padding:7px;font-weight:bold; font-size:14px; cursor:pointer; margin-right:10px;float:left;}
      #menuBar .button {width:55px; padding:5px 0px; margin-right:10px; margin-top:3px;
        background-color:#19BE9C; color:white;
        float:left; 
        font-size:12px; font-weight:bold; text-align:center;
        cursor:pointer;}
      #logoutButton.button {float:right;}


      .menuSelect {float:left; margin:0; margin-top:5px; margin-right:5px;}

      #topContainer {width:100%;height:60px;background-color:#EEEFF1;}
      #bodyContainer {width:100%;height:500px;
        flex: 1;
        -ms-flex: 1;
        -webkit-box-flex: 1;
        -moz-box-flex: 1;
        position:relative;}
      #bodyPositioner {
        position:absolute; width:100%; height:100%; 
        display: flex;
        display: -ms-flexbox;
        display: -webkit-box;
        display: -moz-box;
      }
      #leftContainer {display:inline-block;height:100%;}
     
      .bottomShadow {box-shadow: 0px 10px 5px -5px #D5D5D5 inset; position:relative; top:60px; height:10px; z-index:1000005;}
      .bottomShadow0 {box-shadow: 0px 10px 5px -5px #D5D5D5 inset; position:relative; height:10px; z-index:1000005; top:30px;}
      #projectNameArea {width:150px; margin:20px; font-size:17px; font-weight:900; float:left;}
      #pathArea {padding:22px; font-size:14px; font-weight:900; float:left;}
      #versionArea {padding:23px; font-size:12px; float:left;}
      #topButtonArea {padding:13px 10px; float:right;}
      #topButtonArea .button {width:100px; text-align:center; padding:10px 0px; font-size:12px; 
        border-radius:4px;background-color:#348ece; margin-left:10px; color:white; float:left; font-weight:bold;
        cursor:pointer;} 
      #fileTreeArea {float:left; width:179px; border-right:1px solid #D3D4CF; padding:10px;overflow-y:auto;}
     
      .iconArea {float:left; width:80px; border-right:1px solid #D3D4CF; padding:10px; background-color:#F6FCFC; overflow-y:auto; -webkit-box-sizeing:border-box; box-sizing:border-box;}
      .iconArea::-webkit-scrollbar{width:5px; background-color:rgba(0,0,0,0);}
      .iconArea::-webkit-scrollbar-thumb{width:5px; background-color:#B2B7BA;border-radius:2px;}
      .myFileIcon {float:left; margin:0px 2px;}

      .iconImage {}
      .iconBox {
        padding:2px; border-radius:10px; 
        cursor:pointer; display:inline-block; margin-top:10px; text-align:center; float:left;
        background-color: rgba(0,0,0,0);
        width:55px; height:55px; 
      }
      .iconBox.clicked {background-color: #BDBDBD;}
      .iconBox.clicked.hiddenClicked {background-color: rgba(0,0,0,0);}
      .iconBox.first{margin-top: 0;}


      #propertyArea {float:left; border-right:1px solid #D3D4CF;}
      .propertyElement {font-size:14px;display:inline-block; float:left;}
      .propertyName {background-color:#CEE3E4; font-weight:bold;padding-left:5px;}
      .propertyElement input[name|=name] {width:195px;margin:0;text-align:left;}
      .propertyElement input[name|="linkedUrl"] {width:195px;margin:0;text-align:left;}
      .propertyElement input[name|="informTitle"] {width:195px;margin:0;text-align:left;}
      .propertyElement input[name|=projectName] {width:195px;margin:0;text-align:left;}
      .propertyElement input[type|=file], .propertyElement select
        {width:199px;}
      .propertyElement input, .propertyElement select {font-size:14px; font-family:"nanumgothic"; text-align:center;} 
      .propertyWidth {width:209px;}
      .propertyElement>.propertyWidth {width:199px;padding:5px;}
      .propertyElement input.small {width:40px;}
      .propertyElement .radioBox {width:99px; float:left; margin-right:1px;margin-bottom:5px;}
      .propertyElement .radioBox.last {margin-right:0;} 
      .propertyContents {display:inline-block; float:left;text-align:center;}

      .radioBox {text-align:left;}
      .leaflet-container {background-color: white}


      .buttonBox {display:inline-block; float:right; padding:5px;}
      #propertyArea .button, #iconPropArea .button {width:55px; padding:7px 0px; margin-left:5px;
        background-color:#19BE9C; color:white;
        float:left; 
        font-size:12px; font-weight:bold; text-align:center; border-radius:3px;
        cursor:pointer;}
      #propertyArea .button.wide {width:199px;}
      #propertyArea .button.first {margin:0; margin-bottom:5px;}

      


      #rightContainer {
        display: flex;
        display: -ms-flexbox;
        display: -webkit-box;
        display: -moz-box;
        flex: 1;
        -ms-flex: 1;
        -webkit-box-flex: 1;
        -moz-box-flex: 1;
        position:relative;
      }
      .mainContents {width:100%; height:100%;}
      .bodyHeight {height:100%;}
      .bodyWithPadding {height:100%; padding-top:10px; padding-bottom:10px; -webkit-box-sizing:border-box; box-sizing:border-box;}

      #anchor {height:100%; width:210px; position:absolute; top:0;}
      #anchor.forMarker {right:0;}
      #iconPropArea {
        position:absolute; z-index: 1000001; 
        background-color:white; 
        border-right:1px solid #D3D4CF;
      }
      .propTextareaWidth {width:193px; margin:0;float:left;}
      .fixSize {resize:none;}
      
      #anchor.forMarker #iconPropArea{
        left: auto; right: 0px; top: 0;
        border-left:1px solid #D3D4CF; border-right:0;
      }
      #anchor.forMarker #propertyToggleButton{
        top:50%; margin-top:-45px; left:auto; right:210px;
        border:0px; border-radius:0px;
        border-left:1px solid #D3D4CF; 
        border-top:1px solid #D3D4CF;
        border-bottom:1px solid #D3D4CF;
        border-bottom-left-radius: 10px;
        border-top-left-radius: 10px;
      }

      .hidden {display:none;}
      #propertyToggleButton {position:absolute; height:88px; width:14px; top:50%; 
        margin-top:-45px; left:210px; z-index:1000001;
        background-color:white;
        border-right:1px solid #D3D4CF; 
        border-top:1px solid #D3D4CF;
        border-bottom:1px solid #D3D4CF;
        border-bottom-right-radius: 10px;
        border-top-right-radius: 10px;
        cursor:pointer;
      }

      .loadingContainer {width:100%; height:100%; position:fixed; top:0; left:0;
                        background-color:rgba(0,0,0,0.7); z-index:1000020; cursor:wait;}
      .loadingProgress {position:relative; float:left; display:inline-block;
                        top:50%; left:50%; margin-top:-6px; margin-left:-104px;}
      .loadingProgress img {float:left;}


      #myKrpano>div>div:nth-child(1), #myKrpano>div>div:nth-child(2) {z-index:1000000;}
    
      #mapSearch {position:absolute; bottom:10px; width:100%; 
        height:30px; 
        left: 0;
        display: flex;
        display: -ms-flexbox;
        display: -webkit-box;
        display: -moz-box;
        z-index:1000000;}
      #mapSearch div{text-align:center;}
      #mapSearch .button {width:55px; height:19px; text-align:center; background-color:#19BE9C;
        font-size:14px; font-weight:bold; color:white;padding:3px; cursor:pointer;display:inline-block;
        margin-left:auto; margin-right:auto;}
      #mapSearch div.first{width:80px;padding:5px 0px;}
      #mapSearch div.second{
        flex: 1;
        -ms-flex: 1;
        -webkit-box-flex: 1;
        -moz-box-flex: 1;
        padding:4px 0px;}
      #mapSearch input{width:95%; margin:0;}
      #mapSearch div.third{width:70px;padding:2px 0px;}
      #mapSearch.hidden {display:none;}
    </style>
  </head>
  <body>
    <div id="topContainer">
      <div id="projectNameArea">
      </div>
      <div id="pathArea">
      </div>
      <div id="versionArea">
      </div>
      <div id="topButtonArea">
        <div class="button" id="add360VideoProjectButton">360 video 추가</div>
        <div class="button" id="addChildButton">하위 항목 추가</div>
        <div class="button" id="previewButton">미리 보기</div>        
        <form id="360VideoProjectForm" class="hidden">
          <input name="panoVideoZip" type="file">
        </form>
      </div>
      <div class="bottomShadow">
      </div>
    </div>
    <div id="bodyContainer" class="bodyHeight">
      <div id="bodyPositioner">
        <div id="leftContainer" class="bodyHeight">
          <div id="fileTreeArea" class="bodyWithPadding">
          </div>
          <div id="propertyArea" class="propertyWidth bodyHeight">
            <form id="propertyForm">
              <div class="propertyElement filetreeProp  propertyWidth hidden layerProperty vtourProperty pvrProperty">
                <div class="propertyName propertyWidth">
                  이름
                </div>
                <div class="propertyContents propertyWidth">
                  <input type="text" name="name">
                </div>
              </div>
              <div class="propertyElement filetreeProp propertyWidth hidden mapProperty">
                <div class="propertyName propertyWidth">
                  이름
                </div>
                <div class="propertyContents propertyWidth">
                  <input type="text" disabled name="projectName">
                </div>
              </div>
              <div class="propertyElement filetreeProp  propertyWidth hidden layerProperty">
                <div class="propertyName propertyWidth">
                  지도 이미지
                </div>
                <div class="propertyContents propertyWidth">
                  <div class="radioBox">
                    <input type="radio" name="tileImageType" value="presetMap">
                    <label for="tileImageRadio">제공 지도</label>
                  </div>
                  <div class="radioBox last">
                    <input type="radio" name="tileImageType" value="userMap">
                    <label for="tileImageRadio">사용자 지도</label>
                  </div>
                  <div>
                    <select class="tileImageInput presetMapInput" name="tileImageUrlSelect">
                      <option value="google">구글 지도</option>       
                    </select>                  
                    <input class="tileImageInput userMapInput hidden" name="tileImageFile" type="file">
                  </div>
                </div>
              </div>
              <div class="propertyElement filetreeProp  propertyWidth hidden layerProperty">
                <div class="propertyName propertyWidth">
                  지도 zoom 범위
                </div>
                <div class="propertyContents propertyWidth">
                  <input type="text" name="mapMinZoom" class="small"> -
                  <input type="text" name="mapMaxZoom" class="small">
                </div>
              </div>
              <div class="propertyElement filetreeProp  propertyWidth hidden vtourProperty layerProperty">
                <div class="propertyName propertyWidth">
                  대표 PVR 선택
                </div>
                <div class="propertyContents propertyWidth">
                  <select name="mainPvr"></select>
                </div>
              </div>
              <div class="propertyElement filetreeProp  propertyWidth hidden pvrProperty">
                <div class="propertyName propertyWidth">
                  PVR 용 이미지
                </div>
                <div class="propertyContents propertyWidth">
                  <div class="radioBox">
                    <input type="radio" name="pvrImageType" value="picture" checked>
                    <label for="tileImageRadio">사진</label>
                  </div>
                  <div class="radioBox last">
                    <input type="radio" name="pvrImageType" value="panorama">
                    <label for="tileImageRadio">파노라마</label>
                  </div>
                  <input name="pvrImageFile[]" class="pvrImageInput pictureInput" type="file" multiple>
                  <input name="pvrPanoFile" class="hidden pvrImageInput panoramaInput" type="file">
                </div>
              </div>
              <div class="propertyElement filetreeProp  propertyWidth hidden pvrProperty">
                <div class="propertyName propertyWidth">
                  처음 화면 좌표
                </div>
                <div class="propertyContents propertyWidth">
                  <div id="getCurPvrView" class="button wide first">현재 화면 좌표</div>
                  수직<input name="initialAtv">
                  <br>수평<input name="initialAth">
                  <br>시야각<input name="initialFov">
                </div>
              </div>

              <div class="propertyElement filetreeProp propertyWidth hidden layerProperty">
                <div class="propertyName propertyWidth">
                  처음 화면 좌표
                </div>
                <div class="propertyContents propertyWidth">
                  <div id="setInitialView" class="button wide first">현재 화면 좌표</div>
                  LAT<input name="initialLat">
                  <br>LNG<input name="initialLng">
                  <br>ZOOM<input name="initialZoom">
                </div>
              </div>

              <div class="propertyElement filetreeProp  propertyWidth hidden layerProperty vtourProperty pvrProperty">
                <div class="buttonBox"> 
                  <div class="button" id="nodeModifyButton">입력</div>
                  <div class="button" id="nodeDeleteButton">삭제</div>
                </div>
              </div>
            </form>
          </div>        
          <div id="markerIconArea" class="bodyWithPadding iconArea hidden">
            <form id="iconForm">
              <input class="hidden" id="iconImageFile" type="file" name="iconImageFile[]" multiple>
            </form>
            <div class="iconBox first">            
              <img class="iconImage addIcon" id="addMarkerIcon" src="source/newIcon.png"> 
            </div>
          </div>
          <div id="hotspotIconArea" class="bodyWithPadding iconArea hidden">
            <div class="iconBox first">
              <img class="iconImage addIcon" id="addHotspotIcon" src="source/newIcon.png">       
            </div>
          </div>
          <div id="publicMapIconArea" class="bodyWithPadding iconArea">
          </div>
        </div>      
        <div id="rightContainer" class="bodyHeight">
          <div id="mapContainer" class="mainContents bodyHeight"></div>
          <div id="mapSearch" class="hidden">
            <div class="first">주소 검색</div>
            <div class="second">
              <input name="address" type="text">
            </div>
            <div class="third">
              <div id="addressSearchButton" class="button">추가</div>
            </div>
          </div>
          <div id="layerContainer" class="mainContents bodyHeight hidden"></div>
          <div id="pvrContainer" class="mainContents bodyHeight hidden"></div>
          <div id="anchor" class="hidden">
            <div id="iconPropArea" class="propertyWidth bodyHeight">
              <form id="iconPropForm">
                <div class="propertyElement iconProp propertyWidth markerIconProperty hotspotIconProperty">
                  <div class="propertyName propertyWidth">
                    설명
                  </div>
                  <div class="propertyContents propertyWidth">
                    <textarea name="iconDesc" class="propTextareaWidth fixSize"></textarea>
                  </div>
                </div>
                <div class="propertyElement iconProp propertyWidth markerIconProperty markerProperty hotspotIconProperty hotspotProperty">
                  <div class="propertyName propertyWidth">
                    기능
                  </div>
                  <div class="propertyContents propertyWidth">
                    <select name="iconActionType" class="propSelectWidth">
                      <option value="none">없음</option>
                      <option value="linkToPvr">PVR연결</option>
                      <option class="iconProp markerIconProperty markerProperty" value="showInform">정보 보여주기</option>
                      <!--<option class="iconProp markerIconProperty markerProperty" value="linkToUrl">링크 연결</option>-->
                    </select>
                  </div>
                </div>
                <div class="propertyElement iconProp propertyWidth pvrInformProp informProp">
                  <div class="propertyName propertyWidth">
                    정보 팝업 제목
                  </div>
                  <div class="propertyContents propertyWidth">
                    <input name="informTitle">
                  </div>
                </div>
                <div class="propertyElement iconProp propertyWidth pvrInformProp informProp">
                  <div class="propertyName propertyWidth">
                    정보 팝업 내용
                  </div>
                  <div class="propertyContents propertyWidth">
                    <div class="radioBox">
                      <input type="radio" name="informType" value="text" checked>
                      이미지/텍스트
                    </div>
                    <div class="radioBox last">
                      <input type="radio" name="informType" value="url">
                      웹사이트 링크
                    </div>                    
                    <input name="informImgFile" class="informContentInput textInformInput" type="file">
                    <textarea name="informText" class="informContentInput textInformInput propTextareaWidth fixSize"></textarea>
                    <input name="linkedUrl" class="informContentInput urlInformInput hidden">
                  </div>
                </div>
                <div class="propertyElement iconProp propertyWidth projectMarkerProperty">
                  <div class="propertyName propertyWidth">
                    기능
                  </div>
                  <div class="propertyContents propertyWidth">
                    <select name="projectMarkerActionType" class="propSelectWidth" disabled>
                      <option value="none" selected>프로젝트 연결</option>
                    </select>
                  </div>
                </div>
                <div class="propertyElement iconProp propertyWidth markerProperty projectMarkerProperty">
                  <div class="propertyName propertyWidth">
                    표시 zoom 범위
                  </div>
                  <div class="propertyContents propertyWidth">
                    <input type="text" name="objMinZoom" class="small"> -
                    <input type="text" name="objMaxZoom" class="small">
                  </div>
                </div>
                <div class="propertyElement iconProp propertyWidth markerProperty projectMarkerProperty">
                  <div class="propertyName propertyWidth">
                    좌표
                  </div>
                  <div class="propertyContents propertyWidth">
                    LAT<input name="objLat">
                    <br>LNG<input name="objLng">
                  </div>
                </div>
                <div class="propertyElement iconProp propertyWidth hotspotProperty">
                  <div class="propertyName propertyWidth">
                    좌표
                  </div>
                  <div class="propertyContents propertyWidth">
                    수평<input name="ath">
                    <br>수직<input name="atv">
                  </div>
                </div>                                
                <div class="propertyElement iconProp propertyWidth markerProperty hotspotProperty markerIconProperty hotspotIconProperty projectMarkerProperty">
                  <div class="buttonBox"> 
                    <div class="button iconProp markerProperty hotspotProperty projectMarkerProperty" id="iconModifyButton">수정</div>
                    <div class="button" id="iconDeleteButton">삭제</div>
                  </div>
                </div>
              </form>
            </div>
            <div id="propertyToggleButton"></div>
          </div>
        </div>        
      </div>
    </div>
    <div class="loadingContainer hidden">
      <div class="loadingProgress">
        <img src="source/loading.gif">
      </div>
    </div>
    
    <script type="text/javascript">
    var file, myjqxhr, db, curMainData, curMainIcon, projectId = null, userId,
        googleTileUrl = "https://mts1.google.com/vt/lyrs=m@231000000&hl=ko&gl=KR&src=app&x={x}&y={y}&z={z}&s={s}",
        map, publicMap, pvrPlayer, 
        videoPlayer=new VideoPlayer(null, {
          mode: 'krpano'
        });
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

    function setForNodePropertyArea(){
      $('input[type=radio][name=tileImageType]').change(function (){
        $('.tileImageInput').addClass('hidden');
        $('.'+this.value+'Input').removeClass('hidden');
      });
      $('input[type=radio][name=pvrImageType]').change(function (){
        $('.pvrImageInput').addClass('hidden');
        $('.'+this.value+'Input').removeClass('hidden');
      });
      $('#setInitialView').click(function (){
        $('input[name|="initialLat"]').val(map.map.getCenter().lat.toFixed(4));
        $('input[name|="initialLng"]').val(map.map.getCenter().lng.toFixed(4));
        $('input[name|="initialZoom"]').val(map.map.getZoom());
      });
      $('#getCurPvrView').click(function (){
        $('input[name|="initialAth"]').val(pvrPlayer.getView().hlookat.toFixed(4));
        $('input[name|="initialAtv"]').val(pvrPlayer.getView().vlookat.toFixed(4));
        $('input[name|="initialFov"]').val(pvrPlayer.getView().fov.toFixed(4));
      });

      $('#nodeModifyButton').click(function (){
        var newVal, mapData, layer, vtour;

        if(curMainData.options.type == 'layer'){
          //이름이 달라졌을 경우
          newVal = $('#propertyForm input[name|=name]').val();
          if(newVal != curMainData.options.name){
            //이름의 중복을 확인함
            mapData = db['map'][curMainData.options.mapId];
            if( checkDupleOfName(mapData.options.layerList, newVal) ){
              alert("중복된 이름입니다.");
            }
            else {
              curMainData.options.name = newVal;
              file.changeNodeData('l'+curMainData.id, newVal);
              mapData.options.layerList[getIdxById(mapData.options.layerList, curMainData.id)].name = newVal;
            }
            saveData(curMainData);
          }
          //타일의 min zoom이 변경되었을 경우 
          newVal = $('#propertyForm input[name|=mapMinZoom]').val();
          if(newVal != curMainData.options.minZoom){
            curMainData.options.minZoom = newVal;
            map.tileLayerList[curMainData.id].setOption('minZoom', newVal);
            saveData(curMainData);
          }
          //타일의 max zoom이 변경되었을 경우 
          newVal = $('#propertyForm input[name|=mapMaxZoom]').val();
          if(newVal != curMainData.options.maxZoom){
            curMainData.options.maxZoom = newVal;
            map.tileLayerList[curMainData.id].setOption('maxZoom', newVal);
            saveData(curMainData);
          }
          //타일 타입이 달라졌을 경우 
          newVal = $('#propertyForm input[name|=tileImageType]:checked').val();
          if(newVal != curMainData.options.tileImageType){
            //preset인 경우 구글 지도를 기본값으로 설정해 준다. 
            if(newVal == 'presetMap'){              
              curMainData.tileUrl = googleTileUrl;
              map.tileLayerList[curMainData.id].setTileUrl(googleTileUrl);
              curMainData.options.maxNativeZoom = 22;
              map.tileLayerList[curMainData.id].setOption('maxNativeZoom', 22);              
              curMainData.options.tileImageType = newVal;
              map.tileLayerList[curMainData.id].setOption('tileImageType', newVal);
              saveData(curMainData);
            }
            //usermap인 경우 파일을 업로드 한 경우에만 수정이 됩니다.
            else if( $('#propertyForm input[name|=tileImageFile]').val() ){
              curMainData.options.maxNativeZoom = '0';
              map.tileLayerList[curMainData.id].setOption('maxNativeZoom', '0');
              curMainData.options.tileImageType = newVal;
              map.tileLayerList[curMainData.id].setOption('tileImageType', newVal);
              saveData(curMainData);
            }
            else{
              alert("사용자 지도를 사용하기 위해서는 지도 이미지를 업로드 해야합니다.");
            }
          }

          newVal = $('#propertyForm select[name|="mainPvr"]').val();
          if(newVal != curMainData.options.mainPvr){
            curMainData.options.mainPvr = newVal;
            map.tileLayerList[curMainData.id].setOption('mainPvr', newVal);
            saveData(curMainData);
          }

          //타일용 이미지 파일이 올라왔을 경우
          newVal = $('#propertyForm input[name|=tileImageFile]').val();
          if(newVal){
            $('#propertyForm').ajaxSubmit({
              async: false,
              data: {
                req: "uploadTileImage",
                data: {
                  projectId: projectId,
                  id: curMainData.id
                } 
              },
              type: 'post',
              url: 'file.php',              
              success: function (newTileUrl){                
                curMainData.tileUrl = newTileUrl;
                map.tileLayerList[curMainData.id].setTileUrl( noCacheUrl(newTileUrl) );
                saveData(curMainData);
              },
              beforeSend: function (jqxhr){                
                myjqxhr = jqxhr;
                $('.loadingContainer').removeClass('hidden');
              },
              complete: function(){
                myjqxhr = null;
                $('.loadingContainer').addClass('hidden');
              }
            });
          }

          newVal = Number($('#propertyForm input[name|=initialLat]').val()).toFixed(4);
          if(newVal != curMainData.options.mainView.latlng.lat){
            var newView = {
              latlng: {
                lat: newVal,
                lng: curMainData.options.mainView.latlng.lng
              },
              zoom: curMainData.options.mainView.zoom
            };
            curMainData.options.mainView = newView;
            map.tileLayerList[curMainData.id].setOption('mainView', newView);
            saveData(curMainData);
          }

          newVal = Number($('#propertyForm input[name|=initialLng]').val()).toFixed(4);
          if(newVal != curMainData.options.mainView.latlng.lng){
            var newView = {
              latlng: {
                lat: curMainData.options.mainView.latlng.lat,
                lng: newVal
              },
              zoom: curMainData.options.mainView.zoom
            };
            curMainData.options.mainView = newView;
            map.tileLayerList[curMainData.id].setOption('mainView', newView);
            saveData(curMainData);
          }

          newVal = $('#propertyForm input[name|=initialZoom]').val();
          if(newVal != curMainData.options.mainView.zoom){
            var newView = {
              latlng: {
                lat: curMainData.options.mainView.latlng.lat,
                lng: curMainData.options.mainView.latlng.lng
              },
              zoom: newVal
            };
            curMainData.options.mainView = newView;
            map.tileLayerList[curMainData.id].setOption('mainView', newView);
            saveData(curMainData);
          }

          showLayerData(curMainData);
        }

        if(curMainData.options.type == 'vtour'){
          //이름이 달라졌을 경우
          newVal = $('#propertyForm input[name|=name]').val();
          if(newVal != curMainData.options.name){
            //이름의 중복을 확인함
            layer = db['layer'][curMainData.options.layerId];
            if( checkDupleOfName(layer.options.vtourList, newVal) ){
              alert("중복된 이름입니다.");
            }
            else{
              curMainData.options.name = newVal;              
              file.changeNodeData('vt'+curMainData.id, newVal);
              layer.options.vtourList[getIdxById(layer.options.vtourList, curMainData.id)].name = newVal;
            }
            saveData(curMainData);
          }

          newVal = $('#propertyForm select[name|=mainPvr]').val();
          if(newVal != curMainData.options.mainPvr){
            curMainData.options.mainPvr = newVal;
            saveData(curMainData);
          }

          newVal = $('#propertyForm input[name|=initialLat]').val();
          if(newVal != curMainData.latlng.lat){
            var newLatlng = {
              lat: newVal,
              lng: curMainData.latlng.lng
            };
              
            curMainData.latlng = newLatlng;
            map.viewList[curMainData.id].latlng = newLatlng;
            saveData(curMainData);
          }

          newVal = $('#propertyForm input[name|=initialLng]').val();
          if(newVal != curMainData.latlng.lng){
            var newLatlng = {
              lat: curMainData.latlng.lat,
              lng: newVal
            };
            curMainData.latlng = newLatlng;
            map.viewList[curMainData.id].latlng = newLatlng;
            saveData(curMainData);
          }

          newVal = $('#propertyForm input[name|=initialZoom]').val();
          if(newVal != curMainData.zoom){
            curMainData.zoom = newVal;
            map.viewList[curMainData.id].zoom = newVal;
            saveData(curMainData);
          }


          showVtourData(curMainData); 
        }

        if(curMainData.options.type == 'pvr'){
          //이름이 달라졌을 경우
          newVal = $('#propertyForm input[name|=name]').val();
          if(newVal != curMainData.options.name){
            //이름의 중복을 확인함
            vtour = db['vtour'][curMainData.options.vtourId];            
            if( checkDupleOfName(vtour.options.pvrList, newVal) ){
              alert("중복된 이름입니다.");
            }
            else{
              curMainData.options.name = newVal;
              file.changeNodeData('pvr'+curMainData.id, newVal);
              pvrPlayer.sceneList[curMainData.id].setOption('name', newVal);
              vtour.options.pvrList[getIdxById(vtour.options.pvrList, curMainData.id)].name = newVal;
              saveData(curMainData);
            }
          }

          if($('input[name|="pvrImageType"]:checked').val()=='picture'){
            newVal = $('#propertyForm input[name|="pvrImageFile[]"').val();
            if(newVal){              
              $('#propertyForm').ajaxSubmit({
                data: {
                  req: "uploadPvrImage",
                  data: {
                    projectId: projectId,
                    id: curMainData.id,
                    numOfImage: $('#propertyForm input[name|="pvrImageFile[]"')[0].files.length
                  } 
                },
                type: 'post',
                url: 'file.php',
                success : function (pvrPath){
                  $('#propertyForm input[name|="pvrImageFile[]"').val("");
                  curMainData.options.pvrPath = pvrPath;
                  pvrPlayer.sceneList[curMainData.id].setOption('pvrPath', pvrPath);
                  saveData(curMainData);
                  pvrPlayer.refresh();
                  showPvrData(curMainData);
                },
                beforeSend: function (jqxhr){
                  myjqxhr = jqxhr;
                  $('.loadingContainer').removeClass('hidden');
                },
                complete: function(){
                  myjqxhr = null;
                  $('.loadingContainer').addClass('hidden');
                }
              });
            }
          }
          else if($('input[name|="pvrImageType"]:checked').val()=='panorama'){
            newVal = $('#propertyForm input[name|="pvrPanoFile"').val();
            if(newVal){
              $('#propertyForm').ajaxSubmit({
                data: {
                  req: "uploadPvrPano",
                  data: {
                    projectId: projectId,
                    id: curMainData.id
                  } 
                },
                type: 'post',
                url: 'file.php',
                success : function (pvrPath){
                  $('#propertyForm input[name|="pvrPanoFile"').val("");
                  curMainData.options.pvrPath = pvrPath;                  
                  pvrPlayer.sceneList[curMainData.id].setOption('pvrPath', pvrPath);                  
                  saveData(curMainData);
                  pvrPlayer.refresh();
                  showPvrData(curMainData);
                },
                beforeSend: function (jqxhr){
                  myjqxhr = jqxhr;
                  $('.loadingContainer').removeClass('hidden');
                },
                complete: function(){
                  myjqxhr = null;
                  $('.loadingContainer').addClass('hidden');
                }
              });
            }
          }

          newVal = $('#propertyForm input[name|=initialAth]').val();
          if(newVal != curMainData.options.initialAth){
            curMainData.options.initialAth = newVal;
            pvrPlayer.sceneList[curMainData.id].setOption('initialAth', newVal);
            saveData(curMainData);
          }
          newVal = $('#propertyForm input[name|=initialAtv]').val();
          if(newVal != curMainData.options.initialAtv){
            curMainData.options.initialAtv = newVal;
            pvrPlayer.sceneList[curMainData.id].setOption('initialAtv', newVal);
            saveData(curMainData);
          }
          newVal = $('#propertyForm input[name|=initialFov]').val();
          if(newVal != curMainData.options.initialFov){
            curMainData.options.initialFov = newVal;
            pvrPlayer.sceneList[curMainData.id].setOption('initialFov', newVal);
            saveData(curMainData);
          }

          pvrPlayer.refresh();
          showPvrData(curMainData);
        }                
      });

      $('#nodeDeleteButton').click(function (){
        if(!confirm("삭제하시겠습니까?")) return;
        deleteNode(curMainData.options.type, curMainData.id);
      });
    }

    function removeTempMarker(){
      if(db['projectMarker']['-1']){
        publicMap.delMarker('-1');
        delete db['projectMarker']['-1'];
      }
      if(db['marker']['-1']){
        map.delMarker('-1');
        delete db['marker']['-1']; 
      }
    }

    function setForIconPropertyArea(){
      $('textarea[name|="iconDesc"]').change(function (){
        if(curMainIcon.options.type == "markerIcon" || curMainIcon.options.type == "hotspotIcon"){
          newVal = $(this).val();
          curMainIcon.options.actionType = newVal;
          if(curMainIcon.options.type == "markerIcon"){
            map.iconList[curMainIcon.id].setOption('desc', newVal);
          }
          else if(curMainIcon.options.type == "hotspotIcon"){
            pvrPlayer.iconList[curMainIcon.id].setOption('desc', newVal);
          }
          saveData(curMainIcon);
        }
      });

      $('input[name|="informTitle"]').change(function(){
        if(curMainIcon.options.type == "markerIcon" || curMainIcon.options.type == "hotspotIcon"){
          newVal = $(this).val();
          curMainIcon.options.informTitle = newVal;
          if(curMainIcon.options.type == "markerIcon"){
            map.iconList[curMainIcon.id].setOption('informTitle', newVal);
          }
          else if(curMainIcon.options.type == "hotspotIcon"){
            pvrPlayer.iconList[curMainIcon.id].setOption('informTitle', newVal);
          }
          saveData(curMainIcon);
        }
      });

      $('input[name|="informType"]').change(function(){
        var newVal;

        $('.informContentInput').addClass('hidden');
        newVal = $('input[name|="informType"]:checked').val();
        if(newVal == "text"){
          $('.textInformInput').removeClass('hidden');
        }
        else if(newVal == "url"){
          $('.urlInformInput').removeClass('hidden');
        }

        if(curMainIcon.options.type == "markerIcon"){
          $('input[name|="informImgFile"]').addClass('hidden');
          curMainIcon.options.informType = newVal;
          map.iconList[curMainIcon.id].setOption('informType', newVal);
          saveData(curMainIcon);
        }
      });

      $('textarea[name|="informText"]').change(function(){
        if(curMainIcon.options.type == "markerIcon" || curMainIcon.options.type == "hotspotIcon"){
          newVal = $(this).val();
          curMainIcon.options.informText = newVal;
          if(curMainIcon.options.type == "markerIcon"){
            map.iconList[curMainIcon.id].setOption('informText', newVal);
          }
          else if(curMainIcon.options.type == "hotspotIcon"){
            pvrPlayer.iconList[curMainIcon.id].setOption('informText', newVal);
          }
        }
      });

      $('input[name|="linkedUrl"]').change(function(){
        if(curMainIcon.options.type == "markerIcon" || curMainIcon.options.type == "hotspotIcon"){
          newVal = $(this).val();
          curMainIcon.options.linkedUrl = newVal;
          if(curMainIcon.options.type == "markerIcon"){
            map.iconList[curMainIcon.id].setOption('linkedUrl', newVal);
          }
          else if(curMainIcon.options.type == "hotspotIcon"){
            pvrPlayer.iconList[curMainIcon.id].setOption('linkedUrl', newVal);
          }
        }
      });

      $('select[name|="iconActionType"]').change(function (){
        var options = {};

        if(this.value == "linkToPvr"){
          if(curMainIcon.options.type == "markerIcon" || curMainIcon.options.type == "marker"){
            if(map._curLayer) options.layerId = map._curLayer.id;
          }
          else if(curMainIcon.options.type == "hotspotIcon" || curMainIcon.options.type == "hotspot"){
            if(curMainData) options.layerId = getRelationalLayerId(curMainData);
          }
          options.linkedPvr = curMainIcon.options.linkedPvr;
          options.type = curMainIcon.options.type;
        }

        $('input[name|="informType"][value="text"]').click();
        drawInputAreaByActionType(this.value, options);

        if(curMainIcon.options.type == "markerIcon"){
          $('input[name|="informImgFile"]').addClass('hidden');
        }
        if(curMainIcon.options.type == "hotspotIcon" || curMainIcon.options.type == "hotspot"){
          $('.informProp').addClass('hidden');
        }

        //marker Icon의 경우 변화를 바로 저장한다.
        if(curMainIcon.options.type == "markerIcon" || curMainIcon.options.type == "hotspotIcon"){
          newVal = $(this).val();
          curMainIcon.options.actionType = newVal;
          if(curMainIcon.options.type == "markerIcon"){
            map.iconList[curMainIcon.id].setOption('actionType', newVal);
          }
          else if(curMainIcon.options.type == "hotspotIcon"){
            pvrPlayer.iconList[curMainIcon.id].setOption('actionType', newVal);
          }
          saveData(curMainIcon);
        }
      });

      $('#iconModifyButton').click(function (){
        var newMarker;
        
        if(curMainIcon.options.type == "marker"){
          newVal = $('select[name|="iconActionType"]').val();
          if(newVal != curMainIcon.options.actionType){
            curMainIcon.options.actionType = newVal;
            map.markerList[curMainIcon.id].setOption('actionType', newVal);
          }          

          newVal = $('input[name|="objMaxZoom"]').val();
          if(newVal != curMainIcon.options.maxLevel){
            curMainIcon.options.maxLevel = newVal;
            map.markerList[curMainIcon.id].setOption('maxLevel', newVal);
          }

          newVal = $('input[name|="objMinZoom"]').val();
          if(newVal != curMainIcon.options.minLevel){
            curMainIcon.options.minLevel = newVal;
            map.markerList[curMainIcon.id].setOption('minLevel', newVal);
          }

          newVal = Number($('input[name|="objLat"]').val()).toFixed(4);
          if(newVal != curMainIcon.latlng.lat){
            curMainIcon.latlng.lat = newVal;
            map.markerList[curMainIcon.id].setLatLng([newVal, curMainIcon.latlng.lng]);
          }

          newVal = Number($('input[name|="objLng"]').val()).toFixed(4);
          if(newVal != curMainIcon.latlng.lng){
            curMainIcon.latlng.lng = newVal;
            map.markerList[curMainIcon.id].setLatLng([curMainIcon.latlng.lat, newVal]);
          }

          //if linkedpvr input ins't exists, just ignore the value
          if($('select[name|="linkedPvr"]')[0]){
            newVal = $('select[name|="linkedPvr"]').val();
            if(newVal != curMainIcon.options.linkedPvr){
              curMainIcon.options.linkedPvr = newVal;
              map.markerList[curMainIcon.id].setOption('linkedPvr', newVal);
            }
          }          

          newVal = $('input[name|="informType"]:checked').val();
          if(newVal != curMainIcon.options.informType){
            curMainIcon.options.informType = newVal;
            map.markerList[curMainIcon.id].setOption('informType', newVal);
          }

          newVal = $('input[name|="informTitle"]').val();
          if(newVal != curMainIcon.options.informTitle){
            curMainIcon.options.informTitle = newVal;
            map.markerList[curMainIcon.id].setOption('informTitle', newVal);
          }

          newVal = $('textarea[name|="informText"]').val();
          if(newVal != curMainIcon.options.informText){
            curMainIcon.options.informText = newVal;
            map.markerList[curMainIcon.id].setOption('informText', newVal);
          }

          newVal = $('input[name|="linkedUrl"]').val();
          if(newVal != curMainIcon.options.linkedUrl){
            curMainIcon.options.linkedUrl = newVal;
            map.markerList[curMainIcon.id].setOption('linkedUrl', newVal);
          }

          if(curMainIcon.id == -1){
            newId = getNewId('marker');
            curMainIcon.id = newId;
            db['marker'][newId] = curMainIcon; 
            newMarker = map.addMarker(curMainIcon.id, curMainIcon.latlng, curMainIcon.options);
            setMarker(newMarker);
            removeTempMarker();  
          }

          saveData(curMainIcon);

          newVal = $('input[name|="informImgFile"]').val();
          if(newVal){
            $('#iconPropForm').ajaxSubmit({              
              data: {
                req: "uploadInformImage",
                data: {
                  projectId: projectId,
                  id: curMainIcon.id
                } 
              },
              type: 'post',
              url: 'file.php',              
              success: function (informImgUrl){                
                curMainIcon.options.informImgUrl = informImgUrl;
                map.markerList[curMainIcon.id].setOption('informImgUrl', informImgUrl);

                saveData(curMainIcon);
              },
              beforeSend: function (jqxhr){                
                myjqxhr = jqxhr;
                $('.loadingContainer').removeClass('hidden');
              },
              complete: function(){
                myjqxhr = null;
                $('.loadingContainer').addClass('hidden');
                $('input[name|="informImgFile"]').val('');
              }
            });
          }            
        }
        else if(curMainIcon.options.type == "hotspot"){ 
          newVal = $('select[name|="iconActionType"]').val();
          if(newVal != curMainIcon.options.actionType){
            curMainIcon.options.actionType = newVal;
            pvrPlayer
            pvrPlayer.hotspotList[curMainIcon.id].setOption('actionType', newVal);
          }

          if($('select[name|="linkedPvr"]')[0]) {
            newVal = $('select[name|="linkedPvr"]').val();
            if(newVal != curMainIcon.options.linkedPvr){
              curMainIcon.options.linkedPvr = newVal;
              pvrPlayer.hotspotList[curMainIcon.id].setOption('linkedPvr', newVal);
            }
          }
          

          newVal = Number($('input[name|="ath"]').val()).toFixed(4);
          if(newVal != curMainIcon.ath){
            curMainIcon.ath = newVal;
            pvrPlayer.hotspotList[curMainIcon.id].setAthAtv(newVal, curMainIcon.atv);
          }

          newVal = Number($('input[name|="atv"]').val()).toFixed(4);
          if(newVal != curMainIcon.atv){
            curMainIcon.atv = newVal;
            pvrPlayer.hotspotList[curMainIcon.id].setAthAtv(curMainIcon.ath, newVal);
          }

          newVal = $('textarea[name|="textInfo"]').val();
          if(curMainIcon.options.textfield && 
            newVal != curMainIcon.options.textfield.options.text){
            
            curMainIcon.atv = newVal;
            pvrPlayer.hotspotList[curMainIcon.id].setAthAtv(curMainIcon.ath, newVal);
          }


          pvrPlayer.saveCurState();
          pvrPlayer.refresh();
          pvrPlayer.loadPrevState();
          pvrPlayer.setView(curMainIcon.ath, curMainIcon.atv);

          saveData(curMainIcon);
        }
        else if(curMainIcon.options.type == "projectMarker"){
          newVal = $('input[name|="objMaxZoom"]').val();
          if(newVal != curMainIcon.options.maxLevel){
            curMainIcon.options.maxLevel = newVal;
            publicMap.markerList[curMainIcon.id].setOption('maxLevel', newVal);
          }

          newVal = $('input[name|="objMinZoom"]').val();
          if(newVal != curMainIcon.options.minLevel){
            curMainIcon.options.minLevel = newVal;
            publicMap.markerList[curMainIcon.id].setOption('minLevel', newVal);
          }

          newVal = Number($('input[name|="objLat"]').val()).toFixed(4);
          if(newVal != curMainIcon.latlng.lat){
            curMainIcon.latlng.lat = newVal;
            publicMap.markerList[curMainIcon.id].setLatLng([newVal, curMainIcon.latlng.lng]);
          }

          newVal = Number($('input[name|="objLng"]').val()).toFixed(4);
          if(newVal != curMainIcon.latlng.lng){
            curMainIcon.latlng.lng = newVal;
            publicMap.markerList[curMainIcon.id].setLatLng([curMainIcon.latlng.lat, newVal]);
          }

          if(curMainIcon.id == -1){
            curMainIcon.id = projectId;
            db['projectMarker'][projectId] = curMainIcon;
            newMarker = publicMap.addMarker(curMainIcon.id, curMainIcon.latlng, curMainIcon.options);
            setMarker(newMarker);
            removeTempMarker();
          }

          saveData(curMainIcon);
        }    
          
          /*else {
            if(curMainIcon.options.type == "projectMarker"){
              var newMarker;

              curMainIcon.id = projectId;
              db['projectMarker'][projectId] = curMainIcon;
              newMarker = publicMap.addMarker(curMainIcon.id, curMainIcon.latlng, curMainIcon.options);
              setMarker(newMarker);
              saveData(curMainIcon);
              removeTempMarker();
            }
            else if(curMainIcon.options.type == "marker"){
              var newMarker, newId;

              newId = getNewId('marker');
              curMainIcon.id = newId;
              db['marker'][newId] = curMainIcon; 
              newMarker = map.addMarker(curMainIcon.id, curMainIcon.latlng, curMainIcon.options);
              setMarker(newMarker);
              saveData(curMainIcon);
              removeTempMarker();
            }
          }*/

          $('#anchor').addClass('hidden');
        });    

      $('#iconDeleteButton').click(function (){
        var ret;

        ret = confirm("삭제하시겠습니까?");
        if(!ret) return;

        deleteIcon(curMainIcon.options.type, curMainIcon.id);
      });

      //사실 icon property Area에 속하지 않는 항목들 
      $('.addIcon').hover(function(){
        $('.addIcon').attr('src', "source/newIcon_hover.png");
      },function(){
        $('.addIcon').attr('src', "source/newIcon.png");
      });
      $('.addIcon').click(function(){
        if(projectId!==null){
          $('#iconForm input[name="iconImageFile[]"]').click();
        }
      });
      $('#iconForm input[name="iconImageFile[]"]').change(function(){
        var newId, mainViewContent, newNode, type, i;

        //아이콘 추가
        mainViewContent = $('#pvrContainer').hasClass('hidden')? "map": "pvr";
        newId = [];
        for(i=0; i<document.getElementById('iconImageFile').files.length; i++){
          newId[i] =  mainViewContent=="map"? getNewId('markerIcon'): getNewId('hotspotIcon');
        }        
        type =  mainViewContent=="map"? 'markerIcon': 'hotspotIcon';

        //파일 전송 후 각종 값을 사용하여 아이콘을 추가함
        $('#iconForm').ajaxSubmit({
          type: 'post',
          url : 'file.php',
          data: {
            req: "uploadIconImage",
            data: {
              type: type,
              id: newId,
              projectId: projectId
            }
          },
          dataType: 'json',
          success: function(iconList){
            var idx, i;

            for(i=0; i<iconList.length; i++){
              newNode = {
                id: newId[i],
                options: {
                  iconUrl: iconList[i].options.iconUrl,
                  size: {
                    x: iconList[i].options.size.x,
                    y: iconList[i].options.size.y
                  },
                  iconAnchor: {
                    x: iconList[i].options.size.x/2,
                    y: iconList[i].options.size.y/2
                  },
                  actionType: 'showInform',
                  informType: 'text',
                  type: type,
                  projectId: projectId
                }
              };
              db[type][newId[i]] = newNode;
              idx = addIconToMenu(newId[i], newNode.options);

              if(mainViewContent=="map"){
                var options = {};
                for(key in newNode.options){
                  options[key] = newNode.options[key];
                }
                options.iconUrl = noCacheUrl(options.iconUrl);
                map.addIcon(newNode.id, options);
              }
              else {
                var options = {};
                for(key in newNode.options){
                  options[key] = newNode.options[key];
                }
                options.iconUrl = noCacheUrl(options.iconUrl);
                pvrPlayer.addIcon(newNode.id, options);
              }
              newNode.options.order = idx;
              saveData(newNode);
            }            
            $('#iconForm input[name="iconImageFile[]"]').val('');
          },
          beforeSend: function (jqxhr){
            myjqxhr = jqxhr;
            $('.loadingContainer').removeClass('hidden');
          },
          complete: function(){
            myjqxhr = null;
            $('.loadingContainer').addClass('hidden');
          }
        });
      });
    }

    function setForLoadingContainer(){
      $('#loadingContainer').click(function (){
        if( confirm('처리를 중단하시겠습니까?') ){
          myjqxhr.abort();
          myjqxhr = null;
          $('#loadingContainer').addClass('hidden');
        }
      })
    }

    function setForDragNDrop(){
      $('.mainContents').on('dragover', function(ev){ allowDrop(ev.originalEvent); });
      $('.mainContents').on('drop',     function(ev){ drop(ev.originalEvent);      });
      
      map.map.on('mousemove', function (mouse){
        var newMarker, newId, options;
        if(dropData!==null && map._curLayer!==null){
          newId = -1;
          options = {
            layerId: map._curLayer.id,
            icon: dropData,
            minLevel: map.map.getZoom(), 
            maxLevel: map._curLayer.options.maxZoom,
            actionType: curMainIcon.options.actionType,
            linkedPvr: curMainIcon.options.linkedPvr,
            informTitle: curMainIcon.options.informTitle,
            informText: curMainIcon.options.informText,
            linkedUrl: curMainIcon.options.linkedUrl,
            informType: curMainIcon.options.informType,
            type: "marker"
          };
          db['marker'][newId] = {
            id:newId,
            latlng: {
              lat: mouse.latlng.lat,
              lng: mouse.latlng.lng
            },
            options: options
          };

          map.map.setView(mouse.latlng, map.map.getZoom());

          newMarker = map.addMarker(newId, mouse.latlng, options);
          setMarker(newMarker);

          $('#anchor').removeClass('hidden');
          $('#anchor').addClass('forMarker');
          $('.iconBox.clicked').removeClass('clicked');
          curMainIcon = db['marker'][newId];
          showIconData(curMainIcon);

          /*newMarker.on('click', function (){
            var linkedPvr;

            curMainIcon = db['marker'][this.id];
            //$('.iconBox.clicked').removeClass('clicked');
            
            if(this.options.actionType == 'linkToPvr'){
              linkedPvr = loadData('pvr', this.options.linkedPvr);
              $('#fileElepvr'+this.options.linkedPvr).click();
            }

            //showIconData(this);            
            //map.map.setView(this.getLatLng(), map.map.getZoom());

            //$('#anchor').addClass('forMarker');
            //$('#anchor').removeClass('hidden');
          });*/
          setMarker(newMarker);

          dropData = null;
        }
      });
      $('#pvrContainer').on('mousemove', function (mouse){
        var newHotspot, newId, options;
        if(dropData!==null && curMainIcon !== null){
          newId = getNewId('hotspot');
          options = {
            sceneId: pvrPlayer.getCurSceneId(),
            icon: dropData,
            actionType: curMainIcon.options.actionType,
            linkedPvr: curMainIcon.options.linkedPvr,
            textInfo: curMainIcon.options.textInfo,
            type: "hotspot"
          };
          db['hotspot'][newId] = {
            id: newId,
            ath: pvrPlayer.getMousePosition().ath,
            atv: pvrPlayer.getMousePosition().atv,
            options: options
          };

          pvrPlayer.saveCurState();
          newHotspot = pvrPlayer.addHotspot(newId, db['hotspot'][newId].ath, db['hotspot'][newId].atv, options);
          setHotspot(newHotspot);

          saveData(db['hotspot'][newId]);
          dropData = null;
          pvrPlayer.refresh();
          pvrPlayer.loadPrevState();
        }
      });
    }

    function setForTopContainer(){
      $('#addChildButton').click(function (){
        var newId, newName, newNode, newTreeNode;
        
        if(!curMainData) return;       

        if(curMainData.options.type == 'map'){
          newName = prompt("새 레이어의 이름을 입력해주세요");
          if(!newName) return;
          if(checkDupleOfName(curMainData.options.layerList, newName))
            return alert('중복된 이름입니다.');

          newId = getNewId('layer');
          
          newNode = {
            id: newId,
            tileUrl: googleTileUrl,
            options: {
              type: 'layer',
              name: newName,
              mainView:{
                latlng:{lat: 0, lng: 0}, 
                zoom: 0
              },
              maxZoom: 18,
              minZoom: 0,
              maxNativeZoom: 22,
              mapId: curMainData.id,
              tileImageType: 'presetMap',   
              vtourList: []
            }
          }
          newTreeNode = file.addNewNode('m'+curMainData.id, 'l'+newId, newName, 'layer');
          map.addTileLayer(newNode.id, newNode.tileUrl, newNode.options);
          curMainData.options.layerList.push( {id:newId, name:newName} );
          newNode.options.order = curMainData.options.layerList.length-1;
          saveData(newNode);
        }

        //새 vtour 추가
        else if(curMainData.options.type == 'layer'){
          newName = prompt("새 Vtour의 이름을 입력해주세요");
          if(!newName) return;
          if(checkDupleOfName(curMainData.options.vtourList, newName))
            return alert('중복된 이름입니다.');

          newId = getNewId('vtour');
          newNode = {
            id: newId,
            latlng: {
              lat: curMainData.options.mainView.latlng.lat, 
              lng: curMainData.options.mainView.latlng.lng
            },
            zoom: curMainData.options.mainView.zoom,
            options:{
              type: 'vtour',
              layerId: curMainData.id,
              name: newName,
              pvrList: []              
            }
          }
          $.ajax({
            async: false,
            url: 'file.php',
            type: 'post',
            data: {
              req: 'addVtourXml',
              data: {
                projectId: projectId,
                vtourId: newId
              }
            },
            success: function(newXmlPath){
              newNode.xmlPath = newXmlPath;
            }
          });

          newTreeNode = file.addNewNode('l'+curMainData.id, 'vt'+newId, newName, 'vtour');
          map.addView(newNode.id, newNode.latlng, newNode.zoom, newNode.options);
          pvrPlayer.addVtour(newNode.id, newNode.xmlPath, newNode.options);

          curMainData.options.vtourList.push( {id:newId, name:newName} );
          newNode.options.order = curMainData.options.vtourList.length-1;
          
          saveData(newNode);
        }

        else if(curMainData.options.type == 'vtour'){
          newName = prompt("새 PVR의 이름을 입력해주세요");
          if(!newName) return;
          if(checkDupleOfName(curMainData.options.pvrList, newName))
            return alert('중복된 이름입니다.');

          newId = getNewId('pvr');

          newNode = {
            id: newId,
            options:{
              type: 'pvr',
              vtourId: curMainData.id,
              name: newName,
              initialAth: 0,
              initialAtv: 0,
              initialFov: 90
            }
          }

          newTreeNode = file.addNewNode('vt'+curMainData.id, 'pvr'+newId, newName, 'pvr');
          pvrPlayer.addScene(newId, newNode.options);
          pvrPlayer.refresh();

          if( $.isEmptyObject(curMainData.options.pvrList) ){
            curMainData.options.mainPvr = newId;
            saveData({
              id: curMainData.id,
              options: {
                type: 'vtour',
                mainPvr: newId
              }
            });
          }
          if( !getAPvrInLayer(curMainData.options.layerId) ){
            loadData('layer', curMainData.options.layerId).options.mainPvr = newId;
            saveData({
              id: curMainData.options.layerId,
              options: {
                type: 'layer',
                mainPvr: newId
              }
            })
          }

          curMainData.options.pvrList.push( {id:newId, name:newName} );
          newNode.options.order = curMainData.options.pvrList.length-1;         

          saveData(newNode);
        }

        if(!newNode) return;
        db[newNode.options.type][newId] = newNode;
        $(newTreeNode.dom).click();
      });
      $('#previewButton').click(function (){
        if(projectId || projectId === 0){
        //세션에 현재 프로젝트 정보를 넣는다.
          $.ajax({
            type: 'post',
            url: 'setData.php',
            data: {
              req: 'setPreviewData',
              data: {
                projectId: projectId
              }
            },
            success: function (){
              window.open('preview.html', '_blank', 'width=1000, height=600');
            }
          });
        }
      });

      //360 video project upload
      $('#add360VideoProjectButton').click(function (){
        if(!projectId) {
          return;
        }

        $('#360VideoProjectForm input[name="panoVideoZip"]').click();
      });
      $('#360VideoProjectForm input[name="panoVideoZip"]').change(function (){
        $('#360VideoProjectForm').ajaxSubmit({
          data: {
            req: "uploadPanoVideoZip",
            data: {
              userId: userId,
              projectId: projectId
            } 
          },
          type: 'post',
          url: 'file.php',
          success: function () {
            loadProject(projectId); 
          },
          beforeSend: function (jqxhr) {
            myjqxhr = jqxhr;
            $('.loadingContainer').removeClass('hidden');
          },
          complete: function () {
            myjqxhr = null;
            $('.loadingContainer').addClass('hidden');
            $('#360VideoProjectForm input[name="panoVideoZip"]').val('');
          }
        });
      });
    }

    function setForMapSearch(){
      $('#addressSearchButton').click(function(){
        var newLatLng, zoom, projectMarker, newNode, newMarker, options, key;

        removeTempMarker();
        newLatLng = getLatLngFromAddress($('input[name|="address"]').val());
        if(newLatLng){
          //프로젝트 마커 부분
          if($('#mapContainer:not(".hidden")').length){
            publicMap.map.setView(newLatLng, publicMap.map.getMaxZoom());

            //프로젝트 마커가 없다면 새로 추가함.
            if($.isEmptyObject(db.projectMarker)){
              newNode = {
                id: -1,
                latlng: {lat:newLatLng.lat, lng:newLatLng.lng},
                options: {
                  layerId: publicMap._curLayer.id,
                  icon: 1, //publicMap에는 ID가 1인 아이콘이 추가되어 있다.
                  minLevel: publicMap.map.getZoom(), 
                  maxLevel: publicMap._curLayer.options.maxZoom,
                  actionType: 'linkToProject',
                  linkedProjectId: projectId,
                  type: "projectMarker"
                }
              };
              db['projectMarker']['-1'] = newNode;
              newMarker = publicMap.addMarker(newNode.id, newNode.latlng, newNode.options);
              setMarker(newMarker);

            }
            //프로젝트 마커가 이미 있다면 위치를 이동시킴. 
            else {
              newNode = db.projectMarker[projectId];

              db.projectMarker[projectId].latlng = {
                lat: newLatLng.lat, lng: newLatLng.lng
              };
              publicMap.markerList[projectId].setLatLng([newLatLng.lat, newLatLng.lng]);
              saveData(db.projectMarker[projectId]);
            }

            $('#anchor').removeClass('hidden');
            $('#anchor').addClass('forMarker');
            $('.iconBox.clicked').removeClass('clicked');
            showIconData(newNode);
          }
          else if($('#layerContainer:not(".hidden")').length){
            map.map.setView(newLatLng, map._curLayer.options.maxZoom);

            for(key in db.markerIcon){
              break;
            }
            options = {
              layerId: map._curLayer.id,
              icon: key,
              minLevel: map.map.getZoom(), 
              maxLevel: map._curLayer.options.maxZoom,
              actionType: 'linkToPvr',
              linkedPvr: null,
              informType: 'text',
              type: "marker"
            };
            newNode = {
              id: -1,
              latlng: {
                lat: newLatLng.lat,
                lng: newLatLng.lng
              },
              options: options
            };

            db['marker']['-1'] = newNode;
            newMarker = map.addMarker(newNode.id, newNode.latlng, newNode.options);
            setMarker(newMarker); 

            $('#anchor').removeClass('hidden');
            $('#anchor').addClass('forMarker');
            $('.iconBox.clicked').removeClass('clicked');

            curMainIcon = newNode;
            showIconData(newNode);
          }
        }
        else{
          alert("검색에 실패하였습니다.");
        }
        $('input[name|="address"]').val('');
      });
      $('#mapSearch input').keypress(function (ev){
        if(ev.keyCode == 13){
          $('#addressSearchButton').click();
        }
      });
    }

    function setPublicMap(){
      publicMap = new Map(0, "mapContainer", {
        mode  : "edit",
        useView : true
      });

      //지도 추가
      publicMap.addTileLayer(1, googleTileUrl, {
        maxZoom: 18,
        minZoom: 5,
        mainView:{
          latlng:{lat: 36.2, lng: 127.26}, 
          zoom: 7
        }
      });
      publicMap.changeLayer(1);
      publicMap.map.setView([36.2, 127.26], 7);
      publicMap.map.on('mousemove', function(mouse){
        var newNode, newMarker;


        if(dropData!==null && publicMap._curLayer!==null && projectId != null){
          if(!$.isEmptyObject(db.projectMarker)){
            alert("이미 프로젝트 마커가 추가되었습니다.");
            dropData = null;
            return false;
          }

          publicMap.map.setView(mouse.latlng, publicMap.map.getZoom());
          //if(dropData != 1) return;
          newNode = {
            id: -1,
            latlng: {lat:mouse.latlng.lat, lng:mouse.latlng.lng},
            options: {
              layerId: publicMap._curLayer.id,
              icon: dropData,
              minLevel: publicMap.map.getZoom(), 
              maxLevel: publicMap._curLayer.options.maxZoom,
              actionType: 'linkToProject',
              linkedProjectId: projectId,
              type: "projectMarker"
            }
          }; 
          dropData = null;

          db['projectMarker'][newNode.id] = newNode;
          newMarker = publicMap.addMarker(newNode.id, newNode.latlng, newNode.options);
          setMarker(newMarker);      

          $('#anchor').removeClass('hidden');
          $('#anchor').addClass('forMarker');
          $('.iconBox.clicked').removeClass('clicked');
          curMainIcon = newNode;
          showIconData(curMainIcon);

        }
      })

      //아이콘 추가
      $('#publicMapIconArea').html(
        '<div class="iconBox first">'+
          '<img dragable="true" id="pmic1" class="iconImage" src="source/marker_icon2.png">'+
        '</div>'
      );
      $('#pmic1').css('height', '55px');
      $('#pmic1')[0].addEventListener('dragstart', function(ev){
        drag(ev);
      });
      publicMap.addIcon(1, {
        iconUrl: 'source/marker_icon2.png',
        size: {x:25, y:40},
        iconAnchor: {x:12.5, y:20},
        type: 'projectMarkerIcon'
      })

      //프로젝트 마커 추가
      $.ajax({
        async: false,
        type: 'get',
        url: 'getData.php',
        data: {
          req: 'getProjectMarkers',
          data: {
            projectId: projectId
          }
        },
        dataType: 'json',
        success: function(data){
          var i, newMarker;

          for(i=0; i<data.markers.length; i++){
            data.markers[i].options.layerId = 1;
            data.markers[i].options.icon = 1;

            db['projectMarker'][projectId] = data.markers[i];
            newMarker = publicMap.addMarker(data.markers[i].id, data.markers[i].latlng, data.markers[i].options);
            setMarker(newMarker);
          }
        }
      });
    }

    /**
     * setForCopingPvr
     *  setting for coping and pasting pvr
     */
    function setForCopingPvr(){
      var pressedCtrl = false, pressingC = false, pressingV = false;
      $(document).bind('keydown', function (ev) {
        switch(ev.keyCode){
          case 17:
          pressedCtrl = true;
          break;

          case 67:
          if(pressedCtrl && !pressingC){
            pressingC = true;
            console.log("wow! you made it!");
          }
          break;
        }
      });
      $(document).bind('keyup', function (ev) {
        switch(ev.keyCode){
          case 17:
          pressedCtrl = false;
          break;
          case 67:
          pressingC = false;
          break;
        }
      });
      $(document).bind('copy', function (ev) {
        console.log('good!!!');
      })
    }

    function getAPvrInLayer(layerId){
      var layer, i, tempVtour;
      layer = loadData('layer', layerId);

      for(i=0; i<layer.options.vtourList.length; i++){
        tempVtour = loadData('vtour', layer.options.vtourList[i].id);
        if( !$.isEmptyObject(tempVtour.options.pvrList) ){
          return loadData('pvr', tempVtour.options.pvrList[0].id);
        } 
      }
      return false;
    }


    $(document).ready(function(){
      userId = 

      map = new Map(0, "layerContainer", {
        mode  : "edit",
        useView : true
      });

      loadProject(<?php echo $_GET['project']?>);
      
      //setPublicMap();
      //setForMenuBar(); 
      setForTopContainer();      
      setForNodePropertyArea();
      setForIconPropertyArea();
      //setForDragNDrop();
      setForLoadingContainer();
      setForMapSearch();

      setForCopingPvr();
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
      projectMarker: {},
      video: {},
      polyline: {}
    };

    function loadProject(project){
      var key;

      //기존 항목 모두 제거
      $('#myKrpano').remove();
      map.map.remove();
      delete map;

      $('#pathArea').html('');
      $('#anchor').addClass('hidden');
      $('.propertyElement').addClass('hidden');
      curMainData = null;
      curMainIcon = null;
      /*map._curLayer = null;
      map.tileLayerList = {};
      map.viewList = {};
      map.iconList = {};
      map.markerList = {};
      map.sortedTileLayerList = [];*/
      


      for(key in db){
        if(key != "user"){
          db[key] = {};  
        }        
      }

      for(key in map.map._layers){
        map.map.removeLayer(map.map._layers[key]);
      }
      $('.iconBox:not(.first)').remove();

      if(publicMap) publicMap.map.remove();


      //////////////////////////////

      projectId = project;
      setPublicMap();

      map = new Map(projectId, "layerContainer", {
        mode  : "edit",
        useView : true
      });

      embedpano({
        target: "pvrContainer", 
        id: "myKrpano", 
        bgcolor: "#FFFFFF", 
        html5: "only", 
        swf: "krpano.swf",
        xml: noCacheUrl("project/"+projectId+"/krpano.xml"),
        onready: setPvrPlayer
      });      
      //file tree 생성 
      $.get('getData.php', {
        req: "getNodeList", 
        data: {
          projectId: projectId
        }
      }, function (data){
        file = new FileTree('fileTreeArea', [data], {
          extendButton:{
            icon: "▼",
            iconOnFold: "▷",
            iconOnHover: "<div style='width:100%;color:blue'>▼</div>",
            blank: "  "
          },
          type:[{
            name: "root",
            parentable: true,
            possibleChildType: ["map"],
            icon: "<img class='myFileIcon' src='source/folder.png'>"
          },
          { name: "map",
            parentable: true,
            possibleChildType: ["layer"],
            icon: "<img class='myFileIcon' src='source/folder.png'>"
          }, 
          { name: "layer",
            parentable: true,
            possibleChildType: ["vtour"],
            icon: "<img class='myFileIcon' src='source/folder.png'>"
          },
          { name: "vtour",
            parentable: true,
            possibleChildType: ["pvr"],
            icon: "<img class='myFileIcon' src='source/folder.png'>"
          },
          { name: "pvr",
            parentable: true,
            possibleChildType: ["file"],
            icon: "<img class='myFileIcon' src='source/file.png'>"
          }]
        });
        file.on('clickNode', function(ev){
          var newId = ev.node.id.replace(/\D/g,''),
              nodeData,
              project, layer, vtour, map;         

          nodeData = loadData(ev.node.type, newId);
          curMainData = nodeData;

          removeTempMarker();
          switch(ev.node.type){
            case 'map':   showMapData(nodeData);    break;
            case 'layer': showLayerData(nodeData);  break;
            case 'vtour': showVtourData(nodeData);  break;
            case 'pvr':   showPvrData(nodeData);    break;
          }
        });

        $('#projectNameArea').html(data.data);
        $('#fileElem'+projectId).click();
      }, 'json');

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
            newNode.options.informType = "text";

            db[newNode.options.type][newNode.id] = newNode;          
            addIconToMenu(newNode.id, newNode.options);
            map.addIcon(newNode.id, newNode.options); 
          }
        }
      });

      $.get('getData.php', {
        req: "getMarkerList",
        data: {
          projectId: projectId
        }
      }, function (data){
        var i, newNode, newMarker;

        for(i=0; i<data.length; i++){
          newNode = data[i];

          loadData('layer', newNode.options.layerId);
          db[newNode.options.type][newNode.id] = newNode;
          newMarker = map.addMarker(newNode.id, newNode.latlng, newNode.options);

          setMarker(newMarker);
        }
      }, 'json');

      loadDataListFromServer('video');
      loadDataListFromServer('polyline');

      setForDragNDrop();
    }

    function setMarker(marker){
      marker.on('dragstart', function (){
        if(marker.options.type == "marker") curMainIcon = db['marker'][this.id];
        else if(marker.options.type == "projectMarker") curMainIcon = db['projectMarker'][this.id];

        showIconData(curMainIcon);

        $('#anchor').addClass('forMarker');
        $('.iconBox.clicked').removeClass('clicked');
        $('#anchor').removeClass('hidden');
      });

      marker.on('dragend', function (){
        $('input[name|="objLat"]').val(this._latlng.lat.toFixed(4));
        $('input[name|="objLng"]').val(this._latlng.lng.toFixed(4));

        if(marker.options.type == "marker"){
          db['marker'][this.id]['latlng']['lat'] = this._latlng.lat;
          db['marker'][this.id]['latlng']['lng'] = this._latlng.lng;
          map.map.setView(this.getLatLng(), map.map.getZoom());
          saveData(db['marker'][this.id]);
        }
        else if(marker.options.type == "projectMarker"){
          db['projectMarker'][this.id]['latlng']['lat'] = this._latlng.lat;
          db['projectMarker'][this.id]['latlng']['lng'] = this._latlng.lng;
          publicMap.map.setView(this.getLatLng(), publicMap.map.getZoom());
          saveData(db['projectMarker'][this.id]);
        }
      });
      marker.on('click', function (){
        if(marker.options.type == "marker"){
          curMainIcon = db['marker'][this.id];
          map.map.setView(this.getLatLng(), map.map.getZoom());
        } 
        else if(marker.options.type == "projectMarker"){
          curMainIcon = db['projectMarker'][this.id];
          publicMap.map.setView(this.getLatLng(), publicMap.map.getZoom());
        } 
        showIconData(curMainIcon);               

        $('#anchor').addClass('forMarker');
        $('.iconBox.clicked').removeClass('clicked');
        $('#anchor').removeClass('hidden');

        if(this.id != -1){
          removeTempMarker();
        }
      });
    }


    function addProject(){
      var newId;

      newName = prompt("새 프로젝트의 이름을 입력해주세요");
      if(!newName) return;

      $.ajax({
        async: false,
        type: 'get',
        url: 'getData.php',
        data: {
          req: 'getProjectList',
          data: {
            userId: userId
          }
        },
        dataType: 'json',
        success: function (data){
          db['user']['options'] = {};
          db['user']['options']['projectList'] = data;
        }
      });

      if(checkDupleOfName(db['user']['options']['projectList'], newName)){
        return alert('중복된 이름입니다.');
      }

      newId = getNewId('project');
      saveData({
        id: newId, 
        options: {
          name: newName,
          userId: userId,
          type: 'project'
        }
      });
      $.ajax({
        async: false,
        type: 'post',
        url: 'file.php',
        data: {
          req: "setNewProject",
          data: {
            projectId: newId
          }
        },
      });

      //기본 지도 아이콘 추가 

      newNode = {
        id: getNewId('markerIcon'),
        options: {
          iconUrl: "source/marker_icon2.png",
          size: {
            x: 25,
            y: 40
          },
          iconAnchor: {
            x: 12.5,
            y: 20
          },
          actionType: 'linkToPvr',
          type: "markerIcon",
          projectId: newId,
          order: 0
        }
      };
      saveData(newNode);

      loadProject(newId);
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
              if(newData.options.tileImageType == 'presetMap') {
                newData.options.maxNativeZoom = 22;
              }
              else {
                newData.options.maxNativeZoom = '0';
              }

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

    function setHotspot(hotspot){
      hotspot.on('click', function(){
        curMainIcon = db['hotspot'][this.id]; 
        showIconData(curMainIcon); 
        $('#anchor').addClass('forMarker');
        $('.iconBox.clicked').removeClass('clicked');
        $('#anchor').removeClass('hidden');
        pvrPlayer.setView(this.ath, this.atv);
      });

      hotspot.on('mousedown', function(){        
        pvrPlayer.startDraggingHotspot(this.id);
        curMainIcon = db['hotspot'][this.id];
        showIconData(curMainIcon);                 

        $('#anchor').addClass('forMarker');
        $('.iconBox.clicked').removeClass('clicked');
        $('#anchor').removeClass('hidden');
      });
      hotspot.on('mouseup', function(){
        curMainIcon.ath = pvrPlayer.krpano.get('hotspot[h'+this.id+'].ath');
        curMainIcon.atv = pvrPlayer.krpano.get('hotspot[h'+this.id+'].atv');
        pvrPlayer.hotspotList[curMainIcon.id].setAthAtv(curMainIcon.ath, curMainIcon.atv);

        saveData(curMainIcon);
        this.fire('click');
      });
    }

    function setPvrPlayer(){
      pvrPlayer = new PvrPlayer(myKrpano, "pvrPlayer");
      pvrPlayer.refresh();

      //hotspot icon 생성
      //pvrPlayer 설정이 끝나야함.
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
            addIconToMenu(newNode.id, newNode.options);
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

    function toggleMapSearch(){
      if($('#mapContainer:not(".hidden")').length 
        || $('#layerContainer:not(".hidden")').length 
        && curMainData.options.type == "layer" 
        && curMainData.options.tileImageType == "presetMap"
        && curMainData.tileUrl == googleTileUrl){
        $('#mapSearch').removeClass('hidden');
      }
      else {
        $('#mapSearch').addClass('hidden');
      }
    }

    function setMainViewContentType(type){
      if(type == "map" && $('#mapContainer').hasClass('hidden')){
        $('#mapContainer').removeClass('hidden');
        $('#pvrContainer').addClass('hidden');
        $('#layerContainer').addClass('hidden');

        $('#publicMapIconArea').removeClass('hidden');
        $('#markerIconArea').addClass('hidden');
        $('#hotspotIconArea').addClass('hidden');

        publicMap.map._onResize();
      }
      if(type == "layer" && $('#layerContainer').hasClass('hidden')){
        $('#layerContainer').removeClass('hidden');
        $('#mapContainer').addClass('hidden');
        $('#pvrContainer').addClass('hidden');

        $('#markerIconArea').removeClass('hidden');
        $('#publicMapIconArea').addClass('hidden');
        $('#hotspotIconArea').addClass('hidden');

        map.map._onResize();
      }
      else if(type == "vtour"){
        $('#pvrContainer').removeClass('hidden');
        $('#mapContainer').addClass('hidden');
        $('#layerContainer').addClass('hidden');

        $('#publicMapIconArea').addClass('hidden');
        $('#hotspotIconArea').addClass('hidden');
        $('#markerIconArea').addClass('hidden');
      }
      else if(type == "pvr" && $('#hotspotIconArea').hasClass('hidden')){
       $('#pvrContainer').removeClass('hidden');
        $('#mapContainer').addClass('hidden');
        $('#layerContainer').addClass('hidden');

        $('#publicMapIconArea').addClass('hidden');
        $('#hotspotIconArea').removeClass('hidden');
        $('#markerIconArea').addClass('hidden');
      }

      toggleMapSearch();
      $('#anchor').addClass('hidden');
      $('.iconBox.clicked').removeClass('clicked');
      curMainIcon = null;
    }

    function showLayerData(newData){
      var mapData, newId, i, j, html, tempVtour, tempPvr;

      $('#anchor.forMarker').addClass('hidden');
      $('.filetreeProp').addClass('hidden');
      $('.layerProperty').removeClass('hidden');
      toggleMapSearch();

      setMainViewContentType('layer');
      mapData = db['map'][newData.options.mapId];
      $('#pathArea').html(
        mapData.options.name + 
        " > " + newData.options.name);

      map.changeLayer(newData.id);
      map.map.setView(newData.options.mainView.latlng, newData.options.mainView.zoom, {animate:false});

      if(curMainIcon){
        newId = curMainIcon.options.type=="markerIcon"?"mic":"hic";
        newId += curMainIcon.id;
        $('#'+newId).click();
      }

      $('select[name|="mainPvr"]').html('');
      html = '';
      for(i=0; i<newData.options.vtourList.length; i++){
        tempVtour = loadData('vtour', newData.options.vtourList[i].id);
        html += '<optgroup label="'+tempVtour.options.name+'">';
        for(j=0; j<tempVtour.options.pvrList.length; j++){
          tempPvr = tempVtour.options.pvrList[j];
          html += '<option value="'+tempPvr.id+'">'+tempPvr.name+'</option>';
        }
        html += '</optgroup>';
      }
      $('select[name|="mainPvr"]').html(html);
      $('select[name|="mainPvr"]').val(newData.options.mainPvr);

      $('.layerProperty').removeClass('hidden');
      //이름
      $('#propertyForm input[name|=name]').val(newData.options.name);
      //이미지 타입
      $('#propertyForm input[name|=tileImageType]:checked').removeAttr('checked')
      $('#propertyForm input[name|=tileImageType][value|='+newData.options.tileImageType+']').click();

      $('#propertyForm input.tileImageInput[type|=file]').val(null);
      $('#propertyForm select[name|="layerMainPvr"]').val(newData.options.mainPvr);

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

      setMainViewContentType('vtour');
      layer = db['layer'][newData.options.layerId];
      mapData = db['map'][layer.options.mapId];

      $('#pathArea').html( 
        mapData.options.name + 
        " > " + layer.options.name +
        " > " + newData.options.name);

      //map.setView(newData.id);
      if(newData.options.mainPvr){
        loadData('pvr', newData.options.mainPvr);
        pvrPlayer.showScene(newData.options.mainPvr);
      }
      else{
        pvrPlayer.changeXml(newData.xmlPath, true);
      }

      if(curMainIcon){
        newId = curMainIcon.options.type=="markerIcon"?"mic":"hic";
        newId += curMainIcon.id;
        $('#'+newId).click();
      }

      $('.vtourProperty').removeClass('hidden');
      $('#anchor').addClass('hidden');


      $('#propertyForm input[name|=name]').val(db['vtour'][newData.id].options.name);
      $('#propertyForm select[name|=mainPvr]>*').remove();
      
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
      $('#anchor.forMarker').addClass('hidden');

      setMainViewContentType('pvr');
      vtour = db['vtour'][newData.options.vtourId];
      layer = db['layer'][vtour.options.layerId];
      mapData = db['map'][layer.options.mapId];

      $('#pathArea').html(
        mapData.options.name +  
        " > " + layer.options.name +
        " > " + vtour.options.name +
        " > " + newData.options.name);

      pvrPlayer.showScene(newData.id);
      
      $('#propertyForm input[name|=name]').val(newData.options.name);
      $('#propertyForm input[name|="pvrImageFile[]"]').val(''); 
      $('#propertyForm input[name|="initialAth"]').val(Number(newData.options.initialAth).toFixed(4));
      $('#propertyForm input[name|="initialAtv"]').val(Number(newData.options.initialAtv).toFixed(4));
      $('#propertyForm input[name|="initialFov"]').val(Number(newData.options.initialFov).toFixed(4));
    }
    function showMapData(newData){
      $('.filetreeProp').addClass('hidden');
      $('.mapProperty').removeClass('hidden');

      setMainViewContentType('map');
      $('#pathArea').html(newData.options.name);

      $('input[name|="projectName"]').val(newData.options.name);
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
        pvrPlayer.delVtour(id);
        $.ajax({
          url: 'file.php',
          type: 'post',
          data: {
            req: 'delVtourXml',
            data: {
              projectId: projectId,
              vtourId: id
            }
          }
        });

        vtourList = db['layer'][oldNode.options.layerId].options.vtourList;
        vtourList.splice(getIdxById(vtourList, id), 1);
        setOrderByIdx('vtour', vtourList);        

        delete db[type][id];        
      }

      if(type == "pvr"){ 
        var vtour, layer, anotherPvr; 

        file.deleteNode('pvr'+id);
        pvrPlayer.delScene(id);

        pvrList = db['vtour'][oldNode.options.vtourId].options.pvrList;
        pvrList.splice(getIdxById(pvrList, id), 1);
        setOrderByIdx('pvr', pvrList);

        vtour = db['vtour'][oldNode.options.vtourId];
        layer = loadData('layer', vtour.options.layerId);

        if(db['vtour'][oldNode.options.vtourId].options.mainPvr == id){
          db['vtour'][oldNode.options.vtourId].options.mainPvr = 
            pvrList.length>0? pvrList[0].id: null;
        }
        if(layer.options.mainPvr == id){
          anotherPvr = getAPvrInLayer(layer.id);
          layer.options.mainPvr = anotherPvr.id || null;
        }

        delete db[type][id];
      }

      //화면을 지워야 하는데?    
      if(type == curMainData.options.type && id == curMainData.id){
        $('.filetreeProp').addClass('hidden');

        curMainData = null;

        if(type == "pvr" || type == "vtour"){
          pvrPlayer.clearScreen();
        }
        //property 및 mainContents를 지워버리는 함수 
      }

      //db에 저장
      delData(oldNode);
    }
    function deleteIcon(type, id){
      var oldNode, IdForFileTree, i, pvrList, newId, iconList;

      if(!db[type][id]) loadData(type,id);
      oldNode = db[type][id];

      if(type == "markerIcon"){ 
        iconId = "mic"+id;

        map.delIcon(id);
        iconList = $('#markerIconArea .iconBox:not(.first) img');
        for(i=0; i<iconList.length; i++){ 
          newId = iconList[i].id.replace(/\D/g,'');
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

      else if(type == "hotspotIcon"){ 
        iconId = "hic"+id;
        pvrPlayer.delIcon(id);
        iconList = $('#hotspotIconArea .iconBox:not(.first) img');
        for(i=0; i<iconList.length; i++){ 
          newId = iconList[i].id.replace(/\D/g,'');
          db['hotspotIcon'][newId].options.order = i;
          saveData({
            id: newId,
            options: {
              type: 'hotspotIcon',
              order: i
            }
          });
        }
        $('#'+iconId).parent().remove();
        delete db[type][id];                
      }

      else if(type == 'marker'){
        map.delMarker(id);
        delete db[type][id];
      }
      else if(type == 'hotspot'){
        pvrPlayer.delHotspot(id);
        delete db[type][id];
      }
      else if(type == 'projectMarker'){
        publicMap.delMarker(id);
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
    function addIconToMenu(id, options){
      var newId, margin;

      newId = options.type=="markerIcon"? "mic": "hic";
      newId += id;

      $('#'+options.type+'Area').append(
        '<div class="iconBox">'+
          '<img dragable="true" class="iconImage" id="'+newId+'" src="'+options.iconUrl+'?'+(new Date()).getTime()+'">'+
        '</div>'
      );

      options.size.x > options.size.y?
        $('#'+newId).css('width', '55px'):
        $('#'+newId).css('height', '55px');

      if(options.size.x > options.size.y){
        margin = (55 - options.size.y * 55 / options.size.x)/2;
        $('#'+newId).css('margin-top', margin+'px');
      }

      $('#'+options.type+'Area .iconBox:last img')[0].addEventListener('dragstart', function(ev){
        drag(ev);
        $(this).click();
        /*$('#iconPropArea').addClass('hidden');
        $('#propertyToggleButton').addClass('hidden');*/
      });
      $('#'+options.type+'Area .iconBox:last img').click(function(){
        var newId;
        
        $('#'+options.type+'Area .iconBox.clicked').removeClass('clicked');
        $(this).parent().addClass('clicked');
        $('#anchor').removeClass('hidden');
        $('.iconBox.clicked').removeClass('hiddenClicked');

        newId = this.id.replace(/\D/g,'');
        curMainIcon = db[options.type][newId];
        showIconData(db[options.type][newId]);

        $('#anchor').removeClass('forMarker');

        removeTempMarker();
      });
      $('#propertyToggleButton').click(function(){
        $('#anchor').addClass('hidden');
        $('.iconBox.clicked').addClass('hiddenClicked');

        curMainIcon = null;
        removeTempMarker();
      });

      return $('#'+options.type+'Area .iconBox').length - 1;
    }

    function drawInputAreaByActionType(actionType, options){
      var html,
          vtourList, pvrList,
          i, j;
      
      $('.informProp').addClass('hidden');
      $('.iconActionInput').remove();
      if(actionType=="linkToPvr"){
        html = '<select name="linkedPvr" class="propSelectWidth iconActionInput">';

        if(!isNaN(options.layerId)){
          vtourList = loadData('layer', options.layerId).options.vtourList;

          for(i=0; i<vtourList.length; i++){
            html += '<optgroup label="'+vtourList[i].name+'">';

            loadData('vtour', vtourList[i].id);
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
          var newVal = $(this).val(), pvrName;

          if(!newVal) return;

          if(curMainIcon.options.type == "markerIcon" || curMainIcon.options.type == "hotspotIcon"){
            curMainIcon.options.linkedPvr = newVal;
            if(curMainIcon.options.type == "markerIcon"){
              map.iconList[curMainIcon.id].setOption('linkedPvr', newVal);
            }
            else if(curMainIcon.options.type == "hotspotIcon"){
              pvrPlayer.iconList[curMainIcon.id].setOption('linkedPvr', newVal);
            }
          }

          pvrName = $('select[name|="linkedPvr"] option[value|="'+newVal+'"]').html();
          $('input[name|="informTitle"]').val(pvrName);
          $('input[name|="informTitle"]').trigger('change');
        });

        
        //linkedPvr의 기본 값을 설정하는 과정
        //값이 없을 경우 기본 값으로 결정 
        //기본적으로 설정을 기억하되, 유효하지 않은 값일 경우 원래 값을 삭제한다. 
        if(options.type == "markerIcon" || options.type == "hotspotIcon"){
          if(!curMainIcon.options.linkedPvr) {
            //set linked pvr as the first value at select 
            curMainIcon.options.linkedPvr = $('select[name|="linkedPvr"]').val();
          }
          //set select linked pvr as linked pvr of current icon
          $('select[name|="linkedPvr"]').val(curMainIcon.options.linkedPvr);

          //if the value of linkedpvr of current icon is invalid, set the value as null
          if($('select[name|="linkedPvr"]').val() != curMainIcon.options.linkedPvr){
            $('select[name|="linkedPvr"] option:first').attr('selected', '');
            console.log($('select[name|="linkedPvr"] option:first'));
            curMainIcon.options.linkedPvr = $('select[name|="linkedPvr"]').val();
          }
        }
        else if(options.type == "marker" || options.type == "hotspot"){
          $('select[name|="linkedPvr"]').val(curMainIcon.options.linkedPvr);
        }
        $('select[name|="linkedPvr"]').trigger('change');
        $('.pvrInformProp').removeClass('hidden');
      }
      else if(actionType == "showInform"){
        $('.informProp').removeClass('hidden');
      }
      else if(actionType=="linkToProject"){
        html = '<select name="linkedProject" disabled class="propSelectWidth iconActionInput">';
        html +=   '<option value="'+projectId+' selected">'+loadData('map',projectId).options.name+'</option>';        
        html += '</select>';

        $('select[name|="projectMarkerActionType"]').after(html);
      }
      /*else if(actionType=="linkToUrl"){
        html = '<input type="text" class="iconActionInput" name="linkedUrl">';
        $('select[name|="iconActionType"]').after(html);
        $('input[name|="linkedUrl"]').val(curMainIcon.options.linkedUrl);

        $('input[name|="linkedUrl"]').change(function(){
          if(curMainIcon.options.type == "markerIcon" || curMainIcon.options.type == "hotspotIcon"){
            newVal = $(this).val();
            curMainIcon.options.linkedUrl = newVal;
            if(curMainIcon.options.type == "markerIcon"){
              map.iconList[curMainIcon.id].setOption('linkedUrl', newVal);
            }
            else if(curMainIcon.options.type == "hotspotIcon"){
              pvrPlayer.iconList[curMainIcon.id].setOption('linkedUrl', newVal);
            }
            saveData(curMainIcon);
          }
        });
      }*/
    }

    function getRelationalLayerId(nodeData){
      var vtour;

      if(nodeData.options.type == "vtour"){
        return nodeData.options.layerId;
      }
      else if(nodeData.options.type == "pvr"){
        vtour = loadData('vtour', nodeData.options.vtourId);
        return vtour.options.layerId; 
      }
    }

    function showIconData(data){
      options = {};

      $('textarea[name|="iconDesc"]').val(data.options.desc);
      $('select[name|="iconActionType"]').val(data.options.actionType);
      $('input[name|="informType"][value|="'+data.options.informType+'"]').click();
      
      if(data.options.type == "markerIcon"){
        $('.iconProp').addClass('hidden');
        $('.markerIconProperty').removeClass('hidden');
        //layerId는 연결 가능한 pvrList를 보여주는데 사용됨.
        //linkedPvr은 아이콘에서 마지막으로 설정한 pvr을 저장하고 있음
        if(map._curLayer) options.layerId = map._curLayer.id;

        $('textarea[name|="informText"]').val(data.options.informText);
        $('input[name|="informTitle"]').val(data.options.informTitle);
        $('input[name|="linkedUrl"]').val(data.options.linkedUrl);
      }
      else if(data.options.type == "hotspotIcon"){
        $('.iconProp').addClass('hidden');
        $('.hotspotIconProperty').removeClass('hidden');
        if(curMainData) options.layerId = getRelationalLayerId(curMainData);
      }
      else if(data.options.type == "marker"){
        $('.iconProp').addClass('hidden');
        $('.markerProperty').removeClass('hidden');
        //marker가 속하는 layer의 pvrlist를 읽어오기 위해서 
        options.layerId = data.options.layerId;

        $('input[name|="objMaxZoom"]').val(data.options.maxLevel);
        $('input[name|="objMinZoom"]').val(data.options.minLevel);
        $('input[name|="objLat"]').val(Number(data.latlng.lat).toFixed(4));
        $('input[name|="objLng"]').val(Number(data.latlng.lng).toFixed(4));

        $('input[name|="linkedUrl"]').val(data.options.linkedUrl);
        $('textarea[name|="informText"]').val(data.options.informText);
        $('input[name|="informTitle"]').val(data.options.informTitle);
        $('input[name|="informImgFile"]').val('');
      }
      else if(data.options.type == "hotspot"){
        $('.iconProp').addClass('hidden');
        $('.hotspotProperty').removeClass('hidden');
        //pvr이 속하는 layer의 pvrlist를 읽어오기 위해서 
        options.layerId = getRelationalLayerId(curMainData);

        $('input[name|="ath"]').val(Number(data.ath).toFixed(4));
        $('input[name|="atv"]').val(Number(data.atv).toFixed(4));
      }
      else if(data.options.type == "projectMarker"){
        $('.iconProp').addClass('hidden');
        $('.projectMarkerProperty').removeClass('hidden');

        $('input[name|="objMaxZoom"]').val(data.options.maxLevel);
        $('input[name|="objMinZoom"]').val(data.options.minLevel);
        $('input[name|="objLat"]').val(Number(data.latlng.lat).toFixed(4));
        $('input[name|="objLng"]').val(Number(data.latlng.lng).toFixed(4));
      }

      options.linkedPvr = data.options.linkedPvr;
      options.type = data.options.type;
      drawInputAreaByActionType(data.options.actionType, options);

      if(data.options.type == "markerIcon"){
        $('input[name|="informImgFile"]').addClass('hidden');
      }
      if(data.options.type == "hotspotIcon" || data.options.type == "hotspot"){
        $('.informProp').addClass('hidden');
      }
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

    function getLatLngFromAddress(address){
      var latlng;

      $.ajax({
        async: false,
        type: 'get',
        url: 'getData.php',
        data: {
          req: 'getLatLngFromAddress',
          data: {
            address: address
          }
        },
        dataType: 'json',
        success: function (newLatLng){
          latlng = newLatLng;
        }
      });
      return latlng;
    }

    var dropData = null;
    function drop(ev){
      var iconId = ev.dataTransfer.getData("text");
      dropData = Number(iconId);
      ev.preventDefault();
    }
    function drag(ev) {
      ev.dataTransfer.setData("text", ev.target.id.replace(/\D/g,''));  
    }
    function allowDrop(ev) { 
      ev.preventDefault();  
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

              //layer must be loaded before polyline
              loadData('layer', data.layerId);

              //add polyline to map object
              newPolyline = map.addPolyline(data.id, data.layerId, data.options);
              //add timeline of the polyline add to map
              for(j=0; j<data.options.timelineList.length; j++) {
                timeline = data.options.timelineList[j];
                newPolyline.addTimeline(timeline.perAtStart, timeline.perAtEnd, timeline.latlng);
              }
              //in editor polyline is inactive 
              newPolyline.offToLine('click');
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