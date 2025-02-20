
# Introduction

PHP Package where you can insert your own watermark on image. This package using PHP-GD for generating the watermark, so make sure you have PHP-GD installed before you use this package. For now this package only support on 4 positions, and will get update on future.

## Requirement
- php >= 8.0
- php-gd

## Installation

To install this package, run

```bash
  composer require kaia/watermarking
```

Now you can use it into your PHP project

```bash
  use Kaia\Watermarking\Watermark;

  /** Example create watermark using text
  Watermark::createFromText($sourcePath, $destinationPath, $watermarkText, $options[]);

  /** Example create watermark using image
  Watermark::createFromImage($sourcePath, $destinationPath, $watermarkPath, $options[]);
```

## Available options

For "createFromText" method.
| Key      | Type    | Value                                          | Default Value | Note     |
|----------|---------|------------------------------------------------|---------------|----------|
| position | string  | top-left, top-right, bottom-left, bottom-right | top-left      | optional |
| size     | integer | any number                                     | 12            | optional |
| color    | string  | hex color code (example #ffffff)               | #ffffff       | optional |
| font     | string  | path to your .ttf file                         | arial.ttf     | optional |

For "createFromImage" method.
| Key      | Type    | Value                                          | Default Value | Note     |
|----------|---------|------------------------------------------------|---------------|----------|
| position | string  | top-left, top-right, bottom-left, bottom-right | top-left      | optional |
| opacity  | integer | between 0.1 - 1.0                              | 0.5           | optional |
| scale    | integer | between 0.1 - 1.0                              | 0.2           | optional |

## Example case :

I want create watermark with text "I am Kaia" on existing image :
  
  - Source Image Path = storage/images/image.jpeg
  - Destination Image Path = storage/images/watermarked/watermarked.jpeg
  - Watermark Position = Top Left
  - Watermark Font Size = 16
  - Font Path = storage/fonts/arial.ttf

```bash
  use Kaia\Watermarking\Watermark;

  Watermark::createFromText(
    'storage/images/image.jpeg', 
    'storage/images/watermarked/watermarked.jpeg', 
    'I am Kaia', 
    [
      'position' => 'top-left',
      'size' => '16',
      'font' => 'storage/fonts/arial.ttf'
    ]
  );
```

And the output will be like :
![Image](https://github.com/user-attachments/assets/18299458-cfe5-4fb9-aa8c-9b526b836698)

## Support me

https://ko-fi.com/kaia3
