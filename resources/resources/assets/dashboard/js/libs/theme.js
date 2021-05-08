var data =  {
    "csrf" : $("meta[name='csrf-token']").attr('content')
};

var messages = {
    "cancel" : "بیخیال" ,
    "info" : "هشدار" ,
    "good_job" : 'کار خوب پیش رفت' ,
    "error" : "اختلال در سیستم" ,
    "error_msg" : "متاسفانه خطای غیر منتظره ای رخ داده ." ,
    'info_confirmed' : "بله مطمئن هستم" ,
    "link_delete" : "آیا میخواهید لینک دانلود را حذف نمایید ؟" ,
};

$(function () {
    $('[role="swal"]').each(function () {
        var button = $(this) ;

        button.click(function (e) {
            e.preventDefault() ;
            var url    = button.data('url') ;
            var action = button.data('action') ;
            var msg = button.data('message') ;
            if(action === "delete")
            {
                swal({
                    title: messages.info ,
                    text: msg ,
                    type: "warning" ,
                    showCancelButton: true,
                    confirmButtonText: messages.info_confirmed ,
                    cancelButtonText: messages.cancel ,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true
                }, function () {
                    $.ajax({
                        url : url ,
                        dataType : "JSON" ,
                        method : "DELETE" ,
                        headers : {
                            "X-CSRF-TOKEN" : data.csrf
                        },success : function (response) {
                            swal({
                                title: messages.good_job ,
                                text: response.message ,
                                type:  (response.status == true ) ? "success" : "warning"  ,
                                showCancelButton: false ,
                                showConfirmButton: false
                            });
                            setTimeout(function () {
                                if(response.url != undefined)
                                    window.location.href = response.url ;
                                else
                                    window.location.reload() ;
                            } , 600 ) ;
                        } , error: function (xhr, ajaxOptions, thrownError){
                            swal({
                                title: messages.error ,
                                text: messages.error_msg ,
                                type: "warning" ,
                                showCancelButton: false ,
                                showConfirmButton: false
                            });
                            console.log(e) ;
                        }
                    })
                });
            }
			if(action === "link"){
				window.location.href = url ;
			}
            if(action === "edit")
            {
                swal({
                    title: messages.info ,
                    text: msg ,
                    type: "info" ,
                    showCancelButton: true,
                    confirmButtonText: messages.info_confirmed ,
                    cancelButtonText: messages.cancel ,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true
                }, function () {
                    $.ajax({
                        url : url ,
                        dataType : "JSON" ,
                        method : "PUT" ,
                        headers : {
                            "X-CSRF-TOKEN" : data.csrf
                        },success : function (response) {
                            swal({
                                title: messages.good_job ,
                                text: response.message ,
                                type:  (response.status == true ) ? "success" : "warning"  ,
                                showCancelButton: false ,
                                showConfirmButton: false
                            });
                            setTimeout(function () {
                                if(response.url != undefined)
                                    window.location.href = response.url ;
                                else
                                    window.location.reload() ;
                            } , 600 ) ;
                        } , error: function (xhr, ajaxOptions, thrownError){
                            swal({
                                title: messages.error ,
                                text: messages.error_msg ,
                                type: "warning" ,
                                showCancelButton: false ,
                                showConfirmButton: false
                            });
                            console.log(e) ;
                        }
                    })
                });
            }
        });
    });
});

$(function () {
    $("table").each(function () {
        var table = $(this) ;
        var thc = $("thead tr th input[type='checkbox']" , table ) ;
        var tbc = $("tbody tr td input[type='checkbox']" , table) ;
        thc.click(function () {
            tbc.prop("checked" , $(this).prop("checked") )
        });
        tbc.change(function () {
            if(!$(this).prop("checked") && thc.prop("checked") )
            {
                thc.prop("checked" , false );
            }
            if($(this).prop("checked"))
            {
                var cl = [] ;
                tbc.each(function () {
                    cl.push($(this).prop("checked")) ;
                }) ;
                if( $.inArray(false , cl ) < 0 )
                {
                    thc.prop("checked" , true );
                }
            }
        });
    });
});


