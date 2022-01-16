<div class="breadcrum-container-v2">
    <?php
    if (isset($params['breadcrum'])) {
        $breadcrumItems = count($params['breadcrum']);

        for ($i = 0; $i < $breadcrumItems; $i++) {
            echo '<a class="breadcrum-link-white" href="' . $params['breadcrum'][$i]['link'] . '">' . $params['breadcrum'][$i]['name'] . '</a>';

            if ($i < $breadcrumItems - 1) {
                echo '<p class="breadcrum-link-arrow-white">></p>';
            }
        }
    }
    ?>
</div>