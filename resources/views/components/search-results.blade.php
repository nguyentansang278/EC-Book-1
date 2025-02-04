<article class="flex items-start space-x-6 p-2">
    <img src="{{$book->cover_img}}" alt="" class="max-h-16 w-12 flex-none rounded-md bg-slate-100" />
    <div class="min-w-0 relative flex-auto">
        <h2 class="font-semibold text-slate-900 truncate pr-20">{{$book->name}}</h2>
        <dl class="mt-2 flex flex-wrap text-sm leading-6 font-medium">
            <div>
                <dt class="sr-only">Genre</dt>
                <dd class="flex items-center">
                    <svg width="2" height="2" fill="currentColor" class="mx-2 text-slate-300" aria-hidden="true">
                        <circle cx="1" cy="1" r="1" />
                    </svg>

                </dd>
            </div>
            <div>
                <dt class="sr-only">Runtime</dt>
                <dd class="flex items-center">
                    <svg width="2" height="2" fill="currentColor" class="mx-2 text-slate-300" aria-hidden="true">
                        <circle cx="1" cy="1" r="1" />
                    </svg>

                </dd>
            </div>
            <div class="flex-none w-full mt-2 font-normal">
                <dt class="sr-only">Cast</dt>
                <dd class="text-slate-400">{{$book->author_id}}</dd>
            </div>
        </dl>
    </div>
</article>
