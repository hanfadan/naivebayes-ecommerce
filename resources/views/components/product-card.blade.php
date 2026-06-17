@php
    $id = data_get($product, 'id');
    $name = data_get($product, 'name', 'Produk');
    $description = data_get($product, 'description', '');
    $image = data_get($product, 'image') ?: 'no-image.jpg';
    $priceValue = data_get($product, 'price', 0);
    $category = data_get($product, 'category', 'Fashion lokal');
    $brand = data_get($product, 'brand');
    $stock = data_get($product, 'stok', data_get($product, 'stock'));
    $sold = data_get($product, 'sold');
    $imagePrefix = $imagePrefix ?? '03_';
@endphp

<div class="{{ $columnClass ?? 'col-xl-3 col-lg-4 col-md-4 col-6' }} mb-3">
    <article class="marketplace-product">
        <a href="javascript:void(0);"
           class="marketplace-product-image btn-view"
           aria-label="Lihat detail {{ $name }}"
           data-id="{{ $id }}"
           data-product="{{ $id }}"
           data-name="{{ e($name) }}"
           data-info="{{ e($description) }}"
           data-stok="{{ $stock }}"
           data-price="{{ $priceValue }}"
           data-price-label="{{ price($priceValue) }}"
           data-image="{{ productImage('05_', $image) }}"
           data-category="{{ e($category) }}"
           data-brand="{{ e($brand ?: 'Toko lokal') }}">
            <img src="{{ productImage($imagePrefix, $image) }}" alt="{{ e($name) }}">
        </a>

        <div class="marketplace-product-body">
            <span class="marketplace-badge">{{ $category }}</span>
            <h3 class="marketplace-product-name">{{ $name }}</h3>
            <div class="marketplace-price">Rp{{ price($priceValue) }}</div>
            <div class="marketplace-meta">
                <div><i class="ti-location-pin"></i> Dikirim dari toko lokal</div>
                @if(!empty($sold))
                    <div><i class="ti-check"></i> {{ $sold }} terjual</div>
                @elseif($stock !== null)
                    <div><i class="ti-package"></i> Stok {{ $stock }}</div>
                @else
                    <div><i class="ti-check"></i> Siap ditambahkan ke keranjang</div>
                @endif
            </div>
            <div class="marketplace-product-actions">
                <a href="javascript:void(0);"
                   class="btn btn-cart"
                   data-id="{{ $id }}"
                   data-product="{{ $id }}"
                   data-name="{{ e($name) }}"
                   data-info="{{ e($description) }}"
                   data-stok="{{ $stock }}"
                   data-price="{{ $priceValue }}"
                   data-price-label="{{ price($priceValue) }}"
                   data-image="{{ productImage('05_', $image) }}"
                   data-category="{{ e($category) }}"
                   data-brand="{{ e($brand ?: 'Toko lokal') }}">
                    + Keranjang
                </a>
                <a href="javascript:void(0);"
                   class="btn marketplace-icon-btn btn-wishlist"
                   aria-label="Simpan {{ $name }} ke daftar keinginan"
                   data-product="{{ $id }}">
                    <i class="ti-heart"></i>
                </a>
            </div>
        </div>
    </article>
</div>
