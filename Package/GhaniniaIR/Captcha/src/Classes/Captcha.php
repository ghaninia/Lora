<?php
namespace GhaniniaIR\Captcha\Classes ;
use Faker\Factory;
use Image ;

class Captcha
{
    private static $fontFoler = "/fonts/" ;
    private static $prefix = "packCaptcha" ;
    private static function randomString($len=5)
    {
        $token = random_int(10000,99999) ;
        return $token;
    }

    private static function fonts()
    {
        $fonts = glob(__DIR__.self::$fontFoler . "*.ttf") ;
        return $fonts ;
    }

    private static function sessionCreate($text)
    {
        session()->push(static::$prefix , strtolower($text) ) ;
    }

    public static function show($vendors = [])
    {
        $text_colors = isset($vendors['text_colors']) ? $vendors['text_colors'] : [ "#FF3633" , "#FFAF33" ] ;
        $background  = isset($vendors['background']) ? $vendors['background'] : "#fff" ;
        $randomString = isset($vendors['text_size']) ? self::randomString($vendors['text_size']) : self::randomString(5) ;
        $pic_width  = isset($vendors['pic_width'])  ?  $vendors['pic_width']  : config("captcha.pic_width") ;
        $pic_height = isset($vendors['pic_height']) ?  $vendors['pic_height'] : config("captcha.pic_height") ;
        $text_size  = isset($vendors['text_size']) ? $vendors['text_size'] : config('captcha.text_size') ;
        $fonts = self::fonts() ;
        self::sessionCreate($randomString) ;
        $randomString = strtoupper($randomString) ;

        $image = Image::canvas($pic_width , $pic_height) ;
        if (!!$background)
        {
            $image = $image->fill($background) ;
        }else{
            $image = $image->opacity(0) ;
        }

        $posX = floor( ( $pic_width - ( $text_size * strlen($randomString) ) ) / 2 )   ;
        $posY = floor( ceil( $pic_height / 2 ) + ( $text_size / 2.5 ) ) ;

        for ($i = 0 ; $i < 100 ; $i++ )
        {
            $image->circle( random_int(1,30) , random_int(0, $pic_height * 3 ) , random_int(0 , $pic_width * 3 ) , function ($draw){
                $draw->background( array_random(["#eee" , "#fafafa" , "#f4f4f4" , "bababa"]) );
            });
        }

        for ($i = 0 ; $i < strlen($randomString) ; $i++ )
        {

            $posX += $text_size - 7 ;
            $image->text($randomString[$i], $posX ,$posY, function($font) use ($fonts , $text_size , $text_colors ) {
                $font->file( array_random($fonts) );
                $font->size($text_size);
                $font->color(array_random($text_colors));
                $font->align('center');
            });
        }



        return $image->response("png") ;

    }

    public function src()
    {
        return route(config("captcha.route_name")) ;
    }
    
    public static function compare($text)
    {
        $sessions = session()->get(static::$prefix) ;
        if (is_array($sessions) && is_string($text))
        {
            $searchSession = array_search($text , $sessions ) ;
            if($searchSession !== false )
            {
                unset($sessions[$searchSession]) ;
                session()->put([static::$prefix => $sessions ]) ;
                return true ;
            }
        }
        return false ;
    }
}
