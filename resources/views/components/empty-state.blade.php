<div class="marketplace-empty">
    <i class="{{ $icon ?? 'ti-package' }}"></i>
    <h3>{{ $title ?? 'Belum ada data' }}</h3>
    <p>{{ $message ?? 'Coba kembali lagi nanti.' }}</p>
    @isset($actionUrl)
        <a href="{{ $actionUrl }}" class="btn">{{ $actionLabel ?? 'Mulai Jelajah' }}</a>
    @endisset
</div>
