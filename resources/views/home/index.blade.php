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
                        <h3 class="fs-4 flex-grow-1 mb-3" id="warga">0</h3>
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
                        <p class="text-muted text-truncate font-size-15 mb-2"> Total Iuran s.d saat ini</p>
                        <h3 class="fs-4 flex-grow-1 mb-3" id="iuransdini">Rp. 0</h3>
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
                        <h3 class="fs-4 flex-grow-1 mb-3" id="iuranblini">Rp.0</h3>
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
                        <h3 class="fs-4 flex-grow-1 mb-3" id="iuranbllalu">Rp. 0</h3>
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
                    <table class="table table-striped mb-0" id="data-pengaduanbelum">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th width="10%">No urut</th>
                                <th width="25%">Nama</th>
                                <th width="20%">No HP</th>
                                <th width="30%">Alamat</th>
                                <th width="10%">Status</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h5>Daftar warga yang sudah melakukan iuran bulan ini</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped mb-0" id="data-pengaduansudah">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th width="10%">No urut</th>
                                <th width="25%">Nama</th>
                                <th width="20%">No HP</th>
                                <th width="30%">Alamat</th>
                                <th width="10%">Status</th>
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

        const rupiah = (number) => {
            return new Intl.NumberFormat("id-ID", {
            style: "decimal",
            currency: "IDR"
            }).format(number);
        }

        $(document).ready(function() {
            loaddata();
            getData();
        });

        function getData(){
            $.ajax({
                url: "{{ url('getDashbaord') }}",
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    $('#warga').text(response.data.warga + " warga");
                    $('#iuransdini').text("Rp. "+rupiah(response.data.iuransdini));
                    $('#iuranblini').text("Rp. "+rupiah(response.data.iuranblini));
                    $('#iuranbllalu').text("Rp. "+rupiah(response.data.iuranbllalu));
                },
                error: function(error){
                    console.log(error);
                    
                }
            });
        }

        function loaddata(){
            $.ajax({
                url: "{{ url('getIuran') }}",
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    let belum = response.belum;
                    belum.forEach(function(item, index) {
                        $('#data-pengaduanbelum tbody').append(
                            `<tr>
                                <td>${index+1}</td>
                                <td>${item.no_urut}</td>
                                <td>${item.nama_lengkap}</td>
                                <td>${item.no_hp}</td>
                                <td>${item.alamat}</td>
                                <td><span class="badge bg-primary">Belum iuran</span></td>
                            </tr>`
                        );
                    });
                    
                    let sudah = response.sudah;
                    sudah.forEach(function(item, index) {
                        $('#data-pengaduansudah tbody').append(
                            `<tr>
                                <td>${index+1}</td>
                                <td>${item.no_urut}</td>
                                <td>${item.nama_lengkap}</td>
                                <td>${item.no_hp}</td>
                                <td>${item.alamat}</td>
                                <td><span class="badge bg-success">sudah iuran</span></td>
                            </tr>`
                        );
                    });
                },
                error: function(error){
                    $('#data-pengaduansudah tbody').html(`
                    <tr>
                        <td colspan="6" class="text-center">`+error.responseJSON.message+`</td>
                    </tr>
                    `);
                }
            });
        }
    </script>
@endpush