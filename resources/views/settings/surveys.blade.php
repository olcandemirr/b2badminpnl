@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Anket Yönetim Paneli</h3>
                    <button type="button" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> ANKETİ SIRALA
                    </button>
                </div>
                <div class="card-body">
                    <form action="{{ route('settings.surveys.update') }}" method="POST">
                        @csrf
                        
                        <!-- Anket Başlığı -->
                        <div class="mb-4">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Anket Başlığı</label>
                                    <input type="text" class="form-control" name="survey_title" placeholder="Ürünlerimiz Hakkında Ne Düşünüyorsunuz?">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">ENG</label>
                                    <input type="text" class="form-control" name="survey_title_en" placeholder="What Do You Think About Our Products?">
                                </div>
                            </div>
                        </div>

                        <!-- Yeni Seçenek Ekle -->
                        <div class="mb-4">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Yeni Seçenek Ekle</label>
                                    <input type="text" class="form-control" name="new_option">
                                </div>
                                <div class="col-md-6 d-flex align-items-end">
                                    <button type="button" class="btn btn-success">
                                        <i class="fas fa-plus me-1"></i> Ekle
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Seçenek Listesi -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Seçenek</th>
                                        <th>Eng</th>
                                        <th>Oy Sayısı</th>
                                        <th>Güncelle</th>
                                        <th>Sil</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Veriler buraya gelecek -->
                                </tbody>
                            </table>
                        </div>
                    </form>
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
    font-weight: 600;
}

.table td, .table th {
    vertical-align: middle;
}

.btn-icon {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}

.btn-success {
    background-color: #28a745;
    border-color: #28a745;
    color: white;
}

.btn-success:hover {
    background-color: #218838;
    border-color: #1e7e34;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Anket seçeneği ekleme ve düzenleme işlemleri burada yapılacak
});
</script>
@endpush 