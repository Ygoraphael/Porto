<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class Mssql {
    /* default values */

    private $connection = null;
    private $server = "";
    private $database = "";
    private $user = "";
    private $password = "";
    private $port = "";

    const ICONV_TRANSLIT = "TRANSLIT";
    const ICONV_IGNORE = "IGNORE";
    const WITHOUT_ICONV = "";

    public function __construct() {
        $this->_ci = & get_instance();

        $this->server = $this->_ci->config->MSSQL['server'];
        $this->database = $this->_ci->config->MSSQL['database'];
        $this->user = $this->_ci->config->MSSQL['user'];
        $this->password = $this->_ci->config->MSSQL['password'];
        $this->port = $this->_ci->config->MSSQL['port'];
    }

    public function stamp() {
        $query = "select CONVERT(VARCHAR(25), (select UPPER(suser_sname())+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5))) stamp";
        $query = $this->mssql__select($query);
        return $query[0]["stamp"];
    }

    protected static $win1252ToUtf8 = array(
        128 => "\xe2\x82\xac",
        130 => "\xe2\x80\x9a",
        131 => "\xc6\x92",
        132 => "\xe2\x80\x9e",
        133 => "\xe2\x80\xa6",
        134 => "\xe2\x80\xa0",
        135 => "\xe2\x80\xa1",
        136 => "\xcb\x86",
        137 => "\xe2\x80\xb0",
        138 => "\xc5\xa0",
        139 => "\xe2\x80\xb9",
        140 => "\xc5\x92",
        142 => "\xc5\xbd",
        145 => "\xe2\x80\x98",
        146 => "\xe2\x80\x99",
        147 => "\xe2\x80\x9c",
        148 => "\xe2\x80\x9d",
        149 => "\xe2\x80\xa2",
        150 => "\xe2\x80\x93",
        151 => "\xe2\x80\x94",
        152 => "\xcb\x9c",
        153 => "\xe2\x84\xa2",
        154 => "\xc5\xa1",
        155 => "\xe2\x80\xba",
        156 => "\xc5\x93",
        158 => "\xc5\xbe",
        159 => "\xc5\xb8"
    );
    protected static $brokenUtf8ToUtf8 = array(
        "\xc2\x80" => "\xe2\x82\xac",
        "\xc2\x82" => "\xe2\x80\x9a",
        "\xc2\x83" => "\xc6\x92",
        "\xc2\x84" => "\xe2\x80\x9e",
        "\xc2\x85" => "\xe2\x80\xa6",
        "\xc2\x86" => "\xe2\x80\xa0",
        "\xc2\x87" => "\xe2\x80\xa1",
        "\xc2\x88" => "\xcb\x86",
        "\xc2\x89" => "\xe2\x80\xb0",
        "\xc2\x8a" => "\xc5\xa0",
        "\xc2\x8b" => "\xe2\x80\xb9",
        "\xc2\x8c" => "\xc5\x92",
        "\xc2\x8e" => "\xc5\xbd",
        "\xc2\x91" => "\xe2\x80\x98",
        "\xc2\x92" => "\xe2\x80\x99",
        "\xc2\x93" => "\xe2\x80\x9c",
        "\xc2\x94" => "\xe2\x80\x9d",
        "\xc2\x95" => "\xe2\x80\xa2",
        "\xc2\x96" => "\xe2\x80\x93",
        "\xc2\x97" => "\xe2\x80\x94",
        "\xc2\x98" => "\xcb\x9c",
        "\xc2\x99" => "\xe2\x84\xa2",
        "\xc2\x9a" => "\xc5\xa1",
        "\xc2\x9b" => "\xe2\x80\xba",
        "\xc2\x9c" => "\xc5\x93",
        "\xc2\x9e" => "\xc5\xbe",
        "\xc2\x9f" => "\xc5\xb8"
    );
    protected static $utf8ToWin1252 = array(
        "\xe2\x82\xac" => "\x80",
        "\xe2\x80\x9a" => "\x82",
        "\xc6\x92" => "\x83",
        "\xe2\x80\x9e" => "\x84",
        "\xe2\x80\xa6" => "\x85",
        "\xe2\x80\xa0" => "\x86",
        "\xe2\x80\xa1" => "\x87",
        "\xcb\x86" => "\x88",
        "\xe2\x80\xb0" => "\x89",
        "\xc5\xa0" => "\x8a",
        "\xe2\x80\xb9" => "\x8b",
        "\xc5\x92" => "\x8c",
        "\xc5\xbd" => "\x8e",
        "\xe2\x80\x98" => "\x91",
        "\xe2\x80\x99" => "\x92",
        "\xe2\x80\x9c" => "\x93",
        "\xe2\x80\x9d" => "\x94",
        "\xe2\x80\xa2" => "\x95",
        "\xe2\x80\x93" => "\x96",
        "\xe2\x80\x94" => "\x97",
        "\xcb\x9c" => "\x98",
        "\xe2\x84\xa2" => "\x99",
        "\xc5\xa1" => "\x9a",
        "\xe2\x80\xba" => "\x9b",
        "\xc5\x93" => "\x9c",
        "\xc5\xbe" => "\x9e",
        "\xc5\xb8" => "\x9f"
    );

    static function toUTF8($text) {
        if (is_array($text)) {
            foreach ($text as $k => $v) {
                $text[$k] = self::toUTF8($v);
            }
            return $text;
        }

        if (!is_string($text)) {
            return $text;
        }

        $max = self::strlen($text);

        $buf = "";
        for ($i = 0; $i < $max; $i++) {
            $c1 = $text{$i};
            if ($c1 >= "\xc0") { //Should be converted to UTF8, if it's not UTF8 already
                $c2 = $i + 1 >= $max ? "\x00" : $text{$i + 1};
                $c3 = $i + 2 >= $max ? "\x00" : $text{$i + 2};
                $c4 = $i + 3 >= $max ? "\x00" : $text{$i + 3};
                if ($c1 >= "\xc0" & $c1 <= "\xdf") { //looks like 2 bytes UTF8
                    if ($c2 >= "\x80" && $c2 <= "\xbf") { //yeah, almost sure it's UTF8 already
                        $buf .= $c1 . $c2;
                        $i++;
                    } else { //not valid UTF8.  Convert it.
                        $cc1 = (chr(ord($c1) / 64) | "\xc0");
                        $cc2 = ($c1 & "\x3f") | "\x80";
                        $buf .= $cc1 . $cc2;
                    }
                } elseif ($c1 >= "\xe0" & $c1 <= "\xef") { //looks like 3 bytes UTF8
                    if ($c2 >= "\x80" && $c2 <= "\xbf" && $c3 >= "\x80" && $c3 <= "\xbf") { //yeah, almost sure it's UTF8 already
                        $buf .= $c1 . $c2 . $c3;
                        $i = $i + 2;
                    } else { //not valid UTF8.  Convert it.
                        $cc1 = (chr(ord($c1) / 64) | "\xc0");
                        $cc2 = ($c1 & "\x3f") | "\x80";
                        $buf .= $cc1 . $cc2;
                    }
                } elseif ($c1 >= "\xf0" & $c1 <= "\xf7") { //looks like 4 bytes UTF8
                    if ($c2 >= "\x80" && $c2 <= "\xbf" && $c3 >= "\x80" && $c3 <= "\xbf" && $c4 >= "\x80" && $c4 <= "\xbf") { //yeah, almost sure it's UTF8 already
                        $buf .= $c1 . $c2 . $c3 . $c4;
                        $i = $i + 3;
                    } else { //not valid UTF8.  Convert it.
                        $cc1 = (chr(ord($c1) / 64) | "\xc0");
                        $cc2 = ($c1 & "\x3f") | "\x80";
                        $buf .= $cc1 . $cc2;
                    }
                } else { //doesn't look like UTF8, but should be converted
                    $cc1 = (chr(ord($c1) / 64) | "\xc0");
                    $cc2 = (($c1 & "\x3f") | "\x80");
                    $buf .= $cc1 . $cc2;
                }
            } elseif (($c1 & "\xc0") == "\x80") { // needs conversion
                if (isset(self::$win1252ToUtf8[ord($c1)])) { //found in Windows-1252 special cases
                    $buf .= self::$win1252ToUtf8[ord($c1)];
                } else {
                    $cc1 = (chr(ord($c1) / 64) | "\xc0");
                    $cc2 = (($c1 & "\x3f") | "\x80");
                    $buf .= $cc1 . $cc2;
                }
            } else { // it doesn't need conversion
                $buf .= $c1;
            }
        }
        return $buf;
    }

    static function toWin1252($text, $option = self::WITHOUT_ICONV) {
        if (is_array($text)) {
            foreach ($text as $k => $v) {
                $text[$k] = self::toWin1252($v, $option);
            }
            return $text;
        } elseif (is_string($text)) {
            return static::utf8_decode($text, $option);
        } else {
            return $text;
        }
    }

    static function toISO8859($text) {
        return self::toWin1252($text);
    }

    static function toLatin1($text) {
        return self::toWin1252($text);
    }

    static function fixUTF8($text, $option = self::WITHOUT_ICONV) {
        if (is_array($text)) {
            foreach ($text as $k => $v) {
                $text[$k] = self::fixUTF8($v, $option);
            }
            return $text;
        }
        $last = "";
        while ($last <> $text) {
            $last = $text;
            $text = self::toUTF8(static::utf8_decode($text, $option));
        }
        $text = self::toUTF8(static::utf8_decode($text, $option));
        return $text;
    }

    static function UTF8FixWin1252Chars($text) {
        // If you received an UTF-8 string that was converted from Windows-1252 as it was ISO8859-1
        // (ignoring Windows-1252 chars from 80 to 9F) use this function to fix it.
        // See: http://en.wikipedia.org/wiki/Windows-1252
        return str_replace(array_keys(self::$brokenUtf8ToUtf8), array_values(self::$brokenUtf8ToUtf8), $text);
    }

    static function removeBOM($str = "") {
        if (substr($str, 0, 3) == pack("CCC", 0xef, 0xbb, 0xbf)) {
            $str = substr($str, 3);
        }
        return $str;
    }

    protected static function strlen($text) {
        return (function_exists('mb_strlen') && ((int) ini_get('mbstring.func_overload')) & 2) ?
                mb_strlen($text, '8bit') : strlen($text);
    }

    public static function normalizeEncoding($encodingLabel) {
        $encoding = strtoupper($encodingLabel);
        $encoding = preg_replace('/[^a-zA-Z0-9\s]/', '', $encoding);
        $equivalences = array(
            'ISO88591' => 'ISO-8859-1',
            'ISO8859' => 'ISO-8859-1',
            'ISO' => 'ISO-8859-1',
            'LATIN1' => 'ISO-8859-1',
            'LATIN' => 'ISO-8859-1',
            'UTF8' => 'UTF-8',
            'UTF' => 'UTF-8',
            'WIN1252' => 'ISO-8859-1',
            'WINDOWS1252' => 'ISO-8859-1'
        );
        if (empty($equivalences[$encoding])) {
            return 'UTF-8';
        }
        return $equivalences[$encoding];
    }

    public static function encode($encodingLabel, $text) {
        $encodingLabel = self::normalizeEncoding($encodingLabel);
        if ($encodingLabel == 'ISO-8859-1')
            return self::toLatin1($text);
        return self::toUTF8($text);
    }

    protected static function utf8_decode($text, $option) {
        if ($option == self::WITHOUT_ICONV || !function_exists('iconv')) {
            $o = utf8_decode(
                    str_replace(array_keys(self::$utf8ToWin1252), array_values(self::$utf8ToWin1252), self::toUTF8($text))
            );
        } else {
            $o = iconv("UTF-8", "Windows-1252" . ($option == self::ICONV_TRANSLIT ? '//TRANSLIT' : ($option == self::ICONV_IGNORE ? '//IGNORE' : '')), $text);
        }
        return $o;
    }

    public function mssql__connect() {
        //SQL Servers
        if ($this->port == "") {
            $this->connection = odbc_connect("Driver={SQL Server Native Client 11.0};Server=" . $this->server . ";Database=" . $this->database . ";", $this->user, $this->password);
        } else {
            $this->connection = odbc_connect("Driver={SQL Server Native Client 11.0};Server=" . $this->server . ", " . $this->port . ";Database=" . $this->database . ";", $this->user, $this->password);
        }

        if (!$this->connection) {
            die(print_r(sqlsrv_errors(), true));
        }
    }

    public function utf8ize($d) {
        if (is_array($d)) {
            foreach ($d as $k => $v) {
                $d[$k] = $this->utf8ize($v);
            }
        } else if (is_string($d)) {
            return utf8_encode(trim($d));
        }
        return $d;
    }

    public function latinize($d) {
        if (is_array($d)) {
            foreach ($d as $k => $v) {
                $d[$k] = $this->latinize($v);
            }
        } else if (is_string($d)) {
            return $this->encode('ISO-8859-1', trim($d));
        }
        return $d;
    }

    public function mssql__select($query) {
        $this->mssql__connect();
        // $query = iconv("UTF-8//IGNORE", "CP1252//IGNORE", $query);

        try {
            $results = odbc_exec($this->connection, $query);

            if (odbc_num_rows($results)) {
                $data = [];
                while ($dados_tmp = odbc_fetch_array($results)) {
                    $data[] = $dados_tmp;
                }

                return $this->utf8ize($data);
            } else {
                $data = [];
                return $this->utf8ize($data);
            }
        } catch (Exception $e) {
            log_message('error', $e);
            log_message('error', print_r($query, true));
        }

        if (odbc_error()) {
            log_message('error', odbc_errormsg($this->connection));
            log_message('error', print_r($query, true));
            $data = [""];
            return $this->utf8ize($data);
        }
    }

    public function mssql__execute($query) {
        $this->mssql__connect();
        $this->connection;
        set_error_handler(function($errno, $errstr, $errfile, $errline ) {
            throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
        });

        $query = $this->latinize($query);

        try {
            odbc_exec($this->connection, $query);
        } catch (Exception $e) {
            log_message('error', $e);
        }

        if (odbc_error()) {
            log_message('error', odbc_errormsg($this->connection));
            log_message('error', print_r($query, true));
            return false;
        }

        return true;
    }

    public function mssql__prepare_exec($query, $values) {
        $values = $this->latinize($values);
        $this->mssql__connect();

        set_error_handler(function($errno, $errstr, $errfile, $errline ) {
            throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
        });

        try {
            $stmt = odbc_prepare($this->connection, $query);

            for ($i = 0; $i < count($values); ++$i) {
                if (substr($values[$i], -1) == "'" && substr($values[$i], 0, 1) == "'") {
                    $values[$i] .= " ";
                }
            }

            $r = odbc_execute($stmt, $values);
        } catch (Exception $e) {
            log_message('error', $e);
        }

        if (odbc_error()) {
            log_message('error', odbc_errormsg($this->connection));
            log_message('error', print_r($query, true));
            log_message('error', print_r($values, true));
            return false;
        }

        return true;
    }

    public function mssql__prepare_sel($query, $values) {
        $values = $this->latinize($values);
        $this->mssql__connect();

        set_error_handler(function($errno, $errstr, $errfile, $errline ) {
            throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
        });

        try {
            $stmt = odbc_prepare($this->connection, $query);

            for ($i = 0; $i < count($values); ++$i) {
                if (substr($values[$i], -1) == "'" && substr($values[$i], 0, 1) == "'") {
                    $values[$i] .= " ";
                }
            }

            $result = odbc_execute($stmt, $values);

            if (odbc_num_rows($stmt)) {
                $data = [];
                while ($dados_tmp = odbc_fetch_array($stmt)) {
                    $data[] = $dados_tmp;
                }
                return $this->utf8ize($data);
            } else {
                $data = [];
                return $this->utf8ize($data);
            }
        } catch (Exception $e) {
            log_message('error', $e);
        }

        if (odbc_error()) {
            log_message('error', odbc_errormsg($this->connection));
            log_message('error', print_r($query, true));
            log_message('error', print_r($values, true));
            return false;
        }

        return true;
    }

    function utf8_encode_deep(&$input) {
        if (is_string($input)) {
            $input = $this->toUTF8($input);
        } else if (is_array($input)) {
            foreach ($input as &$value) {
                $this->utf8_encode_deep($value);
            }

            // unset($value);
        } else if (is_object($input)) {
            $vars = array_keys(get_object_vars($input));

            foreach ($vars as $var) {
                $this->utf8_encode_deep($input->$var);
            }
        }
    }

    function utf8_decode_deep(&$input) {
        if (is_string($input)) {
            $input = $this->toLatin1($input);
        } else if (is_array($input)) {
            foreach ($input as &$value) {
                $this->utf8_decode_deep($value);
            }

            // unset($value);
        } else if (is_object($input)) {
            $vars = array_keys(get_object_vars($input));

            foreach ($vars as $var) {
                $this->utf8_decode_deep($input->$var);
            }
        }
    }

}