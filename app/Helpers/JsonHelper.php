<?php

namespace App\Helpers;

class JsonHelper
{
    /**
     * Decodes, sanitizes, and prettifies a JSON string or object.
     *
     * @param mixed $data The raw JSON string, array, or object.
     * @param array $except Keys to remove from the output.
     * @return string
     */
    public static function prettify($data, array $except = [])
    {
        if (empty($data)) {
            return json_encode(new \stdClass());
        }

        // 1. Normalize input to an associative array
        if (is_string($data)) {
            $decoded = json_decode($data, true);
            // If decoding fails, return the original string or empty object
            $data = (json_last_error() === JSON_ERROR_NONE) ? $decoded : $data;
        } else {
            $data = (array) $data;
        }

        // 2. Simplify ruthlessly: remove unwanted keys
        if (!empty($except) && is_array($data)) {
            foreach ($except as $key) {
                unset($data[$key]);
            }
        }

        // 3. Craft: Return the human-readable format
        // JSON_UNESCAPED_SLASHES prevents URLs from looking messy
        return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }
}