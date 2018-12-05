var data =  {
    "csrf" : $("meta[name='csrf-token']").attr('content')
};

$(function () {
    var messages = {
        "cancel" : "بیخیال" ,
        "info" : "هشدار" ,
        "good_job" : 'کار خوب پیش رفت' ,
        "error" : "اختلال در سیستم" ,
        "error_msg" : "متاسفانه خطای غیر منتظره ای رخ داده ." ,
        'info_confirmed' : "بله مطمئن هستم" ,
        "link_delete" : "آیا میخواهید لینک دانلود را حذف نمایید ؟" ,
    };

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
/***************************/
//** checkbox select all **//
/***************************/
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
/********************/
//** chart table  **//
/********************/
function CreateChart(id,lables,data , label ) {
    var label = (typeof label === 'undifined' ? 'views' : label ) ;
    if(typeof Chart === 'function')
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
//***************//
//** copy link **//
//***************//
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
///////////////////////////
//**** append tags  *****//
///////////////////////////
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
//** ثبت فرم جستجو **//

function  getQueryString() {
    var result = {} ;
    if(! window.location.search.length) return false ;
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
//** form changing **//
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
//** payment discount credit **//
$(".payment").each(function () {
    var warpper = $(this) ;

    $(".payment-tab input[type=radio]" , this ).each(function () {
        var darbas  = $(this).closest('.payment-tab') ;
        var input   = $("input[type=text]" , darbas ) ;

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
        $("input[type=text]" , warpper ).prop('required' , false ) ;
        $("input[type=text]" , warpper ).prop('disabled' , true ) ;

        var darbas  = $(this).closest('.payment-tab') ;
        var input   = $("input[type=text]" , darbas ) ;

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

// validator
$(function () {
    $('form#credit').validator() ;
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
        var oldValue = parseFloat(input.val());
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

///////////////////
//* format date *//
///////////////////
function now( NativeDay ) {

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

///////////////////
//* make String *//
///////////////////
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