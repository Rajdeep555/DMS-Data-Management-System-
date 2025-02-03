<?php
$url = $_SERVER['REQUEST_URI'];
$items = explode('/', $url);
$page = end($items);
?>
</head>
<?php
if ($page == 'button-builder.php') {
  echo '<body class="button-builder">';
} else {
  echo '<body>';
}
?>
<!-- loader starts-->
<div class="loader-wrapper">
  <div class="circular-loader">
    <div class="circular-loader__inner"></div>
  </div>
</div>
<!-- loader ends-->
<!-- tap on top starts-->
<div class="tap-top"><i data-feather="chevrons-up"></i></div>
<!-- tap on tap ends-->
<style>
  .loader-wrapper {
    height: 100vh;
    width: 100vw;
    display: flex;
    justify-content: center;
    align-items: center;
    position: fixed;
    z-index: 999999;
    background: #ffffff;
  }

  .circular-loader {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    position: relative;
    animation: rotate 1s linear infinite;
  }

  .circular-loader__inner {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    border: 3px solid transparent;
    border-top-color: #7366ff;
    border-right-color: #7366ff;
    filter: drop-shadow(0 0 8px rgba(115, 102, 255, 0.4));
  }

  @keyframes rotate {
    0% {
      transform: rotate(0deg);
    }

    100% {
      transform: rotate(360deg);
    }
  }
</style>