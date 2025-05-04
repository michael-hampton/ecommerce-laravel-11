<?php

namespace App;

use Intervention\Image\Laravel\Facades\Image;

class Helper
{

    /**
     * @param float $price
     * @param bool $returnPrice
     * @return float|int|mixed
     */
    public static function calculateCommission(float $price, bool $returnPrice = false)
    {
        $commission = config('shop.commission');
        $commissionValue = ($commission / 100) * $price;

        if ($returnPrice) {
            return self::truncateNumber(($price + $commissionValue));
        }


        return self::truncateNumber($commissionValue);
    }

    /**
     * @param $number
     * @param $precision
     * @return float|int|mixed
     */
    public static function truncateNumber($number, $precision = 2)
    {
        // Zero causes issues, and no need to truncate
        if (0 == (int) $number) {
            return $number;
        }
        // Are we negative?
        $negative = $number / abs($number);
        // Cast the number to a positive to solve rounding
        $number = abs($number);
        // Calculate precision number for dividing / multiplying
        $precision = pow(10, $precision);
        // Run the math, re-applying the negative value to ensure returns correctly negative / positive
        return floor($number * $precision) / $precision * $negative;
    }

    public static function generateThumbnailImage($image, $filename, $type)
    {
        $thumbnailPath = public_path('images/' . $type . '/thumbnails');

        $image = Image::read($image->path())
            ->resize(100, 100)
            ->save($thumbnailPath . '/' . $filename);
    }

    /**
     * @param string $email
     * @return string
     */
    public static function obfuscateEmail(string $email): string
    {
        $em = explode("@", $email);

        $firstPart = '';

        for ($x = 0; $x <= strlen($em[0]); $x++) {
            $firstPart .= '*';
        }

        return $firstPart . '@' . $em[1];
    }
}
