<?php

namespace Kaia\Watermarking;

use Kaia\Watermarking\Generator;

class Watermark
{
    /**
     * Create watermark from text
     * @param string $sourcePath Source image path Ex. storage/public/image.jpeg
     * @param string $destinationPath Destination image path Ex. storage/public/result.jpeg
     * @param string $watermarkText Watermark text
     * @param array $options Available Option keys: (string) position, (int) size, (string) color, (string) font
     * @return bool
     */
    public static function createFromText(string $sourcePath, string $destinationPath, string $watermarkText, array $options = []): bool
    {
        Generator::generateFromText($sourcePath, $destinationPath, $watermarkText, $options);

        return true;
    }

    /**
     * Create watermark from image
     * @param string $sourcePath Source image path Ex. storage/public/image.jpeg
     * @param string $destinationPath Destination image path Ex. storage/public/result.jpeg
     * @param string $watermarkText Watermark image path Ex. storage/public/watermark.png
     * @param array $options Available Option keys: (string) position, (int) scale, (string) opacity
     * @return bool
     */
    public static function createFromImage(string $sourcePath, string $destinationPath, string $watermarkImage, array $options = []): bool
    {
        Generator::generateFromImage($sourcePath, $destinationPath, $watermarkImage, $options);

        return true;
    }
}