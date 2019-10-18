<?php
namespace App\Repositories ;
use Illuminate\Support\Facades\File;
use Image;

class Picture
{
    protected static $path = "uploads" ;
    protected static $thumbPathName = "thumb" ;
    protected static $root = "public" ;
    protected static $format = ['image/jpeg','image/png','image/jpg'] ;

    /**
     * @param $picture "string"
     * @param array $size
     * @return mixed
     */
    public static function create($picture ,array $size = ["thumb" , "full"])
    {
        if(request()->hasFile($picture)){
            $picture = request()->file($picture) ;
            $ReturnPath = [] ;
            $fileName = static::folderUpload( $picture ) ;
            $resize = [] ;

            if( in_array($picture->getClientMimeType() , static::$format ) )
            {

                if(in_array("thumb" , $size )){
                    $resize["thumb"] = [
                        "h" => config("dashboard.thumb_height") ,
                        "w"  => config("dashboard.thumb_width")
                    ];
                    Image::make($picture)->resize($resize["thumb"]["w"] , $resize["thumb"]["h"] )->save($fileName["thumb"]) ;

                    $ReturnPath["thumb"] = str_replace( DIRECTORY_SEPARATOR , "/" , str_replace(base_path() , "" , $fileName["thumb"]) ) ;
                }
                if (in_array("full" , $size)){
                    Image::make($picture)->save($fileName["full"]) ;
                    $ReturnPath["full"] = str_replace(DIRECTORY_SEPARATOR , "/" , str_replace(base_path() , "" , $fileName["full"]) ) ;
                }
                return $ReturnPath;
            }
        }
        return null ;
    }

    private static function folderUpload($picture = null)
    {
        $name = null ;
        if(! is_null($picture)){
            $name  = DIRECTORY_SEPARATOR ;
            $name .= time() ;
            $name .= "-" ;
            $name .= $picture->getClientOriginalName() ;
        }
        if(static::$root == "public"){
            $path  =  static::$path ;
            $thumbPath = $path.DIRECTORY_SEPARATOR.static::$thumbPathName ;

            if(!File::exists($path))
                File::makeDirectory( $path , 0777   , true ) ;
            if(! File::exists($thumbPath)){
                File::makeDirectory( $thumbPath, 0777   , true );
            }
            return [
                "full" => $path.(!is_null($name) ? $name : null ),
                "thumb"=> $thumbPath.(!is_null($name) ? $name : null )
            ] ;
        }
    }

    public static function get($pictures , $size = "thumb")
    {
        if( isset($pictures[$size]) ){
            return asset($pictures[$size]) ;
        }
        return $pictures ;
    }

    public static function delete($pictures = null)
    {
        if(static::$root == "public"){
            if(!! $pictures && is_array($pictures)){
                foreach ($pictures as $pic ){
                    $str = str_replace("/" , DIRECTORY_SEPARATOR , $pic ) ;
                    if(File::exists($str))
                        unlink($str) ;
                }
            }
        }
    }

    public static function uploadFolderDelete()
    {
        if(static::$root == "public"){
            File::deleteDirectory(static::$path  , true ) ;
        }
    }

}