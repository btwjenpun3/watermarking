<?php

namespace Kaia\Watermarking;

class Validation 
{
    /**
     * Validate Text options
     * @param array $options
     * @return array
     */
    public static function validateTextOptions(array $options): array
    {
        if (! isset($options['position'])) {
            $options['position'] = 'top-left';
        }

        if (! isset($options['color'])) {
            $options['color'] = '#ffffff';
        
        } else {
            if (strpos($options['color'], '#') !== 0) {
                $options['color'] = '#' . $options['color'];
                
            } else {
                $options['color'] = $options['color'];
            }
        }

        if (! isset($options['size'])) {
            $options['size'] = 12;
        }

        if (! isset($options['font'])) {
            $options['font'] = '../fonts/arial.ttf';
        }

        return $options;
    }

    /**
     * Validate Image options
     * @param array $options
     * @return array
     */
    public static function validateImageOptions(array $options): array
    {
        if (! isset($options['position'])) {
            $options['position'] = 'top-left';
        }

        if (! isset($options['opacity'])) {
            $options['opacity'] = 0.5;
        
        } else {
            if ($options['opacity'] > 1) {
                throw new \Exception('Opacity value must be between 0 and 1');
            }
        }

        if (! isset($options['scale'])) {
            $options['scale'] = 0.2;
        
        } else {
            if ($options['scale'] > 1) {
                throw new \Exception('Scale value must be between 0 and 1');
            }
        }

        return $options;
    }
}