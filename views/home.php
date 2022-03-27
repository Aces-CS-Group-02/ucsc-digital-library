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
  <link rel="stylesheet" href="./css/local-styles/home.css">


  <title>Home</title>


</head>

<body>




  <!-- NAVIGATION BAR -->

  <?php include_once __DIR__ . '/components/nav.php'; ?>

 

  <!-- HOMEPAGE CONTENT -->

  <!-- <div class="banner section">
    <div class="custom-shape-divider-top-1629808668">
      <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
        <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" class="shape-fill"></path>
      </svg>
    </div>
    <div class="wrapper main-section-wrapper">

      <div class="main-section-devider-top">
        <div class="banner-section-container">
          <div class="banner-section-container-text">
            <div class="title-N-logo-container">
              <img id="banner-logo" src="../../assets/home/logo-black.png" alt="" />
              <div id="title">Welcome to UCSC <span>Digital Library</span></div>
            </div>
            <p id="description">
              Welcome to the UCSC digital library.
              Our digital library provides free access to a rich collection of undergraduate and postgraduate dissertations, electronic journals, e-books, and institutional publications. Not only all the students and the staff of the UCSC but also all the communities can fulfill their information needs by accessing this digital library, remotely.
            </p>
          </div>
          <div class="banner-section-container-img"></div>
        </div>
        <div class="main-searchbox-container">
          <input id="main-searchbox-input" type="text" />
          <div class="search-N-advanced-search-btn-container">
            <button id="main-search-btn">Search</button>
            <a id="main-advanced-search-btn" href="#">Advanced Search</a>
          </div>
        </div>
      </div>
      <div class="main-section-devider-bottom">
        <div class="banner-bottom-line-container">
          <p>
            We have a total of <span class="bold-text">15000</span> digital
            content in our<br />digital library as per today!
          </p>
        </div>
      </div>
    </div>
  </div> -->


  <div class="bannerX">
    <div class="custom-shape-divider-top-1629808668">
      <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
        <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" class="shape-fill"></path>
      </svg>
    </div>
    <div class="banner">
      <div class="top">
        <div class="banner-section-container">
          <div class="banner-section-container-text">
            <div class="title-N-logo-container">
              <img id="banner-logo" src="./assets/home/logo-black.png" alt="" />
              <div id="title">Welcome to UCSC <span>Digital Library</span></div>
            </div>
            <p id="description">
              Welcome to the UCSC digital library.
              Our digital library provides free access to a rich collection of undergraduate and postgraduate dissertations, electronic journals, e-books, and institutional publications. Not only all the students and the staff of the UCSC but also all the communities can fulfill their information needs by accessing this digital library, remotely.
            </p>
          </div>
          <div class="banner-section-container-img"></div>
        </div>
      </div>
      <div class="middle">
        <div class="main-searchbox-container">
          <input id="main-searchbox-input" type="text" onkeydown="if(event.keyCode===13)search()" onkeyup="validateOperators(event)" />
          <div class="search-N-advanced-search-btn-container">
            <button id="main-search-btn" onclick="search()">Search</button>
            <a id="advanced-search-btn" href="/advanced-search">Advanced Search</a>
          </div>
        </div>

      </div>
      <div class="bottom">
        <p>
          We have a total of <span class="bold-text">15000</span> digital
          content in our<br />digital library as per today!
        </p>
        <div class="down-animated-arrow">
          <i class="fas fa-chevron-down"></i>
        </div>
      </div>
    </div>
  </div>



  <div class="contents section">
    <div class="wrapper">

      <div class="section-title-container">
        <p class="section-title">Communities</p>
        <a class="view-all-communities" href="#">View All</a>
      </div>


      <div class="contents-grid">

        <?php foreach ($params['communities'] as $community) { ?>
          <div class="content-item-container">


            <div class="content-item">
              <div class="content-item-pattern"></div>
              <div class="content-item-text">
                <p class="content-item-title"><?php echo $community->name; ?></p>
                <p class="content-item-description line-clamp line-clamp-x-description"><?php echo $community->description; ?></p>
                <div class="content-item-view-more">
                  <a class="content-item-view-more-link" href="/browse/community?community_id=<?= $community->community_id ?>">
                    <p>View more</p>
                    <i class="fas fa-long-arrow-alt-right"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>

      <div class="view-all-communities-container-bottom">
        <a class="view-all-communities" href="#">View All</a>
      </div>

    </div>
  </div>

  <!-- Popular Items Section -->

  <div class="popular-items section">
    <div class="wrapper">
      <p class="section-title modify-section-title">Latest Updates</p>

      <!-- Carousel-Slider -->

      <div class="carousel-slider-container">
        <div class="button-container">
          <button class="carousel-prev">
            <i class="fas fa-chevron-left"></i>
          </button>
        </div>
        <div class="carousel-content-container">

          <?php
          $latestContent = $params['latestContents'] ?? "";
          ?>

          <div class="carousel-content">

            <?php if ($latestContent) {
              foreach ($latestContent as $content) {

            ?>

                <div class="item">
                  <div class="book-card box-shadow-2">
                    <div class="book-cover-img" style="background-image: url('<?= $_SERVER['HTTP_HOST'] ?>/<?= $content->thumbnail ?>');"></div>
                    <div class="book-title-container">
                      <p class="line-clamp line-clamp-2-description" name="content_id" value="<?php $content->content_id ?>"> <?php echo $content->title ?></p>
                    </div>
                  </div>
                </div>
            <?php }
            } ?>


          </div>
        </div>
        <div class="button-container">
          <button class="carousel-next">
            <i class="fas fa-chevron-right"></i>
          </button>

        </div>
      </div>

      <!-- / Carousel-Slider -->

      <p class="section-title modify-section-title">Popular Now</p>

      <!-- Carousel-Slider -->

      <div class="carousel-slider-container">
        <div class="button-container">
          <button class="carousel-prev">
            <i class="fas fa-chevron-left"></i>
          </button>
        </div>
        <div class="carousel-content-container">
          <div class="carousel-content">
            <?php $popularContent = $params['popularContent'] ?>
            <?php foreach ($popularContent as $content) { ?>
              <div class="item">
                <div class="book-card box-shadow-2">
                  <div class="book-cover-img" style="background-image: url('http://localhost:8000/<?= $content->thumbnail ?>');"></div>
                  <div class="book-title-container">
                    <p class="line-clamp line-clamp-2-description" name="content_id" value="<?php $content->content_id ?>"> <?php echo $content->title ?></p>
                  </div>
                </div>
              </div>
            <?php } ?>


          </div>
        </div>
        <div class="button-container">
          <button class="carousel-next">
            <i class="fas fa-chevron-right"></i>
          </button>

        </div>
      </div>

      <!-- / Carousel-Slider -->

    </div>
  </div>


  <!-- FOOTER -->

  <?php include_once __DIR__ . '/components/footer.php'; ?>

  <!-- SCRITP -->

  <script src="./javascript/nav.js"></script>
  <script src="./javascript/home.js"></script>
  <script>
    function search() {
      let searchQuery = document.getElementById("main-searchbox-input").value.trim();
      let old_url = new URL(window.location.href);
      let host_name = old_url.hostname;
      let protocol = old_url.protocol;
      let port = old_url.port;
      const url = new URL(protocol + "//" + host_name + ":" + port + "/search-result  ");
      url.searchParams.append('community', '-1');
      url.searchParams.append('sort_by', 'relavance');
      url.searchParams.append('order', 'desc');
      url.searchParams.append('search_query', searchQuery);
      window.location.href = url;

    }

    function validateOperators(event) {
      clearErrorMsg(event.target);
      if ((/((\band\b|\bor\b|\bnot\b)( (\band\b|\bor\b|\bnot\b))+)+/).test(event.target.value.toLowerCase())) {
        addErrorMsg(event.target, 'Operators cannot be used in between words');
      }
    }
  </script>
</body>

</html>