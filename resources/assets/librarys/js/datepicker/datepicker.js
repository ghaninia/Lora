/*
* Datepicker-Jalali v0.0.0.1
* Author : Hossein Rafiee
* repo : https://github.com/h-rafiee/Datepicker-Jalali
*
* MIT LICENSE
* Copyright (c) 2017 Hossein Rafiee (h.rafiee91@gmail.com)

* Permission is hereby granted, free of charge, to any person obtaining a copy
* of this software and associated documentation files (the "Software"), to deal
* in the Software without restriction, including without limitation the rights
* to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, and to permit persons to whom the Software is
* furnished to do so, subject to the following conditions:

* The above copyright notice and this permission notice shall be included in all
* copies or substantial portions of the Software.

* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
* AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
* LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
* OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
* SOFTWARE.
* */
(function ( $ ) {
    var settings = null;
    $.fn.datepicker = function( options ) {
        // This is the easiest way to have default options.
        settings = $.extend({
            // These are the defaults.
            altField : "",
            altSecondaryField : null,
            minDate  : null,
            maxDate  : null,
            maxYear  : 1420,
            minYear  : 1320,
            navRight : "<",
            navLeft  : ">",
            today    : true,
            format   : "short",
            view : "day",
            pick : "day",
            date : "1991-01-02",
            gregorian:false
        }, options );
        return renderDatePicker(this,settings.date);
 
    };
    function renderDatePicker(_,d){
        var navigator = ['day','month','year','decade'];
        var pickLvl = [];
        pickLvl["day"] = 0;
        pickLvl["month"] = 1;
        pickLvl["year"] = 2;
        var darr = d.split("-");
        var sh_date = ToShamsi(parseInt(darr[0]),parseInt(darr[1]),parseInt(darr[2]),"short");
        var sh_date_array = sh_date.split("-");
        settings.shYear = sh_date_array[0];
        settings.cshYear = sh_date_array[0];
        settings.pshYear = sh_date_array[0];
        settings.shMonth = sh_date_array[1];
        settings.cshMonth = sh_date_array[1];
        settings.pshMonth = sh_date_array[1];
        settings.shDay = sh_date_array[2];
        settings.cshDay = sh_date_array[2];
        settings.pshDay = sh_date_array[2];
        settings.startY = parseInt(sh_date_array[0]) - 4;
        settings.endY = parseInt(sh_date_array[0]) + 4;
        if(pickLvl[settings.pick] > pickLvl[settings.view]){
            settings.view = settings.pick;
        }
        settings.navigator = navigator[pickLvl[settings.view]+1];
        var contentNav = settings.shYear+" - "+calNames("hf",settings.shMonth - 1);
        switch (settings.navigator){
            case "year" :
                contentNav = settings.shYear;
                break;
            case "decade" :
                settings.startY = parseInt(settings.shYear) - 4;
                settings.endY   = parseInt(settings.shYear) + 4;
                contentNav = settings.startY+"-"+settings.endY;
                break;
        }
        $.tmplMustache(TEMPLATE.datepciker,dataTemplate).appendTo(_);
        $.tmplMustache(TEMPLATE.navigator,{navRight : settings.navRight , navLeft : settings.navLeft,content : contentNav}).appendTo($("."+dataTemplate.css.datePickerPlotArea+" ."+dataTemplate.css.navigator,_));
        $.tmplMustache(TEMPLATE.months,dataTemplate).appendTo($(s.datePickerPlotArea+" "+ s.monthView,_));
        doView(_,settings.view);
        initEvents(_);
        $(settings.altField).val(formatAltField(parseInt(settings.shYear),parseInt(settings.shMonth),parseInt(settings.shDay),settings.format));
        if(settings.altSecondaryField){
            $(settings.altSecondaryField).val(ToGregorian(parseInt(settings.shYear),parseInt(settings.shMonth),parseInt(settings.shDay)));
        }
    }
    function contentNavigator(_){
        switch (settings.navigator){
            case "month" :
                $(s.datePickerPlotArea+" "+ s.navigator + " .nav-content",_).html(settings.shYear+" - "+calNames("hf",settings.shMonth - 1));
                break;
            case "year" :
                $(s.datePickerPlotArea+" "+ s.navigator + " .nav-content",_).html(settings.shYear);
                break;
            case "decade" :
                settings.startY = parseInt(settings.shYear) - 4;
                settings.endY   = parseInt(settings.shYear) + 4;
                $(s.datePickerPlotArea+" "+ s.navigator + " .nav-content",_).html(settings.startY+"-"+settings.endY);
                break;
        }
    }
    function renderNavigator(_){
        switch (settings.navigator){
            case "month" :
                renderDays(_);
                $(s.datePickerPlotArea+" "+ s.navigator + " .nav-content",_).html(settings.shYear+" - "+calNames("hf",settings.shMonth - 1));
                break;
            case "year" :
                renderMonth(_);
                $(s.datePickerPlotArea+" "+ s.navigator + " .nav-content",_).html(settings.shYear);
                break;
            case "decade" :
                settings.startY = parseInt(settings.shYear) - 4;
                settings.endY   = parseInt(settings.shYear) + 4;
                renderYear(_);
                $(s.datePickerPlotArea+" "+ s.navigator + " .nav-content",_).html(settings.startY+"-"+settings.endY);
                break;
        }
    }
    function renderDays(_){
        var maxDay = daysOfMonth(settings.shYear,settings.shMonth);
        $(s.datePickerPlotArea+" "+s.dayView,_).html('');
        $.tmplMustache(TEMPLATE.monthGrid,dataTemplate).appendTo($(s.datePickerPlotArea+" "+s.dayView,_));
        var first_day = hshDayOfWeek(settings.shYear,settings.shMonth,1);
        var week = 1 ;
        for (var i = 1 ; i <= first_day ; i++){
            $.tmplMustache(TEMPLATE.emptyTd,{}).appendTo($(s.datePickerPlotArea+" "+s.dayView+" "+ s.tableMonthGrid+ " tr[data-week='"+week+"']",_));
        }
        for(var i = 1 ; i <= maxDay ; i++){
            if(first_day>=7){
                first_day = 0 ;
                week++;
            }
            if(checkMaxDate(settings.shYear,settings.shMonth,i) || checkMinDate(settings.shYear,settings.shMonth,i)){
                $.tmplMustache(TEMPLATE.emptyTd,{}).appendTo($(s.datePickerPlotArea+" "+s.dayView+" "+ s.tableMonthGrid+ " tr[data-week='"+week+"']",_));
            }else if(settings.shYear == settings.cshYear && settings.shMonth == settings.cshMonth && settings.cshDay == i){
                $.tmplMustache(TEMPLATE.days,{day : i ,pick : (settings.pick == "day")?"pick":"" , today:"today" , select : ""}).appendTo($(s.datePickerPlotArea+" "+s.dayView+" "+ s.tableMonthGrid+ " tr[data-week='"+week+"']",_));
            }else{
                $.tmplMustache(TEMPLATE.days,{day : i ,pick : (settings.pick == "day")?"pick":"", today:"",select : ( settings.pshYear == settings.shYear && settings.pshMonth == settings.shMonth && parseInt(settings.pshDay) == i)?"select":"" }).appendTo($(s.datePickerPlotArea+" "+s.dayView+" "+ s.tableMonthGrid+ " tr[data-week='"+week+"']",_));
            }
            first_day++;
        }
    }
    function renderMonth(_){
        var season = 1;
        $(s.datePickerPlotArea+" "+ s.monthView,_).html("");
        $.tmplMustache(TEMPLATE.months,dataTemplate).appendTo($(s.datePickerPlotArea+" "+ s.monthView,_));
        for(var i = 1 ; i <= 12 ; i++ ){
            if(checkMaxDate(settings.shYear,i) || checkMinDate(settings.shYear,i,daysOfMonth(settings.shYear,i))){
                continue;
            }else{
                $.tmplMustache(TEMPLATE.eachMonth,{monthNumber : i ,pick : (settings.pick == "month")?"pick":"", month : calNames("hf",i-1) ,select : ( settings.pshYear == settings.shYear && parseInt(settings.pshMonth) == i)?"select":"" , thisMonth : (settings.shYear == settings.cshYear && settings.cshMonth == i)? "this": "" }).appendTo($(s.datePickerPlotArea+" "+ s.monthView+" "+ s.tableMonths+" tr[data-season='"+season+"']",_));
            }
            if(i % 3 == 0){
                season++;
            }
        }
    }

    function renderYear(_){
        var row = 1 ;
        $(s.datePickerPlotArea+" "+ s.yearView,_).html("");
        $.tmplMustache(TEMPLATE.years,dataTemplate).appendTo($(s.datePickerPlotArea+" "+ s.yearView,_));
        var j = 1;
        for(var i = settings.startY ; i <= settings.endY ; i++){
            if(checkMaxDate(i,1) || checkMinDate(i,12,daysOfMonth(i,12))){
                $.tmplMustache(TEMPLATE.emptyTd,{}).appendTo($(s.datePickerPlotArea+" "+ s.yearView+" "+ s.tableYears+" tr[data-row='"+row+"']",_));
            }else{
                $.tmplMustache(TEMPLATE.eachYear,{year : i ,pick : (settings.pick == "year")?"pick":"",select : (parseInt(settings.pshYear) == i)?"select":"", thisYear : (i == settings.cshYear)? "this": "" }).appendTo($(s.datePickerPlotArea+" "+ s.yearView+" "+ s.tableYears+" tr[data-row='"+row+"']",_));
            }
            if(j % 3 == 0){
                row++;
            }
            j++;
        }
    }

    function doView(_,v){
        clearViews(_);
        switch (v){
            case "day":
                renderDays(_)
                $(s.datePickerPlotArea+" "+s.yearView,_).hide();
                $(s.datePickerPlotArea+" "+s.monthView,_).hide();
                $(s.datePickerPlotArea+" "+s.dayView,_).show();
                break;
            case "month":
                renderMonth(_);
                $(s.datePickerPlotArea+" "+s.dayView,_).hide();
                $(s.datePickerPlotArea+" "+s.yearView,_).hide();
                $(s.datePickerPlotArea+" "+s.monthView,_).show();
                break;
            case "year":
                renderYear(_);
                $(s.datePickerPlotArea+" "+s.dayView,_).hide();
                $(s.datePickerPlotArea+" "+s.monthView,_).hide();
                $(s.datePickerPlotArea+" "+s.yearView,_).show();
                break;
        }
    }

    function clearViews(_){
        $(s.datePickerPlotArea+" "+s.dayView,_).html('');
        $(s.datePickerPlotArea+" "+s.monthView,_).html('');
        $(s.datePickerPlotArea+" "+s.yearView,_).html('');

    }

    function daysOfMonth(y,m){
        var maxDay = 31;
        if(m > 6 && m<12){
            maxDay = 30;
        }else if(m == 12 && hshIsLeap(y)){
            maxDay = 30;
        }else if(m == 12){
            maxDay = 29;
        }
        return maxDay;
    }
    var grgSumOfDays=Array(Array(0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334, 365),Array(0, 31, 60, 91, 121, 152, 182, 213, 244, 274, 305, 335, 366));
    var hshSumOfDays=Array(Array(0, 31, 62, 93, 124, 155, 186, 216, 246, 276, 306, 336, 365), Array(0, 31, 62, 93, 124, 155, 186, 216, 246, 276, 306, 336, 366));

    function ToShamsi(grgYear,grgMonth,grgDay,Format)
    {
        var hshYear = grgYear-621;
        var hshMonth,hshDay;
        
        var grgLeap=grgIsLeap (grgYear);
        var hshLeap=hshIsLeap (hshYear-1);
        
        var hshElapsed;
        var grgElapsed = grgSumOfDays[(grgLeap ? 1:0)][grgMonth-1]+grgDay;

        var XmasToNorooz = (hshLeap && grgLeap) ? 80 : 79;

        if (grgElapsed <= XmasToNorooz)
        {
            hshElapsed = grgElapsed+286;
            hshYear--;
            if (hshLeap && !grgLeap)
                hshElapsed++;
        }
        else
        {
            hshElapsed = grgElapsed - XmasToNorooz;
            hshLeap = hshIsLeap (hshYear);
        }

        for (var i=1; i <= 12 ; i++)
        {
            if (hshSumOfDays [(hshLeap ? 1:0)][i] >= hshElapsed)
            {
                hshMonth = i;
                hshDay = hshElapsed - hshSumOfDays [(hshLeap ? 1:0)][i-1];
                break;
            }
        }


        if (Format.toLowerCase() == "long")
            return hshDayName (hshDayOfWeek(hshYear,hshMonth,hshDay)) + "  " + hshDay + " " + calNames("hf", hshMonth-1) + " " + hshYear;
        else
            return hshYear + "-" + hshMonth + "-" + hshDay;
    }


    function formatAltField(hshYear,hshMonth,hshDay,Format){
        switch (settings.pick){
            case "day" :
                if(settings.gregorian == true){
                    return ToGregorian(hshYear,hshMonth,hshDay);
                }
                if (Format.toLowerCase() == "long")
                    return hshDayName (hshDayOfWeek(hshYear,hshMonth,hshDay)) + "  " + hshDay + " " + calNames("hf", hshMonth-1) + " " + hshYear;
                else
                    return hshYear + "-" + hshMonth + "-" + hshDay;
                break;
            case "month":
                if(settings.gregorian == true){
                    return ToGregorian(hshYear,hshMonth,hshDay);
                }
                if (Format.toLowerCase() == "long")
                    return calNames("hf", hshMonth-1) + " " + hshYear;
                else
                    return hshYear + "-" + hshMonth;
                break;
            case "year":
                if(settings.gregorian == true){
                    return ToGregorian(hshYear,hshMonth,hshDay);
                }
                return hshYear;
                break;
        }
    }


    function ToGregorian (hshYear,hshMonth,hshDay)
    {
        var grgYear = hshYear+621;
        var grgMonth,grgDay;

        var hshLeap=hshIsLeap (hshYear);
        var grgLeap=grgIsLeap (grgYear);

        var hshElapsed=hshSumOfDays [hshLeap ? 1:0][hshMonth-1]+hshDay;
        var grgElapsed;

        if (hshMonth > 10 || (hshMonth == 10 && hshElapsed > 286+(grgLeap ? 1:0)))
        {
            grgElapsed = hshElapsed - (286 + (grgLeap ? 1:0));
            grgLeap = grgIsLeap (++grgYear);
        }
        else
        {
            hshLeap = hshIsLeap (hshYear-1);
            grgElapsed = hshElapsed + 79 + (hshLeap ? 1:0) - (grgIsLeap(grgYear-1) ? 1:0);
        }

        for (var i=1; i <= 12; i++)
        {
            if (grgSumOfDays [grgLeap ? 1:0][i] >= grgElapsed)
            {
                grgMonth = i;
                grgDay = grgElapsed - grgSumOfDays [grgLeap ? 1:0][i-1];
                break;
            }
        }
        if(settings.pick == "year")
            return grgYear;
        if(settings.pick == "month")
            return grgYear+"-"+zeroPad(grgMonth,2);
        return grgYear+"-"+zeroPad(grgMonth,2)+"-"+zeroPad(grgDay,2);
    }

    function hshDayOfWeek(hshYear, hshMonth, hshDay)
    {
        var value;
        value = hshYear - 1376 + hshSumOfDays[0][hshMonth-1] + hshDay - 1;

        for (var i=1380; i<hshYear; i++)
            if (hshIsLeap(i)) value++;
        for (var i=hshYear; i<1380; i++)
            if (hshIsLeap(i)) value--;

        value=value%7;
        if (value<0) value=value+7;

        return (value);
    }

    function grgIsLeap (Year)
    {
        return ((Year%4) == 0 && ((Year%100) != 0 || (Year%400) == 0));
    }

    function hshIsLeap (Year)
    {
        Year = (Year - 474) % 128;
        Year = ((Year >= 30) ? 0 : 29) + Year;
        Year = Year - Math.floor(Year/33) - 1;
        return ((Year % 4) == 0);
    }

    function hshDayName(DayOfWeek)
    {
        return calNames("df", DayOfWeek%7);
    }

    function calNames(calendarName, monthNo)
    {
        switch (calendarName)
        {
            case "hf": return Array("فروردين", "ارديبهشت", "خرداد", "تير", "مرداد", "شهريور", "مهر", "آبان", "آذر", "دی", "بهمن", "اسفند")[monthNo];
            case "ge": return Array(" January ", " February ", " March ", " April ", " May ", " June ", " July ", " August ", " September ", " October ", " November ", " December ")[monthNo];
            case "gf": return Array("ژانویه", "فوریه", "مارس", "آوریل", "مه", "ژوثن", "ژوییه", "اوت", "سپتامبر", "اكتبر", "نوامبر", "دسامبر")[monthNo];
            case "df": return Array("شنبه", "یک‌شنبه", "دوشنبه", "سه‌شنبه", "چهارشنبه", "پنج‌شنبه", "جمعه")[monthNo];
            case "de": return Array("Saturday", "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday")[monthNo];
        }
    }

    $.tmplMustache = function (input, dict) {
        // Micro Mustache Template engine
        String.prototype.format = function string_format(arrayInput) {
            function replacer(key) {
                var keyArr = key.slice(2, -2).split("."), firstKey = keyArr[0], SecondKey = keyArr[1];
                if (arrayInput[firstKey] instanceof Object) {
                    return arrayInput[firstKey][SecondKey];
                } else {
                    return arrayInput[firstKey];
                }
            }

            return this.replace(/{{\s*[\w\.]+\s*}}/g, replacer);
        };
        return $(input.format(dict));
    };

    function initEvents(e){
        var self = e ;
        $(s.datePickerPlotArea+" "+ s.navigator+" "+".nav-right",e).bind("click",function(){
            return navigator(self,"prev");
        });
        $(s.datePickerPlotArea+" "+ s.navigator+" "+".nav-left",e).bind("click",function(){
            navigator(self,"next");
        });
        $(s.datePickerPlotArea+" "+ s.navigator+" "+".nav-content",e).bind("click",function(){
            return navigator(self,"view");
        });
        $(s.datePickerPlotArea+" "+ s.yearView,e).on("click",".year",function(){
            settings.shYear = parseInt($(this).attr('data-val'));
            if($(this).hasClass("pick")){
                clearSelection();
                $(this).addClass('select');
                settings.pshYear = parseInt($(this).attr('data-val'));
                $(settings.altField).val(formatAltField(parseInt(settings.shYear),parseInt(settings.shMonth),parseInt($(this).attr('data-val')),settings.format));
                if(settings.altSecondaryField){
                    $(settings.altSecondaryField).val(ToGregorian(parseInt(settings.shYear),parseInt(settings.shMonth),parseInt(settings.shDay)));
                }
                return true;
            }
            settings.view = "month";
            settings.navigator = "year";
            doView(self,settings.view);
            contentNavigator(self)
        });
        $(s.datePickerPlotArea+" "+ s.monthView,e).on("click",".month",function(){
            settings.shMonth = parseInt($(this).attr('data-val'));
            if($(this).hasClass("pick")){
                clearSelection();
                settings.pshYear = settings.shYear;
                settings.pshMonth = parseInt($(this).attr('data-val'));
                $(this).addClass('select');
                $(settings.altField).val(formatAltField(parseInt(settings.shYear),parseInt(settings.shMonth),parseInt($(this).attr('data-val')),settings.format));
                if(settings.altSecondaryField){
                    $(settings.altSecondaryField).val(ToGregorian(parseInt(settings.shYear),parseInt(settings.shMonth),parseInt(settings.shDay)));
                }
                return true;
            }
            settings.view = "day";
            settings.navigator = "month";
            doView(self,settings.view);
            contentNavigator(self)
        });
        $(s.datePickerPlotArea+" "+ s.dayView,e).on("click",".day",function(){
            settings.shDay = parseInt($(this).attr('data-val'));
            settings.pshYear = settings.shYear;
            settings.pshMonth = settings.shMonth;
            settings.pshDay = parseInt($(this).attr('data-val'));
            clearSelection();
            $(this).addClass('select');
            $(settings.altField).val(formatAltField(parseInt(settings.shYear),parseInt(settings.shMonth),parseInt($(this).attr('data-val')),settings.format));
            if(settings.altSecondaryField){
                $(settings.altSecondaryField).val(ToGregorian(parseInt(settings.shYear),parseInt(settings.shMonth),parseInt(settings.shDay)));
            }
        });
    }

    function clearSelection(){
        $(s.datePickerPlotArea+" * .select").each(function(){
            $(this).removeClass('select');
        });
    }

    function navigator(e,to){
        switch (to){
            case "next":
                switch (settings.navigator) {
                    case "month":
                        if(checkMaxDate(settings.shYear,parseInt(settings.shMonth) + 1)){
                            return false;
                        }
                        settings.shMonth = parseInt(settings.shMonth) + 1;
                        if(settings.shMonth > 12) {
                            settings.shMonth = 1;
                            settings.shYear = parseInt(settings.shYear) + 1;
                        }
                        renderNavigator(e);
                        break;
                    case "year":
                        if(checkMaxDate(parseInt(settings.shYear) + 1,1)){
                            return false;
                        }
                        settings.shYear = parseInt(settings.shYear) + 1 ;
                        renderNavigator(e);
                        break;
                    case "decade":
                        if(checkMaxDate(parseInt(settings.shYear) + 9,1)){
                            return false;
                        }
                        settings.shYear = parseInt(settings.shYear) + 9 ;
                        renderNavigator(e);
                        break;
                }
                break;
            case "prev":
                switch (settings.navigator) {
                    case "month":
                        if(checkMinDate(settings.shYear,parseInt(settings.shMonth) - 1,daysOfMonth(settings.shYear,parseInt(settings.shMonth) - 1))){
                            return false;
                        }
                        settings.shMonth =  parseInt(settings.shMonth) - 1;
                        if(settings.shMonth < 1){
                            settings.shMonth = 12;
                            settings.shYear = parseInt(settings.shYear) - 1;
                        }
                        renderNavigator(e);
                        break;
                    case "year":
                        if(checkMinDate(parseInt(settings.shYear) - 1,12,daysOfMonth(parseInt(settings.shYear) - 1,12))){
                            return false;
                        }
                        settings.shYear = parseInt(settings.shYear) - 1 ;
                        renderNavigator(e);
                        break;
                    case "decade":
                        if(checkMinDate(parseInt(settings.shYear) - 9,12,daysOfMonth(parseInt(settings.shYear) - 9,12))){
                            return false;
                        }
                        settings.shYear = parseInt(settings.shYear) - 9 ;
                        renderNavigator(e);
                        break;
                }
                break;
            case "view":
                switch (settings.navigator) {
                    case "month":
                        settings.navigator = "year";
                        settings.view = "month";
                        doView(e,settings.view);
                        contentNavigator(e);
                        break;
                    case "year":
                        settings.navigator = "decade";
                        settings.view = "year";
                        doView(e,settings.view);
                        contentNavigator(e);
                        break;
                }
                break;
        }
    }

    function zeroPad(num, places) {
        var zero = places - num.toString().length + 1;
        return Array(+(zero > 0 && zero)).join("0") + num;
    }

    function checkMaxDate(y,m,d){
        d = d || 1 ;
        if(y+"-"+zeroPad(m,2)+"-"+zeroPad(d,2) > settings.maxDate)
            return true;
        return false;
    }

    function checkMinDate(y,m,d){
        d = d || 1 ;
        if(y+"-"+zeroPad(m,2)+"-"+zeroPad(d,2) < settings.minDate)
            return true;
        return false;
    }

    //selectors
    var s = {
        datePickerPlotArea : ".datepicker-jalali",
        navigator : ".datepicker-navigator",
        tableMonthGrid : ".datepicker-tablemonthgrid",
        tableMonths : ".datepicker-tablemonths",
        tableYears : ".datepicker-tableyears",
        tableYears : ".datepicker-tableyears",
        dayView : ".datepicker-days",
        monthView : ".datepicker-month",
        yearView : ".datepicker-years",
        toolbox : ".datepicker-tools",
        day : ".day"
    }

    var dataTemplate = {
        css : {
            datePickerPlotArea : "datepicker-jalali",
            navigator : "datepicker-navigator",
            tableMonthGrid : "datepicker-tablemonthgrid",
            tableMonths : "datepicker-tablemonths",
            tableYears : "datepicker-tableyears",
            tableYears : "datepicker-tableyears",
            dayView : "datepicker-days",
            monthView : "datepicker-month",
            yearView : "datepicker-years",
            toolbox : "datepicker-tools",
        }
    };

    var TEMPLATE  = {
        datepciker: "<div class='{{css.datePickerPlotArea}}' >" + //
        "<div class='{{css.navigator}}' ></div>" +//
        "<div class='{{css.dayView}}' ></div>" + //
        "<div class='{{css.monthView}}' ></div>" + //
        "<div class='{{css.yearView}}' ></div>" + //
        "<div class='{{css.toolbox}}' ></div>" + //
        "</div>",
        navigator : "<span class='nav-right'>{{navRight}}</span>" +
        "<span class='nav-left'>{{navLeft}}</span>"+
        "<span class='nav-content'>{{content}}</span>",
        years : "<table>" +
        "<tbody class='{{css.tableYears}}'>" +
        "<tr data-row='1'></tr>" +
        "<tr data-row='2'></tr>" +
        "<tr data-row='3'></tr>" +
        "</tbody>"+
        "</table>",
        eachYear : "<td><span class='year {{pick}} {{select}} {{thisYear}}' data-val='{{year}}'>{{year}}</span></td>",
        months : "<table class='table-responsive'>" +
        "<tbody class='{{css.tableMonths}}'>" +
        "<tr data-season='1'></tr>" +
        "<tr data-season='2'></tr>" +
        "<tr data-season='3'></tr>" +
        "<tr data-season='4'></tr>" +
        "</tbody>"+
        "</table>",
        eachMonth : "<td><span class='month {{pick}} {{select}} {{thisMonth}}' data-val='{{monthNumber}}'>{{month}}</span></td>",
        monthGrid : "<table>" +
        "<thead><th>ش</th><th>ی</th><th>د</th><th>س</th><th>چ</th><th>پ</th><th>ج</th></thead>" +
        "<tbody class='{{css.tableMonthGrid}}'>" +
        "<tr data-week='1'></tr>" +
        "<tr data-week='2'></tr>" +
        "<tr data-week='3'></tr>" +
        "<tr data-week='4'></tr>" +
        "<tr data-week='5'></tr>" +
        "<tr data-week='6'></tr>" +
        "</tbody>" +
        "</table>",
        days : "<td><span class='day {{pick}} {{select}} {{today}}' data-val='{{day}}'>{{day}}</span></td>",
        emptyTd : "<td><span>&nbsp;</span></td>"

    };
}( jQuery ));