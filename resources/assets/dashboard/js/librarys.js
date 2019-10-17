require("../../librarys/js/nestable/nestable");
require("../../librarys/js/nestable/menu") ;
require("../../librarys/js/datepicker/datepicker") ;
require("../../librarys/js/chart/chart.min") ;
require("../../librarys/js/sweetalert/sweetalert") ;

$(function(){
    $(".calender").each(function () {
        var calender = $(this) ;
        var valField = $("input" , calender ) ;

        if (valField.val().trim() == "")
            var valField = document.now() ;
        else
            var valField = valField.val() ;

        $(".body" , calender ).datepicker({
            altSecondaryField : $("input" , calender ) ,
            date : valField ,
            gregorian : false
        });
    });
});

/*
* slug proccesor
*/
$(function () {
    $("input#createSlug").each(function () {
        var token = $("meta[name='csrf-token']").attr("content") ;
        var input = $(this) ;
        var action = $(this).data("action") ;
        var type = $(this).data("type") ;
        var oldSlug = $(this).data("slug")  ;
        var slugInputName = "slug" ;
        var placeHoldSlug = $("#slug-permalink") ; // جایی درج درخواست

        if ( input.val().length > 0 ){
            var htmlForm =  htmlComponent( slugInputName , "" ,oldSlug ) ;
            placeHoldSlug.html(htmlForm) ;
        }else{
            input.change(function () {
                if ( $(this).val().length > 0 ){
                    createSlug( $(this).val() , type , function (response) {
                        var htmlForm =  htmlComponent( slugInputName , "" , response ) ;
                        placeHoldSlug.html(htmlForm) ;
                        NProgress.done() ;
                    });
                }
            });
        }

        placeHoldSlug.on( "click" , "button" ,function () {
            var closer = $(this).closest("div.slugWrapper") ;
            var input = $("input" , closer ) ;
            var span = $("span" , closer ) ;
            input.toggleClass("hidden") ;
            if( $(this).text() == "ثبت" ) {
                var result = createSlug( input.val() , type , function (response) {
                    span.text(response) ;
                    NProgress.done() ;
                });
            }
            ( $(this).text() == "ویرایش" ) ? $(this).text("ثبت") :  $(this).text("ویرایش") ;
        });

        function htmlComponent( slugInputName , url , slug ) {
            var slug = slug || "" ;
            return `
                <div class="slugWrapper">
                    ${ url } 
                    <span class="text-primary">${ slug }</span>
                    <input class="hidden" type="text" id="slug" name="slug" value="${ slug }" autocomplete="off">
                    <button type="button" class="edit-slug btn btn-sm btn-secondary">ویرایش</button>
                </div>
           `;
        }

        function createSlug( inputVal , inputType , callback) {
            NProgress.start() ;
            return $.post( action ,  {
                _token : token ,
                name : inputVal ,
                type : inputType
            }).done( callback );
        }

    });
});

