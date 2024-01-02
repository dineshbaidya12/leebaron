@extends('admin.layouts.app')
@section('title', 'Modify Appointment')
@section('pagename', 'Modify Appointment')
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

        .ct_table::before {
            content: ':';
            position: absolute;
            left: -15px;
        }

        .ct_table {
            position: relative;
        }
    </style>
@endsection
@section('content')
    <div class="box">
        <form action="{{ route('modify-appointment-action') }}" method="POST" enctype="multipart/form-data"
            name="modify-appointment" id="modify-appointment">
            @csrf
            <input type="hidden" value="{{ $appointment->id ?? '' }}" name="app_id">
            <div id="form-div">
                <div class="w-full p-4">
                    <label for="app_date" class="ti-form-label">Appointment Date:</label>
                    <div class="relative">
                        <input type="date" class="ti-form-input" name="app_date" id="app_date"
                            value="{{ $appointment->appointment_date ?? '' }}" required>
                        <p id="err_date" style="display:none; color:red;">Appointment date should not be empty or less than
                            today.</p>
                    </div>
                </div>

                <div class="w-full p-4">
                    <h2 style="font-size:18px;">Appoinemnt Details:</h2>
                    <div class="w-full mt-5 p-5">
                        <table class="w-full">
                            <tbody>
                                <tr>
                                    <td class="align-top" style="width:15%;">Name</td>
                                    <td class="w-1/4 align-top ct_table">
                                        @if ($appointment->name)
                                            {{ $appointment->name == '' ? '--' : $appointment->name }}
                                        @else
                                            {{ '--' }}
                                        @endif
                                    </td>
                                    <td class="align-top" style="width:18%;">Street Address</td>
                                    <td class="w-5/12 align-top ct_table">
                                        @if ($appointment->address)
                                            {{ $appointment->address == '' ? '--' : $appointment->address }}
                                        @else
                                            {{ '--' }}
                                        @endif
                                    </td>
                                </tr>
                                <tr style="height:20px;"></tr>
                                <tr>
                                    <td class="align-top" style="width:15%;">City</td>
                                    <td class="w-1/4 align-top ct_table">
                                        @if ($appointment->city)
                                            {{ $appointment->city == '' ? '--' : $appointment->city }}
                                        @else
                                            {{ '--' }}
                                        @endif
                                    </td>
                                    <td class="align-top" style="width:18%;">Address 2</td>
                                    <td class="w-5/12 align-top ct_table">
                                        @if ($appointment->address2)
                                            {{ $appointment->address2 == '' ? '--' : $appointment->address2 }}
                                        @else
                                            {{ '--' }}
                                        @endif
                                    </td>
                                </tr>
                                <tr style="height:20px;"></tr>
                                <tr>
                                    <td class="align-top" style="width:15%;">Phone</td>
                                    <td class="w-1/4 align-top ct_table">
                                        @if ($appointment->phone)
                                            {{ $appointment->phone == '' ? '--' : $appointment->phone }}
                                        @else
                                            {{ '--' }}
                                        @endif
                                    </td>
                                    <td class="align-top" style="width:18%;">Email</td>
                                    <td class="w-5/12 align-top ct_table">
                                        @if ($appointment->email)
                                            {{ $appointment->email == '' ? '--' : $appointment->email }}
                                        @else
                                            {{ '--' }}
                                        @endif
                                    </td>
                                </tr>
                                <tr style="height:20px;"></tr>
                                <tr>
                                    <td class="align-top" style="width:15%;">Country</td>
                                    <td class="w-1/4 align-top ct_table">
                                        @if ($appointment->country_name)
                                            {{ $appointment->country_name == '' ? '--' : $appointment->country_name }}
                                        @else
                                            {{ '--' }}
                                        @endif
                                    </td>
                                    <td class="align-top" style="width:18%;">State</td>
                                    <td class="w-5/12 align-top ct_table">
                                        @if ($appointment->state)
                                            {{ $appointment->state == '' ? '--' : $appointment->state }}
                                        @else
                                            {{ '--' }}
                                        @endif
                                    </td>
                                </tr>
                                <tr style="height:20px;"></tr>
                                <tr>
                                    <td class="align-top" style="width:15%;">Post Code</td>
                                    <td class="w-1/4 align-top ct_table">
                                        @if ($appointment->postcode)
                                            {{ $appointment->address2 == '' ? '--' : $appointment->postcode }}
                                        @else
                                            {{ '--' }}
                                        @endif
                                    </td>
                                    <td class="align-top" style="width:18%;">Request Date</td>
                                    <td class="w-5/12 align-top ct_table">
                                        @if ($appointment->request_date)
                                            {{ $appointment->request_date == '' ? '--' : $appointment->request_date }}
                                        @else
                                            {{ '--' }}
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
    <script>
        $('#app_date').on('change', function() {
            var enteredDate = new Date($('#app_date').val());
            var today = new Date();

            if (enteredDate < today) {
                $('#app_date').css('border', '1px solid red');
                $('#err_date').css('display', 'block');
            } else {
                $('#app_date').css('border', '');
                $('#err_date').css('display', 'none');
            }
        });

        $('#modify-appointment').on('submit', function() {
            var enteredDate = new Date($('#app_date').val());
            var today = new Date();

            if (enteredDate < today) {
                $('#app_date').css('border', '1px solid red');
                return false;
            }
        });
    </script>
@endsection
