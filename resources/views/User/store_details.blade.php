@extends('User.layout')
@section('title')
    {{ $store->meta_title }}
@endsection
@section('content')
 
@php
use Illuminate\Support\Str;
        if (request()->get('sortby') == 'newest') {
            $store = \App\Models\Store::where('id', $store->id)
                ->with([
                    'coupons' => function ($query) {
                        $query
                            ->where(function ($query) {
                                $query
                                    ->whereDate('created_at', '=', now()->toDateString())
                                    ->orWhereDate('created_at', '=', now()->addDay()->toDateString());
                            })
                            ->orderBy('created_at', 'desc');
                    },
                ])
                ->first();
        } elseif (request()->get('sortby') == 'popularity') {
            $store = \App\Models\Store::where('id', $store->id)
                ->with([
                    'coupons' => function ($query) {
                        $query->where('exclusive_button', 1)->get();
                    },
                ])
                ->first();
        } elseif (request()->get('sortby') == 'ending') {
            $store = \App\Models\Store::where('id', $store->id)
                ->with([
                    'coupons' => function ($query) {
                        $query->where('expiry_date', '>=', now())->orderBy('expiry_date', 'asc')->get();
                    },
                ])
                ->first();
        } elseif (request()->get('sortby') == 'expired') {
            $store = \App\Models\Store::where('id', $store->id)
                ->with([
                    'coupons' => function ($query) {
                        $query->where('expiry_date', '<=', now())->orderBy('expiry_date', 'desc')->get();
                    },
                ])
                ->first();
        }
    @endphp
    <main>
        @if ($store->page_type !== 0)
            @push('css')
                <style>
                    img {
                        max-width: 100%;
                    }
                </style>
            @endpush
            {{-- ============================================= --}}
            {{-- FOR TOC --}}
            @if ($store->page_type == 1)
                @push('css')
                    <link type="text/CSS" rel="stylesheet" href="{{ asset('user/assets/css/store_toc.css') }}">
                @endpush
                <!-- HEAD PANE START -->
                <section>
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
                                    <li class="breadcrumb-item active" aria-current="page">{!! $store->name !!}</li>
                                </ol>
                            </nav>
                        </div>
                        <div>
                            <h1>
                                {!! $store->name !!}
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
                                            $createdAt = \Carbon\Carbon::parse($store->updated_at)->format('F  d , Y');
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
                                                {{ empty($store->created_by) ? 'Admin' : $store->created_by }},
                                            </p>
                                        </a>
                                        <p class="mb-0 ms-2 small">
                                            {{-- @dd($blogcategory) --}}
                                            {{ @$storecategory->categories->name ?? 'Current Category' }} expert
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
            @elseif ($store->page_type == 2)
                @push('css')
                    <link type="text/CSS" rel="stylesheet" href="{{ asset('user/assets/css/store_coupon.css') }}">
                @endpush
                {{-- main content --}}
                <div class="container">
                    <div class="row p-5">
                        <div class="col-md-12 text-center">
                            <h1 class="fs-large fw-semibold">{!! $store->name !!}</h1>
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
            @elseif ($store->page_type == 3)
                @push('css')
                    <link type="text/CSS" rel="stylesheet" href="{{ asset('user/assets/css/store_slider.css') }}">
                @endpush
                {{-- main content --}}
                <div class="container mt-4 mt-md-5">
                    <h1 class="fw-semibold"> {!! $store->name !!}</h1>
                </div>
                {{-- main content --}}
                @push('js')
                    <script defer src="{{ asset('user/assets/js/store_slider.js') }}"></script>
                @endpush
            @else
                <div class="container my-4 my-md-5">
                    <h1 class="fw-bold col-12 col-xxl-8 display-5">{!! $store->name !!}</h1>
                    <p class="text-capitalize">
                        {{ empty($store->created_by) ? 'Admin' : $store->created_by }}
                        <span class="border-start border-2 px-2 text-capitalize">
                            @php
                                $createdAt = \Carbon\Carbon::parse($store->updated_at)->format('F  d , Y');
                            @endphp
                            {{ $createdAt }}
                        </span>
                    </p>
                </div>
            @endif
            {{-- FOR DETAILS WITH SLIDER --}}
            {{-- ============================================= --}}

            <section class="">
                <div class="{{ $store->page_type == 3 ? ' ' : 'container' }}">
                    <div class="main-div-blog">
                        {!! $store->long_description !!}
                    </div>
                </div>
            </section>
        @else
            {{-- MENTION THE ORIGINAL CODE HERE --}}
            <section>
                <div class="container border-bottom pb-md-3 px-0 px-lg-2 pt-3 pt-md-0">
                    <div class="row mx-auto w-100 px-lg-1">
                        <div class="d-flex flex-column align-items-lg-center col-12 col-lg">
                            <div class="border border-2 p-2 border-hover-01 d-flex justify-content-center h-100"
                                title="{{ $store->name }}">
                                <img src="{{ asset('images/StoreImages/' . $store->image) }}" class="mw-100"
                                    height="{{ @$imageSize->height }}" width="{{ @$imageSize->width }}" alt="">
                            </div>
                        </div>
                        <div class="col-lg-9 mt-3 mt-lg-0">
                            <div class="ps-lg-1">
                                <h1 class="fs-3 mb-1"> <strong>{{ $store->name }} </strong> 100% Trusted
                                    {{ @$store->headings->name . ' ' . date('Y') }}</h1>
                                <p>
                                    {!! $store->short_description !!}
                                </p>
                            </div>
                            <div class="ps-lg-1">
                                <ul class="list-unstyled d-flex flex-wrap gap-1" id="SocialIcons">
                                    @foreach ($social as $linksSocial)
                                        <li>
                                            <a href="{{ @$linksSocial->link }}"
                                                class="nav-link d-flex align-items-center gap-1 border border-secondary-subtle rounded-1 px-1">
                                                <i class="{{ @$linksSocial->icon }}"></i>
                                                <p class="fw-light mb-0">{{ @$linksSocial->name }}</p>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section>
                <div class="container">
                    <div class="row pt-md-4 flex-lg-row-reverse">
                        <div class="col-lg-8">
                            <div class="">
                                <ul class="nav gap-2 ms-lg-2 my-3 my-lg-0" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="btn btn-outline-light text-dark shadow-sm px-3 py-1 active"
                                            id="all-tab" data-bs-toggle="tab" data-bs-target="#all-tab-pane"
                                            type="button" role="tab" aria-controls="all-tab-pane"
                                            aria-selected="true">
                                            <div class="d-flex align-items-center justify-content-center gap-2">
                                                <h2 class="mb-0 x-small fw-bold">All</h2>
                                                <span
                                                    class="bg-dark p-1 text-white rounded-1 lh-1">{{ @$store->coupons->count() ?? 0 }}</span>
                                            </div>
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="btn btn-outline-light text-dark shadow-sm py-1 px-3" id="codes-tab"
                                            data-bs-toggle="tab" data-bs-target="#codes-tab-pane" type="button"
                                            role="tab" aria-controls="codes-tab-pane" aria-selected="false">
                                            <div class="d-flex align-items-center justify-content-center gap-2">
                                                <h2 class="mb-0 x-small fw-bold">Codes</h2>
                                                <span
                                                    class="custom-bg-01 p-1 text-white rounded-1 lh-1">{{ @$store->coupons->where('coupon_type', 1)->count() ?? 0 }}</span>
                                            </div>
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="btn btn-outline-light text-dark shadow-sm py-1 px-3" id="sale-tab"
                                            data-bs-toggle="tab" data-bs-target="#sale-tab-pane" type="button"
                                            role="tab" aria-controls="sale-tab-pane" aria-selected="false">
                                            <div class="d-flex align-items-center justify-content-center gap-2">
                                                <h2 class="mb-0 x-small fw-bold">Deal</h2>
                                                <span
                                                    class="bg-warning p-1 text-white rounded-1 lh-1">{{ @$store->coupons->where('coupon_type', 0)->count() ?? 0 }}</span>
                                            </div>
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="btn btn-outline-light text-dark shadow-sm py-1 px-3"
                                            id="verified-tab" data-bs-toggle="tab" data-bs-target="#verified-tab-pane"
                                            type="button" role="tab" aria-controls="verified-tab-pane"
                                            aria-selected="false">
                                            <div class="d-flex align-items-center justify-content-center gap-2">
                                                <h2 class="mb-0 x-small fw-bold">Verified</h2>
                                                <span
                                                    class="bg-dark p-1 text-white rounded-1 lh-1">{{ @$store->coupons->where('verified_button', 1)->count() ?? 0 }}</span>
                                            </div>
                                        </button>
                                    </li>
                                </ul>
                            </div>
                            <div class="">
                                <div class="tab-content pt-2 pt-md-4" id="myTabContent">
                                    <div class="tab-pane fade show active" id="all-tab-pane" role="tabpanel"
                                        aria-labelledby="all-tab" tabindex="0">
                                        @foreach ($store->coupons as $coupon)
                                            <div class="">
                                                <input type="hidden" class="coupon-code-input"
                                                    value="{{ $coupon->coupon_code }}" id="code{{ $coupon->id }}"
                                                    readonly>
                                                <div
                                                    class="row gy-2 gx-1 gx-lg-3 justify-content-start mb-4 mb-lg-3 w-100 mx-auto">
                                                    <div
                                                        class="col-lg-3 col-5 d-flex justify-content-start align-items-start">
                                                        <div class="border border-2 p-2 border-hover-01 ratio ratio-1x1"
                                                            title="{{ $store->name }}">
                                                            <img src="{{ asset('images/StoreImages/' . $store->image) }}"
                                                                width="150" class="img-fluid" alt="">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-7 d-flex align-items-center ps-1 ps-lg-0">
                                                        <div>
                                                            <div class="mb-3">
                                                                <span
                                                                    class="@if ($coupon->coupon_type == 1) custom-bg-01 @else bg-warning @endif text-white text-uppercase px-2 fw-semibold small py-1">
                                                                    @if ($coupon->coupon_type == 1)
                                                                        code
                                                                    @else
                                                                        deal
                                                                    @endif
                                                                </span>
                                                            </div>
                                                            <h3 class="mb-1 fs-5">
                                                                {{ str_replace('-', ' ', $coupon->offer_name) }}
                                                            </h3>
                                                            <div class="d-flex flex-wrap align-items-center gap-1 mb-1">
                                                                <span class="small fw-semibold text-body-secondary">
                                                                    Expires:
                                                                    {{ \Carbon\Carbon::parse(@$coupon->expiry_date)->format('d F Y') }}
                                                                </span>
                                                            </div>
                                                            <p class="mb-1 fw-bold small d-none d-md-block">
                                                                {{ str_replace('-', ' ', $coupon->shipping_offer) }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="col-lg-3 col-md-5 col-8 d-flex align-items-end ms-lg-auto mx-auto mt-3 mt-lg-0">
                                                        <div class="w-100">
                                                            <div class="">
                                                                @if ($coupon->coupon_type == 1)
                                                                    <div class="text-decoration-none text-dark position-relative w-100 copyCoupon openModal @if ($coupon->flicker_button == 1) flicker-on @endif "
                                                                        data-clipboard-target="#code{{ $coupon->id }}"
                                                                        data-url="{{ $store->tracking_url ?? '' }}"
                                                                        data-id="{{ $coupon->id }}"
                                                                        data-bs-toggle="tooltip"
                                                                        data-bs-title="Click to copy and open site">
                                                                        <div
                                                                            class="d-block position-relative text-center coupon_custom_btn">
                                                                            <div
                                                                                class="lh-lg fs-5 w-100 fw-bold text-uppercase text-end pe-3">
                                                                               {!! \Illuminate\Support\Str::substr(strip_tags($coupon->coupon_code), -3) !!}

                                                                                {{-- {{ $coupon->coupon_code }} --}}
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="d-block position-absolute top-0 end-0 w-100 overflow-hidden small coupons_custom_btn border border-2 rounded-1">
                                                                            <div
                                                                                class="position-absolute top-0 overflow-hidden">
                                                                                <button
                                                                                    class="d-flex justify-content-center align-items-center custom-bg-01 small p-1 border-0 text-center text-uppercase text-white fw-bold ps-3 h-100">
                                                                                    <span class="h6 fw-bold mb-auto mt-1">
                                                                                        get code
                                                                                    </span>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    <button
                                                                        class="btn btn-warning rounded-1 text-white fw-semibold w-100 d-flex justify-content-center openModal @if ($coupon->flicker_button == 1) flicker-on @endif"
                                                                        data-url="{{ $store->tracking_url ?? '' }}"
                                                                        data-id="{{ $coupon->id }}">
                                                                        <div class="d-flex align-items-center gap-1">
                                                                            Get Deal
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                width="1rem" height="1rem"
                                                                                fill="#fff" viewBox="0 0 576 512">
                                                                                <path
                                                                                    d="M0 24C0 10.7 10.7 0 24 0L69.5 0c22 0 41.5 12.8 50.6 32l411 0c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3l-288.5 0 5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5L488 336c13.3 0 24 10.7 24 24s-10.7 24-24 24l-288.3 0c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5L24 48C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z" />
                                                                            </svg>
                                                                        </div>
                                                                    </button>
                                                                @endif
                                                            </div>
                                                            <div class="d-flex align-items-center pt-2 gap-1 px-2 px-md-0">
                                                                <ul class="list-group list-group-horizontal flex-grow-1">
                                                                    <li
                                                                        class="list-group-item list-group-item-action p-1 text-center d-flex align-items-center justify-content-center">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            width="1rem" fill="#999999" height="1rem"
                                                                            viewBox="0 0 512 512" data-bs-toggle="tooltip"
                                                                            data-bs-title="This Worked">
                                                                            <path
                                                                                d="M464 256A208 208 0 1 0 48 256a208 208 0 1 0 416 0zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256zm177.6 62.1C192.8 334.5 218.8 352 256 352s63.2-17.5 78.4-33.9c9-9.7 24.2-10.4 33.9-1.4s10.4 24.2 1.4 33.9c-22 23.8-60 49.4-113.6 49.4s-91.7-25.5-113.6-49.4c-9-9.7-8.4-24.9 1.4-33.9s24.9-8.4 33.9 1.4zM144.4 208a32 32 0 1 1 64 0 32 32 0 1 1 -64 0zm192-32a32 32 0 1 1 0 64 32 32 0 1 1 0-64z" />
                                                                        </svg>
                                                                    </li>
                                                                    <li
                                                                        class="list-group-item list-group-item-action p-1 text-center d-flex align-items-center justify-content-center">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            width="1rem" fill="#999999" height="1rem"
                                                                            viewBox="0 0 512 512" data-bs-toggle="tooltip"
                                                                            data-bs-title="It didn't work">
                                                                            <path
                                                                                d="M464 256A208 208 0 1 0 48 256a208 208 0 1 0 416 0zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256zM174.6 384.1c-4.5 12.5-18.2 18.9-30.7 14.4s-18.9-18.2-14.4-30.7C146.9 319.4 198.9 288 256 288s109.1 31.4 126.6 79.9c4.5 12.5-2 26.2-14.4 30.7s-26.2-2-30.7-14.4C328.2 358.5 297.2 336 256 336s-72.2 22.5-81.4 48.1zM144.4 208a32 32 0 1 1 64 0 32 32 0 1 1 -64 0zm192-32a32 32 0 1 1 0 64 32 32 0 1 1 0-64z" />
                                                                        </svg>
                                                                    </li>
                                                                    <li
                                                                        class="list-group-item list-group-item-action p-1 text-center d-flex align-items-center justify-content-center">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            width="1rem" fill="#999999" height="1rem"
                                                                            viewBox="0 0 576 512" data-bs-toggle="tooltip"
                                                                            data-bs-title="Save this coupon">
                                                                            <path
                                                                                d="M287.9 0c9.2 0 17.6 5.2 21.6 13.5l68.6 141.3 153.2 22.6c9 1.3 16.5 7.6 19.3 16.3s.5 18.1-5.9 24.5L433.6 328.4l26.2 155.6c1.5 9-2.2 18.1-9.7 23.5s-17.3 6-25.3 1.7l-137-73.2L151 509.1c-8.1 4.3-17.9 3.7-25.3-1.7s-11.2-14.5-9.7-23.5l26.2-155.6L31.1 218.2c-6.5-6.4-8.7-15.9-5.9-24.5s10.3-14.9 19.3-16.3l153.2-22.6L266.3 13.5C270.4 5.2 278.7 0 287.9 0zm0 79L235.4 187.2c-3.5 7.1-10.2 12.1-18.1 13.3L99 217.9 184.9 303c5.5 5.5 8.1 13.3 6.8 21L171.4 443.7l105.2-56.2c7.1-3.8 15.6-3.8 22.6 0l105.2 56.2L384.2 324.1c-1.3-7.7 1.2-15.5 6.8-21l85.9-85.1L358.6 200.5c-7.8-1.2-14.6-6.1-18.1-13.3L287.9 79z" />
                                                                        </svg>
                                                                    </li>
                                                                </ul>
                                                                <p
                                                                    class="mb-0 x-small lh-1 fw-semibold text-body-tertiary">
                                                                    100%
                                                                    SUCCESS </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div
                                                            class="border-top @if ($coupon->verified_button == 1 || $coupon->exclusive_button == 1) border-bottom @endif py-2 px-md-4">
                                                            <ul class="list-unstyled mb-0 d-flex flex-wrap gap-2">
                                                                @if ($coupon->verified_button == 1)
                                                                    <li class="d-flex align-items-center x-small fw-bold gap-1"
                                                                        style="color:var(--bs-form-valid-color)">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            viewBox="0 0 448 512" width="1rem"
                                                                            height="1rem"
                                                                            fill="var(--bs-form-valid-color)">
                                                                            <path
                                                                                d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z" />
                                                                        </svg>
                                                                        Verified
                                                                    </li>
                                                                @endif
                                                                @if ($coupon->exclusive_button == 1)
                                                                    <li
                                                                        class="d-flex align-items-center x-small fw-bold gap-1 text-primary">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            viewBox="0 0 512 512" width="1rem"
                                                                            height="1rem" fill="var(--bs-primary-rgb)">
                                                                            <path
                                                                                d="M168.5 72L256 165l87.5-93-175 0zM383.9 99.1L311.5 176l129 0L383.9 99.1zm50 124.9L256 224 78.1 224 256 420.3 433.9 224zM71.5 176l129 0L128.1 99.1 71.5 176zm434.3 40.1l-232 256c-4.5 5-11 7.9-17.8 7.9s-13.2-2.9-17.8-7.9l-232-256c-7.7-8.5-8.3-21.2-1.5-30.4l112-152c4.5-6.1 11.7-9.8 19.3-9.8l240 0c7.6 0 14.8 3.6 19.3 9.8l112 152c6.8 9.2 6.1 21.9-1.5 30.4z" />
                                                                        </svg>
                                                                        Exclusive
                                                                    </li>
                                                                @endif
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="tab-pane fade" id="codes-tab-pane" role="tabpanel"
                                        aria-labelledby="codes-tab" tabindex="0">
                                        @foreach ($store->coupons as $coupon)
                                            @if ($coupon->coupon_type == 1)
                                                <div>
                                                    <input type="hidden" class="coupon-code-input"
                                                        value="{{ $coupon->coupon_code }}" id="code{{ $coupon->id }}"
                                                        readonly>
                                                    <div
                                                        class="row gy-2 gx-1 gx-lg-3 justify-content-start mb-4 mb-lg-3 w-100 mx-auto">
                                                        <div
                                                            class="col-lg-3 col-5 d-flex justify-content-start align-items-start">
                                                            <div class="border border-2 p-2 border-hover-01 ratio ratio-1x1"
                                                                title="{{ $store->name }}">
                                                                <img src="{{ asset('images/StoreImages/' . $store->image) }}"
                                                                    width="150" class="img-fluid" alt="">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-7 d-flex align-items-center ps-1 ps-lg-0">
                                                            <div>
                                                                <div class="mb-3">
                                                                    <span
                                                                        class="@if ($coupon->coupon_type == 1) custom-bg-01 @else bg-warning @endif text-white text-uppercase px-2 fw-semibold small py-1">
                                                                        @if ($coupon->coupon_type == 1)
                                                                            code
                                                                        @else
                                                                            deal
                                                                        @endif
                                                                    </span>
                                                                </div>
                                                                <h3 class="mb-1 fs-5 custom-test">
                                                                    {{ str_replace('-', ' ', $coupon->offer_name) }}
                                                                </h3>
                                                                <div
                                                                    class="d-flex flex-wrap align-items-center gap-1 mb-1">
                                                                    <span class="small fw-semibold text-body-secondary">
                                                                        Expires:
                                                                        {{ \Carbon\Carbon::parse(@$coupon->expiry_date)->format('d F Y') }}
                                                                    </span>
                                                                </div>
                                                                <p class="mb-1 fw-bold small d-none d-md-block">
                                                                    {{ str_replace('-', ' ', $coupon->shipping_offer) }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="col-lg-3 col-md-5 col-8 d-flex align-items-end ms-lg-auto mx-auto mt-3 mt-lg-0">
                                                            <div class="w-100">
                                                                <div class="">
                                                                    @if ($coupon->coupon_type == 1)
                                                                        <div class="text-decoration-none text-dark position-relative w-100 copyCoupon openModal @if ($coupon->flicker_button == 1) flicker-on @endif "
                                                                            data-clipboard-target="#code{{ $coupon->id }}"
                                                                            data-url="{{ $store->tracking_url ?? '' }}"
                                                                            data-id="{{ $coupon->id }}"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-title="Click to copy and open site">
                                                                            <div
                                                                                class="d-block position-relative text-center coupon_custom_btn">
                                                                                <div
                                                                                    class="lh-lg fs-5 w-100 fw-bold text-uppercase text-end pe-3">
                                                                                      {{ Str::substr($coupon->coupon_code, -3) }}
                                                                                    {{-- {{ $coupon->coupon_code }} --}}
                                                                                </div>
                                                                            </div>
                                                                            <div
                                                                                class="d-block position-absolute top-0 end-0 w-100 overflow-hidden small coupons_custom_btn border border-2 rounded-1">
                                                                                <div
                                                                                    class="position-absolute top-0 overflow-hidden">
                                                                                    <button
                                                                                        class="d-flex justify-content-center align-items-center custom-bg-01 small p-1 border-0 text-center text-uppercase text-white fw-bold ps-3 h-100">
                                                                                        <span
                                                                                            class="h6 fw-bold mb-auto mt-1">
                                                                                            get code
                                                                                        </span>
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @else
                                                                        <button
                                                                            class="btn btn-warning rounded-1 text-white fw-semibold w-100 d-flex justify-content-center openModal @if ($coupon->flicker_button == 1) flicker-on @endif"
                                                                            data-url="{{ $store->tracking_url ?? '' }}"
                                                                            data-id="{{ $coupon->id }}">
                                                                            <div class="d-flex align-items-center gap-1">
                                                                                Get Deal
                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                    width="1rem" height="1rem"
                                                                                    fill="#fff" viewBox="0 0 576 512">
                                                                                    <path
                                                                                        d="M0 24C0 10.7 10.7 0 24 0L69.5 0c22 0 41.5 12.8 50.6 32l411 0c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3l-288.5 0 5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5L488 336c13.3 0 24 10.7 24 24s-10.7 24-24 24l-288.3 0c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5L24 48C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z" />
                                                                                </svg>
                                                                            </div>
                                                                        </button>
                                                                    @endif
                                                                </div>
                                                                <div
                                                                    class="d-flex align-items-center pt-2 gap-1 px-2 px-md-0">
                                                                    <ul
                                                                        class="list-group list-group-horizontal flex-grow-1">
                                                                        <li
                                                                            class="list-group-item list-group-item-action p-1 text-center d-flex align-items-center justify-content-center">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                width="1rem" fill="#999999"
                                                                                height="1rem" viewBox="0 0 512 512"
                                                                                data-bs-toggle="tooltip"
                                                                                data-bs-title="This Worked">
                                                                                <path
                                                                                    d="M464 256A208 208 0 1 0 48 256a208 208 0 1 0 416 0zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256zm177.6 62.1C192.8 334.5 218.8 352 256 352s63.2-17.5 78.4-33.9c9-9.7 24.2-10.4 33.9-1.4s10.4 24.2 1.4 33.9c-22 23.8-60 49.4-113.6 49.4s-91.7-25.5-113.6-49.4c-9-9.7-8.4-24.9 1.4-33.9s24.9-8.4 33.9 1.4zM144.4 208a32 32 0 1 1 64 0 32 32 0 1 1 -64 0zm192-32a32 32 0 1 1 0 64 32 32 0 1 1 0-64z" />
                                                                            </svg>
                                                                        </li>
                                                                        <li
                                                                            class="list-group-item list-group-item-action p-1 text-center d-flex align-items-center justify-content-center">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                width="1rem" fill="#999999"
                                                                                height="1rem" viewBox="0 0 512 512"
                                                                                data-bs-toggle="tooltip"
                                                                                data-bs-title="It didn't work">
                                                                                <path
                                                                                    d="M464 256A208 208 0 1 0 48 256a208 208 0 1 0 416 0zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256zM174.6 384.1c-4.5 12.5-18.2 18.9-30.7 14.4s-18.9-18.2-14.4-30.7C146.9 319.4 198.9 288 256 288s109.1 31.4 126.6 79.9c4.5 12.5-2 26.2-14.4 30.7s-26.2-2-30.7-14.4C328.2 358.5 297.2 336 256 336s-72.2 22.5-81.4 48.1zM144.4 208a32 32 0 1 1 64 0 32 32 0 1 1 -64 0zm192-32a32 32 0 1 1 0 64 32 32 0 1 1 0-64z" />
                                                                            </svg>
                                                                        </li>
                                                                        <li
                                                                            class="list-group-item list-group-item-action p-1 text-center d-flex align-items-center justify-content-center">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                width="1rem" fill="#999999"
                                                                                height="1rem" viewBox="0 0 576 512"
                                                                                data-bs-toggle="tooltip"
                                                                                data-bs-title="Save this coupon">
                                                                                <path
                                                                                    d="M287.9 0c9.2 0 17.6 5.2 21.6 13.5l68.6 141.3 153.2 22.6c9 1.3 16.5 7.6 19.3 16.3s.5 18.1-5.9 24.5L433.6 328.4l26.2 155.6c1.5 9-2.2 18.1-9.7 23.5s-17.3 6-25.3 1.7l-137-73.2L151 509.1c-8.1 4.3-17.9 3.7-25.3-1.7s-11.2-14.5-9.7-23.5l26.2-155.6L31.1 218.2c-6.5-6.4-8.7-15.9-5.9-24.5s10.3-14.9 19.3-16.3l153.2-22.6L266.3 13.5C270.4 5.2 278.7 0 287.9 0zm0 79L235.4 187.2c-3.5 7.1-10.2 12.1-18.1 13.3L99 217.9 184.9 303c5.5 5.5 8.1 13.3 6.8 21L171.4 443.7l105.2-56.2c7.1-3.8 15.6-3.8 22.6 0l105.2 56.2L384.2 324.1c-1.3-7.7 1.2-15.5 6.8-21l85.9-85.1L358.6 200.5c-7.8-1.2-14.6-6.1-18.1-13.3L287.9 79z" />
                                                                            </svg>
                                                                        </li>
                                                                    </ul>
                                                                    <p
                                                                        class="mb-0 x-small lh-1 fw-semibold text-body-tertiary">
                                                                        100%
                                                                        SUCCESS </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div
                                                                class="border-top @if ($coupon->verified_button == 1 || $coupon->exclusive_button == 1) border-bottom @endif py-2 px-md-4">
                                                                <ul class="list-unstyled mb-0 d-flex flex-wrap gap-2">
                                                                    @if ($coupon->verified_button == 1)
                                                                        <li class="d-flex align-items-center x-small fw-bold gap-1"
                                                                            style="color:var(--bs-form-valid-color)">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                viewBox="0 0 448 512" width="1rem"
                                                                                height="1rem"
                                                                                fill="var(--bs-form-valid-color)">
                                                                                <path
                                                                                    d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z" />
                                                                            </svg>
                                                                            Verified
                                                                        </li>
                                                                    @endif
                                                                    @if ($coupon->exclusive_button == 1)
                                                                        <li
                                                                            class="d-flex align-items-center x-small fw-bold gap-1 text-primary">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                viewBox="0 0 512 512" width="1rem"
                                                                                height="1rem"
                                                                                fill="var(--bs-primary-rgb)">
                                                                                <path
                                                                                    d="M168.5 72L256 165l87.5-93-175 0zM383.9 99.1L311.5 176l129 0L383.9 99.1zm50 124.9L256 224 78.1 224 256 420.3 433.9 224zM71.5 176l129 0L128.1 99.1 71.5 176zm434.3 40.1l-232 256c-4.5 5-11 7.9-17.8 7.9s-13.2-2.9-17.8-7.9l-232-256c-7.7-8.5-8.3-21.2-1.5-30.4l112-152c4.5-6.1 11.7-9.8 19.3-9.8l240 0c7.6 0 14.8 3.6 19.3 9.8l112 152c6.8 9.2 6.1 21.9-1.5 30.4z" />
                                                                            </svg>
                                                                            Exclusive
                                                                        </li>
                                                                    @endif
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                    <div class="tab-pane fade" id="sale-tab-pane" role="tabpanel"
                                        aria-labelledby="sale-tab" tabindex="0">
                                        @foreach ($store->coupons as $coupon)
                                            @if ($coupon->coupon_type == 0)
                                                <div>
                                                    <input type="hidden" class="coupon-code-input"
                                                        value="{{ $coupon->coupon_code }}" id="code{{ $coupon->id }}"
                                                        readonly>
                                                    <div
                                                        class="row gy-2 gx-1 gx-lg-3 justify-content-start mb-4 mb-lg-3 w-100 mx-auto">
                                                        <div
                                                            class="col-lg-3 col-5 d-flex justify-content-start align-items-start">
                                                            <div class="border border-2 p-2 border-hover-01 ratio ratio-1x1"
                                                                title="{{ $store->name }}">
                                                                <img src="{{ asset('images/StoreImages/' . $store->image) }}"
                                                                    width="150" class="img-fluid" alt="">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-7 d-flex align-items-center ps-1 ps-lg-0">
                                                            <div>
                                                                <div class="mb-3">
                                                                    <span
                                                                        class="@if ($coupon->coupon_type == 1) custom-bg-01 @else bg-warning @endif text-white text-uppercase px-2 fw-semibold small py-1">
                                                                        @if ($coupon->coupon_type == 1)
                                                                            code
                                                                        @else
                                                                            deal
                                                                        @endif
                                                                    </span>
                                                                </div>
                                                                <h3 class="mb-1 fs-5">
                                                                    {{ str_replace('-', ' ', $coupon->offer_name) }}
                                                                </h3>
                                                                <div
                                                                    class="d-flex flex-wrap align-items-center gap-1 mb-1">
                                                                    <span class="small fw-semibold text-body-secondary">
                                                                        Expires:
                                                                        {{ \Carbon\Carbon::parse(@$coupon->expiry_date)->format('d F Y') }}
                                                                    </span>
                                                                </div>
                                                                <p class="mb-1 fw-bold small d-none d-md-block">
                                                                    {{ str_replace('-', ' ', $coupon->shipping_offer) }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="col-lg-3 col-md-5 col-8 d-flex align-items-end ms-lg-auto mx-auto mt-3 mt-lg-0">
                                                            <div class="w-100">
                                                                <div class="">
                                                                    @if ($coupon->coupon_type == 1)
                                                                        <div class="text-decoration-none text-dark position-relative w-100 copyCoupon openModal @if ($coupon->flicker_button == 1) flicker-on @endif "
                                                                            data-clipboard-target="#code{{ $coupon->id }}"
                                                                            data-url="{{ $store->tracking_url ?? '' }}"
                                                                            data-id="{{ $coupon->id }}"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-title="Click to copy and open site">
                                                                            <div
                                                                                class="d-block position-relative text-center coupon_custom_btn">
                                                                                <div
                                                                                    class="lh-lg fs-5 w-100 fw-bold text-uppercase text-end pe-3">
                                                                                    {{ $coupon->coupon_code }}
                                                                                </div>
                                                                            </div>
                                                                            <div
                                                                                class="d-block position-absolute top-0 end-0 w-100 overflow-hidden small coupons_custom_btn border border-2 rounded-1">
                                                                                <div
                                                                                    class="position-absolute top-0 overflow-hidden">
                                                                                    <button
                                                                                        class="d-flex justify-content-center align-items-center custom-bg-01 small p-1 border-0 text-center text-uppercase text-white fw-bold ps-3 h-100">
                                                                                        <span
                                                                                            class="h6 fw-bold mb-auto mt-1">
                                                                                            get code
                                                                                        </span>
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @else
                                                                        <button
                                                                            class="btn btn-warning rounded-1 text-white fw-semibold w-100 d-flex justify-content-center openModal @if ($coupon->flicker_button == 1) flicker-on @endif"
                                                                            data-url="{{ $store->tracking_url ?? '' }}"
                                                                            data-id="{{ $coupon->id }}">
                                                                            <div class="d-flex align-items-center gap-1">
                                                                                Get Deal
                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                    width="1rem" height="1rem"
                                                                                    fill="#fff" viewBox="0 0 576 512">
                                                                                    <path
                                                                                        d="M0 24C0 10.7 10.7 0 24 0L69.5 0c22 0 41.5 12.8 50.6 32l411 0c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3l-288.5 0 5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5L488 336c13.3 0 24 10.7 24 24s-10.7 24-24 24l-288.3 0c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5L24 48C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z" />
                                                                                </svg>
                                                                            </div>
                                                                        </button>
                                                                    @endif
                                                                </div>
                                                                <div
                                                                    class="d-flex align-items-center pt-2 gap-1 px-2 px-md-0">
                                                                    <ul
                                                                        class="list-group list-group-horizontal flex-grow-1">
                                                                        <li
                                                                            class="list-group-item list-group-item-action p-1 text-center d-flex align-items-center justify-content-center">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                width="1rem" fill="#999999"
                                                                                height="1rem" viewBox="0 0 512 512"
                                                                                data-bs-toggle="tooltip"
                                                                                data-bs-title="This Worked">
                                                                                <path
                                                                                    d="M464 256A208 208 0 1 0 48 256a208 208 0 1 0 416 0zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256zm177.6 62.1C192.8 334.5 218.8 352 256 352s63.2-17.5 78.4-33.9c9-9.7 24.2-10.4 33.9-1.4s10.4 24.2 1.4 33.9c-22 23.8-60 49.4-113.6 49.4s-91.7-25.5-113.6-49.4c-9-9.7-8.4-24.9 1.4-33.9s24.9-8.4 33.9 1.4zM144.4 208a32 32 0 1 1 64 0 32 32 0 1 1 -64 0zm192-32a32 32 0 1 1 0 64 32 32 0 1 1 0-64z" />
                                                                            </svg>
                                                                        </li>
                                                                        <li
                                                                            class="list-group-item list-group-item-action p-1 text-center d-flex align-items-center justify-content-center">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                width="1rem" fill="#999999"
                                                                                height="1rem" viewBox="0 0 512 512"
                                                                                data-bs-toggle="tooltip"
                                                                                data-bs-title="It didn't work">
                                                                                <path
                                                                                    d="M464 256A208 208 0 1 0 48 256a208 208 0 1 0 416 0zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256zM174.6 384.1c-4.5 12.5-18.2 18.9-30.7 14.4s-18.9-18.2-14.4-30.7C146.9 319.4 198.9 288 256 288s109.1 31.4 126.6 79.9c4.5 12.5-2 26.2-14.4 30.7s-26.2-2-30.7-14.4C328.2 358.5 297.2 336 256 336s-72.2 22.5-81.4 48.1zM144.4 208a32 32 0 1 1 64 0 32 32 0 1 1 -64 0zm192-32a32 32 0 1 1 0 64 32 32 0 1 1 0-64z" />
                                                                            </svg>
                                                                        </li>
                                                                        <li
                                                                            class="list-group-item list-group-item-action p-1 text-center d-flex align-items-center justify-content-center">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                width="1rem" fill="#999999"
                                                                                height="1rem" viewBox="0 0 576 512"
                                                                                data-bs-toggle="tooltip"
                                                                                data-bs-title="Save this coupon">
                                                                                <path
                                                                                    d="M287.9 0c9.2 0 17.6 5.2 21.6 13.5l68.6 141.3 153.2 22.6c9 1.3 16.5 7.6 19.3 16.3s.5 18.1-5.9 24.5L433.6 328.4l26.2 155.6c1.5 9-2.2 18.1-9.7 23.5s-17.3 6-25.3 1.7l-137-73.2L151 509.1c-8.1 4.3-17.9 3.7-25.3-1.7s-11.2-14.5-9.7-23.5l26.2-155.6L31.1 218.2c-6.5-6.4-8.7-15.9-5.9-24.5s10.3-14.9 19.3-16.3l153.2-22.6L266.3 13.5C270.4 5.2 278.7 0 287.9 0zm0 79L235.4 187.2c-3.5 7.1-10.2 12.1-18.1 13.3L99 217.9 184.9 303c5.5 5.5 8.1 13.3 6.8 21L171.4 443.7l105.2-56.2c7.1-3.8 15.6-3.8 22.6 0l105.2 56.2L384.2 324.1c-1.3-7.7 1.2-15.5 6.8-21l85.9-85.1L358.6 200.5c-7.8-1.2-14.6-6.1-18.1-13.3L287.9 79z" />
                                                                            </svg>
                                                                        </li>
                                                                    </ul>
                                                                    <p
                                                                        class="mb-0 x-small lh-1 fw-semibold text-body-tertiary">
                                                                        100%
                                                                        SUCCESS </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div
                                                                class="border-top @if ($coupon->verified_button == 1 || $coupon->exclusive_button == 1) border-bottom @endif py-2 px-md-4">
                                                                <ul class="list-unstyled mb-0 d-flex flex-wrap gap-2">
                                                                    @if ($coupon->verified_button == 1)
                                                                        <li class="d-flex align-items-center x-small fw-bold gap-1"
                                                                            style="color:var(--bs-form-valid-color)">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                viewBox="0 0 448 512" width="1rem"
                                                                                height="1rem"
                                                                                fill="var(--bs-form-valid-color)">
                                                                                <path
                                                                                    d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z" />
                                                                            </svg>
                                                                            Verified
                                                                        </li>
                                                                    @endif
                                                                    @if ($coupon->exclusive_button == 1)
                                                                        <li
                                                                            class="d-flex align-items-center x-small fw-bold gap-1 text-primary">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                viewBox="0 0 512 512" width="1rem"
                                                                                height="1rem"
                                                                                fill="var(--bs-primary-rgb)">
                                                                                <path
                                                                                    d="M168.5 72L256 165l87.5-93-175 0zM383.9 99.1L311.5 176l129 0L383.9 99.1zm50 124.9L256 224 78.1 224 256 420.3 433.9 224zM71.5 176l129 0L128.1 99.1 71.5 176zm434.3 40.1l-232 256c-4.5 5-11 7.9-17.8 7.9s-13.2-2.9-17.8-7.9l-232-256c-7.7-8.5-8.3-21.2-1.5-30.4l112-152c4.5-6.1 11.7-9.8 19.3-9.8l240 0c7.6 0 14.8 3.6 19.3 9.8l112 152c6.8 9.2 6.1 21.9-1.5 30.4z" />
                                                                            </svg>
                                                                            Exclusive
                                                                        </li>
                                                                    @endif
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                    <div class="tab-pane fade" id="verified-tab-pane" role="tabpanel"
                                        aria-labelledby="verified-tab" tabindex="0">
                                        @foreach ($store->coupons as $coupon)
                                            @if ($coupon->verified_button == 1)
                                                <div>
                                                    <input type="hidden" class="coupon-code-input"
                                                        value="{{ $coupon->coupon_code }}" id="code{{ $coupon->id }}"
                                                        readonly>
                                                    <div
                                                        class="row gy-2 gx-1 gx-lg-3 justify-content-start mb-4 mb-lg-3 w-100 mx-auto">
                                                        <div
                                                            class="col-lg-3 col-5 d-flex justify-content-start align-items-start">
                                                            <div class="border border-2 p-2 border-hover-01 ratio ratio-1x1"
                                                                title="{{ $store->name }}">
                                                                <img src="{{ asset('images/StoreImages/' . $store->image) }}"
                                                                    width="150" class="img-fluid" alt="">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-7 d-flex align-items-center ps-1 ps-lg-0">
                                                            <div>
                                                                <div class="mb-3">
                                                                    <span
                                                                        class="@if ($coupon->coupon_type == 1) custom-bg-01 @else bg-warning @endif text-white text-uppercase px-2 fw-semibold small py-1">
                                                                        @if ($coupon->coupon_type == 1)
                                                                            code
                                                                        @else
                                                                            deal
                                                                        @endif
                                                                    </span>
                                                                </div>
                                                                <p class="mb-1 fs-5">
                                                                    {{ str_replace('-', ' ', $coupon->offer_name) }}
                                                                </p>
                                                                <div
                                                                    class="d-flex flex-wrap align-items-center gap-1 mb-1">
                                                                    <span class="small fw-semibold text-body-secondary">
                                                                        Expires:
                                                                        {{ \Carbon\Carbon::parse(@$coupon->expiry_date)->format('d F Y') }}
                                                                    </span>
                                                                </div>
                                                                <p class="mb-1 fw-bold small d-none d-md-block">
                                                                    {{ str_replace('-', ' ', $coupon->shipping_offer) }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="col-lg-3 col-md-5 col-8 d-flex align-items-end ms-lg-auto mx-auto mt-3 mt-lg-0">
                                                            <div class="w-100">
                                                                <div class="">
                                                                    @if ($coupon->coupon_type == 1)
                                                                        <div class="text-decoration-none text-dark position-relative w-100 copyCoupon openModal @if ($coupon->flicker_button == 1) flicker-on @endif "
                                                                            data-clipboard-target="#code{{ $coupon->id }}"
                                                                            data-url="{{ $store->tracking_url ?? '' }}"
                                                                            data-id="{{ $coupon->id }}"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-title="Click to copy and open site">
                                                                            <div
                                                                                class="d-block position-relative text-center coupon_custom_btn">
                                                                                <div
                                                                                    class="lh-lg fs-5 w-100 fw-bold text-uppercase text-end pe-3">
                                                                                    {{ $coupon->coupon_code }}
                                                                                </div>
                                                                            </div>
                                                                            <div
                                                                                class="d-block position-absolute top-0 end-0 w-100 overflow-hidden small coupons_custom_btn border border-2 rounded-1">
                                                                                <div
                                                                                    class="position-absolute top-0 overflow-hidden">
                                                                                    <button
                                                                                        class="d-flex justify-content-center align-items-center custom-bg-01 small p-1 border-0 text-center text-uppercase text-white fw-bold ps-3 h-100">
                                                                                        <span
                                                                                            class="h6 fw-bold mb-auto mt-1">
                                                                                            get code
                                                                                        </span>
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @else
                                                                        <button
                                                                            class="btn btn-warning rounded-1 text-white fw-semibold w-100 d-flex justify-content-center openModal @if ($coupon->flicker_button == 1) flicker-on @endif"
                                                                            data-url="{{ $store->tracking_url ?? '' }}"
                                                                            data-id="{{ $coupon->id }}">
                                                                            <div class="d-flex align-items-center gap-1">
                                                                                Get Deal
                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                    width="1rem" height="1rem"
                                                                                    fill="#fff" viewBox="0 0 576 512">
                                                                                    <path
                                                                                        d="M0 24C0 10.7 10.7 0 24 0L69.5 0c22 0 41.5 12.8 50.6 32l411 0c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3l-288.5 0 5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5L488 336c13.3 0 24 10.7 24 24s-10.7 24-24 24l-288.3 0c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5L24 48C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z" />
                                                                                </svg>
                                                                            </div>
                                                                        </button>
                                                                    @endif
                                                                </div>
                                                                <div
                                                                    class="d-flex align-items-center pt-2 gap-1 px-2 px-md-0">
                                                                    <ul
                                                                        class="list-group list-group-horizontal flex-grow-1">
                                                                        <li
                                                                            class="list-group-item list-group-item-action p-1 text-center d-flex align-items-center justify-content-center">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                width="1rem" fill="#999999"
                                                                                height="1rem" viewBox="0 0 512 512"
                                                                                data-bs-toggle="tooltip"
                                                                                data-bs-title="This Worked">
                                                                                <path
                                                                                    d="M464 256A208 208 0 1 0 48 256a208 208 0 1 0 416 0zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256zm177.6 62.1C192.8 334.5 218.8 352 256 352s63.2-17.5 78.4-33.9c9-9.7 24.2-10.4 33.9-1.4s10.4 24.2 1.4 33.9c-22 23.8-60 49.4-113.6 49.4s-91.7-25.5-113.6-49.4c-9-9.7-8.4-24.9 1.4-33.9s24.9-8.4 33.9 1.4zM144.4 208a32 32 0 1 1 64 0 32 32 0 1 1 -64 0zm192-32a32 32 0 1 1 0 64 32 32 0 1 1 0-64z" />
                                                                            </svg>
                                                                        </li>
                                                                        <li
                                                                            class="list-group-item list-group-item-action p-1 text-center d-flex align-items-center justify-content-center">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                width="1rem" fill="#999999"
                                                                                height="1rem" viewBox="0 0 512 512"
                                                                                data-bs-toggle="tooltip"
                                                                                data-bs-title="It didn't work">
                                                                                <path
                                                                                    d="M464 256A208 208 0 1 0 48 256a208 208 0 1 0 416 0zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256zM174.6 384.1c-4.5 12.5-18.2 18.9-30.7 14.4s-18.9-18.2-14.4-30.7C146.9 319.4 198.9 288 256 288s109.1 31.4 126.6 79.9c4.5 12.5-2 26.2-14.4 30.7s-26.2-2-30.7-14.4C328.2 358.5 297.2 336 256 336s-72.2 22.5-81.4 48.1zM144.4 208a32 32 0 1 1 64 0 32 32 0 1 1 -64 0zm192-32a32 32 0 1 1 0 64 32 32 0 1 1 0-64z" />
                                                                            </svg>
                                                                        </li>
                                                                        <li
                                                                            class="list-group-item list-group-item-action p-1 text-center d-flex align-items-center justify-content-center">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                width="1rem" fill="#999999"
                                                                                height="1rem" viewBox="0 0 576 512"
                                                                                data-bs-toggle="tooltip"
                                                                                data-bs-title="Save this coupon">
                                                                                <path
                                                                                    d="M287.9 0c9.2 0 17.6 5.2 21.6 13.5l68.6 141.3 153.2 22.6c9 1.3 16.5 7.6 19.3 16.3s.5 18.1-5.9 24.5L433.6 328.4l26.2 155.6c1.5 9-2.2 18.1-9.7 23.5s-17.3 6-25.3 1.7l-137-73.2L151 509.1c-8.1 4.3-17.9 3.7-25.3-1.7s-11.2-14.5-9.7-23.5l26.2-155.6L31.1 218.2c-6.5-6.4-8.7-15.9-5.9-24.5s10.3-14.9 19.3-16.3l153.2-22.6L266.3 13.5C270.4 5.2 278.7 0 287.9 0zm0 79L235.4 187.2c-3.5 7.1-10.2 12.1-18.1 13.3L99 217.9 184.9 303c5.5 5.5 8.1 13.3 6.8 21L171.4 443.7l105.2-56.2c7.1-3.8 15.6-3.8 22.6 0l105.2 56.2L384.2 324.1c-1.3-7.7 1.2-15.5 6.8-21l85.9-85.1L358.6 200.5c-7.8-1.2-14.6-6.1-18.1-13.3L287.9 79z" />
                                                                            </svg>
                                                                        </li>
                                                                    </ul>
                                                                    <p
                                                                        class="mb-0 x-small lh-1 fw-semibold text-body-tertiary">
                                                                        100%
                                                                        SUCCESS </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div
                                                                class="border-top @if ($coupon->verified_button == 1 || $coupon->exclusive_button == 1) border-bottom @endif py-2 px-md-4">
                                                                <ul class="list-unstyled mb-0 d-flex flex-wrap gap-2">
                                                                    @if ($coupon->verified_button == 1)
                                                                        <li class="d-flex align-items-center x-small fw-bold gap-1"
                                                                            style="color:var(--bs-form-valid-color)">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                viewBox="0 0 448 512" width="1rem"
                                                                                height="1rem"
                                                                                fill="var(--bs-form-valid-color)">
                                                                                <path
                                                                                    d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z" />
                                                                            </svg>
                                                                            Verified
                                                                        </li>
                                                                    @endif
                                                                    @if ($coupon->exclusive_button == 1)
                                                                        <li
                                                                            class="d-flex align-items-center x-small fw-bold gap-1 text-primary">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                viewBox="0 0 512 512" width="1rem"
                                                                                height="1rem"
                                                                                fill="var(--bs-primary-rgb)">
                                                                                <path
                                                                                    d="M168.5 72L256 165l87.5-93-175 0zM383.9 99.1L311.5 176l129 0L383.9 99.1zm50 124.9L256 224 78.1 224 256 420.3 433.9 224zM71.5 176l129 0L128.1 99.1 71.5 176zm434.3 40.1l-232 256c-4.5 5-11 7.9-17.8 7.9s-13.2-2.9-17.8-7.9l-232-256c-7.7-8.5-8.3-21.2-1.5-30.4l112-152c4.5-6.1 11.7-9.8 19.3-9.8l240 0c7.6 0 14.8 3.6 19.3 9.8l112 152c6.8 9.2 6.1 21.9-1.5 30.4z" />
                                                                            </svg>
                                                                            Exclusive
                                                                        </li>
                                                                    @endif
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="border-bottom mb-4">
                                <p class="small text-uppercase text-center ">Filter Store</p>
                                <div class="ps-3 pt-md-3">
                                    <p class="small fw-bold text-center ">Sort By</p>
                                    <ul class="list-unstyled fw-semibold text-body-secondary">
                                        <li class="d-flex align-items-center gap-1">
                                            <input type="radio" name="sortBy" id="all"
                                                @if (request()->get('sortby') == '') checked @endif>
                                            <label for="all">
                                                <a href="?" class="nav-link">All</a>
                                            </label>
                                        </li>
                                        <li class="d-flex align-items-center gap-1">
                                            <input type="radio" name="sortBy" id="Newest"
                                                @if (request()->get('sortby') == 'newest') checked @endif>
                                            <label for="Newest">
                                                <a href="?sortby=newest" class="nav-link">Newest</a>
                                            </label>
                                        </li>
                                        <li class="d-flex align-items-center gap-1">
                                            <input type="radio" name="sortBy" id="Popularity"
                                                @if (request()->get('sortby') == 'popularity') checked @endif>
                                            <label for="Popularity">
                                                <a href="?sortby=popularity" class="nav-link">Popularity</a>
                                            </label>
                                        </li>
                                        <li class="d-flex align-items-center gap-1">
                                            <input type="radio" name="sortBy" id="Ending Soon"
                                                @if (request()->get('sortby') == 'ending') checked @endif>
                                            <label for="Ending Soon">
                                                <a href="?sortby=ending" class="nav-link">Ending Soon</a>
                                            </label>
                                        </li>
                                        <li class="d-flex align-items-center gap-1">
                                            <input type="radio" name="sortBy" id="Expired"
                                                @if (request()->get('sortby') == 'expired') checked @endif>
                                            <label for="Expired">
                                                <a href="?sortby=expired" class="nav-link">Expired</a>
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="border-bottom pb-3 mb-4">
                                <p class="small text-uppercase text-center ">COUPON INTO YOUR INBOX</p>
                                <div class="ps-lg-3">
                                    <form class="newsLetter">
                                        @csrf
                                        <input type="hidden" name="page_url"
                                            value="{{ route(Route::currentRouteName()) }}">
                                        <div class="d-flex border rounded-1 overflow-hidden">
                                            <input type="email" name="email" class="form-control border-0"
                                                placeholder="&#x2709; Your Email">
                                            <button type="submit"
                                                class="btn btn-sm btn-dark text-uppercase rounded-0 fw-semibold px-3">Subscribe</button>
                                        </div>
                                        <div class="form-check my-3">
                                            <input class="form-check-input shadow-none" type="checkbox"
                                                id="sidebar-consent" name="is_consent">
                                            <label class="form-check-label lh-sm small" for="sidebar-consent">
                                                I consent to receiving marketing emails from
                                                ({{ config('setting.site_name') }})
                                            </label>
                                        </div>
                                    </form>
                                    <p class="lh-1 mt-2 small fw-semibold">
                                        You can opt out of our newsletters at any time. See our privacy policy.
                                    </p>
                                    <ul class="list-unstyled d-flex flex-wrap align-items-center justify-content-between row-gap-4 col-9 col-md-12"
                                        id="scialIcons-02">
                                        @foreach ($social as $linksSocial)
                                            <li>
                                                <a href="{{ $linksSocial->link }}"
                                                    class="text-decoration-none text-white">
                                                    <div
                                                        class="bg-dark-subtle p-2 rounded-circle d-flex justify-content-center align-items-center">
                                                        <i class="{{ $linksSocial->icon }}"></i>
                                                    </div>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <div class="border-bottom pb-3 mb-4">
                                <h4 class="small text-uppercase mb-4 text-center move-to-end">POPULAR STORES</h4>
                                <div class="ps-lg-3 pt-2">
                                    <div class="row g-3">
                                        @foreach ($popularStores as $popularStore)
                                            <div class="col-6">
                                                <div class="border border-hover-01">
                                                    <a href="{{ route('store_details', $popularStore->slug) }}">
                                                        <div class="text-center">
                                                            <img src="{{ asset('images/StoreImages/' . $popularStore->image) }}"
                                                                class="img-fluid" alt="{{ $popularStore->image_alt }}">
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="border-bottom pb-3 mb-4">
                                <h4 class="small text-uppercase text-center move-to-end">POPULAR CATEGORIES</h4>
                                <ul class="list-unstyled row ps-3 gy-3 gy-md-2 pt-2">
                                    @foreach ($popularCategories as $popularCategory)
                                        <li class="col-md-6">
                                            <a href="{{ route('category_details', strtolower($popularCategory->slug)) }}"
                                                class="nav-link custom-hover-03">
                                                {{ $popularCategory->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>



                            <div>
                                <div class="position-relative d-flex align-items-center justify-content-center">
                                    <hr class="w-100">
                                    <p
                                        class="x-small text-body-emphasis mb-0 position-absolute z-1 bg-white px-1 text-uppercase fw-semibold">
                                        Advertisement</p>
                                </div>
                                <a href="{{ @$banner->link }}" class="d-flex justify-content-center mb-3">
                                    <img src="{{ asset('images/homeAdsbannerImages/' . @$banner->image) }}"
                                        class="mw-100" height="{{ @$banner->pages->height }}"
                                        width="{{ @$banner->pages->width }}" alt="{{ @$banner->image }}">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            {{-- MENTION THE ORIGINAL CODE HERE --}}
        @endif
    </main>
    @push('js')
        <script type='application/ld+json'>
        {
        "@context": "https://schema.org",
        "@graph": [
            {
                "@type": "CollectionPage",
                "@id": "{!! route('stores').'#webpage' !!}",
                "url": "{!! route('stores') !!}",
                "name": "{!! $dynamicData->meta_title ?? config('setting.site_name')!!}",
                "description": "{!! $dynamicData->meta_description ?? ''!!}"
            },
            {
                "@type": "WebPage",
                "@id": "{!! url()->current().'#webpage' !!}",
                "url": "{!! url()->current() !!}",
                "inLanguage": "en-US",
                "name": "{!! $store->meta_title !!}",
                "isPartOf": { "@id": "{!! route('stores').'#webpage'!!}" },
                "description": "{!! $store->meta_description !!}"
            }
        ]
        }
        </script>

        <script type="application/ld+json">
        {
        "@context": "http://schema.org",
        "@type": "ItemList",
        "name": "{!! $store->meta_title !!}",
        "description": "{!! $store->meta_description !!}",
        "url": "{!! url()->current() !!}",
        "numberOfItems": "{{ $store->coupons->count() }}",
        "itemListElement": [
            @foreach ($store->coupons as $index => $coupon)
            {
                "@type": "ListItem",
                "position": {{ $index + 1 }},
                "item": {
                    "@type": "Offer",
                    "url": "{{ @$coupon->stores->tracking_url ?? '' }}",
                    "description": "{!! $coupon->offer_name !!}",
                    "validThrough": "{{ $coupon->expiry_date }}",
                    "seller": {
                        "@type": "Organization",
                        "name": "{!! $store->name !!}"
                    }
                }
            }{{ !$loop->last ? ',' : '' }}
            @endforeach
        ]
        }
        </script>

        <script type="application/ld+json">
        {
        "@context": "https://schema.org",
        "@graph": [
            @foreach ($store->coupons as $coupon)
            {
                "@type": "Offer",
                "url": "{{ @$coupon->stores->tracking_url ?? '' }}",
                "description": "{!! $coupon->offer_name !!}",
                "validThrough": "{!! $coupon->expiry_date !!}",
                "seller": {
                    "@type": "Organization",
                    "name": "{!! $store->name !!}",
                    "url": "{!! url()->current() !!}"
                }
            }{{ !$loop->last ? ',' : '' }}
            @endforeach
        ]
        }
        </script>
        <script>
            $('.custom-shutter-text').html($('.text').val())
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
    {{-- POPUP MODAL SINGLE --}}
    @if ($store->modal == 1)
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
                                            src="{{ $store->modal_img ? asset('images/modalImages' . '/' . $store->modal_img) : config('setting.site_logo') }}"
                                            class=" object-fit-cover modal-single-image" alt="">
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-7 p-0 align-content-center">
                                    <div class="ps-3 pe-4 pt-4 pb-3 text-center">
                                        <p class="mb-2 mb-md-3 lh-sm fw-bold fs-4">
                                            {{ $store->modal_title ?? 'Get Best Discounts on ' . $store->name }}
                                        </p>
                                        <p class="mb-2 mb-md-3 lh-sm fs-7">
                                            {{ $store->modal_description ?? 'Limited Time Offer!' }}
                                        </p>
                                        <div class="mb-2 mb-md-3">
                                            <a href="{{ $store->modal_link }}" target="_blank"><button
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
@endsection
