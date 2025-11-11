<?php


class StringHelper {
    static $keyboardRus = array(
        'ё', 'й', 'ц', 'у', 'к', 'е', 'н', 'г', 'ш', 'щ', 'з', 'х', 'ъ', 
        'ф', 'ы', 'в', 'а', 'п', 'р', 'о', 'л', 'д', 'ж', 'э',
        'я', 'ч', 'с', 'м', 'и', 'т', 'ь', 'б', 'ю', '.'
    );
    static $keyboardEng = array(
        '`', 'q', 'w', 'e', 'r', 't', 'y', 'u', 'i', 'o', 'p', '[', ']', 
        'a', 's', 'd', 'f', 'g', 'h', 'j', 'k', 'l', ';', "'",
        'z', 'x', 'c', 'v', 'b', 'n', 'm', ',', '.', '/'
    );
    
    static function switchKeyboardLang($string) {
        $string = strtolower( $string );
        $result = str_replace(self::$keyboardEng, StringHelper::$keyboardRus, $string);

        if ( $result == $string ) {
            $result = str_replace(self::$keyboardRus, StringHelper::$keyboardEng, $string);
        }

        return $result;
    }

    /**
     * Choose russian word declension based on numeric.
     * Example for $expressions: array("ответ", "ответа", "ответов")
     */
    static function wordForm($int, $expressions)
    {
        if (count($expressions) < 3) $expressions[2] = $expressions[1];
        settype($int, "integer");
        $count = $int % 100;
        if ($count >= 5 && $count <= 20) {
            $result = $expressions['2'];
        } else {
            $count = $count % 10;
            if ($count == 1) {
                $result = $expressions['0'];
            } elseif ($count >= 2 && $count <= 4) {
                $result = $expressions['1'];
            } else {
                $result = $expressions['2'];
            }
        }
        return $result;
    }

    static function cleanSearchPhrase($string, $encoding = 'utf-8') {
        $result = preg_replace("/[^a-zA-ZабвгдеёжзийклмнопрстуфхцчшщъыьэюяАБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯ0-9_-\s]/u", " ", $string);
        $result = preg_replace('/\s+/u', ' ', $result);
        $result = trim( mb_strtolower($result, $encoding) );

        return $result;
    }

    static function cleanPhrase($string) {
        //Lower case everything
        $string = strtolower($string);
        //Make alphanumeric (removes all other characters)
        $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
        //Clean up multiple dashes or whitespaces
        $string = preg_replace("/[-_\s]+/", " ", $string);

        return trim($string);
    }
    
}