<!--  Modal content for the above example -->
<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-kategori">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nama_kategori" class="form-label">Nama Kategori</label>
                                <input type="hidden" class="form-control" name="id" id="id" placeholder="Masukan nominal iuran">
                                <input type="text" class="form-control" name="nama_kategori" id="nama_kategori" placeholder="Masukan nama kategori">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nominal" class="form-label">Nominal</label>
                                <input type="text" class="form-control" name="nominal" id="nominal" placeholder="Masukan nominal iuran">
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