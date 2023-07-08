<script setup>
  import BookingLayout from '@/Layouts/BookingLayout.vue';
</script>
<template>
  <BookingLayout>
    <div class="border-black border grid grid-cols-12 bg-white">
      <div class="col-span-4">
        <img src="/storage/images/room.jpg" class="w-full" alt="">
      </div>
      <div class="col-span-5 p-4">
        <h2 class="text-[1.5rem] font-bold tracking-wide">Superior Grand Suite</h2>
        <p class="text-[.75rem]">Our Essence double room: cosy 30-35m² for feel-good moments. For you and your favourite person.</p>
      </div>
      <div class="col-span-3 border-l border-black flex flex-col justify-end items-end p-4 space-y-3">
        <p class="text-dark-green font-bold text-[1.25rem]">PHP 1,000.00 / night</p>
        <button class="uppercase border border-dark-green font-bold text-[1rem] p-2.5 w-full">Select</button>
      </div>
    </div>
  </BookingLayout>
</template>