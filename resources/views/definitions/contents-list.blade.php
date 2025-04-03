@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">İçerik Listesi</h3>
                </div>
                <div class="card-body">
                    <!-- Arama Formu -->
                    <form action="{{ route('definitions.contents.list') }}" method="GET" class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <input type="text" name="search" class="form-control" placeholder="Aranacak bilgi girin..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <select name="section_id" class="form-select">
                                    <option value="">Bölüm Seçiniz</option>
                                    @foreach($sections as $section)
                                        <option value="{{ $section->id }}" {{ request('section_id') == $section->id ? 'selected' : '' }}>
                                            {{ $section->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="type" class="form-select">
                                    <option value="">Tür Seçiniz</option>
                                    <option value="haber" {{ request('type') == 'haber' ? 'selected' : '' }}>Haber</option>
                                    <option value="duyuru" {{ request('type') == 'duyuru' ? 'selected' : '' }}>Duyuru</option>
                                    <option value="blog" {{ request('type') == 'blog' ? 'selected' : '' }}>Blog</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary">SORGULA</button>
                            </div>
                        </div>
                    </form>

                    <!-- İçerikler Tablosu -->
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Düz.</th>
                                    <th>No</th>
                                    <th>Durum</th>
                                    <th>Bölüm</th>
                                    <th>Kategori</th>
                                    <th>Başlık</th>
                                    <th>Tarih</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($contents as $content)
                                <tr>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-info edit-btn" 
                                            data-id="{{ $content->id }}"
                                            data-type="{{ $content->type }}"
                                            data-section-id="{{ $content->section_id }}"
                                            data-title="{{ $content->title }}"
                                            data-eng="{{ $content->eng }}"
                                            data-description="{{ $content->description }}"
                                            data-eng-description="{{ $content->eng_description }}"
                                            data-link="{{ $content->link }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                    <td>{{ $content->id }}</td>
                                    <td>
                                        <span class="badge bg-success">Aktif</span>
                                    </td>
                                    <td>{{ $content->section->name }}</td>
                                    <td>{{ ucfirst($content->type) }}</td>
                                    <td>{{ $content->title }}</td>
                                    <td>{{ $content->created_at->format('Y-m-d') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">Veri Bulunamadı</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div>
                            {{ $contents->total() }} kayıttan {{ $contents->firstItem() ?? 0 }} ile {{ $contents->lastItem() ?? 0 }} arası gösteriliyor
                        </div>
                        <div class="pagination-wrapper">
                            {{ $contents->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Düzenleme Modal -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">İçerik Düzenle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editForm" enctype="multipart/form-data">
                    <input type="hidden" id="editId">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editType" class="form-label">Tür</label>
                                <select class="form-select" id="editType" required>
                                    <option value="haber">Haber</option>
                                    <option value="duyuru">Duyuru</option>
                                    <option value="blog">Blog</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editSectionId" class="form-label">Bölüm</label>
                                <select class="form-select" id="editSectionId" required>
                                    @foreach($sections as $section)
                                        <option value="{{ $section->id }}">{{ $section->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editTitle" class="form-label">Başlık</label>
                                <input type="text" class="form-control" id="editTitle" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editEng" class="form-label">Başlık (İngilizce)</label>
                                <input type="text" class="form-control" id="editEng">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editDescription" class="form-label">Açıklama</label>
                                <textarea class="form-control editor" id="editDescription" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editEngDescription" class="form-label">Açıklama (İngilizce)</label>
                                <textarea class="form-control editor" id="editEngDescription" rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editPhoto" class="form-label">Fotoğraf</label>
                                <input type="file" class="form-control" id="editPhoto">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editLink" class="form-label">Link</label>
                                <input type="text" class="form-control" id="editLink">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                <button type="button" class="btn btn-primary" id="saveEdit">Kaydet</button>
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

.table th {
    background-color: #f8f9fa;
    font-weight: 500;
    white-space: nowrap;
}

.table td {
    vertical-align: middle;
}

.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}

.badge {
    font-weight: 500;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js"></script>
<script>
$(document).ready(function() {
    // TinyMCE Editör
    tinymce.init({
        selector: '.editor',
        height: 300,
        plugins: 'advlist autolink lists link image charmap print preview anchor searchreplace visualblocks code fullscreen insertdatetime media table paste code help wordcount',
        toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
        content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif; font-size: 14px; }'
    });

    // Düzenleme modalını aç
    $('.edit-btn').click(function() {
        const id = $(this).data('id');
        const type = $(this).data('type');
        const sectionId = $(this).data('section-id');
        const title = $(this).data('title');
        const eng = $(this).data('eng');
        const description = $(this).data('description');
        const engDescription = $(this).data('eng-description');
        const link = $(this).data('link');

        $('#editId').val(id);
        $('#editType').val(type);
        $('#editSectionId').val(sectionId);
        $('#editTitle').val(title);
        $('#editEng').val(eng);
        tinymce.get('editDescription').setContent(description || '');
        tinymce.get('editEngDescription').setContent(engDescription || '');
        $('#editLink').val(link);
        $('#editModal').modal('show');
    });

    // Düzenlemeyi kaydet
    $('#saveEdit').click(function() {
        const id = $('#editId').val();
        const formData = new FormData();
        
        formData.append('section_id', $('#editSectionId').val());
        formData.append('type', $('#editType').val());
        formData.append('title', $('#editTitle').val());
        formData.append('eng', $('#editEng').val());
        formData.append('description', tinymce.get('editDescription').getContent());
        formData.append('eng_description', tinymce.get('editEngDescription').getContent());
        formData.append('link', $('#editLink').val());
        
        if ($('#editPhoto')[0].files[0]) {
            formData.append('photo', $('#editPhoto')[0].files[0]);
        }

        formData.append('_method', 'PUT');

        $.ajax({
            url: `/definitions/contents/${id}`,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    location.reload();
                }
            },
            error: function(xhr) {
                alert('Güncelleme sırasında bir hata oluştu.');
            }
        });
    });
});
</script>
@endpush 