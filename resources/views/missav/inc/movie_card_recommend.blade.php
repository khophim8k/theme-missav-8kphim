<div class="thumbnail group pb-12 lg:pb-2 md:pb-2 sm:pb-2 se:pb-2 gl:pb-2">
    <div class="relative aspect-w-16 aspect-h-9 rounded overflow-hidden">
        <a href="{{ $movie->episodes->sortBy([['server', 'asc']])->groupBy('server')->first()->sortByDesc('name', SORT_NATURAL)->groupBy('name')->last()->sortByDesc('type')->first()->getUrl() }}" class="block shadow-lg rounded-md overflow-hidden relative group"
            title="{{ $movie->name ?? '' }}">
            <img class="w-full rounded-md group-hover:opacity-60 transition-all duration-500 transform group-hover:bg-opacity-60"
                style="aspect-ratio: 16/9" src="{{ $movie->getPosterUrl() }}" alt="{{ $movie->name ?? '' }}" />
            @php
                // Lấy giá trị thời gian và chuyển đổi thành số phút
                $timeString = $movie->episode_time;
                $minutes = (int) str_replace(' phút', '', $timeString);

                // Tính giờ và phút
                $hours = floor($minutes / 60);
                $minutes = $minutes % 60;

                // Định dạng thời gian theo dạng hh:mm:ss
                $formattedTime = sprintf('%02d:%02d:00', $hours, $minutes);
            @endphp
            <span
                class="absolute bottom-1 right-1 rounded-lg px-2 py-1 text-xs text-nord5 bg-gray-800 bg-opacity-75">{{ $formattedTime }}</span>
            @if ($movie->status == 'ongoing')
                <span
                    class="absolute bottom-12 right-0 p-0.5 bg-gradient-to-r from-cyan-500/50 to-blue-500/50 text-white text-sm rounded-md rounded-br-none rounded-tr-none">Đang
                    chiếu</span>
            @endif
            <div class="absolute hidden top-1/4 left-1/3 animate-pulse group-hover:block">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 group-hover:text-primary" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2}
                        d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2}
                        d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </a>
    </div>
    <div class="my-2 text-sm text-nord4 truncate">
        <a href="{{ $movie->getUrl() }}" class="text-secondary group-hover:text-primary">
            {{ $movie->name ?? '' }}
        </a>
    </div>
</div>
