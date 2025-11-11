<?php

Yii::import('application.helpers.CArray');
Yii::import('ext.image.Image');

class ImageProcessService extends Image {


    function resizeToMinSide($width, $height) {
        $necessaryAR = $width / $height;
        $aspectRatio = $this->width / $this->height;

        // crop to aspect ratio
        if ($aspectRatio < $necessaryAR)  // высота выше требуемой
        {
            $new_width  = $this->width;
            $new_height = floor($this->width * 1/$necessaryAR);
        }
        else
        {
            $new_width  = floor($this->height * $necessaryAR);
            $new_height = $this->height;
        }
        $this->crop($new_width, $new_height);

        // resize
        if ($new_width > $width && $new_height > $height) {
            $this->resize($width, $height);
        }

        return $this;
    }

    function resizeToMaxSide($width, $height) {
        if ($this->width<=$width && $this->height<=$height){
            return $this;
        }

        $aspectRatio = $this->width / $this->height;
        $necessaryAR = $width / $height;

        if ($aspectRatio > $necessaryAR) {
            $new_width  = $width;
            $new_height = floor($width * 1/$necessaryAR);
        }
        else {
            $new_width  = floor($height * $necessaryAR);
            $new_height = $height;
        }

        $this->resize($new_width, $new_height);

        return $this;
    }

    function resizeToWidth($width) {
        if ($this->width<=$width){
            return $this;
        }

        $aspectRatio = $this->width / $this->height;
        $height = floor($width * 1/$aspectRatio);

        $this->resize($width, $height);

        return $this;
    }



}