@extends('layout.main')
@push('css')
    <!-- DataTables -->
    <link href="/tocly/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/tocly/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/tocly/libs/datatables.net-select-bs4/css/select.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <link href="/tocly/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css">

    <!-- Responsive datatable examples -->
    <link href="/tocly/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    
    <!-- Sweet Alert-->
    <link href="/tocly/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
@endpush
@section('container')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 col-sm-12 mb-3">
                            <select name="tahun" id="tahun" class="form-select">
                                <option value="{{ date('Y') }}" selected>{{ date('Y') }}</option>
                                @foreach ($tahun as $t)
                                    <option value="{{ $t }}">{{ $t }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <h4 class="card-title">Daftar iuran</h4>
                    <table id="data-iuran" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr class="text-center">
                                <th rowspan="2" width="5%">No</th>
                                <th rowspan="2" width="15%">Warga</th>
                                <th colspan="12" width="80%">Bulan</th>
                            </tr>
                            <tr>
                                <th width="6%">Jan</th>
                                <th width="6%">Feb</th>
                                <th width="6%">Mar</th>
                                <th width="6%">Apr</th>
                                <th width="6%">Mei</th>
                                <th width="6%">Jun</th>
                                <th width="6%">Jul</th>
                                <th width="6%">Agt</th>
                                <th width="6%">Sep</th>
                                <th width="6%">Okt</th>
                                <th width="6%">Nov</th>
                                <th width="6%">Des</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
@endsection

@push('js')
    <!-- Required datatable js -->
    <script src="/tocly/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="/tocly/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>

    <!-- Buttons examples -->
    <script src="/tocly/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="/tocly/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>

    <script src="/tocly/libs/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="/tocly/libs/datatables.net-select/js/dataTables.select.min.js"></script>
    
    <!-- Responsive examples -->
    <script src="/tocly/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/tocly/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

    <script src="/tocly/libs/select2/js/select2.min.js"></script>

    <!-- Datatable init js -->
    <script src="/tocly/js/pages/datatables.init.js"></script>

    <!-- Sweet Alerts js -->
    <script src="/tocly/libs/sweetalert2/sweetalert2.min.js"></script>

    <!-- Sweet alert init js-->
    <script src="/tocly/js/pages/sweet-alerts.init.js"></script>

    <script>

        const rupiah = (number) => {
            return new Intl.NumberFormat("id-ID", {
            style: "decimal",
            currency: "IDR"
            }).format(number);
        }

        // Fungsi untuk memformat tanggal ke format Indonesia
        function formatTanggal(tanggal) {
            if (!tanggal) return "Belum tersedia"; // Jika tanggal null atau undefined
            let date = new Date(tanggal); // Konversi string tanggal ke objek Date
            let day = String(date.getDate()).padStart(2, '0'); // Hari dengan 2 digit
            let month = String(date.getMonth() + 1).padStart(2, '0'); // Bulan dengan 2 digit
            let year = date.getFullYear(); // Tahun
            return `${day}/${month}/${year}`; // Format dd-mm-yyyy
        }

        function convertRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, "").toString(),
                split = number_string.split(","),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? "." : "";
                rupiah += separator + ribuan.join(".");
            }

            rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
            return prefix == undefined ? rupiah : rupiah ? prefix + rupiah : "";
        }

        $(document).on('change', '#tahun', function(e){
            e.preventDefault();
            table.ajax.reload();
        });

        const table = $('#data-iuran').DataTable({          
            "lengthMenu": [[5, 10, 25, 50, 100, -1],[5, 10, 25, 50, 100, 'All']],
            "pageLength": 10, 
            processing: true,
            serverSide: true,
            responseive: true,
            ajax: {
                url:"{{ url('jsonRekap') }}",
                type:"POST",
                data:function(d){
                    d.tahun = $('#tahun').val(),
                    d._token = "{{ csrf_token() }}"
                }
            },
            columns:[
                {
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": function(data, type, row, meta){
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": function(data, type, row, meta){
                        return row.warga
                    }
                },
                {
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": function(data, type, row, meta){
                        return rupiah(row.Jan)
                    }
                },
                {
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": function(data, type, row, meta){
                        return rupiah(row.Feb)
                    }
                },
                {
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": function(data, type, row, meta){
                        return rupiah(row.Mar)
                    }
                },
                {
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": function(data, type, row, meta){
                        return rupiah(row.Apr)
                    }
                },
                {
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": function(data, type, row, meta){
                        return rupiah(row.Mei)
                    }
                },
                {
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": function(data, type, row, meta){
                        return rupiah(row.Jun)
                    }
                },
                {
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": function(data, type, row, meta){
                        return rupiah(row.Jul)
                    }
                },
                {
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": function(data, type, row, meta){
                        return rupiah(row.Agt)
                    }
                },
                {
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": function(data, type, row, meta){
                        return rupiah(row.Sep)
                    }
                },
                {
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": function(data, type, row, meta){
                        return rupiah(row.Okt)
                    }
                },
                {
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": function(data, type, row, meta){
                        return rupiah(row.Nov)
                    }
                },
                {
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": function(data, type, row, meta){
                        return rupiah(row.Des)
                    }
                },
            ]
        });
    </script>
@endpush