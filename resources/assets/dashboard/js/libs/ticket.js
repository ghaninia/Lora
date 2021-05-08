$(function () {
    "use strict";
    $("#message").each(function () {

        var warpper = $(this)  ;
        var side = $('#side' , warpper ) ;
        var content = $("#content" , warpper) ;
        var load = $('<div class="load"></div>') ;
        var csrf = $("meta[name='csrf-token']").attr("content") ;
        var baseUrl = $('meta[name="ticket-url"]').attr("content") ;

        jQuery.ajaxSetup({
            cache : true ,
            headers : {
                "X-CSRF-TOKEN" : csrf
            }
        });

        side.on('click', "li" ,function (e) {
            e.preventDefault() ;
            side.find("li.active-message").removeClass("active-message") ;
            $(this).addClass("active-message") ;
            var trakingCode = $(this).data('id') ;
            if(content.find(".load").length == 0 )
            {
                content.append(load) ; // namayesh load
                $.ajax({
                    url : baseUrl+"/content",
                    dataType : "TEXT" ,
                    type : "POST" ,
                    data : {
                        "traking_code" :  trakingCode
                    }
                }).then(function(data) {
                    content.find('.load').remove() ;
                    content.html(data) ;
                    reScript();
                });
            }
            return false ;
        });

        $("input#search" , warpper ).keyup(function (e) {
            if ( e.keyCode == 13 )
            {
                var value = $(this).val() ;
                if(side.find(".load").length == 0 )
                {
                    side.append(load) ; // namayesh load
                    $.ajax({
                        url : baseUrl+"/side",
                        dataType : "TEXT" ,
                        type : "POST" ,
                        data : {
                            "search" :  value
                        }
                    }).then(function(data) {
                        side.find('.load').remove() ;
                        side.html(data) ;
                        reScript();
                    });
                }
            }
            return false ;

        });

        content.on("click" , '.changestatus' , function (e) {
            e.preventDefault() ;
            var confirmed = confirm("آیا میخواهید این تیکت را ببندید ؟") ;
            if(confirmed)
            {
                var id = $(this).data('id') ;
                $.ajax({
                    dataType : "JSON" ,
                    type : "POST" ,
                    url : baseUrl+"/changestatus" ,
                    data : {
                        'tracking_code' : id
                    } ,
                    success : function (response) {
                        Snackbar.show({
                            text: response.message ,
                            pos: 'bottom-right',
                            showAction: false,
                            duration: 3000
                        });
                        $("li[data-id='"+id+"']", side ).click() ; // refresh content
                    }
                });

            }
        });

        content.on("submit" , "form.replayMessage" , function (e) {
            e.preventDefault() ;
            var url = $(this).attr('action') ;
            var trackingCode = $("input[name='tracking_code']").val() ;
            $.ajax({
                url : url ,
                dataType : "json" ,
                type : "POST" ,
                data : {
                    'tracking_code' : trackingCode ,
                    'message' : $("textarea[name='message']").val()
                } ,
                success : function (response) {
                    $("li[data-id='"+trackingCode+"']", side ).click() ;
                    $("textarea[name='message']").val("") ;
                    return true ;
                }
            })
        });

        var popopen = 0 ;
        warpper.on('click' , '.append' , function (e) {
            if(popopen === 0)
            {
                popopen += 1 ;
                var action = new Array() ;

                var popmain = $("<div id='popup_context' class=' popup_context'></div>") ;

                $.ajax({
                    url : baseUrl + "/append" ,
                    dataType : "TEXT" ,
                    type : "GET" ,
                    beforeSend : function () {
                        $(this).html("<div class='loading'></div>") ;
                    } ,
                    success : function (response) {
                        popmain.append(response) ;
                        $('body').append(popmain) ;
                        $("select" , popmain).selectpicker({
                            size: 4
                        }) ;
                    }
                });

                popmain.on("change" , "input[name=to_type]" , function () {
                    var toType = $(this).val() ;

                    if (action[toType] != undefined )
                    {
                        $("#to_id .insert" , popmain ).html( action[toType] ) ;
                        $("select" , popmain).selectpicker({
                            size: 4
                        }) ;
                    }else{
                        $.ajax({
                            url : baseUrl + "/append" ,
                            dataType : "html" ,
                            type : "GET" ,
                            data : {
                                'to_type' : toType
                            } , success : function (response) {
                                var response = $(response) ;
                                action[toType] = response ;
                                $("#to_id" , popmain ).removeClass('hidden');
                                $("#to_id .insert" , popmain ).html( response ) ;

                                $("select" , popmain).selectpicker({
                                    size: 4
                                }) ;
                            }
                        }) ;
                    }
                });

                popmain.on("click" , ".close" , function () {
                    $(".content" , popmain).removeClass('bounceInDown').addClass('bounceOutDown') ;

                    setTimeout(function () {
                        popmain.remove() ;
                        popopen = 0 ;
                    } , 500 );

                });

                popmain.on('submit' , "form#ticketAppendStore" , function (e) {
                    e.preventDefault() ;

                    var datas =
                    {
                        "subject" : $("#subject" , popmain).val() ,
                        "priority" : $("input[name=priority]:checked").val() ,
                        "from_type" : $("input[name=from_type]:checked").val() ,
                        "to_type" : $("input[name=to_type]:checked").val() ,
                        "to_id" : $("select[name=to_id]").val() ,
                        "message" : $("#message" , popmain).val()
                    } ;

                    $.ajax({
                        url : baseUrl + "/append" ,
                        dataType : "JSON" ,
                        type : "POST" ,
                        data : datas ,
                        error : function (jqXHR, exception ) {
                            var status = jqXHR.status;
                            if(status == 422) // validate error
                            {
                                var response = jqXHR.responseJSON.errors ;
                                for(var i in response)
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
                        } ,
                        success : function (response) {
                            if(response.status == true)
                                Snackbar.show({
                                    text: response.message ,
                                    pos: 'bottom-right',
                                    showAction: false ,
                                    actionText: "Dismiss",
                                    duration: 3000,
                                    textColor: '#fff',
                                    backgroundColor: '#383838'
                                });
                            setTimeout(function () {
                                location.reload() ;
                            },1000);
                        }
                    }) ;
                });

            }
        }) ;
    });
});
