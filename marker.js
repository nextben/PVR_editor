/*
    linkUrl 자동 갱신
    popupContents 자동 갱신 
    useSettingByContextMenu 자동 갱신
    useHyperLink 자동 갱신 
    usePopup 자동 갱신 

    draggable 비자동 
    icon 비자동
    opacity 비자동
*/
/*
    changeOption()
*/
function Marker(id, latlng, userOption){
    var key, options, that = this;

    options = {
        useSettingByContextMenu: false,
        draggable: true,
        usePopup: false, 
        useHyperLink: false,
    };
    for(key in userOption){
        options[key] = userOption[key];
    }
    L.Marker.call(this, latlng, options);
    this.id = id;

    this.on('contextmenu', function() {
        if(!this.options.useSettingByContextMenu) return;

		var newPopupDiv = $('<div class="popup"></div>');
        newPopupDiv.html(
        "<div class='popupcontainer'>"+
        	"<div class='popupcategory'>라벨입력</div><div class='popupinput'><input type='text' value='"+this._label+"'></div>"+
        "</div>"+
        "<div class='popupcontainer'>"+
        	"<div class='popupcategory'>url입력</div><div class='popupinput'><input type='text' value='"+this.url+"'></div>"+
        "</div>"+
        "<div class='popupcontainer'>"+
        	"<div class='popupcategory'>popup입력</div><div class='popupinput'><input type='text' value='"+this.popup+"'></div>"+
        "</div>"+
        "<div class='popupcontainer'>"+
        	"<input type='button' value='수정'>"+
        	"<input type='button' value='삭제'>"+
        "</div>");

        $(newPopupDiv).find('input')[3].onclick = function(){
        	that._label = $(newPopupDiv).find('input')[0].value;
            that.unbindLabel();
            if(that._label){
                that.bindLabel(that._label, {noHide:true});
                that.hide();
                that.show(that.floor.contents.map);
            }
        	var urlVal = $(newPopupDiv).find('input')[1].value;
            if($.trim(urlVal)){
            	urlVal = urlVal.replace('http://','');
            	urlVal = 'http://'.concat(urlVal);
            }
            that.url = urlVal;
            that.popup = $(newPopupDiv).find('input')[2].value;


            that.contextchange();

            that.closePopup();
        }; 

        $(newPopupDiv).find('input')[4].onclick = function(){
            that.delete();
        };

        var newPopup = L.popup().setContent(newPopupDiv[0]);
        //this.unbindPopup();
        this.bindPopup(newPopup).openPopup();
	});
	this.on('click', function() {
        if(this.options.usePopup){
            if(this.options.popupContents){
                this.unbindPopup();
                this.bindPopup('<p>'+this.options.popupContents+'</p>').openPopup();
            }
            else
                this.unbindPopup();
        }
        if(this.options.useHyperLink){
            if(this.options.linkUrl){
                window.open(this.options.linkUrl, '', 'width=700,height=500');
            } 
        }             
	});
}

Marker.prototype = new L.Marker();
Marker.prototype.constructor = Marker;

Marker.prototype.changeIcon = function(icon){
    this.options.icon = icon;
    this.refresh();
}

Marker.prototype.hide = function(){
    if(this._map){
        this._map.removeLayer(this);    
    }
}

Marker.prototype.setOption = function(key, value){
    var oldValue;
    
    oldValue = this.options[key];
    this.options[key] = value;

    this.fire('changeOption', {key:key, oldValue:oldValue, value:value});
    this.refresh();
}

Marker.prototype.refresh = function(){
    var curMap;
    if(curMap = this._map){
        curMap.removeLayer(this);
        curMap.addLayer(this);
    }
}