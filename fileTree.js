var FileTree = (function(){
	//data는 content, subdir, type으로 나누어진다.
	//option
	//extendButton:
	// 		iconOnFold: html
	//		icon: html
	//		iconOnHover: html
	//		iconOnFoldNHover: html
	//		blank: html
	//type: [array or object]
	//		name: 
	//		icon: html
	//		iconOnFold: htmlf
	//		parentable: bool
	//		contain: [type/type/type]
	//extra
	//기본 제공 타입 folder/file

	function FileTree(containerId, data, option){
		var defExtendButtonIcon = "▼", 
			defBlankExtendButtonIcon = "  ",
			defFileIcon = "□",
			dropArea = 0.25,

			nextElementId = 0,
			that = this,
			tbodyId = 'tbody',
			i, tempData;
			
		tempData = data;
		data = {
			id 		:"root",
			type 	:"root",
			subdir 	:tempData
		};
		this._type = option.type;
		this._data = data;
		this.event = {};

		if(!option.extendButton.icon) option.extendButton.icon = defExtendButtonIcon;
		if(!option.extendButton.iconOnFold) option.extendButton.iconOnFold = option.extendButton.icon;
		if(!option.extendButton.iconOnHover) option.extendButton.iconOnHover = option.extendButton.icon;
		if(!option.extendButton.iconOnFoldNHover) option.extendButton.iconOnFoldNHover = option.extendButton.iconOnFold;
		if(!option.extendButton.blank) option.extendButton.blank = defBlankExtendButtonIcon;

		for(i=0; i<option.type.length; i++){
			if(!option.type[i].icon) option.type[i].icon = defFileIcon;
			if(!option.type[i].iconOnFold) option.type[i].iconOnUnfold = option.type[i].icon;
			if(option.type[i].parentable === undefined) option.type[i].parentable = false;
		} 				

		_drawFileTree();

		//this.drawFileTree(data);
		function _drawFileTree(){
			var i, foldList, nodeList;

			
			if($('#'+containerId).html()){
				nodeList = $('#'+containerId+' tr');
				foldList = [];
				for(i=0; i<nodeList.length; i++){
					if(!nodeList[i].hasAttribute('unfold'))
						foldList[i] = nodeList[i].id; 					 	
				}
			}

			$('#'+containerId).html(
				'<table id="tree">'+
					'<tbody id="tbody">'
			);
			for(i=0; i<data.subdir.length; i++){
				_createTree(data.subdir[i], 1);
			}					
			$('#'+containerId).append(
					'</tbody>'+
				'</table>'
			);
			_setMargin();
			_setExtendButton();
			_setClick();
			_setHover();
			_setDragAndDrop();

			if(foldList){
				for(i=0; i<foldList.length; i++){
					$('#'+foldList[i]+' .extendButton').click();
				}
			}
		}
		function _createTree(node, depth){
			var i, parentable, typeInfo,
				extendButtonIcon, fileIcon, parentable, extra,
				idx = _getIdxOfType(node.type);
				type = that._type;

			extendButtonIcon = option.extendButton.icon;


			fileIcon = type[idx].icon;
			parentable = type[idx].parentable? 'parentable': '';
			extra = option.extra? option.extra: '';
			id = node.id;

			$('#'+tbodyId).append(
				'<tr depth="'+depth+'" id="fileEle'+id+'" unfold type="'+node.type+'">'+
					'<td>'+
						'<div class="treeEle '+parentable+'">'+
							'<div class="extendButton">'+extendButtonIcon+'</div>'+
							'<div class="icon">'+fileIcon+'</div>'+
							'<div class="content">'+node.data+'</div>'+
							'<div class="extra">'+extra+'</div>'+
						'</div>'+
					'</td>'+
				'</tr>'
			);
			node.dom = $('#fileEle'+id)[0];

			if(node.subdir){
				for(i=0; i<node.subdir.length; i++){
					_createTree(node.subdir[i], depth+1, option);
				}					
			}
		}
		function _getIdxOfType(name){
			var i;
			for(i=0; i<that._type.length; i++){
				if(that._type[i].name == name)
					return i;
			}
			return -1;
		}
		//왼쪽 여백을 설정하는 부분
		function _setMargin(){
			var i, depth;				
			for(i = 0; i < $('#'+containerId+'>table>tbody>tr').length; i++){
				depth = Number( $('#'+containerId+'>table>tbody>tr:nth-child('+(i+1)+')' ).attr('depth') );
				$('#'+containerId+'>table>tbody>tr:nth-child('+(i+1)+')').find('.treeEle').css('margin-left', (depth-1)*15+'px');  
			}
		}
		//펼침 버튼을 설정하는 부분
		function _setExtendButton(){
			/*$('#'+containerId+' .extendButton').mousedown(function (){
				$(this).html(option.extendButton.iconOnClick);
			});*/

			$('#'+containerId+' .extendButton').hover(function (){
				if($(this).closest('tr').attr('unfold')===undefined)
					$(this).html(option.extendButton.iconOnFoldNHover);
				else
					$(this).html(option.extendButton.iconOnHover);
			}, function (){
				if($(this).closest('tr').attr('unfold')===undefined)
					$(this).html(option.extendButton.iconOnFold);
				else
					$(this).html(option.extendButton.icon);
			});

			$('#'+containerId+' .extendButton').click(function (ev){
				var td, depth, lethide, ele, typeInfo;


				ev.originalEvent? ev.originalEvent.stopPropagation(): ev.stopPropagation();

				if(!$(this).parent().hasClass('parentable')) return;

				tr = $(this).parent().parent().parent();
				depth = Number( tr.attr('depth') );

				typeInfo = option.type[_getIdxOfType( tr.attr('type') )];
				
				if(tr.attr('unfold')!==undefined){
					tr.removeAttr('unfold');
					lethide = true;
					if($(this).is(":hover")){
						$(this).html(option.extendButton.iconOnFoldNHover);
					}
					else
						$(this).html(option.extendButton.iconOnFold);

					$(this).siblings('.icon').html(typeInfo.iconOnFold);
					//하위 항목 모두 숨기기
				}
				else {
					tr.attr('unfold', '');
					lethide = false;
					if($(this).is(":hover"))
						$(this).html(option.extendButton.iconOnHover);
					else
						$(this).html(option.extendButton.icon);

					$(this).siblings('.icon').html(typeInfo.icon);
						//직속 하위 항목 보이고, 나머지는 재량껏 처리 
				}
				ele = tr.next();

				while(ele[0]){
					if(Number(ele.attr('depth')) <= depth) break;
					
					if(lethide)
						ele.css('display','none');						
					else{
						if(ele.attr('depth') == depth+1){
							ele.css('display', '');
							ele = _checkToShowChild(ele);
						}
					}
					ele = ele.next();
				}
			});
		}
		function _checkToShowChild(ele){
			var depth, unfold; 

			depth = Number( ele.attr('depth') );
			if(ele.attr('unfold')!==undefined){
				//하위 항목 모두 보이기 
				unfold = true;				
			}
			else {
				//하위항목 숨기기
				unfold = false;				
			}
			//console.log(ele.attr('id'));
			ele = ele.next();
			while(ele[0]){
				//console.log("check : ",ele.attr('depth'),'<=',depth, ele.attr('id'));
				if(Number(ele.attr('depth')) <= depth) break;
				if(!unfold)
					ele.css('display','none');						
				else{
					if(ele.attr('depth') == depth+1){
						ele.css('display', '');
						//console.log('------------------------');
						ele = _checkToShowChild(ele);
					}
				}				
				ele = ele.next();
			}
			return ele.prev();
		}
		function _setClick(){
			var i, ele;

			for(i = 0; i < $('#'+containerId+'>table>tbody>tr').length; i++){
				$('#'+containerId+'>table>tbody>tr:nth-child('+(i+1)+')').click(function(ev){
					var i, ele, node;

					//if( $(this).find('td').hasClass('clicked') ) return $(this).find('td').removeClass('clicked'); 

					for(i = 0; i < $('#'+containerId+'>table>tbody>tr>td').length; i++){
						ele = $('#'+containerId+'>table>tbody>tr>td:nth-child('+(i+1)+')');
						ele.removeClass('clicked');
					}
					$(this).find('td').addClass('clicked');

					node = _findNodeById(that._data, $(this).attr('id').replace("fileEle", ""));
					that.fire('clickNode', node);
				})
			}
		}
		function _setHover(){
			var tdList, i;
			tdList = $('#'+containerId+'>table>tbody>tr>td');

			for(i=0; i<tdList.length; i++){
				$(tdList[i]).hover(function(){
					$(this).addClass('hovered');							
				}, function(){
					$(this).removeClass('hovered');
				})
			}
		}
		function _setDragAndDrop(){
			var i, depth, tr, trList;
			trList = $('#'+containerId+'>table>tbody>tr');
			
			for(i = 0; i < trList.length; i++){
				tr = $(trList[i]);
				//console.log(tr);

				tr.on('dragstart', function(ev){
					ev.originalEvent.dataTransfer.setData('ele', this.id);
				});

				tr.on('dragover', function(ev){
					var mouseY = ev.originalEvent.pageY,
						offsetY = $(this).offset().top,
						height = $(this).height();

					ev.originalEvent.preventDefault();
					$(this).find('td').addClass('hovered');
					if(offsetY <= mouseY && mouseY <=offsetY+height*dropArea){
						$(this).find('td').removeClass("dropBottom centerhovered dropTop");
						$(this).find('td').addClass('dropTop');							
					}
					else if(offsetY+height*dropArea <= mouseY && mouseY < offsetY+height*(1-dropArea)){
						$(this).find('td').removeClass("dropBottom centerhovered dropTop");
						$(this).find('td').addClass('centerhovered');
					}
					else if(offsetY+height*(1-dropArea) <= mouseY && mouseY < offsetY+height){
						$(this).find('td').removeClass("dropBottom centerhovered dropTop");
						$(this).find('td').addClass('dropBottom');
					}
				});

				tr.on('dragleave', function(ev){
					_clearFileCss(this);
				});

				tr.on('drop', function(ev){
					var eleInDragging = $('#'+ev.originalEvent.dataTransfer.getData('ele')),
						ele, eleList=[], i, depth, baseDepth, offsetDepth,
						mouseY = ev.originalEvent.pageY,
						offsetY = $(this).offset().top,
						height = $(this).height(),
						td = $(this).find('td'), parent, newParent, node;

					ev.originalEvent.preventDefault();
					//eleInDragging.removeClass('clicked')

					_clearFileCss(this);
					eleInDragging.find('td').addClass('hovered');
					//console.log(td);
					//_clearFileCss(eleInDragging);

					if(_isAncestor($(this), eleInDragging)) return;

					//옮길 항목을 결정함
					eleList.push(eleInDragging.attr('id'));
					ele = eleInDragging.next();
					while(ele[0]){
						if(ele.attr('depth') <= eleInDragging.attr('depth')) break;

						eleList.push(ele.attr('id'));
						ele = ele.next();
					}
					
					//옮길 위치를 결정함(아래칸이나 하위 항목으로 이동할때)
					//[기본적으로 가장 끝에 위치한 자식으로 이동]
					ele = $(this);
					while(ele.next()[0]){
						if(ele.next().attr('depth') <= $(this).attr('depth')) break;
						ele = ele.next();
					}

					if(offsetY <= mouseY && mouseY <= offsetY+height*dropArea){							
						if(!_isPossibleToBeSiblings($(this), eleInDragging)) return;

						//이전 이동시 기준점은 drop target이 된다.
						ele = $(this);
						baseDepth = Number($(this).attr('depth'));
						depth = Number($('#'+eleList[0]).attr('depth'));
						for(i=0; i<eleList.length; i++){
							if(i==0){
								$('#'+eleList[i]).insertBefore( ele );
								offsetDepth = Number($('#'+eleList[i]).attr('depth')) - depth;
								$('#'+eleList[i]).attr('depth', baseDepth+offsetDepth); 
								ele = ele.prev();
							}
							else{
								$('#'+eleList[i]).insertAfter( ele );
								offsetDepth = Number($('#'+eleList[i]).attr('depth')) - depth;
								$('#'+eleList[i]).attr('depth', baseDepth+offsetDepth);
								ele = ele.next();
							} 									
						}
						_addPrevSiblingNode(this, eleInDragging);
						
						node = _findNodeById(that._data, $(this).attr('id').replace("fileEle", ""));
						that.fire('moveNode', node);
					}							
					else if(offsetY+height*dropArea <= mouseY && mouseY < offsetY+height*(1-dropArea)){
						if(!_isPossibleToBeChild($(this), eleInDragging)) return;

						baseDepth = Number($(this).attr('depth'))+1;
						depth = Number($('#'+eleList[0]).attr('depth'));
						for(i=0; i<eleList.length; i++){
							$('#'+eleList[i]).insertAfter( ele );
							offsetDepth = Number($('#'+eleList[i]).attr('depth')) - depth;
							$('#'+eleList[i]).attr('depth', baseDepth+offsetDepth);
							if($(this).attr('unfold')===undefined){
								$('#'+eleList[i]).css('display','none');
							}
							ele = ele.next();
						}
						_addChildNode(this, eleInDragging);

						node = _findNodeById(that._data, $(this).attr('id').replace("fileEle", ""));
						that.fire('moveNode', node);
					}
					else if(offsetY+height*(1-dropArea) <= mouseY && mouseY < offsetY+height){
						if(!_isPossibleToBeSiblings($(this), eleInDragging)) return;

						baseDepth = Number($(this).attr('depth'));
						depth = Number($('#'+eleList[0]).attr('depth'));
						for(i=0; i<eleList.length; i++){
							$('#'+eleList[i]).insertAfter( ele );
							offsetDepth = Number($('#'+eleList[i]).attr('depth')) - depth;
							$('#'+eleList[i]).attr('depth', baseDepth+offsetDepth); 
							ele = ele.next();
						}
						_addNextSiblingNode(this, eleInDragging);

						node = _findNodeById(that._data, $(this).attr('id').replace("fileEle", ""));
						that.fire('moveNode', node);
					}

					_setMargin();					
					//eleInDragging.remove();
				}); 
			}
		}
		function _clearFileCss(ele){
			$(ele).find('td').removeClass('dropTop')
			$(ele).find('td').removeClass("hovered");
			$(ele).find('td').removeClass("dropBottom");
			$(ele).find('td').removeClass("centerhovered");
		}
		function _isAncestor(ele, candi){
			var curDepth, depth;
			depth = candi.attr('depth');

			while(ele[0]){
				curDepth = $(ele).attr('depth');

				if($(ele)[0] == $(candi)[0])
					return true;

				if(curDepth <= depth) break; 
				ele = ele.prev();
			}
			return false;
		}
		function _isPossibleToBeSiblings(ele, candi){
			var parent, cur, depth, i, possibleChildTypeList, rootIdx;

			cur = ele;
			while(cur[0]){
				if(cur.attr('depth') < ele.attr('depth')) break;
				cur = cur.prev();
			}
			//항목이 root 밑에 직접 속할 때
			if(!cur[0]){
				//사용자가 root밑에 올 수 있는 항목을 제한한 경우.
				//다른 경우와 동일하게 검사를 진행한다.
				if( (rootIdx = _getIdxOfType('root')) != -1 ){
					possibleChildTypeList = that._type[rootIdx].possibleChildType;
				}
				//사용자가 root 밑에 올수 있는 항목을 제한하지 않은 경우
				//모두 해당 element의 형제가 될 수 있다.
				else{
					return true;	
				} 
			}
			//항목이 root 밑에 직접 속하지 않은 경우 부모 type 이 허가한
			//type인지 확인한다.  
			else {
				parent = cur;
				possibleChildTypeList = that._type[_getIdxOfType(parent.attr('type'))].possibleChildType;
				if( !possibleChildTypeList ) return false;
			} 		
			//확인 과정 
			for(i=0; i<possibleChildTypeList.length; i++){
				if(possibleChildTypeList[i] == candi.attr('type')) return true;
			}
			return false;
		}
		function _isPossibleToBeChild(ele, candi){
			var possibleChildTypeList;

			ele = $(ele);
			candi = $(candi);

			//항목이 root 밑에 직접 속할 때
			if(!ele[0]){
				//사용자가 root밑에 올 수 있는 항목을 제한한 경우.
				//다른 경우와 동일하게 검사를 진행한다.
				if( (rootIdx = _getIdxOfType('root')) != -1 ){
					possibleChildTypeList = that._type[rootIdx].possibleChildType;
				}
				//사용자가 root 밑에 올수 있는 항목을 제한하지 않은 경우
				//모두 해당 element의 형제가 될 수 있다.
				else{
					return true;	
				}
			}
			//항목이 root 밑에 직접 속하지 않은 경우 부모 type 이 허가한
			//type인지 확인한다.  
			else {
				possibleChildTypeList = that._type[_getIdxOfType(ele.attr('type'))].possibleChildType;
				if( !possibleChildTypeList ) return false;
			}	
			//확인 과정
			for(i=0; i<possibleChildTypeList.length; i++){
				if(possibleChildTypeList[i] == candi.attr('type')) return true;
			}
			return false;
		}
		//node(data 구조 상)의 밑에서 dom element가 dom과 같은 것을 찾는다.
		function _findNode(node, ele){
			var i, ret;

			if(node.dom == $(ele)[0]) return node;
			if(!node.subdir) return false;

			for(i=0; i<node.subdir.length; i++){
				if(ret = _findNode(node.subdir[i], ele))
					return ret;
			}
			return false;
		}
		//ele를 dom으로 가지는 node의 부모 node를 찾음.
		function _findParentNode(node, ele){
			var i, ret;

			if(!node.subdir) return false;

			for(i=0; i<node.subdir.length; i++){
				if(node.subdir[i].dom == $(ele)[0])
					return node;
				else
					if( ret = _findParentNode(node.subdir[i], ele) ) 
						return ret;
			}
			return false;
		}
		function _removeFromParentNode(ele){
			var parent, idx, i;

			parent = _findParentNode(data, ele);
			if(!parent) return;

			for(i=0; i<parent.subdir.length; i++){
				if(parent.subdir[i].dom == $(ele)[0])	break;
			}

			return parent.subdir.splice(i, 1)[0];
		}
		//ele(dom)의 밑에 다른 dom 밑에 있던 child(dom)를 추가한다.
		function _addChildNode(ele, child){
			var parent, newParent, node, i;

			newParent = _findNode(data, ele);
			parent = _findParentNode(data, child);

			node = _removeFromParentNode(child);

			if(!newParent.subdir) newParent.subdir = [];
			newParent.subdir.push(node);
		}
		function _addPrevSiblingNode(ele, sibling){
			var parent, newParent, node, i;

			parent = _findParentNode(data, sibling);
			newParent = _findParentNode(data, ele);

			for(i=0; i<newParent.subdir.length; i++){
				if(newParent.subdir[i].dom == $(ele)[0]) break;
			}
			node = _removeFromParentNode(sibling);
			newParent.subdir.splice(i, 0, node);
		}
		function _addNextSiblingNode(ele, sibling){
			var parent, newParent, node, i;

			parent = _findParentNode(data, sibling);
			newParent = _findParentNode(data, ele);

			for(i=0; i<newParent.subdir.length; i++){
				if(newParent.subdir[i].dom == $(ele)[0]) break;
			}
			node = _removeFromParentNode(sibling);
			newParent.subdir.splice(i+1, 0, node);
		}
		//node인 data 밑에서 id를 가진 node를 찾아 반환한다.
		function _findNodeById(data, id){
			var i, ret;

			if(data === undefined || id === undefined ) return false;
			if(data.id == id) return data;
			if(!data.subdir) return false;

			for(i=0; i<data.subdir.length; i++){
				if( ret = _findNodeById(data.subdir[i], id) ){
					return ret;			
				}
			}
			return false;
		}


		FileTree.prototype.drawFileTree = _drawFileTree;
		FileTree.prototype.curTreeToArray = function(){
			var dataArray = [];
			
			_gatherDataOfNode(data);
			return dataArray;

			function _gatherDataOfNode(node){
				var i;

				if(!node.subdir) return;
				for(i=0; i<node.subdir.length; i++){
					childNode = node.subdir[i];
					newCol = {
						data: childNode.data,
						type: childNode.type,
						id: childNode.id,
						order: i,
						parent: _findParentNode(data, childNode.dom).id
					}
					dataArray.push(newCol);
					_gatherDataOfNode(childNode);
				}
			}
		}
		FileTree.prototype.arrayToDom = function(dataArray){
			var i, j, tempArray=[], resultArray=[];

			for(i=0; i<dataArray.length; i++){
				tempArray[i] = dataArray[i];
			}

			for(i=0; i<tempArray.length; i++){
				if(!tempArray[i].parent && tempArray[i].parent!==0){
					resultArray[tempArray[i].order]	= tempArray[i];
					continue;		
				}

				for(j=0; j<tempArray.length; j++){
					if(tempArray[i].parent == tempArray[j].id){
						if(!tempArray[j].subdir) tempArray[j].subdir=[];
						tempArray[j].subdir[tempArray[i].order] = tempArray[i];
						break;
					}								
				}
			}
			return resultArray;
		}
		FileTree.prototype.addNewNode = function(parentId, newNodeId, data, type){
			var parentNode, newNode;

			if( !(parentNode = _findNodeById(this._data, parentId)) ) return false;
			newNode = {
				id 		: newNodeId, 
				data 	: data,
				dom 	: document.createElement('tr'),
				type 	: type,
				subdir 	: []
			};
			$(newNode.dom).attr('type', type);

			if(!_isPossibleToBeChild(parentNode.dom, newNode.dom)) return false;

			parentNode.subdir.push(newNode);
			_drawFileTree();
			this.fire('addNewNode', newNode);
			
			return newNode;
		}	
		FileTree.prototype.moveNodeTo = function(parentId, childId){
			var parentNode, childNode;

			if( !(parentNode = _findNodeById(this._data, parentId)) ) return false;
			if( !(childNode = _findNodeById(this._data, childId)) ) return false;
			if(!_isPossibleToBeChild(parentNode.dom, childNode.dom)) return false;

			_addChildNode(parentNode.dom, childNode.dom);
			_drawFileTree();
			this.fire('moveNode', childNode);
			return true;
		}
		FileTree.prototype.deleteNode = function(nodeId){
			var oldNode;

			if( !(oldNode = _findNodeById(this._data, nodeId)) ) return false;
			
			_removeFromParentNode(oldNode.dom);
			_drawFileTree();
			this.fire('deleteNode', oldNode);
			return true;
		}
		FileTree.prototype.changeNodeData = function(nodeId, newData){
			var node;

			if( !newData )	return false;
			if( !(node = _findNodeById(this._data, nodeId)) ) return false;
			
			node.data = newData;
			_drawFileTree();
			this.fire('changeNodeAttr', node);
			return true;
		}
		FileTree.prototype.changeNodeType = function(nodeId, newType){
			var node, possibleChildType, i;

			if( !newType )	return false;
			if( !(node = _findNodeById(this._data, nodeId)) ) return false;
			

			possibleChildType = this._type[_getIdxOfType(_findParentNode(this._data, node.dom).type)].possibleChildType
			for(i=0; i<possibleChildType.length; i++){
				if(possiblechildType[i] == newType){
					node.type = newType;
					_drawFileTree();
					this.fire('changeNodeAttr', node);
					return true;
				}
			}	
			return false;
		}
		/*지원 타입
			addNewNode(node)
			moveNode(node)
			deleteNode(node)
			changeNodeAttr(node)
			clickNode(node)
		*/
		FileTree.prototype.on = function(name, func, context){
		    if(!this.event[name]) this.event[name] = [];
		    this.event[name].push({action: func, context: context?context:this});
		}

		FileTree.prototype.off = function(name){
		    if(!this.event[name]) this.event[name] = [];
		    this.event[name].pop();
		}

		FileTree.prototype.fire = function(name, data){
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
	}
	return FileTree;
})();		