(function($){
 	$.fn.JAMTimepicker = function (options) {
		var defaults = { disable: 0, title: "JAM TIMEPICKER" };
		var settings = $.extend(defaults, options);
		
		// ikone		
		var titleIcon = '<svg class="JAM-icon-title" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 8 8"><path d="M4 0c-2.2 0-4 1.8-4 4s1.8 4 4 4 4-1.8 4-4-1.8-4-4-4zm0 1c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm-.5 1v2.22l.16.13.5.5.34.38.72-.72-.38-.34-.34-.34v-1.81h-1z" /></svg>';
		var closeIcon = '<svg class="JAM-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 8 8"><path d="M4 0c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm-1.5 1.78l1.5 1.5 1.5-1.5.72.72-1.5 1.5 1.5 1.5-.72.72-1.5-1.5-1.5 1.5-.72-.72 1.5-1.5-1.5-1.5.72-.72z" /></svg>';
		var clearIcon = '<svg class="JAM-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 8 8"><path d="M2 0l-2 3 2 3h6v-6h-6zm1.5.78l1.5 1.5 1.5-1.5.72.72-1.5 1.5 1.5 1.5-.72.72-1.5-1.5-1.5 1.5-.72-.72 1.5-1.5-1.5-1.5.72-.72z" transform="translate(0 1)" /></svg>';
		
 		return this.each(function () {
			var hourList, minuteList, h, m;
			var minutesSet = hoursSet = 0;
			var overlay = document.createElement("DIV");
			var timepicker = this;
			
			// za obnovit disable
			var clone = timepicker.cloneNode();
			while (timepicker.firstChild) { clone.appendChild(timepicker.lastChild); }
			timepicker.parentNode.replaceChild(clone, timepicker);
			timepicker = clone;
			timepicker.addEventListener("click", function () { pickerFuncs.openPicker(timepicker,settings.disable); });
			
			var pickerFuncs = {
				updateTime: function (horm, div) {
					temp = div.id;
					if (horm == 0) {
						for (var i = settings.disable; i < hourList.childNodes.length; i++) { hourList.childNodes[i].className = "field"; }
						h = ("0" + temp).slice(-2); hoursSet = 1;
				 	}
					else if (horm == 1) {
						for (var j = 0; j < minuteList.childNodes.length; j++) { minuteList.childNodes[j].className = "field"; }
						m = ("0" + temp).slice(-2); minutesSet = 1;
				 	}
					div.className += " selected";
					
					if ((hoursSet == 1) && (minutesSet == 1)) {
						timepicker.value = h + ":" + m;
						if(timepicker.value == '00:00') { alert("00:00 not allowed in this field!\nUse 23:55 or 00:05 instead!!!"); }
						hoursSet = minutesSet = 0;
						timepicker.onchange(); 
						
						pickerFuncs.closePicker();
					}
				},
				
				closePicker: function () {
					overlay.innerHTML = '';
					//overlay.className='';
					//overlay.remove();
					overlay.parentNode.removeChild(overlay);
				},
				
				clearPicker: function () {
					h = m = null;
					timepicker.value = "";
					pickerFuncs.closePicker();
				},
				
				openPicker: function (onePicker, disable) {
					var currentTime;
					if (timepicker.value != "") {
						currentTime = timepicker.value.split(":");
						h = currentTime[0];
						m = currentTime[1];
					}

					var picker = document.createElement("DIV");
					var titlebar = document.createElement("DIV");
					var title = document.createElement("DIV");
					
					var closeButton = document.createElement("DIV");
					var clearButton = document.createElement("DIV");
					var pickerBody = document.createElement("DIV");
					var hourPicker = document.createElement("DIV");
					var hourLabels = document.createElement("DIV");
					var separator = document.createElement("HR");
					var minutePicker = document.createElement("DIV");
					var minuteLabels = document.createElement("DIV");
	
					hourList = document.createElement("DIV");
					minuteList = document.createElement("DIV");
	
					overlay.className = "JAM-overlay";
					picker.className = "JAM-picker";
					titlebar.className = "JAM-titlebar";
					title.className = "JAM-title";
					closeButton.className = "JAM-closeButton";
					clearButton.className = "JAM-clearButton";
					pickerBody.className = "JAM-pickerBody";
					hourLabels.className = "JAM-hourLabels";
					hourList.className = "JAM-hourList";
					minuteLabels.className = "JAM-minuteLabels";
					minuteList.className = "JAM-minuteList";

					//closeButton.innerHTML = "X";
					//clearButton.innerHTML = "clear";
					//title.innerHTML = settings.title;
					closeButton.innerHTML = closeIcon;
					closeButton.addEventListener("click", pickerFuncs.closePicker);
					clearButton.innerHTML = clearIcon;
					clearButton.addEventListener("click", pickerFuncs.clearPicker);
					title.innerHTML = titleIcon;
					
					titlebar.appendChild(closeButton);
					titlebar.appendChild(clearButton);
					titlebar.appendChild(title);
	
					hourLabels.innerHTML = '<div class="period">AM</div><div class="period">PM</div>';
					minuteLabels.innerHTML = '';
					hourPicker.appendChild(hourLabels);
					minutePicker.appendChild(minuteLabels);

					var tempField; hourSelected = 0;
					for (var i = 0; i < 24; i++) {
						tempField = document.createElement("div");
						tempField.innerHTML = ("0"+i).slice(-2);
						tempField.id = i;
						if (i+1 <= disable) { tempField.className = "field disabled"; }
						else {
							if (i == h) { tempField.className = "field selected"; hourSelected = 1;}
							else { tempField.className = "field"; }
							tempField.addEventListener("click",function () { pickerFuncs.updateTime(0,this); });
						}
						hourList.appendChild(tempField);
					}
					for (var j = 0; j < 60; j = j + 5) {
						tempField = document.createElement("div");
						tempField.innerHTML = ("0"+j).slice(-2);
						tempField.id = j;
						if ((j == m)&&(hourSelected==1)) { tempField.className = "field selected"; }
						else { tempField.className = "field"; }
						tempField.addEventListener("click",function () { pickerFuncs.updateTime(1,this); });
						minuteList.appendChild(tempField);
					}
					hourPicker.appendChild(hourList);
					minutePicker.appendChild(minuteList);

					pickerBody.appendChild(hourPicker);
					pickerBody.appendChild(separator);
					pickerBody.appendChild(minutePicker);

					picker.appendChild(titlebar);
					picker.appendChild(pickerBody);	
					overlay.appendChild(picker);
					document.body.appendChild(overlay);
				}
    		} 		
 		}); // end this.each

    }; // end plugin
})(jQuery);

