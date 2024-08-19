<?php

declare(strict_types=1);

namespace App\Utility;

class ParseRawEmailUtility
{
    public const string CONTENT_TYPE_HTML = 'text/html';

    public const string CONTENT_TYPE_PLAIN_TEXT = 'text/plain';

    public static function normalizeRawText(string $longText): string
    {
        $data = [];

        $splitLongText = explode(PHP_EOL, $longText);

        $indexes = self::getIndexes(
            startAt: self::CONTENT_TYPE_PLAIN_TEXT,
            endAt: self::CONTENT_TYPE_HTML,
            data: $splitLongText
        );

        for ($index = $indexes['start']; $index <= $indexes['end']; $index++) {
            if (array_key_exists($index, $splitLongText)) {
                $data[] = $splitLongText[$index];
            }
        }

        return implode(PHP_EOL, $data);
    }

    private static function getIndexes(string $startAt, string $endAt, array $data)
    {
        $lastIndex = array_key_last($data);
        $startIndex = 0;
        $endIndex = 0;

        foreach ($data as $key => $text) {
            if (str_contains($text, $startAt)) {
                $startIndex = ($key + 2);

                while ($startIndex < $lastIndex) {
                    if (! $data[$startIndex]) {
                        $startIndex += 1;
                    }

                    if (isset($data[$startIndex])) {
                        $startIndex = $startIndex;
                        break;
                    }
                }
            }

            if (str_contains($text, $endAt)) {
                $endIndex = ($key - 2);

                while ($endIndex < $lastIndex) {
                    if (! $data[$endIndex]) {
                        $endIndex -= 1;
                    }

                    if (isset($data[$endIndex])) {
                        $endIndex = $endIndex;
                        break;
                    }
                }
                break;
            }
        }

        return [
            'start' => $startIndex,
            'end' => $endIndex,
        ];
    }
}
