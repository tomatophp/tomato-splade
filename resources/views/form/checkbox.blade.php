<div {{ $attributes->only(['v-if', 'v-show', 'class']) }}>
    <label class="flex items-center">
        <input {{ $attributes->except(['v-if', 'v-show', 'class'])->class(
            'dark:bg-gray-700 dark:border-gray-600 rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 disabled:opacity-50'
        )->merge([
            'name' => $name,
            'value' => $value,
            'type' => 'checkbox',
            'v-model' => $vueModel(),
            'data-validation-key' => $validationKey(),
        ]) }} :true-value="@js($value)" :false-value="@js($falseValue)" />

        @if(trim($slot))
            <span class="ml-2 rtl:mr-2 rtl:ml-0 dark:text-gray-200">{{ $slot }}</span>
        @else
            <span class="ml-2 rtl:mr-2 rtl:ml-0 dark:text-gray-200">{{ $label }}</span>
        @endif
    </label>

    @includeWhen($help, 'splade::form.help', ['help' => $help])
    @includeWhen($showErrors, 'splade::form.error', ['name' => $validationKey()])
</div>


