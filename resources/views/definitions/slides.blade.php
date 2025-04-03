@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Slayt Ekle</h3>
                </div>
                <div class="card-body">
                    <!-- Slayt Ekleme Formu -->
                    <form id="slideForm" action="{{ route('definitions.slides.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="section_id" class="form-label">Bölüm *</label>
                                    <select class="form-select" id="section_id" name="section_id" required>
                                        <option value="">Seçiniz</option>
                                        @foreach($sections as $section)
                                            <option value="{{ $section->id }}">{{ $section->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Başlık</label>
                                    <input type="text" class="form-control" id="title" name="title" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="photo" class="form-label">Foto</label>
                                    <input type="file" class="form-control" id="photo" name="photo">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="description" class="form-label">Açıklama</label>
                                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="description1" class="form-label">Açıklama 1</label>
                                    <textarea class="form-control" id="description1" name="description1" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="link" class="form-label">Link</label>
                                    <input type="text" class="form-control" id="link" name="link">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="style" class="form-label">Style</label>
                                    <input type="text" class="form-control" id="style" name="style">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">EKLE</button>
                    </form>

                    <!-- Slaytlar Tablosu -->
                    <div class="table-responsive mt-4">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Başlık</th>
                                    <th>Eng</th>
                                    <th>Açıklama</th>
                                    <th>Eng</th>
                                    <th>Açıklama1</th>
                                    <th>Eng</th>
                                    <th>Bölüm</th>
                                    <th>Foto</th>
                                    <th>Link</th>
                                    <th>Sıra</th>
                                    <th>Style</th>
                                    <th>Düz.</th>
                                    <th>Sil</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($slides as $slide)
                                <tr>
                                    <td>{{ $slide->id }}</td>
                                    <td>{{ $slide->title }}</td>
                                    <td>{{ $slide->eng }}</td>
                                    <td>{{ Str::limit($slide->description, 30) }}</td>
                                    <td>{{ Str::limit($slide->eng_description, 30) }}</td>
                                    <td>{{ Str::limit($slide->description1, 30) }}</td>
                                    <td>{{ Str::limit($slide->eng_description1, 30) }}</td>
                                    <td>{{ $slide->section->name }}</td>
                                    <td>
                                        @if($slide->photo)
                                            <img src="{{ asset('uploads/slides/' . $slide->photo) }}" 
                                                alt="Slayt Görseli" 
                                                style="max-width: 50px; max-height: 50px;">
                                        @endif
                                    </td>
                                    <td>{{ Str::limit($slide->link, 20) }}</td>
                                    <td>
                                        <input type="number" class="form-control form-control-sm order-input" 
                                            value="{{ $slide->order }}" 
                                            data-id="{{ $slide->id }}" 
                                            style="width: 80px">
                                    </td>
                                    <td>{{ $slide->style }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-info edit-btn" 
                                            data-id="{{ $slide->id }}"
                                            data-section-id="{{ $slide->section_id }}"
                                            data-title="{{ $slide->title }}"
                                            data-eng="{{ $slide->eng }}"
                                            data-description="{{ $slide->description }}"
                                            data-eng-description="{{ $slide->eng_description }}"
                                            data-description1="{{ $slide->description1 }}"
                                            data-eng-description1="{{ $slide->eng_description1 }}"
                                            data-link="{{ $slide->link }}"
                                            data-style="{{ $slide->style }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-danger delete-btn" 
                                            data-id="{{ $slide->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="14" class="text-center">Veri Bulunamadı</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div>
                            {{ $slides->total() }} kayıttan {{ $slides->firstItem() ?? 0 }} ile {{ $slides->lastItem() ?? 0 }} arası gösteriliyor
                        </div>
                        <div class="pagination-wrapper">
                            {{ $slides->links() }}
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
                <h5 class="modal-title">Slayt Düzenle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editForm" enctype="multipart/form-data">
                    <input type="hidden" id="editId">
                    <div class="row">
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
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editTitle" class="form-label">Başlık</label>
                                <input type="text" class="form-control" id="editTitle" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editDescription" class="form-label">Açıklama</label>
                                <textarea class="form-control" id="editDescription" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editEngDescription" class="form-label">Açıklama (İngilizce)</label>
                                <textarea class="form-control" id="editEngDescription" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editDescription1" class="form-label">Açıklama 1</label>
                                <textarea class="form-control" id="editDescription1" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editEngDescription1" class="form-label">Açıklama 1 (İngilizce)</label>
                                <textarea class="form-control" id="editEngDescription1" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="editPhoto" class="form-label">Foto</label>
                                <input type="file" class="form-control" id="editPhoto">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="editLink" class="form-label">Link</label>
                                <input type="text" class="form-control" id="editLink">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="editStyle" class="form-label">Style</label>
                                <input type="text" class="form-control" id="editStyle">
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

.order-input {
    min-width: 60px;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Düzenleme modalını aç
    $('.edit-btn').click(function() {
        const id = $(this).data('id');
        const sectionId = $(this).data('section-id');
        const title = $(this).data('title');
        const eng = $(this).data('eng');
        const description = $(this).data('description');
        const engDescription = $(this).data('eng-description');
        const description1 = $(this).data('description1');
        const engDescription1 = $(this).data('eng-description1');
        const link = $(this).data('link');
        const style = $(this).data('style');

        $('#editId').val(id);
        $('#editSectionId').val(sectionId);
        $('#editTitle').val(title);
        $('#editDescription').val(description);
        $('#editEngDescription').val(engDescription);
        $('#editDescription1').val(description1);
        $('#editEngDescription1').val(engDescription1);
        $('#editLink').val(link);
        $('#editStyle').val(style);
        $('#editModal').modal('show');
    });

    // Düzenlemeyi kaydet
    $('#saveEdit').click(function() {
        const id = $('#editId').val();
        const formData = new FormData();
        
        formData.append('section_id', $('#editSectionId').val());
        formData.append('title', $('#editTitle').val());
        formData.append('eng', $('#editEng').val());
        formData.append('description', $('#editDescription').val());
        formData.append('eng_description', $('#editEngDescription').val());
        formData.append('description1', $('#editDescription1').val());
        formData.append('eng_description1', $('#editEngDescription1').val());
        formData.append('link', $('#editLink').val());
        formData.append('style', $('#editStyle').val());
        
        if ($('#editPhoto')[0].files[0]) {
            formData.append('photo', $('#editPhoto')[0].files[0]);
        }

        formData.append('_method', 'PUT');

        $.ajax({
            url: `/definitions/slides/${id}`,
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

    // Sıra güncelleme
    $('.order-input').change(function() {
        const id = $(this).data('id');
        const order = $(this).val();

        $.ajax({
            url: `/definitions/slides/${id}`,
            type: 'PUT',
            data: { order },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    location.reload();
                }
            },
            error: function(xhr) {
                alert('Sıra güncellenirken bir hata oluştu.');
            }
        });
    });

    // Silme işlemi
    $('.delete-btn').click(function() {
        const id = $(this).data('id');
        
        if (confirm('Bu slaytı silmek istediğinizden emin misiniz?')) {
            $.ajax({
                url: `/definitions/slides/${id}`,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    }
                },
                error: function(xhr) {
                    alert('Silme işlemi sırasında bir hata oluştu.');
                }
            });
        }
    });
});
</script>
@endpush 