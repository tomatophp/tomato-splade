@if($name)<p class="text-danger-600 text-sm mt-2 font-sans" v-if="form.hasError(@js($name))" v-bind="form.$errorAttributes(@js($name))" />@endif
