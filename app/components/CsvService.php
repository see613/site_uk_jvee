<?php

class CsvService {
    private $delimiter;
    private $endLine;
    private $charset;
    private $result;


    /**
     * usually delimiter is ";" <br>
     * and end of line is "\n"
     */
    function __construct($delimiter, $endLine, $charset)
    {
        $this->delimiter = $delimiter;
        $this->endLine = $endLine;
        $this->charset = $charset;
        $this->result = '';
    }


    function addRow($row) {
        $length = count($row);

        for ($i=0; $i<$length; $i++) {
            $this->result .= $this->convertCharset($row[$i]) . (($i < $length-1) ? $this->delimiter : $this->endLine);
        }
    }

    function getResult() {
        return $this->result;
    }

    private function convertCharset($str) {
        return iconv('UTF-8', $this->charset, $str);
    }


}


