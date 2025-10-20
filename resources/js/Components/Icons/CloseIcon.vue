<script setup>
const props = defineProps({
  fill: {
    type: String,
    default: 'none',
  },
  stroke: {
    type: String,
    default: 'currentColor'
  }
});
</script>
<template>
  <svg
    class="h-8 w-8 text-black"
    viewBox="0 0 24 24"
    :fill="props.fill"
    :stroke="props.stroke"
    stroke-width="2"
    stroke-linecap="round"
    stroke-linejoin="round"
  >
    <line x1="18" y1="6" x2="6" y2="18" />
    <line x1="6" y1="6" x2="18" y2="18" />
  </svg>
</template>
