<tbody class="divide-y divide-gray-100 dark:divide-gray-600 bg-white dark:bg-gray-800">
    @forelse($table->resource as $itemKey => $item)
        <tr
            :class="{
                'bg-gray-50 dark:bg-gray-700 ': table.striped && @js($itemKey) % 2,
                'hover:bg-gray-100 dark:hover:bg-gray-800': table.striped,
                'hover:bg-gray-50 dark:hover:bg-gray-900 ': !table.striped
            }"
        >
            @if($hasBulkActions = $table->hasBulkActions())
                @php $itemPrimaryKey = $table->findPrimaryKey($item) @endphp
                <td width="64" class="text-xs px-6 py-4 align-middle" :class="{'bg-gray-200': table.itemIsSelected(@js($itemPrimaryKey))}">
                    <div class="h-full">
                        <input
                            @change="(e) => table.setSelectedItem(@js($itemPrimaryKey), e.target.checked)"
                            :checked="table.itemIsSelected(@js($itemPrimaryKey))"
                            :disabled="table.allItemsFromAllPagesAreSelected"
                            class="dark:bg-gray-500 border-gray-200 dark:border-gray-600 rounded text-primary-600 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 disabled:opacity-50"
                            name="table-row-bulk-action"
                            type="checkbox"
                            value="{{ $itemPrimaryKey }}"
                        />
                    </div>
                </td>
            @endif

            @foreach($table->columns() as $column)
                <td
                    @if($table->rowLinks->has($itemKey))
                        @click="(event) => table.visit(@js($table->rowLinks->get($itemKey)), @js($table->rowLinkType), event)"
                    @endif
                    v-show="table.columnIsVisible(@js($column->key))"
                    :class="{'bg-gray-200': table.itemIsSelected(@js($itemPrimaryKey))}"
                    class="whitespace-nowrap align-middle text-sm @if($loop->first && $hasBulkActions) pr-6 @else px-6 @endif py-4 @if($column->highlight) text-gray-900 dark:text-white font-medium text-left rtl:text-right @else text-gray-500 dark:text-gray-200 @endif @if($table->rowLinks->has($itemKey)) cursor-pointer @endif {{ $column->classes }}"
                >
                    @isset(${'spladeTableCell' . $column->keyHash()})
                        {{ ${'spladeTableCell' . $column->keyHash()}($item, $itemKey) }}
                    @else
                        {!! nl2br(e($getColumnDataFromItem($item, $column))) !!}
                    @endisset
                </td>
            @endforeach
        </tr>
    @empty
        <tr>
            <td colspan="{{ $table->columns()->count() }}" class="whitespace-nowrap">
                @if(isset($emptyState) && !!$emptyState)
                    {{ $emptyState }}
                @else
                    <div class="py-12">
                        <div class="flex flex-col justify-center items-center my-2 text-danger-500">
                            <x-heroicon-s-x-circle class="w-16 h-16" />
                        </div>
                        <p class="text-gray-700 dark:text-gray-200 px-6  font-medium text-sm text-center">
                            {{ __('There are no items to show.') }}
                        </p>
                    </div>
                @endif
            </td>
        </tr>
    @endforelse
</tbody>
