<SpladeInput
    {{ $attributes->only(['v-if', 'v-show', 'v-for', 'class'])->class(['hidden' => $isHidden()]) }}
    :flatpickr="@js($flatpickrOptions())"
    :js-flatpickr-options="{!! $jsFlatpickrOptions !!}"
    v-model="{{ $vueModel() }}"
    #default="inputScope"
>
    <label class="block">
        @includeWhen($label, 'splade::form.label', ['label' => $label])

        <div class="flex rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm dark:text-white ">
            @if($prepend)
                <span :class="{ 'opacity-50': inputScope.disabled && @json(!$alwaysEnablePrepend) }" class="inline-flex items-center px-3 rounded-l-md border border-t-0 border-b-0 border-l-0 border-gray-300 bg-gray-50 dark:bg-gray-700 dark:text-gray-200 text-gray-50 dark:text-white">
                    {!! $prepend !!}
                </span>
            @endif

            <input {{ $attributes->except(['v-if', 'v-show', 'v-for', 'class'])->class([
                'fi-input block w-full border-none bg-white dark:bg-gray-800 py-1.5 text-base text-gray-950 outline-none transition duration-75' => true,
                'placeholder:text-gray-400  disabled:text-gray-500 disabled:[-webkit-text-fill-color:theme(colors.gray.500)]',
                'disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.400)] dark:text-white dark:placeholder:text-gray-500',
                'dark:disabled:text-gray-400 dark:disabled:[-webkit-text-fill-color:theme(colors.gray.400)]',
                'dark:disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.500)] sm:text-sm sm:leading-6 ps-3 pe-3',
                'focus:ring-2 ring-primary-500 focus:ring-2 focus:ring-primary-500',
                'rounded-lg' => !$append && !$prepend,
                'min-w-0 flex-1 rounded-none' => $append || $prepend,
                'rounded-l-lg' => $append && !$prepend,
                'rounded-r-lg' => !$append && $prepend,
            ])->merge([
                'name' => $name,
                'type' => $type,
                'v-model' => $flatpickrOptions() ? null : $vueModel(),
                'data-validation-key' => $validationKey(),
            ])  }}
            />

            @if($append)
                <span :class="{ 'opacity-50': inputScope.disabled && @json(!$alwaysEnableAppend) }" class="inline-flex items-center px-3 rounded-r-md border border-t-0 border-b-0 border-r-0 border-gray-300 bg-gray-50 dark:bg-gray-700 dark:text-gray-200 text-gray-500 dark:text-white">
                    {!! $append !!}
                </span>
            @endif
        </div>
    </label>

    @include('splade::form.help', ['help' => $help])
    @includeWhen($showErrors, 'splade::form.error', ['name' => $validationKey()])
</SpladeInput>
