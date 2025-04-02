@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">MESAJ YAZ</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('messages.store') }}" method="POST">
                        @csrf
                        
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label>Bayi Seçin</label>
                                <select class="form-select" name="dealer_id" required>
                                    <option value="">Bayi Seçin</option>
                                    @foreach($dealers as $dealer)
                                        <option value="{{ $dealer->id }}">{{ $dealer->company_title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label>Konu</label>
                                <input type="text" class="form-control" name="subject" required>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label>Mesaj</label>
                                <textarea class="form-control" name="message" rows="6" required></textarea>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="send_as_email" id="sendAsEmail">
                                    <label class="form-check-label" for="sendAsEmail">
                                        Mail Olarakta Gönder
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Mesajı Gönder</button>
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

.form-label {
    font-weight: 500;
}
</style>
@endpush 