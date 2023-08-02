<script setup>
  import Navigator from '@/Components/Booking/Navigator.vue';
  import DetailsPanel from '@/Components/Booking/DetailsPanel.vue';
  import { ModalsContainer } from 'vue-final-modal';
</script>
<template>
  <div class="max-w-7xl mx-auto">
    <div class="m-4">
      <ModalsContainer />
      <Navigator></Navigator>
      <DetailsPanel class="my-4"></DetailsPanel>
      <div>
        <slot></slot>
      </div>
    </div>
  </div>
</template>