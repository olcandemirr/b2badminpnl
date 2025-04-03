@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Kategori Ekle</h3>
                </div>
                <div class="card-body">
                    <!-- Kategori Ekleme Formu -->
                    <form id="categoryForm" action="{{ route('definitions.categories.store') }}" method="POST" enctype="multipart/form-data">
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
                                    <label for="name" class="form-label">Kategori</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="file" class="form-label">Dosya</label>
                                    <input type="file" class="form-control" id="file" name="file">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">EKLE</button>
                    </form>

                    <!-- Kategoriler Tablosu -->
                    <div class="table-responsive mt-4">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Bölüm</th>
                                    <th>En</th>
                                    <th>Kategori</th>
                                    <th>En</th>
                                    <th>Dosya</th>
                                    <th>Sıra</th>
                                    <th>Oran%</th>
                                    <th>Link</th>
                                    <th>Düz.</th>
                                    <th>Sil</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->section->name }}</td>
                                    <td>{{ $category->section->eng }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->eng }}</td>
                                    <td>
                                        @if($category->file)
                                            <img src="{{ asset('uploads/categories/' . $category->file) }}" 
                                                alt="Kategori Görseli" 
                                                style="max-width: 50px; max-height: 50px;">
                                        @endif
                                    </td>
                                    <td>
                                        <input type="number" class="form-control form-control-sm order-input" 
                                            value="{{ $category->order }}" 
                                            data-id="{{ $category->id }}" 
                                            style="width: 80px">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control form-control-sm percentage-input" 
                                            value="{{ $category->percentage }}" 
                                            data-id="{{ $category->id }}" 
                                            style="width: 80px">
                                    </td>
                                    <td>{{ $category->link }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-info edit-btn" 
                                            data-id="{{ $category->id }}"
                                            data-section-id="{{ $category->section_id }}"
                                            data-name="{{ $category->name }}"
                                            data-eng="{{ $category->eng }}"
                                            data-percentage="{{ $category->percentage }}"
                                            data-link="{{ $category->link }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-danger delete-btn" 
                                            data-id="{{ $category->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="11" class="text-center">Veri Bulunamadı</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div>
                            {{ $categories->total() }} kayıttan {{ $categories->firstItem() ?? 0 }} ile {{ $categories->lastItem() ?? 0 }} arası gösteriliyor
                        </div>
                        <div class="pagination-wrapper">
                            {{ $categories->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Düzenleme Modal -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kategori Düzenle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editForm" enctype="multipart/form-data">
                    <input type="hidden" id="editId">
                    <div class="mb-3">
                        <label for="editSectionId" class="form-label">Bölüm</label>
                        <select class="form-select" id="editSectionId" required>
                            @foreach($sections as $section)
                                <option value="{{ $section->id }}">{{ $section->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editName" class="form-label">Kategori</label>
                        <input type="text" class="form-control" id="editName" required>
                    </div>
                    <div class="mb-3">
                        <label for="editEng" class="form-label">İngilizce</label>
                        <input type="text" class="form-control" id="editEng">
                    </div>
                    <div class="mb-3">
                        <label for="editFile" class="form-label">Dosya</label>
                        <input type="file" class="form-control" id="editFile">
                    </div>
                    <div class="mb-3">
                        <label for="editPercentage" class="form-label">Oran (%)</label>
                        <input type="number" class="form-control" id="editPercentage" step="0.01">
                    </div>
                    <div class="mb-3">
                        <label for="editLink" class="form-label">Link</label>
                        <input type="text" class="form-control" id="editLink">
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

.order-input,
.percentage-input {
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
        const name = $(this).data('name');
        const eng = $(this).data('eng');
        const percentage = $(this).data('percentage');
        const link = $(this).data('link');

        $('#editId').val(id);
        $('#editSectionId').val(sectionId);
        $('#editName').val(name);
        $('#editEng').val(eng);
        $('#editPercentage').val(percentage);
        $('#editLink').val(link);
        $('#editModal').modal('show');
    });

    // Düzenlemeyi kaydet
    $('#saveEdit').click(function() {
        const id = $('#editId').val();
        const formData = new FormData();
        
        formData.append('section_id', $('#editSectionId').val());
        formData.append('name', $('#editName').val());
        formData.append('eng', $('#editEng').val());
        formData.append('percentage', $('#editPercentage').val());
        formData.append('link', $('#editLink').val());
        
        if ($('#editFile')[0].files[0]) {
            formData.append('file', $('#editFile')[0].files[0]);
        }

        formData.append('_method', 'PUT');

        $.ajax({
            url: `/definitions/categories/${id}`,
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
            url: `/definitions/categories/${id}`,
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

    // Yüzde güncelleme
    $('.percentage-input').change(function() {
        const id = $(this).data('id');
        const percentage = $(this).val();

        $.ajax({
            url: `/definitions/categories/${id}`,
            type: 'PUT',
            data: { percentage },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    location.reload();
                }
            },
            error: function(xhr) {
                alert('Oran güncellenirken bir hata oluştu.');
            }
        });
    });

    // Silme işlemi
    $('.delete-btn').click(function() {
        const id = $(this).data('id');
        
        if (confirm('Bu kategoriyi silmek istediğinizden emin misiniz?')) {
            $.ajax({
                url: `/definitions/categories/${id}`,
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