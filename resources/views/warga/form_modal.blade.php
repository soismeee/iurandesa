<!--  Modal content for the above example -->
<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form warga</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-warga">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="no_urut" class="form-label">No urut</label>
                                <input type="text" class="form-control" name="no_urut" id="no_urut" placeholder="Masukan no urut">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="nama_lengkap" class="form-label">Nama warga</label>
                                <input type="hidden" class="form-control" name="id" id="id">
                                <input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap" placeholder="Masukan nomor hp warga">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="no_hp" class="form-label">No HP</label>
                                <input type="text" class="form-control" name="no_hp" id="no_hp" onkeypress="return telepon('event')" placeholder="Masukan nama warga">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Masukan alamat warga">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="tombol" class="btn btn-primary waves-effect waves-light" id="tombol">Simpan</button>
                    <button type="button" class="btn btn-light waves-effect" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->