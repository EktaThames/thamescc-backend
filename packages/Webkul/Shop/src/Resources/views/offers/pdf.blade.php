<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Special Offers</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #333; }
        h1 { text-align: center; margin-bottom: 20px; }
        .product-table { width: 100%; border-collapse: collapse; }
        .product-row { border-bottom: 1px solid #ddd; padding: 10px 0; }
        .product-image { width: 80px; vertical-align: top; padding-right: 10px; }
        .product-details { vertical-align: top; }
        .product-name { font-size: 14px; font-weight: bold; margin-bottom: 5px; }
        .product-price { color: #2a9d8f; margin-bottom: 5px; }
        .product-desc { font-size: 12px; margin-bottom: 5px; }
        .offer-label { display: inline-block; background: #e76f51; color: #fff;
                       padding: 2px 6px; font-size: 10px; border-radius: 3px; }
    </style>
</head>
<body>
    <h1>Special Offers</h1>
    <table class="product-table">
        @foreach ($products as $product)
        <tr class="product-row">
            <td>
                @php
                    $img = $product->base_image['small_image_url'] ?? '';
                @endphp
                @if ($img)
                    <img src="{{ $img }}" class="product-image" />
                @endif
            </td>
            <td class="product-details">
                <div class="product-name">{{ $product->name }}</div>
                <div class="product-price">Price: {{ core()->currency($product->price) }}</div>
                @if (!empty($product->offer_title))
                    <div class="offer-label">{{ strtoupper($product->offer_title) }}</div>
                @endif
                @if (!empty($product->short_description))
                    <div class="product-desc">{{ Str::limit($product->short_description, 100) }}</div>
                @endif
            </td>
        </tr>
        @endforeach
    </table>
</body>
</html>
