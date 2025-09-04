
<x-shop::layouts>
    <x-slot:title>
        {{ __('Special Offers') }}
    </x-slot:title>

    <div class="container py-8">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold">
                {{ __('Special Offers') }}
            </h1>

             <a href="{{ route('shop.offers.pdf') }}"
           target="_blank"
           class="secondary-button block w-max rounded-2xl px-11 py-3 text-center text-base max-md:rounded-lg max-md:text-sm max-sm:px-7 max-sm:py-2">
            <i class="icon download-icon"></i> Download Offers as PDF
        </a>
        </div>
        @if ($offers->count())
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($offers as $offer)
    <div>
        <h2>{{ $offer->name }}</h2>
        <p>{{ $offer->price }}</p>
    </div>
@endforeach

            </div>

            <div class="mt-6">
                {{ $offers->links() }}
            </div>
        @else
            <p>{{ __('No offers available right now.') }}</p>
        @endif
    </div>
</x-shop::layouts>
