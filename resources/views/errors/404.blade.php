<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Not Found</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
     <link rel="shortcut icon" href="{{ config('setting.site_favicon') }}" type="image/x-icon">
    <style>
        .custom-bg-color {
        background: #000000;

        }
        body{
            overflow:hidden;
            background:  #b8b6b6;

        }
        /* Ensuring image is responsive */
        .image-container img {
            width: 100%;
            height: 100%;
        }
        .main{
            height:100vh;
        }
        .bg-primary{
            background-color:#333333!important;
        }
    </style>
</head>

<body>
    <main>
        <section class="bg-primary main text-white">
            <div class="container">
                <div class="row  gy-4 py-3 mt-4">
                    <div class="col-md-6 d-flex flex-column justify-content-center align-items-center ">
                        <div class="">
                            <button class="btn custom-bg-color text-white rounded-pill">Page not found</button>
                            <p class="display-4 fw-bold py-4 mb-0">Oh No! Error 404</p>
                            <p class="mb-5">
                               This page is not available at our site Please Check Your URL.
                            </p>
                            <div class="d-flex gap-4 flex-wrap">
                                <a href="{{ url()->previous() }}" class="btn text-white custom-bg-color  rounded-3 fw-bold">Back to Page</a>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex align-items-center image-container">
                        <img src="{{ asset('user/assets/images/404.svg') }}" alt="404 Error" class="img-fluid">
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
