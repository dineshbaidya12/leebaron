@extends('admin.layouts.app')
@section('title', 'Send Newsletter Mail')
@section('pagename', 'Send Newsletter Mail')
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

        .profile-picture {
            height: 150px;
            width: 150px;
            margin: auto;
            border-radius: 50%;
            background: transparent;
            position: relative;
            /* overflow: hidden; */
        }

        .profile-picture img {
            height: 100%;
            width: 100%;
            object-fit: cover;
            border-radius: 50%;
            border: 1px solid #c8c8c8
        }

        .edit-icon {
            position: absolute;
            top: -10px;
            font-size: 26px;
            right: -8px;
            cursor: pointer;
            padding: 5px;
        }

        .show_mul_img_div,
        .show_mul_img_div_existing {
            display: inline-block;
            height: 100px;
            width: 100px;
            object-fit: cover;
            vertical-align: top;
            border: 1px solid grey;
            margin: 5px;
        }

        .show_mul_img_div img,
        .show_mul_img_div_existing img {
            height: 100%;
            width: 100%;
            object-fit: cover;
        }

        .cross {
            position: absolute;
            top: -12px;
            right: -12px;
            color: red;
            background: #eee;
            padding: 5px;
            border: 1px solid gray;
            border-radius: 50%;
            font-size: 18px;
            cursor: pointer;
            transition: .3s all ease-in;
        }

        .cross:hover {
            color: white;
            background: red;
            transform: scale(1.2);
        }

        .err {
            border: 1px solid red !important;
        }
    </style>
@endsection
@section('content')
    <div class="box">
        <form action="{{ route('send-newsletter-email-action') }}" method="POST" enctype="multipart/form-data"
            name="email_form" id="common-form">
            @csrf

            <div id="form-div">

                <div class="w-full p-4">
                    <label for="reciever_type" class="ti-form-label">Select Reciever: <span class="astric">*</span></label>
                    <select name="reciever_type" id="reciever_type" class="ti-form-select" onchange="reciverType($(this))"
                        required>
                        <option value="a" selected>All Newsletter Subscriber</option>
                        <option value="r">Registered User - Subscriber</option>
                        <option value="ra">Registered User - All</option>
                        <option value="d">Indivisual Person</option>
                    </select>
                </div>

                <div class="w-full p-4" id="email-div">
                    <label for="email" class="ti-form-label">Email: <span class="astric">*</span></label>
                    <div class="relative">
                        <input type="email" class="ti-form-input" name="email" id="email">
                    </div>
                </div>

                <div id="default-desc-div">
                    <div class="w-full p-4">
                        <label for="subject" class="ti-form-label">Subject: <span class="astric">*</span></label>
                        <div class="relative">
                            <input type="text" class="ti-form-input" name="subject" id="subject" required>
                        </div>
                    </div>

                    <div class="w-full p-4">
                        <label for="mail_content" class="ti-form-label">Mail Content: <span class="astric">*</span></label>
                        <div class="relative mail-div-ck">
                            <textarea name="mail_content" class="ti-form-input" id="mail_content" rows="5" required></textarea>
                        </div>
                    </div>
                </div>


                <div class="w-full p-4">
                    {{-- <input type="button" id="submit-btn" class="ti-btn ti-btn-primary" value="Submit"> --}}
                    <button type="button" id="submit-btns" class="ti-btn ti-btn-primary">Submit</button>
                </div>

            </div>
            <input type="hidden" value="no" id="isCopied" name="isCopied">
        </form>

        <div class="box-body">
            <div class="overflow-auto table-bordered">
                <div id="past-table" class="ti-custom-table ti-striped-table ti-custom-table-hover tabulator" role="grid"
                    tabulator-layout="fitColumns">

                </div>
            </div>
        </div>


    </div>
@endsection

