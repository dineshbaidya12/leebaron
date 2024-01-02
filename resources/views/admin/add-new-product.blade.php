@extends('admin.layouts.app')
@php
    $res = $isEdit ? 'Modify' : 'Add New';
@endphp
@section('title', $res . ' Product')
@section('pagename', $res . ' Product')
@section('custom-styles')
    <style>
        #form-div {
            width: 80%;
            margin: auto;
            padding: 20px;
        }

        #location {
            width: 100%;
            border: 1px solid #e2e8f0;
            font-size: 12px;
            background: transparent;
        }

        .profile-picture {
            height: 150px;
            width: 150px;
            margin: auto;
            border-radius: 50%;
            background: transparent;
            position: relative;
            /* overflow: hidden; */
        }

        .profile-picture img {
            height: 100%;
            width: 100%;
            object-fit: cover;
            border-radius: 50%;
            border: 1px solid #c8c8c8
        }

        .edit-icon {
            position: absolute;
            top: -10px;
            font-size: 26px;
            right: -8px;
            cursor: pointer;
            padding: 5px;
        }

        .show_mul_img_div,
        .show_mul_img_div_existing {
            display: inline-block;
            height: 100px;
            width: 100px;
            object-fit: cover;
            vertical-align: top;
            border: 1px solid grey;
            margin: 5px;
        }

        .show_mul_img_div img,
        .show_mul_img_div_existing img {
            height: 100%;
            width: 100%;
            object-fit: cover;
        }

        .cross {
            position: absolute;
            top: -12px;
            right: -12px;
            color: red;
            background: #eee;
            padding: 5px;
            border: 1px solid gray;
            border-radius: 50%;
            font-size: 18px;
            cursor: pointer;
            transition: .3s all ease-in;
        }

        .cross:hover {
            color: white;
            background: red;
            transform: scale(1.2);
        }
    </style>
