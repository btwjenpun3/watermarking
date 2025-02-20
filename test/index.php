<?php 

require __DIR__ . '/../vendor/autoload.php';

use Kaia\Watermarking\Watermark;

$generator = new Watermark();

/**
 * Create watermark from Image
 */
$resultPath = $generator->createFromText(
    'img/image.png', // Source Image Path
    'result.png', // Destination Image Path
    'I am Kaia', // Source Watermark Image Path
    [
        'position'  => 'top-left', 
        'size'     => 16, 
        'opacity'   => 0.4
    ]
);

echo '<img src="result.png" alt="Watermarked Image">';
