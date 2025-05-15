<?php

namespace Webkul\Installer\Database\Seeders\Category;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Webkul\Category\Models\Category;

class CategoryTableSeeder extends Seeder
{
    public function run($parameters = [])
    {
        DB::table('category_translations')->delete();
        DB::table('categories')->delete();


        $now = Carbon::now();

        $defaultLocale = $parameters['default_locale'] ?? config('app.locale');
        $locales = $parameters['allowed_locales'] ?? [$defaultLocale];

        $new_categories_and_their_codes = [
            1 => "BEER, CIDER, ALCOHOL FREE & READY TO DRINK",
            2 => "WINE",
            3 => "SPIRITS",
            4 => "SOFT DRINK",
            5 => "WATER",
            6 => "HOT DRINKS",
            7 => "TOBACCO & VAPES",
            8 => "BISCUITS",
            9 => "CEREALS & CEREAL BAR",
            10 => "CONFECTIONERY",
            11 => "BREAD & CAKES",
            12 => "CRISPS AND SNACKS",
            13 => "PET FOOD",
            14 => "HOUSEHOLD, CLEANING & PAPER",
            15 => "NON-FOOD AND STATIONERY",
            16 => "HEALTH, BEAUTY & BABY PRODUCTS",
            18 => "GROCERY",
            19 => "CATERING & ETHNIC",
            20 => "CHILLED & FROZEN",
        ];

        $new_subcategory_array = [
            1 => [
                1001 => 'ALCOHOL FREE AND LOW ALCOHOL',
                1002 => 'ALES AND BITTERS',
                1003 => 'BEER & LAGER',
                1004 => 'CIDER',
                1005 => 'READY TO DRINK'
            ],
            2 => [
                2001 => 'WHITE WINE',
                2002 => 'RED WINE',
                2003 => 'ROSE WINE',
                2004 => 'PROSECCO, CHAMPAGNE & SPARKLING WINE',
                2005 => 'PORT, SHERRY, VERMOUTH & FORTIFIED WINE',
                2006 => 'ALCOHOL FREE AND LOW ALCOHOL WINE',
                2007 => 'PERRY'
            ],
            3 => [
                3001 => 'GIN',
                3002 => 'WHISKY',
                3003 => 'VODKA',
                3004 => 'RUM',
                3005 => 'BRANDY & COGNAC',
                3006 => 'TEQUILA, LIQUEURS & APERITIFS'
            ],
            4 => [
                4001 => 'FIZZY DRINKS',
                4002 => 'JUICES',
                4003 => 'ENERGY DRINKS',
                4004 => 'MILKSHAKES',
                4005 => 'SQUASH & CORDIAL',
                4006 => 'TONIC & MIXERS',
                4007 => 'ETHNIC DRINKS',
                4008 => 'COLD BEVERAGES'
            ],
            5 => [
                5001 => 'STILL WATER',
                5002 => 'SPARKLING WATER',
                5003 => 'FLAVOURED WATER'
            ],
            6 => [
                6001 => 'TEA',
                6002 => 'COFFEE',
                6003 => 'HOT CHOCOLATE & MALTED DRINKS'
            ],
            7 => [
                7001 => 'CIGARETTES',
                7002 => 'CIGARS',
                7003 => 'ROLLING TOBACCO',
                7004 => 'VAPES & REFILLS',
                7005 => 'CIGARETTE PAPERS & LIGHTERS',
                7006 => 'SNUFF'
            ],
            8 => [
                8001 => 'BISCUITS',
                8002 => 'COOKIES',
                8003 => 'CRACKERS',
                8004 => 'CONTINENTAL BISCUITS'
            ],
            9 => [
                9001 => 'CEREALS',
                9002 => 'BRAN, OAT & FLAKE CEREAL',
                9003 => 'GRANOLA',
                9004 => 'CEREAL BARS & PROTEIN BARS'
            ],
            10 => [
                10001 => 'CHOCOLATES',
                10002 => 'CHOCOLATE BOXES',
                10003 => 'CHEWING GUM',
                10004 => 'MINT',
                10005 => 'SWEET BAGS',
                10006 => 'SEASONAL'
            ],
            11 => [
                11001 => 'BREAD',
                11002 => 'CAKES & TART',
                11003 => 'MORNING GOODS'
            ],
            12 => [
                12001 => 'CRISP',
                12002 => 'DIPS',
                12003 => 'NUTS',
                12004 => 'POPCORN',
                12005 => 'ETHNIC SNACKS'
            ],
            13 => [
                13001 => 'CAT FOOD',
                13002 => 'DOG FOOD'
            ],
            14 => [
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
            ],
            15 => [
                15001 => 'BATTERIES',
                15002 => 'CARDED RANGE',
                15003 => 'COAL/CHARCOAL',
                15004 => 'STATIONERY',
                15005 => 'FOOD & DRINK DISPOSABLE',
                15006 => 'DIY HARDWARES'
            ],
            16 => [
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
            ],
            18 => [
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
            ],
            19 => [
                19001 => 'SPICES',
                19002 => 'GRAINS',
                19003 => 'RICE',
                19004 => 'FLOUR',
                19005 => 'OIL & GHEE (ETHNIC)',
                19006 => 'CHUTNEY & SAUCES',
                19007 => 'SNACKS & NUTS',
                19008 => 'FOOD & DRINK DISPOSABLE',
                19009 => 'CLEANING PROFESSIONAL',
                19010 => 'CLEANING TOOLS & GLOVES',
                19011 => 'DISHWASHER & WASH UP PROFESSIONAL',
                19012 => 'ETHNIC DRINKS',
                19013 => 'CONTINENTAL BISCUITS',
                19014 => 'INDIAN FROZEN',
                19015 => 'COAL/CHARCOAL'
            ],
            20 => [
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
            ],
        ];

        // Insert root category
        $rootCategoryId = DB::table('categories')->insertGetId([
            'position'    => 0,
            'logo_path'   => null,
            'status'      => 1,
            '_lft'        => 0,
            '_rgt'        => 9999,
            'parent_id'   => null,
            'banner_path' => null,
            'created_at'  => $now,
            'updated_at'  => $now,
        ]);

        foreach ($locales as $locale) {
            DB::table('category_translations')->insert([
                'name' => 'Root Category',
                'slug' => 'root',
                'description' => 'Root category description',
                'category_id' => $rootCategoryId,
                'locale' => $locale,
                'meta_title' => '',
                'meta_description' => '',
                'meta_keywords' => '',
            ]);
        }

        foreach ($new_categories_and_their_codes as $key => $categoryName) {
            $mainCategoryId = DB::table('categories')->insertGetId([
                'position'     => $key,
                'logo_path'    => null,
                'status'       => 1,
                'display_mode' => 'products_and_description',
                '_lft'         => 0,
                '_rgt'         => 0,
                'parent_id'    => $rootCategoryId,
                'banner_path'  => null,
                'created_at'   => $now,
                'updated_at'   => $now,
            ]);

            foreach ($locales as $locale) {
                DB::table('category_translations')->insert([
                    'category_id'      => $mainCategoryId,
                    'name'             => $categoryName,
                    'slug'             => strtolower(str_replace(' ', '-', $categoryName)),
                    'url_path'         => '',
                    'description'      => '',
                    'meta_title'       => '',
                    'meta_description' => '',
                    'meta_keywords'    => '',
                    'locale'           => $locale,
                ]);
            }

            foreach ($new_subcategory_array[$key] ?? [] as $subCatName) {
                $subCategoryId = DB::table('categories')->insertGetId([
                    'position'     => 1,
                    'logo_path'    => null,
                    'status'       => 1,
                    'display_mode' => 'products_and_description',
                    '_lft'         => 0,
                    '_rgt'         => 0,
                    'parent_id'    => $mainCategoryId,
                    'banner_path'  => null,
                    'created_at'   => $now,
                    'updated_at'   => $now,
                ]);

                foreach ($locales as $locale) {
                    DB::table('category_translations')->insert([
                        'category_id'      => $subCategoryId,
                        'name'             => $subCatName,
                        'slug'             => strtolower(str_replace(' ', '-', $subCatName)),
                        'url_path'         => '',
                        'description'      => '',
                        'meta_title'       => '',
                        'meta_description' => '',
                        'meta_keywords'    => '',
                        'locale'           => $locale,
                    ]);
                }
            }
        }

        Category::fixTree();
    }
}
