@extends('themes::layout')
@php
$menu = \Kho8k\Core\Models\Menu::getTree();
$tops = Cache::remember('site.movies.tops', setting('site_cache_ttl', 5 * 60), function () {
    $lists = preg_split('/[\n\r]+/', get_theme_option('hotest'));
    $data = [];
    foreach ($lists as $list) {
        if (trim($list)) {
            $list = explode('|', $list);
            [$label, $relation, $field, $val, $sortKey, $alg, $limit] = array_merge($list, ['Phim hot', '', 'type', 'series', 'view_total', 'desc', 4]);
            try {
                $data[] = [
                    'label' => $label,
                    'data' => \Kho8k\Core\Models\Movie::when($relation, function ($query) use ($relation, $field, $val) {
                        $query->whereHas($relation, function ($rel) use ($field, $val) {
                            $rel->where($field, $val);
                        });
                    })
                        ->when(!$relation, function ($query) use ($field, $val) {
                            $query->where($field, $val);
                        })
                        ->orderBy($sortKey, $alg)
                        ->limit($limit)
                        ->get(),
                ];
            } catch (\Exception $e) {
                # code
            }
        }
    }

    return $data;
});
@endphp

@push('header')
    <link href="/themes/missav/css/all.css" rel="stylesheet" type="text/css" />
@endpush

@section('body')
    {{-- <body class="bg-[#1a1a1a] font-sans leading-normal tracking-normal"></body> --}}
    @include('themes::missav.inc.nav')
    <div class="w-full pt-14">
        <div class="container mx-auto px-4 md:px-8 xl:px-40 md:mt-4 mb-8 text-gray-800 leading-normal">
            <div class="flex flex-row flex-wrap flex-grow mt-2">
                <div class="w-full">
                    <div class="w-full">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <footer class="container mx-auto px-4">
        <div class="max-w-7xl mx-auto py-12 lg:py-16">
            {!! get_theme_option('footer') !!}
        </div>
    </footer>

    @if (get_theme_option('ads_catfish'))
        <div id="catfish" style="width: 100%;position:fixed;bottom:0;left:0;z-index:222" class="mp-adz">
            <div style="position: relative; margin: 0 auto; text-align: center; overflow: visible;" id="container-ads">
                <button id="close-catfish" style="position: absolute; top: -10px; right: 10px; background-color: transparent; border: none; font-size: 20px; cursor: pointer; color: #fff;">&times;</button>
                {!! get_theme_option('ads_catfish') !!}
            </div>
        </div>

        <script>
            document.getElementById('close-catfish').addEventListener('click', function() {
                document.getElementById('catfish').style.display = 'none';
            });
        </script>
    @endif
    {{-- <div class="relative">
        <div class="container text-center mx-auto px-4 md:px-8 xl:px-40 fixed bottom-0 right-0 left-0 z-40">
            <button id="close-catfish" style="position: absolute; top: -10px; right: 10px; background-color: transparent; border: none; font-size: 20px; cursor: pointer; color: #fff;">&times;</button>
            {!! get_theme_option('ads_catfish') !!}
        </div>
    </div> --}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://unpkg.com/flowbite@1.6.4/dist/flowbite.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js" integrity="sha512-q583ppKrCRc7N5O0n2nzUiJ+suUv7Et1JGels4bXOaMFQcamPk9HjdUknZuuFjBNs7tsMuadge5k9RzdmO+1GQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    {!! setting('site_scripts_google_analytics') !!}
@endsection
