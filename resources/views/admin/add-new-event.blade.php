@extends('admin.layouts.app')
@php
    $res = $isEdit ? 'Modify' : 'Add New';
@endphp
@section('title', $res . ' Event')
@section('pagename', $res . ' Event')
@section('custom-styles')
    <style>
        #form-div {
            width: 80%;
            margin: auto;
            padding: 20px;
        }

        /* #location {
                    width: 100%;
                    border: 1px solid #e2e8f0;
                    font-size: 12px;
                    background: transparent;
                } */
    </style>
@endsection
@section('content')
    <div class="box">
        <form action="{{ route('event-action') }}" method="POST" enctype="multipart/form-data" name="add-edit-event"
            id="event-form">
            @csrf
            <input type="hidden" name="editId" value="{{ $isEdit ? $event->id : 0 }}">
            <div id="form-div">
                <div class="w-full p-4">
                    <label for="site-title" class="ti-form-label">Headline:</label>
                    <div class="relative">
                        <input type="text" class="ti-form-input" name="headline" required
                            value="{{ $event->headline ?? '' }}">
                    </div>
                </div>
                <div class="w-full p-4">
                    <label for="site-title" class="ti-form-label">Event Content:</label>
                    <div class="relative">
                        <textarea name="event_content" class="ti-form-input" id="event-content" rows="9" required>{{ $event->content ?? '' }}</textarea>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="w-full p-4">
                        <label for="site-title" class="ti-form-label">Status:</label>
                        <div class="grid sm:grid-cols-2 gap-2">
                            <label
                                class="flex p-3 w-full bg-white border border-gray-200 rounded-sm text-sm focus:border-primary focus:ring-primary dark:bg-bgdark dark:border-white/10 dark:text-white/70">
                                <input type="radio" name="event_status" class="ti-form-radio" id="hs-radio-in-form"
                                    value="active" required
                                    @if ($isEdit) {{ $event->status == 'active' ? 'checked' : '' }} @else {{ 'checked' }} @endif>
                                <span class="text-sm text-gray-500 ltr:ml-2 rtl:mr-2 dark:text-white/70">Active</span>
                            </label>
                            <label
                                class="flex p-3 w-full bg-white border border-gray-200 rounded-sm text-sm focus:border-primary focus:ring-primary dark:bg-bgdark dark:border-white/10 dark:text-white/70">
                                <input type="radio" name="event_status" class="ti-form-radio"
                                    id="hs-radio-checked-in-form" value="inactive" required
                                    @if ($isEdit) {{ $event->status == 'inactive' ? 'checked' : '' }} @endif>
                                <span class="text-sm text-gray-500 ltr:ml-2 rtl:mr-2 dark:text-white/70">Inactive</span>
                            </label>
                        </div>
                    </div>

                    <div class="w-full p-4">
                        <label for="site-title" class="ti-form-label">Location:</label>
                        <div class="relative">
                            <select name="location" id="location" class="ti-form-select" required>
                                @if ($isEdit)
                                    <option value="COPENHAGEN DENMARK"
                                        {{ $event->location == 'COPENHAGEN DENMARK' ? 'selected' : '' }}>
                                        COPENHAGEN DENMARK</option>
                                    <option value="NEW YORK USA" {{ $event->location == 'NEW YORK USA' ? 'selected' : '' }}>
                                        NEW YORK USA
                                    </option>
                                    <option value="STOCKHOLM SWEDEN"
                                        {{ $event->location == 'STOCKHOLM SWEDEN' ? 'selected' : '' }}>STOCKHOLM SWEDEN
                                    </option>
                                    <option value="TORONTO CANADA"
                                        {{ $event->location == 'TORONTO CANADA' ? 'selected' : '' }}>TORONTO CANADA
                                    </option>
                                @else
                                    <option value="COPENHAGEN DENMARK">COPENHAGEN DENMARK</option>
                                    <option value="NEW YORK USA">NEW YORK USA</option>
                                    <option value="STOCKHOLM SWEDEN">STOCKHOLM SWEDEN</option>
                                    <option value="TORONTO CANADA">TORONTO CANADA</option>
                                @endif
                            </select>
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
                                value="{{ $isEdit ? $event->start_date : '' }}">
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
                                value="{{ $isEdit ? $event->end_date : '' }}">
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

            if (invalidInputs.length > 0) {
                e.preventDefault();
                invalidInputs.addClass('err');
            } else {
                $('input[required]').removeClass('err');
                if (endDateObj >= startDateObj) {
                    $('form[name="add-edit-event"]').submit();
                } else {
                    e.preventDefault();
                }
            }
        });
    </script>
@endsection
