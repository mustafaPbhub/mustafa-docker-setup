@extends('User.layout')
@section('title')
    Blog Categories
@endsection
@section('content')
    <style>
        @media (width <=440px) {
            .small-heading {
                white-space: pre-line;
            }
        }
    </style>
    <main>
        <div class='pt-4 pt-lg-0'>
            <div class="container-fluid d-flex justify-content-center align-items-center my-3 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                    <path
                        d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2" />
                </svg>
                <p class="small mb-0 small-heading mx-2">
                    When you make a purchase, {{ ucfirst(config('setting.site_name')) }} earns a commission.
                </p>
            </div>
        </div>
        <section style="min-height: 50vh">
            <div class="container-fluid pt-3">
                <div class="text-center">
                    <h1><u>All Blog Categories</u></h1>
                </div>
                <div class="row row-cols-2 row-cols-md-3 row-cols-lg-5 mb-3">
                    @forelse ($categories as $key => $category)
                        <div class="col mt-3 overflow-y-hidden">
                            <div class="rounded-3 border pb-3 custom_card_animate" style="height:305px!important">
                                <a aria-label="link" href="{{ route('blog_category', $category->slug) }}"
                                    class="text-decoration-none text-dark d-flex flex-column">
                                    <span>
                                        <img style="height: 242px;object-fit: contain;"
                                            src="{{ asset('images/BlogCategoriesImages/' . $category->image) }}"
                                            class="card-img-top img-fluid px-md-4 py-2"
                                            alt="67241330_2461182777279421_5091668585353314304_n.png">
                                    </span>
                                    <p class="f-16 text-uppercase text-center fs-6 fw-semibold mb-0">
                                        {{ $category->name }}</p>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-danger mt-3 w-100 d-flex justify-content-center align-items-center">
                            <span class="text-center">No Data Found</span>
                        </div>
                    @endforelse



                </div>
                <div class="d-flex justify-content-start mt-3 mb-2">{{ $categories->links() }}</div>
            </div>
        </section>
    </main>
@endsection
