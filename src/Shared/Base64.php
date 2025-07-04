<?php

namespace Stytch\Shared;

class Base64
{
    private const LOOKUP_TABLE = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=';

    /**
     * base64Encode is a vanilla-php implementation of base64 encoding
     * We expect stytch-php to be run in a variety of environments, so
     * we implement our own base64 encoding for consistency.
     *
     * We only use this to encode project IDs and secrets, which are guaranteed to be ASCII and not unicode.
     *
     * @param string $input
     * @return string
     */
    public static function encode(string $input): string
    {
        // Unicode sanity check
        for ($i = 0; $i < strlen($input); $i++) {
            if (ord($input[$i]) > 128) {
                throw new \InvalidArgumentException(
                    "Base64 encoded unicode is not supported. Cannot encode " . $input,
                );
            }
        }

        $output = '';
        $i = 0;
        $len = strlen($input);

        while ($i < $len) {
            $char1 = $i < $len ? ord($input[$i++]) : 0;
            $char2 = $i < $len ? ord($input[$i++]) : 0;
            $char3 = $i < $len ? ord($input[$i++]) : 0;

            $enc1 = $char1 >> 2;
            $enc2 = (($char1 & 3) << 4) | ($char2 >> 4);
            $enc3 = (($char2 & 15) << 2) | ($char3 >> 6);
            $enc4 = $char3 & 63;

            if ($char2 === 0) {
                $enc3 = $enc4 = 64;
            } elseif ($char3 === 0) {
                $enc4 = 64;
            }

            $output .= self::LOOKUP_TABLE[$enc1] .
                      self::LOOKUP_TABLE[$enc2] .
                      self::LOOKUP_TABLE[$enc3] .
                      self::LOOKUP_TABLE[$enc4];
        }

        return $output;
    }
}
