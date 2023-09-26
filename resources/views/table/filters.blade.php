<x-splade-component is="button-with-dropdown" dusk="filters-dropdown">
    <x-slot:button>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"
            :class="{
                'text-gray-400': !@js($table->hasFiltersEnabled()),
                'text-green-400': @js($table->hasFiltersEnabled()),
            }"
        >
            <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
        </svg>
    </x-slot:button>

    <div
      role="menu"
      aria-orientation="horizontal"
      aria-labelledby="filter-menu"
    >
        <x-splade-form method="GET" :action="url()->current()" :default="['filter' => request()->get('filter') ?: []]">
            @foreach($table->filters() as $filter)
                <div>
                    <h3 class="text-xs uppercase tracking-wide bg-gray-100 dark:bg-gray-700 p-3">
                        {{ $filter->label }}
                    </h3>

                    <div class="p-2 dark:bg-gray-600" style="width: 200px !important;">
                        @if($filter->type === 'select')
                            <x-tomato-admin-select
                                name="filter[{{ $filter->key }}]"
                                placeholder="{!! $filter->label !!}"
                                option-label="{{$filter->option_label}}"
                                option-value="{{$filter->option_value}}"
                                remote-url="{!! $filter->remote_url !!}"
                                remote-root="{{$filter->remote_root}}"
                                paginated="{{$filter->paginated}}"
                                query-by="{{$filter->queryBy}}"
                                type="relation"
                                multiple="{{$filter->mutli}}"
                                @select="table.updateQuery('filter[{{ $filter->key }}]', $event)"
                            >
                                @foreach($filter->options() as $optionKey => $option)
                                    <option @selected($filter->hasValue() && $filter->value == $optionKey) value="{{ $optionKey }}">
                                        {{ $option }}
                                    </option>
                                @endforeach
                            </x-tomato-admin-select>
                        @endif
                        @if($filter->type === 'bool')
                            <label class="relative inline-flex items-center cursor-pointer" @click.prevent="table.updateQuery('filter[{{ $filter->key }}]', {{request()->get('filter') && isset(request()->get('filter')[$filter->key]) && request()->get('filter')[$filter->key] == '1' ? '0' : '1'}} )">
                                <input type="checkbox" @if(request()->get('filter') && isset(request()->get('filter')[$filter->key]) && request()->get('filter')[$filter->key] == '1') checked="1" @endif class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200
                                peer-focus:outline-none
                                peer-focus:ring-4
                                peer-focus:ring-primary-300
                                dark:peer-focus:ring-primary-800
                                rounded-full peer
                                dark:bg-gray-700
                                peer-checked:after:translate-x-full
                                peer-checked:after:border-white
                                after:content-['']
                                after:absolute
                                after:top-[2px]
                                after:left-[2px]
                                after:bg-white
                                after:border-gray-300
                                after:border after:rounded-full
                                after:h-5
                                after:w-5
                                after:transition-all
                                dark:border-gray-600
                                peer-checked:bg-blue-600"
                                ></div>
                            </label>
                        @endif
                    </div>
                </div>
            @endforeach
        </x-splade-form>
    </div>
</x-splade-component>
