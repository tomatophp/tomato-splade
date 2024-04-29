<div {{ $attributes->only(['v-if', 'v-show', 'class']) }}>
    <label class="flex items-center">
        <input {{ $attributes->except(['v-if', 'v-show', 'class'])->class(
            'rounded-full dark:bg-zinc-700 dark:border-zinc-600 border-zinc-200 text-primary-600 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 disabled:opacity-50'
        )->merge([
            'name' => $name,
            'value' => $value,
            'type' => 'radio',
            'v-model' => $vueModel(),
            'data-validation-key' => $validationKey(),
        ]) }}
        />

        @if(trim($slot))
            <span class="ltr:ml-2 rtl:mr-2">{{ $slot }}</span>
        @else
            <span class="ltr:ml-2 rtl:mr-2">{{ $label }}</span>
        @endif
    </label>

    @includeWhen($help, 'splade::form.help', ['help' => $help])
    @includeWhen($showErrors, 'splade::form.error', ['name' => $validationKey()])
  </div>


