@extends('User.layout')
@section('title')
    Categories
@endsection
@section('content')
    <main>
        <section>
            <div class="container pt-3">
                <div class="text-center">
                    <h1 class="text-decoration-underline">All Categories</h1>
                </div>
                @foreach ($letters as $letter)
                    <div class="col-12">
                        <p class="text-uppercase mt-4">{{ $letter }}</p>
                        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-6 mb-3">
                            @foreach ($groupedCategories[$letter] as $category)
                                <div class="col mt-3 overflow-y-hidden">
                                    <div class="rounded-3 border pb-3 custom_card_animate">
                                        <a href="{{ route('category_details', strtolower($category->slug)) }}"
                                            class="text-decoration-none text-dark d-flex flex-column">
                                            <span>
                                                <img src="{{ asset('images/CategoriesImages/' . $category->image) }}"
                                                    class="card-img-top img-fluid px-md-4 py-2" alt="{{ $category->image_alt }}">
                                            </span>
                                            <h2 class="text-uppercase text-center fs-6 fw-semibold mb-0">
                                                {{ $category->name }}</h2>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

            </div>
        </section>
    </main>
    @push('js')
        <script type='application/ld+json'>
        {
            "@context":"https://schema.org",
            "@graph":
            [
                {!! home_schema() !!},
                {
                "@type":"CollectionPage",
                "@id":"{{ route('categories').'#webpage' }}",
                "url":"{{ route('categories') }}",
                "inLanguage":"en-US",
                "name":"{!! config('metatags.meta_title') ?? config('setting.site_name') !!}",
                "isPartOf":{"@id":"{{ config('setting.url') . '#website' }}"},
                "description":"{!! config('metatags.meta_description') ?? config('setting.site_name')!!}"
                }
            ]
        }
        </script>

        <script type="application/ld+json">
            {
            "@context": "https://schema.org",
            "@type": "ItemList",
            "name": "{!! config('metatags.meta_title') ?? config('setting.site_name') !!}", //Category Page Meta Title
            "description": "{!! config('metatags.meta_description') ?? config('setting.site_name') !!}",//Category Page Meta Description
            "url": "{{ route('categories') }}",
            "numberOfItems": {{ $categories->count() }}, //Number of categories
            "itemListElement": [
                @foreach($categories as $index => $category)
                {
                "@type": "ListItem",
                "position": {{ $index + 1 }},
                "item": {
                    "@type": "CategoryCode",
                    "name": "{!! $category->name !!}",//Category Name
                    "description": "{!! $category->meta_description !!}",//Category Meta Description
                    "url": "{{ route('category_details' , strtolower(str_replace(" ", '-' , $category->slug)) ) }}",//Category URL
                    "additionalProperty": {
                    "@type": "PropertyValue",
                    "name": "{{ $category->stores->count() }}",
                    "value": {
                        "@type": "QuantitativeValue",
                        "value": {{ $category->stores->count() }},//Number of Store in The Category
                        "unitText": "Stores"
                    }
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
                    @foreach($categories as $index => $category)
                    {
                        "@type": "CategoryCode",
                        "name": "{!! $category->name !!}",
                        "description": "{!! $category->meta_description !!}",
                        "url": "{!! route('category_details', $category->slug) !!}",
                        "additionalProperty": {
                            "@type": "PropertyValue",
                            "name": "Number of Stores",
                            "value": {
                                "@type": "QuantitativeValue",
                                "value": {{ $category->stores->count() }},
                                "unitText": "Stores"
                            }
                        }
                    }{{ !$loop->last ? ',' : '' }}
                    @endforeach
                ]
            }
        </script>
    @endpush
@endsection
