@extends('themes::missav.layout')

@php
    use Kho8k\Core\Models\Movie;

    $recommendations = Cache::remember('site.movies.recommendations', setting('site_cache_ttl', 5 * 60), function () {
        return Movie::where('is_recommended', true)
            ->limit(get_theme_option('recommendations_limit', 10))
            ->get()
            ->sortBy([
                function ($a, $b) {
                    return $a['name'] <=> $b['name'];
                },
            ]);
    });

    $data = Cache::remember('site.movies.latest', setting('site_cache_ttl', 5 * 60), function () {
        $lists = preg_split('/[\n\r]+/', get_theme_option('latest'));
        $data = [];
        foreach ($lists as $list) {
            if (trim($list)) {
                $list = explode('|', $list);
                [$label, $relation, $field, $val, $limit, $link] = array_merge($list, [
                    'Phim  mới cập nhật',
                    '',
                    'type',
                    'series',
                    8,
                    '/',
                ]);
                try {
                    $data[] = [
                        'label' => $label,
                        'data' => Movie::when($relation, function ($query) use ($relation, $field, $val) {
                            $query->whereHas($relation, function ($rel) use ($field, $val) {
                                $rel->where($field, $val);
                            });
                        })
                            ->when(!$relation, function ($query) use ($field, $val) {
                                $query->where($field, $val);
                            })
                            ->limit($limit)
                            ->orderBy('updated_at', 'desc')
                            ->get(),
                        'link' => $link ?: '#',
                    ];
                } catch (\Exception $e) {
                }
            }
        }
        return $data;
    });

@endphp


@section('content')

    <div class="search-form flex flex-col justify-center content-center text-center">
        <h1 class="text-3xl tracking-tight leading-10 font-serif text-zinc-50 sm:text-4xl sm:leading-none mb-8"
            style="visibility: visible;">
            tìm kiếm bất kỳ<span class="text-primary"> phim sex yêu thích</span>
        </h1>
        <div class="container relative mx-auto px-4 max-w-xl shadow-sm flex w-full rounded-md">
            <form class="relative flex items-stretch grow" id="form-search" action="/">
                <input type="search" name="search" placeholder="Tìm kiếm phim"
                    class="block w-full rounded-none rounded-l-md p-3 border border-gray-300 transition ease-in-out duration-150 sm:leading-5 focus:outline-none focus:border-primary focus:ring focus:ring-nord11 focus:ring-opacity-50 placeholder-gray-400"
                    value="{{ request('search') }}" />

                <button
                    class="-ml-px relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-r-md text-gray-700 bg-gray-50 hover:text-gray-500 hover:bg-white focus:outline-none focus:ring-blue-500 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 whitespace-nowrap search-icon"><svg
                        class="fill-current pointer-events-none text-gray-400 w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20">
                        <path
                            d="M12.9 14.32a8 8 0 1 1 1.41-1.41l5.35 5.33-1.42 1.42-5.33-5.34zM8 14A6 6 0 1 0 8 2a6 6 0 0 0 0 12z">
                        </path>
                    </svg>
                    <span class="ml-2 w-full">Tìm kiếm</span>
                </button>
            </form>
        </div>
    </div>
    
    <div class="flex-1 min-w-0 pt-10 pd-6 items-center justify-between"><h2 class="h-text text-white uppercase text-2xl mb-2">đề xuất cho bạn</h2></div>
    @if (count($recommendations))
        <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-5">
            @foreach ($recommendations as $movie)
                @include('themes::missav.inc.movie_card_recommend')
            @endforeach
        </div>
    @endif
    <div class="flex flex-row flex-wrap flex-grow mt-2 justify-center content-center">
        @if (get_theme_option('ads_header'))
            {!! get_theme_option('ads_header') !!}
        @endif
    </div>
    @foreach ($data as $key_section => $item)
        <div class="mb-5 ">
            <div class="flex-1 min-w-0 pd-4 items-center justify-between lg:pt-6 md:pt-6 sm:pt-6 se:pt-4 gl:pt-4">
                <h2 class="h-text text-white uppercase text-2xl mb-2">
                    <span class="h-text text-white uppercase">{{ $item['label'] }}</span>
                </h2>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 lg:grid-cols-4 gap-5">
                @foreach ($item['data'] ?? [] as $key => $movie)
                    @include('themes::missav.inc.movie_card')
                @endforeach
            </div>
            <div class="relative w-full text-center pt-6">
                <a class="inline-flex items-center text-secondary hover:text-primary font-medium" href="{{ $item['link'] }}">
                    <span>Xem Thêm</span>
                </a>
            </div> 
        </div>
    @endforeach
@endsection

@push('header')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
@endpush

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".recommend-carousel").owlCarousel({
                items: 1,
                center: false,
                loop: true,
                dots: false,
                nav: true,
                margin: 10,
                stagePadding: 0,
                stageOuterClass: 'owl-stage-outer',
                responsive: {
                    1280: {
                        items: 4
                    },
                    1024: {
                        items: 3
                    },
                    768: {
                        items: 2
                    },
                },
                scrollPerPage: true,
                lazyLoad: true,
                slideSpeed: 800,
                paginationSpeed: 400,
                stopOnHover: true,
                autoplay: true,
                navText: [
                    `<span style="display: none" aria-label="Previous">‹</span><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="absolute top-1/3 left-0 text-red-500 bg-gradient-to-r from-[#151111] w-8 h-8"><path stroke-linecap="round" stroke-linejoin="round" d="M18.75 19.5l-7.5-7.5 7.5-7.5m-6 15L5.25 12l7.5-7.5" /></svg>`,
                    `<span style="display: none" aria-label="Next">›</span><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="absolute top-1/3 right-0 text-red-500 bg-gradient-to-l from-[#151111] w-8 h-8"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 4.5l7.5 7.5-7.5 7.5m-6-15l7.5 7.5-7.5 7.5" /></svg>`
                ],
            });
        });
    </script>
@endpush
