@extends('admin.layouts.app')
@php
    $res = $isEdit ? 'Modify' : 'Add New';
@endphp
@section('title', $res . ' NYC Calender')
@section('pagename', $res . ' NYC Calender')
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
        <form action="{{ route('calender-action') }}" method="POST" enctype="multipart/form-data" name="add-edit-calender"
            id="calender-form">
            @csrf
            <input type="hidden" name="editId" value="{{ $isEdit ? $calender->id : 0 }}">
            <div id="form-div">

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
                                value="{{ $isEdit ? $calender->start_time : '' }}">
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
                                value="{{ $isEdit ? $calender->end_time : '' }}">
                        </div>
                        <p class="astric" id="date_err"></p>
                    </div>
                </div>

                <div class="w-full p-4">
                    <label for="calender-notes" class="ti-form-label">Calender Notes:</label>
                    <div class="relative notes_desc">
                        <textarea name="calender_notes" class="ti-form-input" id="calender_notes" rows="9" required>{{ $calender->notes ?? '' }}</textarea>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="w-full p-4">
                        <label for="site-title" class="ti-form-label">Status:</label>
                        <div class="grid sm:grid-cols-2 gap-2">
                            <label
                                class="flex p-3 w-full bg-white border border-gray-200 rounded-sm text-sm focus:border-primary focus:ring-primary dark:bg-bgdark dark:border-white/10 dark:text-white/70">
                                <input type="radio" name="calender_status" class="ti-form-radio" id="hs-radio-in-form"
                                    value="active" required
                                    @if ($isEdit) {{ $calender->status == 'active' ? 'checked' : '' }} @else {{ 'checked' }} @endif>
                                <span class="text-sm text-gray-500 ltr:ml-2 rtl:mr-2 dark:text-white/70">Active</span>
                            </label>
                            <label
                                class="flex p-3 w-full bg-white border border-gray-200 rounded-sm text-sm focus:border-primary focus:ring-primary dark:bg-bgdark dark:border-white/10 dark:text-white/70">
                                <input type="radio" name="calender_status" class="ti-form-radio"
                                    id="hs-radio-checked-in-form" value="inactive" required
                                    @if ($isEdit) {{ $calender->status == 'inactive' ? 'checked' : '' }} @endif>
                                <span class="text-sm text-gray-500 ltr:ml-2 rtl:mr-2 dark:text-white/70">Inactive</span>
                            </label>
                        </div>
                    </div>

                    {{-- <div class="w-full p-4">
                        <label for="site-title" class="ti-form-label">Location:</label>
                        <div class="relative">
                            <select name="location" id="location" required>
                                <option value="COPENHAGEN DENMARK">COPENHAGEN DENMARK</option>
                                <option value="NEW YORK USA">NEW YORK USA</option>
                                <option value="STOCKHOLM SWEDEN">STOCKHOLM SWEDEN</option>
                                <option value="TORONTO CANADA">TORONTO CANADA</option>
                            </select>
                        </div>
                    </div> --}}

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
        {{-- <script>
            const currentDate = new Date().toISOString().split('T')[0];

            // Set start date
            document.getElementById('start-date').value = currentDate;

            // Set end date as the next day
            const nextDay = new Date();
            nextDay.setDate(new Date().getDate() + 1);
            const nextDayISOString = nextDay.toISOString().split('T')[0];
            document.getElementById('end-date').value = nextDayISOString;
        </script> --}}
        <script>
            const currentDate = new Date().toISOString().split('T')[0];
            document.getElementById('start-date').value = currentDate;
            document.getElementById('end-date').value = currentDate;
        </script>
    @endif
    <script src="{{ asset('admin/js/ckeditor/ckeditor.js') }}"></script>
    <script>
        $(document).ready(function() {
            //ckeditor
            CKEDITOR.replace('calender_notes');
        });


        $('#submit').on('click', function(e) {
            var invalidInputs = $('input[required]').filter(function() {
                return !$(this).val();
            });

            $('input[required]').removeClass('err');

            if ($('#event-content').val() == '') {
                $('#event-content').css('border', '1px solid red');
            } else {
                $('#event-content').css('border', '');
            }

            let startDateObj = new Date(document.getElementById('start-date').value);
            let endDateObj = new Date(document.getElementById('end-date').value);
            let dateErr = true;
            if (endDateObj >= startDateObj) {
                $('#date_err').html("");
            } else {
                $('#date_err').html("End Date Should Greater or Equal of Start Date");
            }

            var data = CKEDITOR.instances.calender_notes.getData();
            if (data == '') {
                $('.notes_desc').css('border', '1px solid red');
                return false;
            } else {
                $('.notes_desc').css('border', '');
            }

            if (invalidInputs.length > 0) {
                invalidInputs.addClass('err');
                return false;
            } else {
                $('input[required]').removeClass('err');
                if (endDateObj >= startDateObj) {
                    $('form[name="add-edit-calender"]').submit();
                    // console.log(data);
                } else {
                    return false;
                }
            }
        });
    </script>
@endsection
