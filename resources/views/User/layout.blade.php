@php

    $currentPage    =   ''  ;
    $meta_type      =   ''  ;
    $currentDomain  =   Illuminate\Support\Facades\Request::getHost()   ;
    $social         =   \App\Models\SocialLink::limit(4)->get(['link', 'icon']) ;
    $blogCategory   =   \App\Models\BlogCategory::latest()->where('home_featured', 1)->limit(6)->get()  ;

@endphp

<!doctype html>
<html lang="en">

<head>
    @include('User.partial.header')
    @stack('css')
    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-WDKRQ7PV');
    </script>
    <!-- End Google Tag Manager -->
    <style>
        .flicker-on {
            animation: blinker-flicker 1s linear infinite;
        }

        @keyframes blinker-flicker {
            50% {
                box-shadow: 0 0 12px var(--basic-orange);
            }
        }

        .bottom-text {
            font-size: 23px;
        }

        @media (max-width: 400px) {
            .bottom-text {
                font-size: 20px
            }


            @media (max-width:770px) {
                .main-title {
                    display: none
                }
            }
        }
    </style>
</head>

<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WDKRQ7PV" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <header>
        <nav class="navbar navbar-expand-lg bg-white">
            <div class="container">
                <div class="col-12 col-lg d-flex justify-content-between">
                    <a class="navbar-brand me-0" href="{{ route('home') }}">
                        <img class="img-fluid" width="150" src="{{ config('setting.site_logo') }}" alt="">
                    </a>
                    <button class="btn navbar-toggler shadow-none border-0 px-0 ms-1" type="button"
                        data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
                <form
                    class="my-2 my-lg-0 order-0 order-lg-last mx-auto position-relative col-12 col-sm-8 col-md-6 col-lg-auto col-xl-3">
                    <input class="form-control  rounded-0 m-auto" type="search" placeholder="Search"
                        aria-label="Search" name="search">
                    <div class="position-absolute p-2 d-none w-100 border border-top-0 text-black overflow-auto bg-white shadow search_response-output overflow-y-auto z-3"
                        style="max-height:250px">
                        <span class="text-dark fw-bold text-uppercase border-bottom">Stores</span>
                        <ul class="list-unstyled pt-2 d-flex flex-column container-fluid mb-0" id="store">

                        </ul>
                        <hr>
                        <span class="text-dark fw-bold border-bottom text-uppercase">Coupons</span>

                        <ul class="list-unstyled pt-2 d-flex  flex-column container-fluid mb-0" id="coupon">

                        </ul>
                        <hr>
                        <span class="text-dark fw-bold border-bottom text-uppercase">Blogs</span>

                        <ul class="list-unstyled pt-2 d-flex flex-column container-fluid mb-0" id="blog">

                        </ul>
                    </div>
                </form>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    @if (count($blogCategory) > 0)
                        <ul class="navbar-nav mx-xl-auto mb-2 mb-lg-0 fw-bold gap-xl-3 gap-0" style="font-size:1.2rem">
                            @foreach ($blogCategory as $category)
                                <li class="nav-item">
                                    <div class="nav-dropdown-list position-relative">
                                        <a class="nav-link active" href="{{ route('blog_category', $category->slug) }}">
                                            {{ ucfirst($category->name) }}
                                        </a>
                                        <div class="position-absolute top-100 py-3 fw-semibold bg-white">
                                            <ul class="list list-unstyled">
                                                @php
                                                    $navBlogsLinks = \App\Models\Blog::where(
                                                        'category_id',
                                                        $category->id,
                                                    )
                                                        ->where('published_status', 1)
                                                        ->limit(5)
                                                        ->select(['slug','title'])
                                                        ->get();
                                                @endphp
                                                @foreach ($navBlogsLinks as $blog)
                                                    <li>
                                                        <a href="{{ route('blog_details', isset($blog) ? $blog->slug : '') }}"
                                                            class="text-decoration-none text-dark ps-3 py-2 d-block text-truncate">
                                                            {{ isset($blog) ? $blog->title : '' }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </nav>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample"
            aria-labelledby="offcanvasExampleLabel">
            <div class="offcanvas-header pb-0">
                <a class="navbar-brand" href="{{ route('home') }}">
                    <img class="img-fluid me-1" width="250" src="{{ config('setting.site_logo') }}" alt="">
                </a>
                <button type="button" class="btn-close fs-6 shadow-none" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body px-0 pt-0">
                @if (count($blogCategory) > 0)
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        @php
                            $i = 0;
                        @endphp
                        @foreach ($blogCategory as $category)
                            <div class="accordion-item border-0">
                                <p class="accordion-header " id="flush-headingOne">
                                    <button
                                        class="accordion-button custom-hover-01 custom-accordion-icon bg-transparent collapsed shadow-none fs-3 fw-bold"
                                        type="button" data-bs-toggle="collapse"
                                        data-bs-target="#flush-{{ $i }}" aria-expanded="false"
                                        aria-controls="flush-{{ $i }}">
                                        {{ ucfirst($category->name) }}
                                    </button>
                                 </p>
                                <div id="flush-{{ $i }}" class="accordion-collapse collapse"
                                    aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body p-0 small text-muted bg-transparent">
                                        <ul class="list-unstyled fw-semibold mb-0">
                                            @php
                                                $navBlogsLinks = \App\Models\Blog::where('category_id', $category->id)->where('published_status', 1)->limit(5)->select(['slug','title'])->get();
                                            @endphp
                                            @foreach ($navBlogsLinks as $blog)
                                                <li>
                                                    <a href="{{ route('blog_details', isset($blog) ? $blog->slug : '') }}" class="custom-list-hover d-block nav-link ps-5 py-1">
                                                        <div class="text-truncate" title="{{ isset($blog) ? $blog->title : '' }}">
                                                            {{ isset($blog) ? $blog->title : '' }}
                                                        </div>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <?php $i++; ?>
                        @endforeach
                    </div>
                @endif

                <ul class="list-unstyled d-flex ms-3 ps-1 mt-2 mb-4">
                    @foreach ($social as $linksSocial)
                        <li>
                            <a href="{{ $linksSocial->url }}" target="_blank" class="nav-link"><i
                                    class="{{ $linksSocial->icon }}"></i></a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </header>
    @yield('content')

    <footer>
        <section class="mx-md-3">
            <div class="mx-md-3 bg-dark mt-md-5">
                <div class="container py-5">
                    <a class="navbar-brand" href="{{ route('home') }}">
                        <img class="img-fluid" width="150" src="{{ !empty(config('setting.site_footer')) ? config('setting.site_footer') : config('setting.site_logo') }}" alt="">
                    </a>
                    <div class="row justify-content-between mt-4 pt-md-2">
                        <div class="col-lg-5 col-md-6">
                            <ul class="list-unstyled d-flex flex-wrap align-items-center gap-4 mb-4 text-white">
                                @foreach ($social as $linksSocial )
                                    <li>
                                        <a href="{{ $linksSocial->link }}" class="nav-link">
                                            <i class="{{ $linksSocial->icon }} fs-2"></i>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                            <div>
                                <p class="text-white">
                                    {{ config('setting.about') }}
                                </p>
                            </div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb text-uppercase x-small fw-bold"
                                    style="--bs-breadcrumb-divider-color : rgba(225,225,225,0.4);">
                                    <li class="breadcrumb-item font-poppins">
                                        <a href="{{ route('aboutus') }}"
                                            class="fw-medium text-decoration-none text-white">
                                            About US
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item font-poppins">
                                        <a href="{{ route('termsandconditions') }}"
                                            class="fw-medium text-decoration-none text-white">
                                            Terms And Conditions
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item font-poppins">
                                        <a href="{{ route('privacyandpolicy') }}"
                                            class="fw-medium text-decoration-none text-white">
                                            Privacy Policy
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item font-poppins">
                                        <a href="{{ route('impressum') }}"
                                            class="fw-medium text-decoration-none text-white">
                                            Imprint
                                        </a>
                                    </li>
                                </ol>
                            </nav>

                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="">
                                <form class="newsLetter text-white">
                                    @csrf
                                    <input type="hidden" name="page_url" value="{{ url()->current() }}">
                                    <input type="email" class="form-control py-2 rounded-1 shadow-none mb-2" placeholder="Email Address" id="" name="email" required>
                                    <button type='submit' class="btn custom-bg-02 text-uppercase w-100 fw-semibold mt-2 px-3 shadow">Subscribe</button>
                                    <div class="form-check my-3">
                                        <input class="form-check-input shadow-none" type="checkbox" id="footer-consent" name="is_consent">
                                        <label class="form-check-label lh-sm small" for="footer-consent">
                                        I consent to receiving marketing emails from ({{ strtolower(config('setting.site_name')) }})
                                        </label>
                                    </div>
                                    <span class="small text-start mt-0 ">We handpick the very best deals, trends and product news - making sure you never miss a thing</span>
                                </form>
                            </div>
                        </div>
                        <div class="col-12">
                             <div>
                                <p class="text-center text-white fw-medium mb-0 mt-lg-5 mt-3 small">
                                    &copy;️ Copyright @php echo date('Y') @endphp {{ucfirst(config('setting.site_name'))}} Disclosure: We may receive a commission if our readers make a purchase using our links.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </footer>
    <button type="button" class="btn btn-primary d-none CustomModalSubs" data-bs-toggle="modal"
        data-bs-target="#CustomModalSubs">
    </button>

    <div class="card cookie-alert position-fixed border bg-white rounded-3 p-1 m-2 end-0 bottom-0">
        <div class="card-body">
            <p class="card-text">&#x1F36A; We use cookies to ensure our website functions properly and to provide you
                with a personalized experience.</p>
            <div class="btn-toolbar justify-content-end">
                <button onclick="acceptCookies(0)" class="btn accept-cookies">Reject</button>
                <button onclick="acceptCookies(1)" class="btn btn-success accept-cookies">Accept</button>
            </div>
        </div>
    </div>


    <!-- Custom Modal -->
    <div class="modal fade" id="CustomModalSubs" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content bg-linear">
                <div class="CustomModalSubs-header">
                    <button type="button" class="close text-right m-1 me-2 outline_custum float-end border-0 bg-dark"
                        data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-white">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-white">
                    <div class="text-uppercase text-center">
                        <p class="mb-0 h2" style="margin-top: 0px">Stay in the loop with
                            {{ strtolower(config('setting.site_name')) }} </p>
                        <p class="mb-2 my-2">Signup Now for top notch shopping advice</p>
                        <input id="csrf_token" value="{{ csrf_token() }}" type="hidden" />
                        <form method="Post" class="newsLetter">
                            @csrf
                            <div class="my-lg-4 w-auto  mx-auto d-flex justify-content-center">
                                <span class="bg-white d-flex p-1 bg-white p-1 rounded-5 ">
                                    <input type="hidden" name="page_url" value="{{ url()->current() }}">
                                    <input type="email"
                                        class="border-0 w-100 rounded-pill text-dark ps-1 outline_custum"
                                        name="email" id="modal-sub" placeholder="Your Email Address">
                                    <button class="p-2 rounded-pill fw-bold bg-dark text-white">subscribe</button>
                                </span>
                            </div>
                            <div class="d-flex align-items-center justify-content-center gap-0 gap-lg-1 pb-1 pb-lg-2 "
                                style="font-size:10px !important;">
                                <input type="checkbox" name="is_consent" id="consent-18">
                                <label for="consent-18" class="lh-1 consent-box">
                                    I consent to receiving marketing emails from
                                    ({{ strtolower(config('setting.site_name')) }})
                                </label>
                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- Coupon MODAL --}}
    <div class="modal fade" id="searchCoupon" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content couponModal">

            </div>
        </div>
    </div>
    @include('User.partial.footer')
    @stack('js')
</body>

</html>
