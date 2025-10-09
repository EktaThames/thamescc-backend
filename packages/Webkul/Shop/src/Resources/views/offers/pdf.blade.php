<?php set_time_limit(300); ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Bulk Bazaar Special Offers</title>
  <style>
    /* ----------- GENERAL PAGE ----------- */
    body {
      font-family: 'Segoe UI', Arial, sans-serif;
      color: #111;
      margin: 0;
      padding: 25px 30px;
      background: #fff;
    }

    h1 {
      text-align: center;
      font-size: 30px;
      font-weight: 900;
      color: #cc0000;
      text-transform: uppercase;
      margin-bottom: 25px;
      letter-spacing: 1px;
    }

    /* ----------- GRID LAYOUT ----------- */
    table {
      width: 100%;
      border-collapse: collapse;
    }
    td {
      width: 33.33%;
      padding: 14px 10px;
      vertical-align: top;
      background: #fff;
      border: 1px solid #f0f0f0;
      border-radius: 4px;
      box-sizing: border-box;
    }

    /* ----------- POR LABEL ----------- */
    .por {
      display: inline-block;
      background: #cc0000;
      color: #fff;
      font-weight: 700;
      font-size: 13px;
      text-transform: lowercase;
      padding: 3px 10px;
      border-radius: 3px;
      margin-bottom: 8px;
    }

    /* ----------- IMAGE SECTION ----------- */
    .image-container {
      text-align: center;
      height: 120px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 8px;
    }
    .product-image {
      max-width: 100%;
      max-height: 110px;
      object-fit: contain;
    }

    /* ----------- TEXT DETAILS ----------- */
    .product-name {
      font-size: 13px;
      font-weight: 700;
      text-transform: uppercase;
      color: #000;
      line-height: 1.3;
      text-align: center;
      margin-bottom: 6px;
      min-height: 32px;
    }

    .sku-rrp {
      text-align: center;
      font-size: 11px;
      color: #555;
      margin-bottom: 3px;
    }
    .pack {
      text-align: center;
      font-size: 11px;
      color: #666;
      margin-bottom: 8px;
    }

    /* ----------- PRICE SECTION ----------- */
    .price {
      font-size: 18px;
      font-weight: 900;
      color: #006400;
      text-align: center;
      margin-top: 6px;
    }

    /* ----------- ROW BREAK ----------- */
    tr {
      page-break-inside: avoid;
    }
  </style>
</head>
<body>
  <h1>Special Offers</h1>

  <table>
    <tr>
    @foreach ($products as $index => $product)
      <td>
        {{-- POR --}}
        @if (!empty($product->por_percentage))
          <div class="por">por {{ $product->por_percentage }}%</div>
        @endif

        {{-- IMAGE --}}
        <div class="image-container">
          <img src="{{ $product->base64_image }}" alt="{{ $product->name ?? 'Product N/A' }}" class="product-image" />
        </div>

        {{-- NAME --}}
        <div class="product-name">{{ strtoupper($product->name ?? 'Product N/A') }}</div>

        {{-- SKU + RRP --}}
        <div class="sku-rrp">
          SKU: {{ $product->sku ?? '-' }}
          @if (!empty($product->rrp_price))
            &nbsp;&nbsp;RRP {{ $product->rrp_price }}
          @endif
        </div>

        {{-- PACK INFO --}}
        <div class="pack">{{ $product->custom_product_subtitle ?? 'N/A' }}</div>

        {{-- PRICE --}}
        <div class="price">{{ core()->currency($product->price ?? '0.00') }}</div>
      </td>

      {{-- Start new row every 3 products --}}
      @if (($index + 1) % 3 == 0)
        </tr><tr>
      @endif
    @endforeach
    </tr>
  </table>
</body>
</html>
