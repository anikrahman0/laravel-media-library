<?php

namespace Noobtrader\LaravelMediaLibrary\Library;

use Carbon\Carbon;

class ImagePathGenerator {

    private $year;
    private $month;

    public function __construct()
    {
        $now = Carbon::now();
        $this->month = $now->format('F');
        $this->year = $now->year;
    }

    public function generatePath($basePath)
    {
        $basePath = rtrim($basePath, '/') . '/';
        $storePath = $this->generateStorePath();
        $originalPath = $basePath . $storePath;
        return [ 'originalPath' => $originalPath, 'storePath' => $storePath, ];
    }
    public function generateStorePath(){
        return  $this->year . $this->month;
    }
}