@endsection
@section('content')
    <div class="box">
        <form action="{{ route('product-action') }}" method="POST" enctype="multipart/form-data" name="add-edit-product"
            id="product-form">
            @csrf
            <input type="hidden" name="editId" value="{{ $isEdit ? $product->id : 0 }}">

            <div id="form-div">

                <div class="box-body">
                    <div class="profile-picture">
                        @if ($isEdit)
                            @if ($product->main_img != '')
                                <img src="{{ asset('storage/product/thumb/' . $product->main_img) }}" alt="Product Image"
                                    id="show-profile-picture">
                            @else
                                <img src="{{ asset('admin/images/leebaron/default-product.png') }}" alt="Product Image"
                                    id="show-profile-picture">
                            @endif
                        @else
                            <img src="{{ asset('admin/images/leebaron/default-product.png') }}" alt="Product Image"
                                id="show-profile-picture">
                        @endif

                        <i class="ti ti-pencil edit-icon" id="edit-profile-picture"></i>
                    </div>
                </div>

                <div class="w-full p-4">
                    <label for="product_img" class="ti-form-label">Product Image:</label>
                    <div class="relative">
                        <input type="file" class="ti-form-input" name="product_img" id="profile-picture"
                            onchange="profileChange(this);" accept=".png, .jpg, .jpeg" {{ $isEdit ? '' : 'required' }}>
                    </div>
                </div>

                <div class="w-full p-4">
                    <label for="category" class="ti-form-label">Category:</label>
                    <div class="relative">
                        <select name="category" id="category" class="w-full ti-form-select" required>
                            <option value="">Select A Category</option>
                            @foreach ($catgories as $cat)
                                @if ($isEdit)
                                    <option value="{{ $cat->id }}"
                                        {{ $product->cateogry == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->category_name }}
                                    </option>
                                @else
                                    <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>


                <div class="w-full p-4">
                    <label for="product_name" class="ti-form-label">Product Name:</label>
                    <div class="relative">
                        <input type="text" class="ti-form-input" name="product_name" required
                            value="{{ $product->name ?? '' }}">
                    </div>
                </div>

                <div class="w-full p-4">
                    <label for="product_code" class="ti-form-label">Product Code:</label>
                    <div class="relative">
                        <input type="text" class="ti-form-input" name="product_code" style="text-transform:uppercase;"
                            required value="{{ $product->product_code ?? '' }}">
                    </div>
                </div>

                <div class="w-full p-4">
                    <label for="product_price" class="ti-form-label">Product Price:</label>
                    <div class="relative">
                        <input type="number" class="ti-form-input" name="product_price" required
                            value="{{ $product->price ?? '' }}">
                    </div>
                </div>

                <div class="w-full p-4">
                    <label for="product_description" class="ti-form-label">Product Description:</label>
                    <div class="relative p_desc">
                        <textarea name="product_description" class="ti-form-input" id="product_description" rows="9" required>{{ $product->description ?? '' }}</textarea>
                    </div>
                </div>

                <div class="w-full p-4" id="show_nul_imgs">
                    @if ($isEdit)
                        @foreach ($pImages as $sImg)
                            <div class="show_mul_img_div_existing relative">
                                <img alt="Uploaded multiple image"
                                    src="{{ asset('storage/product/sub-img/thumb/' . $sImg->image) }}">
                                <i class="ti ti-x cross" data-id={{ $sImg->id }}></i>
                            </div>
                        @endforeach
                    @endif
                </div>

                <div class="w-full p-4">
                    <label for="p_mul_imgs" class="ti-form-label">Product Multiple Images:</label>
                    <div class="relative">
                        <input type="file" class="ti-form-input" name="product_multiple_images[]" id="p_mul_imgs"
                            accept=".jpg, .png, .jpeg" multiple>
                    </div>
                </div>


                <div class="grid grid-cols-2 gap-4">
                    <div class="w-full p-4">
                        <label for="site-title" class="ti-form-label">Status:</label>
                        <div class="grid sm:grid-cols-2 gap-2">
                            <label
                                class="flex p-3 w-full bg-white border border-gray-200 rounded-sm text-sm focus:border-primary focus:ring-primary dark:bg-bgdark dark:border-white/10 dark:text-white/70">
                                <input type="radio" name="status" class="ti-form-radio" id="hs-radio-in-form"
                                    value="active" required
                                    @if ($isEdit) {{ $product->status == 'active' ? 'checked' : '' }} @else {{ 'checked' }} @endif>
                                <span class="text-sm text-gray-500 ltr:ml-2 rtl:mr-2 dark:text-white/70">Active</span>
                            </label>
                            <label
                                class="flex p-3 w-full bg-white border border-gray-200 rounded-sm text-sm focus:border-primary focus:ring-primary dark:bg-bgdark dark:border-white/10 dark:text-white/70">
                                <input type="radio" name="status" class="ti-form-radio" id="hs-radio-checked-in-form"
                                    value="inactive" required
                                    @if ($isEdit) {{ $product->status == 'inactive' ? 'checked' : '' }} @endif>
                                <span class="text-sm text-gray-500 ltr:ml-2 rtl:mr-2 dark:text-white/70">Inactive</span>
                            </label>
                        </div>
                    </div>

                    <div class="w-full p-4">
                        <label for="site-title" class="ti-form-label">Order :</label>
                        <input type="number" id="orderby" class="ti-form-input" name="orderby"
                            value="{{ $product->orderby ?? '' }}" required>
                    </div>

                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="w-full p-4">
                        <label for="site-title" class="ti-form-label">Use Default Meta Information :</label>
                        <div class="grid sm:grid-cols-2 gap-2">
                            <label
                                class="flex p-3 w-full bg-white border border-gray-200 rounded-sm text-sm focus:border-primary focus:ring-primary dark:bg-bgdark dark:border-white/10 dark:text-white/70">
                                <input type="radio" name="default_meta" class="ti-form-radio" id="hs-radio-in-form"
                                    checked="" value="yes" required
                                    @if ($isEdit) {{ $product->default_meta == 'yes' ? 'checked' : '' }} @endif>
                                <span class="text-sm text-gray-500 ltr:ml-2 rtl:mr-2 dark:text-white/70">Yes</span>
                            </label>
                            <label
                                class="flex p-3 w-full bg-white border border-gray-200 rounded-sm text-sm focus:border-primary focus:ring-primary dark:bg-bgdark dark:border-white/10 dark:text-white/70">
                                <input type="radio" name="default_meta" class="ti-form-radio"
                                    id="hs-radio-checked-in-form" value="no" required
                                    @if ($isEdit) {{ $product->default_meta == 'no' ? 'checked' : '' }}  @else {{ 'checked' }} @endif>
                                <span class="text-sm text-gray-500 ltr:ml-2 rtl:mr-2 dark:text-white/70">No</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div id="default-desc-div">
                    <div class="w-full p-4">
                        <label for="page_title" class="ti-form-label">Page Title:</label>
                        <div class="relative">
                            <input type="text" class="ti-form-input" name="page_title" id="page_title"
                                value="{{ $product->page_title ?? '' }}">
                        </div>
                    </div>

                    <div class="w-full p-4">
                        <label for="meta_desc" class="ti-form-label">Meta Description:</label>
                        <div class="relative">
                            <textarea name="meta_desc" class="ti-form-input" id="meta_desc" rows="3">{{ $product->meta_desc ?? '' }}</textarea>
                        </div>
                    </div>

                    <div class="w-full p-4">
                        <label for="meta_key" class="ti-form-label">Meta Keywords:</label>
                        <div class="relative">
                            <textarea name="meta_key" class="ti-form-input" id="meta_key" rows="3">{{ $product->meta_key ?? '' }}</textarea>
                        </div>
                    </div>
                </div>


                <div class="w-full p-4">
                    <input type="submit" id="submit" class="ti-btn ti-btn-primary" value="Submit">
                </div>

            </div>
        </form>
    </div>
