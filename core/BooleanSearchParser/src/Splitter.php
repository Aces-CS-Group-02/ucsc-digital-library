<?php

namespace app\core\BooleanSearchParser\src;


class Splitter
{

    private static $splitters = ["\r\n", "!=", ">=", "<=", "<>", ":=", "\\", "&&", ">", "<", "|", "=", "^", "(",
        ")", "\t", "\n", "'", "\"", "`", ",", "@", " ", "+", "-", "*", "/", ";"];
    private $tokenSize;
    private $hashSet;

    public function __construct() {
        $this->tokenSize = strlen(self::$splitters[0]); # should be the largest one
        $this->hashSet = array_flip(self::$splitters);
    }

    public function getMaxLengthOfSplitter() {
        return $this->tokenSize;
    }

    public function isSplitter($token) {
        return isset($this->hashSet[$token]);
    }
}
