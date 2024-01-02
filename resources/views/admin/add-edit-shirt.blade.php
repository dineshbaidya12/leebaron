@extends('admin.layouts.app')
@php
    $res = $isEdit ? 'Modify' : 'Add New';
@endphp
@section('title', $res . ' Online Shirt')
@section('pagename', $res . ' Online Shirt')
@section('custom-styles')
    <style>
        #form-div {
            width: 80%;
            margin: auto;
            padding: 20px;
        }

        .admin-site-logo {
            background: #f2f6f9;
            padding: 10px;
        }

        .admin-site-logo img {
            object-fit: cover;
            width: 100%;
            height: 100%;
            max-height: 135px;
        }

        .left-div {
            width: 70%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .right-div {
            width: 20%;
            margin-left: auto;
        }
    </style>
@endsection
@section('content')
    <div class="box">
        <form action="{{ route('shirt-action') }}" method="POST" enctype="multipart/form-data" name="add-edit-shirt"
            id="shirt">
            @csrf
            <input type="hidden" name="editId" value="{{ $isEdit ? $shirt->id : 0 }}">
            <div id="form-div">

                <div class="w-full p-4">
                    <label for="category" class="ti-form-label">Category <span class="astric">*</span>:</label>
                    <div class="relative">
                        <select name="category" id="category" class="w-full ti-form-input" required>
                            <option value="">-- Select a category --</option>
                            @if ($isEdit)
                                <option value="Fabrics" {{ $shirt->category == 'Fabrics' ? 'selected' : '' }}>Fabrics
                                </option>
                                <option value="Fit" {{ $shirt->category == 'Fit' ? 'selected' : '' }}>Fit</option>
                                <option value="Collars" {{ $shirt->category == 'Collars' ? 'selected' : '' }}>Collars
                                </option>
                                <option value="Sleeves" {{ $shirt->category == 'Sleeves' ? 'selected' : '' }}>Sleeves
                                </option>
                                <option value="Cuffs" {{ $shirt->category == 'Cuffs' ? 'selected' : '' }}>Cuffs</option>
                                <option value="Front" {{ $shirt->category == 'Front' ? 'selected' : '' }}>Front</option>
                                <option value="Pocket" {{ $shirt->category == 'Pocket' ? 'selected' : '' }}>Pocket</option>
                                <option value="Bottom Cut" {{ $shirt->category == 'Bottom Cut' ? 'selected' : '' }}>Bottom
                                    Cut
                                </option>
                                <option value="Back Details" {{ $shirt->category == 'Back Details' ? 'selected' : '' }}>
                                    Back
                                    Details</option>
                            @else
                                <option value="Fabrics">Fabrics</option>
                                <option value="Fit">Fit</option>
                                <option value="Collars">Collars</option>
                                <option value="Sleeves">Sleeves</option>
                                <option value="Cuffs">Cuffs</option>
                                <option value="Front">Front</option>
                                <option value="Pocket">Pocket</option>
                                <option value="Bottom Cut">Bottom Cut</option>
                                <option value="Back Details">Back Details</option>
                            @endif
                        </select>
                    </div>
                </div>

                <div class="w-full p-4">
                    <label for="product-name" class="ti-form-label">Product Name <span class="astric">*</span>:</label>
                    <div class="relative">
                        <input type="text" class="ti-form-input" id="product-name" name="product_name"
                            value="{{ $shirt->product_name ?? '' }}" required>
                    </div>
                </div>

                <div class="w-full p-4">
                    <label for="site-title" class="ti-form-label">Main Image
                        {!! $isEdit ? '' : '<span class="astric">*</span>' !!}:</label>
                    <div class="flex">
                        <div class="left-div">
                            <input type="file" name="main_img" id="main_img"
                                class="block w-full border border-gray-200 focus:shadow-sm dark:focus:shadow-white/10 rounded-sm text-sm focus:z-10 focus:outline-0 focus:border-gray-200 dark:focus:border-white/10 dark:border-white/10 dark:text-white/70 file:bg-transparent file:border-0 file:bg-gray-100 ltr:file:mr-4 rtl:file:ml-4 file:py-3 file:px-4 dark:file:bg-black/20 dark:file:text-white/70"
                                onchange="changeImg(this, 'main_img');" accept=".png, .jpg, .jpeg"
                                {{ $isEdit ? '' : 'required' }} />
                        </div>

                        <div class="right-div">
                            <div class="admin-site-logo flex justify-center items-center">
                                <img src="{{ asset('admin/images/leebaron/default-image2.png') }}" alt="logo"
                                    id="main-img" class="main-logo object-cover cursor-pointer" style="width:80px;" />
                            </div>
                        </div>

                    </div>
                </div>

                <div class="w-full p-4">
                    <label for="site-title" class="ti-form-label">Thumbnail
                        {!! $isEdit ? '' : '<span class="astric">*</span>' !!}:</label>
                    <div class="flex">
                        <div class="left-div">
                            <input type="file" name="thubnail" id="file-input"
                                class="block w-full border border-gray-200 focus:shadow-sm dark:focus:shadow-white/10 rounded-sm text-sm focus:z-10 focus:outline-0 focus:border-gray-200 dark:focus:border-white/10 dark:border-white/10 dark:text-white/70 file:bg-transparent file:border-0 file:bg-gray-100 ltr:file:mr-4 rtl:file:ml-4 file:py-3 file:px-4 dark:file:bg-black/20 dark:file:text-white/70"
                                onchange="changeImg(this, 'thumb');" accept=".png, .jpg, .jpeg"
                                {{ $isEdit ? '' : 'required' }} />
                        </div>

                        <div class="right-div">
                            <div class="admin-site-logo flex justify-center items-center">
                                <img src="{{ asset('admin/images/leebaron/default-image2.png') }}" alt="logo"
                                    id="thubnail-logo" class="main-logo object-cover cursor-pointer" style="width:80px;" />
                            </div>
                        </div>

                    </div>
                </div>


                <div class="grid grid-cols-2 gap-4">
                    <div class="w-full p-4">
                        <label for="site-title" class="ti-form-label">Status:</label>
                        <div class="grid sm:grid-cols-2 gap-2">
                            <label
                                class="flex p-3 w-full bg-white border border-gray-200 rounded-sm text-sm focus:border-primary focus:ring-primary dark:bg-bgdark dark:border-white/10 dark:text-white/70">
                                <input type="radio" name="shirt_status" class="ti-form-radio" id="hs-radio-in-form"
                                    value="active" required
                                    @if ($isEdit) {{ $shirt->status == 'active' ? 'checked' : '' }} @else {{ 'checked' }} @endif>
                                <span class="text-sm text-gray-500 ltr:ml-2 rtl:mr-2 dark:text-white/70">Active</span>
                            </label>
                            <label
                                class="flex p-3 w-full bg-white border border-gray-200 rounded-sm text-sm focus:border-primary focus:ring-primary dark:bg-bgdark dark:border-white/10 dark:text-white/70">
                                <input type="radio" name="shirt_status" class="ti-form-radio"
                                    id="hs-radio-checked-in-form" value="inactive" required
                                    @if ($isEdit) {{ $shirt->status == 'inactive' ? 'checked' : '' }} @endif>
                                <span class="text-sm text-gray-500 ltr:ml-2 rtl:mr-2 dark:text-white/70">Inactive</span>
                            </label>
                        </div>
                    </div>

                    <div class="w-full p-4">
                        <label for="order_by" class="ti-form-label">Order <span class="astric">*</span>:</label>
                        <div class="relative">
                            <input type="number" name="order_by" id="order_by" class="ti-form-input" required
                                value={{ $shirt->orderby ?? '' }}>
                        </div>
                    </div>

                </div>

                <div class="w-full p-4">
                    <input id="submit" type="submit" class="ti-btn ti-btn-primary" value="Submit">
                </div>

            </div>
        </form>
    </div>



@endsection
@section('custom-scripts')
    @if ($isEdit)
        @php
            $mainImg = asset('storage/shirt/' . $shirt->image);
            $thumbImg = asset('storage/shirt/thumb/' . $shirt->thumb);
        @endphp
        <script>
            $('#main-img').attr('src', "{{ $mainImg }}");
            $('#thubnail-logo').attr('src', "{{ $thumbImg }}");
        </script>
    @endif

    <script>
        function changeImg(input, type) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (type == "main_img") {
                        $('#main-img').attr('src', e.target.result);
                        $('#main-img').css('width', '100%');
                    } else {
                        $('#thubnail-logo').attr('src', e.target.result);
                        $('#thubnail-logo').css('width', '100%');
                    }
                };
                reader.readAsDataURL(input.files[0]);
            }
        }


        $('#thubnail-logo').on('click', function() {
            $('#file-input').click();
        });
        $('#main-img').on('click', function() {
            $('#main_img').click();
        });

        $('#submit').on('click', function(e) {
            var invalidInputs = $('input[required], select[required]').filter(function() {
                return !$(this).val();
            });

            $('input[required], select[required]').removeClass('err');

            // let isMainImg;
            // if ($('#main_img').val() == '') {
            //     $('#main_img').css('border', '1px solid red');
            //     isMainImg = false;
            // } else {
            //     $('#main_img').css('border', '');
            //     isMainImg = true;
            // }

            if (invalidInputs.length > 0) {
                invalidInputs.addClass('err');
                return false;
            } else {
                $('input[required], select[required]').removeClass('err');

            }
        });
    </script>
@endsection
