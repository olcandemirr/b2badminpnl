@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Aktarım</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                Aktarım yapmak istediğiniz işlemi seçin ve "AKTARIMA BAŞLA" butonuna tıklayın.
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Aktarım Tipi</th>
                                            <th>İşlem</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>GENELBAYILER</td>
                                            <td>
                                                <button type="button" class="btn btn-primary btn-sm transfer-btn" data-type="GENELBAYILER">
                                                    AKTARIMA BAŞLA
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>İŞG GV</td>
                                            <td>
                                                <button type="button" class="btn btn-primary btn-sm transfer-btn" data-type="ISG_GV">
                                                    AKTARIMA BAŞLA
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>OTO TAMİR</td>
                                            <td>
                                                <button type="button" class="btn btn-primary btn-sm transfer-btn" data-type="OTO_TAMIR">
                                                    AKTARIMA BAŞLA
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>x01</td>
                                            <td>
                                                <button type="button" class="btn btn-primary btn-sm transfer-btn" data-type="X01">
                                                    AKTARIMA BAŞLA
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
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
                    <p id="statusMessage">Aktarım işlemi devam ediyor...</p>
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

.alert {
    margin-bottom: 1.5rem;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    $('.transfer-btn').click(function() {
        const button = $(this);
        const type = button.data('type');
        
        // Butonu devre dışı bırak
        button.prop('disabled', true);
        
        // Modal'ı göster
        $('#statusModal').modal('show');
        
        // Aktarım isteğini gönder
        $.ajax({
            url: '{{ route("definitions.transfer.start") }}',
            type: 'POST',
            data: {
                type: type,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    $('#statusMessage').html('<span class="text-success"><i class="fas fa-check-circle"></i> ' + response.message + '</span>');
                    setTimeout(function() {
                        $('#statusModal').modal('hide');
                        button.prop('disabled', false);
                    }, 2000);
                }
            },
            error: function(xhr) {
                $('#statusMessage').html('<span class="text-danger"><i class="fas fa-times-circle"></i> Aktarım sırasında bir hata oluştu.</span>');
                setTimeout(function() {
                    $('#statusModal').modal('hide');
                    button.prop('disabled', false);
                }, 2000);
            }
        });
    });

    // Modal kapandığında mesajı sıfırla
    $('#statusModal').on('hidden.bs.modal', function() {
        $('#statusMessage').text('Aktarım işlemi devam ediyor...');
    });
});
</script>
@endpush 