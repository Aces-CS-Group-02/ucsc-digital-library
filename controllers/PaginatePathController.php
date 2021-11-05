<?php

namespace app\controllers;

use app\core\Application;
use app\core\exception\NotFoundException;

class PaginatePathController
{

    public function validatePage($page, $pageCount)
    {
        if (($page <= 0)) throw new NotFoundException();
        if (!$pageCount && $page > 1) throw new NotFoundException();
        if ($pageCount && ($page > $pageCount)) throw new NotFoundException();
    }


    public function getNewPath($pageCount)
    {
        $temp = Application::$app->request->getBody();
        $temp_array_keys = array_keys($temp);

        if (array_pop($temp_array_keys) !== 'page') {
            unset($temp['page']);
        }

        if ($pageCount) {
            $temp['page'] = $pageCount;
        }


        $path_end = [];

        foreach ($temp as $key => $attr) {
            $temp_str = $key . '=' . $attr;
            array_push($path_end, $temp_str);
        }

        $path_end = implode('&', $path_end);
        $path = Application::$app->request->getPath();
        if ($path_end !== '') $path = $path . '?' . $path_end;

        return $path;
    }
}
