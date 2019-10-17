const mix = require('laravel-mix');

/****************/
/*** librarys ***/
/****************/
mix.styles([
    "resources/assets/librarys/css/fonts.css" ,
    "resources/assets/librarys/css/icons.css" ,
    "resources/assets/librarys/css/bootstrap-grid.css" ,
    "resources/assets/librarys/css/lightbox.css" ,
    "resources/assets/librarys/css/animate.min.css"
] , 'public/assets/librarys/css/app.css') ;
mix.copyDirectory("resources/assets/librarys/fonts" , "public/assets/librarys/fonts") ;
mix.copyDirectory("resources/assets/librarys/imgs" , "public/assets/librarys/imgs") ;

/**********/
/** auth **/
/**********/
mix.styles(["resources/assets/auth/css/app.css"] ,'public/assets/auth/css/app.css') ;
mix.js('resources/assets/auth/js/app.js', 'public/assets/auth/js/app.js');

/*****************/
/*** dashboard ***/
/*****************/

mix.styles([
    "resources/assets/dashboard/css/app.css" ,
    "resources/assets/librarys/js/datepicker/datepicker.css" ,
    "resources/assets/librarys/js/sweetalert/sweetalert.css" ,
] ,'public/assets/dashboard/css/app.css') ;

mix.js("resources/assets/dashboard/js/app.js" , "public/assets/dashboard/js/app.js") ;
mix.js("resources/assets/dashboard/js/librarys.js" , "public/assets/dashboard/js/librarys.js") ;

mix.copyDirectory("resources/assets/dashboard/css/colors" , "public/assets/dashboard/css/colors") ;

/************/
/** errors **/
/************/

mix.styles(["resources/assets/errors/css/app.css"] ,'public/assets/errors/css/app.css') ;
