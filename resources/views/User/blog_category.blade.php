@extends('User.layout')
@section('title')
    {{ $blogcategory->meta_title ?? 'Blog Category' }}
@endsection
@section('content')
    <main>
        @if ($type != 'store')
            <section>
                <div class="container pt-4 pt-lg-0">
                    <h1 class="fw-bold lh-1 mb-1" style="font-size: calc(4.58vw + 100%);">{{ $blogcategory->name }}</h1>
                    <nav style="--bs-breadcrumb-divider: '|';" aria-label="breadcrumb">
                        <ol class="breadcrumb mb-md-4" style="--bs-breadcrumb-item-padding-x:1rem;">
                            <li class="breadcrumb-item">
                                <a href="{{ route('blogs') }}"
                                    class="text-decoration-none custom-color-01 custom-hover-03 small linkers text-uppercase fw-bold">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('blog_category', $blogcategory->slug) }}"
                                    class="text-decoration-none custom-color-01 custom-hover-03 small linkers text-uppercase fw-bold">{{ $blogcategory->name }}</a>
                            </li>
                        </ol>
                    </nav>
                    <div class="row gx-4 gy-4 mb-3 mb-md-0">
                        <div class="col-md-6">
                            <div class="underline-hover">
                                <div>
                                    <a href="{{ route('blog_details', @$featured_blog->slug) }}">
                                        <img src="{{ asset('images/blogsImages/' . @$featured_blog->image) }}" class="img-fluid"
                                            alt="">
                                    </a>
                                </div>
                                <div>
                                    <a href="{{ route('blog_category', @$featured_blog->categories->slug) }}"
                                        class="text-decoration-none x-small text-uppercase custom-color-01 fw-semibold d-block my-2">
                                        {{ @$featured_blog->categories->name }}
                                    </a>
                                    <h2 class="h3 fw-bold">
                                        <a href="{{ route('blog_details', @$featured_blog->slug) }}" class="nav-link">
                                            {{ @$featured_blog->title }}
                                        </a>
                                    </h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 row-gap-4 d-flex flex-column">
                            @foreach (@$featured_blogs as $blog)
                                <div class="underline-hover row flex-row-reverse flex-md-row gx-md-4 gx-3">
                                    <div class="col-4">
                                        <a href="{{ route('blog_details', $blog->slug) }}">
                                            <img src="{{ asset('images/blogsImages/' . $blog->image) }}"
                                                class="img-fluid w-100 h-100" alt="">
                                        </a>
                                    </div>
                                    <div class="col-8">
                                        <a href="{{ route('blog_category', $blog->categories->slug) }}"
                                            class="text-decoration-none x-small text-uppercase custom-color-01 fw-semibold">
                                            {{ $blog->categories->name }}
                                        </a>
                                        <h2 class="text-ellipsis-3 mt-2 mb-0 h4 fw-bold">
                                            <a href="{{ route('blog_details', $blog->slug) }}" class="nav-link">
                                                {{ $blog->title }}
                                            </a>
                                        </h2>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        @endif

        <section>
            <div class="container mt-5">
                <div class="d-flex justify-content-between align-items-end pt-md-3 border-4 border-bottom mb-4 pb-2"
                    style="border-color: var(--basic-orange) !important;">
                    <h2 class="mb-0 display-3 fw-bold lh-1">More {{ $blogcategory->name }}</h2>
                </div>
                <div class="row gy-3">
                    @forelse ($blogsdata as $blog)
                        <div class="col-lg-4 col-md-6">
                            <a href="{{ route('blog_details', strtolower(str_replace(' ', '-', $blog->slug))) }}"
                                class="card text-decoration-none text-dark border-0">
                                <img src="{{ asset('images/blogsImages/' . $blog->image) }}"
                                    class="rounded-3 img-fluid object-fit-cover w-100" alt="{{ $blog->image_alt }}"
                                    width="404" style="height:300px">
                                <div class="card-body p-0 pt-2">
                                    <h3 class="h5 card-title fw-semibold text-lg-truncate" title="{{ $blog->title }}">
                                        {{ $blog->title }}
                                    </h3>
                                    <p class="mb-0">By <span
                                            class="text-secondary fw-semibold">{{ empty($blog->author) ? 'Admin' : $blog->author }}</span>
                                    </p>
                                    <a href="{{ route('blog_category', @$blog->categories->slug) }}"
                                        class="text-decoration-none text-dark">
                                        <p class="card-text text-truncate">
                                            {{ $blog->categories->name ?? '' }}
                                        </p>
                                    </a>
                                </div>
                            </a>
                        </div>
                    @empty
                        <p class="m-0 p-0 text-center">No blogs Available!</p>
                    @endforelse
                    <div class='mt-2 mb-2 d-flex justify-content-center'>{{ $blogsdata->links() }}</div>
                </div>
            </div>
        </section>

    </main>
    @if($type != 'store')
        @push('js')
            <script type='application/ld+json'>
            {
                "@context":"https://schema.org",
                "@graph":[
                    {!! home_schema() !!},
                    {
                    "@type":"CollectionPage",
                    "@id":"{!! route('blog_category' ,$blogcategory->slug).'#webpage'!!}",
                    "url":"{!! route('blog_category' ,$blogcategory->slug) !!}",
                    "inLanguage":"en-US",
                    "name":"{!! $blogcategory->meta_title !!}",
                    "isPartOf":
                    {
                        "@id":"{{ route('blogs').'#website' }}"
                    },
                    "description":"{!! $blogcategory->meta_description !!}"
                    }
                ]
            }
            </script>
        @endpush
    @endif
@endsection
