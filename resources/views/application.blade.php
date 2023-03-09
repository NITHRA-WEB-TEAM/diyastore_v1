<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <link rel="icon" href="/fav_icon.png" />
  <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0"/>

  <title>DiyaStore - Pooja items shopping</title>
  <link rel="stylesheet" type="text/css" href="/loader.css" />
  <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
{{--  <script type="application/javascript" src="https://securegw.paytm.in//merchantpgpui/checkoutjs/merchants/PYTMDM29354165830326.js"></script>--}}

{{--    <script type="application/javascript" src="https://securegw.paytm.in/merchantpgpui/checkoutjs/merchants/NITHRA89390541186008.js" ></script>--}}
  @vite(['resources/js/main.js'])
</head>

<body>
  <div id="app">
    <div id="loading-bg">
      <div class="loading-logo">
        <img src="/diyaLogo.png" alt="Logo" />
      </div>
{{--      <div class="loading">--}}
{{--        <div class="effect-1 effects"></div>--}}
{{--        <div class="effect-2 effects"></div>--}}
{{--        <div class="effect-3 effects"></div>--}}
{{--      </div>--}}
    </div>
  </div>

  <script>


    const loaderColor = localStorage.getItem('Vuexy-initial-loader-bg') || '#FFFFFF'
    const primaryColor = localStorage.getItem('Vuexy-initial-loader-color') || '#7367F0'

    if (loaderColor)
      document.documentElement.style.setProperty('--initial-loader-bg', loaderColor)
    if (primaryColor)
      document.documentElement.style.setProperty('--initial-loader-color', primaryColor)

  </script>
</body>

</html>
