@extends('layouts.app')

@section('title')
Kategori - Yamyam Snack
@endsection

@section('content')
<!-- Page Content -->
<div class="page-content page-home">
    <section class="store-trend-categories">
        <div class="container">
            <div class="row">
                <div class="col-12" data-aos="fade-up">
                    <h5>Kategori</h5>
                </div>
            </div>
            <div class="row">
                @php $incrementCategory = 0 @endphp
                @if ($categories != null)
                    <div class="col-6 col-md-3 col-lg-2" data-aos="fade-up"
                        data-aos-delay="{{ $incrementCategory += 100 }}">
                        <a href="{{ route('categories') }}" class="component-categories d-block">
                            <p class="categories-text">
                                Semua Kategori
                            </p>
                        </a>
                    </div>
                @endif
                @forelse ($categories as $category)
                    <div class="col-6 col-md-3 col-lg-2" data-aos="fade-up"
                        data-aos-delay="{{ $incrementCategory += 100 }}">
                        <a href="{{ route('categories-detail', $category->slug) }}" class="component-categories d-block">
                            <div class="categories-image">
                                <img src="{{ Storage::url($category->photo) }}" alt="" class="w-100" />
                            </div>
                            <p class="categories-text">
                                {{ucwords($category->name) }}
                            </p>
                        </a>
                    </div>
                @empty
                    <div class="py-5 text-center col-12" data-aos="fade-up" data-aos-delay="100">
                        Kategori Tidak Ditemukan
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="store-new-products">
        <div class="container">
            <div class="row">
                <div class="col-12 d-flex justify-content-between align-items-center" data-aos="fade-up">
                    @if ($selectedCategory == 'Semua Kategori')
                        <h5>Produk pada Semua Kategori</h5>
                    @else
                        <h5>Produk pada Kategori {{ $selectedCategory }}</h5>
                    @endif
                    <form action="{{ route('products.search') }}" method="GET" class="d-flex">
                        <input type="hidden" name="category" value="{{ $selectedCategory }}">
                        <div class="input-group">
                            <input type="text" name="query" class="form-control" placeholder="Cari produk...">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-secondary">
                                <i class="fas fa-search"></i>
                                </button>
                            </div>
                            <div class="ml-2">
                                <select name="sort" class="form-control" onchange="this.form.submit()">
                                    <option value="">Sort by Price</option>
                                    <option value="low_to_high" {{ request('sort') == 'low_to_high' ? 'selected' : '' }}>Urutkan dari termurah</option>
                                    <option value="high_to_low" {{ request('sort') == 'high_to_low' ? 'selected' : '' }}>Urutkan dari termahal</option>
                                </select>
                            </div>
                            </div>
                    </form>
                </div>
            </div>
            <div class="row">
                @php $incrementProduct = 0 @endphp
                @forelse ($products as $product)
                    <div class="col-6 col-md-4 col-lg-3 card-body wrapper-text" data-aos="fade-up" data-aos-delay="{{ $incrementProduct += 100 }}">
                        <a href="{{ route('detail', $product->slug) }}" class="component-products d-block">
                            <div class="products-image" style="
                            @if ($product->galleries->count())
                                background-image: url('{{ Storage::url($product->galleries->first()->photos) }}');
                            @else
                                background-color: #eee;
                            @endif
                        ">
                            </div>
                            <div>
                                <div class="products-text">
                                    {{ucfirst($product->name)  }}
                                </div>
                                <div class="products-price">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="py-5 text-center col-12" data-aos="fade-up" data-aos-delay="100">
                        No Products Found
                    </div>
                @endforelse
            </div>
            <div class="row">
                <div class="mt-4 col-12">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </section>
</div>
@endsection