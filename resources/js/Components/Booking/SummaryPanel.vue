<script setup>
  import { useBookingStore } from '@/stores/booking';
  import { Link } from '@inertiajs/vue3';

  const bookingStore = useBookingStore();
</script>
<template>
  <div>
    <div class="border border-black bg-white">
      <div class="border-b border-black text-center py-5 px-2">
        <p class="text-[.875rem] font-bold uppercase tracking-widest">Stay Summary</p>
      </div>
      <div class="content p-4">
        <div class="grid grid-cols-5 justify-start">
          <div class="col-span-4">
            <p class="text-[.85rem] font-bold">Stay at Catanduanes Midtown Inn</p>
            <span class="text-[.7rem]">
              {{ bookingStore.room.name }}
            </span>
          </div>
          <div class="flex justify-end items-start"> 
            <Link 
              href="/rooms"
              :data="{ edit: true, dates: bookingStore.dates }"
              class="text-[.85rem] font-bold">
              Edit
            </Link>
          </div>
        </div>
        <div class="ml-3 mt-2 pl-2 border-l-2 border-black border-opacity-25 ">
          <div>
            <p class="text-[.85rem] font-bold">Check In & Out Dates</p>
            <span class="text-[.7rem]">{{ bookingStore.checkInDate }} - {{ bookingStore.checkOutDate }} 
              ( {{ bookingStore.stayCount }} nights x {{ bookingStore.room.currency }} {{ bookingStore.room.price.toLocaleString() }} )
            </span>
          </div>

          <div class="mt-2.5">
            <p class="text-[.85rem] font-bold">Guests</p>
            <span class="text-[.7rem]">
              {{ bookingStore.guestsCountDetailed }}
            </span>
          </div>
        </div>
      </div>
    </div>
    <div class="bg-white border-black border border-t-0 py-5 px-5 grid grid-cols-2">
      <p class="text-[.875rem] font-bold uppercase tracking-widest">Total</p>
      <p class="text-[.875rem] font-bold uppercase tracking-widest text-right">
        {{ bookingStore.room.currency }} {{ bookingStore.subTotal.toLocaleString() }}
      </p>
    </div>
  </div>
</template>