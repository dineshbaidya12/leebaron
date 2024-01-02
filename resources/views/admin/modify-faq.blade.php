@extends('admin.layouts.app')
@section('title', 'Modify Faq')
@section('pagename', 'Modify Faq')
@section('custom-styles')
    <style>
        #form-div {
            width: 80%;
            margin: auto;
            padding: 20px;
        }
    </style>
@endsection

@section('content')
    <div class="box">
        <form action="{{ route('modify-faq-action', $faq->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div id="form-div">
                <div class="w-full p-4">
                    <label for="site-title" class="ti-form-label">Question:</label>
                    <div class="relative">
                        <textarea name="question" class="ti-form-input" id="question" rows="3" required>{{ $faq->question ?? '' }}</textarea>
                    </div>
                </div>
                <div class="w-full p-4">
                    <label for="site-title" class="ti-form-label">Answer:</label>
                    <div class="relative">
                        <textarea name="answer" class="ti-form-input" id="answer" rows="9" required>{{ $faq->answer ?? '' }}</textarea>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="w-full p-4">
                        <label for="site-title" class="ti-form-label">Status:</label>
                        <div class="grid sm:grid-cols-2 gap-2">
                            <label
                                class="flex p-3 w-full bg-white border border-gray-200 rounded-sm text-sm focus:border-primary focus:ring-primary dark:bg-bgdark dark:border-white/10 dark:text-white/70">
                                <input type="radio" name="faq_status" class="ti-form-radio" id="hs-radio-in-form"
                                    value="active" required {{ $faq->status == 'active' ? 'checked' : '' }}>
                                <span class="text-sm text-gray-500 ltr:ml-2 rtl:mr-2 dark:text-white/70">Active</span>
                            </label>
                            <label
                                class="flex p-3 w-full bg-white border border-gray-200 rounded-sm text-sm focus:border-primary focus:ring-primary dark:bg-bgdark dark:border-white/10 dark:text-white/70">
                                <input type="radio" name="faq_status" class="ti-form-radio" id="hs-radio-checked-in-form"
                                    value="inactive" required {{ $faq->status == 'inactive' ? 'checked' : '' }}>
                                <span class="text-sm text-gray-500 ltr:ml-2 rtl:mr-2 dark:text-white/70">Inactive</span>
                            </label>
                        </div>
                    </div>

                    <div class="w-full p-4">
                        <label for="site-title" class="ti-form-label">Order:</label>
                        <div class="relative">
                            <input type="number" class="ti-form-input" name="order" id="order"
                                value="{{ $faq->order ?? 0 }}">
                        </div>
                    </div>
                </div>




                <div class="w-full p-4">
                    <input type="submit" class="ti-btn ti-btn-primary" value="Submit">
                </div>

            </div>
        </form>
    </div>
@endsection
