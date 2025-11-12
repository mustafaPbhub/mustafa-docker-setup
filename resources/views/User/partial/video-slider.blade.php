
   <style>
    .displayer {
        display: none;
    }
    .price-title{
        font-size:16px;
    }
    .videoslider{
        position: fixed;
        top: 0;
        z-index:1000;
        height:100vh;
        width:100%;
        display:none
    }
    .splider-slide>div>div>div>img {
        width: 60%;
    }

    .splider-slide.is-active>div>div>div>img {
        width: 100%;
    }

    .splider-slide.is-active {
        .displayer {
            display: block;
        }
        .imger{
            display: none
        }
        .videoer{
            display: block
        }
    }
    .toggle-audio{
        position:absolute;
        top:2%;
        right:5%;
        z-index:10000;
        width: 50px; /* ya jo bhi size chahiye */
        height: 50px; /* same size */
    }
    @media (width <= 400px){
        .title{
            font-size:12px!important;
        }
    }

</style>



<div class="d-flex videoslider bg-dark justify-content-center align-items-center" style="height: 100vh; display:none!important;">
    <section class="splide m-3" id="videoSlider" aria-label="Splide Basic HTML Example">
        <button class="closeBtn btn btn-white bg-white fw-bold rounded-2 text-dark border-white" style="position:fixed; top:10px; right:10px; z-index:1000">x</button>
        <div class="splide__track" style="height: 100%;">
            <ul class="splide__list" style="padding: 0;">
                @foreach($product as $i => $value)
                    <li class="splide__slide  splider-slide" >
                        <div class="row w-100 mx-auto justify-content-center "style="height: 600px!important;margin: 0;" >
                            <div class="col-6 px-0 d-none d-sm-block rounded-start overflow-hidden" style="padding: 0;">
                                <div class="h-100 text-center videoDiv position-relative">
                                    <video  data-id={{ $i }} data-product-id={{ $value->id }}   @if(!empty($value->thumbnail)) poster="{{ asset('/images/ProductThumbnail/' .$value->thumbnail ?? '') }}" @endif  src="{{ asset('images/ProductVideos/'. $value->video) }}"  class="img-fluid video-slider video" style="height: 600px!important; 1000px ; object-fit:cover;cursor: pointer;"></video>
                                   <button class="toggle-audio rounded-circle p-2 bg-dark btn btn-dark"><i class='bx bx-volume-full mb-1 mt-1'></i></button>
                                </div>
                            </div>
                            <div class="bg-white displayer p-4 col-md-6 rounded-end position-relative" style="padding: 1rem;overflow:hidden;">
                                <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        @foreach ($value->images as $item => $data)
                                            <div class="carousel-item {{ $item == 0 ? 'active' : '' }}">
                                                <img src="{{ asset('images/ProductSubImages/' . $data->image) }}" alt="" class="img-fluid p-3 border rounded d-block w-100" style="height: 200px!important;width:100%!important; object-fit:contain;">
                                            </div>
                                        @endforeach
                                    </div>

                                </div>

                                                    <div class="h2 text-gray-600 fw-bold" style="font-size:18px;margin-top:15px">{{ $value->name }}</div>
                                                    <div class="h5 mb-0 text-gray-800" style="font-size: 12px;margin-top: -4px;">
                                                        <p class="card-text mb-0 p-0 price-title text-start py-2">
                                                            @if ($value->is_discount)
                                                           <span class="fw-bold">{{ $value->currency ?? "$" }}{{ $value->discounted_amount }}</span> <del class="text-secondary disabled">{{ $value->currency ?? "$" }}{{ $value->price }}</del> <b class="text-success ms-2 small ">{{ round(( $value->discounted_amount / $value->price ) * 100 , 0) }}% off</b>
                                                            @else
                                                             <span class="fw-bold">{{ $value->currency ?? "$" }}{{ $value->price }}</span>
                                                            @endif
                                                        </p>
                                                    </div>

                                                    <div class="mt-2" style="height:6px;width:100;background:rgba(185, 185, 185, 0.473) ; margin-bottom:15px"></div>
                                                 <span class="mt-0 p-0 py-1 fw-bold mb-2">Description</span>
                                                 <div class="description-container mt-2" style="    overflow-x: hidden;height: 150px;">
                                                    {!! $value->short_description !!}
                                                 </div>
                                        <div class=" w-100 p-4 text-white bordet-top mt-2" style="position:absolute; bottom:-1%;  right:1%;">
                                            <div class="mt-2" style="height:6px;width:100;background:rgba(185, 185, 185, 0.473) ; margin-bottom:15px"></div>

                                         <a href="{{ @$value->tracking_url ?? "" }}" class="btn btn-dark  w-100">Visit Store</a>
                                        </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>
</div>

<div class="main-container">
    <div class="parent-container">

        <div class="sliderContainer">
              <div class="top-icon">
            <button class="btn text-white bg-dark shadow closeBtnMobile"><i class='bx bx-x'></i></button>
          </div>
            <div class="slider-container splide">
                <div class="splide__track">
                    <div class="splide__list">
                        @foreach($product as $i => $value)
                        <div class="splide__slide">
                            <div class="center-icon-1 mt-2">
                                <button class="btn  text-white bg-dark toggle-audio-mobile"><i class='bx bx-volume-mute' ></i></button>
                            </div>
                            <video  data-product-id={{ $value->id }} src="{{ asset('images/ProductVideos/'. $value->video) }}" data-id="{{ $i }}" class="slide_video video" ></video>
                            <div class="bottom-slider bg-white">
                                <div class="d-flex justify-content-between py-2 px-2">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('images/ProductImages/'.  $value->image ) }}" class="img-fluid border" width='60' height='60' style="">
                                        <div class="p-2 ">
                                        <p class="f-2 mb-0 mt-0 fw-bold title lh-sm " style='font-size:16px'>{{ ucfirst($value->name) }}</p>
                                        <span class="f-2 mt-1 title" style='font-size:16px'>
                                            @if ($value->is_discount)
                                            <span class="fw-bold">{{ $value->currency ?? "$" }}{{ $value->discounted_amount }}</span> <del class="text-secondary disabled">{{ $value->currency ?? "$" }}{{ $value->price }}</del> <b class="text-success ms-2 small ">{{ round(( $value->discounted_amount / $value->price ) * 100 , 0) }}% off</b>
                                             @else
                                              <span class="fw-bold">{{ $value->currency ?? "$" }}{{ $value->price }}</span>
                                             @endif

                                        </span>

                                        </div>
                                    </div>
                                    <div class="my-auto me-2">
                                        <a class="btn btn-dark shadow"  href="{{ @$value->tracking_url ?? "" }}" style='font-size:14px ; white-space:nowrap'>Shop Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>
            <!-- Bottom of Slider -->

        </div>
    </div>
</div>




