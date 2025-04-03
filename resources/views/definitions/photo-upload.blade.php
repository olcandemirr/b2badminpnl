@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">FOTOĞRAF YÜKLE</h3>
                </div>
                <div class="card-body">
                    <form id="photoUploadForm" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="type" class="form-label">Yükleme Tipi</label>
                                    <select class="form-select" id="type" name="type" required>
                                        <option value="">-SEÇİNİZ-</option>
                                        <option value="buyuk">Büyük Foto Yükle</option>
                                        <option value="kucuk">Küçük Foto Yükle</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="photo" class="form-label">Dosya Seçin</label>
                                    <input type="file" class="form-control" id="photo" name="photo" accept=".jpg,.jpeg,.png" required>
                                    <div id="selectedPhoto" class="form-text mt-1"></div>
                                </div>
                            </div>
                            <div class="col-md-6 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary">DOSYAYI YÜKLEYİN</button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div id="photoPreview" class="mt-3" style="display: none;">
                                    <h5>Önizleme:</h5>
                                    <img id="previewImage" src="#" alt="Fotoğraf önizleme" style="max-width: 300px; max-height: 300px;">
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="alert alert-info mt-4">
                        <i class="fas fa-info-circle me-2"></i>
                        Yüklemek istediğiniz fotoğraf tipini seçin ve "DOSYAYI YÜKLEYİN" butonuna tıklayın.
                        Desteklenen formatlar: JPG, JPEG, PNG. Maksimum dosya boyutu: 2MB
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
                <h5 class="modal-title">Yükleme Durumu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <div class="spinner-border text-primary mb-3" role="status">
                        <span class="visually-hidden">Yükleniyor...</span>
                    </div>
                    <p id="statusMessage">Fotoğraf yükleniyor...</p>
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

#selectedPhoto {
    color: #6c757d;
}

#photoPreview {
    border: 1px solid #dee2e6;
    padding: 15px;
    border-radius: 4px;
}

#previewImage {
    border: 1px solid #dee2e6;
    border-radius: 4px;
    padding: 5px;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Fotoğraf seçildiğinde önizleme göster
    $('#photo').change(function() {
        const file = this.files[0];
        const fileName = file.name;
        $('#selectedPhoto').text('Seçilen dosya: ' + fileName);

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#previewImage').attr('src', e.target.result);
                $('#photoPreview').show();
            }
            reader.readAsDataURL(file);
        }
    });

    // Form submit
    $('#photoUploadForm').submit(function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        // Modal'ı göster
        $('#statusModal').modal('show');
        
        // Fotoğraf yükleme isteğini gönder
        $.ajax({
            url: '{{ route("definitions.photo-upload.upload") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    $('#statusMessage').html('<span class="text-success"><i class="fas fa-check-circle"></i> ' + response.message + '</span>');
                    setTimeout(function() {
                        $('#statusModal').modal('hide');
                        $('#photoUploadForm')[0].reset();
                        $('#selectedPhoto').text('');
                        $('#photoPreview').hide();
                    }, 2000);
                }
            },
            error: function(xhr) {
                let errorMessage = 'Fotoğraf yükleme sırasında bir hata oluştu.';
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
        $('#statusMessage').text('Fotoğraf yükleniyor...');
    });
});
</script>
@endpush 