<?php

namespace Kaia\Watermarking;

class Position
{
    /**
     * Watermark position
     * @param int $height
     * @param int $width
     */
    public static function orientation(string $type, string $position, int $width, int $height, int $textWidth, int $textHeight)
    {
        switch ($position) {
            case 'top-left':
                return Position::topLeft($type, $width, $height, $textHeight);

            case 'top-right':
                return Position::topRight($type, $width, $height, $textWidth, $textHeight);

            case 'bottom-left':
                return Position::bottomLeft($type, $width, $height, $textHeight);

            case 'bottom-right':
                return Position::bottomRight($type, $width, $height, $textWidth, $textHeight);
                
            default:
                return Position::topLeft($type, $width, $height, $textHeight);
        }
    }
    
    /**
     * Watermark position top-left
     * @param int $width
     * @param int $height
     * @param int $padding
     * @return array
     */
    public static function topLeft(string $type, int $width, int $height, int $textHeight, int $padding = 20): array
    {
        if ($type === 'image') {
            return [$padding, $padding];
        
        } else {
            return [$padding, $padding + $textHeight];
        }
    }

    /**
     * Watermark position top-right
     * @param int $width
     * @param int $height
     * @param int $textWidth
     * @param int $padding
     * @return array
     */
    public static function topRight(string $type, int $width, int $height, int $textWidth, int $textHeight, int $padding = 20): array
    {
        if ($type === 'image') {
            return [$width - $textWidth - $padding, $padding];
        
        } else {
            return [$width - $textWidth - $padding, $padding + $textHeight];
        }
    }

    /**
     * Watermark position bottom-left
     * @param int $width
     * @param int $height
     * @param int $textHeight
     * @param int $padding
     * @return array
     */
    public static function bottomLeft(string $type, int $width, int $height, int $textHeight, int $padding = 20): array
    {
        if ($type === 'image') {
            return [$padding, $height - $textHeight - $padding];
        
        } else {
            return [$padding, $height - $textHeight - $padding];
        }        
    }

    /**
     * Watermark position bottom-right
     * @param int $width
     * @param int $height
     * @param int $textWidth
     * @param int $textHeight
     * @param int $padding
     * @return array
     */
    public static function bottomRight(string $type, int $width, int $height, int $textWidth, int $textHeight, int $padding = 20): array
    {
        if ($type === 'image') {
            return [$width - $textWidth - $padding, $height - $textHeight - $padding];
        
        } else {
            return [$width - $textWidth - $padding, $height - $textHeight - $padding];
        }
    }
}
