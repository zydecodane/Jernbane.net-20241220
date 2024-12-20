/*
--------------------------------------------------------
jernbane.net - vis en liste med forslag som bruker kan velge blant

Based on suggest.js made by onozaty (http://www.enjoyxstudy.com)
Released under an MIT-style license.
--------------------------------------------------------
*/

if (!SuggestList) {
  var SuggestList = {};
}
/*-- KeyCodes -----------------------------------------*/
SuggestList.Key = {
  TAB:     9,
  RETURN: 13,
  ESC:    27,
  UP:     38,
  DOWN:   40
};

/*-- Utils --------------------------------------------*/
SuggestList.copyProperties = function(dest, src) {
  for (var property in src) {
    dest[property] = src[property];
  }
  return dest;
};

/*-- SuggestList.Local ------------------------------------*/
SuggestList.Local = function() {
  this.initialize.apply(this, arguments);
};
SuggestList.Local.prototype = {
  initialize: function(input, suggestArea, candidateList) {

    this.input = this._getElement(input);
    this.suggestArea = this._getElement(suggestArea);
    this.candidateList = candidateList;
    this.oldText = this.getInputText();

    if (arguments[3]) this.setOptions(arguments[3]);

    // reg event
    //this._addEvent(this.input, 'focus', this._bind(this.checkLoop));
    this._addEvent(this.input, 'blur', this._bind(this.inputBlur));
    this._addEvent(this.suggestArea, 'blur', this._bind(this.inputBlur));

    this._addEvent(this.input, 'keydown', this._bindEvent(this.keyEvent));

    // init
    this.clearSuggestArea();
    this.createSuggestArea(this.candidateList);
    this.selection = -1;
  },
  remove: function() {
    this._removeEvent(this.input, 'blur', this._bind(this.inputBlur));
    this._removeEvent(this.suggestArea, 'blur', this._bind(this.inputBlur));

    this._removeEvent(this.input, 'keydown', this._bindEvent(this.keyEvent));
    this.clearSuggestArea();
         
  },

  // options
  interval: 500,
  dispMax: 20,
  listTagName: 'div',
  prefix: false,
  ignoreCase: true,
  highlight: false,
  dispAllKey: true,
  classMouseOver: 'over',
  classSelect: 'select',
  //hookBeforeSearch: function(){},
  callbackSetVal: function(value){},
  
  selection: -1,    // set to index of selected element, <0 means no selection made

  setOptions: function(options) {
    SuggestList.copyProperties(this, options);
  },

  inputBlur: function() {

    setTimeout(this._bind(function(){

      if (document.activeElement == this.suggestArea
          || document.activeElement == this.input) {
        // keep suggestion
        return;
      }

      this.changeUnactive();
      this.oldText = this.getInputText();

      if (this.timerId) clearTimeout(this.timerId);
      this.timerId = null;

      setTimeout(this._bind(this.clearSuggestArea), 500);
    }, 500));
  },

clearSuggestArea: function() {
    this.suggestArea.innerHTML = '';
    this.suggestArea.style.display = 'none';
    this.suggestList = null;
    //this.suggestIndexList = null;
    this.activePosition = null;
  },

  createSuggestArea: function(resultList) {

    this.suggestList = [];
    this.inputValueBackup = this.input.value;

    for (var i = 0, length = resultList.length; i < length && i<this.dispMax; i++) {
      var element = document.createElement(this.listTagName);
      element.innerHTML = resultList[i];
      this.suggestArea.appendChild(element);

      this._addEvent(element, 'click', this._bindEvent(this.listClick, i));
      this._addEvent(element, 'mouseover', this._bindEvent(this.listMouseOver, i));
      this._addEvent(element, 'mouseout', this._bindEvent(this.listMouseOut, i));

      this.suggestList.push(element);
    }

    this.suggestArea.style.display = '';
    this.suggestArea.scrollTop = 0;
  },

  getInputText: function() {
    return this.input.value;
  },

  setInputText: function(text) {
    this.input.value = text;
  },

  // key event
  keyEvent: function(event) {
  
    if (this.dispAllKey && event.ctrlKey 
        //&& this.getInputText() == ''
        //&& !this.suggestList
        && event.keyCode == SuggestList.Key.DOWN) {
      // dispAll
      this._stopEvent(event);
      this.keyEventDispAll();
    } else if (event.keyCode == SuggestList.Key.UP ||
               event.keyCode == SuggestList.Key.DOWN) {
      // key move
      if (this.suggestList && this.suggestList.length != 0) {
        this._stopEvent(event);
        this.keyEventMove(event.keyCode);
      }
    } else if (event.keyCode == SuggestList.Key.RETURN) {
      // fix
      if (this.suggestList && this.suggestList.length != 0) {
        this._stopEvent(event);
        this.keyEventReturn();
      }
    } else if (event.keyCode == SuggestList.Key.ESC) {
      // cancel
      if (this.suggestList && this.suggestList.length != 0) {
        this._stopEvent(event);
        this.keyEventEsc();
      }
    } else {
      this.keyEventOther(event);
    }
  },

  keyEventDispAll: function() {

    // init
    this.clearSuggestArea();

    this.oldText = this.getInputText();

/*
    this.suggestIndexList = [];
    for (var i = 0, length = this.candidateList.length; i < length; i++) {
      this.suggestIndexList.push(i);
    }
*/
    this.createSuggestArea(this.candidateList);
  },

  keyEventMove: function(keyCode) {

    this.changeUnactive();

    if (keyCode == SuggestList.Key.UP) {
      // up
      if (this.activePosition == null) {
        this.activePosition = this.suggestList.length -1;
      }else{
        this.activePosition--;
        if (this.activePosition < 0) {
          this.activePosition = null;
          this.input.value = this.inputValueBackup;
          this.suggestArea.scrollTop = 0;
          return;
        }
      }
    }else{
      // down
      if (this.activePosition == null) {
        this.activePosition = 0;
      }else{
        this.activePosition++;
      }

      if (this.activePosition >= this.suggestList.length) {
        this.activePosition = null;
        this.input.value = this.inputValueBackup;
        this.suggestArea.scrollTop = 0;
        return;
      }
    }

    this.changeActive(this.activePosition);
  },

  keyEventReturn: function() {

    if(this.activePosition==null) {
        this.callbackSetVal("");
    } else {
        this.callbackSetVal(this.candidateList[this.activePosition]);
    }
    this.clearSuggestArea();
    this.moveEnd();
  },

  keyEventEsc: function() {

    this.clearSuggestArea();
    this.input.value = this.inputValueBackup;
    this.oldText = this.getInputText();
    this.callbackSetVal("");

    if (window.opera) setTimeout(this._bind(this.moveEnd), 5);
  },

  keyEventOther: function(event) {},

  changeActive: function(index) {
      
    this.setStyleActive(this.suggestList[index]);

    this.setInputText(this.candidateList[index]);

    this.selection = index;

    this.oldText = this.getInputText();
    this.input.focus();
  },

  changeUnactive: function() {

    if (this.suggestList != null 
        && this.suggestList.length > 0
        && this.activePosition != null) {
      this.setStyleUnactive(this.suggestList[this.activePosition]);
    }
  },

  listClick: function(event, index) {

    this.changeUnactive();
    this.activePosition = index;
    this.changeActive(index);
    this.callbackSetVal(this.candidateList[index]);

    this.clearSuggestArea();
    this.moveEnd();
  },

  listMouseOver: function(event, index) {
    this.setStyleMouseOver(this._getEventElement(event));
  },

  listMouseOut: function(event, index) {

    if (!this.suggestList) return;

    var element = this._getEventElement(event);

    if (index == this.activePosition) {
      this.setStyleActive(element);
    }else{
      this.setStyleUnactive(element);
    }
  },

  setStyleActive: function(element) {
    element.className = this.classSelect;

    // auto scroll
    var offset = element.offsetTop;
    var offsetWithHeight = offset + element.clientHeight;

    if (this.suggestArea.scrollTop > offset) {
      this.suggestArea.scrollTop = offset
    } else if (this.suggestArea.scrollTop + this.suggestArea.clientHeight < offsetWithHeight) {
      this.suggestArea.scrollTop = offsetWithHeight - this.suggestArea.clientHeight;
    }
  },

  setStyleUnactive: function(element) {
    element.className = '';
  },

  setStyleMouseOver: function(element) {
    element.className = this.classMouseOver;
  },

  moveEnd: function() {

    if (this.input.createTextRange) {
      this.input.focus(); // Opera
      var range = this.input.createTextRange();
      range.move('character', this.input.value.length);
      range.select();
    } else if (this.input.setSelectionRange) {
      this.input.setSelectionRange(this.input.value.length, this.input.value.length);
    }
  },

  // Utils
  _getElement: function(element) {
    return (typeof element == 'string') ? document.getElementById(element) : element;
  },
  _addEvent: (window.addEventListener ?
    function(element, type, func) {
      element.addEventListener(type, func, false);
    } :
    function(element, type, func) {
      element.attachEvent('on' + type, func);
    }),
  _removeEvent: (window.removeEventListener ?
    function(element, type, func) {
      element.removeEventListener(type, func);
    } :
    function(element, type, func) {
      element.detachEvent('on' + type, func);
    }), 
  _stopEvent: function(event) {
    if (event.preventDefault) {
      event.preventDefault();
      event.stopPropagation();
    } else {
      event.returnValue = false;
      event.cancelBubble = true;
    }
  },
  _getEventElement: function(event) {
    return event.target || event.srcElement;
  },
  _bind: function(func) {
    var self = this;
    var args = Array.prototype.slice.call(arguments, 1);
    return function(){ func.apply(self, args); };
  },
  _bindEvent: function(func) {
    var self = this;
    var args = Array.prototype.slice.call(arguments, 1);
    return function(event){ event = event || window.event; func.apply(self, [event].concat(args)); };
  },
  _escapeHTML: function(value) {
    return value.replace(/\&/g, '&amp;').replace( /</g, '&lt;').replace(/>/g, '&gt;')
             .replace(/\"/g, '&quot;').replace(/\'/g, '&#39;');
  }
};

/*-- SuggestList.LocalMulti ---------------------------------*/
SuggestList.LocalMulti = function() {
  this.initialize.apply(this, arguments);
};
SuggestList.copyProperties(SuggestList.LocalMulti.prototype, SuggestList.Local.prototype);

SuggestList.LocalMulti.prototype.delim = ' '; // delimiter

SuggestList.LocalMulti.prototype.keyEventReturn = function() {

  this.clearSuggestArea();
  this.input.value += this.delim;
  this.moveEnd();
};

SuggestList.LocalMulti.prototype.keyEventOther = function(event) {

  if (event.keyCode == SuggestList.Key.TAB) {
    // fix
    if (this.suggestList && this.suggestList.length != 0) {
      this._stopEvent(event);

      if (!this.activePosition) {
        this.activePosition = 0;
        this.changeActive(this.activePosition);
      }

      this.clearSuggestArea();
      this.input.value += this.delim;
      if (window.opera) {
        setTimeout(this._bind(this.moveEnd), 5);
      } else {
        this.moveEnd();
      }
    }
  }
};

SuggestList.LocalMulti.prototype.listClick = function(event, index) {

  this.changeUnactive();
  this.activePosition = index;
  this.changeActive(index);

  this.input.value += this.delim;

  this.clearSuggestArea();
  this.moveEnd();
};

SuggestList.LocalMulti.prototype.getInputText = function() {

  var pos = this.getLastTokenPos();

  if (pos == -1) {
    return this.input.value;
  } else {
    return this.input.value.substr(pos + 1);
  }
};

SuggestList.LocalMulti.prototype.setInputText = function(text) {

  var pos = this.getLastTokenPos();

  if (pos == -1) {
    this.input.value = text;
  } else {
    this.input.value = this.input.value.substr(0 , pos + 1) + text;
  }
};

SuggestList.LocalMulti.prototype.getLastTokenPos = function() {
  return this.input.value.lastIndexOf(this.delim);
};

