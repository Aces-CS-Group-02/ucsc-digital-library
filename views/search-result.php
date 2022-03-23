<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Global Styles -->
    <link rel="stylesheet" href="./css/global-styles/style.css">
    <link rel="stylesheet" href="./css/global-styles/nav.css">
    <link rel="stylesheet" href="./css/global-styles/footer.css">
    <link rel="stylesheet" href="/css/global-styles/paginate.css">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Aces css framework -->
    <link rel="stylesheet" href="./css/aces-css-framework/style.css">

    <!-- Local Styles -->
    <link rel="stylesheet" href="./css/local-styles/advanced-search.css">
    <link rel="stylesheet" href="./css/local-styles/search.css">


    <title>Advanced Search</title>
</head>

<body>

    <!-- NAVIGATION BAR -->

    <?php include_once __DIR__ . '/components/nav.php'; ?>
    <?php $data = $params['data']; ?>

    <!-- Advanced Search Content -->

    <div class="main-container">
        <div class="input-container">
            <div class="card type-column box-shadow-1">
                <div class="form form-override">
                    <div class="input-group input-group-override" id="input-group">
                        <label class="labelPlace label-override add-margin" for="">Search items from :</label>
                        <select class="custom-select custom-select-override add-margin change-height" id="community-select">

                            <option value="-1" <?php if($data['community']=="-1")echo "selected"; ?>>Anywhere</option>

                            <?php foreach ($params['communities']->payload as $community) { ?>
                                <option value="<?php echo $community->community_id; ?>"><?php echo $community->name; ?></option>
                            <?php } ?>
                        </select>
                        <input class="form-control add-margin change-height" onkeyup="validateOperators(event)" id="search-box" type="text" value="<?php echo $data['search_query']; ?>"/>
                        <?php foreach($params['filters'] as $filter) { ?>
                        <div class="filter input-group input-group-override-1" data-type="<?php echo $filter['type']; ?>" data-condition="<?php echo $filter['condition']; ?>" data-query="<?php echo $filter['query']; ?>">
                            <select class="custom-select custom-select-override add-margin change-height" disabled>
                                <option selected><?php echo $filter['type']; ?></option>
                            </select>
                            <select class="custom-select custom-select-override add-margin change-height" disabled>
                                <option selected><?php echo $filter['condition']; ?></option>
                            </select>
                            <input class="form-control add-margin change-height" disabled="" type="text" value="<?php echo $filter['query']; ?>">
                            <button class="btn btn-secondary" type="button" onclick="removeFilter(event)"><i class="fas fa-times add-margin"></i></button>
                        </div>
                        <?php } ?>
                    </div>
                    <hr>
                    <div class="card-title">
                        <p>Filters</p>
                    </div>
                    <div class="input-group input-group-override">
                        <select class="custom-select custom-select-override add-margin change-height" id="type">
                            <option value="title">Title</option>
                            <option value="author">Author</option>
                            <option value="subject">Subject</option>
                        </select>
                        <select class="custom-select custom-select-override add-margin change-height" id="condition">
                            <option value="equals">Equals</option>
                            <option value="contains">Contains</option>
                            <option value="not equals">Not Equals</option>
                        </select>
                    </div>
                    <div class="input-group input-group-override-1">
                        <div class="input-group">
                            <input class="form-control add-margin change-height" onkeydown="if(event.keyCode===13)addFilter()" onkeyup="validateOperators(event)" id="query" type="text" />
                        </div>

                        <button class="btn btn-secondary" type="button" onclick="addFilter()"><i class="fas fa-plus-circle add-margin"></i></button>
                    </div>
                    <div class="input-group">
                        <button class="btn btn-primary add-margin" type="button" onclick="search()">Search</button>
                    </div>
                    <div class="main-container">
                        <div class="input-group input-group-override-1">
                            <label for="" style="width: 50%;">Sort results by: </label>
                            <select class="custom-select custom-select-override add-margin" id="sort-by">
                                <option value="relavance" <?php if($data['sort_by']=="relavance")echo "selected"; ?>>Relavance</option>
                                <option value="title" <?php if($data['sort_by']=="title")echo "selected"; ?>>Title</option>
                                <option value="date" <?php if($data['sort_by']=="date")echo "selected"; ?>>Published date</option>
                            </select>
                            <select class="custom-select custom-select-override add-margin" id="order">
                                <option value="desc" <?php if($data['order']=="desc")echo "selected"; ?>>Descending</option>
                                <option value="asc" <?php if($data['order']=="asc")echo "selected"; ?>>Ascending</option>

                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="">
                <?php if (count($params['contents']) == 0) { ?>
                    <div class="search-card box-shadow-1">
                        <div class="search-card-details">
                            <div class="search-card-title result-info">
                                <h5>No results found !</h5>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <?php foreach ($params['contents'] as $content) { ?>

                    <div class="search-card box-shadow-1">
                        <div class="search-card-img">
                            <img src="https://m.media-amazon.com/images/I/91FlBY2B6yL._AC_UY327_FMwebp_QL65_.jpg" alt="" />
                        </div>
                        <div class="search-card-details">
                            <div class="search-card-title">
                                <h5><?php echo $content->title; ?></h5>
                            </div>
                            <div class="search-card-views">
                                <h6>1.5K views . 200 Cited</h6>
                            </div>
                            <div class="search-card-creator">
                                <h6>
                                    <?php
                                    echo $content->creators[0]['creator'];
                                    for ($i = 1; $i < count($content->creators); $i++) {
                                        echo ', ' . $content->creators[$i]['creator'];
                                    } ?>
                                </h6>
                            </div>
                            <div>
                                <p class="line-clamp line-clamp-x-description"><?php echo $content->abstract; ?> </p>
                            </div>
                            <div class="icon-bar">
                                <i class="fas fa-heart"></i>
                                <i class="fas fa-download"></i>
                                <i class="fas fa-plus"></i>
                                <i class="fas fa-quote-right"></i>
                                <i class="fas fa-share"></i>
                            </div>
                        </div>

                    </div>
                <?php } ?>
            </div>

            <?php

            if (!empty($params['contents']) && isset($params['pageCount'])) {
                include_once __DIR__ . '/components/paginate.php';
            }
            ?>
        </div>
        <div class="info-container">
            <div class="card type-column box-shadow-1">
                <div class="info-container-content">
                    <h2>SEARCH TIPS for text fields</h2>
                    <h4>Boolean searches</h4>

                    <p>Use the boolean operators <b>AND</b>, <b>OR</b>, and <b>NOT</b> to narrow or broaden your search results.</p>
                    <p>By default, an AND relationship is assumed between Search Within terms unless you specify a different operator in the <b>Edit Query:</b> input.
                    <p>By default, an <b>OR</b> relationship is assumed between <u>words</u> within 1 Search Within term.</p>

                    <h4>Searching for phrases</h4>

                    <p>Enclose your search terms within quotation marks (" ") to search for an exact match of that phrase.</p>
                    <p>If no quotation marks are used, search results will be populated with publications that contain your search terms somewhere in the text.</p>
                    <p>For example, if you search for <i style="background: #fafafa;">"machine learning"</i> the search engine will limit the results to publications that contain this exact phrase otherwise an <b>OR</b> will be assumed in between the words.
                    </p>
                    <p>Curly quotes (“ ”) are also acceptable eg. <i style="background: #fafafa;">“machine learning”</i></p>
                    <p><b>NOTE:</b> opening and closing quotes must be of the same type; curly or straight. Please avoid entering <i style="background: #fafafa;">“machine learning"</i></p>

                    <h4>Wildcards</h4>

                    <p>Use an asterisk (*) to specify <u>any number</u> of unknown characters. For example, if you search for <b>comput*</b>, the search engine will provide results that contain words such as compute, comput<b>ation</b>, comput<b>ing</b>, etc.</p>
                    <p>Use a question mark (?) to specify any <u>single</u> unknown character. For example, if you search for <b>compute?</b>, the search engine will provide results that contain words such as computer or compute<b>d</b> <u>but not</u> compute<b>rs</b> because the question mark represents <u>only one</u> character.</p>
                    <p><b>NOTE</b>: Wildcards cannot be used at the start of a search term or when searching for phrases within quotes.</p>

                    <h4>Special Characters</h4>
                    <p>The following characters have a special meaning when they appear in a query:</p>
                    <quote style="background: #fafafa;"> + - && || ! ( ) { } [ ] ^ " ~ * ? : / </quote>
                    <p>To instruct Search to interpret any of these characters literally, rather as a special character, precede the character with a backslash character <b>\</b></p>
                    <p>For example, the term <i style="background: #fafafa;">web -based</i> will search for <i style="background: #fafafa;">web NOT base</i> so either remove the space before - or escape it <b>web \-based</b> to find web-based documents.</p>
                    <p>Another example, <i style="background: #fafafa;">complexity n^2</i> is best to be searched with escaping <b>complexity n\^2</b> as ^ is interpreted as boost a term.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <?php include_once __DIR__ . '/components/footer.php'; ?>

    <!-- SCRITP -->

    <script src="./javascript/nav.js"></script>
    <script>
        function createElementFromHTML(htmlString) {
            var div = document.createElement('div');
            div.innerHTML = htmlString.trim();
            return div.firstChild;
        }

        function clearFilters() {
            document.getElementById("query").value = "";
            document.getElementById("type").value = "title";
            document.getElementById("condition").value = "equals";
        }

        function addFilter() {
            var type = document.getElementById('type').value;
            var condition = document.getElementById('condition').value;
            var query = document.getElementById('query').value.trim();
            if (query != "") createFilter(type, condition, query);
            clearFilters();
        }

        function removeFilter(event) {
            event.target.closest(".filter").remove();
        }

        function createFilter(type, condition, query) {
            let html_div = "<div class='filter input-group input-group-override-1' data-type='" + type + "' data-condition='" + condition + "' data-query='" + query + "'>" + '<select class="custom-select custom-select-override add-margin change-height" disabled><option selected>' + type + '</option></select>' + '<select class="custom-select custom-select-override add-margin change-height" disabled><option selected>' + condition + '</option></select>' + '<input class="form-control add-margin change-height" disabled type="text"' + 'value="' + query + '"' + '/>' + '<button class="btn btn-secondary" type="button" onclick="removeFilter(event)"><i class="fas fa-times add-margin"></i></button>';
            let div = createElementFromHTML(html_div);
            document.getElementById("input-group").appendChild(div);
        }


        function search() {
            let elements = document.querySelectorAll(".filter");
            let community = document.getElementById("community-select").value;
            let sort_by = document.getElementById("sort-by").value;
            let order = document.getElementById("order").value;
            let searchQuery = document.getElementById("search-box").value.trim();
            let old_url = new URL(window.location.href);
            let host_name = old_url.hostname;
            let protocol = old_url.protocol;
            let port = old_url.port;
            const url = new URL(protocol + "//" + host_name + ":" + port + "/search-result  ");
            url.searchParams.append('community', community);
            url.searchParams.append('sort_by', sort_by);
            url.searchParams.append('order', order);
            url.searchParams.append('search_query', searchQuery);
            for (let i = 0; i < elements.length; i++) {
                url.searchParams.append('type' + i, elements[i].dataset.type);
                url.searchParams.append('condition' + i, elements[i].dataset.condition);
                url.searchParams.append('query' + i, elements[i].dataset.query);
            }
            window.location.href = url;
        }

        function validateOperators(event) {
            clearErrorMsg(event.target);
            if ((/((\band\b|\bor\b|\bnot\b)( (\band\b|\bor\b|\bnot\b))+)+/).test(event.target.value.toLowerCase())) {
                addErrorMsg(event.target, 'Operators cannot be used in between words');
            }
        }

        function clearErrorMsg(input) {
            let msg = input.nextElementSibling;
            if (msg) {
                if (msg.classList.contains("input-error"))
                    msg.remove();
            }
            input.style.borderColor = null;
        }

        function addErrorMsg(input, msg) {
            let span = input.nextElementSibling;
            if (span) {
                if (!span.classList.contains("input-error")) {
                    span = document.createElement("span");
                    input.insertAdjacentElement("afterend", span);
                }
            } else {

                span = document.createElement("span");
                input.insertAdjacentElement("afterend", span);
            }
            span.classList.add("input-error");
            span.innerHTML = "<i class='fas fa-exclamation-circle'></i> &nbsp" + msg;
            span.style.color = "red";
            span.style.margin = "0.2rem";
            span.style.fontSize = "0.7rem";
            input.style.borderColor = "red";
        }
    </script>
</body>

</html