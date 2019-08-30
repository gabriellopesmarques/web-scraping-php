<?php

require __DIR__ . "/../vendor/autoload.php";

use App\SimpleScan;
use Core\Response;

$scraping = SimpleScan::url("https://en.wikipedia.org/wiki/Data_scraping");

Response::json($scraping);
