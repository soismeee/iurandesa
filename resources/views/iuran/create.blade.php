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
        <div class="col-lg-4 col-md-12">
            <div class="card">
                <div class="card-header">
                    <label>Form iuran</label>
                </div>
                <div class="card-body">
                    <form id="form-iuran">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <input type="hidden" class="form-control" id="id" name="id">
                                <label for="warga_id">Warga</label>
                                <select class="form-select select2" id="warga_id" name="warga_id">
                                    <option>Pilih warga</option>
                                </select>
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="kategori">Kategori</label>
                                <select class="form-select" name="kategori" id="kategori">
                                    <option selected disabled>Pilih kategori</option>
                                    @foreach ($kategori as $k)
                                        <option value="{{ $k->nama_kategori }}" data-nominal="{{ $k->nominal }}">{{ $k->nama_kategori }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="bulan">Tanggal</label>
                                <input type="date" class="form-control" name="tanggal_iuran" id="tanggal_iuran" value="{{ date('Y-m-d') }}">
                            </div>
                            <div class="col-md-12 mt-3">
                                <label for="nominal">Nominal</label>
                                <input type="text" class="form-control" id="nominal" name="nominal" placeholder="Masukan nominal iuran">
                            </div>
                            <div class="col-md-12 mt-3">
                                <button type="submit" id="tombol" class="btn btn-sm btn-primary">Tambah</button>    
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Daftar iuran bulan ini</h4>
                    <table id="data-iuran" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="20%">Warga</th>
                                <th width="15%">Bulan</th>
                                <th width="15%">Kategori</th>
                                <th width="10%">Tgl Iuran</th>
                                <th width="20%">Nominal</th>
                                <th width="10%">#</th>
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

        $(document).ready(function(e){
            getWarga();
        });

        var nominal = document.getElementById("nominal");
        nominal.addEventListener("keyup", function(e) {
            nominal.value = convertRupiah(this.value, "Rp. ");
        });

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

        function getWarga() {
            $('#warga_id').html("");
            $('#warga_id').append('<option selected disabled>Pilih warga</option>');
            $.ajax({
                type: "GET",
                url: "{{ url('getWarga') }}",
                dataType: "json",
                success: function (response) {
                    let warga = response.data
                    warga.forEach(function(items) {
                        $('#warga_id').append(`
                        <option value="`+items.id+`" data-nama_lengkap="`+items.nama_lengkap+`" >`+items.no_urut+`. `+items.nama_lengkap+`</option>
                        `)
                    })
                }
            });
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

        const table = $('#data-iuran').DataTable({          
            "lengthMenu": [[5, 10, 25, 50, 100, -1],[5, 10, 25, 50, 100, 'All']],
            "pageLength": 10, 
            processing: true,
            serverSide: true,
            responseive: true,
            ajax: {
                url:"{{ url('jsonHariIni') }}",
                type:"POST",
                data:function(d){
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
                        return row.warga.nama_lengkap
                    }
                },
                {
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": function(data, type, row, meta){
                        return row.bulan
                    }
                },
                {
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": function(data, type, row, meta){
                        return row.kategori_iuran
                    }
                },
                {
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": function(data, type, row, meta){
                        return formatTanggal(row.tanggal_iuran)
                    }
                },
                {
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": function(data, type, row, meta){
                        return "Rp. " + rupiah(row.nominal)
                    }
                },
                {
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": function(data, type, row, meta){
                        return `
                        <div class="btn-group">
                            <a href="#" class="btn btn-sm btn-warning edit" data-id="`+row.id+`" data-warga_id="`+row.warga_id+`" data-kategori="`+row.kategori_iuran+`" data-nominal="`+row.nominal+`" data-tanggal_iuran="`+row.tanggal_iuran+`" title="Edit data"><i class="mdi mdi mdi-file-document-edit-outline"></i></a>
                            <button class="btn btn-sm btn-danger delete" title="Hapus data" data-id="`+row.id+`"><i class="mdi mdi mdi-delete-outline"></i></button>
                        </div>
                        `
                    }
                },
            ]
        });

        $(document).on('change', '#kategori', function(e){
            e.preventDefault();
            let nominal = $(this).find(':selected').data('nominal');
            $('#nominal').val("Rp. "+rupiah(nominal))
        });

        $('#form-iuran').on('submit', function(event){
            event.preventDefault();
            $('#tombol').html('Loading...');
            let type = "POST";
            let url = "{{ url('saveIuran') }}";
            let tombol = $('#tombol').val();
            let texttombol = "Simpan";
            if(tombol == 'update'){
                texttombol = "Edit";
                let id = $('#id').val();
                type = "PATCH";
                url = "{{ url('changeIuran') }}/"+id;
            }
            $.ajax({
                type: type,
                url: url,
                data: $('#form-iuran').serialize(),
                success: function(response){
                $('#tombol').html('Tambah');
                $('#tombol').val('store');
                    table.ajax.reload();
                    Swal.fire({
                        icon: "success",
                        title: "Selamat!",
                        text: response.message,
                    });
                },
                error: function(err){
                    $('#tombol').html('Tambah');
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: err.responseJSON.message,
                    });
                }
            });
        });

        $(document).on('click', '.edit', function(e){
            e.preventDefault();
            let id = $(this).data('id');
            let warga_id = $(this).data('warga_id');
            let kategori = $(this).data('kategori');
            let nominal = $(this).data('nominal');
            let tanggal_iuran = $(this).data('tanggal_iuran');
            $('#tombol').html('Ubah data');
            $('#tombol').val('update');
            $('#id').val(id);
            $('#warga_id').val(warga_id);
            $('#kategori').val(kategori);
            $('#nominal').val("Rp. " + rupiah(nominal));
            $('#tanggal_iuran').val(tanggal_iuran);
        });

        $(document).on('click', '.delete', function(e){
            e.preventDefault();
            let id = $(this).data('id');
            Swal.fire({
                title: "Yakin ingin menghapus ini?",
                text: "Data Iuran ini akan terhapus pada sistem!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                $.ajax({
                    type: "DELETE",
                    url: "{{ url('getIuran') }}/"+id,
                    data: { '_token': "{{ csrf_token() }}"},
                    success: function(response){
                        table.ajax.reload();
                        Swal.fire({
                            title: "Terhapus!",
                            text: response.message,
                            icon: "success"
                        });
                    },
                    error: function(err){
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: err.responseJSON.message,
                        });
                    }
                });
                }
            });
        });
    </script>
@endpush