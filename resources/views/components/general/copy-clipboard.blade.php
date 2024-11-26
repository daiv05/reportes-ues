@props(['content', 'targetId'])
<button :data-copy-to-clipboard-target="$targetId"
    onclick="noty('Texto copiado', 'success')"
    data-copy-to-clipboard-content-type="textContent"
    class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg p-2 inline-flex items-center justify-center">
    <span :id="$targetId">{{ $content }}</span>
</button>