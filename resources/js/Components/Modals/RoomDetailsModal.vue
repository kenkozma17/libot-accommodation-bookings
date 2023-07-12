<script setup>
  import { VueFinalModal } from 'vue-final-modal';
  import { defineEmits } from 'vue';

  const emit = defineEmits(['confirm']);
</script>

<template>
  <VueFinalModal
    class="flex justify-center items-center"
    content-class="flex flex-col w-[90%] h-[90%] mx-4 p-4 bg-white border space-y-2"
  >
    <h1 class="text-xl">
      Test
    </h1>
    <slot />
    <button 
      @click="emit('confirm')"
      class="mt-1 ml-auto px-2 border rounded-lg">
      Confirm
    </button>
  </VueFinalModal>
</template>