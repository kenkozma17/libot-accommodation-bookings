<script setup>
const props = defineProps({
    hasSearch: {
        default: true,
        type: Boolean,
    },
});
</script>
<template>
  <div class="flex flex-col">
    <div class="-m-1.5 overflow-x-auto">
      <div class="p-1.5 min-w-full inline-block align-middle">
        <div class="border rounded-lg divide-y divide-gray-200">
          <div class="py-3 px-4">
            <div class="relative">
              <slot name="search"></slot>
              <div v-if="props.hasSearch" class="absolute inset-y-0 left-0 flex items-center pointer-events-none pl-4">
                <svg class="h-3.5 w-3.5 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                </svg>
              </div>
            </div>
          </div>
          <div class="overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <slot name="header"></slot>
              </thead>
              <tbody class="divide-y divide-gray-200">
                <slot name="content"></slot>
              </tbody>
            </table>
          </div>
          <div class="py-1 px-4">
            <slot name="pagination"></slot>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
