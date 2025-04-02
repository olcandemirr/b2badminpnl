@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Gelen Mesajlar</h3>
                </div>
                <div class="card-body">
                    <!-- Arama Formu -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <form action="{{ route('messages.inbox') }}" method="GET" class="search-form">
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
                                    <th style="width: 50px">
                                        <div class="d-flex align-items-center">
                                            <input type="checkbox" class="form-check-input me-2" id="selectAll">
                                            Oku
                                        </div>
                                    </th>
                                    <th>Tarih</th>
                                    <th>No</th>
                                    <th>Bayi</th>
                                    <th>SipNo</th>
                                    <th>Türü</th>
                                    <th>Konu</th>
                                    <th style="width: 100px">Mesaj</th>
                                    <th style="width: 50px">Sil</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($messages as $message)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <input type="checkbox" class="form-check-input me-2 message-checkbox" value="{{ $message->id }}">
                                            <button type="button" class="btn btn-sm {{ $message->is_read ? 'btn-secondary' : 'btn-success' }}" 
                                                data-message-id="{{ $message->id }}"
                                                onclick="markAsRead('{{ $message->id }}')">
                                                <i class="fas {{ $message->is_read ? 'fa-envelope-open' : 'fa-envelope' }}"></i>
                                            </button>
                                        </div>
                                    </td>
                                    <td>{{ $message->created_at->format('d.m.Y H:i') }}</td>
                                    <td>{{ $message->id }}</td>
                                    <td>{{ $message->dealer->company_title }}</td>
                                    <td>{{ $message->order_id ?? '-' }}</td>
                                    <td>{{ $message->type ?? 'Genel' }}</td>
                                    <td>{{ $message->subject }}</td>
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
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Tümünü seç checkbox'ı
    $('#selectAll').change(function() {
        $('.message-checkbox').prop('checked', $(this).prop('checked'));
    });

    // Tekil checkbox'lar değiştiğinde tümünü seç'i kontrol et
    $('.message-checkbox').change(function() {
        if ($('.message-checkbox:checked').length === $('.message-checkbox').length) {
            $('#selectAll').prop('checked', true);
        } else {
            $('#selectAll').prop('checked', false);
        }
    });
});

// Mesajı okundu olarak işaretle
function markAsRead(id) {
    $.ajax({
        url: `/messages/${id}/read`,
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                location.reload();
            }
        },
        error: function(xhr) {
            alert('Bir hata oluştu. Lütfen tekrar deneyin.');
        }
    });
}

// Mesaj detayını göster
function showMessage(id) {
    $.ajax({
        url: `/messages/${id}`,
        type: 'GET',
        success: function(response) {
            let html = `
                <div class="mb-3">
                    <strong>Gönderen:</strong> ${response.sender}<br>
                    <strong>Bayi:</strong> ${response.dealer}<br>
                    <strong>Tarih:</strong> ${response.created_at}<br>
                    <strong>Konu:</strong> ${response.subject}
                </div>
                <div class="message-content">
                    ${response.message}
                </div>
            `;
            $('.message-details').html(html);
            $('#messageModal').modal('show');
            
            // Mesajı okundu olarak işaretle
            markAsRead(id);
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