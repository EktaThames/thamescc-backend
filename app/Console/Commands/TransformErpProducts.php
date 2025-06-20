<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use League\Csv\Reader;
use League\Csv\Writer;
use Illuminate\Support\Str;

class TransformErpProducts extends Command
{
    protected $signature = 'transform:erp-products';
    protected $description = 'Transform ERP CSV to Bagisto-compatible format';

    public function handle(): int
    {
        $inputPath = storage_path('app/private/imports/raw_erp.csv');
        $outputPath = storage_path('app/private/imports/products.csv');

        if (!file_exists($inputPath)) {
            $this->error("Input file not found: {$inputPath}");
            return Command::FAILURE;
        }

        $reader = Reader::createFromPath($inputPath, 'r');
        $reader->setHeaderOffset(0);
        $records = iterator_to_array($reader->getRecords());

        $products = [];

        $new_categories_and_their_codes = [
            "1" => "BEER, CIDER, ALCOHOL FREE & READY TO DRINK",
            "2" => "WINE",
            "3" => "SPIRITS",
            "4" => "SOFT DRINK",
            "5" => "WATER",
            "6" => "HOT DRINKS",
            "7" => "TOBACCO & VAPES",
            "8" => "BISCUITS",
            "9" => "CEREALS & CEREAL BAR",
            "10" => "CONFECTIONERY",
            "11" => "BREAD & CAKES",
            "12" => "CRISPS AND SNACKS",
            "13" => "PET FOOD",
            "14" => "HOUSEHOLD, CLEANING & PAPER",
            "15" => "NON-FOOD AND STATIONERY",
            "16" => "HEALTH, BEAUTY & BABY PRODUCTS",
            "18" => "GROCERY",
            "19" => "CATERING & ETHNIC",
            "20" => "CHILLED & FROZEN",
        ];

        $new_subcategory_array = array(
            1 => array(
                1001 => 'ALCOHOL FREE AND LOW ALCOHOL',
                1002 => 'ALES AND BITTERS',
                1003 => 'BEER & LAGER',
                1004 => 'CIDER',
                1005 => 'READY TO DRINK'
            ),
            2 => array(
                2001 => 'WHITE WINE',
                2002 => 'RED WINE',
                2003 => 'ROSE WINE',
                2004 => 'PROSECCO, CHAMPAGNE & SPARKLING WINE',
                2005 => 'PORT, SHERRY, VERMOUTH & FORTIFIED WINE',
                2006 => 'ALCOHOL FREE AND LOW ALCOHOL WINE',
                2007 => 'PERRY'
            ),
            3 => array(
                3001 => 'GIN',
                3002 => 'WHISKY',
                3003 => 'VODKA',
                3004 => 'RUM',
                3005 => 'BRANDY & COGNAC',
                3006 => 'TEQUILA, LIQUEURS & APERITIFS'
            ),
            4 => array(
                4001 => 'FIZZY DRINKS',
                4002 => 'JUICES',
                4003 => 'ENERGY DRINKS',
                4004 => 'MILKSHAKES',
                4005 => 'SQUASH & CORDIAL',
                4006 => 'TONIC & MIXERS',
                4007 => 'ETHNIC DRINKS',
                4008 => 'COLD BEVERAGES'
            ),
            5 => array(
                5001 => 'STILL WATER',
                5002 => 'SPARKLING WATER',
                5003 => 'FLAVOURED WATER'
            ),
            6 => array(
                6001 => 'TEA',
                6002 => 'COFFEE',
                6003 => 'HOT CHOCOLATE & MALTED DRINKS'
            ),
            07 => array(
                7001 => 'CIGARETTES',
                7002 => 'CIGARS',
                7003 => 'ROLLING TOBACCO',
                7004 => 'VAPES & REFILLS',
                7005 => 'CIGARETTE PAPERS & LIGHTERS',
                7006 => 'SNUFF'
            ),
            8 => array(
                8001 => 'BISCUITES',
                8002 => 'COOKIES',
                8003 => 'CRACKERS',
                8004 => 'CONTINENTAL BISCUITES'
            ),
            9 => array(
                9001 => 'CEREALS',
                9002 => 'BRAN, OAT & FLAKE CEREAL',
                9003 => 'GRANOLA',
                9004 => 'CEREAL BARS & PROTEIN BARS'
            ),
            10 => array(
                10001 => 'CHOCOLATES',
                10002 => 'CHOCOLATE BOXES',
                10003 => 'CHEWING GUM',
                10004 => 'MINT',
                10005 => 'SWEET BAGS',
                10006 => 'SEASONAL'
            ),
            11 => array(
                11001 => 'BREAD',
                11002 => 'CAKES & TART',
                11003 => 'MORNING GOODS'
            ),
            12 => array(
                12001 => 'CRISP',
                12002 => 'DIPS',
                12003 => 'NUTS',
                12004 => 'POPCORN',
                12005 => 'ETHNIC SNACKS'
            ),
            13 => array(
                13001 => 'CAT FOOD',
                13002 => 'DOG FOOD'
            ),
            14 => array(
                14001 => 'AIR FRESHENER',
                14002 => 'CLEANING',
                14003 => 'CLEANING PROFESSIONAL',
                14004 => 'CLEANING TOOLS & GLOVES',
                14005 => 'DISHWASHER & WASHING UP',
                14006 => 'DISHWASHER & WASH UP PROFESSIONAL',
                14007 => 'HYGIENE PRODUCTS',
                14008 => 'LAUNDRY',
                14009 => 'TOILET ROLL',
                14010 => 'KITCHEN ACCESSORIES',
                14011 => 'FACIAL TISSUE & HAND WIPES',
                14012 => 'POLISHES, WAXES & PEST CONTROL'
            ),
            15 => array(
                15001 => 'BATTERIES',
                15002 => 'CARDED RANGE',
                15003 => 'COAL/CHARCOAL',
                15004 => 'STATIONERY',
                15005 => 'FOOD & DRINK DISPOSABLE',
                15006 => 'DIY HARDWARES'
            ),
            16 => array(
                16001 => 'BABY FOOD & DRINKS',
                16002 => 'BATH, SHOWER, SOAP',
                16003 => 'BEAUTY & SKINCARE',
                16004 => 'CONTRACEPTION',
                16005 => 'DENTAL CARE',
                16006 => 'FEMININE HYGIENE',
                16007 => 'HAIRCARE',
                16008 => 'MEDICINES & HEALTHCARE',
                16009 => 'MEN\'S TOILETRIES',
                16010 => 'NAPPIES & BABY TOILETRIES',
                16011 => 'WOMEN\'S TOILETRIES'
            ),
            18 => array(
                18001 => 'BAKING INGREDIENTS',
                18002 => 'COOKING INGREDIENTS',
                18003 => 'COOKING SAUCE & PASTA',
                18004 => 'DESSERTS',
                18005 => 'DRIED VEG RICE & PULSES',
                18006 => 'GRAVY & STOCK',
                18007 => 'INSTANT NOODLES & MEALS',
                18008 => 'JAM, HONEY, SPREAD',
                18009 => 'KETCHUP AND SAUCE',
                18010 => 'OIL & GHEE',
                18011 => 'PICKLE, CHUTNEY & OLIVES',
                18012 => 'SALT, HERB & SPICES',
                18013 => 'SUGAR & SYRUP',
                18014 => 'TINNED FOOD',
                18015 => 'SPORT & NUTRITION',
                18016 => 'SOUP'
            ),
            19 => array(
                19001 => 'SPICES',
                19002 => 'GRAINS',
                19003 => 'RICE',
                19004 => 'FLOUR',
                18010 => 'OIL & GHEE',
                19006 => 'CHUTNEY & SAUCES',
                12005 => 'SNACKS & NUTS',
                15005 => 'FOOD & DRINK DISPOSABLE',
                14003 => 'CLEANING PROFESSIONAL',
                14004 => 'CLEANING TOOLS & GLOVES',
                14006 => 'DISHWASHER & WASH UP PROFESSIONAL',
                4007 => 'ETHNIC DRINKS',
                8004 => 'CONTINENTAL BISCUITES',
                20011 => 'INDIAN FROZEN',
                15003 => 'COAL/CHARCOAL'
            ),
            20 => array(
                20001 => 'BREAD, PIZZA & SNACK',
                20002 => 'FROZEN VEGETABLES',
                20003 => 'ICE CREAM',
                20004 => 'READY MEAL',
                20005 => 'ICE CUBE',
                20006 => 'DESSERTS & GATEAUX',
                20007 => 'MEAT & POULTRY',
                20008 => 'POTATOES & SIDES',
                20009 => 'MILK',
                20010 => 'YOGURT AND CREAM',
                20011 => 'INDIAN FROZEN'
            )
        );

        foreach ($records as $row) {
            $item = trim($row['item'] ?? '');
            $description = str_replace('�', '£', trim($row['description'] ?? ''));
            $packDescription = trim($row['pack_description'] ?? '');
            $qty = trim($row['qty_in_stock'] ?? '0');
            $casesInStock = trim($row['cases_in_stock'] ?? '0');

            $category = trim($row['hierarchy1'] ?? '0');
            $sub_catgeory = trim($row['hierarchy2'] ?? '0');

            $categoryText = $new_categories_and_their_codes[$category] ?? '';
            $subcategoryText = $new_subcategory_array[$category][$sub_catgeory] ?? '';
            $categoriesField = $categoryText;
            if ($categoryText && $subcategoryText) {
                $categoriesField .= '/' . $subcategoryText;
            }

            $VAT = strtoupper(trim($row['VAT'] ?? ''));

            $promID = strtoupper(trim($row['promID'] ?? ''));
            $promSell1 = trim($row['promSell for Sell 1'] ?? '');
            $promSell2 = trim($row['promSell for Sell 2'] ?? '');
            $promSell3 = trim($row['promSell for Sell 3'] ?? '');
            $promStart = trim($row['promStart'] ?? '');
            $promEnd = trim($row['promEnd'] ?? '');
            $promStart = $this->formatDate($promStart);
            $promEnd = $this->formatDate($promEnd);
            $max_order = trim($row['Max. Order'] ?? '');
            $RRP = trim($row['RRP'] ?? '');
            $POR = trim($row['POR %'] ?? '');
            $PMP_Plain = strtoupper(trim($row['PMP/Plain'] ?? ''));

            $pack1 = trim($row['Pack 1'] ?? '');
            $pack2 = trim($row['Pack 2'] ?? '');
            $pack3 = trim($row['Pack 3'] ?? '');
            $sell1 = trim($row['Sell 1'] ?? '');
            $sell2 = trim($row['Sell 2'] ?? '');
            $sell3 = trim($row['Sell 3'] ?? '');

            $vatId = match ($VAT) {
                'A' => 1,
                'Z' => 3,
                default => 2,
            };

            $hasVariants = !empty($pack2) || !empty($pack3);
            $variants = [];

            if (!$hasVariants) {
                    $urlKey = Str::slug("{$description}-{$item}");
                    $specialPrice = $promID ? $promSell1 : '';
                    $products[] = $this->makeSimpleProduct(
                        $item, '', $description, $packDescription, $qty, $casesInStock, $vatId, $sell1, $pack1, 1,
                        $promID, $promStart, $promEnd, $max_order, $RRP, $POR, $PMP_Plain, $urlKey, $categoriesField, $specialPrice
                    );
            } else {
                $parent = $this->makeConfigurableParent($item, $description, $packDescription, $qty, $casesInStock, $promID, $promStart, $promEnd, $max_order, $RRP, $POR, $PMP_Plain, $categoriesField);
                $products[] = $parent;

                $configurableVariants = [];

                $sku1 = $item . 'a';
                $urlKey1 = Str::slug("{$description}-{$sku1}");
                $specialPrice1 = $promID ? $promSell1 : '';
                $products[] = $this->makeSimpleProduct(
                    $sku1, $item, $description, $packDescription, $qty, $casesInStock, $vatId, $sell1, $pack1, 0,
                    $promID, $promStart, $promEnd, $max_order, $RRP, $POR, $PMP_Plain, $urlKey1, $categoriesField, $specialPrice1
                );
                $configurableVariants[] = "sku={$sku1},pack_size=Pack 1";

                if (!empty($pack2)) {
                    $sku2 = $item . 'c';
                    $urlKey2 = Str::slug("{$description}-{$sku2}");
                    $specialPrice2 = $promID ? $promSell2 : '';
                    $products[] = $this->makeSimpleProduct(
                        $sku2, $item, $description, $packDescription, $qty, $casesInStock, $vatId, $sell2, $pack2, 0,
                        $promID, $promStart, $promEnd, $max_order, $RRP, $POR, $PMP_Plain, $urlKey2, $categoriesField, $specialPrice2
                    );
                    $configurableVariants[] = "sku={$sku2},pack_size=Pack 2";
                }

                if (!empty($pack3)) {
                    $sku3 = $item . 'b';
                    $urlKey3 = Str::slug("{$description}-{$sku3}");
                    $specialPrice3 = $promID ? $promSell3 : '';
                    $products[] = $this->makeSimpleProduct(
                        $sku3, $item, $description, $packDescription, $qty, $casesInStock, $vatId, $sell3, $pack3, 0,
                        $promID, $promStart, $promEnd, $max_order, $RRP, $POR, $PMP_Plain, $urlKey3, $categoriesField, $specialPrice3
                    );
                    $configurableVariants[] = "sku={$sku3},pack_size=Pack 3";
                }

                $products[array_key_last($products) - count($configurableVariants)]['configurable_variants'] = implode('|', $configurableVariants);
            }
        }

        $header = array_keys($products[0]);
        $writer = Writer::createFromPath($outputPath, 'w+');
        $writer->insertOne($header);

        foreach ($products as $product) {
            $writer->insertOne(array_map('strval', $product));
        }

        $this->info("Products CSV created at: {$outputPath}");
        return Command::SUCCESS;
    }

