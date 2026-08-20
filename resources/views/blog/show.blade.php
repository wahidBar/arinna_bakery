@extends('layouts.app')

@section('title', $blog ? $blog->title : 'Blog / News')

@section('content')
@include('partials.breadcrumb', [
'items' => [
['label' => 'Blog', 'url' => route('blog.index')],
['label' => $blog ? $blog->title : 'Artikel'],
]
])
<section class="section-blog-details py-[50px] max-[1199px]:py-[35px]">
    <div class="flex flex-wrap justify-between relative mx-auto min-[1400px]:max-w-[1320px] min-[1200px]:max-w-[1140px] min-[992px]:max-w-[960px] min-[768px]:max-w-[720px] min-[576px]:max-w-[540px]">
        <div class="flex flex-wrap mb-[-24px] w-full">
            @if(!$blog)
            <div class="min-[1200px]:w-[66.66%] min-[992px]:w-[58.33%] w-full px-[12px] mb-[24px]">
                <div class="text-center py-20 bg-white rounded-2xl border border-amber-100 shadow-sm">
                    <h2 class="text-xl font-bold text-stone-700 font-quicksand">Belum Ada Artikel</h2>
                    <p class="text-stone-500 mt-2">Maaf, saat ini belum ada artikel yang dipublikasikan di kategori ini.</p>
                    <a href="{{ route('blog.index') }}" class="inline-block mt-4 text-[#6c7fd8] hover:underline">Kembali ke semua artikel</a>
                </div>
            </div>
            @else
            <div class="min-[1200px]:w-[66.66%] min-[992px]:w-[58.33%] w-full px-[12px] mb-[24px]">
                <div class="bb-blog-details-contact aos-init aos-animate" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
                    <div class="inner-blog-details-image mb-[24px]">
                        <img src="{{ asset('storage/' . $blog->thumbnail) }}" alt="{{ $blog->title }}" class="w-full rounded-[15px] max-h-[500px] object-cover">
                    </div>
                    <div class="inner-blog-details-contact mb-[30px]">
                        <span class="font-Poppins mb-[6px] text-[15px] leading-[26px] font-light tracking-[0.02rem] text-[#777]">
                            {{ $blog->published_at?->format('M d, Y') }}
                        </span>
                        <h4 class="sub-title font-quicksand tracking-[0.03rem] leading-[1.2] mb-[12px] text-[22px] font-bold text-[#3d4750] max-[575px]:text-[20px]">
                            {{ $blog->title }}
                        </h4>

                        <div class="prose prose-stone max-w-none text-stone-700 leading-relaxed font-Poppins text-[#686e7d] tracking-[0.03rem]">
                            {!! $blog->content !!}
                        </div>
                    </div>

                    {{-- Share button (maintained from original) --}}
                    <div class="flex gap-3 mb-8 pt-6 border-t border-amber-100">
                        <span class="text-sm text-stone-500 self-center">Bagikan:</span>
                        <a href="https://wa.me/?text={{ urlencode($blog->title . ' - ' . request()->fullUrl()) }}" target="_blank"
                            class="text-xs font-medium bg-green-500 text-white px-3 py-1.5 rounded-full">WhatsApp</a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" target="_blank"
                            class="text-xs font-medium bg-blue-600 text-white px-3 py-1.5 rounded-full">Facebook</a>
                    </div>

                    @isset($paginator)
                    <div class="mb-10 border-t border-amber-100 pt-6">
                        {{ $paginator->links() }}
                    </div>
                    @endisset

                    <div class="bb-blog-details-comment mb-[30px]">
                        <div class="main-title mb-[12px]">
                            <h4 class="font-quicksand tracking-[0.03rem] leading-[1.2] text-[20px] font-bold text-[#3d4750]">Comments ({{ $blog->comments->count() }})</h4>
                        </div>

                        @forelse($blog->comments as $comment)
                        <div class="bb-comment-box flex mb-[24px] max-[575px]:flex-col">
                            <div class="inner-image mr-[15px] max-[575px]:mr-[0] max-[575px]:mb-[15px]">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($comment->name) }}&background=random" alt="{{ $comment->name }}" class="max-w-[50px] rounded-[15px]">
                            </div>
                            <div class="inner-contact flex flex-col justify-center">
                                <h5 class="sub-title font-quicksand tracking-[0.03rem] leading-[1.2] mb-[4px] text-[16px] font-bold text-[#3d4750]">{{ $comment->name }}</h5>
                                <span class="font-Poppins leading-[26px] tracking-[0.02rem] mb-[4px] text-[14px] font-light text-[#777]">{{ $comment->created_at->format('M d, Y') }}</span>
                                <p class="font-Poppins mb-[6px] text-[14px] font-light leading-[28px] tracking-[0.03rem] text-[#686e7d]">
                                    {{ $comment->message }}
                                </p>
                                <a href="#reply-form" onclick="document.getElementById('parent_id').value = '{{ $comment->id }}'" class="bb-details-btn transition-all duration-[0.3s] ease-in-out text-[13px] font-semibold leading-[28px] tracking-[0.03rem] uppercase text-[#6c7fd8]">Reply <i class="ri-arrow-right-line transition-all duration-[0.3s] ease-in-out text-[15px] font-semibold text-[#6c7fd8]"></i></a>
                            </div>
                        </div>

                        @foreach($comment->replies as $reply)
                        <div class="bb-comment-box second flex mb-[24px] max-[575px]:flex-col pl-[50px]">
                            <div class="inner-image mr-[15px] max-[575px]:mr-[0] max-[575px]:mb-[15px]">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($reply->name) }}&background=random" alt="{{ $reply->name }}" class="max-w-[50px] rounded-[15px]">
                            </div>
                            <div class="inner-contact flex flex-col justify-center">
                                <h5 class="sub-title font-quicksand tracking-[0.03rem] leading-[1.2] mb-[4px] text-[16px] font-bold text-[#3d4750]">{{ $reply->name }}</h5>
                                <span class="font-Poppins leading-[26px] tracking-[0.02rem] mb-[4px] text-[14px] font-light text-[#777]">{{ $reply->created_at->format('M d, Y') }}</span>
                                <p class="font-Poppins mb-[6px] text-[14px] font-light leading-[28px] tracking-[0.03rem] text-[#686e7d]">
                                    {{ $reply->message }}
                                </p>
                            </div>
                        </div>
                        @endforeach
                        @empty
                        <p class="text-sm text-gray-500">Belum ada komentar.</p>
                        @endforelse
                    </div>

                    <div class="bb-blog-details-comment" id="reply-form">
                        <div class="main-title mb-[12px]">
                            <h4 class="font-quicksand tracking-[0.03rem] leading-[1.2] text-[20px] font-bold text-[#3d4750]">Leave A Reply</h4>
                        </div>
                        @if(session('success'))
                        <div class="mb-4 text-sm text-green-600 bg-green-100 border border-green-400 p-3 rounded">
                            {{ session('success') }}
                        </div>
                        @endif
                        <form method="post" action="{{ route('blog.comments.store', $blog) }}">
                            @csrf
                            <input type="hidden" name="parent_id" id="parent_id" value="">
                            <div class="flex flex-wrap mx-[-12px]">
                                <div class="min-[992px]:w-[50%] w-full px-[12px]">
                                    <div class="bb-details-input mb-[24px]">
                                        <input type="text" name="name" required placeholder="Enter Your Name" class="w-full p-[10px] text-[14px] font-normal text-[#686e7d] border-[1px] border-solid border-[#eee] outline-[0] leading-[26px] rounded-[10px]">
                                        @error('name')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                                <div class="min-[992px]:w-[50%] w-full px-[12px]">
                                    <div class="bb-details-input mb-[24px]">
                                        <input type="email" name="email" required placeholder="Enter Your Email" class="w-full p-[10px] text-[14px] font-normal text-[#686e7d] border-[1px] border-solid border-[#eee] outline-[0] leading-[26px] rounded-[10px]">
                                        @error('email')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                                <div class="w-full px-[12px]">
                                    <div class="bb-details-input mb-[24px]">
                                        <textarea name="message" required placeholder="Message" class="w-full h-[200px] p-[10px] text-[14px] font-normal text-[#686e7d] border-[1px] border-solid border-[#eee] outline-[0] rounded-[10px]"></textarea>
                                        @error('message')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                                <div class="w-full px-[12px]">
                                    <div class="bb-details-buttons flex gap-2">
                                        <button type="submit" class="bb-btn-2 transition-all duration-[0.3s] ease-in-out font-Poppins leading-[28px] tracking-[0.03rem] py-[4px] px-[18px] text-[14px] font-normal text-[#fff] bg-[#6c7fd8] rounded-[10px] border-[1px] border-solid border-[#6c7fd8] hover:bg-transparent hover:border-[#3d4750] hover:text-[#3d4750]">Post Comment</button>
                                        <button type="button" onclick="document.getElementById('parent_id').value=''" class="transition-all duration-[0.3s] ease-in-out font-Poppins leading-[28px] tracking-[0.03rem] py-[4px] px-[18px] text-[14px] font-normal text-[#3d4750] bg-gray-200 rounded-[10px] border-[1px] border-solid border-gray-300 hover:bg-gray-300">Cancel Reply</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endif
            <div class="min-[1200px]:w-[33.33%] min-[992px]:w-[41.66%] w-full px-[12px] mb-[24px]">
                <div class="bb-blog-sidebar mb-[-24px]">
                    <div class="blog-inner-contact p-[30px] border-[1px] border-solid border-[#eee] mb-[24px] rounded-[20px] max-[575px]:p-[15px] aos-init aos-animate" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                        <div class="blog-sidebar-title mb-[20px]">
                            <h4 class="font-quicksand tracking-[0.03rem] leading-[1.2] text-[20px] font-bold text-[#3d4750] max-[575px]:text-[18px]">Recent Articles</h4>
                        </div>
                        @foreach($recentBlogs as $recent)
                        <div class="blog-sidebar-card mb-[24px] p-[15px] bg-[#f8f8fb] border-[1px] border-solid border-[#eee] rounded-[20px] flex max-[991px]:flex-row max-[360px]:flex-col">
                            <div class="inner-image mr-[15px] max-[991px]:mr-[20px] max-[991px]:mb-[0] max-[360px]:mr-[0] max-[360px]:mb-[15px]">
                                <img src="{{ asset('storage/' . $recent->thumbnail) }}" alt="{{ $recent->title }}" class="max-w-[80px] h-[80px] object-cover rounded-[20px] max-[360px]:max-w-full">
                            </div>
                            <div class="blog-sidebar-contact">
                                <span class="font-Poppins text-[13px] font-normal leading-[26px] tracking-[0.02rem] text-[#6c7fd8]">{{ $recent->category->name ?? 'Uncategorized' }}</span>
                                <h4 class="text-[15px] mb-[8px] leading-[1.2]"><a href="{{ route('blog.show', $recent->slug) }}" class="font-Poppins tracking-[0.03rem] text-[15px] font-medium leading-[18px] text-[#3d4750] line-clamp-2">{{ $recent->title }}</a></h4>
                                <p class="font-Poppins tracking-[0.03rem] text-[13px] leading-[16px] font-light text-[#686e7d]">{{ $recent->published_at?->format('M d, Y') }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="blog-inner-contact p-[30px] border-[1px] border-solid border-[#eee] mb-[24px] rounded-[20px] max-[575px]:p-[15px] aos-init aos-animate" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
                        <div class="blog-sidebar-title mb-[20px]">
                            <h4 class="font-quicksand tracking-[0.03rem] leading-[1.2] text-[20px] font-bold text-[#3d4750] max-[575px]:text-[18px]">Categories</h4>
                        </div>
                        <div class="blog-categories">
                            <ul class="mb-[-14px]">
                                @foreach($categories as $category)
                                <li class="relative mb-[14px] leading-[28px]">
                                    <div class="bb-sidebar-block-item relative">
                                        <input type="checkbox" onchange="window.location.href='{{ route('blog.index', ['category' => $category->slug]) }}'" {{ request('category') == $category->slug ? 'checked' : '' }} class="w-full h-[calc(100%-5px)] absolute opacity-[0] cursor-pointer z-[999] top-[50%] left-[0] translate-y-[-50%] p-[10px] text-[14px] font-normal text-[#686e7d] border-[1px] border-solid border-[#eee] outline-[0] rounded-[10px]">
                                        <a href="{{ route('blog.index', ['category' => $category->slug]) }}" class="ml-[30px] block text-[#777] text-[14px] mt-[0] leading-[20px] font-normal capitalize cursor-pointer">{{ $category->name }} ({{ $category->blogs_count }})</a>
                                        <span class="checked absolute top-[0] left-[0] h-[18px] w-[18px] {{ request('category') == $category->slug ? 'bg-[#6c7fd8] border-[#6c7fd8]' : 'bg-[#fff] border-[#eee]' }} border-[1px] border-solid rounded-[5px] overflow-hidden transition-all duration-[300ms] linear"></span>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @if($blog->instagram_link)
                    @php
                    // Extract the canonical part (strip query string)
                    $igLink = strtok($blog->instagram_link, '?');
                    $igLink = rtrim($igLink, '/') . '/';
                    // Build the proper embed URL:
                    // e.g. https://www.instagram.com/reel/ABC123/embed/
                    // strip username segment if present: /username/reel/CODE/ → /reel/CODE/
                    $igEmbedUrl = preg_replace('#instagram\.com/[^/]+/(reel|p|tv)/([^/]+)/#', 'instagram.com/$1/$2/embed/', $igLink);
                    // if URL already has /embed/ no change needed
                    if (!str_contains($igEmbedUrl, '/embed/')) {
                    $igEmbedUrl = $igLink . 'embed/';
                    }
                    @endphp
                    <div class="mt-8 flex justify-center w-full">
                        <div style="max-width:500px; width:100%; border-radius:15px; overflow:hidden; box-shadow:0 0 1px rgba(0,0,0,.5),0 1px 10px rgba(0,0,0,.15);">
                            <iframe src="{{ $igEmbedUrl }}"
                                width="100%"
                                height="640"
                                frameborder="0"
                                scrolling="no"
                                allowtransparency="true"
                                allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"
                                loading="lazy"
                                style="background:#fff; display:block;">
                            </iframe>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection