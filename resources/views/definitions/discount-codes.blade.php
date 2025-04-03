@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">İskonto Kod Tanım</h3>
                </div>
                <div class="card-body">
                    <!-- İskonto Kodu Ekleme Formu -->
                    <form action="{{ route('definitions.discount-codes.store') }}" method="POST" class="mb-4">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="code" class="form-label">İskonto Kodu</label>
                                    <input type="text" class="form-control" id="code" name="code" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="description" class="form-label">Açıklama</label>
                                    <input type="text" class="form-control" id="description" name="description">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="rate" class="form-label">Oran</label>
                                    <input type="number" class="form-control" id="rate" name="rate" step="0.01" min="0" max="100" required>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="mb-3">
                                    <label class="form-label">&nbsp;</label>
                                    <button type="submit" class="btn btn-primary w-100">EKLE</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- İskonto Kodları Tablosu -->
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Kod</th>
                                    <th>Açıklama</th>
                                    <th>Oran</th>
                                    <th>Düz.</th>
                                    <th>Sil</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($discountCodes as $code)
                                <tr>
                                    <td>{{ $code->id }}</td>
                                    <td>{{ $code->code }}</td>
                                    <td>{{ $code->description }}</td>
                                    <td>{{ $code->rate }}%</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-info edit-btn" 
                                            data-id="{{ $code->id }}"
                                            data-code="{{ $code->code }}"
                                            data-description="{{ $code->description }}"
                                            data-rate="{{ $code->rate }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="{{ $code->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">Veri Bulunamadı</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div>
                            {{ $discountCodes->total() }} kayıttan {{ $discountCodes->firstItem() ?? 0 }} ile {{ $discountCodes->lastItem() ?? 0 }} arası gösteriliyor
                        </div>
                        <div class="pagination-wrapper">
                            {{ $discountCodes->links() }}
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
                <h5 class="modal-title">İskonto Kodu Düzenle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editForm">
                    <input type="hidden" id="editId">
                    <div class="mb-3">
                        <label for="editCode" class="form-label">İskonto Kodu</label>
                        <input type="text" class="form-control" id="editCode" required>
                    </div>
                    <div class="mb-3">
                        <label for="editDescription" class="form-label">Açıklama</label>
                        <input type="text" class="form-control" id="editDescription">
                    </div>
                    <div class="mb-3">
                        <label for="editRate" class="form-label">Oran</label>
                        <input type="number" class="form-control" id="editRate" step="0.01" min="0" max="100" required>
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
        const code = $(this).data('code');
        const description = $(this).data('description');
        const rate = $(this).data('rate');

        $('#editId').val(id);
        $('#editCode').val(code);
        $('#editDescription').val(description);
        $('#editRate').val(rate);
        $('#editModal').modal('show');
    });

    // Düzenlemeyi kaydet
    $('#saveEdit').click(function() {
        const id = $('#editId').val();
        const data = {
            code: $('#editCode').val(),
            description: $('#editDescription').val(),
            rate: $('#editRate').val(),
            _method: 'PUT'
        };

        $.ajax({
            url: `/definitions/discount-codes/${id}`,
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
        if (confirm('Bu iskonto kodunu silmek istediğinizden emin misiniz?')) {
            const id = $(this).data('id');
            
            $.ajax({
                url: `/definitions/discount-codes/${id}`,
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