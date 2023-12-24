<x-splade-component is="dropdown" {{ $attributes }}>
    <x-slot:trigger>
        {{ $button }}
    </x-slot:trigger>

    <div class="mt-2 min-w-max rounded-lg border border-gray-200 dark:border-gray-700 dark:bg-gray-800 shadow-lg bg-white ring-1 ring-black ring-opacity-5" >
        {{ $slot }}
    </div>
</x-splade-component>