@endsection

@section('custom-scripts')
    <script src="{{ asset('admin/js/ckeditor/ckeditor.js') }}"></script>
    <script>
        $(document).ready(function() {
            //ckeditor
            CKEDITOR.replace('product_description');

            let selectedValue = $('input[name="default_meta"]:checked').val();
            if (selectedValue == 'no') {
                $('#default-desc-div').css('display', 'block');
                $('input[name="page_title"]').attr('required', true);
                $('textarea[name="meta_desc"]').attr('required', true);
                $('textarea[name="meta_key"]').attr('required', true);
            } else {
                $('#default-desc-div').css('display', 'none');
                $('input[name="page_title"]').attr('required', false);
                $('textarea[name="meta_desc"]').attr('required', false);
                $('textarea[name="meta_key"]').attr('required', false);
            }


            $('input[name="default_meta"]').on('change', function() {
                let selectedValue = $(this).val();
                console.log(selectedValue);
                if (selectedValue == 'no') {
                    $('#default-desc-div').css('display', 'block');
                    $('input[name="page_title"]').attr('required', true);
                    $('textarea[name="meta_desc"]').attr('required', true);
                    $('textarea[name="meta_key"]').attr('required', true);
                } else {
                    $('#default-desc-div').css('display', 'none');
                    $('input[name="page_title"]').attr('required', false);
                    $('textarea[name="meta_desc"]').attr('required', false);
                    $('textarea[name="meta_key"]').attr('required', false);
                }
            });
        });

        $('#submit').on('click', function(e) {
            var invalidInputs = $('input[required], textarea[required], select[required]').filter(function() {
                return !$(this).val();
            });

            $('input[required], textarea[required], select[required]').removeClass('err');

            var data = CKEDITOR.instances.product_description.getData();
            if (data == '') {
                $('.p_desc').css('border', '1px solid red');
            } else {
                $('.p_desc').css('border', '');
            }

            if (invalidInputs.length > 0) {
                event.preventDefault();
                invalidInputs.addClass('err');
            } else {
                $('input[required], textarea[required], select[required]').removeClass('err');
                if (data == '') {
                    $('.p_desc').css('border', '1px solid red');
                } else {
                    $('.p_desc').css('border', '');
                    $('form[name="add-edit-product"]').submit();
                }
            }
        });

        document.getElementById('edit-profile-picture').addEventListener('click', function() {
            document.getElementById('profile-picture').click();
        });
        document.getElementById('show-profile-picture').addEventListener('click', function() {
            document.getElementById('profile-picture').click();
        });


        function profileChange(input) {
            const profilePicImg = document.getElementById('show-profile-picture');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    profilePicImg.src = e.target.result;
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        $('#p_mul_imgs').on('change', function() {
            $('.show_mul_img_div').remove();
            let files = this.files;
            let projectsAllSubImagesDiv = $('#show_nul_imgs');
            for (let i = 0; i < files.length; i++) {
                let subSingleImgDiv = $('<div class="show_mul_img_div"></div>');
                let image = $('<img alt="Uploaded multiple image">');
                image.attr('src', URL.createObjectURL(files[i]));
                subSingleImgDiv.append(image);
                projectsAllSubImagesDiv.append(subSingleImgDiv);
            }
        });

        $('.cross').on('click', function() {
            const theDiv = $(this).closest('.show_mul_img_div_existing');
            const theId = $(this).attr('data-id');
            Swal.fire({
                title: 'Are you sure you want to delete this image?',
                text: 'This action cannot be undone!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, proceed!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then(function(result) {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('del-product-image') }}",
                        type: 'POST',
                        data: {
                            '_token': '{{ csrf_token() }}',
                            'id': theId
                        },
                        success: function(data) {
                            if (data.status) {
                                theDiv.fadeOut();
                                var notifier = new AWN({
                                    position: 'top-right',
                                });
                                notifier.success(data.message)
                            } else {
                                Swal.fire('Something Went Wrong!', data.message, 'error');
                            }
                        },
                        error: function(error) {
                            Swal.fire('Something Went Wrong!', error, 'error');
                        }
                    });
                }
            });
        });
    </script>
@endsection
