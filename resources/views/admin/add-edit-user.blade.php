@extends('admin.layouts.app')
@php
    $res = $isEdit ? 'Modify' : 'Add New';
@endphp
@section('title', $res . ' User')
@section('pagename', $res . ' User')
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

        .top-head {
            background: #353535;
            color: white;
        }

        .top-head {
            text-transform: uppercase;
        }

        .password-div i {
            position: absolute;
            top: 9px;
            right: 12px;
            font-size: 25px;
            cursor: pointer;
        }
    </style>
@endsection
@section('content')
    <div class="box">
        <form action="{{ route('user-action') }}" method="POST" enctype="multipart/form-data" name="add-edit-shirt"
            id="shirt">
            @csrf
            <input type="hidden" name="editId" value="{{ $isEdit ? $user->user_id : 0 }}">
            <div id="form-div">

                <div class="w-full top-head p-2">
                    <p>Login Information</p>
                </div>

                <div class="w-full p-4">
                    <label for="email" class="ti-form-label">Email Address :<span class="astric">*</span></label>
                    <div class="relative">
                        <input type="email" class="ti-form-input" name="email" id="email"
                            value="{{ $user->email ?? '' }}" required>
                    </div>
                </div>

                <div class="w-full p-4 password-div">
                    <label for="password" class="ti-form-label">Password :<span class="astric">*</span></label>
                    <div class="relative">
                        <input type="password" class="ti-form-input" name="password" id="password"
                            value="{{ $user->plain_pass ?? '' }}" required>
                        <i class="ti ti-eye" id="open-eye" style="display: none;"></i>
                        <i class="ti ti-eye-closed" id="close-eye"></i>
                    </div>
                </div>

                <div class="w-full p-4 password-div">
                    <label for="confirm_pass" class="ti-form-label">Confirm Password :<span class="astric">*</span><span
                            class="astric" id="err_conform"></span></label>
                    <div class="relative">
                        <input type="password" class="ti-form-input" name="confirm_pass" id="confirm_pass"
                            value="{{ $user->plain_pass ?? '' }}" required>
                        <i class="ti ti-eye" id="open-eye-confirm" style="display: none;"></i>
                        <i class="ti ti-eye-closed" id="close-eye-confirm"></i>
                    </div>
                </div>

                <div class="w-full p-4">
                    <div class="relative">
                        <input type="checkbox" class="ti-form-checkbox" name="newsletter" id="newsletter"
                            @if ($isEdit) {{ $isNewsLetter ? 'checked' : '' }} @else {{ 'checked' }} @endif>
                        <label for="newsletter" class="ti-form-label inline-block">If you do not wish to receive our
                            newsletter please un-tick this box</label>
                    </div>
                </div>

                <div class="w-full top-head p-2">
                    <p>Address Information</p>
                </div>

                <div class="w-full p-4">
                    <label for="fname" class="ti-form-label">First Name :<span class="astric">*</span></label>
                    <div class="relative">
                        <input type="text" class="ti-form-input" name="fname" id="fname"
                            value="{{ $user->first_name ?? '' }}" required>
                    </div>
                </div>

                <div class="w-full p-4">
                    <label for="lname" class="ti-form-label">Last Name :<span class="astric">*</span></label>
                    <div class="relative">
                        <input type="text" class="ti-form-input" name="lname" id="lname"
                            value="{{ $user->last_name ?? '' }}" required>
                    </div>
                </div>

                <div class="w-full p-4">
                    <label for="address1" class="ti-form-label">Address 1 :<span class="astric">*</span></label>
                    <div class="relative">
                        <textarea name="address1" id="address1" class="w-100 resize-none ti-form-input" style="height:125px; width:100%;"
                            required>{{ $user->address1 ?? '' }}</textarea>
                    </div>
                </div>

                <div class="w-full p-4">
                    <label for="address2" class="ti-form-label">Address 2:</label>
                    <div class="relative">
                        <input type="text" class="ti-form-input" name="address2" id="address2"
                            value="{{ $user->address2 ?? '' }}">
                    </div>
                </div>

                <div class="w-full p-4">
                    <label for="city" class="ti-form-label">City :<span class="astric">*</span></label>
                    <div class="relative">
                        <input type="text" class="ti-form-input" name="city" id="city"
                            value="{{ $user->city ?? '' }}" required>
                    </div>
                </div>

                <div class="w-full p-4">
                    <label for="country" class="ti-form-label">Select Country :<span class="astric">*</span></label>
                    <div class="relative">
                        <select name="country" id="country" class="ti-form-select" required>
                            @if ($isEdit)
                                @foreach ($country as $c)
                                    <option value="{{ $c->id }}" {{ $c->id == $user->country ? 'selected' : '' }}>
                                        {{ $c->country }}</option>
                                @endforeach
                            @else
                                @foreach ($country as $c)
                                    <option value="{{ $c->id }}">{{ $c->country }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>

                <div class="w-full p-4">
                    <label for="state" class="ti-form-label">State :<span class="astric">*</span></label>
                    <div class="relative">
                        <input type="text" class="ti-form-input" name="state" id="state"
                            value="{{ $user->state ?? '' }}" required>
                    </div>
                </div>

                <div class="w-full p-4">
                    <label for="postcode" class="ti-form-label">Post Code :<span class="astric">*</span></label>
                    <div class="relative">
                        <input type="text" class="ti-form-input" name="postcode" id="postcode"
                            value="{{ $user->postcode ?? '' }}" required>
                    </div>
                </div>

                <div class="w-full p-4">
                    <label for="phone" class="ti-form-label">Phone Number :<span class="astric">*</span></label>
                    <div class="relative">
                        <input type="number" class="ti-form-input" name="phone" id="phone"
                            value="{{ $user->phone ?? '' }}" required>
                    </div>
                </div>

                <div class="w-full p-4">
                    <label for="fax" class="ti-form-label">Fax Number:</label>
                    <div class="relative">
                        <input type="number" class="ti-form-input" name="fax" id="fax"
                            value="{{ $user->fax ?? '' }}">
                    </div>
                </div>

                <div class="w-full p-4">
                    <label for="email" class="ti-form-label">Showroom :<span class="astric">*</span></label>
                    <div class="relative">
                        <select name="showroom" id="showroom" class="ti-form-select">
                            <option value="USNY"
                                @if ($isEdit) {{ $user->showroom == 'USNY' ? 'selected' : '' }} @endif>
                                USNY</option>
                            <option value="DKCO"
                                @if ($isEdit) {{ $user->showroom == 'DKCO' ? 'selected' : '' }} @endif>
                                DKCO</option>
                            <option value="SWST"
                                @if ($isEdit) {{ $user->showroom == 'SWST' ? 'selected' : '' }} @endif>
                                SWST</option>
                            <option value="HKCH"
                                @if ($isEdit) {{ $user->showroom == 'HKCH' ? 'selected' : '' }} @endif>
                                HKCH</option>
                            <option value="CATO"
                                @if ($isEdit) {{ $user->showroom == 'CATO' ? 'selected' : '' }} @endif>
                                CATO</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <div class="w-full p-4">
                        <label for="status" class="ti-form-label">Status :<span class="astric">*</span></label>
                        <div class="grid sm:grid-cols-3 gap-2">
                            <label
                                class="flex p-3 w-full bg-white border border-gray-200 rounded-sm text-sm focus:border-primary focus:ring-primary dark:bg-bgdark dark:border-white/10 dark:text-white/70">
                                <input type="radio" name="status" class="ti-form-radio" id="hs-radio-in-form"
                                    value="active" required
                                    @if ($isEdit) {{ $user->status == 'active' ? 'checked' : '' }} @else {{ 'checked' }} @endif>
                                <span class="text-sm text-gray-500 ltr:ml-2 rtl:mr-2 dark:text-white/70">Active</span>
                            </label>
                            <label
                                class="flex p-3 w-full bg-white border border-gray-200 rounded-sm text-sm focus:border-primary focus:ring-primary dark:bg-bgdark dark:border-white/10 dark:text-white/70">
                                <input type="radio" name="status" class="ti-form-radio" id="hs-radio-checked-in-form"
                                    value="inactive" required
                                    @if ($isEdit) {{ $user->status == 'inactive' ? 'checked' : '' }} @endif>
                                <span class="text-sm text-gray-500 ltr:ml-2 rtl:mr-2 dark:text-white/70">Inactive</span>
                            </label>
                            <label
                                class="flex p-3 w-full bg-white border border-gray-200 rounded-sm text-sm focus:border-primary focus:ring-primary dark:bg-bgdark dark:border-white/10 dark:text-white/70">
                                <input type="radio" name="status" class="ti-form-radio" id="hs-radio-in-form"
                                    value="waiting" required
                                    @if ($isEdit) {{ $user->status == 'waiting' ? 'checked' : '' }} @endif>
                                <span class="text-sm text-gray-500 ltr:ml-2 rtl:mr-2 dark:text-white/70">Waiting</span>
                            </label>
                        </div>
                    </div>

                    <div class="w-full p-4">
                        <label for="customerno" class="ti-form-label">Customer Number:</label>
                        <input type="text" class="ti-form-input" name="customerno" id="customerno"
                            value="{{ $user->customer_no ?? '' }}" style="text-transform: uppercase;">
                        <span class="astric" id="err_cnum"></span>
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
    <script>
        //password

        $('#close-eye-confirm').on('click', function() {
            $('#confirm_pass').attr('type', 'text');
            $('#close-eye-confirm').css('display', 'none');
            $('#open-eye-confirm').css('display', 'block');
        });

        $('#open-eye-confirm').on('click', function() {
            $('#confirm_pass').attr('type', 'password');
            $('#close-eye-confirm').css('display', 'block');
            $('#open-eye-confirm').css('display', 'none');
        });

        $('#close-eye').on('click', function() {
            $('#password').attr('type', 'text');
            $('#close-eye').css('display', 'none');
            $('#open-eye').css('display', 'block');
        });

        $('#open-eye').on('click', function() {
            $('#password').attr('type', 'password');
            $('#close-eye').css('display', 'block');
            $('#open-eye').css('display', 'none');
        });

        $('#confirm_pass').on('keyup', function() {
            if ($('#confirm_pass').val() == $('#password').val()) {
                $('#confirm_pass').css('border', '');
                $('#err_conform').text('');
                $('#submit').css('pointer-events', 'auto');
                $('#submit').css('opacity', '1');
            } else {
                $('#confirm_pass').css('border', '1px solid red');
                $('#err_conform').text('Password and confirm password not matched.');
                $('#submit').css('pointer-events', 'none');
                $('#submit').css('opacity', '.5');
            }
        });

        $('#password').on('keyup', function() {
            if ($('#confirm_pass').val() !== $('#password').val() && $('#confirm_pass').val() !== '') {
                $('#confirm_pass').css('border', '1px solid red');
                $('#err_conform').text('Password and confirm password not matched.');
                $('#submit').css('pointer-events', 'none');
                $('#submit').css('opacity', '.5');
            } else {
                $('#confirm_pass').css('border', '');
                $('#err_conform').text('');
                $('#submit').css('pointer-events', 'auto');
                $('#submit').css('opacity', '1');
            }
        });

        //customer number

        const customerNumbers = {!! $cusNosJson !!};

        $('#customerno').on('keyup', function() {
            const enteredValue = $(this).val().trim().toLowerCase();
            const isInArray = customerNumbers.some(obj => obj.customer_no.toLowerCase() === enteredValue);
            if (isInArray && enteredValue !== '') {
                $('#err_cnum').text("This customer number already in database");
                $('#submit').css('pointer-events', 'none');
                $('#submit').css('opacity', '.5');
            } else {
                $('#err_cnum').text("");
                $('#submit').css('pointer-events', 'auto');
                $('#submit').css('opacity', '1');
            }
        });

        //submit the form 

        $('#submit').on('click', function(e) {
            var invalidInputs = $('input[required], select[required], textarea[required]').filter(function() {
                return !$(this).val();
            });

            $('input[required], select[required], textarea[required]').removeClass('err');

            if (invalidInputs.length > 0) {
                invalidInputs.addClass('err');
                return false;
            } else {
                if ($('#password').val() !== $('#confirm_pass').val()) {
                    $('#confirm_pass').css('border', '1px solid red');
                    return false;
                } else {
                    $('input[required], select[required], textarea[required]').removeClass('err');
                    return true;
                }
            }
        });

        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }
    </script>
@endsection
