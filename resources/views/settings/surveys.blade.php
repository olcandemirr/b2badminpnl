@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Anket Yönetim Paneli</h3>
                    <button type="button" class="btn btn-primary btn-sm" id="reorderButton">
                        <i class="fas fa-sort me-1"></i> Seçenekleri Sırala
                    </button>
                </div>
                <div class="card-body">
                    <!-- Anket Ayarları -->
                    <form action="{{ route('settings.surveys.update') }}" method="POST" class="mb-4">
                        @csrf
                        
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-check mb-3">
                                    <input type="checkbox" class="form-check-input" name="survey_active" id="surveyActive" {{ ($settings['survey_active'] ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="surveyActive">Anketi Aktif Et</label>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Anket Başlığı</label>
                                <input type="text" class="form-control" name="survey_title" placeholder="Ürünlerimiz Hakkında Ne Düşünüyorsunuz?" value="{{ $settings['survey_title'] ?? '' }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">ENG</label>
                                <input type="text" class="form-control" name="survey_title_en" placeholder="What Do You Think About Our Products?" value="{{ $settings['survey_title_en'] ?? '' }}">
                            </div>
                        </div>
                        
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Anket Ayarlarını Kaydet
                            </button>
                        </div>
                    </form>

                    <hr class="my-4">

                    <!-- Yeni Seçenek Ekle -->
                    <form action="{{ route('settings.surveys.options.add') }}" method="POST" class="mb-4">
                        @csrf
                        <h5 class="mb-3">Anket Seçeneği Ekle</h5>
                        
                        <div class="row">
                            <div class="col-md-5">
                                <label class="form-label">Seçenek</label>
                                <input type="text" class="form-control" name="option" required>
                            </div>
                            <div class="col-md-5">
                                <label class="form-label">Seçenek (İngilizce)</label>
                                <input type="text" class="form-control" name="option_en">
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-plus me-1"></i> Ekle
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Seçenek Listesi -->
                    <h5 class="mb-3">Anket Seçenekleri</h5>
                    
                    @if(count($surveyOptions) > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 60px">#</th>
                                    <th>Seçenek</th>
                                    <th>İngilizce</th>
                                    <th style="width: 100px">Oy Sayısı</th>
                                    <th style="width: 100px">Durum</th>
                                    <th style="width: 150px">İşlemler</th>
                                </tr>
                            </thead>
                            <tbody id="sortable-options">
                                @foreach($surveyOptions as $option)
                                <tr data-id="{{ $option->id }}">
                                    <td class="text-center">
                                        <span class="handle" style="cursor: grab"><i class="fas fa-grip-vertical"></i></span>
                                        <span>{{ $option->order }}</span>
                                    </td>
                                    <td>{{ $option->option }}</td>
                                    <td>{{ $option->option_en }}</td>
                                    <td class="text-center">{{ $option->votes }}</td>
                                    <td class="text-center">
                                        @if($option->is_active)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-danger">Pasif</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-primary edit-option-btn" 
                                            data-id="{{ $option->id }}" 
                                            data-option="{{ $option->option }}" 
                                            data-option-en="{{ $option->option_en }}"
                                            data-active="{{ $option->is_active }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <a href="{{ route('settings.surveys.options.delete', $option->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Bu seçeneği silmek istediğinize emin misiniz?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="alert alert-info">
                        Henüz bir anket seçeneği eklenmemiş.
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Düzenleme Modal -->
<div class="modal fade" id="editOptionModal" tabindex="-1" aria-labelledby="editOptionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('settings.surveys.options.update', 0) }}" method="POST" id="editOptionForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="editOptionModalLabel">Anket Seçeneğini Düzenle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Seçenek</label>
                        <input type="text" class="form-control" name="option" id="editOption" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Seçenek (İngilizce)</label>
                        <input type="text" class="form-control" name="option_en" id="editOptionEn">
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="is_active" id="editIsActive">
                        <label class="form-check-label" for="editIsActive">Aktif</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-primary">Kaydet</button>
                </div>
            </form>
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

.table th {
    background-color: #f8f9fa;
    font-weight: 600;
}

.table td, .table th {
    vertical-align: middle;
}

.handle {
    margin-right: 8px;
    color: #999;
}

.sortable-ghost {
    background-color: #e9ecef;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
$(document).ready(function() {
    // Sortable.js ile sıralama işlemi
    var sortable = new Sortable(document.getElementById('sortable-options'), {
        handle: '.handle',
        animation: 150,
        ghostClass: 'sortable-ghost'
    });
    
    // Sıralama butonuna tıklandığında
    $('#reorderButton').click(function() {
        var items = [];
        $('#sortable-options tr').each(function() {
            items.push($(this).data('id'));
        });
        
        // Ajax ile sıralama bilgilerini gönder
        $.ajax({
            url: '{{ route("settings.surveys.options.reorder") }}',
            type: 'POST',
            data: {
                ids: items,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    // Sayfayı yenile
                    location.reload();
                }
            }
        });
    });
    
    // Düzenleme modalını göster
    $('.edit-option-btn').click(function() {
        var id = $(this).data('id');
        var option = $(this).data('option');
        var optionEn = $(this).data('option-en');
        var isActive = $(this).data('active');
        
        $('#editOption').val(option);
        $('#editOptionEn').val(optionEn);
        $('#editIsActive').prop('checked', isActive);
        
        // Form action URL'ini güncelle
        var formAction = $('#editOptionForm').attr('action');
        formAction = formAction.replace(/\/\d+$/, '/' + id);
        $('#editOptionForm').attr('action', formAction);
        
        // Modal'ı göster
        $('#editOptionModal').modal('show');
    });
});
</script>
@endpush 