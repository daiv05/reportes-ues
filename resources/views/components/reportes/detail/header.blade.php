@props(['title'])
<div class="flex flex-col lg:flex-row justify-center lg:justify-between">
    <div class="w-full lg:w-[70%] px-8 mb-4 flex justify-center lg:justify-start">
        <div class="text-xl font-bold lg:ml-4 mb-8">
            <p>{{ $title }}</p>
        </div>
    </div>
    <div class="w-full lg:w-[30%] px-8 mb-4 flex justify-center lg:justify-end">
        {{ $slot }}
    </div>
</div>