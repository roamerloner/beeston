<div class="grid">
    <div class="product-pic">
        @if ($product->thumbnail)
            <img src="{{asset('uploads/product_thumbnail')}}/{{ $product->thumbnail }}" alt="Not Found">

        @else
            <img src="{{ Avatar::create($product->name )->setShape('square'); }}" />
        @endif
        @if ($product->discounted_price)
            <span class="theme-badge-2">{{ round(100 - (($product->discounted_price /$product->regular_price)*100), 2) }} % Off</span>
        @endif
    </div>
    <div class="details">
        <h4><a href="{{ route('product.details', $product->id) }}">{{ $product->name }}</a>
        </h4>
        <p class="badge" style="background: {{ $product->relationshipwithCategory->category_color }}">{{ $product->relationshipwithCategory->category_name }}</p>
        <p>
            {{ Str::limit($product->short_description, 20) }}
        </p>
        <div class="rating">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
        </div>
        <span class="price">
            @if ($product->discounted_price)
                <ins>
                    <span class="woocommerce-Price-amount amount">
                        <bdi>
                            <span class="woocommerce-Price-currencySymbol">৳</span>{{ $product->discounted_price }}
                        </bdi>
                    </span>
                </ins>
                    <del aria-hidden="true">
                    <span class="woocommerce-Price-amount amount">
                    <bdi>
                        <span class="woocommerce-Price-currencySymbol">৳</span>{{ $product->regular_price }}
                    </bdi>
                    </span>
                    </del>

            @else
                <ins>
                    <span class="woocommerce-Price-amount amount">
                        <bdi>
                            <span class="woocommerce-Price-currencySymbol">৳</span>{{ $product->regular_price }}
                        </bdi>
                    </span>
                </ins>
            @endif
        </span>

        <div class="add-cart-area">
            <a href="{{ route('product.details', $product->id) }}" class="btn btn-danger">Details</a>
        </div>
    </div>
</div>
