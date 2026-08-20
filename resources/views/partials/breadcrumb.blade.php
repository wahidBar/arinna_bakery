{{--
    partials/breadcrumb.blade.php
    Usage: @include('partials.breadcrumb', ['items' => [['label' => 'Products', 'url' => route('products.index')], ['label' => 'Detail']]])
    The last item is always the current page (no URL needed).
--}}
<div class="bg-[#f8f8fb] border-b border-[#eee]">
    <div class="flex flex-wrap justify-between relative items-center mx-auto
                min-[1400px]:max-w-[1320px] min-[1200px]:max-w-[1140px]
                min-[992px]:max-w-[960px] min-[768px]:max-w-[720px]
                min-[576px]:max-w-[540px] px-[12px]">
        <div class="w-full py-[14px]">
            <nav class="flex items-center flex-wrap gap-1.5 text-[13px] font-Poppins" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="text-[#6c7fd8] hover:underline transition">Home</a>
                @foreach($items as $item)
                    <span class="text-[#bbb]">/</span>
                    @if(isset($item['url']))
                        <a href="{{ $item['url'] }}" class="text-[#6c7fd8] hover:underline transition">{{ $item['label'] }}</a>
                    @else
                        <span class="text-[#686e7d]">{{ $item['label'] }}</span>
                    @endif
                @endforeach
            </nav>
        </div>
    </div>
</div>