$(function () {
   if ( document.querySelector('.chart') ){
       $(function () {
           if( typeof Chart == 'function')
           {
               var charts = $("canvas#chart") ;
               var x = charts.data("x") ; var y = charts.data("y") ; var theme = charts.data("theme") ;
               new Chart( charts , {
                   type: 'line',
                   data: {
                       labels: x ,
                       datasets: [{
                           backgroundColor: "transparent" ,
                           borderColor: theme ,
                           borderWidth: "2",
                           data: y
                       }]
                   },
                   options: {
                       layout: {
                           padding: 0,
                       },
                       legend: { display: false },
                       title:  { display: false },
                       tooltips: { display : false },
                       scales: {
                           yAxes: [{
                               ticks: {
                                   userCallback: function(label, index, labels) {
                                       if (Math.floor(label) === label) return label;
                                   },
                               }
                           }]
                       }
                   }
               });
           }
       });
       function CreateChart(id,lables,data , label ) {
           var label = (typeof label === 'undifined' ? 'views' : label ) ;
           if( typeof Chart == 'function')
           {
               var chart = new Chart( document.getElementById(id).getContext('2d') , {
                   type: 'line',
                   // The data for our dataset
                   data: {
                       labels: lables ,
                       // Information about the dataset
                       datasets: [{
                           label: label ,
                           backgroundColor: 'rgba(0,0,0,0.02)',
                           borderColor: 'rgba(0,0,0,0.09)' ,
                           borderWidth: "3",
                           data: data ,
                           pointRadius: 5,
                           pointHoverRadius:5,
                           pointHitRadius: 10,
                           pointBackgroundColor: "#fff",
                           pointHoverBackgroundColor: "#fff",
                           pointBorderWidth: "2"
                       }]
                   },
                   // Configuration options
                   options: {
                       responsive: true,
                       layout: {
                           padding: 10
                       },
                       legend: { display: false },
                       title:  { display: false },
                       scales: {
                           yAxes: [{
                               scaleLabel: {
                                   display: false
                               },
                               gridLines: {
                                   borderDash: [6, 10],
                                   color: "#d8d8d8",
                                   lineWidth: 1
                               } ,
                               ticks: {
                                   beginAtZero: true,
                                   userCallback: function(label, index, labels) {
                                       if (Math.floor(label) === label) {
                                           return label;
                                       }

                                   },
                               }
                           }],
                           xAxes: [{
                               scaleLabel: { display: false },
                               gridLines:  { display: false }
                           }]
                       },

                       tooltips: {
                           bodyFontFamily : "tahoma" ,
                           backgroundColor: '#333',
                           titleFontSize: 13,
                           titleFontColor: '#fff',
                           bodyFontColor: '#fff',
                           bodyFontSize: 13,
                           displayColors: false,
                           xPadding: 10,
                           yPadding: 10,
                           intersect: false
                       }
                   }
               });
           }else{
               console.log('chart function is not exists !!!');
           }
       }
   }
});

$(function () {
    $(".copy").each(function () {
        var id  = "#"+$(this).attr("id") ;
        $(this).click(function (e) {
            e.preventDefault() ;
            var clipboard = new Clipboard(id, {
                text: function() {
                    return document.querySelector(id).getAttribute('data-url');
                }
            });
            clipboard.on('success', function(e) {
                Snackbar.show({
                    text: 'Copied : '  + $(id).data('url')  ,
                    pos: 'bottom-right',
                    showAction: false,
                    duration: 3000
                });
                e.clearSelection();
            });
        });
    })
});