    protected function makeSimpleProduct($sku, $parentSku, $name, $packDesc, $qty, $cases, $vatId, $price, $packName = '', $visible_individually = 1, $promID = '', $promStart = '', $promEnd = '', $max_order = '', $RRP = '', $POR = '', $PMP_Plain = '', $url_key, $categories = '', $special_price = '')
    {
        $packQuantity = $packName;
        $customSubtitle = '';

        if (empty($price) || !is_numeric($price)) {
            $price = 1;
        }
        if ($packName && strtolower($packName) !== 'pack 1' && !empty($packDesc)) {
            $customSubtitle = "{$packName}X{$packDesc}";
        } elseif ($packQuantity == '') {
            $customSubtitle = $packDesc;
        }

        $sku = str_replace('/', '', $sku);

        return [
            'sku' => $sku,
            'parent_sku' => $parentSku,
            'locale' => 'en',
            'attribute_family_code' => 'variant_family',
            'type' => 'simple',
            'categories' => $categories,
            'images' => '',
            'name' => $name,
            'description' => $name,
            'short_description' => $name,
            'status' => 1,
            'visible_individually' => $visible_individually,
            'length' => '',
            'width' => '',
            'height' => '',
            'weight' => 10,
            'price' => $price,
            'special_price' => $special_price,
            'special_price_from' => $promStart,
            'special_price_to' => $promEnd,
            'url_key' => $url_key,
            'meta_title' => '',
            'meta_keywords' => '',
            'meta_description' => '',
            'manage_stock' => 1,
            'inventories' => 'default=' . $qty,
            'related_skus' => '',
            'cross_sell_skus' => '',
            'up_sell_skus' => '',
            'tax_status' => 19,
            'tax_category_id' => $vatId,
            'global_unique_id' => '',
            'cases_in_stock' => $cases,
            'custom_product_subtitle' => $customSubtitle,
            'pack_quantity' => $packQuantity,
            'low_stock_amount' => '',
            'pmp_or_not' => $PMP_Plain,
            'max_order' => $max_order,
            'por_percentage' => $POR,
            'product_size' => '',
            'prom_id' => $promID,
            'prom_start' => $promStart,
            'promo_end' => $promEnd,
            'total_sales' => '',
            'rrp_price' => $RRP,
            'outer_pack_size' => '',
            'shipping_class' => 'No Shipping class',
            'configurable_variants' => '',
        ];
    }

