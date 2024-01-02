@extends('admin.layouts.app')

@section('title', 'Newsletter')
@section('pagename', 'Newsletter Section')
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

        .waiting {
            background: #ddd;
            color: black;
        }
    </style>
@endsection
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="col-span-12">
        <div class="box">
            <div class="box-header">
                {{-- <input type="text" class="ti-form-input" placeholder="Type to search" id="search"> --}}
                <a href="{{ route('add-newsletter') }}" type="button" class="ti-btn ti-btn-success" style="float:right;">
                    Add New Newsletter Email
                </a>
                <a href="{{ route('bulk-upload-csv') }}" id="bulkupload" class="ti-btn ti-btn-primary" style="float:right;">
                    Bulk Upload - CSV
                </a>
            </div>
            <div class="box-body">
                <div class="overflow-auto table-bordered">
                    <div id="newsletter-table" class="ti-custom-table ti-striped-table ti-custom-table-hover tabulator"
                        role="grid" tabulator-layout="fitColumns">

                    </div>
                </div>
            </div>
        </div>
    </div>




@endsection
@section('custom-scripts')
    <script>
        // $(document).on('click', '#bulkupload', function() {
        //     $('#myModal').removeClass('hidden');
        //     $('#myModal .modal-content').removeClass('opacity-0');
        // });

        // $(document).on('click', '#closeModal', function() {
        //     $('#myModal').addClass('hidden');
        //     $('#myModal .modal-content').addClass('opacity-0');
        //     setTimeout(function() {
        //         $('#myModal').addClass('hidden');
        //     }, 300);
        // });


        var tabledata = [];

        @foreach ($newsletters as $newsletter)
            tabledata.push({
                sl_no: {{ $newsletter->id }},
                name: '{{ $newsletter->name }}',
                email: '{{ $newsletter->email }}',
                status: '{{ $newsletter->status }}'
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
            var table = new Tabulator("#newsletter-table", {
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
                        sorter: "number",
                        width: 100,
                    },
                    {
                        title: "Name",
                        field: "name",
                        sorter: "string",
                        width: 180
                    },
                    {
                        title: "Email",
                        field: "email",
                        sorter: "string",
                        align: "center"
                    },
                    {
                        title: "Status",
                        field: "status",
                        sorter: "string",
                        width: 180,
                        align: "center",
                        formatter: function(cell, formatterParams, onRendered) {
                            var rowData = cell.getRow().getData();
                            let statusIcon = '';
                            if (rowData.status == 'active') {
                                statusIcon =
                                    "<button type=\"button\" class=\"ti-btn ti-btn-soft-warning\" onclick=\"changeStatus(" +
                                    rowData.sl_no + ", '" + rowData.status +
                                    "', this);\"><i class='ti ti-bulb-filled'></i></button>";
                            } else if (rowData.status == 'waiting') {
                                statusIcon =
                                    "<button type=\"button\" class=\"ti-btn waiting\" onclick=\"changeStatus(" +
                                    rowData.sl_no + ", '" + rowData.status +
                                    "', this);\"><i class='ti ti-clock'></i></button>";
                            } else {
                                statusIcon =
                                    "<button type=\"button\" class=\"ti-btn ti-btn-soft-dark\" onclick=\"changeStatus(" +
                                    rowData.sl_no + ", '" + rowData.status +
                                    "', this);\"><i class='ti ti-bulb-off'></i></button>";
                            }
                            return statusIcon;
                        }
                    },
                    {
                        title: "Action",
                        field: "action",
                        width: 180,
                        formatter: function(cell, formatterParams, onRendered) {
                            var rowData = cell.getRow().getData();
                            var editButton =
                                '<button class="ti-btn ti-btn-soft-success" onclick="editAction(' +
                                rowData.sl_no + ')">Edit</button>';
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

        function editAction(id) {
            window.location.href = "{{ route('modify-newsletter', '') }}" + "/" + id;
        }

        function deleteAction(id, buttonElement) {
            let table = document.getElementById('newsletter-table');
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

                    fetch("{{ route('delete-newsletter') }}", {
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
                                notifier.success('Newsletter Email Deleted Successfully!')
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

        function changeStatus(id, status, element) {
            const url = "{{ route('change-newsletter-status', '') }}";
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const updatedData = {
                id: id,
                status: status
            };
            var notifier = new AWN({
                position: 'top-right',
            });

            Swal.fire({
                title: 'Are you sure you want to change it\'s status?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#5e76a6',
                cancelButtonColor: '#ef4444',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: "POST",
                        data: updatedData,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        success: function(response) {
                            if (response.status == 'true') {
                                if (response.data.status == 'active') {
                                    element.setAttribute('class', 'ti-btn ti-btn-soft-dark');
                                    element.innerHTML = "<i class='ti ti-bulb-off'></i>";
                                    element.setAttribute('onclick', "changeStatus(" + id +
                                        ", 'inactive',this)");
                                } else {
                                    element.setAttribute('class', 'ti-btn ti-btn-soft-warning');
                                    element.innerHTML = "<i class='ti ti-bulb-filled'></i>";
                                    element.setAttribute('onclick', "changeStatus(" + id +
                                        ", 'active', this)");
                                }
                                notifier.success(response.messege);
                            } else {
                                notifier.alert(response.messege);
                            }
                        },
                        error: function(xhr, textStatus, errorThrown) {
                            notifier.alert(response.messege);
                        }
                    });
                }
            })
        }
    </script>
@endsection
