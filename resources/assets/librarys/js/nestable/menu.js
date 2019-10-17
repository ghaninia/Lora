$('.accordion .item .heading').click(function() {
    var a = $(this).closest('.item');
    var b = $(a).hasClass('open');
    var c = $(a).closest('.accordion').find('.open');
    if(b != true) {
        var content = $(c).find('.content') ;
        $(content).slideUp(200);
        $('input' , content).attr('disabled' , true );
        $(c).removeClass('open');
    }
    $(a).addClass('open');
    $(a).find('.content').slideDown(200);
    $('input' , a ).removeAttr('disabled') ;
});

/*
* append item in menu
*/
$("#menu #add_menu_item").submit(function (e) {
    NProgress.start();
    e.preventDefault() ;
    var item = $('.accordion',this).find('.open') ;
    var type = $("input[name='type']" , item ).val() ;
    if(type == 'posts' || type == 'terms')
    {
        var lists = [] ;
        var checked = $("input[type='checkbox']:checked" , item );
        checked.each(function() {
            var list = [] ;
                list.name = $(this).closest('li').find("a").text() ;
                list.type = type ;
                list.type_id = $(this).val() ;
                list.description = "" ;
                list.class = "" ;
                list.icon = "" ;
            lists.push(list) ;
        });

        checked.each(function(){
            this.checked = false;
        });
        if(lists.length == 0){ // empty ids
            NProgress.done();

            return false ;
        }
        // id just terms and posts argument two = true
    }else{
        var link = $('input[name="link"]' ,item ) ;
        var title = $('input[name="title"]' , item) ;
        if( $.trim(link.val()).length == 0 || $.trim(title.val()).length == 0){ //empty field
            NProgress.done();
            return false ;
        }
        var lists = [] ;
        lists.name = title.val() ;
        lists.link = link.val() ;
        lists.type = type ;
        lists.description = "" ;
        lists.class = "" ;
        lists.icon = "" ;
    }
    createItemAndSave(lists , true ) ;

    NProgress.done() ;
});

function createItemAndSave(lists , typo ){
    var place = $("#menu #nestable ol").first() ;
    if(typo && lists.length > 0)
    {
        for(var i = 0 ; i < lists.length ; i++ )
        {
            var li = $("<li class='dd-item'></li>");
            li.data('class' , lists[i]['class'] ) ;
            li.data('icon' , lists[i]['icon'] ) ;
            li.data('description' , lists[i]['description'] ) ;
            li.data('type_id' , lists[i]['type_id'] ) ;
            li.data('type' , lists[i]['type'] ) ;
            li.data('name' , lists[i]['name'] ) ;

            li.append("<div class='dd-handle'>"+lists[i]['name']+"</div>") ;
            li.append('<a class="menuItemEdit dd-edit icon-feather-edit-3\n"></a>') ;
            li.append('<a data-action="%s" class="menuItemDelete dd-delete icon-feather-trash"></a>') ;
            place.append(li) ;
        }
    }else{
        var li = $("<li class='dd-item'></li>");
        li.data('class' , lists.class ) ;
        li.data('icon' , lists.icon ) ;

        li.data('description' , lists.description) ;
        li.data('link' , lists.link ) ;
        li.data('type' , lists.type) ;
        li.data('name' , lists.name) ;

        li.append("<div class='dd-handle'>"+lists.name+"</div>") ;
        li.append('<a class="menuItemEdit dd-edit icon-feather-edit-3\n"></a>') ;
        li.append('<a data-action="%s" class="menuItemDelete dd-delete icon-feather-trash"></a>') ;
        place.append(li) ;
    }

    menuOutput() ;
    return false ;
}

var updateOutput = function (e) {

};

function menuOutput() {
    output = $('#menu #output') ;
    if (window.JSON) {
        if (output) {
            output.val(window.JSON.stringify( $("#menu #nestable").nestable('serialize') ) );
        }
    } else {
        alert('JSON browser support required for this page.');
    }
}

$('#nestable').nestable({
    maxDepth: 4
}).on('change', menuOutput );
$(function () { menuOutput() ;});


$("body").on("click" , ".menuItemEdit" , function (e) {
    e.preventDefault() ;
    var item = $(this);
    var item = item.closest('li').first() ;
    item.toggleClass('active') ;
    if (item.hasClass("active")) {
        var type = item.data('type') ;
        var name = item.data('name') ;
        var description = item.data('description')  ;
        var classCss = item.data('class')  ;
        var icon = item.data('icon')  ;

        /**html append***/
        /*******/
        var html = $("<form class='dd-handle-form'></form>") ;
        if ( type == 'links') {
            var link = item.data('link');
            html.append('<div class="submit-field"><h5 class="input-group-addon">لینک پیوند</h5><div class="form-group"><input dir="ltr" id="link" value="'+link+'" class="form-control form-control-sm"><i class="form-group__bar"></i></div></div>');
        }
        html.append('<div class="submit-field"> <h5 class="input-group-addon">تیتر</h5><div class="form-group"><input id="name" value="'+name+'" class="form-control form-control-sm"> <i class="form-group__bar"></i> </div> </div>');
        html.append('<div class="submit-field"> <h5 class="input-group-addon">توضیحات</h5> <div class="form-group"> <input id="description" value="'+description+'" class="form-control form-control-sm"> <i class="form-group__bar"></i> </div> </div>');
        html.append('<div class="submit-field"> <h5 class="input-group-addon">کلاس css</h5> <div class="form-group"> <input dir="ltr" id="classCss" value="'+classCss+'" class="form-control form-control-sm"> <i class="form-group__bar"></i> </div> </div>');
        html.append('<div class="submit-field"> <h5 class="input-group-addon">آیکون</h5> <div class="form-group"> <input dir="ltr" id="icon" value="'+icon+'" class="form-control form-control-sm"> <i class="form-group__bar"></i> </div> </div>');

        html.append('<div><button class="button ripple-effect margin-bottom-5">ذخیره تغییرات</button></div>');
        /*******/
        $('.dd-handle' ,item).first().after(html); // بعد از کلاس این در هر ایتم اضافه کن
        $(html).submit(function (e) {
            e.preventDefault() ;
            var name = $('input#name' , html ).val() ;
            $('.dd-handle' ,item).first().text(name) ;
            item.data("name" , name );

            var description = $('input#description' , html ).val() ;
            item.data("description" , description ) ;

            var classCss = $('input#classCss' , html ).val() ;
            item.data("class" , classCss ) ;

            var icon = $('input#icon' , html ).val() ;
            item.data("icon" , icon ) ;

            if ( type == 'links') {
                item.data("link" ,  $('input#link' , html ).val() );
            }
            menuOutput() ;
            alert('فرم با موفقیت ویرایش گردید.');
        });
    }else{
        $("form" , item).first().remove()
    }
});

$("body").on("click" , ".menuItemDelete" , function (e) {
    e.preventDefault() ;
    var item = $(this) ;
    var item = item.closest('li').first() ;
    item.remove() ;
    menuOutput() ;
});
