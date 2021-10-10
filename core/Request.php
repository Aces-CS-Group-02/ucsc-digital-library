<?php

namespace app\core;

class Request
{
    public function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function isGET()
    {
        return $this->getMethod() === "GET";
    }

    public function isPOST()
    {
        return $this->getMethod() === "POST";
    }

    public function getPath()
    {
        $path = $_SERVER['REQUEST_URI'] ?? "/";
        $positionOfQeustionMark = strpos($path, '?');

        if ($positionOfQeustionMark === false) {
            return $path;
        } else {
            return substr($path, 0, $positionOfQeustionMark);
        }
    }

    public function getBody()
    {
        $body = [];

        if ($this->getMethod() === "GET") {
            foreach ($_GET as $key => $value) {
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        if ($this->getMethod() === "POST") {
            foreach ($_POST as $key => $value) {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        return $body;
    }
}
