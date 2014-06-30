!function(e){var t=function(t,n,r){var i=typeof n=="object";var s;this.startDate=moment().startOf("day");this.endDate=moment().startOf("day");this.minDate=false;this.maxDate=false;this.dateLimit=false;this.showDropdowns=false;this.showWeekNumbers=false;this.timePicker=false;this.timePickerIncrement=30;this.timePicker12Hour=true;this.ranges={};this.opens="right";this.buttonClasses=["btn","btn-small"];this.applyClass="btn-success";this.cancelClass="btn-default";this.format="MM/DD/YYYY";this.separator=" - ";this.locale={applyLabel:"Apply",cancelLabel:"Cancel",fromLabel:"From",toLabel:"To",weekLabel:"W",customRangeLabel:"Custom Range",daysOfWeek:moment()._lang._weekdaysMin.slice(),monthNames:moment()._lang._monthsShort.slice(),firstDay:0};this.cb=function(){};this.parentEl="body";this.element=e(t);if(this.element.hasClass("pull-right"))this.opens="left";if(this.element.is("input")){this.element.on({click:e.proxy(this.show,this),focus:e.proxy(this.show,this)})}else{this.element.on("click",e.proxy(this.show,this))}s=this.locale;if(i){if(typeof n.locale=="object"){e.each(s,function(e,t){s[e]=n.locale[e]||t})}if(n.applyClass){this.applyClass=n.applyClass}if(n.cancelClass){this.cancelClass=n.cancelClass}}var o='<div class="daterangepicker dropdown-menu">'+'<div class="calendar left"></div>'+'<div class="calendar right"></div>'+'<div class="ranges">'+'<div class="range_inputs">'+'<div class="daterangepicker_start_input" style="float: left">'+'<label for="daterangepicker_start">'+this.locale.fromLabel+"</label>"+'<input class="input-mini" type="text" name="daterangepicker_start" value="" disabled="disabled" />'+"</div>"+'<div class="daterangepicker_end_input" style="float: left; padding-left: 11px">'+'<label for="daterangepicker_end">'+this.locale.toLabel+"</label>"+'<input class="input-mini" type="text" name="daterangepicker_end" value="" disabled="disabled" />'+"</div>"+'<button class="'+this.applyClass+' applyBtn" disabled="disabled">'+this.locale.applyLabel+"</button> "+'<button class="'+this.cancelClass+' cancelBtn">'+this.locale.cancelLabel+"</button>"+"</div>"+"</div>"+"</div>";this.parentEl=i&&n.parentEl&&e(n.parentEl)||e(this.parentEl);this.container=e(o).appendTo(this.parentEl);if(i){if(typeof n.format=="string")this.format=n.format;if(typeof n.separator=="string")this.separator=n.separator;if(typeof n.startDate=="string")this.startDate=moment(n.startDate,this.format);if(typeof n.endDate=="string")this.endDate=moment(n.endDate,this.format);if(typeof n.minDate=="string")this.minDate=moment(n.minDate,this.format);if(typeof n.maxDate=="string")this.maxDate=moment(n.maxDate,this.format);if(typeof n.startDate=="object")this.startDate=moment(n.startDate);if(typeof n.endDate=="object")this.endDate=moment(n.endDate);if(typeof n.minDate=="object")this.minDate=moment(n.minDate);if(typeof n.maxDate=="object")this.maxDate=moment(n.maxDate);if(typeof n.ranges=="object"){for(var u in n.ranges){var a=moment(n.ranges[u][0]);var f=moment(n.ranges[u][1]);if(this.minDate&&a.isBefore(this.minDate))a=moment(this.minDate);if(this.maxDate&&f.isAfter(this.maxDate))f=moment(this.maxDate);if(this.minDate&&f.isBefore(this.minDate)||this.maxDate&&a.isAfter(this.maxDate)){continue}this.ranges[u]=[a,f]}var l="<ul>";for(var u in this.ranges){l+="<li>"+u+"</li>"}l+="<li>"+this.locale.customRangeLabel+"</li>";l+="</ul>";this.container.find(".ranges").prepend(l)}if(typeof n.dateLimit=="object")this.dateLimit=n.dateLimit;if(typeof n.locale=="object"){if(typeof n.locale.firstDay=="number"){this.locale.firstDay=n.locale.firstDay;var c=n.locale.firstDay;while(c>0){this.locale.daysOfWeek.push(this.locale.daysOfWeek.shift());c--}}}if(typeof n.opens=="string")this.opens=n.opens;if(typeof n.showWeekNumbers=="boolean"){this.showWeekNumbers=n.showWeekNumbers}if(typeof n.buttonClasses=="string"){this.buttonClasses=[n.buttonClasses]}if(typeof n.buttonClasses=="object"){this.buttonClasses=n.buttonClasses}if(typeof n.showDropdowns=="boolean"){this.showDropdowns=n.showDropdowns}if(typeof n.timePicker=="boolean"){this.timePicker=n.timePicker}if(typeof n.timePickerIncrement=="number"){this.timePickerIncrement=n.timePickerIncrement}if(typeof n.timePicker12Hour=="boolean"){this.timePicker12Hour=n.timePicker12Hour}}if(!this.timePicker){this.startDate=this.startDate.startOf("day");this.endDate=this.endDate.startOf("day")}var h=this.container;e.each(this.buttonClasses,function(e,t){h.find("button").addClass(t)});if(this.opens=="right"){var p=this.container.find(".calendar.left");var d=this.container.find(".calendar.right");p.removeClass("left").addClass("right");d.removeClass("right").addClass("left")}if(typeof n=="undefined"||typeof n.ranges=="undefined"){this.container.find(".calendar").show();this.move()}if(typeof r=="function")this.cb=r;this.container.addClass("opens"+this.opens);if(!i||typeof n.startDate=="undefined"&&typeof n.endDate=="undefined"){if(e(this.element).is("input[type=text]")){var v=e(this.element).val();var m=v.split(this.separator);var a,f;if(m.length==2){a=moment(m[0],this.format);f=moment(m[1],this.format)}if(a!=null&&f!=null){this.startDate=a;this.endDate=f}}}this.oldStartDate=this.startDate.clone();this.oldEndDate=this.endDate.clone();this.leftCalendar={month:moment([this.startDate.year(),this.startDate.month(),1,this.startDate.hour(),this.startDate.minute()]),calendar:[]};this.rightCalendar={month:moment([this.endDate.year(),this.endDate.month(),1,this.endDate.hour(),this.endDate.minute()]),calendar:[]};this.container.on("mousedown",e.proxy(this.mousedown,this));this.container.find(".calendar").on("click",".prev",e.proxy(this.clickPrev,this));this.container.find(".calendar").on("click",".next",e.proxy(this.clickNext,this));this.container.find(".ranges").on("click","button.applyBtn",e.proxy(this.clickApply,this));this.container.find(".ranges").on("click","button.cancelBtn",e.proxy(this.clickCancel,this));this.container.find(".ranges").on("click",".daterangepicker_start_input",e.proxy(this.showCalendars,this));this.container.find(".ranges").on("click",".daterangepicker_end_input",e.proxy(this.showCalendars,this));this.container.find(".calendar").on("click","td.available",e.proxy(this.clickDate,this));this.container.find(".calendar").on("mouseenter","td.available",e.proxy(this.enterDate,this));this.container.find(".calendar").on("mouseleave","td.available",e.proxy(this.updateView,this));this.container.find(".ranges").on("click","li",e.proxy(this.clickRange,this));this.container.find(".ranges").on("mouseenter","li",e.proxy(this.enterRange,this));this.container.find(".ranges").on("mouseleave","li",e.proxy(this.updateView,this));this.container.find(".calendar").on("change","select.yearselect",e.proxy(this.updateMonthYear,this));this.container.find(".calendar").on("change","select.monthselect",e.proxy(this.updateMonthYear,this));this.container.find(".calendar").on("change","select.hourselect",e.proxy(this.updateTime,this));this.container.find(".calendar").on("change","select.minuteselect",e.proxy(this.updateTime,this));this.container.find(".calendar").on("change","select.ampmselect",e.proxy(this.updateTime,this));this.element.on("keyup",e.proxy(this.updateFromControl,this));this.updateView();this.updateCalendars()};t.prototype={constructor:t,mousedown:function(e){e.stopPropagation()},updateView:function(){this.leftCalendar.month.month(this.startDate.month()).year(this.startDate.year());this.rightCalendar.month.month(this.endDate.month()).year(this.endDate.year());this.container.find("input[name=daterangepicker_start]").val(this.startDate.format(this.format));this.container.find("input[name=daterangepicker_end]").val(this.endDate.format(this.format));if(this.startDate.isSame(this.endDate)||this.startDate.isBefore(this.endDate)){this.container.find("button.applyBtn").removeAttr("disabled")}else{this.container.find("button.applyBtn").attr("disabled","disabled")}},updateFromControl:function(){if(!this.element.is("input"))return;if(!this.element.val().length)return;var e=this.element.val().split(this.separator);var t=moment(e[0],this.format);var n=moment(e[1],this.format);if(t==null||n==null)return;if(n.isBefore(t))return;this.startDate=t;this.endDate=n;this.notify();this.updateCalendars()},notify:function(){this.updateView();this.cb(this.startDate,this.endDate)},move:function(){var t={top:this.parentEl.offset().top-(this.parentEl.is("body")?0:this.parentEl.scrollTop()),left:this.parentEl.offset().left-(this.parentEl.is("body")?0:this.parentEl.scrollLeft())};if(this.opens=="left"){this.container.css({top:this.element.offset().top+this.element.outerHeight()-t.top,right:e(window).width()-this.element.offset().left-this.element.outerWidth()-t.left,left:"auto"});if(this.container.offset().left<0){this.container.css({right:"auto",left:9})}}else{this.container.css({top:this.element.offset().top+this.element.outerHeight()-t.top,left:this.element.offset().left-t.left,right:"auto"});if(this.container.offset().left+this.container.outerWidth()>e(window).width()){this.container.css({left:"auto",right:0})}}},show:function(t){this.container.show();this.move();if(t){t.stopPropagation();t.preventDefault()}e(document).on("mousedown",e.proxy(this.hide,this));this.element.trigger("shown",{target:t.target,picker:this})},hide:function(t){this.container.hide();if(!this.startDate.isSame(this.oldStartDate)||!this.endDate.isSame(this.oldEndDate))this.notify();this.oldStartDate=this.startDate.clone();this.oldEndDate=this.endDate.clone();e(document).off("mousedown",this.hide);this.element.trigger("hidden",{picker:this})},enterRange:function(e){var t=e.target.innerHTML;if(t==this.locale.customRangeLabel){this.updateView()}else{var n=this.ranges[t];this.container.find("input[name=daterangepicker_start]").val(n[0].format(this.format));this.container.find("input[name=daterangepicker_end]").val(n[1].format(this.format))}},showCalendars:function(){this.container.find(".calendar").show();this.move()},updateInputText:function(){if(this.element.is("input"))this.element.val(this.startDate.format(this.format)+this.separator+this.endDate.format(this.format))},clickRange:function(e){var t=e.target.innerHTML;if(t==this.locale.customRangeLabel){this.showCalendars()}else{var n=this.ranges[t];this.startDate=n[0];this.endDate=n[1];if(!this.timePicker){this.startDate.startOf("day");this.endDate.startOf("day")}this.leftCalendar.month.month(this.startDate.month()).year(this.startDate.year()).hour(this.startDate.hour()).minute(this.startDate.minute());this.rightCalendar.month.month(this.endDate.month()).year(this.endDate.year()).hour(this.endDate.hour()).minute(this.endDate.minute());this.updateCalendars();this.updateInputText();this.container.find(".calendar").hide();this.hide()}},clickPrev:function(t){var n=e(t.target).parents(".calendar");if(n.hasClass("left")){this.leftCalendar.month.subtract("month",1)}else{this.rightCalendar.month.subtract("month",1)}this.updateCalendars()},clickNext:function(t){var n=e(t.target).parents(".calendar");if(n.hasClass("left")){this.leftCalendar.month.add("month",1)}else{this.rightCalendar.month.add("month",1)}this.updateCalendars()},enterDate:function(t){var n=e(t.target).attr("data-title");var r=n.substr(1,1);var i=n.substr(3,1);var s=e(t.target).parents(".calendar");if(s.hasClass("left")){this.container.find("input[name=daterangepicker_start]").val(this.leftCalendar.calendar[r][i].format(this.format))}else{this.container.find("input[name=daterangepicker_end]").val(this.rightCalendar.calendar[r][i].format(this.format))}},clickDate:function(t){var n=e(t.target).attr("data-title");var r=n.substr(1,1);var i=n.substr(3,1);var s=e(t.target).parents(".calendar");if(s.hasClass("left")){var o=this.leftCalendar.calendar[r][i];var u=this.endDate;if(typeof this.dateLimit=="object"){var a=moment(o).add(this.dateLimit).startOf("day");if(u.isAfter(a)){u=a}}}else{var o=this.startDate;var u=this.rightCalendar.calendar[r][i];if(typeof this.dateLimit=="object"){var f=moment(u).subtract(this.dateLimit).startOf("day");if(o.isBefore(f)){o=f}}}s.find("td").removeClass("active");if(o.isSame(u)||o.isBefore(u)){e(t.target).addClass("active");this.startDate=o;this.endDate=u}else if(o.isAfter(u)){e(t.target).addClass("active");this.startDate=o;this.endDate=moment(o).add("day",1).startOf("day")}this.leftCalendar.month.month(this.startDate.month()).year(this.startDate.year());this.rightCalendar.month.month(this.endDate.month()).year(this.endDate.year());this.updateCalendars()},clickApply:function(e){this.updateInputText();this.hide()},clickCancel:function(e){this.startDate=this.oldStartDate;this.endDate=this.oldEndDate;this.updateView();this.updateCalendars();this.hide()},updateMonthYear:function(t){var n=e(t.target).closest(".calendar").hasClass("left");var r=this.container.find(".calendar.left");if(!n)r=this.container.find(".calendar.right");var i=parseInt(r.find(".monthselect").val());var s=r.find(".yearselect").val();if(n){this.leftCalendar.month.month(i).year(s)}else{this.rightCalendar.month.month(i).year(s)}this.updateCalendars()},updateTime:function(t){var n=e(t.target).closest(".calendar").hasClass("left");var r=this.container.find(".calendar.left");if(!n)r=this.container.find(".calendar.right");var i=parseInt(r.find(".hourselect").val());var s=parseInt(r.find(".minuteselect").val());if(this.timePicker12Hour){var o=r.find(".ampmselect").val();if(o=="PM"&&i<12)i+=12;if(o=="AM"&&i==12)i=0}if(n){var u=this.startDate;u.hour(i);u.minute(s);this.startDate=u;this.leftCalendar.month.hour(i).minute(s)}else{var a=this.endDate;a.hour(i);a.minute(s);this.endDate=a;this.rightCalendar.month.hour(i).minute(s)}this.updateCalendars()},updateCalendars:function(){this.leftCalendar.calendar=this.buildCalendar(this.leftCalendar.month.month(),this.leftCalendar.month.year(),this.leftCalendar.month.hour(),this.leftCalendar.month.minute(),"left");this.rightCalendar.calendar=this.buildCalendar(this.rightCalendar.month.month(),this.rightCalendar.month.year(),this.rightCalendar.month.hour(),this.rightCalendar.month.minute(),"right");this.container.find(".calendar.left").html(this.renderCalendar(this.leftCalendar.calendar,this.startDate,this.minDate,this.maxDate));this.container.find(".calendar.right").html(this.renderCalendar(this.rightCalendar.calendar,this.endDate,this.startDate,this.maxDate));this.container.find(".ranges li").removeClass("active");var e=true;var t=0;for(var n in this.ranges){if(this.timePicker){if(this.startDate.isSame(this.ranges[n][0])&&this.endDate.isSame(this.ranges[n][1])){e=false;this.container.find(".ranges li:eq("+t+")").addClass("active")}}else{if(this.startDate.format("YYYY-MM-DD")==this.ranges[n][0].format("YYYY-MM-DD")&&this.endDate.format("YYYY-MM-DD")==this.ranges[n][1].format("YYYY-MM-DD")){e=false;this.container.find(".ranges li:eq("+t+")").addClass("active")}}t++}if(e)this.container.find(".ranges li:last").addClass("active")},buildCalendar:function(e,t,n,r,i){var s=moment([t,e,1]);var o=moment(s).subtract("month",1).month();var u=moment(s).subtract("month",1).year();var a=moment([u,o]).daysInMonth();var f=s.day();var l=[];for(var c=0;c<6;c++){l[c]=[]}var h=a-f+this.locale.firstDay+1;if(h>a)h-=7;if(f==this.locale.firstDay)h=a-6;var p=moment([u,o,h,12,r]);for(var c=0,d=0,v=0;c<42;c++,d++,p=moment(p).add("hour",24)){if(c>0&&d%7==0){d=0;v++}l[v][d]=p.clone().hour(n);p.hour(12)}return l},renderDropdowns:function(e,t,n){var r=e.month();var i='<select class="monthselect">';var s=false;var o=false;for(var u=0;u<12;u++){if((!s||u>=t.month())&&(!o||u<=n.month())){i+="<option value='"+u+"'"+(u===r?" selected='selected'":"")+">"+this.locale.monthNames[u]+"</option>"}}i+="</select>";var a=e.year();var f=n&&n.year()||a+5;var l=t&&t.year()||a-50;var c='<select class="yearselect">';for(var h=l;h<=f;h++){c+='<option value="'+h+'"'+(h===a?' selected="selected"':"")+">"+h+"</option>"}c+="</select>";return i+c},renderCalendar:function(t,n,r,i){var s='<div class="calendar-date">';s+='<table class="table-condensed">';s+="<thead>";s+="<tr>";if(this.showWeekNumbers)s+="<th></th>";if(!r||r.isBefore(t[1][1])){s+='<th class="prev available"><i class="icon-arrow-left glyphicon glyphicon-arrow-left"></i></th>'}else{s+="<th></th>"}var o=this.locale.monthNames[t[1][1].month()]+t[1][1].format(" YYYY");if(this.showDropdowns){o=this.renderDropdowns(t[1][1],r,i)}s+='<th colspan="5" style="width: auto">'+o+"</th>";if(!i||i.isAfter(t[1][1])){s+='<th class="next available"><i class="icon-arrow-right glyphicon glyphicon-arrow-right"></i></th>'}else{s+="<th></th>"}s+="</tr>";s+="<tr>";if(this.showWeekNumbers)s+='<th class="week">'+this.locale.weekLabel+"</th>";e.each(this.locale.daysOfWeek,function(e,t){s+="<th>"+t+"</th>"});s+="</tr>";s+="</thead>";s+="<tbody>";for(var u=0;u<6;u++){s+="<tr>";if(this.showWeekNumbers)s+='<td class="week">'+t[u][0].week()+"</td>";for(var a=0;a<7;a++){var f="available ";f+=t[u][a].month()==t[1][1].month()?"":"off";if(r&&t[u][a].isBefore(r)||i&&t[u][a].isAfter(i)){f=" off disabled "}else if(t[u][a].format("YYYY-MM-DD")==n.format("YYYY-MM-DD")){f+=" active ";if(t[u][a].format("YYYY-MM-DD")==this.startDate.format("YYYY-MM-DD")){f+=" start-date "}if(t[u][a].format("YYYY-MM-DD")==this.endDate.format("YYYY-MM-DD")){f+=" end-date "}}else if(t[u][a]>=this.startDate&&t[u][a]<=this.endDate){f+=" in-range ";if(t[u][a].isSame(this.startDate)){f+=" start-date "}if(t[u][a].isSame(this.endDate)){f+=" end-date "}}var l="r"+u+"c"+a;s+='<td class="'+f.replace(/\s+/g," ").replace(/^\s?(.*?)\s?$/,"$1")+'" data-title="'+l+'">'+t[u][a].date()+"</td>"}s+="</tr>"}s+="</tbody>";s+="</table>";s+="</div>";if(this.timePicker){s+='<div class="calendar-time">';s+='<select class="hourselect">';var c=0;var h=23;var p=n.hour();if(this.timePicker12Hour){c=1;h=12;if(p>=12)p-=12;if(p==0)p=12}for(var d=c;d<=h;d++){if(d==p){s+='<option value="'+d+'" selected="selected">'+d+"</option>"}else{s+='<option value="'+d+'">'+d+"</option>"}}s+="</select> : ";s+='<select class="minuteselect">';for(var d=0;d<60;d+=this.timePickerIncrement){var v=d;if(v<10)v="0"+v;if(d==n.minute()){s+='<option value="'+d+'" selected="selected">'+v+"</option>"}else{s+='<option value="'+d+'">'+v+"</option>"}}s+="</select> ";if(this.timePicker12Hour){s+='<select class="ampmselect">';if(n.hour()>=12){s+='<option value="AM">AM</option><option value="PM" selected="selected">PM</option>'}else{s+='<option value="AM" selected="selected">AM</option><option value="PM">PM</option>'}s+="</select>"}s+="</div>"}return s}};e.fn.daterangepicker=function(n,r){this.each(function(){var i=e(this);if(!i.data("daterangepicker"))i.data("daterangepicker",new t(i,n,r))});return this}}(window.jQuery)