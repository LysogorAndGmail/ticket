//tgl.js versi 0.10 ahqof.com

//creat main function, with one parameter
function tgl(par) {

	function main(par){
		var inp = document.getElementById(par.input);

		//create array list day name and list month name
		var days = {};
		var months = {};
		var times = {};

		days.id = ["minggu","senin","selasa","rabu","kamis","jumat","sabtu"];
		months.id = ["januari","februari","maret","april","mei","juni","juli","agustus","september","oktober","november","desember"];
		times.id = ["jam","menit","detik"];
		days.en = ["sunday","monday","tuesday","wednesday","thursday","friday","saturday"];
		months.en = ["january","february","march","april","may","june","july","august","september","october","november","december"];
		times.en = ["hour","minute","second"];

		//set default region
		var listDay = days.en;
		var listMonth = months.en;
		var listTime = times.en;

		function addList(list,mainList,obj){
			if(list !== undefined){
				for(var a in list){
					obj[a] = [];
					for(var b in mainList){
						if(list[a][b] === undefined){
							obj[a][b] = mainList[b];
						} else {
							obj[a][b] = list[a][b];
						}
					}
				}
			}
		}

		//add dynamic list days from main parameter
		addList(par.day,listDay,days);

		//add dynamic months from main parameter
		addList(par.month,listMonth,months);

		//add dynamic times from main parameter
		addList(par.time,listTime,times);
		
		//choose region from main parameter
		if(par.region !== undefined){
			if(days[par.region] !== undefined){
				listDay = days[par.region];
			}
			if(months[par.region] !== undefined){
				listMonth = months[par.region];
			}
			if(times[par.region] !== undefined){
				listTime = times[par.region];
			}
		}

		//object for convert format to date
		var formatDate = {
			d : function (t){ return t.getDate();},
			dd : function (t){ t = t.getDate(); t < 10 ? t = '0'+t : t; return t;},
			ddd : function (t){ return listDay[t.getDay()].substr(0,3);},
			dddd : function (t){ return listDay[t.getDay()];},
			m : function (t){ return t.getMonth()+1;},
			mm : function (t){ t = t.getMonth()+1; t < 10 ? t = '0'+t : t; return t;},
			mmm : function (t){ return listMonth[t.getMonth()].substr(0,3);},
			mmmm : function (t){ return listMonth[t.getMonth()];},
			y : function (t){ t=t.getFullYear()+''; return t.substr(-2);},
			yy : function (t){ t=t.getFullYear()+''; return t.substr(-2);},
			yyy : function (t){ return t.getFullYear();},
			yyyy : function (t){ return t.getFullYear();},
			s : function (t){ return t.getSeconds();},
			ss : function (t){ t = t.getSeconds(); t < 10 ? t = '0'+t : t; return t;},
			n : function (t){ return t.getMinutes();},
			nn : function (t){ t = t.getMinutes(); t < 10 ? t = '0'+t : t; return t;},
			h : function (t){ return t.getHours();},
			hh : function (t){ t = t.getHours(); t < 10 ? t = '0'+t : t; return t;},
		};

		//object for convert date to format
		var dateFormat = {
			d : function (t,it){ t.da = Number(it); return t;},
			dd : function (t,it){ t.da = Number(it); return t;},
			m : function (t,it){ t.mo = it-1; return t;},
			mm : function (t,it){ t.mo = it-1; return t;},
			mmm : function (t,it){ 
					for(var a in listMonth){ 
						if(listMonth[a].toLowerCase().substr(0,3) == it ){ 
							t.mo = a; return t;
						}
					}
				},
			mmmm : function (t,it){ t.mo = listMonth.indexOf(it.toLowerCase()); return t;},
			y : function (t,it){ t.ye = '20' + it; return t;},
			yy : function (t,it){ t.ye = '20' + it; return t;},
			yyy : function (t,it){ t.ye = it; return t;},
			yyyy : function (t,it){ t.ye = it; return t;},
			s : function (t,it){ t.se = Number(it); return t;},
			ss : function (t,it){ t.se= Number(it); return t;},
			n : function (t,it){ t.mi = Number(it); return t;},
			nn : function (t,it){ t.mi = Number(it); return t;},
			h : function (t,it){ t.ho = Number(it); return t;},
			hh : function (t,it){ t.ho = Number(it); return t;},
		};

		//set default date format
		if(par.format === undefined || par.format === null || par.format === ""){
			par.format = 'd/m/yyyy';
		}

		//split format to converter
		var splitFormat = par.format.split('');
		var no = 0;
		var format = [];
		for (var e in splitFormat){
			if(formatDate[splitFormat[e]] === undefined){
				no++;
				format[no] = splitFormat[e];
				no++;
			} else {
				if(format[no] === undefined){
					format[no] = splitFormat[e];					
				} else {
					format[no] += splitFormat[e];					
				}
			}
		}

		//set short day name
		if(par.shortDay !== undefined && isNaN(par.shortDay) === false ){
			var shortDay = par.shortDay;
		}
    
		//choose css class
		var clasStyle = 'theme';
		if(par.clasStyle !== undefined && par.clasStyle !== null && par.clasStyle !== ""){
			clasStyle = par.clasStyle;		
		}

		//choose file css
		var fileCss = "/tgl_callendar/css/" + clasStyle + ".css";
		if(par.fileCss !== undefined && par.fileCss !== null && par.fileCss !== ""){
			fileCss = par.fileCss;
		}

		//check if css file has declare
		var foundCss = false;
		var allCss = document.getElementsByTagName('link');
		for (var f=0; f < allCss.length; f++) {
			if(allCss[f].getAttribute('href') == fileCss) {
				foundCss = true;
			}
		}	
		//insert css	
		if(foundCss === false && fileCss !== ""){
			var createCss = document.createElement('link');
			createCss.setAttribute("rel","stylesheet");
			createCss.setAttribute("type","text/css");
			createCss.setAttribute("href",fileCss);
			inp.parentNode.insertBefore(createCss, inp);
		}

		//function convert format to date
		function convertFormat(tt){
			var result = [];
			for ( var a in format){
				if(formatDate[format[a]] !== undefined){
					result[a] = formatDate[format[a]](tt);
				} else {
					result[a] = format[a];
				}
			}
			return result.join('');
		}

		//function convert date to format
		function convertDate(tt){
			tt = tt.trim().split('');
			var pi = [];
			var no = 0;
			var cc = '';
			for ( var t in tt){
				cc = tt[t].charCodeAt(0);
				if(cc >= 48 && cc <= 57 || cc >= 65 && cc <= 90 || cc >= 97 && cc <= 122){
					if(pi[no] === undefined){
						pi[no] = tt[t];
					} else {
						pi[no] += tt[t];
					}
				} else {
					no++;
					pi[no] = tt[t];
					no++;
				}
			}

			var tg = {
				da : 1,
				mo : 0,
				ye : 2000,
				se : 1,
				mi : 1,
				ho : 1,
			};
			for ( var a in format){
				if(dateFormat[format[a]] !== undefined){
					tg = dateFormat[format[a]](tg,pi[a]);
				}
			}

			return new Date(tg.ye, tg.mo, tg.da, tg.ho, tg.mi, tg.se);
		}

		//create month list
		function createMonth(){
			var divmonth = "";
			for (var e=0; e < listMonth.length; e++){
				if(e === dateObj.getMonth()){
					divmonth += "<div class='month monthSel' value='" + e + "'>" + listMonth[e] + "</div>";
				} else {
					divmonth += "<div class='month' value='" + e + "'>" + listMonth[e] + "</div>";
				}
			}

			var monthdiv = document.createElement('div');
			monthdiv.setAttribute("id","months");
			monthdiv.innerHTML = divmonth;
			boxCal.insertBefore(monthdiv,boxCal.firstChild.nextSibling);
		}

		//create year list		
		function createYear(){
			var divyear = "";

			//var yearvalue = Number(boxCal.getAttribute('yearvalue'));
			var yearvalue = dateObj.getFullYear();
			var yearstart = yearvalue  - 6;
			var yearend = yearvalue + 5;
			for (var g=yearstart; g <= yearend; g++){
				if(g == yearvalue){
					divyear += "<div class='year yearSel' value='" + g + "'>" + g + "</div>";
				} else {
					divyear += "<div class='year' value='" + g + "'>" + g + "</div>";
				}
			}

			var yeardiv = document.createElement('div');
			yeardiv.setAttribute("id","years");
			yeardiv.innerHTML = divyear;
			boxCal.appendChild(yeardiv);
		}

		//function create round
		function createRound(frameClass,pointClass,value,topStart,leftStart,width,numberStart,numberEnd,selClass,select,label){

			var radian = 0;
			var topEnd = 0;
			var leftEnd = 0;
			var point = [];

			if (Array.isArray(numberEnd)){
				var list = numberEnd;
				numberEnd = list.length-1;
			}

			var frame = document.createElement('ul');
			frame.setAttribute("class",frameClass);
			frame.setAttribute("label",label);
			frame.style.position = "relative";

			//for(var q = numberStart; q <= numberEnd; q++){
			for(var q = numberEnd; q >= numberStart; q--){
				radian = ((2*Math.PI)/(numberEnd-numberStart+1))*q;
				topEnd = topStart - ( width * Math.cos(radian));
				leftEnd = leftStart + ( width * Math.sin(radian));
				
				atag = document.createElement('li');
				point[q] = document.createElement('a');
				if (select === q ) {
					point[q].setAttribute("class",pointClass + " " + selClass);			
				} else {
					point[q].setAttribute("class",pointClass);
				}
				atag.style.position = "absolute";
				atag.style.top = topEnd + "px";
				atag.style.left = leftEnd + "px";
				/*point[q].style.position = "absolute";
				point[q].style.top = topEnd + "px";
				point[q].style.left = leftEnd + "px";*/

				if (Array.isArray(list)){
					point[q].setAttribute(value,list[q]);
					point[q].innerHTML = list[q];
				} else {
					point[q].setAttribute(value,q);
					point[q].innerHTML = q;
				}
				

				atag.appendChild(point[q]);
				frame.appendChild(atag);

				//frame.appendChild(point[q]);
			}

			return frame;
		}

		//create time list
		function createTime(){
			var hourdiv = document.createElement('div');
			hourdiv.setAttribute("id","time");
			hourdiv.appendChild(createRound('seconds','second','value',105,105,85,0,59,'secondsel',dateObj.getSeconds(),listTime[2]));
			hourdiv.appendChild(createRound('minutes','minute','value',105,105,75,0,59,'minutesel',dateObj.getMinutes(),listTime[1]));
			hourdiv.appendChild(createRound('hours hborder','hour','value',105,105,53,12,23,'hoursel',dateObj.getHours(),listTime[0]));
			hourdiv.appendChild(createRound('hours','hour','value',105,105,43,0,11,'hoursel',dateObj.getHours(),listTime[0]));
			//hourdiv.appendChild(createRound('tipeHourId','tipeHourCl','tipehour',100,100,18,0,["24","pm","am"]));
			//boxCal.insertBefore(hourdiv,boxCal.firstChild.nextSibling);
			boxCal.appendChild(hourdiv);
		}

		//event handle 
		function clickObj(obj){
			//var name = obj.getAttribute('class').split(' ')[0];
			var value = obj.getAttribute('value');
			if(findClass(obj,'date')){
				dateObj.setDate(obj.innerHTML);
			} else if(findClass(obj,'month')){
				dateObj.setMonth(value);
				boxCal.setAttribute("monthBtn","");
			} else if(findClass(obj,'year')){
				dateObj.setYear(value);
				boxCal.setAttribute("yearBtn","");
			} else if(findClass(obj,'hour')){
				dateObj.setHours(value);
			} else if(findClass(obj,'minute')){
				dateObj.setMinutes(value);
			} else if(findClass(obj,'second')){
				dateObj.setSeconds(value);
			}
			inp.value = convertFormat(dateObj);
			calendar();
		}

		function showMonthYear(obj){
			var name = obj.getAttribute('id');
			if(boxCal.getAttribute(name) === null){
				boxCal.setAttribute(name,"");
			} else {
				boxCal.removeAttribute(name);
			}
			calendar();
		}

		//create date
		var dateObj = '';
		function createDate(){

			//var dayNow = dateObj.getDay();
			//var dayNameNow = listDay[dateObj.getDay()];
			var dateSel = dateObj.getDate();
			var monthNow = dateObj.getMonth();
			var monthNameNow = listMonth[dateObj.getMonth()];
			var yearNow = dateObj.getFullYear();

			var divbar = "";
			divbar += "<div id='contMonth'><h2 id='monthBtn' value='" + monthNow + "'>" + monthNameNow + "</h2></div>";
			divbar += "<div id='contYear'><h2 id='yearBtn' value='" + yearNow + "'>" + yearNow + "</h2></div>";

			var divweek = "";
			//for(var a = 0; a < listDay.length; a++){
			for ( var a in listDay){
				if(shortDay !== undefined){
					divweek += "<th class='day'>" + listDay[a].substr(0,shortDay) + "</th>";		
				} else {
					divweek += "<th class='day'>" + listDay[a] + "</th>";		
				}
			}

			var divdate = "";
			var datevar = new Date(dateObj);
			datevar.setDate(1);
			var datestart = datevar.getDate();
			var daystart = datevar.getDay();
			var monthstart = datevar.getMonth();
			var br = 0;
            
            var Full_manth = '';
            switch (monthNow) {
                case 0:
                Full_manth = '01';
                break
                case 1:
                Full_manth = '02';
                break
                case 2:
                Full_manth = '03';
                break
                case 3:
                Full_manth = '04';
                break
                case 4:
                Full_manth = '05';
                break
                case 5:
                Full_manth = '06';
                break
                case 6:
                Full_manth = '07';
                break
                case 7:
                Full_manth = '08';
                break
                case 8:
                Full_manth = '09';
                break
                case 9:
                Full_manth = '10';
                break
                case 10:
                Full_manth = '11';
                break
                case 11:
                Full_manth = '12';
                break
            }
            
            var day_full = '';
            switch (datestart) {
                case '1':
                day_full = '01';
                break
                case '2':
                day_full = '02';
                break
                case '3':
                day_full = '03';
                break
                case '4':
                day_full = '04';
                break
                case '5':
                day_full = '05';
                break
                case '6':
                day_full = '06';
                break
                case '7':
                day_full = '07';
                break
                case '8':
                day_full = '08';
                break
                case '9':
                day_full = '09';
                break
                default:
                day_full = datestart;
            }

            
            
			do {
				if(br === 0 ){
					divdate += "<tr>";
				}
				while( br < daystart){
					br++;
					divdate += "<td></td>";
				}
				if(datestart === dateSel){
					divdate += "<td class='date dateSel' data-day_full="+yearNow+"-"+ Full_manth +"-"+datestart+">" + datestart + "</td>";
				} else {
					divdate += "<td class='date' data-day_full="+yearNow+"-"+ Full_manth +"-"+datestart+">" + datestart + "</td>";
				}
				br++;
				if(br >= listDay.length){
					divdate += "</tr>";
					br = 0;
				}
				datevar.setDate(datestart+1);
				datestart = datevar.getDate();
				daystart = datevar.getDay();
				monthstart = datevar.getMonth();
			} while(monthstart == monthNow);
			if( br !== 0 ){
				while( br < listDay.length){
					br++;
					divdate += "<td></td>";
				}
			}
			divdate += "</tr>";

			var calendar = document.createElement('div');
			calendar.setAttribute("id","calendar");
			calendar.innerHTML = divbar + "<table><tr>" + divweek + "</tr>" + divdate + "</table>";
			boxCal.insertBefore(calendar,boxCal.firstChild);
		}

		function findClass(obj,name){
			var cl = obj.getAttribute('class');
			if ( cl === null || cl === undefined || cl.split(' ').indexOf(name) < 0){
				return false;
			} else {
				return true;
			}
		}

		var prevent = false;
		function watchEvent(event){
		        var elm = event.target || event.srcElement;
			//var tglCl = elm.getAttribute('class');
			var tglId = elm.getAttribute('id');
			var inpId = inp.getAttribute('id');
			var inpKey = event.keyCode;

			if(tglId === 'monthBtn' || tglId === 'yearBtn'){
				showMonthYear(elm);
			}else if(findClass(elm,'date') || findClass(elm,'month') || findClass(elm,'year') || findClass(elm,'hour') || findClass(elm,'minute') || findClass(elm,'second')){
				clickObj(elm);
			} else if(inpKey !== 0){
				if (document.addEventListener) { 
					document.removeEventListener("mousedown", watchEvent,true);
					document.removeEventListener("keydown", watchEvent,true);
				} else if (document.attachEvent) {
					document.detachEvent("mousedown", watchEvent);
					document.detachEvent("keydown", watchEvent,true);
				}
				boxCal.parentNode.removeChild(boxCal);
				boxCal = false;
			}else if(boxCal !== false){
				if (document.addEventListener) { 
					document.removeEventListener("mousedown", watchEvent,true);
					document.removeEventListener("keydown", watchEvent,true);
				} else if (document.attachEvent) {
					document.detachEvent("mousedown", watchEvent);
					document.detachEvent("keydown", watchEvent,true);
				}
				boxCal.parentNode.removeChild(boxCal);
				boxCal = false;

				if(inpId === tglId){
					prevent = true;
				}
			}
		}

		//function create div calendar
		var boxCal = false;
		function calendar(){
			var showmonth = null;
			var showyear = null;

			if (boxCal === false){
				//set event to document
				if (document.addEventListener) { 
					document.addEventListener("mousedown", watchEvent,true);
					document.addEventListener("keydown", watchEvent,true);
				} else if (document.attachEvent) {
					document.attachEvent("mousedown", watchEvent);
					document.attachEvent("keydown", watchEvent,true);
				}

			} else {
				showmonth = boxCal.getAttribute('monthBtn');
				showyear = boxCal.getAttribute('yearBtn');
				boxCal.parentNode.removeChild(boxCal);
			}

			boxCal = document.createElement('div');
			boxCal.setAttribute("id","boxCal");
			//boxCal.setAttribute("tabindex","0");
			boxCal.setAttribute("class",clasStyle);
			inp.parentNode.insertBefore(boxCal, inp.nextSibling);

			if(inp.value.trim() === ""){
				dateObj = new Date();
				inp.value = "";
			} else {
				//dateObj = new Date(inp.value);
				dateObj = convertDate(inp.value);
				if (isNaN(dateObj) ){
					dateObj = new Date();
				} else {
					inp.value = convertFormat(dateObj);
				}
			}

			var widthAll = 0;
			if(par.datePicker !== false){
				createDate();
				widthAll = widthAll + document.getElementById('calendar').offsetWidth;
			}

			if( showmonth !== null){
				boxCal.setAttribute("monthBtn","");
				createMonth();
				widthAll = widthAll + document.getElementById('months').offsetWidth;
			}
			if( showyear !== null){
				boxCal.setAttribute("yearBtn","");
				createYear();
				widthAll = widthAll + document.getElementById('years').offsetWidth;
			}

			if(par.timePicker === true){
				createTime();
				widthAll = widthAll + document.getElementById('time').offsetWidth;
			}

			if((inp.offsetLeft + widthAll) >= document.body.offsetWidth){
				boxCal.style.right = "5px";
			} else {
				boxCal.style.left = inp.offsetLeft + "px";
			}
		}

		function inpFocus(){
			if(prevent === false){
				calendar();
			}
		}
		function inpDown(){
			if(prevent === false){
				calendar();
			}else{
				prevent = false;				
			}
		}

		if (inp.addEventListener) { 
			inp.addEventListener("focus", inpFocus);
			inp.addEventListener("click", inpDown);
		} else if (document.attachEvent) { 
			inp.attachEvent("focus", inpFocus);
			inp.attachEvent("click", inpDown);
		}
	}

	//check id input element
	if(document.getElementById(par.input) !== null){
		main(par);
	} else {
		console.log("tgl.js : input id [" + par.input + "] null");
	}
}
