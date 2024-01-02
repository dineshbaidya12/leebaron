@extends('admin.layouts.app')
@section('title', 'Export Users')
@section('pagename', 'Export Users')
@section('custom-styles')
    <style>
        #form-div {
            width: 80%;
            margin: auto;
            padding: 20px;
        }

        .top-head {
            background: #353535;
            color: white;
        }

        #download-all {
            cursor: pointer;
            /* background: #353535; */
            color: white;
        }

        #download-all:hover {
            cursor: pointer;
            /* background: #535353; */
            color: white;
        }
    </style>
@endsection
@section('content')
    <div class="box">
        <form action="{{ route('export-user-action') }}" name="export-form" id="export-form" method="POST">
            @csrf
            <div id="form-div">

                <div class="w-full top-head p-2">
                    <p>Pick the date to get user who join between that date</p>
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
                                id="start-date" placeholder="Choose start date" value="">
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
                                id="end-date" placeholder="Choose end date" value="">
                        </div>
                        <p class="astric" id="date_err"></p>
                    </div>
                </div>

                <div class="w-full p-4">
                    <input id="submit" type="submit" class="ti-btn ti-btn-primary" value="Submit">
                    <button id="download-all" type="submit" class="ti-btn ti-btn-primary">Download All record</button>
                </div>
            </div>
        </form>
    </div>



@endsection
@section('custom-scripts')
    <script>
        $('#download-all').on('click', function() {
            let createInput = $('<input>');
            createInput.attr('name', 'download_all');
            createInput.attr('type', 'hidden');
            createInput.attr('id', 'download_all');
            createInput.val('download_all');
            $('#export-form').append(createInput);
            submitForm();
        });

        $('#submit').on('click', function() {
            $('#download_all').remove();
            submitForm();
        });

        function submitForm() {
            $('#export-form').submit();
        }

        $('#export-form').on('submit', function(e) {
            if ($('#download_all').val() != 'download_all') {
                if ($('#start-date').val() == '' || $('#end-date').val() == '') {
                    e.preventDefault();
                }
                let startDateObj = new Date(document.getElementById('start-date').value);
                let endDateObj = new Date(document.getElementById('end-date').value);
                let dateErr = true;
                if (endDateObj >= startDateObj) {
                    $('#date_err').html("");
                } else {
                    if ($('#start-date').val() !== '' || $('#end-date').val() !== '') {
                        $('#date_err').html("End Date Should Greater or Equal of Start Date");
                    }
                    e.preventDefault();
                }
                if ($('#start-date').val() == '') {
                    $('#start-date').css('border', '1px solid red');
                } else {
                    $('#start-date').css('border', '');
                }
                if ($('#end-date').val() == '') {
                    $('#end-date').css('border', '1px solid red');
                } else {
                    $('#end-date').css('border', '');
                }

            }
        });
    </script>
@endsection
