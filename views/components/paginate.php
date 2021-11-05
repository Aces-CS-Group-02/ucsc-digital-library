<!-- Paginate -->
<div class="paginate-controller-container">

    <?php

    use app\core\Application;


    /*---------------------------------------------------------
    \  Paginate Logic
    ---------------------------------------------------------*/

    $currentPage = $params['currentPage'];
    $pageCount = $params['pageCount'];

    if ($pageCount > 5 && $currentPage >= 4) {
        $start = $currentPage - 2;
    } else {
        $start = 1;
    }

    $end = $start + 4;

    if ($end > $pageCount) $end = $pageCount;

    if ($pageCount > 5 && ($end - $start + 1) < 5) {
        $start = $start - (5 - ($end - $start + 1));
    };


    if ($currentPage > $pageCount) {
        $currentPage = $pageCount;
    }




    /*---------------------------------------------------------
    \  Build Path for button links
    ---------------------------------------------------------*/

    $temp = Application::$app->request->getBody();

    $temp_array_keys = array_keys($temp);


    /*I want to set page attribute at the end of the path always. 
    If the page attribute occurs middle of the path(If page attribute 
    is not the last one in  atributes array) then remove it from that place.*/
    if (array_pop($temp_array_keys) !== 'page') {
        unset($temp['page']);
    }

    $temp['page'] = '';
    $path_end = [];

    foreach ($temp as $key => $attr) {
        $temp_str = $key . '=' . $attr;
        array_push($path_end, $temp_str);
    }

    $path_end = implode('&', $path_end);
    $path = Application::$app->request->getPath();
    if ($path_end !== '') $path = $path . '?' . $path_end;





    /*---------------------------------------------------------
    \  Previous Button
    ---------------------------------------------------------*/
    if ($currentPage != 1) {
        $temp_page = $currentPage - 1;
        echo "<li class='paginate-btn-next-prev'><a href=$path" . "$temp_page" . "><i class='fas fa-long-arrow-alt-left'></i></a></li>";
    }



    /*---------------------------------------------------------
    \  Paginate Numbered Buttons
    ---------------------------------------------------------*/
    for ($i = $start; $i <= $end; $i++) {
        $paginate_current_page_class = $i == $currentPage ? "paginate-current-page" : "";
        echo "<li class='$paginate_current_page_class paginate-btn'><a href=$path" . "$i" . ">$i</a></li>";
    }



    /*---------------------------------------------------------
    \  Next Button
    ---------------------------------------------------------*/
    if ($pageCount >= 1 && $currentPage != $pageCount) {
        $temp_page = $currentPage + 1;
        echo "<li class='paginate-btn-next-prev'><a href=$path" . "$temp_page" . "><i class='fas fa-long-arrow-alt-right'></i></a></li>";
    }
    ?>
</div>