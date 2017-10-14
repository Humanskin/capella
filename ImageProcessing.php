<?php

class ImageProcessing
{
    public $imageExtension;
    public $height, $width;
    public $imagePath = null;

    private $imagick;
	
	private $validExtensions = array('png', 'gif', 'jpeg');

    public function __construct()
    {
        $this->imagick = new Imagick();
    }

    /**
     * @param {String} $path local path to image
     * @throws Exception
     */
    public function readImage($path)
    {
		$readResult = @$this->imagick->readImage($path);
        if($readResult == false){
            throw new Exception("Invalid image path.");
        }
        $this->imageExtension = $this->imagick->getImageFormat();
        if(!$this->isValidExtension($this->imageExtension)) {
            throw new Exception("Unsupported Extension");
        }
        $this->recalculateDimensions();
    }

    /**
     * @param {int} $cropWidth
     * @param {int} $cropHeight
     * @param {int} null $x crop x
     * @param {int} null $y crop y
     */
    public function cropImage($cropWidth, $cropHeight, $x = null, $y = null)
    {
        if($cropWidth == null || $cropHeight== null) {
            throw new Exception("Uncorrected input dimensions");
        }
        if ($x == null && $y == null) {
            $this->resizeImage(null, $cropHeight);
            $x = $this->width / 2 - $cropWidth / 2;
            $this->imagick->cropImage($cropWidth, $cropHeight, $x, 0);
        }
        else {
            $this->imagick->cropImage($cropWidth, $cropHeight, $x, $y);
        }
        $this->recalculateDimensions();
    }

    /**
     * @param {int} $resizeWidth
     * @param {int} $resizeHeight
     */
    public function resizeImage($resizeWidth, $resizeHeight)
    {
        if($resizeWidth == null && $resizeHeight == null) {
            throw new Exception("Uncorrected input dimensions");
        }
        if($resizeWidth == null) {
            $k = $resizeHeight / $this->height;
            $this->imagick->scaleImage($this->width * $k, $resizeHeight);
        }
        else {
            $k = $resizeWidth / $this->width;
            $this->imagick->scaleImage($resizeWidth, $this->height * $k);
        }
        $this->recalculateDimensions();
    }

    /**
     * output image in browser
     */
    public function echoImage()
    {
        header('Content-Type: image/'.$this->imageExtension);
        echo $this->imagick->getImageBlob();
    }
		
    /**
     *
     * @param {String} $extension we want to validate
     * @return bool
     */
    private function isValidExtension($extension)
    {
        $extension = strtolower($extension);
        return in_array($extension, $this->validExtensions);
    }

    /**
     * calculate image dimensions
     */
    private function recalculateDimensions()
    {
        $this->width = $this->imagick->getImageWidth();
        $this->height = $this->imagick->getImageHeight();
    }
}

?>

