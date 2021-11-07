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


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Aces css framework -->
    <link rel="stylesheet" href="./css/aces-css-framework/style.css">

    <!-- Local Styles -->
    <link rel="stylesheet" href="./css/local-styles/advanced-search.css">


    <title>Document</title>
</head>

<body>

    <!-- NAVIGATION BAR -->

    <?php include_once __DIR__ . '/components/nav.php'; ?> 


    <!-- Advanced Search Content -->

    <div class="main-container">
        <div class="input-container">
            <div class="card type-column box-shadow-1">
                <div class="form form-override">
                    <div class="input-group input-group-override">
                        <label class="labelPlace label-override add-margin" for="">Search items from :</label>
                        <select class="custom-select custom-select-override add-margin change-height">
                            <option value="1">Anywhere</option>
                            <option value="2">E-Books</option>
                            <option value="3">Institutional Publications</option>
                            <option value="4">Journals and Magazines</option>
                            <option value="5">Past Papers</option>
                            <option value="6">Newsletters</option>
                        </select>
                    </div>
                    <hr>
                    <div class="card-title">
                        <p>Filters</p>
                    </div>
                    <div class="input-group input-group-override">
                        <select class="custom-select custom-select-override add-margin change-height">
                            <option value="1">Title</option>
                            <option value="2">Author</option>
                            <option value="3">Subject</option>
                        </select>
                        <select class="custom-select custom-select-override add-margin change-height">
                            <option value="1">Equals</option>
                            <option value="2">Contains</option>
                            <option value="3">Not Equlas</option>
                        </select>
                    </div>
                    <div class="input-group input-group-override-1">
                        <input class="form-control add-margin change-height" id="name" type="text"/>
                        <button class="btn btn-secondary" type="button"><i class="fas fa-plus-circle add-margin"></i></button>
                    </div>
                    <div class="input-group">
                        <button class="btn btn-primary add-margin" type="button">Search</button>
                    </div>
                </div>
            </div>
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
</body>

</html>