@section('custom-scripts')
    <script src="{{ asset('admin/js/ckeditor/ckeditor.js') }}"></script>
    <script>
        $(document).ready(function() {
            CKEDITOR.replace('mail_content');
            reciverType($('#reciever_type'));

            //form validation

            $('#submit-btns').on('click', function() {
                if ($('#reciever_type').val() != 'd') {
                    $('#email').attr('required', false);
                } else {
                    $('#email').attr('required', true);
                }

                var emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

                var invalidInputs = $('input[required]').filter(function() {
                    return !$(this).val();
                });

                $('input[required]').removeClass('err');

                var data = CKEDITOR.instances.mail_content.getData();
                if (data == '') {
                    $('.mail-div-ck').css('border', '1px solid red');
                } else {
                    $('.mail-div-ck').css('border', '');
                }

                if (invalidInputs.length > 0) {
                    event.preventDefault();
                    invalidInputs.addClass('err');
                } else if ($('#reciever_type').val() == 'd' && !emailRegex.test($('#email').val().trim())) {
                    event.preventDefault();
                    $('#email').addClass('err');
                } else if (data == '') {
                    event.preventDefault();
                } else {
                    $('form[name="email_form"]').submit();
                }
            });

        });

        var tabledata = [];

        @foreach ($sendedMail as $mail)
            tabledata.push({
                sl_no: {{ $mail->id }},
                subject: '{{ $mail->subject }}',
                content: `{!! $mail->content !!}`,
            });
        @endforeach

        jQuery(document).ready(function($) {
            "use strict";
            /* Start::Choices JS */
            document.addEventListener('DOMContentLoaded', function() {
                var genericExamples = document.querySelectorAll('[data-trigger]');
                for (let i = 0; i < genericExamples.length; ++i) {
                    var element = genericExamples[i];
                    new Choices(element, {
                        allowHTML: false,
                    });
                }
            });

            //Basic Tabulator
            var table = new Tabulator("#past-table", {
                width: 150,
                minWidth: 100,
                layout: "fitColumns",
                pagination: "local",
                paginationSize: 8,
                paginationSizeSelector: [8],
                paginationCounter: "rows",
                data: tabledata,
                columns: [{
                        title: "ID",
                        field: "sl_no",
                        sorter: "string",
                        width: 100,
                    },
                    {
                        title: "Subject",
                        field: "subject",
                        sorter: "string",
                        width: 250,
                    },
                    {
                        title: "Subject",
                        field: "content",
                        sorter: "string",
                    },
                    {
                        title: "Action",
                        field: "action",
                        width: 200,
                        formatter: function(cell, formatterParams, onRendered) {
                            var rowData = cell.getRow().getData();
                            var editButton =
                                '<button class="ti-btn ti-btn-soft-success" data-id="' + rowData
                                .sl_no + '" onclick="copyContent($(this))">Copy</button>';
                            var deleteButton =
                                '<button class="ti-btn ti-btn-soft-danger" data-id="' + rowData
                                .sl_no +
                                '" onclick="deleteAction(' +
                                rowData.sl_no + ')">Delete</button>';

                            return editButton + deleteButton;
                        }
                    },
                ],
            });
        });

        function deleteAction(id) {
            let table = document.getElementById('event-table');
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'ti-btn bg-secondary text-white hover:bg-secondary focus:ring-secondary dark:focus:ring-offset-secondary',
                    cancelButton: 'ti-btn bg-danger text-white hover:bg-danger focus:ring-danger dark:focus:ring-offset-danger'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {

                    const data = {
                        id: id
                    };

                    fetch("{{ route('delete-sended-email') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            },
                            body: JSON.stringify(data),
                        })
                        .then(response => {
                            if (response.ok) {
                                setTimeout(() => {
                                    location.reload();
                                }, 4000);
                                var notifier = new AWN({
                                    position: 'top-right',
                                });
                                notifier.success('History Deleted Successfully!')
                            } else {
                                var notifier = new AWN({
                                    position: 'top-right',
                                });
                                notifier.alert('Something Went Wrong!')
                            }
                        })
                        .catch(error => {
                            console.error("Error:", error);
                            var notifier = new AWN({
                                position: 'top-right',
                            });
                            notifier.alert('Something Went Wrong!')
                        });
                } else if (
                    result.dismiss === Swal.DismissReason.cancel
                ) {

                }
            })
        }

        function copyContent(element) {
            var notifier = new AWN({
                position: 'top-right',
            });
            let id = element.attr('data-id');
            $.ajax({
                url: '{{ route('get-prev-mail-data', ['id' => ':id']) }}'.replace(':id', id),
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.status) {
                        var editor = CKEDITOR.instances.mail_content;
                        console.log(response.data);
                        editor.setData(response.data.content);
                        $('#subject').val(response.data.subject);
                        element.text('Copied');
                        setTimeout(() => {
                            element.text('Copy');
                        }, 800);
                        $('#isCopied').val('yes');
                    } else {
                        notifier.alert(response.message);
                    }
                },
                error: function(error) {
                    notifier.alert('Something Went Wrong')
                }
            });
        }

        function reciverType(elem) {
            if (elem.val() == 'd') {
                $('#email-div').css('display', 'block');
                $('#email').attr('required', true);
            } else {
                $('#email-div').css('display', 'none');
                $('#email').attr('required', false);
            }
        }
    </script>
@endsection
