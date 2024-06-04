<?php

class Seme_Imageresize {
    private $image_resource;
    private $height;
    private $width;
    private $longest_side;
    public $quality = -1;

    public function __construct()
    {
        $this->image_resource = null;
        $this->height = null;
        $this->width = null;
        $this->longest_side = null;
    }

    private function beforeSaveToFile()
    {
        if (is_null($this->image_resource)) return false;
        if (!is_resource($this->image_resource)) return false;

        return true;
    }

    public function load($source)
    {
        $image = null;
        
        $info = getimagesize($source);
        if ($info['mime'] == 'image/jpeg') 
            $image = imagecreatefromjpeg($source);
    
        elseif ($info['mime'] == 'image/gif') 
            $image = imagecreatefromgif($source);
    
        elseif ($info['mime'] == 'image/png') 
            $image = imagecreatefrompng($source);

        $this->image_resource = $image;

        return $this;
    }

    private function calcuateWH($width, $height)
    {
        $this->width = intval($width);
        $this->height = intval($height);

        $this->longest_side = $width;
        if ($height >= $width) {
            $this->longest_side = $height;
        }

        return $this;
    }

    public function resize($width, $height = '', $mode = 'fill', $crop_center = true)
    {
        if (intval($height) <= 0)
            $hight = $width;
        $this->calcuateWH($width, $height);
        if ($crop_center == true) {
            $this->image_resource = imagescale($this->image_resource, $this->longest_side);
        } else {
            $this->image_resource = imagescale($this->image_resource, $this->width, $this->height);
        }

        return $this;
    }

    public function saveToFile($destination)
    {
        if ($this->beforeSaveToFile() && imagejpeg($this->image_resource, $destination, $this->quality)) {
            return $destination;
        } else {
            return false;
        }
    }
}