@extends('layout.main')
@section('container')
<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="avatar-md flex-shrink-0">
                        <span class="avatar-title bg-subtle-primary text-primary rounded fs-2">
                            <i class="uim uim-briefcase"></i>
                        </span>
                    </div>
                    <div class="flex-grow-1 overflow-hidden ms-4">
                        <p class="text-muted text-truncate font-size-15 mb-2"> Total Warga</p>
                        <h3 class="fs-4 flex-grow-1 mb-3">Rp. 0</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="avatar-md flex-shrink-0">
                        <span class="avatar-title bg-subtle-primary text-primary rounded fs-2">
                            <i class="uim uim-layer-group"></i>
                        </span>
                    </div>
                    <div class="flex-grow-1 overflow-hidden ms-4">
                        <p class="text-muted text-truncate font-size-15 mb-2"> Total Uiran s.d saat ini</p>
                        <h3 class="fs-4 flex-grow-1 mb-3">Rp. 0</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="avatar-md flex-shrink-0">
                        <span class="avatar-title bg-subtle-primary text-primary rounded fs-2">
                            <i class="uim uim-scenery"></i>
                        </span>
                    </div>
                    <div class="flex-grow-1 overflow-hidden ms-4">
                        <p class="text-muted text-truncate font-size-15 mb-2"> Total Iuran bulan ini</p>
                        <h3 class="fs-4 flex-grow-1 mb-3">Rp.0</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="avatar-md flex-shrink-0">
                        <span class="avatar-title bg-subtle-primary text-primary rounded fs-2">
                            <i class="uim uim-airplay"></i>
                        </span>
                    </div>
                    <div class="flex-grow-1 overflow-hidden ms-4">
                        <p class="text-muted text-truncate font-size-15 mb-2"> Total Iuran bulan lalu</p>
                        <h3 class="fs-4 flex-grow-1 mb-3">Rp. 0</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END ROW -->

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h5>Daftar warga yang belum melakukan iuran bulan ini</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped mb-0" id="data-pengaduan">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>No urut</th>
                                <th>Nama</th>
                                <th>No HP</th>
                                <th>Alamat</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            loaddata();
        });

        function loaddata(){
            $.ajax({
                url: "{{ url('getIuran') }}",
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    let data = response.data;
                    let html = '';
                    let no = 1;
                    data.forEach(function(item) {
                        html += `<tr>
                                    <td>${no++}</td>
                                    <td>${item.no_urut}</td>
                                    <td>${item.nama_lengkap}</td>
                                    <td>${item.no_hp}</td>
                                    <td>${item.alamat}</td>
                                    <td><span class="badge bg-primary">Belum iuran</span></td>
                                </tr>`;
                    });
                    $('#data-pengaduan tbody').html(html);
                },
                error: function(error){
                    $('#data-pengaduan tbody').html(`
                    <tr>
                        <td colspan="6" class="text-center">`+error.responseJSON.message+`</td>
                    </tr>
                    `);
                }
            });
        }
    </script>
@endpush