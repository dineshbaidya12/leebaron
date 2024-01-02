@extends('admin.layouts.app')
@section('title', 'Appointments')

@if (request()->routeIs('appointment'))
    @section('pagename', 'Upcomming Appointment Lists')
@elseif (request()->routeIs('pending_appointment'))
    @section('pagename', 'Panding Appointment Lists')
@endif

@section('custom-styles')
    <style>
        .tabulator .tabulator-row .tabulator-cell,
        .tabulator-col-content {
            text-align: center;
        }

        #search {
            width: 27%;
            display: inline-block;
        }

        .tabulator-cells {
            border-left: 1px solid gray;
        }
    </style>
@endsection
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="col-span-12">
        <div class="box">
            <div class="box-header">
                {{-- <input type="text" class="ti-form-input" placeholder="Type to search" id="search"> --}}
                <a href="{{ route('export-appointments-lists') }}" type="button" class="ti-btn ti-btn-success"
                    style="float:right;">Export Appointments Lists</a>
            </div>
            <div class="box-body">
                <div class="overflow-auto table-bordered">
                    <div id="appointment-table" class="ti-custom-table ti-striped-table ti-custom-table-hover tabulator"
                        role="grid" tabulator-layout="fitColumns">

                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
@section('custom-scripts')
    <script>
        var tabledata = [];

        @foreach ($appointments as $app)
            tabledata.push({
                sl_no: {{ $app->id }},
                name: '{{ $app->name }}',
                email: '{{ $app->email }}',
                phone: '{{ $app->phone }}',
                appointment_date: '{{ $app->appointment_date }}',
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
            var table = new Tabulator("#appointment-table", {
                width: 150,
                minWidth: 100,
                layout: "fitColumns",
                pagination: "local",
                paginationSize: 10,
                paginationSizeSelector: [5, 10, 15, 20, 25],
                paginationCounter: "rows",
                data: tabledata,
                columns: [{
                        title: "ID",
                        field: "sl_no",
                        sorter: "string",
                        width: 100,
                    },
                    {
                        title: "Name",
                        field: "name",
                        sorter: "string",
                        align: "center",
                        width: 200,
                    },
                    {
                        title: "Email",
                        field: "email",
                        sorter: "string",
                        align: "center"
                    },
                    {
                        title: "Phone",
                        field: "phone",
                        sorter: "string",
                        align: "center",
                        width: 150,
                    },
                    {
                        title: "Appointment Date",
                        field: "appointment_date",
                        sorter: "date",
                        align: "center",
                        width: 180,
                    },
                    {
                        title: "Action",
                        field: "action",
                        width: 180,
                        cssClass: "tabulator-cells",
                        formatter: function(cell, formatterParams, onRendered) {
                            var rowData = cell.getRow().getData();
                            var editButton =
                                '<button class="ti-btn ti-btn-soft-success" onclick="editAction(' +
                                rowData.sl_no + ')">Edit</button>';
                            var deleteButton =
                                '<button class="ti-btn ti-btn-soft-danger" data-id="' + rowData
                                .sl_no +
                                '" onclick="cancleAction(' +
                                rowData.sl_no + ')">Cancle</button>';

                            return editButton + deleteButton;
                        }
                    },
                ],
            });
        });

        function editAction(id) {
            window.location.href = "{{ route('modify-appointment', '') }}" + "/" + id;
        }

        function cancleAction(id, buttonElement) {
            let table = document.getElementById('event-table');
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'ti-btn bg-secondary text-white hover:bg-secondary focus:ring-secondary dark:focus:ring-offset-secondary',
                    cancelButton: 'ti-btn bg-danger text-white hover:bg-danger focus:ring-danger dark:focus:ring-offset-danger'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: 'Are you sure you want to cancle the appointment?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, cancle the appointment!',
                cancelButtonText: 'No!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {

                    const data = {
                        id: id
                    };

                    fetch("{{ route('cancle_appointment') }}", {
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
                                notifier.success('Appoinement Cancled Successfully.')
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

                    // swalWithBootstrapButtons.fire(
                    //     'Deleted!',
                    //     'Your file has been deleted.',
                    //     'success'
                    // )
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {

                }
            })
        }
    </script>
@endsection
