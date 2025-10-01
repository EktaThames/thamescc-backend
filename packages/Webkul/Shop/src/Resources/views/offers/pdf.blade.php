<?php set_time_limit(300); ?> 
<?php 
// ⚠️ Recommended: Increase time limit to prevent the "Maximum execution time exceeded" error
// set_time_limit(300); 
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Thames C&C Special Offers</title>
    <style>
        /* BASE STYLES */
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #222;
            margin: 0;
            padding: 15px; 
            background: #fff;
        }

        h1 {
            text-align: left;
            margin-bottom: 25px;
            font-size: 28px;
            color: #C00; /* Signature Offer Red */
            border-bottom: 3px solid #FFCC00; /* Gold/Yellow highlight line */
            padding-bottom: 10px;
            font-weight: 900;
        }

        /* GRID/LAYOUT - Using 3 products per row for better density on a PDF page */
        .product-grid {
            width: 100%;
            border-spacing: 12px;
            table-layout: fixed;
        }

        /* PRODUCT CARD - Clean, minimal shadow and border for a modern look */
        .product-card {
            background: #FAFAFA; /* Off-white card background */
            border-radius: 8px; 
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border: none; /* Removed harsh border */
            padding: 10px;
            vertical-align: top;
            width: 33.33%; /* THREE columns per row */
            height: 100%; 
            position: relative;
            box-sizing: border-box;
        }

        /* IMAGE CONTAINER & STYLING */
        .image-container {
            height: 120px;
            text-align: center;
            margin-bottom: 8px;
            background: #FFFFFF;
            border-radius: 6px;
            padding: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .product-image {
            max-width: 100%;
            max-height: 110px; 
            object-fit: contain;
        }

        /* POR BADGE - The most prominent feature, simulated as a clean, sharp badge */
        .por-badge {
            position: absolute;
            top: 0;
            right: 0;
            background: #E53935; /* Primary Offer Red */
            color: #fff;
            padding: 8px 10px; 
            text-align: center;
            font-size: 14px;
            font-weight: 900;
            border-bottom-left-radius: 8px;
            border-top-right-radius: 8px;
            line-height: 1.2;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
            z-index: 10;
        }

        /* TEXT DETAILS */
        .product-name {
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 4px;
            color: #000;
            min-height: 32px; /* Ensure 2 lines can fit for consistency */
        }
        
        .product-pack-size {
            font-size: 11px;
            color: #666;
            margin-bottom: 4px;
            text-transform: capitalize;
        }
        
        /* PRICE MARKED PACK (PMP) or RRP */
        .offer-label {
            display: block;
            background: #333; /* Dark background for PMP/RRP */
            color: #FFCC00; /* Yellow text for contrast */
            padding: 3px 6px;
            font-size: 10px;
            border-radius: 3px;
            font-weight: bold;
            margin-bottom: 4px;
            width: fit-content;
        }
        
        /* CASE PRICE */
        .product-price {
            font-size: 18px;
            color: #008000; /* Green for profit/good price */
            font-weight: 900;
            padding-top: 4px;
            border-top: 1px solid #EEE;
        }

        /* SKU/Brand Details */
        .product-meta {
            font-size: 9px;
            color: #999;
            margin-top: 6px;
        }
    </style>
</head>
<body>
    <h1>Warehouse Special Offers</h1>

    <table class="product-grid">
    <tr>
    @foreach ($products as $index => $product)
        <td class="product-card">
            @php
                $imageData = product_image()->getProductBaseImage($product);
                // ⚠️ Crucial for PDF: Convert image data to Base64 (string) 
                // Assumes $imageData['data'] contains the raw image content or $imageData['base64_url'] is available
                // If using a library, use its method to get Base64. Placeholder URL used if data is missing.
                $base64Image = isset($imageData['base64_url']) && $imageData['base64_url'] ? $imageData['base64_url'] : 'https://via.placeholder.com/110x110?text=Image+N%2FA'; 
            @endphp

            {{-- POR Badge --}}
            @if (!empty($product->por_percentage))
                <div class="por-badge">POR<br>{{ $product->por_percentage }}</div>
            @endif

            <div class="image-container">
                {{-- Use Base64 inline for reliable PDF image rendering --}}
                <img src="{{ $base64Image }}" class="product-image" />
            </div>

            <div class="product-name">{{ $product->name ?? 'Product Name N/A' }}</div>
            
            {{-- PACK SIZE and Description --}}
            <div class="product-pack-size">Pack Size: {{ $product->pack_size ?? 'N/A' }}</div>

            {{-- PMP/RRP Label --}}
            @if (!empty($product->offer_title))
                <div class="offer-label">RRP/PMP: {{ $product->offer_title }}</div>
            @endif
            
            {{-- Case Price - The final selling price --}}
            <div class="product-price">{{ core()->currency($product->price ?? '0.00') }}</div>

            {{-- SKU/Brand Details --}}
            <div class="product-meta">
                SKU: {{ $product->sku ?? '-' }} | Brand: {{ $product->brand_name ?? 'N/A' }}
            </div>
        </td>

        {{-- Change: Break row after 3 products (index starts at 0, so index 2 is the 3rd item) --}}
        @if (($index + 1) % 3 == 0)
            </tr><tr>
        @endif
    @endforeach
    </tr>
    </table>
</body>
</html>