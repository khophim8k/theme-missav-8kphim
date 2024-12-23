@php
$logo = setting('site_logo', '');
$brand = setting('site_brand', '');
$title = isset($title) ? $title : setting('site_homepage_title', '');
@endphp

<nav class="w-full fixed top-0 py-3 bg-transform z-max">
    <div class="container mx-auto px-4 md:px-8 xl:px-40 flex flex-wrap justify-between items-center">
        <div class="w-2/5 md:w-1/5 flex items-center">
            <a class="text-gray-100 text-base xl:text-xl no-underline hover:no-underline font-bold content-center" href="/">
                @if ($logo)
                    {!! $logo !!}
                @else
                    {!! $brand !!}
                @endif
            </a>
        </div>
        <button data-collapse-toggle="mobile-menu" type="button"
            class="inline-flex justify-center items-center ml-3 rounded-lg md:hidden text-gray-400 hover:text-white focus:ring-gray-500"
            aria-controls="mobile-menu-2" aria-expanded="false">
            <span class="sr-only">Open main menu</span>
            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                    d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                    clip-rule="evenodd"></path>
            </svg>
        </button>
        <div class="hidden md:flex items-center w-full md:w-auto" id="mobile-menu">
            <ul class="flex flex-col md:flex-row md:text-xl">
                @foreach ($menu as $item)
                    <li class="mr-6 my-2 md:my-0 dropdown relative group">
                        @if (count($item['children']))
                            <button data-dropdown-toggle="nav-dropdown-{{ $loop->index }}"
                                class="flex justify-between items-center py-2 pr-4 w-full font-medium text-slate-200 hover:text-primary md:p-0 md:w-auto">
                                {{ $item->name }}
                                <svg class="ml-1 w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </button>
                            <div id="nav-dropdown-{{ $loop->index }}"
                                class="hidden z-20 w-[80vw] md:w-[50vw] xl:w-[35vw] font-normal divide-x shadow">
                                <ul class="py-1 text-sm text-slate-300 bg-[#151111] grid grid-cols-2 md:grid-cols-4 xl:grid-cols-5"
                                    aria-labelledby="dropdownLargeButton">
                                    @foreach ($item['children'] as $children)
                                        <li class="inline-block p-1 truncate text-center">
                                            <a href="{{ $children['link'] }}"
                                                class="block py-2 hover:bg-slate-800">{{ $children['name'] }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            <a href="{{ $item['link'] }}" class="flex items-center">
                                <span class="text-white">{{ $item['name'] }}</span>
                            </a>
                        @endif
                    </li>
                @endforeach

            </ul>
        </div>

    </div>
</nav>
