@extends('User.layout')
@section('title')
Store
@endsection
@section('content')

<main >
    <section>
    <div class="shadow">
        <div class="container"   >
            <h1 class="fw-bold h3 py-3">Browse Stores Starting with <span id="change_value"> A </span></h1>
            <ul class="nav nav-tabs border-0 d-flex justify-content-evenly" id="myTab" role="tablist">
                @for($i  = 0 ; $i < $lettersCount ; $i ++)
                <li class="nav-item mb-3 btn btn-sm letter-links  @if($letters[$i] == "a" ) active show @endif"  id="{{ $letters[$i] }}-tab" data-bs-toggle="tab"
                    data-bs-target="#{{ $letters[$i] == "0-9" ? 'zero_line' : $letters[$i] }}" type="button" onclick="(changeText(this))" role="tab" aria-controls="{{ $letters[$i] }}"
                        @if($letters[$i] == "a") aria-selected="true" @else aria-selected="false"  @endif>
                   {{ strtoupper($letters[$i]) }}
                </li>
                @endfor
            </ul>
        </div>
    </div>
</section>

    <section>
    <div class="bg-light"  style="min-height: 100vh ; height:auto">
        <div class="container">
            <div class="tab-content bg-light" id="myTabContent">

                <div class="tab-pane fade show active" id="a" role="tabpanel" aria-labelledby="a-tab">
                    <ul class="row mt-3 pt-3" id="tabpaneContainer">
                          @foreach ($stores as $storeinline)
                            <li class="col-lg-4 col-md-6 col-12 mb-3 underline_effect"> <a href="{{ route('store_details' ,strtolower(str_replace(" " , "-" , $storeinline->slug))) }}" class="text-secondary nav-link">{{ $storeinline->name }}</a></li>
                          @endforeach
                        </ul>
                </div>

            </div>
        </div>
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
        "@id":"{!! route('stores').'#webpage' !!}",
        "url":"{!! route('stores') !!}",
        "inLanguage":"en-US",
        "name":"{!! config('metatags.meta_title') ?? config('setting.site_name') !!}",
        "isPartOf":{"@id":"{{ config('setting.url').'#website' }}"},
        "description":"{!! config('metatags.meta_description') ?? config('setting.site_name') !!}"
        }
    ]
}
</script>
<script>

$(document).ready(function(){

    let getStoresUrl     = "{{ route('get_stores') }}";
    let tabpaneContainer = $("#tabpaneContainer");

    $(document).on('click', '.letter-links' , function(e){
        e.preventDefault();
        $('.letter-links').removeClass('active show');
        $(this).addClass('active show');
       let letter = $(this).text().trim();
       let tabData  = "" ;
        $.ajax({
            url  : getStoresUrl ,
            'type': "Get" ,
            'data': {letter : letter},
            success: function(response){
                if(response.stores != "empty"){
                    $(response.stores).each(function(index,  value){
                        let storeUrl  = "{{ route('store_details')}}" +"/"+value.slug.replace(/\s+/g, '-').toLowerCase() ;
                        tabData += `
                        <li class="col-lg-4 col-md-6 col-12 mb-3 underline_effect">     <a href="${storeUrl}" class="text-secondary nav-link">${value.name}</a></li>`;
                    })
                    tabpaneContainer.html(tabData);
                    $('.tab-pane').attr('id', letter.toLowerCase());
                    $('.tab-pane').addClass('show active');
                    $('.tab-pane').attr('aria-labelledby', letter.toLowerCase() + '-tab'); // Changing aria-labelledby attribute

                }
                else{
                    tabData += `<li class="col-lg-12 col-md-12 col-12 mb-3 underline_effect text-danger">No Stores Available that start with ${letter}</li>`;
                    tabpaneContainer.html(tabData);
                    $('.tab-pane').attr('id', letter.toLowerCase());
                    $('.tab-pane').addClass('show active');
                    $('.tab-pane').attr('aria-labelledby', letter.toLowerCase() + '-tab');
                }
            }
        });
    })
})
</script>

@endpush
@endsection
