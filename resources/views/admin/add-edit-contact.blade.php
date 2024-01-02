@extends('admin.layouts.app')
@php
    $res = $isEdit ? 'Modify' : 'Add New';
@endphp
@section('title', $res . ' Contact Address')
@section('pagename', $res . ' Contact Address')
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
        <form action="{{ route('contact-action') }}" method="POST" enctype="multipart/form-data" name="add-edit-contact"
            id="contact">
            @csrf
            <input type="hidden" name="editId" value="{{ $isEdit ? $contact->id : 0 }}">
            <div id="form-div">

                <div class="w-full p-4">
                    <label for="title" class="ti-form-label">Title <span class="astric">*</span>:</label>
                    <div class="relative">
                        <input type="text" class="ti-form-input" id="title" name="title"
                            value="{{ $contact->title ?? '' }}" required>
                    </div>
                </div>

                <div class="w-full p-4">
                    <label for="gmap_address" class="ti-form-label">Address For Google Map <span
                            class="astric">*</span>:</label>
                    <div class="relative">
                        <input type="text" class="ti-form-input" id="gmap_address" name="gmap_address"
                            value="{{ $contact->map_address ?? '' }}" required>
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
                    <label for="address" class="ti-form-label">Address:</label>
                    <div class="relative addr">
                        <textarea name="address" class="ti-form-input" id="address" rows="9" required>{{ $contact->title ?? '' }}</textarea>
                    </div>
                </div>

                <div class="w-full p-4">
                    <label for="popup_content" class="ti-form-label">Pop Up Content:</label>
                    <div class="relative p_content">
                        <textarea name="popup_content" class="ti-form-input" id="popup_content" rows="9" required>{{ $contact->popup_content ?? '' }}</textarea>
                    </div>
                </div>

                <div class="w-full p-4">
                    <label for="popup_details" class="ti-form-label">Popup Details:</label>
                    <div class="relative p_details">
                        <textarea name="popup_details" class="ti-form-input" id="popup_details" rows="9" required>{{ $contact->popup_details ?? '' }}</textarea>
                    </div>
                </div>

                <div class="w-full p-4">
                    <label for="blackbox_content" class="ti-form-label">Black Box Content:</label>
                    <div class="relative bb_content">
                        <textarea name="blackbox_content" class="ti-form-input" id="blackbox_content" rows="9" required>{{ $contact->black_box_content ?? '' }}</textarea>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="w-full p-4">
                        <label for="site-title" class="ti-form-label">Status:</label>
                        <div class="grid sm:grid-cols-2 gap-2">
                            <label
                                class="flex p-3 w-full bg-white border border-gray-200 rounded-sm text-sm focus:border-primary focus:ring-primary dark:bg-bgdark dark:border-white/10 dark:text-white/70">
                                <input type="radio" name="contact_status" class="ti-form-radio" id="hs-radio-in-form"
                                    value="active" required
                                    @if ($isEdit) {{ $contact->status == 'active' ? 'checked' : '' }} @else {{ 'checked' }} @endif>
                                <span class="text-sm text-gray-500 ltr:ml-2 rtl:mr-2 dark:text-white/70">Active</span>
                            </label>
                            <label
                                class="flex p-3 w-full bg-white border border-gray-200 rounded-sm text-sm focus:border-primary focus:ring-primary dark:bg-bgdark dark:border-white/10 dark:text-white/70">
                                <input type="radio" name="contact_status" class="ti-form-radio"
                                    id="hs-radio-checked-in-form" value="inactive" required
                                    @if ($isEdit) {{ $contact->status == 'inactive' ? 'checked' : '' }} @endif>
                                <span class="text-sm text-gray-500 ltr:ml-2 rtl:mr-2 dark:text-white/70">Inactive</span>
                            </label>
                        </div>
                    </div>

                    <div class="w-full p-4">
                        <label for="order_by" class="ti-form-label">Order <span class="astric">*</span>:</label>
                        <div class="relative">
                            <input type="number" name="order_by" id="order_by" class="ti-form-input" required
                                value={{ $contact->orderby ?? '' }}>
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
    <script src="{{ asset('admin/js/ckeditor/ckeditor.js') }}"></script>
    @if ($isEdit)
        @php
            $mainImg = asset('storage/contact/' . $contact->image);
        @endphp
        <script>
            $('#main-img').attr('src', "{{ $mainImg }}");
        </script>
    @endif

    <script>
        $(document).ready(function() {
            //ckeditor
            CKEDITOR.replace('address');
            CKEDITOR.replace('popup_content');
            CKEDITOR.replace('popup_details');
            CKEDITOR.replace('blackbox_content');
        });

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
            var invalidInputs = $('input[required], textarea[required]').filter(function() {
                return !$(this).val();
            });

            $('input[required], textarea[required]').removeClass('err');

            let address = CKEDITOR.instances.address.getData();
            let p_content = CKEDITOR.instances.popup_content.getData();
            let p_details = CKEDITOR.instances.popup_details.getData();
            let bb_content = CKEDITOR.instances.blackbox_content.getData();
            if (address == '') {
                // $('.addr').css
            } else {

            }
            if (p_content == '') {
                return false;
            }
            if (p_details == '') {
                return false;
            }
            if (bb_content == '') {
                return false;
            }


            if (invalidInputs.length > 0) {
                invalidInputs.addClass('err');
                return false;
            } else {
                $('input[required], textarea[required]').removeClass('err');
                let address = CKEDITOR.instances.address.getData();
                let p_content = CKEDITOR.instances.popup_content.getData();
                let p_details = CKEDITOR.instances.popup_details.getData();
                let bb_content = CKEDITOR.instances.blackbox_content.getData();
                if (address == '' || p_content == '' || p_details == '' || bb_content == '') {
                    return false;
                } else {
                    return true;
                }
            }
        });
    </script>
@endsection
