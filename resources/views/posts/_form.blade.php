@csrf
@isset($post)
    @method('PUT')
@endisset

<div class="mb-6">
    <label for="title" class="block text-xs tracking-widest uppercase text-muted mb-2">Title</label>
    <input type="text" name="title" id="title" required
           value="{{ old('title', $post->title ?? '') }}"
           placeholder="Give it a headline"
           class="font-display text-2xl w-full border-0 border-b border-hairline focus:border-signal focus:ring-0 px-0 py-2 bg-transparent placeholder:text-muted/50">
</div>

<div class="mb-6">
    <label for="content" class="block text-xs tracking-widest uppercase text-muted mb-2">Content</label>
    <textarea name="content" id="content" required rows="10"
              placeholder="Write your post..."
              class="w-full border border-hairline rounded-md focus:border-signal focus:ring-1 focus:ring-signal px-4 py-3 text-sm leading-relaxed placeholder:text-muted/50">{{ old('content', $post->content ?? '') }}</textarea>
</div>

<div class="mb-8">
    <label for="image" class="block text-xs tracking-widest uppercase text-muted mb-2">Image</label>

    @isset($post)
        @if ($post->image)
            <img src="{{ asset('storage/'.$post->image) }}" alt=""
                 class="w-32 h-32 object-cover rounded-md bg-hairline mb-3">
            <p class="text-xs text-muted mb-2">Choose a new file to replace the current image.</p>
        @endif
    @endisset

    <input type="file" name="image" id="image" accept="image/*"
           class="block w-full text-sm text-muted file:mr-4 file:py-2 file:px-4 file:rounded-md file:border file:border-hairline file:text-sm file:bg-white hover:file:border-signal file:cursor-pointer">
</div>
