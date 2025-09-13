<?php
class Image {
    public $name, $size, $compressed;
    function __construct($name, $size) {
        $this->name = $name;
        $this->size = $size;
        $this->compressed = false;
    }
}
class ImageCompressorTool {
    public $images = [];
    public function addImage($name, $size) {
        $this->images[] = new Image($name, $size);
    }
    public function compress($name) {
        foreach ($this->images as $img) {
            if ($img->name == $name && !$img->compressed) {
                $img->size = intval($img->size * 0.5);
                $img->compressed = true;
            }
        }
    }
    public function listImages() {
        foreach ($this->images as $img)
            echo "$img->name: $img->size KB" . ($img->compressed ? " (compressed)" : "") . "<br>";
    }
    public function export($filename) {
        $data = [];
        foreach ($this->images as $img)
            $data[] = ["name"=>$img->name,"size"=>$img->size,"compressed"=>$img->compressed];
        file_put_contents($filename, json_encode($data, JSON_PRETTY_PRINT));
    }
}

$ict = new ImageCompressorTool();
$ict->addImage("photo.jpg", 1200);
$ict->addImage("logo.png", 800);
$ict->compress("photo.jpg");
$ict->listImages();
$ict->export("images.json");
?>