@extends('User.layout')
@section('title')
    {{ $blog->meta_title }}
@endsection
@section('content')
    @push('css')
        <style>
            #long-desc span:has(img) {
                width: auto !important;
                height: auto !important;
            }

            #long-desc img {
                max-width: 100%;
            }
        </style>
    @endpush
    <main>
        @if ($blog->page_type !== 0)
            {{-- ============================================= --}}
            {{-- FOR TOC --}}
            @if ($blog->page_type == 1)
                @push('css')
                    <link type="text/CSS" rel="stylesheet" href="{{ asset('user/assets/css/store_toc.css') }}">
                @endpush
                <!-- HEAD PANE START -->
                <section class="toc-section">
                    <div class="container pt-5">
                        <div class="small">
                            <span class="">

                                We may earn affiliate commissions for the recommended products. Learn more.
                            </span>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    {{-- <li class="breadcrumb-item"><a href="{{ route('blogs') }}">Blogs</a></li>
                                    <li class="breadcrumb-item">{!! $blog->title !!}</li> --}}
                                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{!! $blog->title !!}</li>
                                </ol>
                            </nav>
                        </div>
                        <div>
                            <h1>
                                {!! $blog->title !!}
                            </h1>
                            <div class="d-flex flex-wrap py-3 border-bottom">
                                <a href="#!" class="text-decoration-none">
                                    <div class="bg-for-hover rounded text-dark py-1 px-2 small w-fit-content w-fit-content">
                                        <p class="mb-0">
                                            test
                                            <span>
                                                <svg width="22" height="22" xmlns="http://www.w3.org/2000/svg"
                                                    fill="none" viewBox="9.91 12.4 75 71.33">
                                                    <path
                                                        d="M59.0009 12.3996L65.0463 23.7937L77.7509 26.0223L75.9444 38.7937L84.9127 48.0642L75.9444 57.3347L77.7509 70.1062L65.0463 72.3347L59.0009 83.7289L47.4127 78.0642L35.8246 83.7289L29.7792 72.3347L17.0746 70.1062L18.881 57.3347L9.91271 48.0642L18.881 38.7937L17.0746 26.0223L29.7792 23.7937L35.8246 12.3996L47.4127 18.0642L59.0009 12.3996Z"
                                                        fill="#0050DB"></path>
                                                    <rect x="43.1625" y="63.9349" width="8" height="33.4955"
                                                        transform="rotate(-133.73 43.1625 63.9349)" fill="white"></rect>
                                                    <rect x="48.5036" y="57.9499" width="8" height="19.8518"
                                                        transform="rotate(136.27 48.5036 57.9499)" fill="white"></rect>
                                                </svg>
                                            </span>
                                        </p>
                                    </div>
                                </a>
                                <div class="ms-2 ms-sm-3">
                                    <p class="mb-0 small py-1">
                                        Updated on: @php
                                            $createdAt = \Carbon\Carbon::parse($blog->updated_at)->format('F  d , Y');
                                        @endphp
                                        {{ $createdAt }}
                                    </p>
                                </div>
                                <div>
                                    <div class="py-1 ms-3 ">
                                        <p class="mb-0 small " style="color: #04d;"><svg xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 512 512" class="me-1" width="15" height="15"
                                                fill="#04d">
                                                <path
                                                    d="M160 368c26.5 0 48 21.5 48 48l0 16 72.5-54.4c8.3-6.2 18.4-9.6 28.8-9.6L448 368c8.8 0 16-7.2 16-16l0-288c0-8.8-7.2-16-16-16L64 48c-8.8 0-16 7.2-16 16l0 288c0 8.8 7.2 16 16 16l96 0zm48 124l-.2 .2-5.1 3.8-17.1 12.8c-4.8 3.6-11.3 4.2-16.8 1.5s-8.8-8.2-8.8-14.3l0-21.3 0-6.4 0-.3 0-4 0-48-48 0-48 0c-35.3 0-64-28.7-64-64L0 64C0 28.7 28.7 0 64 0L448 0c35.3 0 64 28.7 64 64l0 288c0 35.3-28.7 64-64 64l-138.7 0L208 492z" />
                                            </svg>31</p>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 py-3 border-bottom border-2 border-dark">
                                <div class="d-flex flex-wrap">

                                    <div class="d-flex flex-wrap align-items-center border-end pe-4">
                                        <div class="overflow-hidden">
                                            <img src="{{ asset('public/user/assets/images') . '/    ysolt-120x120.webp' }}"
                                                class="rounded-circle" alt="img" width="40" height="40"
                                                style="width:40px;height:40px;max-width:40px;">
                                        </div>
                                        <a href="#!" class="text-decoration-none ms-3 small">
                                            <p class="mb-0">
                                                {{ empty($blog->created_by) ? 'Admin' : $blog->created_by }},
                                            </p>
                                        </a>
                                        <p class="mb-0 ms-2 small">
                                            {{-- @dd($blogcategory) --}}
                                            {{ @$blogcategory->categories->name ?? 'Current Category' }} expert
                                        </p>
                                    </div>
                                    <div class="d-flex flex-wrap mt-3 mt-md-0 ps-md-4">
                                        <div class="d-flex flex-wrap justify-content-center align-items-center rounded-circle  border-1 border border-success"
                                            style="height: 40px;width: 40px;">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="16"
                                                height="16" fill="#090">
                                                <path
                                                    d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z" />
                                            </svg>
                                        </div>
                                        <div class="d-flex flex-wrap align-items-center    ps-2">
                                            <p class="mb-0 me-2 small">
                                                Fact-checked by,
                                            </p>

                                            <a href="#!" class="text-decoration-none me-3 small">
                                                <p class="mb-0">Admin</p>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- HEAD PANE END -->
                @push('js')
                    <script defer src="{{ asset('user/assets/js/store_toc.js') }}"></script>
                @endpush

                {{-- FOR TOC --}}
                {{-- ============================================= --}}
                {{-- FOR SINGLE COUPON TO DOUBLE --}}
            @elseif ($blog->page_type == 2)
                @push('css')
                    <link type="text/CSS" rel="stylesheet" href="{{ asset('user/assets/css/store_coupon.css') }}">
                @endpush
                {{-- main content --}}
                <div class="container">
                    <div class="row p-5">
                        <div class="col-md-12 text-center">
                            <h1 class="fs-large fw-semibold">{!! $blog->title !!}</h1>
                        </div>
                    </div>
                </div>
                {{-- main content --}}
                @push('js')
                    <script defer src="{{ asset('user/assets/js/store_coupon.js') }}"></script>
                @endpush
                {{-- FOR SINGLE COUPON TO DOUB0LE --}}
                {{-- ============================================= --}}
                {{-- FOR DETAILS WITH SLIDER --}}
            @elseif ($blog->page_type == 3)
                @push('css')
                    <link type="text/CSS" rel="stylesheet" href="{{ asset('user/assets/css/store_slider.css') }}">
                @endpush
                {{-- main content --}}
                <div class="container mt-4 mt-md-5">
                    <h1 class="fw-semibold"> {!! $blog->title !!}</h1>
                </div>
                {{-- main content --}}
                @push('js')
                    <script defer src="{{ asset('user/assets/js/store_slider.js') }}"></script>
                @endpush
                {{-- FOR DETAILS WITH SLIDER --}}
            @else
                <div class="container my-4 my-md-5">
                    <h1 class="fw-bold col-12 col-xxl-8 display-5">{!! $blog->title !!}</h1>
                    <p class="text-capitalize">
                        {{ empty($blog->created_by) ? 'Admin' : $blog->created_by }}
                        <span class="border-start border-2 px-2 text-capitalize">
                            @php
                                $createdAt = \Carbon\Carbon::parse($blog->updated_at)->format('F  d , Y');
                            @endphp
                            {{ $createdAt }}
                        </span>
                    </p>
                </div>
            @endif
            {{-- ============================================= --}}

            <section class="">
                <div class="{{ $blog->page_type == 3 ? ' ' : 'container' }}">
                    <div class="main-div-blog">
                        {!! $blog->long_description !!}
                    </div>
                </div>
            </section>
            {{-- ============================================= --}}
        @else
            {{-- MENTION THE ORIGINAL CODE HERE --}}
            <section class="mt-4 pt-md-0 pt-5">
                <div class="container pt-md-0 pt-5">
                    <div class="col-md-8 mt-md-3">
                        <div class="">
                            <nav style="--bs-breadcrumb-divider: '&#183;';" aria-label="breadcrumb">
                                <ol class="breadcrumb fw-semibold text-uppercase mb-0">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('blogs') }}" class="underline-hover nav-link">
                                            <p class="mb-2 x-small linkers">Home</p>
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('blog_category', $blog->categories->slug) }}"
                                            class="underline-hover nav-link d-flex align-items-end">
                                            <p class="mb-0 x-small linkers">{{ $blog->categories->name }}</p>
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <p class="mb-0 x-small linkers d-flex">{{ $blog->title }}</p>
                                    </li>
                                </ol>
                            </nav>
                            <h1 class="fs-1 h1 fw-bold">{{ $blog->title }}</h1>
                            <p class="small fw-semibold mb-0 linkers">By
                                <span class="text-dark text-decoration-underline custom-hover-03 linkers pe-auto"
                                    style="text-decoration-color: var(--basic-orange) !important;">{{ $blog->author ?? 'Admin' }}</span>
                            </p>
                            <p class="small fw-semibold mb-0 linkers">Published on {{ $blog->published_at }}</p>
                            <img src="{{ asset('images/blogsImages/' . $blog->image) }}" class="img-fluid w-100 mt-md-4 mt-2"
                                alt="{{ $blog->image_alt }}">
                        </div>
                        <div class="">
                            <div class="fw-semibold mt-3 font-poppins">
                                {!! $blog->short_description !!}
                            </div>
                            <div class="fw-semibold mt-3 font-poppins" id="long-desc">
                                {!! $blog->long_description !!}
                            </div>
                        </div>
                        <div class="bg-warning-subtle w-100 px-3 py-4">
                            <form class="newsLetter">
                                @csrf
                                <input type="hidden" name="page_url" value="{{ route(Route::currentRouteName()) }}">
                                <div class="">
                                    <div class="d-flex column-gap-md-4">
                                        <img src="https://assets3.thrillist.com/v1/image/3180660/size/_original;webp=auto;jpeg_quality=60.png"
                                            width="72" height="72" class="img-fluid h-100 d-none d-md-block"
                                            alt="">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h4 class="mb-2 fw-semibold fs-3 fw-bold lh-1">
                                                Sign Up For the {{ config('setting.site_name') }} Newsletter
                                            </h4>
                                            <p class="mb-0 fw-semibold lh-1">Exclusive product reviews, expert workout tips, and
                                                more, delivered to your inbox daily.</p>
                                        </div>
                                    </div>
                                    <div class="bg-white border mt-3 p-2 d-flex">
                                        <input type="email" class="form-control border-0 shadow-none" name="email"
                                            placeholder="Your Email Address">
                                        <button type="submit" class="btn custom-btn-03 rounded-0 fw-bold">Subscribe</button>
                                    </div>
                                    <div class="d-flex flex-wrap row-gap-2 justify-content-between mt-3">
                                        {{-- <div class="d-flex align-items-start gap-2">
                                            <input type="checkbox" name="is_consent" id="newsletter">
                                            <label class="lh-1 fw-semibold x-small" for="newsletter">I am 21+ years old</label>
                                        </div> --}}
                                        <div class="form-check">
                                            <input class="form-check-input shadow-none" type="checkbox" value="" name="is_consent" id="flexCheckDefault">
                                            <label class="form-check-label lh-1 fw-semibold x-small" for="flexCheckDefault">
                                                I consent to receiving marketing emails from
                                                ({{ strtolower(config('setting.site_name')) }})
                                            </label>
                                          </div>
                                        <div>
                                            <p class="mb-0 x-small fw-bold">
                                                By signing up, I agree to the Terms and Privacy Policy.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>

            <section>
                <div class="container pt-5">
                    <div class="col-md-8 mt-md-3 overflow-hidden position-relative readMoreSection">
                        <div class="">
                            <nav style="--bs-breadcrumb-divider: '&#183;';" aria-label="breadcrumb">
                                <ol class="breadcrumb fw-semibold text-uppercase mb-0">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('blogs') }}" class="underline-hover nav-link">
                                            <p class="mb-2 x-small linkers">Home</p>
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('blog_category', @$similar_blog->categories->slug) }}"
                                            class="underline-hover nav-link d-flex align-items-end">
                                            <p class="mb-0 x-small linkers">{{ $blog->categories->name }}</p>
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <p class="mb-0 x-small linkers d-flex">{{ @$similar_blog->title }}</p>
                                    </li>
                                </ol>
                            </nav>
                            <h2 class="fs-1 h1 fw-semibold">{{ @$similar_blog->title }}</h2>
                            <p class="small fw-semibold mb-0">By <a href="#"
                                    class="text-dark text-decoration-underline custom-hover-03 pe-auto"
                                    style="text-decoration-color: var(--basic-orange) !important;">{{ @$similar_blog->author ?? 'Admin' }}</a></p>
                            <p class="small fw-semibold mb-2 mb-md-0">Published on {{ @$similar_blog->published_at }}</p>
                            <img src="{{ asset('images/blogsImages/' . @$similar_blog->image) }}" class="img-fluid w-100 mt-md-4" alt="">
                            <nav style="--bs-breadcrumb-divider: '|';" aria-label="breadcrumb">
                                <ol class="breadcrumb fw-semibold text-uppercase mb-0">
                                    <li class="breadcrumb-item">
                                        <a href="#" class="underline-hover nav-link">
                                            <p class="mb-2 x-small ">Home</p>
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="#" class="underline-hover nav-link d-flex align-items-end">
                                            <p class="mb-0 x-small ">Home</p>
                                        </a>
                                    </li>
                                </ol>
                            </nav>
                        </div>
                        <div class="">
                            <p class="fw-semibold mt-3 font-poppins">
                                {!! @$similar_blog->short_description !!}
                            </p>
                            <p class="fw-semibold mt-3 font-poppins" id="long-desc">
                                {!! @$similar_blog->long_description !!}
                            </p>
                        </div>
                        <div id="bgFade"></div>
                    </div>
                    <div class="text-center col-md-8">
                        <button class="btn bg-primary-subtle rounded-0 fw-bold" onclick="readMore(this)">
                            Read Full Article
                        </button>
                    </div>
                </div>
            </section>

            <section class="mx-md-3 py-md-3 d-none d-md-block">
                <div class="bg-warning-subtle mx-md-3 my-md-5">
                    <div class="container py-3">
                        <h4 class="text-uppercase fs-5 pt-3">BLOGS</h4>
                        <div class="row gx-3 gy-4">
                            @foreach ($random_blogs as $random_blog)
                            <div class="col-md-3">
                                <a href="{{ route('blog_details',$random_blog->slug) }}" class="text-decoration-none text-dark">
                                    <div>
                                        <img src="{{ asset('images/blogsImages/' . $random_blog->image) }}" class="img-fluid w-100 object-fit-cover" style="height: 210px">
                                        <h5 class="mb-0 fs-5 fw-semibold lh-1 py-1">
                                            {{ $random_blog->title }}
                                        </h5>
                                        <p class="x-small text-body-tertiary fw-bold text-uppercase">
                                            {{ @$random_blog->categories->name }}
                                        </p>
                                    </div>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>

            <section>
                <div class="container mt-md-2 mt-4">
                    <div class="d-flex justify-content-between align-items-end pt-md-3 border-4 border-bottom mb-4 pb-2"
                        style="border-color: var(--basic-orange) !important;">
                        <h4 class="mb-0 display-5 fw-bold lh-1">Related</h4>
                    </div>
                    <div class="row">
                        <div class="col-md-8 row-gap-4 d-flex flex-column">
                            @foreach ($related_blogs as $related_blog)
                                <div class="underline-hover row gx-md-4 gx-0">
                                    <div class="col-9 col-md-8">
                                        <div class="x-small text-uppercase linkers">
                                            <a href="{{ route('blog_category', $related_blog->categories->slug) }}" class="text-decoration-none custom-color-01 fw-semibold">{{ $related_blog->categories->name }}</a>
                                            <span class="ps-2 fw-bold">{{ $related_blog->published_at }}</span>
                                        </div>
                                        <h5 class="mb-0 h4 fw-bold lh-1">
                                            <a href="{{ route('blog_details',$related_blog->slug) }}" class="nav-link">
                                                {{ $related_blog->title }}
                                            </a>
                                        </h5>
                                    </div>
                                    <div class="col-3 col-md-3">
                                        <a href="{{ route('blog_details',$related_blog->slug) }}">
                                            <img src="{{ asset('images/blogsImages/'.$related_blog->image) }}"
                                            class="img-fluid" alt="">
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                            <div class="d-flex justify-content-center">
                                <a href="{{ route('blog_category', $blog->categories->slug) }}" class="btn bg-primary-subtle rounded-0 fw-bold col-lg-5 col-md-6 col-sm-8 col-6">Load More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- MENTION THE ORIGINAL CODE HERE --}}
        @endif
    </main>
    @push('js')
        <script>
            $('.custom-shutter-text').html($('.text').val())
            $(document).ready(function() {
                let copyButton = new ClipboardJS('.copyCoupon');
                $(document).on('click', '.openModal', function(event) {
                    var newTab = window.open();
                    newTab.location.href = $(this).attr('data-url');
                });

            });
        </script>
    @endpush
    {{-- POPUP MODAL SINGLE --}}
    @if ($blog->modal == 1)
        @push('js')
            <script>
                setTimeout(() => {
                    $('#single-modal').click();
                }, 3000);
            </script>
        @endpush
        @push('css')
            <style>
                .modal-single-image {
                    width: 330px;
                    height: 330px;
                    max-width: 330px;
                    max-height: 330px;
                }

                @media(max-width:991px) {
                    .modal-single-image {
                        width: 100%;
                        height: 100%;
                    }
                }

                @media(max-width:575px) {
                    .modal-single-image {
                        width: 320px;
                        height: 320px;
                    }

                    .custom-dialog {
                        width: 320px !important;
                        margin: auto !important;
                    }
                }

                .btn-orange {
                    background-color: #ff6759 !important;
                    color: #F6F6FB !important;
                }
            </style>
        @endpush

        <!-- Button trigger modal -->
        <button id="single-modal" type="button" class="btn btn-primary d-none" data-bs-toggle="modal"
            data-bs-target="#singleModal"></button>

        <!-- Modal -->
        <div class="modal fade" id="singleModal" tabindex="-1" aria-labelledby="singleModalLabel" aria-hidden="true">
            <div class="custom-dialog modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content overflow-hidden rounded-0">

                    <button type="button" class="z-3 position-absolute top-0 me-1 mt-1 end-0 btn-close"
                        data-bs-dismiss="modal" aria-label="Close"></button>

                    <div class="modal-body p-0">
                        <div class="">
                            <div class="row mx-auto w-100 p-0">
                                <div class="col-md-4 col-lg-5 p-0">
                                    <div class="w-100 h-100 text-center mx-auto">
                                        <img width="300" height="300"
                                            src="{{ $blog->modal_img ? asset('images/modalImages' . '/' . $blog->modal_img) : config('setting.site_logo') }}"
                                            class=" object-fit-cover modal-single-image" alt="">
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-7 p-0 align-content-center">
                                    <div class="ps-3 pe-4 pt-4 pb-3 text-center">
                                        <p class="mb-2 mb-md-3 lh-sm fw-bold fs-4">
                                            {{ $blog->modal_title ?? 'Get Best Discounts on ' . $blog->title }}
                                        </p>
                                        <p class="mb-2 mb-md-3 lh-sm fs-7">
                                            {{ $blog->modal_description ?? 'Limited Time Offer!' }}
                                        </p>
                                        <div class="mb-2 mb-md-3">
                                            <a href="{{ $blog->modal_link }}" target="_blank"><button
                                                    class="rounded-0 px-lg-5 py-lg-3 fw-semibold py-2 px-3 btn btn-orange">Claim
                                                    Discount</button></a>
                                        </div>
                                        <div>
                                            <button type="button"
                                                class="text-decoration-underline small bg-transparent border-0 outline-none shadow-none"
                                                data-bs-dismiss="modal" aria-label="Close"><span>No Thanks I don't want
                                                    it</span></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endif
    {{-- POPUP MODAL SINGLE --}}

    @push('js')
        <script type='application/ld+json'>
        {
            "@context":"https://schema.org",
            "@graph":
            [
                {!! home_schema() !!},
                {
                "@type":"ImageObject",
                "@id":"{!! url()->current().'#primaryimage' !!}",
                "url":"{{ rtrim(config('setting.url'), '/') . '/images/blogsImages/' . $blog->image }}",
                "width":"718",
                "height":"449",
                "caption":"{{ $blog->image_alt }}"
                },
                {
                "@type":"WebPage",
                "@id":"{!!  url()->current().'#webpage' !!}",
                "url":"{!! url()->current()!!}",
                "inLanguage":"en-US",
                "name":"{!! config('metatags.meta_title') !!}",
                "description":"{!! config('metatags.meta_description') !!}",
                "isPartOf":
                {
                    "@id":"{{ route('blogs').'#website' }}"
                },
                "primaryImageOfPage":
                {
                    "@id":"{{ rtrim(config('setting.url'), '/') . '/images/blogsImages/' . $blog->image . '#primaryimage' }}"
                },
                "datePublished": "{{ \Carbon\Carbon::parse($blog->published_at)->toIso8601String() }}",
                "dateModified": "{{ !empty($blog->updated_at) ? \Carbon\Carbon::parse($blog->updated_at)->toIso8601String() : '' }}",
                "sameAs":[]
                }
            ]
        }
        </script>
        <script>
            $(document).ready(function() {
                let copyButton = new ClipboardJS('.copyCoupon');
                $(document).on('click', '.openModal', function(event) {
                    var newTab = window.open();
                    newTab.location.href = $(this).attr('data-url');
                });
                const accordionElements = document.querySelectorAll('.accordion-collapse');
                accordionElements.forEach(element => {
                    element.classList.remove('show');
                });
            });
        </script>
    @endpush
@endsection
