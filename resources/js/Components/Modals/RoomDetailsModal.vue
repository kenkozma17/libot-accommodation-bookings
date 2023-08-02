<script setup>
  import { VueFinalModal } from 'vue-final-modal';
  import { defineEmits } from 'vue';

  const emit = defineEmits(['confirm']);
  const props = defineProps({
    room: Object,
  })
</script>

<template>
  <VueFinalModal
    class="flex justify-center items-center"
    content-class="flex flex-col w-[90%] h-[90%] mx-4 p-4 bg-white border space-y-2"
  >
  <div class="grid-cols-2 py-10 px-20">
    <div class="col-span-1">
      <h2 class="md:text-[2.5rem] text-[1.25rem] font-bold tracking-wide">
        {{ props.room.name }}
      </h2>
    </div>
    <div class="col-span-1">

    </div>
    <button 
      @click="emit('confirm')"
      class="mt-1 ml-auto px-2 border rounded-lg">
      Confirm
    </button>
  </div>
  </VueFinalModal>
</template>