<?php

namespace App\Model;

class Product
{
    private $title;
    private $price;
    private $description;
    private $imagePath;

    public function __construct($title, $price, $description, $imageFileName)
    {
        $this->title = $title;
        $this->price = $price;
        $this->description = $description;
        $this->imagePath = $imageFileName;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getImagePath()
    {
        return $this->imagePath;
    }
}