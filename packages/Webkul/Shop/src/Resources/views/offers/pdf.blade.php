<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Special Offers</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #333;
            margin: 0;
            padding: 20px;
            background: #f9fafb;
        }

        h1 {
            text-align: center;
            margin-bottom: 25px;
            font-size: 22px;
            color: #222;
            letter-spacing: 1px;
        }

        .product-grid {
            width: 100%;
            border-spacing: 16px;
        }

        .product-card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.08);
            border: 1px solid #eee;
            padding: 12px;
            vertical-align: top;
            width: 48%;
        }

        .product-image {
            width: 100%;
            max-height: 160px;
            object-fit: contain;
            margin-bottom: 10px;
            border-radius: 6px;
            background: #f3f4f6;
            padding: 5px;
        }

        .product-name {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 5px;
            color: #111;
        }

        .product-price {
            font-size: 13px;
            color: #2a9d8f;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .product-desc {
            font-size: 12px;
            line-height: 1.4;
            margin-bottom: 8px;
            color: #444;
        }

        .offer-label {
            display: inline-block;
            background: #e76f51;
            color: #fff;
            padding: 3px 8px;
            font-size: 11px;
            border-radius: 12px;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .product-meta {
            font-size: 11px;
            color: #666;
            margin-top: 8px;
        }
    </style>
</head>
<body>
    <h1>Special Offers</h1>

    <table class="product-grid">
    <tr>
    @foreach ($products as $index => $product)
        <td class="product-card">
           @php
    $imageData = product_image()->getProductBaseImage($product);
    $finalImg = $imageData['original_image_url'] ?? bagisto_asset('images/small-product-placeholder.webp');
@endphp

@if ($finalImg)
    <img src="{{ $finalImg }}" class="product-image" />
@endif

                    <div class="product-name">{{ $product->name }}</div>
                    <div class="product-price">Price: {{ core()->currency($product->price) }}</div>

                    @if (!empty($product->offer_title))
                        <div class="offer-label">{{ strtoupper($product->offer_title) }}</div>
                    @endif

                    @if (!empty($product->short_description))
                        <div class="product-desc">
                            {{ Str::limit(strip_tags($product->short_description), 120) }}
                        </div>
                    @endif

                    <div class="product-meta">
                        SKU: {{ $product->sku ?? '-' }} <br>
                        Brand: {{ $product->brand_name ?? 'N/A' }} <br>
                        Stock: {{ $product->quantity ?? 'N/A' }}
                    </div>
                </td>

                {{-- Break row after 2 products --}}
                @if (($index + 1) % 2 == 0)
                    </tr><tr>
                @endif
            @endforeach
            
        </tr>
    </table>
</body>
</html>
