@extends('User.layout')
@section('title')
    Category Details
@endsection
@section('content')
<style>
    nav > .pagination
    {
        display:flex;
        flex-wrap:wrap;
    }
</style>
    <main class="bg-light">

        <section>
            <div>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 col-md-12 col-12">
                            <div class="py-4 py-sm-5">
                                <nav aria-label="breadcrumb" class="position-relative">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <a href="{{ route('home') }}" class="text-decoration-none text-dark fw-bold">
                                                Home
                                            </a>
                                        </li>
                                        <li class="breadcrumb-item">
                                            <a href="{{ route('categories') }}"
                                                class="text-decoration-none text-dark fw-bold">
                                                Categories
                                            </a>
                                        </li>
                                        <li class="breadcrumb-item fw-light">{{ $category->name }}</li>
                                    </ol>
                                </nav>
                                <h1 class="h2 fw-bold">{{ $category->name }}</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-light">
            <div class="container">
                <div class="row pt-2 pb-3 mb-0">
                    <div class="col-lg-9">
                        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 row-cols-lg-4 g-4">
                            @forelse ($stores as $store)
                                <div class="col">
                                    <a href="{{ route('store_details', strtolower(str_replace(' ', '-', $store->slug))) }}"
                                        class="text-decoration-none text-dark">
                                        <div
                                            class="card border-0 shadow rounded-4 d-flex d-sm-block flex-row align-items-center overflow-hidden">
                                            <div class="d-flex justify-content-center">
                                                <img src="@if (!empty(@$store->image)) {{ asset('images/StoreImages/' . @$store->image) }} @else {{ asset('user/assets/images/noimage.avif') }} @endif"
                                                    class="img-fluid px-0 px-sm-4 object-fit-contain"
                                                    alt="{{ $store->image_alt }}" style="height:175px">
                                            </div>
                                            <div class="card-body">
                                                <h2 class="h6 card-title mb-1 lh-1">{{ $store->name }}</h2>
                                                <p class="card-text small text-muted">{{ @$store->headings->name }}</p>
                                                <div class="mt-2">
                                                    <button
                                                        class="btn btn-lg btn-dark w-100 rounded-pill fs-6 fw-bold text-uppercase text-nowrap">
                                                        View Offers
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @empty
                                <center><span class="text-danger">No Data Found</span></center>
                            @endforelse
                        </div>
                    </div>
                    @if(!empty($banner))
                    <div class="col-lg-3">
                        <div class="py-3">
                            <div class="shadow rounded">
                                <a href="{{ @$banner->link }}" class="text-decoration-none">
                                    <img src="{{ asset('images/homeAdsbannerImages/'. @$banner->image) }}"
                                    class="img-fluid w-100" alt="{{ @$banner->image }}">
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="d-flex justify-content-center py-3">
                    {{ $stores->links() }}
                </div>
            </div>
        </section>
    </main>
    @push('js')
        <script type='application/ld+json'>
        {
        "@context":"https://schema.org",
        "@graph":[
                {
                "@type":"CollectionPage",
                "@id":"{{ route('categories').'#webpage' }}",
                "url":"{{ route('categories') }}",
                "name":"{!! $dynamicData->meta_title ?? config('setting.site_name')!!}",
                "description":"{!! $dynamicData->meta_description ?? ''!!}"
                },
                {
                "@type":"WebPage",
                "@id":"{{ url()->current().'#webpage' }}",
                "url":"{{ url()->current() }}",
                "inLanguage":"en-US",
                "name":"{!! $category->meta_title !!}",
                "isPartOf":{"@id":"{{ route('categories').'#webpage' }}"},
                "description":"{!! $category->meta_description !!}"
                }
            ]
        }
        </script>

        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "ItemList",
            "name": "{!! $category->meta_title !!}", // Single Store Category Page Meta Title
            "description": "{!! $category->meta_description !!}", // Single Store Category Page Meta Description
            "url": "{{ url()->current() }}", // Single Store Category URL
            "numberOfItems": {{ $category->stores->count() }}, // Number of Stores
            "itemListElement": [
            @foreach ($category->stores as $index => $store)
            {
                "@type": "ListItem",
                "position": {{ $index + 1 }},
                "item": {
                "@type": "Store",
                "name": "{{ $store->name }}", // Store Name
                "description": "{!! $store->meta_description !!}", // Store Description
                "url": "{{ route('store_details',$store->slug) }}", // Store URL
                "additionalProperty": {
                    "@type": "PropertyValue",
                    "name": "Coupons",
                    "value": {
                    "@type": "QuantitativeValue",
                    "value": {{ $store->coupons->count() }}, // Number of Coupons for The Store
                    "unitText": "Coupons"
                    }
                }
                }
            }{{ !$loop->last ? ',' : '' }}
            @endforeach
            ]
        }
        </script>

        <script type="application/ld+json">
        [
        @foreach ($category->stores as $index => $store)
        {
            "@context": "https://schema.org",
            "@type": "Store",
            "name": "{!! $store->name !!}",
            "description": "{!! $store->meta_description !!}",
            "url": "{!! route('store_details', $store->slug) !!}",
            "additionalProperty": {
                "@type": "PropertyValue",
                "name": "NumberofCoupons",
                "value": {
                    "@type": "QuantitativeValue",
                    "value": {{ $store->coupons->count() }},
                    "unitText": "Coupons"
                }
            }
        }{{ !$loop->last ? ',' : '' }}
        @endforeach
        ]
        </script>
    @endpush
@endsection
