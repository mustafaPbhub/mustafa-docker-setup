@extends('User.layout')
@section('title')
    Terms And Conditions
@endsection
@section('content')
    <main class="h-100 container " style="min-height:80vh; height:auto">

        <div class="heading mt-3 px-3 container">
            <h1 class="text-uppercase text-center fw-bold">
                Terms And Conditions
            </h1>
            <p class="px-3">
                Welcome to {{ config('setting.site_name') }}! These terms and conditions are designed to safeguard your
                rights and ensure the security of the information collected from you. They also outline the legal
                obligations of both you as a user and us as a company.
            </p>
            <p class="px-3">The terms and conditions outlined in this agreement govern the services made available by
                {{ config('setting.site_name') }}. These terms represent the understanding between "the Company" (referred to as "We", "Us",
                "Our") and the customer or individual utilizing our services, referred to as "You".
            </p>
            <p class="px-3 mt-0">
                Before using our services, we recommend that every individual read these terms and conditions carefully, as
                they are legally binding and outline the obligations of both parties.
            </p>
        </div>
        <hr>

        <div class="heading text-start mt-3 px-3 container">
            <h2 class="fs-3 text-uppercase fw-bold">
                General

            </h2>
            <p>
                By using our services, you agree to comply with the terms and conditions stated in this agreement. Please
                ensure you have thoroughly reviewed the policy before using our services. The company reserves the right to
                terminate the use of services at any time without prior notice if you violate any terms and conditions, act
                against the conduct guidelines, or pose a threat to the company.

            </p>
        </div>

        <div class="heading text-start mt-3 px-3 container">
            <h2 class="fs-3 text-uppercase fw-bold">

                Referral Tracking


            </h2>
            <p>
                {{ config('setting.site_name') }} includes specific referral links on advertisements and content leading to
                third-party platforms. By using our services, you consent to the tracking of your activity via these
                referral links. The company will not amend cookies without notifying consumers.

            </p>
        </div>
        <div class="heading text-start mt-3 px-3 container">
            <h2 class="fs-3 text-uppercase fw-bold">
                Who Can Use the Platform
            </h2>
            <p>
                To ensure a safe browsing experience, our services are restricted to individuals who meet the following
                criteria:
            </p>
            <ul class="m-3 ">
                <li>You must be at least 12 years of age.
                </li>
                <li>We have not previously terminated your use of our services due to policy violations.
                </li>
                <li>You are not a convicted sex offender.
                </li>
                <li>You have no previous scam background.</li>
                <li>You are legally allowed to receive our services.</li>
            </ul>
        </div>
        <hr>
        <div class="heading text-start mt-3 px-3 container">
            <h2 class="fs-3 text-uppercase fw-bold">
                Individual Conduct

            </h2>
            <p>
                You consent to not use the services to:

            </p>
            <ul class="m-3 ">
                <li>Violate any applicable laws or policies.
                </li>
                <li>Impersonate someone else to use our services.
                </li>
                <li>Publish, share, or post any content that is sexually explicit, obscene, invasive of privacy, racially or
                    ethnically offensive, or otherwise objectionable.
                </li>
                <li>Share content that violates copyright laws or is intellectual property of another person.</li>
                <li>Share advertisements or solicitations unrelated to the entity without permission.</li>
                <li>
                    Expose the platform to viruses, threats, encrypted files, or programs that corrupt or limit
                    functionality.
                </li>
                <li>Harm the entity’s services or damage website content.
                </li>
                <li>
                    Gain unauthorized access to the services, servers, or network systems.
                </li>
            </ul>
        </div>
        <hr>
        <div class="heading text-start mt-3 px-3 container">
            <h2 class="fs-3 text-uppercase fw-bold">
                Governing Law
            </h2>
            <p>
                To enhance your shopping experience and address your concerns, you can contact us at <b>info{{ '@' . str_replace(' ', '', strtolower(config('setting.site_name'))) }}.com</b>. Any claims arising from legal disputes related to these terms and conditions will be governed by the laws of the state. By using our services, you agree to settle legal disputes in federal or state courts where the laws apply.

            </p>
        </div>

        <div class="heading text-start mt-3 px-3 container">
            <h2 class="fs-3 text-uppercase fw-bold">
                Limitation of Liability
            </h2>
            <p>
                We strive to provide the best content and deals. The products and services displayed are "as is" on third-party websites. We make no guarantees that content will be error-free, secure, or without disruptions. We disclaim all warranties, including implied warranties by third parties, merchants, fitness for a particular purpose, and non-infringement. We do not control content on third-party websites and are not responsible for it.
            </p>
            <p>Our liability is limited to the content shared on {{ config('setting.site_name') }} and is only applicable under law. Under no circumstance will we be liable to you or any third party for loss of profits, data, or damages arising from these terms.
            </p>
        </div>
        <div class="heading text-start mt-3 px-3 container">
            <h2 class="fs-3 text-uppercase fw-bold">
                Intellectual Property

            </h2>
            <p>
                {{ config('setting.site_name') }} grants you a personal, worldwide, royalty-free, non-transferable, non-assignable, and non-exclusive license to use the service for personal, non-commercial purposes. All content and images on the website are the property of {{ config('setting.site_name') }}. You do not have the right to use the content for personal gain or commercial purposes. Any feedback or suggestions you provide are free for us to use without obligation to you.
            </p>
        </div>
        <div class="heading text-start mt-3 px-3 container">
            <h2 class="fs-3 text-uppercase fw-bold">
                Contact Information
            </h2>
            <p>
                We welcome your comments, questions, and suggestions at <b>info{{ '@' . str_replace(' ', '', strtolower(config('setting.site_name'))) }}.com</b>.
            </p>

        </div>
        <div class="heading text-start mt-3 px-3 container">
            <h2 class="fs-3 text-uppercase fw-bold">
                Third-Party Advertisements and Content

            </h2>
            <p>
                Our services may contain links to third-party websites. While we ensure due diligence before publication, we have no control over third-party content and advertisements. We cannot confirm or endorse claims made by third parties.
            </p>
        </div>
        <div class="heading text-start mt-3 px-3 container">
            <h2 class="fs-3 text-uppercase fw-bold">
                Agreement
            </h2>
            <p>
                {{ config('setting.site_name') }} reserves the right to change these terms and conditions at any time without prior notice. Any changes will be displayed on this page. Please review the updated date before using the services. By using our services, you agree to comply with these terms and conditions.

            </p>
        </div>








    </main>
    @push('js')
    @endpush
@endsection
