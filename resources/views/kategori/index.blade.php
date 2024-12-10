@extends('layout.main')
@push('css')
    <!-- DataTables -->
    <link href="/tocly/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/tocly/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/tocly/libs/datatables.net-select-bs4/css//select.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="/tocly/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    
    <!-- Sweet Alert-->
    <link href="/tocly/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
@endpush
@section('container')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-4">
                        <h4 class="card-title">Daftar Kategori Iuran Warga</h4>
                        <button type="button" id="tambah" class="btn btn-primary">Tambah Kategori</button>
                    </div>
                    <table id="data-kategori" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="40%">Nama Kategori</th>
                                <th width="45%">Nominal</th>
                                <th width="10%">#</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
    @include('kategori.form_modal')
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

    <!-- Datatable init js -->
    <script src="/tocly/js/pages/datatables.init.js"></script>

    <!-- Sweet Alerts js -->
    <script src="/tocly/libs/sweetalert2/sweetalert2.min.js"></script>

    <!-- Sweet alert init js-->
    <script src="/tocly/js/pages/sweet-alerts.init.js"></script>

    <script>

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

        const table = $('#data-kategori').DataTable({          
            "lengthMenu": [[5, 10, 25, 50, 100, -1],[5, 10, 25, 50, 100, 'All']],
            "pageLength": 10, 
            processing: true,
            serverSide: true,
            responseive: true,
            ajax: {
                url:"{{ url('jsonKategori') }}",
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
                        return row.nama_kategori
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
                            <a href="#" class="btn btn-sm btn-warning edit" data-id="`+row.id+`" data-nama_kategori="`+row.nama_kategori+`" data-nominal="`+row.nominal+`" title="Edit data"><i class="mdi mdi mdi-file-document-edit-outline"></i></a>
                            <button class="btn btn-sm btn-danger hapusdata" title="Hapus data" data-id="`+row.id+`"><i class="mdi mdi mdi-delete-outline"></i></button>
                        </div>
                        `
                    }
                },
            ]
        });

        $(document).on('click', '#tambah', function(e){
            e.preventDefault();
            $('#modal-form').find('.modal-title').text('Tambah Kategori');
            $('#modal-form').find('.modal-footer button[type=submit]').text('Tambah');
            $('#modal-form').find('#tombol').val('add'); 
            $('#modal-form').modal('show');
            $('#form-dpa')[0].reset();
        });
        
        $(document).on('click', '.edit', function(e){
            e.preventDefault();
            let idedit = $(this).data('id');
            let nama_kategori = $(this).data('nama_kategori');
            let nominal = $(this).data('nominal');
            $('#modal-form').find('.modal-body input[name=id]').val(idedit);
            $('#modal-form').find('.modal-body input[name=nama_kategori]').val(nama_kategori);
            $('#modal-form').find('.modal-body input[name=nominal]').val("Rp. "+rupiah(nominal));
            $('#modal-form').find('.modal-title').text('Edit Kategori');
            $('#modal-form').find('.modal-footer button[type=submit]').text('Edit');
            $('#modal-form').find('#tombol').val('edit'); 
            $('#modal-form').modal('show');
        });

        $('#form-kategori').on('submit', function(event){
            event.preventDefault();
            $('#tombol').html('Loading...');
            let type = "POST";
            let url = "{{ url('kategori') }}";
            let tombol = $('#tombol').val();
            let texttombol = "Simpan";
            if(tombol == 'edit'){
                texttombol = "Edit";
                let id = $('#id').val();
                type = "PATCH";
                url = "{{ url('kategori') }}/"+id;
            }
            $.ajax({
                type: type,
                url: url,
                data: $('#form-kategori').serialize(),
                success: function(response){
                    table.ajax.reload();
                    $('#modal-form').modal('hide');
                    $('#tombol').html(texttombol);
                    Swal.fire({
                        icon: "success",
                        title: "Selamat!",
                        text: response.message,
                    });
                },
                error: function(err){
                    $('#tombol').html(texttombol);
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: err.responseJSON.message,
                    });
                }
            });
        });

        $(document).on('click', '.hapusdata', function(e){
            e.preventDefault();
            let id = $(this).data('id');
            Swal.fire({
                title: 'Data ini akan dihapus?',
                text: $(this).data('pesan'),
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "/delkategori/"+id,
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response){
                            Swal.fire(
                                'Berhasil!',
                                response.message,
                               'success'
                            )
                            table.ajax.reload();
                        }
                    });
                }
            });
        });
    </script>
@endpush