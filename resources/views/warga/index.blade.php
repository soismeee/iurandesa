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
                        <h4 class="card-title">Daftar warga Iuran Warga</h4>
                        
                        <div>
                            <div class="btn-group">
                                <button type="button" id="tambah" class="btn btn-outline-primary"> Unduh Template</button>
                                <button type="button" id="tambah" class="btn btn-primary">Import Data Warga</button>
                            </div>
                            <button type="button" id="tambah" class="btn btn-success">+ Tambah warga</button>
                        </div>
                    </div>
                    <table id="data-warga" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="10%">No Urut</th>
                                <th width="25%">Nama warga</th>
                                <th width="20%">No HP</th>
                                <th width="30%">Alamat</th>
                                <th width="10%">#</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
    @include('warga.form_modal')
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

    function telepon(evt) {
      var charCode = (evt.which) ? evt.which : event.keyCode
      if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
      return true;
    }

        const table = $('#data-warga').DataTable({          
            "lengthMenu": [[5, 10, 25, 50, 100, -1],[5, 10, 25, 50, 100, 'All']],
            "pageLength": 10, 
            processing: true,
            serverSide: true,
            responseive: true,
            ajax: {
                url:"{{ url('jsonWarga') }}",
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
                        return row.no_urut
                    }
                },
                {
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": function(data, type, row, meta){
                        return row.nama_lengkap
                    }
                },
                {
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": function(data, type, row, meta){
                        return row.no_hp
                    }
                },
                {
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": function(data, type, row, meta){
                        return row.alamat
                    }
                },
                {
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": function(data, type, row, meta){
                        return `
                        <div class="btn-group">
                            <a href="#" class="btn btn-sm btn-warning edit" data-id="`+row.id+`" data-nama_lengkap="`+row.nama_lengkap+`" data-no_urut="`+row.no_urut+`" data-no_hp="`+row.no_hp+`" data-alamat="`+row.alamat+`" title="Edit data"><i class="mdi mdi mdi-file-document-edit-outline"></i></a>
                            <button class="btn btn-sm btn-danger hapusdata" title="Hapus data" data-id="`+row.id+`"><i class="mdi mdi mdi-delete-outline"></i></button>
                        </div>
                        `
                    }
                },
            ]
        });

        $(document).on('click', '#tambah', function(e){
            e.preventDefault();
            $('#modal-form').find('.modal-title').text('Tambah warga');
            $('#modal-form').find('.modal-footer button[type=submit]').text('Tambah');
            $('#modal-form').find('#tombol').val('add'); 
            $('#modal-form').modal('show');
            $('#form-dpa')[0].reset();
        });
        
        $(document).on('click', '.edit', function(e){
            e.preventDefault();
            let idedit = $(this).data('id');
            let nama_lengkap = $(this).data('nama_lengkap');
            let no_urut = $(this).data('no_urut');
            let no_hp = $(this).data('no_hp');
            let alamat = $(this).data('alamat');
            $('#modal-form').find('.modal-body input[name=id]').val(idedit);
            $('#modal-form').find('.modal-body input[name=nama_lengkap]').val(nama_lengkap);
            $('#modal-form').find('.modal-body input[name=no_urut]').val(no_urut);
            $('#modal-form').find('.modal-body input[name=no_hp]').val(no_hp);
            $('#modal-form').find('.modal-body input[name=alamat]').val(alamat);
            $('#modal-form').find('.modal-title').text('Edit warga');
            $('#modal-form').find('.modal-footer button[type=submit]').text('Edit');
            $('#modal-form').find('#tombol').val('edit'); 
            $('#modal-form').modal('show');
        });

        $('#form-warga').on('submit', function(event){
            event.preventDefault();
            $('#tombol').html('Loading...');
            let type = "POST";
            let url = "{{ url('warga') }}";
            let tombol = $('#tombol').val();
            let texttombol = "Simpan";
            if(tombol == 'edit'){
                texttombol = "Edit";
                let id = $('#id').val();
                type = "PATCH";
                url = "{{ url('warga') }}/"+id;
            }
            $.ajax({
                type: type,
                url: url,
                data: $('#form-warga').serialize(),
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
                        url: "/delwarga/"+id,
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