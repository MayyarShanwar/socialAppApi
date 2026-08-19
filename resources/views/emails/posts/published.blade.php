<x-mail::message>
    # Introduction
    Hello {{ $user->name }}
    Your new post has been successfully published to our platform.
    {{ $post->title }}
    <x-mail::button :url="config('app.name') . '/posts/' . $post->id">
        View your post
    </x-mail::button>

    Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>
