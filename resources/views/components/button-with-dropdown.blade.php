<x-splade-component is="dropdown" {{ $attributes }}>
    <x-slot:trigger>
        {{ $button }}
    </x-slot:trigger>

    <div class="mt-2 min-w-max rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5" >
        {{ $slot }}
    </div>
</x-splade-component>
