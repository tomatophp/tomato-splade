@if($customBody)
    {{ $slot }}
@else
<div class="flex flex-col">
    <div class="-my-2 overflow-x-auto">
        <div class="py-2 align-middle inline-block min-w-full sm:px-px">
            <div class="shadow-sm relative border border-gray-200 dark:border-gray-700">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
@endif
