@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Parametreler</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('settings.parameters.update') }}" method="POST">
                        @csrf
                        
                        <!-- Parametre Ekle -->
                        <div class="mb-4">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label">Tür</label>
                                    <input type="text" class="form-control" name="type">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">TESLİMAT</label>
                                    <input type="text" class="form-control" name="delivery">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Değer</label>
                                    <input type="text" class="form-control" name="value">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Açıklama</label>
                                    <input type="text" class="form-control" name="description">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">En</label>
                                    <input type="text" class="form-control" name="en">
                                </div>
                                <div class="col-md-3 d-flex align-items-end">
                                    <button type="button" class="btn btn-primary">
                                        <i class="fas fa-plus me-1"></i> Ekle
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Parametre Listesi -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tür</th>
                                        <th>Değer</th>
                                        <th>Açıklama</th>
                                        <th>En</th>
                                        <th>Düz.</th>
                                        <th>Sil</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Veriler buraya gelecek -->
                                </tbody>
                            </table>
                        </div>

                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Değişikleri Kaydet
                            </button>
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
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Parametre ekleme ve düzenleme işlemleri burada yapılacak
});
</script>
@endpush 