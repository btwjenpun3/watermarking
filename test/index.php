<?php 

require __DIR__ . '/../vendor/autoload.php';

use Kaia\Watermarking\Watermark;

$generator = new Watermark();

/**
 * Create watermark from Image
 */
$resultPath = $generator->createFromImage(
    'img/image.png', // Source Image Path
    'result.png', // Destination Image Path
    'img/php.png', // Source Watermark Image Path
    [
        'position'  => 'top-left', 
        'size'     => 16, 
        'opacity'   => 0.4
    ]
);

echo '<img src="result.png" alt="Watermarked Image">';
