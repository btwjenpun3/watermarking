<?php

namespace Kaia\Watermarking;

use Kaia\Watermarking\Position;
use Kaia\Watermarking\Validation;

class Generator extends Image
{
    /**
     * Generate watermark from text
     * @param string $sourcePath
     * @param string $destinationPath
     * @param string $watermarkText
     * @param array $options
     * @return bool
     */
    public static function generateFromText(
        string $sourcePath, 
        string $destinationPath, 
        string $watermarkText, 
        array $options = []
    ): bool {
        try {
            switch (self::extension($sourcePath)) {
                case 'jpeg':
                    $image = @imagecreatefromjpeg($sourcePath);
                break;

                case 'png':
                    $image = @imagecreatefrompng($sourcePath);
                break;
            }

            if (! $image) {
                throw new \Exception('Could not create image from file');
            }

            $options = Validation::validateTextOptions($options);

            $positionType       = 'text';
            $font               = $options['font'];      
            $fontSize           = $options['size'];
            $fontColor          = $options['color'];
            $watermarkPosition  = $options['position'];

            $height = imagesy($image);
            $width  = imagesx($image);

            $box        = imagettfbbox($fontSize, 0, $font, $watermarkText);
            $textWidth  = abs($box[2] - $box[0]);
            $textHeight = abs($box[7] - $box[1]);

            [$x, $y] = Position::orientation($positionType, $watermarkPosition, $width, $height, $textWidth, $textHeight);

            list($r, $g, $b)    = sscanf($fontColor, "#%02x%02x%02x");
            $textColor          = @imagecolorallocate($image, $r, $g, $b);

            imagettftext($image, $fontSize, 0, $x, $y, $textColor, $font, $watermarkText);

            imagejpeg($image, $destinationPath, 100);

            imagedestroy($image);

            return true;

        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Generate watermark from Image
     * @param string $sourcePath
     * @param string $destinationPath
     * @param string $watermarkImage
     * @param array $options
     * @return bool
     */
    public static function generateFromImage(
        string $sourcePath,
        string $destinationPath,
        string $watermarkImage,
        array  $options = []
    ): bool {
        try {
            switch (self::extension($sourcePath)) {
                case 'jpeg':
                    $image = @imagecreatefromjpeg($sourcePath);
                    break;
    
                case 'png':
                    $image = @imagecreatefrompng($sourcePath);
                    break;
    
                default:
                    throw new \Exception('Unsupported image format');
            }    
            if (! $image) {
                throw new \Exception('Could not create image from file');
            }

            switch (self::extension($watermarkImage)) {
                case 'jpeg':
                    $watermark = @imagecreatefromjpeg($watermarkImage);
                    break;
    
                case 'png':
                    $watermark = @imagecreatefrompng($watermarkImage);
                    break;
    
                default:
                    throw new \Exception('Unsupported watermark image format');
            }
    
            if (! $watermark) {
                throw new \Exception('Could not create watermark image');
            }
    
            $options = Validation::validateImageOptions($options);
            
            $positionType       = 'image';
            $scale              = $options['scale'];
            $opacity            = $options['opacity'];
            $watermarkPosition  = $options['position'];
    
            $width  = imagesx($image);
            $height = imagesy($image);
    
            $watermarkWidth    = imagesx($watermark);
            $watermarkHeight   = imagesy($watermark);

            $resizedWatermarkWidth     = (int) ($width * $scale);
            $resizedWatermarkHeight    = (int) ($watermarkHeight * ($resizedWatermarkWidth / $watermarkWidth));

            $resizedWatermark = self::resizeImage($watermark, $watermarkWidth, $watermarkHeight, $resizedWatermarkWidth, $resizedWatermarkHeight);

            $resizedWatermark = self::makeTransparent($resizedWatermark, $opacity);
    
            [$x, $y] = Position::orientation($positionType, $watermarkPosition, $width, $height, $resizedWatermarkWidth, $resizedWatermarkHeight);

            imagecopy($image, $resizedWatermark, $x, $y, 0, 0, $resizedWatermarkWidth, $resizedWatermarkHeight);
    
            imagejpeg($image, $destinationPath, 100);
    
            imagedestroy($image);
            imagedestroy($watermark);
    
            return true;

        } catch (\Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

    /**
     * Resize watermark image
     * @param \GdImage $sourceImage
     * @param int $sourceWidth
     * @param int $sourceHeight
     * @param int $dstWidth
     * @param int $dstHeight
     * @return \GdImage
     */
    public static function resizeImage($sourceImage, int $sourceWidth, int $sourceHeight, int $dstWidth, int $dstHeight): \GdImage
    {
        $image = imagecreatetruecolor($dstWidth, $dstHeight);

        imagealphablending($image, false);
        imagesavealpha($image, true);

        imagecopyresampled(
            $image, $sourceImage, 
            0, 0, 0, 0, 
            $dstWidth, $dstHeight, 
            $sourceWidth, $sourceHeight
        );

        return $image;
    }

    public static function makeTransparent($sourceImage, $opacity): \GdImage
    {
        $width  = imagesx($sourceImage);
        $height = imagesy($sourceImage);

        $transparentImage = imagecreatetruecolor($width, $height);
        imagealphablending($transparentImage, false);
        imagesavealpha($transparentImage, true);

        for ($x = 0; $x < $width; $x++) {
            for ($y = 0; $y < $height; $y++) {
                $rgba = imagecolorat($sourceImage, $x, $y);
                $alpha = ($rgba >> 24) & 0x7F; 

                $newAlpha = min(127, max(0, $alpha + ceil((127 - $alpha) * (1 - $opacity))));

                $red   = ($rgba >> 16) & 0xFF;
                $green = ($rgba >> 8) & 0xFF;
                $blue  = $rgba & 0xFF;

                $newColor = imagecolorallocatealpha($transparentImage, $red, $green, $blue, $newAlpha);
                imagesetpixel($transparentImage, $x, $y, $newColor);
            }
        }

        return $transparentImage;
    }
}