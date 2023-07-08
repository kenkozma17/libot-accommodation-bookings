<script setup>
  import Navigator from '@/Components/Booking/Navigator.vue';
  import DetailsPanel from '@/Components/Booking/DetailsPanel.vue';
</script>
<template>
  <div class="m-4">
    <Navigator></Navigator>
    <DetailsPanel class="my-4"></DetailsPanel>
    <div>
      <slot></slot>
    </div>
  </div>
</template>