@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Bayi Yönetimi</h3>
                    <div class="input-group" style="width: 300px;">
                        <input type="text" class="form-control" placeholder="Ürün Arayın...">
                        <button class="btn btn-outline-secondary" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Filtreler -->
                    <div class="row mb-4">
                        <div class="col-md-2">
                            <button class="btn btn-primary" id="anaBayi">
                                Ana Bayi <span class="badge bg-light text-dark">1</span>
                            </button>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary" id="altBayi">
                                Alt Bayi <span class="badge bg-light text-dark">1</span>
                            </button>
                        </div>
                        <div class="col-md-7">
                            <input type="text" class="form-control" id="searchQuery" placeholder="Aranacak bilgi girin...">
                        </div>
                        <div class="col-md-1">
                            <button class="btn btn-primary w-100" id="searchButton">
                                <i class="fas fa-search"></i> SORGULA
                            </button>
                        </div>
                    </div>

                    <!-- Excel Export Butonu -->
                    <div class="mb-3">
                        <button class="btn btn-purple" id="exportExcel">
                            <i class="fas fa-file-excel"></i> Excele Aktar
                        </button>
                    </div>

                    <!-- Bayiler Tablosu -->
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Düz</th>
                                    <th>No</th>
                                    <th>BayiNo</th>
                                    <th>Ünvan</th>
                                    <th>KulAdı</th>
                                    <th>BayiTip</th>
                                    <th>AnaBayi</th>
                                    <th>Sepet</th>
                                    <th>Login</th>
                                    <th>Adres</th>
                                    <th>Durumu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($dealers ?? [] as $dealer)
                                <tr>
                                    <td>
                                        <button class="btn btn-sm btn-secondary">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $dealer->dealer_no ?? '' }}</td>
                                    <td>{{ $dealer->company_title ?? '' }}</td>
                                    <td>{{ $dealer->username ?? '' }}</td>
                                    <td>{{ $dealer->dealer_type ?? '' }}</td>
                                    <td>{{ $dealer->main_dealer ?? '' }}</td>
                                    <td>{{ $dealer->basket ?? '' }}</td>
                                    <td>{{ $dealer->login ?? '' }}</td>
                                    <td>{{ $dealer->address ?? '' }}</td>
                                    <td>
                                        @if($dealer->status ?? false)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-danger">Pasif</span>
                                        @endif
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
                            Gösteriliyor {{ $dealers->firstItem() ?? 0 }} ile {{ $dealers->lastItem() ?? 0 }} arası {{ $dealers->total() ?? 0 }} kayıttan
                        </div>
                        <div>
                            {{ $dealers->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .btn-purple {
        background-color: #6f42c1;
        color: white;
    }
    .btn-purple:hover {
        background-color: #5a32a3;
        color: white;
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Ana Bayi ve Alt Bayi butonları tıklama
    $('#anaBayi, #altBayi').click(function() {
        $(this).toggleClass('active');
        // Filtreleme işlemi yapılacak
    });

    // Sorgula butonu tıklama
    $('#searchButton').click(function() {
        const searchQuery = $('#searchQuery').val();
        window.location.href = `/dealers?search=${searchQuery}`;
    });

    // Excel export butonu tıklama
    $('#exportExcel').click(function() {
        const searchQuery = $('#searchQuery').val();
        window.location.href = `/dealers/export?search=${searchQuery}`;
    });
});
</script>
@endpush 