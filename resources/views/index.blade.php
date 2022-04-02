<!doctype html>
<html lang="ar">

<head>
    <!-- Meta-->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="تطبيق سنام متخصص في الإبل وسلالاتها وألوانها وأنواعها ومستلزماتها ومعداتها وكل مايخصها

يوفر سنام منصة إلكترونية لإعلانات بيع والشراء الإبل وتصفحها بكل سهولة

يتيح تطبيق سنام للمستخدم إمكانية مشاهدة صور ومقاطع الفيديو والبحث بالمواقع و فرز الإعلانات المنشورة من المستخدمين و التواصل معهم.
 ">
    <!-- Title-->
    <title>تطبيق سنام | Snam App</title>
    <link rel="shortcut icon" type="image/png" href="{{asset('web/images/300x300bb.png')}}" />
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{asset('web/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('web/css/bootstrap-rtl.min.css')}}">
    <link rel="stylesheet" href="{{asset('web/fonts/fontawesome/css/all.css')}}">
    <link rel="stylesheet" href='{{asset('web/css/animate.css')}}'>
    <link rel="stylesheet" href="{{asset('web/css/style.css')}}">

    <style>
        footer{
            background: rgb(94,196,115);
            background: linear-gradient(249deg, rgba(94,196,115,1) 0%, rgba(5,187,178,1) 100%);
        }
        footer ul {
            display: flex;
            justify-content: center;
        }
        footer ul li {
            float: right;
            margin: 15px;
            text-align: center;
        }
    </style>
</head>

<body>
<header style="background-image: url('web/images/bg.png')">
    <nav class="navbar navbar-expand-xl  pt-4">
        <div class="container">
            <a href="">
                <img src="{{asset('web/images/logo.png')}}" class="img-fluid logo wow rollIn">
            </a>
            <button class="navbar-toggler " type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item mx-3 active">
                        <a class="nav-link " href="">
                            الرئيسيه
                        </a>
                    </li>
                    <li class="nav-item mx-3">
                        <a class="nav-link " href="#about">
                            عن التطبيق
                        </a>
                    </li>
                    <li class="nav-item mx-3">
                        <a class="nav-link " href="#download">
                            حمل التطبيق
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- intro -->
    <div class="container " id="intro">
        <div class="row">
            <div class="col-md-6 m-auto wow zoomIn">
                <img src="{{asset('web/images/1.png')}}" class="img-fluid p-5">
            </div>
        </div>
    </div>
</header>
<!-- about -->
<div class="container-fluid py-5 mt-5 about" id="about">
    <div class="row">

        <div class="col-md-6 m-auto wow fadeInLeft text-center" data-wow-offset="100">
            <h1 class="my-5 w-700">
                عن سنام
            </h1>
            <p class="py-2">
                تطبيق سنام متخصص في الابل و سلالاتها و الوانها و أنواعها و مستلزمات ومعداتها و كل مايخصها
            </p>
            <p class="py-2">
                يوفر سنام منصة إلكترونية لإعلانات بيع وشراء الابل و تصفحها بسهولة
            </p>
            <p class="py-2">
                يتيح تطبيق سنام للمستخدم إمكانية مشاهدة صور و مقاطع الفيديو و البحث بالموقع و فرز الإعلانات المنشورة من المستخدمين و التواصل معهم
            </p>
        </div>
    </div>
</div>
<!-- how to advert -->
<div class="container-fluid py-5 text-center" id="advert">

    <div class="m-auto">
        <h1 class="my-5 w-700">
            كل ما تحتاجه عن الإعلان
        </h1>
        <img src="{{asset('web/images/2.png')}}" class="img-fluid wow zoomIn d-inline-block" data-wow-offset="100">
        <img src="{{asset('web/images/3.png')}}" class="img-fluid wow zoomIn d-inline-block" data-wow-offset="100">
    </div>


</div>
<!-- download -->
<div class="container-fluid wow fadeInRight text-center pb-5" data-wow-offset="100" id="download">
    <div class="m-auto">
        <h1 class="my-5 w-700">
            حمل التطبيق الان
        </h1>
        <a href="https://apps.apple.com/us/app/%D8%B3%D9%86%D8%A7%D9%85-snam/id1506493352" target="_blanck">
            <img src="{{asset('web/images/apple.png')}}" class="img-fluid wow zoomIn d-inline-block" data-wow-offset="100">
        </a>
        <a href="https://play.google.com/store/apps/details?id=com.senam.senam" target="_blanck">
            <img src="{{asset('web/images/google.png')}}" class="img-fluid wow zoomIn d-inline-block" data-wow-offset="100">
        </a>
    </div>
</div>

<!-- footer -->
<footer class=" text-center ">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul>
                    <!--
                       <li>
                           <a href="" target="_blanck">
                               <img class="img-fluid" src="web/images/social/whatsapp.png">
                           </a>
                       </li>
                   -->
                    <li>
                        <a href="https://facebook.com/snamApp" target="_blanck">
                            <img class="img-fluid" src="{{asset('web/images/social/facebook.png')}}">
                        </a>
                    </li>
                    <li>
                        <a href="https://instagram.com/snamApp" target="_blanck">
                            <img class="img-fluid" src="{{asset('web/images/social/instagram.png')}}">
                        </a>
                    </li>
                    <li>
                        <a href="https://twitter.com/snamApp" target="_blanck">
                            <img class="img-fluid" src="{{asset('web/images/social/twitter.png')}}">
                        </a>
                    </li>
                    <li>
                        <a href="https://www.youtube.com/snamApp" target="_blanck">
                            <img class="img-fluid" src="{{asset('web/images/social/youtube.png')}}">
                        </a>
                    </li>
                    <li>
                        <a href="https://www.snapchat.com/add/snamapp" target="_blanck">
                            <img class="img-fluid" src="{{asset('web/images/social/snapchat.png')}}">
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-md-12 text-center">
                <h5 class="text-white my-5">
                    &copy;
                    جميع الحقوق محفوظة لمؤسسة سنام للتسويق الإلكتروني
                </h5>
            </div>
        </div>
    </div>

</footer>
<!--scripts -->

<script src="{{asset('web/js/jquery-3.2.1.min.js')}}"></script>
<script src="{{asset('web/js/bootstrap.min.js')}}"></script>
<script src="{{asset('web/js/wow.min.js')}}"></script>
<script src="{{asset('web/js/scripts.js')}}"></script>


</body>

</html>
