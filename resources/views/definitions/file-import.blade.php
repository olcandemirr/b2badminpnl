@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">VERİ AKTARMA</h3>
                </div>
                <div class="card-body">
                    <form id="importForm" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="type" class="form-label">Yükleme Tipi</label>
                                    <select class="form-select" id="type" name="type" required>
                                        <option value="">-SEÇİNİZ-</option>
                                        <option value="products">Ürünler</option>
                                        <option value="dealers">Bayiler</option>
                                        <option value="orders">Siparişler</option>
                                        <option value="prices">Fiyatlar</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="file" class="form-label">Dosya Seçin</label>
                                    <input type="file" class="form-control" id="file" name="file" accept=".xlsx,.xls,.csv" required>
                                    <div id="selectedFile" class="form-text mt-1"></div>
                                </div>
                            </div>
                            <div class="col-md-6 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary">DOSYAYI YÜKLEYİN</button>
                            </div>
                        </div>
                    </form>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Yüklemek istediğiniz dosya tipini seçin ve "DOSYAYI YÜKLEYİN" butonuna tıklayın.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- İşlem Durumu Modal -->
<div class="modal fade" id="statusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Aktarım Durumu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <div class="spinner-border text-primary mb-3" role="status">
                        <span class="visually-hidden">Yükleniyor...</span>
                    </div>
                    <p id="statusMessage">Dosya yükleniyor...</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
}

.card-title {
    margin-bottom: 0;
    font-size: 1.1rem;
    font-weight: 600;
}

.form-label {
    font-weight: 500;
}

.alert {
    margin-bottom: 0;
}

#selectedFile {
    color: #6c757d;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Dosya seçildiğinde dosya adını göster
    $('#file').change(function() {
        const fileName = $(this).val().split('\\').pop();
        $('#selectedFile').text(fileName ? 'Seçilen dosya: ' + fileName : '');
    });

    // Form submit
    $('#importForm').submit(function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        // Modal'ı göster
        $('#statusModal').modal('show');
        
        // Dosya yükleme isteğini gönder
        $.ajax({
            url: '{{ route("definitions.file-import.start") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    $('#statusMessage').html('<span class="text-success"><i class="fas fa-check-circle"></i> ' + response.message + '</span>');
                    setTimeout(function() {
                        $('#statusModal').modal('hide');
                        $('#importForm')[0].reset();
                        $('#selectedFile').text('');
                    }, 2000);
                }
            },
            error: function(xhr) {
                let errorMessage = 'Dosya yükleme sırasında bir hata oluştu.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                $('#statusMessage').html('<span class="text-danger"><i class="fas fa-times-circle"></i> ' + errorMessage + '</span>');
                setTimeout(function() {
                    $('#statusModal').modal('hide');
                }, 2000);
            }
        });
    });

    // Modal kapandığında mesajı sıfırla
    $('#statusModal').on('hidden.bs.modal', function() {
        $('#statusMessage').text('Dosya yükleniyor...');
    });
});
</script>
@endpush 