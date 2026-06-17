@if(!empty($categories))
    <div class="category-shortcuts" aria-label="Kategori populer">
        @foreach($categories as $category)
            @php
                $slug = data_get($category, 'slug');
                $name = data_get($category, 'name');
                $active = request('category') === $slug;
            @endphp
            <a href="{{ route('product', ['category' => $slug]) }}"
               class="category-chip {{ $active ? 'active' : '' }}">
                <span class="category-chip-icon"><i class="ti-tag"></i></span>
                {{ $name }}
            </a>
        @endforeach
    </div>
@endif
