@extends('themes::missav.layout')

@php
    $years = Cache::remember(
        'all_years',
        \Backpack\Settings\app\Models\Setting::get('site_cache_ttl', 5 * 60),
        function () {
            return \Kho8k\Core\Models\Movie::select('publish_year')->distinct()->pluck('publish_year')->sortDesc();
        },
    );
@endphp

@section('content')
    <ul class="breadcrumb w-full px-2 py-2 mb-3  rounded-lg text-white">
        <li class="inline hover:text-yellow-400" itemprop="itemListElement" itemscope=""
            itemtype="http://schema.org/ListItem">
            <a itemprop="item" href="/" title="Xem phim">
                <span itemprop="name">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-4 h-4 inline">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                    Xem phim »
                </span>
            </a>
            <meta itemprop="position" content="1">
        </li>
        <li class="inline text-gray-400" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
            <a itemprop="item" href="{{ url()->current() }}" title="{{ $section_name ?? 'Danh Sách Phim' }}">
                <span itemprop="name">
                    {{ $section_name ?? 'Danh Sách Phim' }}
                </span>
            </a>
            <meta itemprop="position" content="2">
        </li>
    </ul>
    <form action="/" method="get" id="form-search" class="text-[#ddd] mb-3">
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3 mb-3">
            <div class="block-search">
                <select name="filter[sort]" form="form-search"
                    class="bg-black border border-black text-gray-300 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full p-1">
                    <option value="">Sắp xếp</option>
                    <option value="update" @if (isset(request('filter')['sort']) && request('filter')['sort'] == 'update') selected @endif>Thời gian cập nhật</option>
                    <option value="create" @if (isset(request('filter')['sort']) && request('filter')['sort'] == 'create') selected @endif>Thời gian đăng</option>
                    <option value="year" @if (isset(request('filter')['sort']) && request('filter')['sort'] == 'year') selected @endif>Năm sản xuất</option>
                    <option value="view" @if (isset(request('filter')['sort']) && request('filter')['sort'] == 'view') selected @endif>Lượt xem</option>
                </select>
            </div>

            <div class="block-search">
                <select name="filter[category]" form="form-search"
                    class="bg-black border border-black text-gray-300 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full p-1">
                    <option value="">Tất cả thể loại</option>
                    @foreach (\Kho8k\Core\Models\Category::fromCache()->all() as $item)
                        <option value="{{ $item->id }}" @if (
                            (isset(request('filter')['category']) && request('filter')['category'] == $item->id) ||
                                (isset($category) && $category->id == $item->id)) selected @endif>
                            {{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="block-search">
                <select name="filter[region]" form="form-search"
                    class="bg-black border border-black text-gray-300 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full p-1">
                    <option value="">Tất cả quốc gia</option>
                    @foreach (\Kho8k\Core\Models\Region::fromCache()->all() as $item)
                        <option value="{{ $item->id }}" @if (
                            (isset(request('filter')['region']) && request('filter')['region'] == $item->id) ||
                                (isset($region) && $region->id == $item->id)) selected @endif>
                            {{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="block-search">
                <select name="filter[year]" form="form-search"
                    class="bg-black border border-black text-gray-300 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full p-1">
                    <option value="">Tất cả năm</option>
                    @foreach ($years as $year)
                        <option value="{{ $year }}" @if (isset(request('filter')['year']) && request('filter')['year'] == $year) selected @endif>
                            {{ $year }}</option>
                    @endforeach
                </select>
            </div>
            <div class="block-search grow">
                <button type="submit" form="form-search"
                    class="w-full bg-black hover:bg-opacity-80 rounded-md p-1 flex items-center justify-center">

                    <span class="text-white ">Lọc</span>
                </button>
            </div>

        </div>
    </form>

    <div class="section-heading flex rounded-lg p-0 mb-2">
        <h1 class="inline p-1.5  rounded-l-lg h-text text-white">
            {{ $section_name ?? 'Danh Sách Phim' }}
        </h1>
    </div>
    @if (count($data))
        @php
            $key_section = 0;
        @endphp
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-3 mb-3">
            @foreach ($data ?? [] as $key => $movie)
                @include('themes::missav.inc.movie_card')
            @endforeach
        </div>
    @else
        <div class="flex flex-row flex-wrap flex-grow h-50 mt-10">
            <p class="w-full text-center text-white">Rất tiếc, không có nội dung nào trùng khớp yêu cầu.</p>
        </div>
    @endif

    {{ $data->appends(request()->all())->links('themes::missav.inc.pagination') }}
@endsection
