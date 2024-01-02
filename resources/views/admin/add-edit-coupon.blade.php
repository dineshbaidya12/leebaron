@extends('admin.layouts.app')
@php
    $res = $isEdit ? 'Modify' : 'Add New';
@endphp
@section('title', $res . ' Voucher')
@section('pagename', $res . ' Voucher')
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
    </style>
@endsection
@section('content')
    <div class="box">
        <form action="{{ route('voucher-action') }}" method="POST" enctype="multipart/form-data" name="add-edit-voucher"
            id="voucher-form">
            @csrf
            <input type="hidden" name="editId" value="{{ $isEdit ? $coupon->id : 0 }}">
            <div id="form-div">

                <div class="w-full p-4">
                    <label for="coupon_name" class="ti-form-label">Coupon Name:</label>
                    <div class="relative">
                        <input type="text" class="ti-form-input" name="coupon_name" required
                            value="{{ $coupon->voucher_name ?? '' }}">
                    </div>
                </div>

                <div class="w-full p-4">
                    <label for="coupon_code" class="ti-form-label">Coupon Code:</label>
                    <div class="relative">
                        <input type="text" class="ti-form-input" name="coupon_code" required
                            value="{{ $coupon->voucher_code ?? '' }}">
                    </div>
                </div>

                <div class="w-full p-4">
                    <label for="min_applicable" class="ti-form-label">Min Applicable:</label>
                    <div class="relative">
                        <input type="number" class="ti-form-input" name="min_applicable" required
                            value="{{ $coupon->min_applicable ?? '' }}">
                    </div>
                </div>

                <div class="w-full p-4">
                    <label for="voucher_amount" class="ti-form-label">Voucher Amount:</label>
                    <div class="relative">
                        <input type="number" class="ti-form-input" name="voucher_amount" required
                            value="{{ $coupon->voucher_amount ?? '' }}">
                    </div>
                </div>



                <div class="grid grid-cols-2 gap-4">
                    <div class="w-full p-4">
                        <label for="discount_type" class="ti-form-label">Discount Type:</label>
                        <div class="grid sm:grid-cols-2 gap-2">
                            <label
                                class="flex p-3 w-full bg-white border border-gray-200 rounded-sm text-sm focus:border-primary focus:ring-primary dark:bg-bgdark dark:border-white/10 dark:text-white/70">
                                <input type="radio" name="discount_type" class="ti-form-radio"
                                    id="hs-radio-checked-in-form" value="price" required
                                    @if ($isEdit) {{ $coupon->discount_type == 'price' ? 'checked' : '' }}  @else {{ 'checked' }} @endif>
                                <span class="text-sm text-gray-500 ltr:ml-2 rtl:mr-2 dark:text-white/70">Price</span>
                            </label>
                            <label
                                class="flex p-3 w-full bg-white border border-gray-200 rounded-sm text-sm focus:border-primary focus:ring-primary dark:bg-bgdark dark:border-white/10 dark:text-white/70">
                                <input type="radio" name="discount_type" class="ti-form-radio" id="hs-radio-in-form"
                                    value="percentage" required
                                    @if ($isEdit) {{ $coupon->discount_type == 'percentage' ? 'checked' : '' }} @endif>
                                <span class="text-sm text-gray-500 ltr:ml-2 rtl:mr-2 dark:text-white/70">Percentage</span>
                            </label>
                        </div>
                    </div>

                    <div class="w-full p-4">
                        <label for="site-title" class="ti-form-label">Status:</label>
                        <div class="grid sm:grid-cols-2 gap-2">
                            <label
                                class="flex p-3 w-full bg-white border border-gray-200 rounded-sm text-sm focus:border-primary focus:ring-primary dark:bg-bgdark dark:border-white/10 dark:text-white/70">
                                <input type="radio" name="status" class="ti-form-radio" id="hs-radio-in-form"
                                    value="active" required
                                    @if ($isEdit) {{ $coupon->status == 'active' ? 'checked' : '' }} @else {{ 'checked' }} @endif>
                                <span class="text-sm text-gray-500 ltr:ml-2 rtl:mr-2 dark:text-white/70">Active</span>
                            </label>
                            <label
                                class="flex p-3 w-full bg-white border border-gray-200 rounded-sm text-sm focus:border-primary focus:ring-primary dark:bg-bgdark dark:border-white/10 dark:text-white/70">
                                <input type="radio" name="status" class="ti-form-radio" id="hs-radio-checked-in-form"
                                    value="inactive" required
                                    @if ($isEdit) {{ $coupon->status == 'inactive' ? 'checked' : '' }} @endif>
                                <span class="text-sm text-gray-500 ltr:ml-2 rtl:mr-2 dark:text-white/70">Inactive</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="w-full p-4">
                        <label for="site-title" class="ti-form-label">Start Date:</label>
                        <div class="flex rounded-sm shadow-sm">
                            <div
                                class="px-4 inline-flex items-center min-w-fit ltr:rounded-l-sm rtl:rounded-r-sm border ltr:border-r-0 rtl:border-l-0 border-gray-200 bg-gray-50 dark:bg-black/20 dark:border-white/10">
                                <span class="text-sm text-gray-500 dark:text-white/70">
                                    <i class="ri ri-calendar-line"></i>
                                </span>
                            </div>
                            <input type="date" name="start_date"
                                class="ti-form-input ltr:rounded-l-none rtl:rounded-r-none focus:z-10 flatpickr-input"
                                id="start-date" placeholder="Choose start date" required
                                value="{{ $isEdit ? $coupon->start_date : '' }}">
                        </div>
                    </div>

                    <div class="w-full p-4">
                        <label for="site-title" class="ti-form-label">End Date:</label>
                        <div class="flex rounded-sm shadow-sm">
                            <div
                                class="px-4 inline-flex items-center min-w-fit ltr:rounded-l-sm rtl:rounded-r-sm border ltr:border-r-0 rtl:border-l-0 border-gray-200 bg-gray-50 dark:bg-black/20 dark:border-white/10">
                                <span class="text-sm text-gray-500 dark:text-white/70">
                                    <i class="ri ri-calendar-line"></i>
                                </span>
                            </div>
                            <input type="date" name="end_date"
                                class="ti-form-input ltr:rounded-l-none rtl:rounded-r-none focus:z-10 flatpickr-input"
                                id="end-date" placeholder="Choose end date" required
                                value="{{ $isEdit ? $coupon->end_date : '' }}">
                        </div>
                        <p class="astric" id="date_err"></p>
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
    @if (!$isEdit)
        <script>
            const currentDate = new Date().toISOString().split('T')[0];
            document.getElementById('start-date').value = currentDate;
            document.getElementById('end-date').value = currentDate;
        </script>
    @endif
    <script>
        $('#submit').on('click', function(e) {
            var invalidInputs = $('input[required]').filter(function() {
                return !$(this).val();
            });

            $('input[required]').removeClass('err');

            let startDateObj = new Date(document.getElementById('start-date').value);
            let endDateObj = new Date(document.getElementById('end-date').value);
            let dateErr = true;
            if (endDateObj > startDateObj) {
                $('#date_err').html("");
            } else {
                $('#date_err').html("End Date Should Greater than Start Date");
            }

            if (invalidInputs.length > 0) {
                e.preventDefault();
                invalidInputs.addClass('err');
            } else {
                $('input[required]').removeClass('err');
                if (endDateObj > startDateObj) {
                    $('form[name="add-edit-voucher"]').submit();
                } else {
                    e.preventDefault();
                }
            }
        });
    </script>
@endsection
