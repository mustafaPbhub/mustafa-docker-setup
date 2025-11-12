@section('title')
Not Authorized User
@endsection
@section('content')
<div class="container-xxl container-p-y">
    <div class="misc-wrapper">
      <h1 class="mb-2 mx-2">You are not authorized!</h1>
      <p class="mb-4 mx-2">You don’t have permission to access this page.</p>
      <div class="mt-5">
        <img src="{{ asset('assets/img/illustrations/girl-hacking-site-light.png') }}" alt="page-misc-not-authorized-light" width="450" class="img-fluid" >
      </div>
    </div>
  </div>
@endsection
