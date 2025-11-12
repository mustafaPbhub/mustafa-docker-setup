@extends('User.layout')
@section('title')
    About Us
@endsection
@section('content')
    <main class="h-100 container " style="min-height:80vh; height:auto">

        <div class="heading mt-3 mb-3 text-center container">
            <h1 class="fs-3 text-uppercase fw-bold">
                About Us
            </h1>
            <p>
                Welcome to <b>{{ config('setting.site_name') }}</b>, your premier destination for discovering the latest
                digital products and services through affiliate marketing. Our commitment is to bring you top-notch digital
                solutions, exclusive offers, and valuable content to enhance your digital experience.
            </p>
        </div>
        <hr>
        <div class="heading text-start mt-3 px-3 container">
            <h2 class="fs-3 text-uppercase fw-bold">
                Who Are We
            </h2>
            <p>
                At {{ config('setting.site_name') }}, we are passionate about keeping you informed and connected with the
                latest digital products and services. Our team comprises dedicated professionals, including tech
                enthusiasts, researchers, and writers, who work tirelessly to provide you with up-to-date information and
                the best deals available.
            </p>
        </div>
        <div class="heading text-start mt-3 px-3 container">
            <h2 class="fs-3 text-uppercase fw-b~old">
                Our Mission
            </h2>
            <p>
                Our mission at {{ config('setting.site_name') }} is to simplify your digital experience by offering a
                curated selection of trending digital products and services. We aim to be your trusted source for finding
                quality digital solutions at competitive prices, ensuring that you always have access to the best the
                digital market has to offer.
            </p>
        </div>

        <div class="heading text-start mt-3 px-3 container">
            <h2 class="fs-3 text-uppercase fw-bold">
                Our Vision
            </h2>
            <p>
                Our vision is to become a leading authority in the affiliate marketing space for digital products and
                services, renowned for our reliability and excellence. We strive to build a platform where users can
                effortlessly discover the latest digital trends, access unbeatable deals, and enjoy an exceptional digital
                experience.
            </p>
        </div>

        <div class="heading text-start mt-3 px-3 container">
            <h2 class="fs-3 text-uppercase fw-bold">
                What We Do
            </h2>
            <ul class="m-3 ">
                <li>We handpick the most popular and trending digital products from various categories to ensure you find
                    exactly what you’re looking for.
                </li>
                <li>Our comprehensive reviews and buying guides offer you insights into the digital products we feature,
                    helping you make informed decisions.
                </li>
                <li>Through our affiliate partnerships, we bring you special offers and discounts, making your digital
                    experience both enjoyable and economical.
                </li>
                <li>We continuously monitor market trends and consumer preferences, ensuring that our content remains fresh
                    and relevant.</li>
            </ul>
        </div>
        <hr>
        <div class="heading text-start mt-3 px-3 container">
            <h2 class="fs-3 text-uppercase fw-bold">
                Join Our Community
            </h2>
            <p>
                Become a part of the {{ config('setting.site_name') }} community and stay ahead of the trends. Follow us on
                social media to stay connected and be a part of our growing family. If you have any questions, suggestions,
                or feedback, please reach out to us at
                info{{ '@' . str_replace(' ', '', config('setting.site_name')) }}.com. Our team will be more than happy to
                help.

                Thank you for choosing {{ config('setting.site_name') }} We look forward to providing you with the best
                digital products, deals, and digital experience.

            </p>
        </div>







    </main>
@endsection
