@extends('User.layout')
@section('title')
    Home
@endsection
@section('content')
    <main>

        <section>
            <div class="container mb-3">
                <div id="carouselExampleIndicators" class="mt-5 mt-lg-4 carousel slide">
                    <div class="carousel-indicators d-none d-lg-flex">
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                            aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                            aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                            aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">
                        @foreach ($slider as $item)
                            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                <a aria-label="redirector" href="{{ $item->link }}">
                                    <img src="{{ asset('images/slidersImages/' . $item->image) }}" width='1296'
                                        height='100%' class="" alt="{{ $item->image }}">
                                </a>
                            </div>
                        @endforeach


                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </section>

        <section>
            <div class="container pt-1">
                <div class="row g-4 d-flex">
                    <div class="col-lg-3 pb-5 pb-sm-2 pb-md-0 order-2">
                        <div class="border-top"
                            style="border-width: 20px !important; border-color: var(--basic-orange) !important;">
                            <h2 class="fw-bold mt-3 fs-1">The Latest</h2>
                            <ul class="list-unstyled mt-3 mt-md-4 d-flex flex-column gap-4">
                                @foreach ($latest_blogs as $blog)
                                    <li class="underline-hover">
                                        <a href="{{ route('blog_category', $blog->categories->slug) }}"
                                            class="text-decoration-none x-small text-uppercase custom-color-01 fw-semibold d-block mt-1 mb-1 mb-sm-0">
                                            {{ $blog->categories->name }}
                                        </a>
                                        <a href="{{ route('blog_details', $blog->slug) }}" class="nav-link">
                                            <h3 class="mb-0 h5 fw-bold">
                                                {{ $blog->title }}
                                            </h3>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-9 pb-4 pb-sm-2 pb-md-0 pt-4 pt-md-0 order-1">
                        <div class="underline-hover">
                            <div class="row flex-column-reverse flex-md-row gy-2">
                                <div class="col-md-4">
                                    <a href="{{ route('blog_category', $blog_featured->categories->slug) }}"
                                        class="text-decoration-none x-small text-uppercase custom-color-01 fw-semibold d-block mt-sm-1 pt-md-2 pb-2">
                                        {{ $blog_featured->categories->name }}
                                    </a>
                                    <a href="{{ route('blog_details', $blog_featured->slug) }}" class="nav-link">
                                        <h3 class="mb-0 h1 f-36px fw-bold">
                                            {{ $blog_featured->title }}
                                        </h3>
                                    </a>
                                </div>
                                <div class="col-md-8">
                                    <a href="{{ route('blog_details', $blog_featured->slug) }}" class="ratio ratio-16x9">
                                        <img src="{{ asset('images/blogsImages/' . $blog_featured->image ?? '') }}"
                                            class="img-fluid h-100 object-fit-cover" alt="">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3 mt-sm-5 gy-3">
                            @foreach ($blogs_featured as $blog)
                                <div class="col-md-4 pb-2 pb-md-0">
                                    <div class="underline-hover d-flex flex-md-column flex-row-reverse">
                                        <div class="ms-2 ms-md-0 col-4 col-md-12">
                                            <a href="{{ route('blog_details', $blog->slug) }}" class="ratio ratio-16x9">
                                                <img src="{{ asset('images/blogsImages/' . $blog->image ?? '') }}"
                                                    class="img-fluid h-100 object-fit-cover" alt="">
                                            </a>
                                        </div>
                                        <div class="">
                                            <a href="{{ route('blog_category', $blog->categories->slug) }}"
                                                class="text-decoration-none x-small text-uppercase custom-color-01 fw-semibold d-block mt-sm-1 py-2">
                                                {{ $blog->categories->name }}
                                            </a>
                                            <a href="{{ route('blog_details', $blog->slug) }}" class="nav-link">
                                                <h3 class="mb-0 h5 fw-bold text-ellipsis-3">
                                                    {{ $blog->title }}
                                                </h3>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="mt-3 container d-flex justify-content-center">
                    <a href="{{ route('blogs') }}" class="btn btn-outline-dark w-50 mt-2 rounded-0"> View More
                    </a>
                </div>
            </div>
        </section>

        <section>
            <div class="container mt-5 pt-md-3">
                <div class="d-flex justify-content-between align-items-end pt-md-3 mb-4 pb-2">
                    <h2 class="mb-0 display-3 fw-bold lh-1">Best Sellers</h2>
                </div>
            </div>
            <div class="container">
                <div class="splide pb-3" aria-label="best Seller" id="bestSeller">
                    <div class="splide__track">
                        <ul class="splide__list">
                            @foreach ($products as $product)
                                <li class="splide__slide">
                                    <div>
                                        <div class="nav-link underline-hover">
                                            <div class="">
                                                <a href="{{ @$product->tracking_url }}" target="_blank">
                                                    <div class="border-warning-subtle position-relative mx-auto mb-2"
                                                        style="border: 1rem solid;width:fit-content;">
                                                        @if ($product->is_discount == 1)
                                                            <div class="position-absolute top-0 start-0 w-100">
                                                                <div class="d-flex justify-content-center">
                                                                    <p
                                                                        class="mb-0 text-uppercase text-decoration-none text-dark fw-semibold bg-white small px-3 mt-1">
                                                                        <span
                                                                            class="text-danger text-decoration-line-through link-underline-danger">
                                                                            {{ \Illuminate\Support\Number::currency($product->price, $product->currency) }}
                                                                        </span>
                                                                        Now
                                                                        {{ round(100 - ($product->discounted_amount / $product->price) * 100) }}%
                                                                        Off
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        <img src="{{ asset('images/ProductImages/' . $product->image) }}"
                                                            class="mw-100 object-fit-cover" height="301" width="271"
                                                            alt="{{ $product->image_alt }}">
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="height-slide">
                                                <span
                                                    class="small custom-color-01 text-uppercase fw-bold">{{ @$product->categories->name }}</span>
                                                <div class="d-flex flex-column justify-content-between">
                                                    <a href="{{ @$product->tracking_url }}" target="_blank"
                                                        class="nav-link">
                                                        <h3 class="mb-2 mt-1 h6 fw-bold text-ellipsis-4">
                                                            {{ $product->name }}
                                                        </h3>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="">
                                                <div class="mb-2 h4">
                                                    <span>
                                                        @php
                                                            $price = $product->discounted_amount ?? $product->price;
                                                        @endphp
                                                        {{ \Illuminate\Support\Number::currency($product->discounted_amount ?? $product->price, $product->currency) }}
                                                    </span>
                                                </div>
                                                <a href="{{ @$product->tracking_url }}" target="_blank"
                                                    class="btn bg-primary-subtle rounded-0 w-100 fw-bold custom-btn-04 py-1">
                                                    Buy at {{ @$product->stores->name }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="container p-2">
                    <p class="x-small fw-semibold pt-5">
                        While each product featured is independently selected by our editors, we may include paid
                        promotion. If you buy something through our links, we may earn commission. Read more about our
                        <a href="{{ route('aboutus') }}" class="text-dark custom-hover-03"
                            style="text-decoration-color: var(--basic-orange);">Product Review Guidelines here</a>.
                    </p>
                </div>
            </div>
        </section>

        @if (count($blogcategories) > 0)
            @foreach ($blogcategories as $category)
                <section>
                    <div class="container mt-5 mb-4">
                        <div class="d-flex justify-content-between align-items-end pt-md-3 border-4 border-bottom mb-4 pb-2"
                            style="border-color: var(--basic-orange) !important;">
                            <h2 class="mb-0 display-3 fw-bold lh-1">{{ ucfirst($category->name) }}</h2>
                            <a href="{{ route('blog_category', $category->slug) }}"
                                class="nav-link underline-hover d-none d-md-block">
                                <p class="mb-0 fw-semibold lh-1 linkers text-uppercase">More
                                    {{ ucfirst($category->name) }}
                                    <span class="fs-4">&#8250;</span>
                                </p>
                            </a>
                        </div>
                        <div class="row gy-3 mt-md-3">
                            @php
                                $blogsByCate = \App\Models\Blog::where('category_id', $category->id)
                                    ->limit(4)
                                    ->where('published_status', 1)
                                    ->where('home_featured', 1)
                                    ->get();
                            @endphp
                            @foreach ($blogsByCate as $blog)
                                <div class="col-md-3">
                                    <div class="underline-hover row gx-2 mb-2 mb-md-0">
                                        <div class="col-md-12 col-4 flex-grow-1 position-relative">
                                            <a href="{{ route('blog_details', $blog->slug) }}"
                                                class="nav-link pe-2 pe-md-0 ratio ratio-1x1">
                                                <img src="{{ asset('images/blogsImages/' . $blog->image) }}"
                                                    class="img-fluid object-fit-cover" alt="" height="350px">
                                            </a>
                                            <div class="position-absolute top-0 start-0">
                                                <div
                                                    class="p-2 d-flex align-items-center justify-content-center rounded-circle m-2 custom-bg-03">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="#fff" viewBox="0 0 448 512">
                                                        <path
                                                            d="M0 80L0 229.5c0 17 6.7 33.3 18.7 45.3l176 176c25 25 65.5 25 90.5 0L418.7 317.3c25-25 25-65.5 0-90.5l-176-176c-12-12-28.3-18.7-45.3-18.7L48 32C21.5 32 0 53.5 0 80zm112 32a32 32 0 1 1 0 64 32 32 0 1 1 0-64z" />
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-8 fw-bold">
                                            <a href="{{ route('blog_category', $category->slug) }}"
                                                class="text-decoration-none custom-color-01 x-small d-block mt-md-2 mb-md-1 mb-0 linkers pb-2 pb-md-0 text-uppercase">{{ ucfirst($category->name) }}</a>
                                            <a href="{{ route('blog_details', $blog->slug) }}"
                                                class="nav-link pe-2 pe-md-0">
                                                <h3 class="mb-0 lh-1 h5 fw-bold text-ellipsis-4">
                                                    {{ isset($blog) ? $blog->title : '' }}
                                                </h3>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            @endforeach
        @endif
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

        <div class="modal fade" id="CustomModalSubs" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content" style="background:#FED33C">
                    <div class="CustomModalSubs-header">
                        <button type="button" class="close text-right m-1 me-2 outline_custum float-end border-0"
                            style="background:#FED33C" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex justify-content-center mb-3">
                            <img src="{{ config('setting.site_logo') }}" class="img-fluid" width="100"
                                alt="logo">
                        </div>
                        <form class="text-uppercase text-center newsLetter">
                            <input type="hidden" id="csrf_token" value="{{ csrf_token() }}" name="_token">
                            <p class="mb-0 h2">Stay in the loop with {{ config('setting.site_name') }}</p>
                            <p class="mb-2 my-2">Signup Now for top notch shopping advice</p>
                            <div class="my-lg-4 w-auto  mx-auto d-flex justify-content-center">
                                <span class="bg-white d-flex p-1 bg-white p-1 rounded-5 ">
                                    <input type="hidden" name="page_url"
                                        value="{{ route(Route::currentRouteName()) }}">
                                    <input type="email"
                                        class="border-0 w-100 rounded-pill text-dark ps-1 outline_custum form-control shadow-none"
                                        name="email" placeholder="Your Email Address">
                                    <button type="submit"
                                        class="p-2 rounded-pill fw-bold bg-dark text-white">subscribe</button>
                                </span>
                            </div>
                            <div class="d-flex justify-content-center mt-3">
                                <div class="form-check col-md-auto col-11">
                                    <input class="form-check-input shadow-none" type="checkbox" id="consent-02"
                                        name="is_consent">
                                    <label class="form-check-label small" for="consent-02">
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
    </main>
    @push('js')
        <script type="application/ld+json">
            {
            "@context": "https://schema.org",
            "@type": "Organization",
            "name": "{!! config('metatags.meta_title') !!}",
            "description": "{!! config('metatags.meta_description') !!}",
            "url": "{{ config('setting.url') }}",
            "logo": {
                "@type": "ImageObject",
                "url": "{{ config('setting.url').config('setting.site_logo') }}"
            },
            "image": {
                "@type": "ImageObject",
                "url": "{{ config('setting.url').config('setting.site_logo') }}"
            },
            "sameAs": [
                "https://www.instagram.com/activecorefit.official/",
                "https://www.facebook.com/activecorefit/"
            ],
            "address": {
                "@type": "PostalAddress",
                "addressCountry": "USA"
            }
            }
        </script>
        <!-- Include CopySheriff from CDN -->
        <!-- Include clipboard-copy from CDN -->
        <script src="{{ asset('user/assets/js/clipboard.min.js') }}"></script>

        <script>
            $('.custom-shutter-text').html($('.text').val())
            $(document).ready(function() {
                let copyButton = new ClipboardJS('.copyCoupon');
                $(document).on('click', '.openModal', function(event) {
                    var newTab = window.open();
                    newTab.location.href = $(this).attr('data-url');
                });
            });


            let cookies_modal;
            // Function to open the custom modal with delay
            function openCustomModalWithDelay() {
                clearTimeout(modalTimeout); // Clear any previous timeout to prevent multiple triggers

                modalTimeout = setTimeout(() => {
                    let isAnyModalOpen = document.querySelector(".modal.show") !== null;

                    if (!isAnyModalOpen && !getCookie("Item_showes")) {
                        let modal_open_btn = document.getElementsByClassName("CustomModalSubs")[0];
                        modal_open_btn.click();
                        setSessionCookie("Item_showes", "YES");
                    }
                }, 3000); // 3-second delay
            }
            window.addEventListener("load", () => {

                cookies_modal = document.getElementsByClassName("cookie-alert")[0];

                if (
                    !getCookie("consent") &&
                    !getCookie("analyticsData") &&
                    !getCookie("Rejected")
                ) {
                    cookies_modal.classList.add("show_cookie");
                }

                // Initial call to open modal with delay if no modal is open
                openCustomModalWithDelay();

                // Event listener for modal close
                document.addEventListener("hidden.bs.modal", () => {
                    // Call to open the custom modal after any other modal closes
                    openCustomModalWithDelay();
                });
            });

            function acceptCookies(e) {
                if (!getCookie("consent") && !getCookie("analyticsData") && e == 1) {
                    setSessionCookie("consent", "true");
                    setSessionCookie("analyticsData", JSON.stringify({
                        pageViews: 1000
                    }));
                    cookies_modal.classList.remove("show_cookie");
                } else if (!getCookie("consent") && !getCookie("analyticsData") && e == 0) {
                    cookies_modal.classList.remove("show_cookie");
                    setSessionCookie("Rejected", "True");
                }
            }

            function setSessionCookie(name, value) {
                document.cookie = `${name}=${encodeURIComponent(value)}; path=/`;
            }

            function getCookie(name) {
                const cookies = document.cookie.split("; ");
                for (const cookie of cookies) {
                    const [cookieName, cookieValue] = cookie.split("=");
                    if (cookieName === name) {
                        return decodeURIComponent(cookieValue);
                    }
                }
                return null;
            }
        </script>
    @endpush
@endsection
