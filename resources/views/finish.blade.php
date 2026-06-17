@extends('layouts.app')

@section('content')
<main class="marketplace-page">
    <div class="container">
        <section class="success-panel">
            <i class="ti-check-box"></i>
            <h1>Pesanan berhasil dibuat</h1>
            <p class="marketplace-muted">Kami sedang menyiapkan pesananmu. Lanjutkan konfirmasi pembayaran melalui WhatsApp toko.</p>
            <div class="marketplace-panel mt-4 mb-4 text-left">
                <div class="summary-row">
                    <span>Nomor Pesanan</span>
                    <strong>{{ $trans['invoice'] ?? '-' }}</strong>
                </div>
                <div class="summary-row summary-total">
                    <span>Total</span>
                    <strong>Rp{{ price($trans['total'] ?? 0) }}</strong>
                </div>
            </div>
            <a class="btn" href="http://api.whatsapp.com/send?phone={{ config('app.whatsapp') }}&text=Hai, {{ config('app.name') }} pesanan saya sudah di buat dengan nomor pesanan {{ $trans['invoice'] ?? '' }}, dengan total pemesanan sebesar Rp.{{ price($trans['total'] ?? 0) }}.-" target="_blank" rel="noopener">
                Konfirmasi via WhatsApp
            </a>
            <a class="btn marketplace-icon-btn ml-2" href="{{ route('product') }}">Belanja Lagi</a>
        </section>
    </div>
</main>

@include('components.trust-strip')
@endsection