$(function () {
    var popopen = 0 ;

    $("#popupBtn").click(function (e) {
        e.preventDefault() ;
        var details = $(this).html() ;
        var url = $(this).data("toggle") ;
        popopen += 1 ;

        if( popopen == 1 )
        {
            var popmain = $("<div id='popup_context' class=' popup_context'></div>") ;

            $.ajax({
                url : url ,
                dataType : "TEXT" ,
                type : "GET" ,
                headers : {
                    "X-CSRF-TOKEN" : data.csrf
                } ,
                beforeSend : function () {
                    $(this).html("<div class='loading'></div>") ;
                } ,
                success : function (response) {
                    popmain.append(response) ;
                    $(".title" , popmain).html(details) ;
                    $('body').append(popmain) ;
                }
            });

            popmain.on("click" , ".close" , function () {
                $(".content" , popmain).removeClass('bounceInDown').addClass('bounceOutDown') ;

                setTimeout(function () {
                    popmain.remove() ;
                    popopen = 0 ;
                } , 500 );

            });

            popmain.on('submit' , "form" , function (e) {
                e.preventDefault() ;
                // $("button" , this ).html('<img src="/asset/imgs/loading.gif" />') ;
                var url = $(this).attr('action') ;
                var tags = [] ;

                $("input[name='tags[]']:checked" , this ).each(function () {
                    tags.push( $(this).val() );
                });

                $.ajax({
                    url : url ,
                    dataType : "json" ,
                    type : "POST" ,
                    data : {
                        "tags" : tags
                    } ,
                    headers : {
                      "X-CSRF-TOKEN" : data.csrf
                    },
                    success : function (response) {
                        if ( response.status )
                        {
                            Snackbar.show({
                                text: response.message ,
                                pos: 'bottom-right',
                                showAction: false ,
                                actionText: "Dismiss",
                                duration: 3000,
                                textColor: '#fff',
                                backgroundColor: '#383838'
                            }) ;
                            setTimeout(function () {
                                if (response.url == undefined)
                                    window.location.reload() ;
                                else
                                    window.location.href = response.url ;
                            } , 500 ) ;
                        }
                    },
                    error : function (jqXHR, exception ) {
                        var status = jqXHR.status;
                        if(status == 422) // validate error
                        {
                            response = jqXHR.responseJSON.errors ;
                            for(i in response)
                            {
                                setTimeout(function () {
                                    Snackbar.show({
                                        text: response[i] ,
                                        pos: 'bottom-right',
                                        showAction: false ,
                                        actionText: "Dismiss",
                                        duration: 3000,
                                        textColor: '#fff',
                                        backgroundColor: '#383838'
                                    });
                                },100) ;
                            }
                        }
                    }
                });
            });
        }
    });
});

function  getQueryString() {
    var result = {} ;
    if(! window.location.search.length) return {} ;
    var qs = window.location.search.slice(1) ;
    var parts = qs.split("&") ;
    for( var i = 0 , len = parts.length ; i < len ; i++ )
    {
        var tokens = parts[i].split("=") ;
        if( jQuery.trim(tokens[1]) != "" )
        {
            result[tokens[0]] = decodeURIComponent(tokens[1]) ;
        }
    }

    return result
}

$("form#statusFormChaning").change(function (e) {
    e.preventDefault();
    var qs = getQueryString();
    if  (qs == false)
        qs = {} ;

    $("input[type=checkbox]" , this ).each(function () {
        var checkbox = $(this) ;
        if( checkbox.prop("checked") )
        {
            qs[ checkbox.attr('name') ] = checkbox.val() ;
        }else{
            delete qs[ checkbox.attr('name') ] ;
        }
    });

    $("select" , $(this)).each(function () {
        qs[ $(this).attr('name') ] = $(this).val() ;
    });

    var Query = $.param(qs);
    var currentURL = window.location.href.split('?')[0] ;

    window.location.href = currentURL + "?" + Query ;

});

