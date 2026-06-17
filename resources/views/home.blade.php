@extends('layouts.app')

@section('content')
<main class="marketplace-page">
    <div class="container">
        <section class="marketplace-section marketplace-hero">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <span class="marketplace-badge">Marketplace fashion lokal</span>
                    <h1>Temukan produk yang cocok dengan gaya belanjamu.</h1>
                    <p>Jelajahi kategori populer, dapatkan rekomendasi personal, lalu tambah produk ke keranjang tanpa ribet.</p>
                </div>
                <div class="col-lg-5 mt-3 mt-lg-0">
                    <form action="{{ route('product') }}" class="d-flex">
                        <input type="search" name="search" class="form-control mr-2" placeholder="Cari produk, toko, atau kategori..." aria-label="Cari produk">
                        <button class="btn" type="submit">Cari</button>
                    </form>
                </div>
            </div>
        </section>

        <section class="marketplace-section">
            <div class="marketplace-title-row">
                <div>
                    <h2>Kategori Populer</h2>
                    <p>Pilih kategori dan mulai jelajah produk fashion.</p>
                </div>
                <a href="{{ route('product') }}">Lihat semua</a>
            </div>
            @include('components.category-shortcuts', ['categories' => $categoryShortcuts ?? []])
        </section>

        <section class="marketplace-section marketplace-panel">
            <div class="marketplace-title-row">
                <div>
                    <h2>Dapatkan Rekomendasi Produk</h2>
                    <p>Isi preferensimu agar sistem membantu memilih produk yang lebih relevan.</p>
                </div>
            </div>

            <form method="post">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="umur">Kelompok Umur</label>
                            <select id="umur" name="umur" class="form-control" required>
                                <option value="" disabled {{ empty($formInput['umur']) ? 'selected' : '' }}>Pilih kelompok umur</option>
                                @foreach (['18-24','25-34','35+'] as $age)
                                    <option value="{{ $age }}" {{ !empty($formInput['umur']) && $formInput['umur'] === $age ? 'selected' : '' }}>{{ $age }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <select id="gender" name="gender" class="form-control" required>
                                <option value="" disabled {{ empty($formInput['gender']) ? 'selected' : '' }}>Pilih gender</option>
                                @foreach (['m' => 'Laki-laki','f' => 'Perempuan'] as $val => $label)
                                    <option value="{{ $val }}" {{ !empty($formInput['gender']) && $formInput['gender'] === $val ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="kategori">Gaya / Kategori Favorit</label>
                            <select id="kategori" name="kategori" class="form-control" required>
                                <option value="" disabled {{ empty($formInput['kategori']) ? 'selected' : '' }}>Pilih kategori</option>
                                @foreach ($kategoriList as $slug => $label)
                                    <option value="{{ $slug }}" {{ !empty($formInput['kategori']) && $formInput['kategori'] === $slug ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-md-0">
                            <label for="buy_freq">Frekuensi Belanja</label>
                            <select id="buy_freq" name="buy_freq" class="form-control" required>
                                <option value="" disabled {{ empty($formInput['buy_freq']) ? 'selected' : '' }}>Pilih frekuensi</option>
                                @foreach ($buyFreqList as $freq)
                                    <option value="{{ $freq }}" {{ !empty($formInput['buy_freq']) && $formInput['buy_freq'] === $freq ? 'selected' : '' }}>{{ $freq }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-md-0">
                            <label for="budget_band">Budget per Transaksi</label>
                            <select id="budget_band" name="budget_band" class="form-control" required>
                                <option value="" disabled {{ empty($formInput['budget_band']) ? 'selected' : '' }}>Pilih budget</option>
                                @foreach ($budgetBandList as $budget)
                                    <option value="{{ $budget }}" {{ !empty($formInput['budget_band']) && $formInput['budget_band'] === $budget ? 'selected' : '' }}>{{ $budget }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-block">Tampilkan Rekomendasi</button>
                    </div>
                </div>
            </form>
        </section>

        @if(request()->isMethod('POST'))
            <section class="marketplace-section">
                <div class="marketplace-title-row">
                    <div>
                        <h2>Rekomendasi Untukmu</h2>
                        <p>Produk pilihan berdasarkan preferensi belanjamu.</p>
                    </div>
                </div>
                @if(!empty($naivebayes))
                    <div class="row marketplace-grid">
                        @foreach ($naivebayes as $product)
                            @include('components.product-card', ['product' => $product, 'imagePrefix' => '03_'])
                        @endforeach
                    </div>
                @else
                    @include('components.empty-state', [
                        'icon' => 'ti-search',
                        'title' => 'Belum ada rekomendasi',
                        'message' => 'Coba ubah kategori atau preferensi lain, ya.',
                        'actionUrl' => route('product'),
                        'actionLabel' => 'Jelajah Produk'
                    ])
                @endif
            </section>
        @endif

        <section class="marketplace-section">
            <div class="marketplace-title-row">
                <div>
                    <h2>Produk Terbaru</h2>
                    <p>Barang baru yang siap kamu masukkan ke keranjang.</p>
                </div>
                <a href="{{ route('product') }}">Lihat semua produk</a>
            </div>
            @if(!empty($products))
                <div class="row marketplace-grid">
                    @foreach ($products as $product)
                        @include('components.product-card', ['product' => $product, 'imagePrefix' => '03_'])
                    @endforeach
                </div>
            @else
                @include('components.empty-state', [
                    'title' => 'Belum ada produk',
                    'message' => 'Produk akan tampil di sini setelah toko menambahkannya.'
                ])
            @endif
        </section>
    </div>
</main>

@include('components.trust-strip')
@endsection
