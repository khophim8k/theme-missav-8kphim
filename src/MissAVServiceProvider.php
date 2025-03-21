<?php

namespace Kho8k\MissAV;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class MissAVServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->setupDefaultThemeCustomizer();
    }

    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views/', 'themes');

        $this->publishes([
            __DIR__ . '/../resources/assets' => public_path('themes/missav')
        ], 'missav-assets');
    }

    protected function setupDefaultThemeCustomizer()
    {
        config(['themes' => array_merge(config('themes', []), [
            'missav' => [
                'name' => 'MissAV',
                'author' => 'kho8k@gmail.com',
                'package_name' => 'kho8k/theme-missav',
                'publishes' => ['missav-assets'],
                'preview_image' => '',
                'options' => [
                    [
                        'name' => 'recommendations_limit',
                        'label' => 'Recommended movies limit',
                        'type' => 'number',
                        'value' => 10,
                        'wrapperAttributes' => [
                            'class' => 'form-group col-md-4',
                        ],
                        'tab' => 'List'
                    ],
                    [
                        'name' => 'per_page_limit',
                        'label' => 'Pages limit',
                        'type' => 'number',
                        'value' => 20,
                        'wrapperAttributes' => [
                            'class' => 'form-group col-md-4',
                        ],
                        'tab' => 'List'
                    ],
                    [
                        'name' => 'movie_related_limit',
                        'label' => 'Movies related limit',
                        'type' => 'number',
                        'value' => 10,
                        'wrapperAttributes' => [
                            'class' => 'form-group col-md-4',
                        ],
                        'tab' => 'List'
                    ],
                    [
                        'name' => 'latest',
                        'label' => 'Danh sách mới cập nhật',
                        'type' => 'code',
                        'hint' => 'display_label|relation|find_by_field|value|limit|show_more_url',
                        'value' => "Phim sex Hot||is_copyright|0|8|/danh-sach/phim-hot\r\nJAV HD|categories|slug|jav-hd|12|/the-loai/jav-hd\r\nPhim sex vụng trộm|categories|slug|vung-trom|8|/the-loai/vung-trom\r\nPhim sex không che|categories|slug|av-khong-che|12|/the-loai/av-khong-che\r\nMỹ-Châu Âu|regions|slug|trung-quoc|8|/quoc-gia/chau-au",
                        'attributes' => [
                            'rows' => 5
                        ],
                        'tab' => 'List'
                    ],
                    [
                        'name' => 'hotest',
                        'label' => 'Danh sách hot',
                        'type' => 'code',
                        'hint' => 'Label|relation|find_by_field|value|sort_by_field|sort_algo|limit',
                        'value' => "",
                        'attributes' => [
                            'rows' => 5
                        ],
                        'tab' => 'List'
                    ],
                    [
                        'name' => 'additional_css',
                        'label' => 'Additional CSS',
                        'type' => 'code',
                        'value' => "<style>img.logoiframe {width: 15%;heigh:7%;position: absolute;top: 2%;left: 3%;background-color: #00000010;z-index: 100;}</style>",
                        'tab' => 'Custom CSS'
                    ],
                    [
                        'name' => 'body_attributes',
                        'label' => 'Body attributes',
                        'type' => 'text',
                        'value' => "class='bg-[#1a1a1a] font-sans leading-normal tracking-normal'",
                        'tab' => 'Custom CSS'
                    ],
                    [
                        'name' => 'additional_header_js',
                        'label' => 'Header JS',
                        'type' => 'code',
                        'value' => "",
                        'tab' => 'Custom JS'
                    ],
                    [
                        'name' => 'additional_body_js',
                        'label' => 'Body JS',
                        'type' => 'code',
                        'value' => <<<HTML
                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                setTimeout(function() {
                                    var playerDiv = document.getElementById("player-wrapper");

                                    if (playerDiv) {
                                        var imgElement = document.createElement("img");
                                        imgElement.src = "/storage/images/logovl.png";  // Đường dẫn hình ảnh
                                        imgElement.alt = "logo";  // Thuộc tính alt của ảnh
                                        imgElement.className = "logoiframe";  // Thêm class 'logoiframe'
                                        playerDiv.appendChild(imgElement);
                                    }
                                }, 500); // Chờ 1 giây sau khi script trước đã thực thi
                            });
                        </script>
                        <script>
                        var catfishDiv = `<div class="custom-banner-video">
                                                <div class="banner-ads">
                                                </div>
                                            </div>
                                            <style>
                                            .custom-banner-video {
                                                text-align: center;
                                                margin: 5px;
                                            }
                                            </style>
                                            `;
                                            var headerDiv = `
                                            <div class="custom-banner-video">
                                                <div class="banner-ads">
                                                </div>
                                            </div>
                                            <style>
                                            .custom-banner-video {
                                                text-align: center;
                                                margin: 5px;
                                            }

                                            </style>`;

                        var targetBottomElement = document.querySelector(".h-content");
                        var targetTopElement = document.querySelector(".h-content");
                        if (targetBottomElement) {
                            targetBottomElement.insertAdjacentHTML("beforeend", catfishDiv);
                        }
                        if (targetTopElement) {
                            targetTopElement.insertAdjacentHTML("afterbegin", headerDiv);
                        }
                        </script>
                        HTML,
                        'tab' => 'Custom JS'
                    ],
                    [
                        'name' => 'additional_footer_js',
                        'label' => 'Footer JS',
                        'type' => 'code',
                        'value' => "",
                        'tab' => 'Custom JS'
                    ],
                    [
                        'name' => 'footer',
                        'label' => 'Footer',
                        'type' => 'code',
                        'value' => <<<EOT
                        <div class="xl:grid xl:grid-cols-3 xl:gap-8">
                            <div class="space-y-4 xl:col-span-1">
                                <a class="text-4xl leading-normal" href="#">
                                    <img src="" alt="logo" loading="lazy" class="logo-footer">
                                </a>
                                <p class="text-gray-500 text-base">
                                    Hãy đảm bảo rằng bạn đã đủ 18+ tuổi khi xem Phim sex tại Tên Website. Chúng tôi sẽ không chịu bất cứ tránh nhiệm nào nếu bạn nhỏ hơn 18 tuổi mà vẫn xem phim người lớn.
                                    Tất cả nội dung phim đều được dàn dựng từ trước, không có thật, người xem tuyệt đối không bắt chước hành động trong phim, tránh vi phạm pháp luật.
                                </p>
                                <div id="inpage" class="text-gray-900"></div>
                            </div>
                            <div class="grid grid-cols-2 gap-8 xl:mt-0 xl:col-span-2">
                                <div class="md:grid md:grid-cols-2 md:gap-8">
                                    <div>
                                        <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">Video</h3>
                                        <ul class="mt-4 space-y-4">
                                            <li>
                                                <a href="/the-loai/jav-hd" class="text-base text-gray-500 hover:text-primary">JAV HD</a>
                                            </li>
                                            <li>
                                                <a href="/the-loai/av-khong-che" class="text-base text-gray-500 hover:text-primary">
                                                    AV Không Che
                                                </a>
                                            </li>
                                            <li>
                                                <a href="/the-loai/vung-trom" class="text-base text-gray-500 hover:text-primary">
                                                    Vụng trộm
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="md:mt-0 mt-12 ">
                                        <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">Quốc Gia</h3>
                                        <ul class="mt-4 space-y-4">
                                            <li>
                                                <a href="/quoc-gia/nhat-ban" class="text-base text-gray-500 hover:text-primary">Nhật Bản</a>
                                            </li>
                                            <li>
                                                <a href="/quoc-gia/chau-au" class="text-base text-gray-500 hover:text-primary">
                                                    Châu Âu
                                                </a>
                                            </li>
                                            <li>
                                                <a href="/quoc-gia/trung-quoc" class="text-base text-gray-500 hover:text-primary">
                                                    Trung Quốc
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="md:grid md:grid-cols-2 md:gap-8">
                                    <div>
                                        <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">
                                            liên kết
                                        </h3>
                                        <ul class="mt-4 space-y-4">

                                            <li>
                                                <a href="https://t.me/quinzz99" class="text-base text-gray-500 hover:text-primary">
                                                    Yêu cầu quảng cáo
                                                </a>
                                            </li>

                                        </ul>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="mt-12 border-t border-gray-700 pt-8">
                            <p class="flex justify-center items-center text-base text-gray-400 xl:text-center">
                                <a href="#">© 2024</a>
                                <a class="ml-1 align-middle text-lg" href="/"><span style="visibility: visible;" class="font-serif"><span class="text-zinc-50">Tên</span><span class="text-primary">Website</span></span>
                                </a>
                            </p>
                        </div>
                        EOT,
                        'tab' => 'Custom HTML'
                    ],
                    [
                        'name' => 'ads_header',
                        'label' => 'Ads header',
                        'type' => 'code',
                        'value' => <<<EOT
                        <img src="" alt="">
                        EOT,
                        'tab' => 'Ads'
                    ],
                    [
                        'name' => 'ads_catfish',
                        'label' => 'Ads catfish',
                        'type' => 'code',
                        'value' => <<<EOT
                        <img src="" alt="">
                        EOT,
                        'tab' => 'Ads'
                    ]
                ],
            ]
        ])]);
    }
}