$(".payment").each(function () {
    var warpper = $(this) ;

    $(".payment-tab input[type=radio]" , this ).each(function () {
        var darbas  = $(this).closest('.payment-tab') ;
        var input   = $("input[type=text],input[type=number]" , darbas ) ;

        if($(this).prop('checked'))
        {
            input.prop('required' , true ) ;
            input.removeAttr('disabled') ;
        }else {
            input.prop('required' , false ) ;
            input.attr('disabled' , 'disabled' ) ;
        }

    });

    $(".payment-tab input[type=radio]" , this ).change(function () {
        $("input[type=text],input[type=number]" , warpper ).prop('required' , false ) ;
        $("input[type=text],input[type=number]" , warpper ).prop('disabled' , true ) ;

        var darbas  = $(this).closest('.payment-tab') ;
        var input   = $("input[type=text],input[type=number]" , darbas ) ;

        if($(this).prop('checked'))
        {
            input.prop('required' , true ) ;
            input.removeAttr('disabled') ;
        }else {
            input.prop('required' , false ) ;
            input.attr('disabled' , 'disabled' ) ;
        }
    });


});

$(function () {
    $('form').validator() ;
});

jQuery('.amount').each(function() {

    $('<div class="amount-nav"><div class="amount-button amount-up">+' +
        '</div><div class="amount-button amount-down">-</div></div>').insertAfter( $('input' , this ) ) ;

    var spinner = jQuery(this),
        input = spinner.find('input[type="number"]'),
        btnUp = spinner.find('.amount-up'),
        btnDown = spinner.find('.amount-down'),
        min  = input.attr('min'),
        max  = input.attr('max');
        step = ( input.attr('step') == undefined  ? 1 : input.attr('step') );

    btnUp.click(function() {
        var oldValue = parseFloat(input.val()) || 0;
        if (oldValue >= max) {
            var newVal = oldValue;
        } else {
            var newVal = oldValue + parseInt(step) ;
        }
        spinner.find("input").val(newVal);
        spinner.find("input").trigger("change");
    });

    btnDown.click(function() {
        var oldValue = parseFloat(input.val());
        if (oldValue <= min) {
            var newVal = oldValue;
        } else {
            var newVal = oldValue - parseInt(step) ;
        }
        spinner.find("input").val(newVal);
        spinner.find("input").trigger("change");
    });

});

document.now =  function( NativeDay ) {

    var date = new Date() ;

    if(NativeDay != undefined)
        date.setDate( date.getDate() - NativeDay );

    var month = '' + (date.getMonth() + 1),
        day = '' + date.getDate()  ,
        year = date.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [year, month, day].join('-');
}


function makeString(length) {
    var text = "";
    var string = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

    for (var i = 0; i < length ; i++)
        text += string.charAt(Math.floor(Math.random() * string.length));

    return text;
}

$(function () {
   $(".code").each(function () {
       var warrper = $(this) ;
       $('.refresh').click(function () {
           $("input" , warrper).val( makeString(10) ) ;
       });
   }) ;
});

$(".selectpicker").selectpicker({
    'size' : 4
}) ;

//** serviceUpgrade **//
$("#serviceUpgrade").each(function () {
    var url = $(this).data('url') ;
    var msg = $(this).data('msg') ;

    $("button.upgradeId" , this).click(function () {
        var Id = $(this).data('id')  ;

        swal({
            title: messages.info ,
            text: msg ,
            type: "warning" ,
            showCancelButton: true,
            confirmButtonText: messages.info_confirmed ,
            cancelButtonText: messages.cancel ,
            closeOnConfirm: false,
            showLoaderOnConfirm: true
        }, function () {
            $.ajax({
                url : url ,
                dataType : "JSON" ,
                method : "GET" ,
                data : {
                   id : Id ,
                } ,
                success : function (response) {
                    swal({
                        title: messages.good_job ,
                        text: response.message ,
                        type:  (response.status == true ) ? "success" : "warning"  ,
                        showCancelButton: false ,
                        showConfirmButton: false
                    });
                    setTimeout(function () {
                        if(response.url != undefined)
                            window.location.href = response.url ;
                        else
                            window.location.reload() ;
                    } , 600 ) ;
                } , error: function (xhr, ajaxOptions, thrownError){
                    swal({
                        title: messages.error ,
                        text: messages.error_msg ,
                        type: "warning" ,
                        showCancelButton: false ,
                        showConfirmButton: false
                    });
                    console.log(e) ;
                }
            })
        });

    }) ;
}) ;

