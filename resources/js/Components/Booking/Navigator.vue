<script setup>
  import { Link } from '@inertiajs/vue3'
  import { ref } from 'vue';
  import CalendarIcon from '@/Components/Icons/CalendarIcon.vue';
  import TagIcon from '@/Components/Icons/TagIcon.vue';
  import UserIcon from '@/Components/Icons/UserIcon.vue';
  import FileIcon from '@/Components/Icons/FileIcon.vue';

</script>
<template>
  <div class="m-6">
    <div class="border border-gray-200 w-full bg-white">
      <div class="grid grid-cols-4">
        <Link href="/" class="flex flex-col items-center border border-black py-5 hover:bg-gray-200 cursor-pointer">
          <CalendarIcon></CalendarIcon>
          <span class="text-[0.875rem] font-bold mt-1">Dates</span>
        </Link>
        <Link href="/rooms" class="flex flex-col items-center border border-black border-l-0 py-5 hover:bg-gray-200 cursor-pointer">
          <TagIcon></TagIcon>
          <span class="text-[0.875rem] font-bold mt-1">Room</span>
        </Link>
        <Link href="/booking-details" class="flex flex-col items-center border border-black border-l-0 py-5 hover:bg-gray-200 cursor-pointer">
          <UserIcon></UserIcon>
          <span class="text-[0.875rem] font-bold mt-1">Personal Data</span>
        </Link>
        <Link href="/payment" class="flex flex-col items-center border border-black border-l-0 py-5 hover:bg-gray-200 cursor-pointer">
          <FileIcon></FileIcon>
          <span class="text-[0.875rem] font-bold mt-1">Payment</span>
        </Link>
      </div>
      <div class="grid grid-cols-4">
        <div class="border-b-4 border-black">
        </div>
        <div 
          class="border-b-4 border-black" >
          </div>
        <div 
          class="border-b-4 border-black">
          </div>
        <div class="border-b-4 border-black border-opacity-25"></div>
      </div>
    </div>
  </div>
</template>