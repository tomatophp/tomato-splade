<x-splade-component is="group" :name="$name" :inline="$inline" :help="$help" {{ $attributes }}>
    <x-slot:label>{{ $label }}</x-slot:label>

    <div class="flex flex-col gap-1 mt-2">
        @foreach($options as $value => $label)
            <x-splade-component is="radio" :name="$name" :label="$label" :value="$value" />
        @endforeach
    </div>
</x-splade-component>