//** serialize to http **//
serialize = function(obj) {
    var str = [];
    for (var p in obj)
        if (obj.hasOwnProperty(p)) {
            str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
        }
    return str.join("&");
} ;

//** pagination **//
$(function() {

    $('body').on('click', '#content .pagination a , #content table thead a', function(e) {
        e.preventDefault();
        var url = $(this).attr('href') ;
        window.history.pushState("", "", url);
        getArticles(url) ;
    });

    $('body').on('submit' , '#content .pagination-container form' , function (e) {
        e.preventDefault() ;
        var QueryString = getQueryString() ;
        QueryString['page'] = $("input",this).val() ;
        var url = "?" + serialize(QueryString) ;
        window.history.pushState("" , "" , url ) ;
        var url = window.location.href ;
        getArticles(url) ;
    });

    $("form#searchService").submit(function (e) {
        e.preventDefault() ;
        var formURI = $(this).attr("action") ;
        var url = $(this).serialize() ;
        url = formURI + "?" + url ;
        window.history.pushState("" , "" , url ) ;
        getArticles(url) ;
    });

    function getArticles(url) {
        NProgress.start() ;
        $.ajax({
            url : url
        }).done(function (data) {
            $('#content').html(data);
        }).fail(function () {
            console.log('سرویس بارگزاری نشده است لطفا بعدا تلاش کنید .');
        });
        NProgress.done() ;
    }
});

//** buyService **//

$(function () {

    $("#buyService").each(function () {

        var buyService = $(this) ;

        var categories = $("#categories" , this );

        $(document).ready(function () {
            categories.show().slick({
                rtl: true ,
                arrows: false,
                responsive: [{
                    breakpoint: 1800,
                    settings: {
                        slidesToShow: 4 ,
                        slidesToScroll: 4
                    }
                },{
                    breakpoint: 1365,
                    settings: {
                        slidesToShow: 4 ,
                        slidesToScroll: 4
                    }
                }, {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                }, {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }]
            });
        });

        $(".category" , categories).click(function () {

            var category = $(this) ;
            var warper = category.closest("label") ;
            var value = $("input[type=radio]" , warper ).val() ;
            var url = window.location.href.split("?")[0] ;
            url += "?category="+ value ;
            window.location.href = url ;
        });

        $("#services" , buyService ).change(function () {
            var QueryString = getQueryString() ;
            QueryString['service'] = $(this).val() ;
            var url = window.location.href.split("?")[0] ;
            url = url + "?" + serialize(QueryString) ;
            window.location.href = url ;
        }) ;

    }) ;

});