    protected function makeConfigurableParent($sku, $name, $packDesc, $qty, $cases, $promID = '', $promStart = '', $promEnd = '', $max_order = '', $RRP = '', $POR = '', $PMP_Plain = '', $categories = '')
    {
        $url_key = Str::slug($name).'-' . $sku ;
        return [
            'sku' => $sku,
            'parent_sku' => '',
            'locale' => 'en',
            'attribute_family_code' => 'variant_family',
            'type' => 'configurable',
            'categories' => $categories,
            'images' => '',
            'name' => $name,
            'description' => $name,
            'short_description' => $name,
            'status' => 1,
            'visible_individually' => 1,
            'length' => '',
            'width' => '',
            'height' => '',
            'weight' => '',
            'price' => '',
            'special_price' => '',
            'special_price_from' => '',
            'special_price_to' => '',
            'url_key' => $url_key,
            'meta_title' => '',
            'meta_keywords' => '',
            'meta_description' => '',
            'manage_stock' => '',
            'inventories' => '',
            'related_skus' => '',
            'cross_sell_skus' => '',
            'up_sell_skus' => '',
            'tax_status' => '',
            'tax_category_id' => '',
            'global_unique_id' => '',
            'cases_in_stock' => $cases,
            'custom_product_subtitle' => '',
            'pack_quantity' => '',
            'low_stock_amount' => '',
            'pmp_or_not' => $PMP_Plain,
            'max_order' => $max_order,
            'por_percentage' => $POR,
            'product_size' => '',
            'prom_id' => $promID,
            'prom_start' => $promStart,
            'promo_end' => $promEnd,
            'total_sales' => '',
            'rrp_price' => $RRP,
            'outer_pack_size' => '',
            'shipping_class' => 'No Shipping class',
            'configurable_variants' => '',
        ];
    }

    protected function formatDate($date)
    {
        if (empty($date)) {
            return '';
        }
        $timestamp = strtotime($date);
        if ($timestamp === false) {
            return '';
        }
        return date('Y-m-d', $timestamp);
    }
}
