@extends('User.layout')
@section('title')
 All Blogs
@endsection
@section('content')
    <main>

        <div class="container mt-5">
            <h1 class="text-md-start text-center fw-semibold">All Blogs</h1>
        </div>
        <section>
            <div class="container">
                <div class="py-4">

                    <div class="row row-cols-1 row-cols-md-3 mx-auto g-4 mt-1">
                        @foreach ($blogs as $blog)
                            <div class="col  hover-class p-2 rounded">
                                <a href="{{ route('blog_details', strtolower(str_replace(' ', '-', $blog->slug))) }}"
                                    class="card text-decoration-none text-dark border-0">
                                    <img src="{{ asset('images/blogsImages/' . $blog->image) }}" class="rounded-3 img-fluid object-fit-cover"
                                        alt="{{ $blog->image_alt }}" style="height:300px">
                                    <div class="card-body p-0 pt-2">
                                        <h2 class="h5 card-title fw-semibold text-lg-truncate" title="{{ $blog->title }}">
                                             {!! $blog->title !!}
                                        </h2>
                                        <p class="mb-0">By <span class="text-secondary fw-semibold">{{ empty($blog->author) ? 'Admin' : $blog->author }}</span></p>
                                        <a href="{{ route('blog_category', @$blog->categories->slug) }}" class="text-decoration-none text-dark">
                                            <p class="card-text text-truncate">
                                                {{ $blog->categories->name ?? '' }}
                                            </p>
                                        </a>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
            <div class="d-flex justify-content-center mt-3 mb-3">
                {{ $blogs->links() }}
            </div>
        </section>

    </main>

    @push('js')
        <script type='application/ld+json'>
        {
          "@context": "https://schema.org",
          "@graph": [
            {!! home_schema() !!},
            {
              "@type": "CollectionPage",
              "@id": "{!! route('blogs').'#webpage' !!}",
              "url": "{!!  route('blogs') !!}",
              "inLanguage": "en-US",
              "name": "{!! config('metatags.meta_title') ?? config('setting.site_name') !!}",
              "isPartOf":
              {
                  "@id": "{!! route('blogs').'#website' !!}"
              },
              "description": "{!! config('metatags.meta_description') ?? config('setting.site_name') !!}"
            }
          ]
        }
        </script>
    @endpush
@endsection
