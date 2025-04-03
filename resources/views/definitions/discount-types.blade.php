@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">İskonto Tip Ekle</h3>
                </div>
                <div class="card-body">
                    <!-- İskonto Tipi Ekleme Formu -->
                    <form action="{{ route('definitions.discount-types.store') }}" method="POST" class="mb-4">
                        @csrf
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="name" class="form-label">İskonto Tipi</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="eng" class="form-label">İskonto Tipi (İngilizce)</label>
                                    <input type="text" class="form-control" id="eng" name="eng">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="rate" class="form-label">Oran</label>
                                    <input type="number" class="form-control" id="rate" name="rate" step="0.01" min="0" max="100" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">&nbsp;</label>
                                    <button type="submit" class="btn btn-primary w-100">EKLE</button>
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
                                    <label for="eng_description" class="form-label">Açıklama (İngilizce)</label>
                                    <textarea class="form-control" id="eng_description" name="eng_description" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- İskonto Tipleri Tablosu -->
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>İskonto Tipi</th>
                                    <th>İskonto Tipi (İng)</th>
                                    <th>Açıklama</th>
                                    <th>Açıklama (İng)</th>
                                    <th>Oran</th>
                                    <th>Düz.</th>
                                    <th>Sil</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($discountTypes as $type)
                                <tr>
                                    <td>{{ $type->id }}</td>
                                    <td>{{ $type->name }}</td>
                                    <td>{{ $type->eng }}</td>
                                    <td>{{ $type->description }}</td>
                                    <td>{{ $type->eng_description }}</td>
                                    <td>{{ $type->rate }}%</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-info edit-btn" 
                                            data-id="{{ $type->id }}"
                                            data-name="{{ $type->name }}"
                                            data-eng="{{ $type->eng }}"
                                            data-description="{{ $type->description }}"
                                            data-eng-description="{{ $type->eng_description }}"
                                            data-rate="{{ $type->rate }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="{{ $type->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">Veri Bulunamadı</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div>
                            {{ $discountTypes->total() }} kayıttan {{ $discountTypes->firstItem() ?? 0 }} ile {{ $discountTypes->lastItem() ?? 0 }} arası gösteriliyor
                        </div>
                        <div class="pagination-wrapper">
                            {{ $discountTypes->links() }}
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
                <h5 class="modal-title">İskonto Tipi Düzenle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editForm">
                    <input type="hidden" id="editId">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editName" class="form-label">İskonto Tipi</label>
                                <input type="text" class="form-control" id="editName" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editEng" class="form-label">İskonto Tipi (İngilizce)</label>
                                <input type="text" class="form-control" id="editEng">
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
                                <label for="editRate" class="form-label">Oran</label>
                                <input type="number" class="form-control" id="editRate" step="0.01" min="0" max="100" required>
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
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Düzenleme modalını aç
    $('.edit-btn').click(function() {
        const id = $(this).data('id');
        const name = $(this).data('name');
        const eng = $(this).data('eng');
        const description = $(this).data('description');
        const engDescription = $(this).data('eng-description');
        const rate = $(this).data('rate');

        $('#editId').val(id);
        $('#editName').val(name);
        $('#editEng').val(eng);
        $('#editDescription').val(description);
        $('#editEngDescription').val(engDescription);
        $('#editRate').val(rate);
        $('#editModal').modal('show');
    });

    // Düzenlemeyi kaydet
    $('#saveEdit').click(function() {
        const id = $('#editId').val();
        const data = {
            name: $('#editName').val(),
            eng: $('#editEng').val(),
            description: $('#editDescription').val(),
            eng_description: $('#editEngDescription').val(),
            rate: $('#editRate').val(),
            _method: 'PUT'
        };

        $.ajax({
            url: `/definitions/discount-types/${id}`,
            type: 'POST',
            data: data,
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

    // Silme işlemi
    $('.delete-btn').click(function() {
        if (confirm('Bu iskonto tipini silmek istediğinizden emin misiniz?')) {
            const id = $(this).data('id');
            
            $.ajax({
                url: `/definitions/discount-types/${id}`,
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