//** keyword container **//
$(".keywords-container").each(function() {
    var maxitem = $(this).data("max") ;
    var customName = $(this).data("name") ;
    var keywordInput = $(this).find(".keyword-input");
    var keywordsList = $(this).find(".keywords-list");
    var Button = $(this).find('.keyword-input-button') ;

    // add keyword
    function addKeyword(Input) {
        var isValid = [] ;
        $(".keywords-list .keyword").each(function () {
            isValid.push( $(".keyword-text" , this ).text() == Input )
        });

        if ( $.trim(Input) == "")
            return Snackbar.show({
                        text:  "شما نمیتوانید فیلد خالی وارد نمایید ."  ,
                        pos: 'bottom-right',
                        showAction: false,
                        duration: 3000
                    });

        if ( $.inArray(true , isValid) != -1 )

            Snackbar.show({
                text:  "شما قبلا این آیتم را انتخاب نموده اید."  ,
                pos: 'bottom-right',
                showAction: false,
                duration: 3000
            });

        else
        {

            var keywordCount = $("span.keyword" , keywordsList ).length ;
            if( maxitem-1 < keywordCount)
            {
                Snackbar.show({
                    text:  "شما حداکثر میتوانید "+maxitem+" آیتم انتخاب نمایید."  ,
                    pos: 'bottom-right',
                    showAction: false,
                    duration: 3000
                });
            }else{
                var item = keywordInput.val() ;
                var $newKeyword = $(
                    "<span class='keyword'>" +
                    "<span class='keyword-remove'>" +
                    "</span>" +
                    "<input checked class='hidden' type='checkbox' name='"+customName+"[]' multiple value='"+keywordInput.val()+"' />" +
                    "<span class='keyword-text'>"+
                    keywordInput.val() +
                    "</span>" +
                    "</span>"
                );
                keywordsList.append($newKeyword).trigger('resizeContainer');
            }
        }
        keywordInput.val("");
    }

    Button.on('click', function() {
        var Input = $.trim(keywordInput.val());
        addKeyword(Input );
    });

    keywordInput.on('keyup', function(e) {
        var Input = $.trim(keywordInput.val());
        if ( e.keyCode == 13 )
            addKeyword(Input );
    });

    $(document).on("click", ".keyword-remove", function() {
        $(this).parent().addClass('keyword-removed');
        function removeFromMarkup() {
            $(".keyword-removed").remove();
        }
        setTimeout(removeFromMarkup, 500);
    });
});

//** ToRial string **//
function ToRial(str) {
    str = str.toString() ;
    str = str.replace(/\,/g, '');
    var objRegex = new RegExp('(-?[0-9]+)([0-9]{3})');
    while (objRegex.test(str)) {
        str = str.replace(objRegex, '$1,$2');
    }
    return str;
}

//** buyServiceFormQuantity **//
$(function () {
    var buyServiceFormQuantity = $("form#buyService input[name=quantity]") ;

    buyServiceFormQuantity.each(function () {
        totalQuantity($(this));
    });

    buyServiceFormQuantity.keyup(function () {
        totalQuantity($(this));
    }) ;
    buyServiceFormQuantity.change(function () {
        totalQuantity($(this));
    }) ;

    function totalQuantity(item) {
        var min = item.attr("min") ;
        var max = item.attr("max") ;
        var quantity  = parseInt(item.val()) ;
        if ( min <= quantity && quantity <= max )
        {
            var totalCost = $(".boxed-widget-inner #total-costs span") ;
            var price  = $(".boxed-widget-inner span#price").data('price') ;
            var amount = price / 1000 * quantity ;
            amount = ToRial(amount) ;
            totalCost.text( amount ) ;
        }
    }
});

//** form buy **//
$(function () {
    $('#buyService').validator() ;
}) ;

//** users chart **//

//**  **//
$(function () {
    var topTextSlider = $(".top-nav ul") ;
    topTextSlider.each(function () {
        var warrper = $(this) ;
        $('li:gt(0)',warrper ).hide();
        setInterval(function(){
            $('li:first' , warrper).animate({
                    top:"100px"
                },1000).fadeOut().animate({top:"0"})
                .next('li').fadeIn(1000)
                .end().appendTo(warrper);},
        4000);
    });
});
/** moreStep **/
$(function () {
    document.querySelectorAll(".moreStep").forEach(function (item) {
        var delemiter = item.innerHTML ;
        delemiter = delemiter[0] ;
        setInterval(function () {
            var size = item.innerHTML.length ;
            if (size > 2)
                item.innerHTML = "" ;
            item.innerHTML += delemiter ;
        } , 1000 );
    });
});

