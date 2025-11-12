<div class="gtranslate_wrapper"></div>

@foreach (config('scriptlink') as $item)
    <script src="{{ asset($item) }}"></script>
@endforeach
@if (Session::has('error'))
    <script>
        toastr['error']("{{ Session::get('error') }}");
    </script>
@endif
@if (Session::has('success'))
    <script>
        toastr['success']("{{ Session::get('success') }}");
    </script>
@endif
{{-- @if (Route::currentRouteName() === 'home') --}}

    {{-- <script src="{{ asset('user/assets/js/splide.js') }}"></script> --}}
    {{-- <script src="{{ asset('user/assets/js/clipboard.min.js') }}"></script> --}}
  
     
{{-- @endif --}}
<script>
    let couponModal = $(".couponModal");
    let seachURL = "{{ route('search') }}";
    let storeDetails = "{{ route('store_details') }}";
    let blogDetails = "{{ route('blog_details') }}";
    let couponModalURL = "{{ route('coupon_details') }}";
    let newsletterUrl = "{{ route('subscribe') }}";
    let assetURL = "{{ asset('') }}";
</script>
