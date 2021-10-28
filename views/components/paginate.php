<!-- Paginate -->
<div class="paginate-controller-container">

    <?php

    $currentPage = $params['currentPage'];
    $pageCount = $params['pageCount'];

    if ($pageCount > 5 && $currentPage >= 4) {
        $start = $currentPage - 2;
    } else {
        $start = 1;
    }

    $end = $start + 5;
    if ($end > $pageCount) $end = $pageCount;

    if ($pageCount > 5 && ($end - $start + 1) < 5) {
        $start = $start - (5 - ($end - $start + 1));
    };

    //  Previous
    if ($currentPage != 1)  echo "<li class='paginate-btn-next-prev'><a href='/admin/manage-communities?page=" . $currentPage - 1 . "'>Previous</a></li>";

    // Middle
    for ($i = $start; $i <= $end; $i++) {
        $paginate_current_page_class = $i == $currentPage ? "paginate-current-page" : "";
        echo "<li class='$paginate_current_page_class paginate-btn'><a href='/admin/manage-communities?page=$i'>$i</a></li>";
    }

    // Next
    if ($pageCount >= 1 && $currentPage != $pageCount) echo "<li class='paginate-btn-next-prev'><a href='/admin/manage-communities?page=" . $currentPage + 1 . "'>Next</a></li>";
    ?>
</div>