@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Gönderilen Mesajlar</h3>
                </div>
                <div class="card-body">
                    <!-- Arama Formu -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <form action="{{ route('messages.sent') }}" method="GET" class="search-form">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Aranacak bilgi girin..." value="{{ request('search') }}">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search me-1"></i>
                                        SORGULA
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Mesaj Tablosu -->
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Tarih</th>
                                    <th>No</th>
                                    <th>Bayi</th>
                                    <th>SipNo</th>
                                    <th>Türü</th>
                                    <th>Konu</th>
                                    <th>Email</th>
                                    <th style="width: 100px">Mesaj</th>
                                    <th style="width: 50px">Sil</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($messages as $message)
                                <tr>
                                    <td>{{ $message->created_at->format('d.m.Y H:i') }}</td>
                                    <td>{{ $message->id }}</td>
                                    <td>{{ $message->dealer->company_title ?? 'Belirtilmemiş' }}</td>
                                    <td>{{ $message->order_id ?? '-' }}</td>
                                    <td>{{ $message->type ?? 'Genel' }}</td>
                                    <td>{{ $message->subject }}</td>
                                    <td>
                                        @if($message->is_sent_as_email)
                                            <span class="badge bg-success">Gönderildi</span>
                                        @else
                                            <span class="badge bg-warning">Bekliyor</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-info" 
                                            data-message-id="{{ $message->id }}"
                                            onclick="showMessage('{{ $message->id }}')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-danger" 
                                            data-message-id="{{ $message->id }}"
                                            onclick="deleteMessage('{{ $message->id }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center">Veri Bulunamadı</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div>
                            {{ $messages->total() }} kayıttan {{ $messages->firstItem() ?? 0 }} ile {{ $messages->lastItem() ?? 0 }} arası gösteriliyor
                        </div>
                        <div class="pagination-wrapper">
                            <button class="btn btn-sm btn-outline-secondary me-2" 
                                {{ $messages->onFirstPage() ? 'disabled' : '' }}
                                onclick="window.location='{{ $messages->previousPageUrl() }}'">
                                Önceki
                            </button>
                            <span class="btn btn-sm btn-primary">{{ $messages->currentPage() }}</span>
                            <button class="btn btn-sm btn-outline-secondary ms-2" 
                                {{ !$messages->hasMorePages() ? 'disabled' : '' }}
                                onclick="window.location='{{ $messages->nextPageUrl() }}'">
                                Sonraki
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Mesaj Detay Modal -->
<div class="modal fade" id="messageModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Mesaj Detayı</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="message-details">
                    <!-- Mesaj detayları JavaScript ile doldurulacak -->
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

.search-form {
    max-width: 100%;
}

.search-form .input-group {
    width: 100%;
}

.search-form .form-control {
    border-radius: 4px 0 0 4px;
}

.search-form .btn {
    border-radius: 0 4px 4px 0;
    padding: 8px 20px;
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

.pagination-wrapper {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.message-details {
    font-size: 0.95rem;
    line-height: 1.6;
}

.badge {
    font-size: 0.85rem;
    padding: 0.35em 0.65em;
}
</style>
@endpush

@push('scripts')
<script>
// Mesaj detayını göster
function showMessage(id) {
    $.ajax({
        url: `/messages/${id}`,
        type: 'GET',
        success: function(response) {
            let html = `
                <div class="mb-3">
                    <strong>Alıcı:</strong> ${response.receiver}<br>
                    <strong>Bayi:</strong> ${response.dealer}<br>
                    <strong>Tarih:</strong> ${response.created_at}<br>
                    <strong>Konu:</strong> ${response.subject}<br>
                    <strong>Email Durumu:</strong> ${response.is_sent_as_email ? '<span class="badge bg-success">Gönderildi</span>' : '<span class="badge bg-warning">Bekliyor</span>'}
                </div>
                <div class="message-content">
                    ${response.message}
                </div>
            `;
            $('.message-details').html(html);
            $('#messageModal').modal('show');
        },
        error: function(xhr) {
            alert('Mesaj detayı yüklenirken bir hata oluştu.');
        }
    });
}

// Mesajı sil
function deleteMessage(id) {
    if (confirm('Bu mesajı silmek istediğinizden emin misiniz?')) {
        $.ajax({
            url: `/messages/${id}`,
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
                alert('Mesaj silinirken bir hata oluştu.');
            }
        });
    }
}
</script>
@endpush 