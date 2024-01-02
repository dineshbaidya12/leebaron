@extends('admin.layouts.app')
@section('title', 'Bulk Upload CSV')
@section('pagename', 'Bulk Upload CSV')
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
        <form action="{{ route('bulk-upload-csv-action') }}" method="POST" enctype="multipart/form-data"
            name="add-edit-bulk-csv" id="bulk-csv-form">
            @csrf
            <div id="form-div">

                <div class="w-full p-4">
                    <label for="csv_file" class="ti-form-label">Upload CSV File Here:</label>
                    <div class="relative">
                        <input type="file" class="ti-form-input" name="csv_file" id="csv_file" required accept=".csv">
                    </div>
                    <a href="{{ asset('uploads/sample_CSV_file.csv') }}">Download Sample CSV File Here</a>
                </div>

                <div class="w-full p-4">
                    <input type="submit" id="submit" class="ti-btn ti-btn-primary" value="Submit">
                </div>

            </div>
        </form>
    </div>
@endsection

@section('custom-scripts')
    <script>
        $('#submit').on('click', function() {
            if ($('#csv_file').val() == '') {
                $('#csv_file').css('border', '1px solid red');
                return false;
            } else {
                $('#csv_file').css('border', '');
                return true;
            }
        });
    </script>
@endsection
