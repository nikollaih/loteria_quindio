<?php
/**
* Descripcion: Create a new file copy for images
* @author: Nikollai Hernandez <nikollaihernandez@gmail.com>
* @param: String $name -> Original picture name
* @param: String $img_type -> Image extension (.jpg, .png, .gif, .jpeg...)
* @param: String $dir -> Picture parent folder
* @return:
*/
    function createThumb($name, $img_type, $dir, $square = false){
        
        list($w_src, $h_src, $type) = getimagesize($dir.$name);

        $proporcion = $h_src / $w_src;

        switch ($img_type){
            case 'gif':   //   gif -> jpg
                $img_src = imagecreatefromgif($dir.$name);
            break;
            case 'png':  //   png -> jpg
                $img_src = imagecreatefrompng($dir.$name);
            break;
            case 'jpeg' || 'jpg':   //   jpeg -> jpg
                $img_src = imagecreatefromjpeg($dir.$name); 
            break;
            default:  //   jpeg -> jpg
                $img_src = imagecreatefromjpeg($dir.$name); 
            break;
            
        }

        $size_t_h = 150;

        
        if($square){
            if($w_src > $h_src){
                $size = $h_src;
                $crop_x     =   ceil(($w_src - $h_src) / 2);
                $crop_y     =   0;
            }
            else{
                $size = $w_src;
                $crop_x = 0;
                $crop_y = ceil(($h_src - $w_src) / 2);
            }

            $img_dst_t = imagecreatetruecolor($size, $size);  //  resample (70x70)
            imagecopyresampled($img_dst_t, $img_src, 0, 0, $crop_x, $crop_y, $size, $size, $size, $size);
        }
        else{
            $img_dst_t = imagecreatetruecolor(($square) ? $size_t_h : $size_t_h / $proporcion, $size_t_h);  //  resample (70x70)
            // Thumbs de tamaño s ======================================================
            imagecopyresampled($img_dst_t, $img_src, 0, 0, 0, 0, ($square) ? $size_t_h : $size_t_h / $proporcion, $size_t_h, $w_src, $h_src);
        }


        imagejpeg($img_dst_t, $dir.'s'.$name, 200);    //  save new image

        imagedestroy($img_dst_t);
        // // Fin ========================================================================

        imagedestroy($img_src);
        unlink($dir.$name); 
    }
?>