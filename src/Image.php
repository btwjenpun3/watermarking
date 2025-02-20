<?php

namespace Kaia\Watermarking;

class Image
{
    /**
     * Allowed image extensions
     * @return array
     */
    private static function allowedExtensions(): array
    {
        return ['jpg', 'jpeg', 'png'];
    }

    /**
     * Get the extension of a file
     * @param string $path
     * @return string
     */
    public static function extension(string $path): string
    {
        if (empty($path)) {
            throw new \Exception('File path is empty');
        }
    
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
    
        $allowedExtensions = self::allowedExtensions();
    
        if (in_array($extension, $allowedExtensions)) {
            return $extension === 'jpg' ? 'jpeg' : $extension; 
        }
    
        throw new \Exception('Unsupported image extension, supported extensions: ' . implode(', ', $allowedExtensions));
    }
}