/*************************/
/** search trackingCode **/
/*************************/
$(function () {
    $('form#checkTrackingCode').submit(function (e) {
        e.preventDefault() ;
        NProgress.start() ;
        var url = $(this).attr("action") ;
        var data = new FormData( $(this)[0] ) ;

        $.ajax({
            url : url ,
            data : data ,
            dataType : "JSON" ,
            type : "POST" ,
            async: false ,
            cache: false ,
            contentType: false ,
            processData: false ,
            headers : {
                "X-CSRF-TOKEN" : data.csrf
            } ,
            success : function (response){
                if( !response.ok ){
                    response.errors.forEach(function(item){
                        Snackbar.show({
                            text: item ,
                            pos: 'bottom-right',
                            showAction: false,
                            duration: 3000
                        });
                    });
                }else {
                    var html = "" ;
                    for ( value in response) {
                        if (value === 'ok'){continue;}
                        html += `<label><b>${value} : </b>${response[value]}</label>`;
                    }
                    var showFactor = $("#showFactor") ;
                    $(".content" , showFactor).html(html) ;
                    showFactor.removeClass("dialog-close").addClass("dialog-open") ;
                }
                NProgress.done() ;
            } ,
            error: function(xhr){
                NProgress.done() ;
            }
        });
    })
});
// modal
$(function(){
    $(".dialog").each(function () {
        var modal = $(this).attr("v-modal") ;
        var content = $(this) ;
        $("#"+modal).click(function (e) {
            e.preventDefault() ;
            if (content.hasClass("dialog-open"))
            {
                content.removeClass("dialog-open").addClass("dialog-close") ;
            }else {
                content.addClass("dialog-open").removeClass("dialog-close") ;
            }
        });
        $('.dialog-overlay').click(function(){
            content.removeClass("dialog-open").addClass("dialog-close") ;
        });
    });
}) ;

$(function () {
    $("#ContactFormSite").validator().submit(function (e) {
        if (!e.isDefaultPrevented()) {
            e.preventDefault() ;
            var data = $(this).serialize() ;
            $.ajax({
                url : $(this).attr("action") ,
                type: "POST",
                dataType : "JSON" ,
                headers: {
                    "X-CSRF-TOKEN": data.csrf
                },
                data : data ,
                success : function (response) {
                    $("#captcha #refresh").click()


                } , error : function ( t ) {
                    if(t.status == 422 ){
                        for (i in response = t.responseJSON.errors, response) {
                            $("[name='" + i + "']", e).closest(".form-group").addClass("has-error has-danger") ;
                            setTimeout(function() {
                                Snackbar.show({
                                    text: response[i],
                                    pos: "bottom-right",
                                    showAction: !1,
                                    actionText: "Dismiss",
                                    duration: 3e3,
                                    textColor: "#fff",
                                    backgroundColor: "#383838"
                                }) ;
                            }, 100)
                        }
                    }
                    $("#captcha #refresh").click()
                }
            })
        }

    });
});

$(function() {
    $("#captcha").each(function() {
        var t = $("img", this);
        $("#refresh", this).click(function() {
            $(this).closest(".form-group").find("input").val(""), NProgress.start(), t.attr("src", t.attr("src") + "?" + Math.random()), NProgress.done()
        })
    })
});

function searchGroup(InputName , BodyName){
    var input, filter, ul, li, label, i ;
    input = InputName ;
    filter = input.value.toUpperCase();
    ul = document.getElementById(BodyName);
    li = ul.getElementsByTagName('li');
    // Loop through all list items, and hide those who don't match the search query
    for (i = 0; i < li.length; i++) {
        label = li[i].getElementsByTagName("a")[0];
        if (label.innerHTML.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";
        }
    }
}

$(function () {
    var readURL=function(input , wrapper){
        if(input.files&&input.files[0]){
            var reader = new FileReader();
            reader.onload= function(e){
                $('.profile-pic' , wrapper).attr('src',e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    };

    $(".file-upload").on('change',function(){
        var wrapper = $(this).closest(".avatar-wrapper") ;
        readURL(this , wrapper);
    });

    $(".avatar-wrapper").each(function(){
        var wrapper = $(this) ;
        $(".upload-button" , this ).on('click',function(){
            $(".file-upload" , wrapper).click();
        });
    });

});

