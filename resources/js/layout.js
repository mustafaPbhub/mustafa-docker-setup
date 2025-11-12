$(document).ready(function() {
    
    var url = window.location.href;
    var lowerCaseUrl = url.toLowerCase();
    history.pushState({}, '', lowerCaseUrl);
    // let newsletterUrl = "{{ route('subscribe') }}";
    $('.newsLetter').submit(function(e) {
        isValid = true;

        e.preventDefault();
        let formData = $(this).serialize();
        $(this).find('input[name="email"]').val('')
        $(this).find('input[name="is_consent"]').prop('checked', false);
        
        $.ajax(({
            url: newsletterUrl,
            type: "POST",
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $("#csrf_token").val()
            },
            success: function(res) {
                if (res.available) {
                    toastr['error']("Already subscribed to the newsletter");
                } else if (res.success) {
                    toastr['success']("Successfully Subscribed");
                } else {
                    toastr['error']("Failed to subscribe");
                }
            },
            error: function(data) {
                toastr['error']("Something Went Wrong");
            }
        }))
    });
    $(document).click(function() {
        $('.search_response-output').addClass('d-none');
        $('.search-res').addClass('d-none');
    })
    // Search ajax
    $('input[name="search"]').on('input', function(e) {

        e.preventDefault();
        $('.search_response-output').removeClass('d-none');
        $('.search-res').removeClass('d-none');
        let searchVal = $(this).val();
        // let seachURL = "{{ route('search') }}";
        // let storeDetails = "{{ route('store_details') }}";
        // let blogDetails = "{{ route('blog_details') }}";
        $.ajax({
            url: seachURL,
            type: "GET",
            data: {
                search: searchVal
            },
            success: function(res) {
                if (res.Store.length === 0 && res.Coupons.length === 0 && res.blogs
                    .length === 0) {
                    // If all arrays in response are empty
                    $("#store").html('<li class=" text-danger">No Result Found</li>');
                    $("#coupon").html('<li class=" text-danger">No Result Found</li>');
                    $("#blog").html('<li class=" text-danger">No Result Found</li>');
                } else {
                    let blog = "";
                    let store = "";
                    let coupons = "";

                    $(res.Store).each(function(index, value) {
                    store += `
                            <li class = "mb-2">
                                <a href="${storeDetails +'/' + value.slug.replace(/\s+/g, '-').toLowerCase()}" class="text-decoration-none">
                                    <div class="d-flex flex-row">
                                        <img src="${assetURL}/StoreImages/${value.image}"
                                            class="h-100 object-fit-cover rounded-3 me-1 search_response-img"
                                            height="100" width="120" alt="">
                                        <div class="overflow-hidden d-flex align-items-center">
                                            <p class="text-uppercase small mb-0 text-center text-dark text-truncate">
                                                ${value.name}
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            `;
                    });
                    $("#store").html(store);

                    // coupons
                    $(res.Coupons).each(function(index, value) {
                        coupons +=
                            `
                            <li class = "mb-2">
                                <a href="#" data-id="${value.id}" class="openModal text-decoration-none">
                                    <div class="d-flex flex-row">
                                        <img src="${assetURL}/StoreImages/${value.stores.image}"
                                            class="h-100 object-fit-cover rounded-3 me-1 search_response-img"
                                            height="100" width="120" alt="">
                                        <div class="overflow-hidden d-flex align-items-center">
                                            <p class="text-uppercase small mb-0 text-dark text-center text-truncate">
                                                ${value.offer_name}
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            `;
                    });

                    $("#coupon").html(coupons);

                    $(res.blogs).each(function(index, value) {
                        blog +=
                            `
                                <li class="mb-2">
                                    <a href="${blogDetails + '/' + value.slug.replace(/\s+/g, '-').toLowerCase()}" class="text-decoration-none">
                                        <div class="d-flex flex-row">
                                            <img src="${assetURL}/blogsImages/${value.image}"
                                                class="h-100 object-fit-cover rounded-3 me-1 search_response-img"
                                                height="100" width="120" alt="">
                                            <div class="overflow-hidden d-flex align-items-center">
                                                <p class="text-uppercase small text-dark mb-0 text-center text-truncate">
                                                    ${value.title}
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            `;
                    })
                    $("#blog").html(blog);
                }
            },
            error: function(data) {
                toastr['error']("Something Went Wrong");
            }
        });
    });
    // Coupon Modal opening Code
    $(document).ready(function() {
        currentBaseURl = window.location.href;
        if (currentBaseURl.includes('#coupon_code-')) {
            let couponID = currentBaseURl.split('#coupon_code-')[1];
            $('#searchCoupon').modal('show');
            openCouponModal(couponID);
        }

    })
    $(document).on('click', '.openModal', function(e) {

        let id = $(this).attr('data-id');
        let baseUrl = window.location.href.split('#')[0] + '#coupon_code-' + id;
        window.location.href = baseUrl;
        $('#searchCoupon').modal('show');
        openCouponModal(id);

    });

    function openCouponModal(id) {
        // let storeDetails = "{{ route('store_details') }}";
        // let couponModal = $(".couponModal");
        $.ajax({
            url: couponModalURL + '/' + id,
            type: "GET",
            data: {
                id: $(this).attr('data-id')
            },
            success: function(res) {
                let modalData = "";
                let baseUrl = window.location.href.split('/').slice(0, 3).join('/');
                let coupon = `
                <div class="d-flex justify-content-center mt-4">
                    <a href="${res.stores.tracking_url != null ? res.stores.tracking_url : "#"}" class="btn btn-warning rounded-1 text-white" target="_blank">Get this Deal</a>
                </div>`;
                if (res.coupon_type == 1) {
                    coupon = `
                            <div class="d-flex justify-content-center mt-4">
                                <div class="bg-dark-subtle w-auto d-flex p-1 rounded-pill" style="border: dashed 2px #000;">
                                    <input type="text" class="form-control border-0 w-100 bg-transparent" style="outline:none!important;" value="${res.coupon_code}"  id="copyInput" readonly>
                                    <button class="btn btn-light rounded-pill fw-semibold text-uppercase copyInput" data-clipboard-target="#foo" >Copy</button>
                                </div>
                            </div>
                            `;
                }
                modalData = `
                <div class="modal-header">
                    <div class="text-center w-100 ps-4">
                        <p class="text-center fw-semibold h3 text-decoration-underline border-bottom border-2 border-dark d-inline text-uppercase">
                            ${res.stores.name != "" ? res.stores.name : ""}
                        </p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <p class="text-center fs-5">${res.offer_box}</p>
                    </div>
                    <div class="d-flex justify-content-center align-items-center mb-5 mb-md-0" bis_skin_checked="1">
                        <div class="p-4 bg-dark-subtle shadow" bis_skin_checked="1">
                            <a href="${storeDetails +'/' + res.stores.slug.replace(/\s+/g, '-').toLowerCase()}">
                                <img src="${baseUrl}/images/StoreImages/${encodeURIComponent(res.stores.image)}" class="img-fluid shadow rounded" alt="${res.stores.image}">
                            </a>
                        </div>
                    </div>
                    ${coupon}
                </div>`;



                couponModal.html(modalData);





            },
            error: function(data) {
                toastr['error']("Something Went Wrong");
            }
        })
    }
    $(document).on('click', '.copyInput', function() {
        var textToCopy = document.getElementById('copyInput');
        textToCopy.select();
        document.execCommand("copy");

    })
    // Will copy Data

})