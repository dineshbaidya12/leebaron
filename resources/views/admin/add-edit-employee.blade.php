@extends('admin.layouts.app')
@php
    $res = $isEdit ? 'Modify' : 'Add New';
@endphp
@section('title', $res . ' Employee')
@section('pagename', $res . ' Employee')
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

        .p-show {
            position: absolute;
            top: 13px;
            right: 11px;
            cursor: pointer;
            font-size: 20px;
        }
    </style>
@endsection
@section('content')
    <div class="box">
        <form autocomplete="off" action="{{ route('employee-action') }}" method="POST" enctype="multipart/form-data"
            name="add-edit-employee" id="employee-form">
            @csrf
            <input type="hidden" name="editId" value="{{ $isEdit ? $employee->id : 0 }}">
            <div id="form-div">

                <div class="w-full p-4">
                    <label for="username" class="ti-form-label">User Name:</label>
                    <div class="relative">
                        <input type="text" class="ti-form-input username" name="emp_username" required
                            value="{{ $employee->username ?? '' }}" autocomplete="off" disabled />
                    </div>
                </div>

                <div class="w-full p-4">
                    <label for="email" class="ti-form-label">Email:</label>
                    <div class="relative">
                        <input type="email" class="ti-form-input" name="emp_email" autocomplete="off" required
                            value="{{ $employee->email ?? '' }}">
                    </div>
                </div>

                <div class="w-full p-4">
                    <label for="password" class="ti-form-label">Password:</label>
                    <div class="relative">
                        <input type="password" id="pass" class="ti-form-input" name="emp_password" autocomplete="off"
                            required value="{{ $employee->password ?? '' }}">
                        <i class="ti ti-eye p-show" id="p-show" style="display:none;"></i>
                        <i class="ti ti-eye-closed p-show" id="p-hide"></i>
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
                                    @if ($isEdit) {{ $employee->status == 'active' ? 'checked' : '' }} @else {{ 'checked' }} @endif>
                                <span class="text-sm text-gray-500 ltr:ml-2 rtl:mr-2 dark:text-white/70">Active</span>
                            </label>
                            <label
                                class="flex p-3 w-full bg-white border border-gray-200 rounded-sm text-sm focus:border-primary focus:ring-primary dark:bg-bgdark dark:border-white/10 dark:text-white/70">
                                <input type="radio" name="status" class="ti-form-radio" id="hs-radio-checked-in-form"
                                    value="inactive" required
                                    @if ($isEdit) {{ $employee->status == 'inactive' ? 'checked' : '' }} @endif>
                                <span class="text-sm text-gray-500 ltr:ml-2 rtl:mr-2 dark:text-white/70">Inactive</span>
                            </label>
                        </div>
                    </div>

                    <div class="w-full p-4">
                        <label for="site-title" class="ti-form-label">Showroom:</label>
                        <div class="grid">
                            <select name="showroom" id="showroom" class="w-full ti-form-select">
                                @if ($isEdit)
                                    <option value="USNY" {{ $employee->showroom == 'USNY' ? 'selected' : '' }}>USNY
                                    </option>
                                    <option value="DKCO" {{ $employee->showroom == 'DKCO' ? 'selected' : '' }}>DKCO
                                    </option>
                                    <option value="SWST" {{ $employee->showroom == 'SWST' ? 'selected' : '' }}>SWST
                                    </option>
                                    <option value="HKCH" {{ $employee->showroom == 'HKCH' ? 'selected' : '' }}>HKCH
                                    </option>
                                    <option value="CATO" {{ $employee->showroom == 'CATO' ? 'selected' : '' }}>CATO
                                    </option>
                                @else
                                    <option value="USNY">USNY</option>
                                    <option value="DKCO">DKCO</option>
                                    <option value="SWST">SWST</option>
                                    <option value="HKCH">HKCH</option>
                                    <option value="CATO">CATO</option>
                                @endif
                            </select>
                        </div>
                    </div>


                </div>

                <div class="w-full p-4">
                    <input type="button" id="submit-btn" class="ti-btn ti-btn-primary" value="Submit">
                </div>

            </div>
        </form>
    </div>
@endsection

@section('custom-scripts')
    <script>
        $(document).ready(function() {
            $('#p-show').on('click', function() {
                $('#p-hide').css('display', 'block');
                $('#p-show').css('display', 'none');
                $('#pass').attr('type', 'password');
            });
            $('#p-hide').on('click', function() {
                $('#p-hide').css('display', 'none');
                $('#p-show').css('display', 'block');
                $('#pass').attr('type', 'text');
            });

            getRidOffAutocomplete();


        });

        function getRidOffAutocomplete() {

            var timer = window.setTimeout(function() {
                    $('.username').prop('disabled', false);
                    $('.username').focus();
                    clearTimeout(timer);
                },
                800);
        }

        $('#submit-btn').on('click', function() {
            var invalidInputs = $('input[required]').filter(function() {
                return !$(this).val();
            });

            $('input[required]').removeClass('err');

            if (invalidInputs.length > 0) {
                event.preventDefault();
                invalidInputs.addClass('err');
            } else {
                $('input[required]').removeClass('err');
                $('#employee-form').submit();
            }
        });
    </script>
@endsection
