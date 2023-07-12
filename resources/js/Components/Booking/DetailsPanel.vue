<script setup>
  import { ref, reactive, onBeforeMount, computed } from 'vue';
  import { router } from '@inertiajs/vue3';
  import { useBookingStore } from '@/stores/booking';
  import dayjs from 'dayjs';
  
  const bookingStore = useBookingStore();

  const bookingDetails = reactive({
    date: {
      start: null,
      end: null,
    },
    guests: {
      adults: 1,
      children: 0,
    }
  });

  const showDatePicker = ref(false);
  const showPanel = ref(true);

  const checkInDate = computed(() => {
    return dayjs(bookingDetails.date.start).format('MMMM D, YYYY');
  });

  const checkOutDate = computed(() => {
    return dayjs(bookingDetails.date.end).format('MMMM D, YYYY');
  });

  function toggleDatePicker() {
    showDatePicker.value = !showDatePicker.value;
  }

  function updateDates() {
    bookingStore.setCheckIn(
      dayjs(bookingDetails.date.start).toISOString()
    );
    bookingStore.setCheckOut(
      dayjs(bookingDetails.date.end).toISOString()
    );
    toggleDatePicker();
  }

  onBeforeMount(() => {
    if(router.page.url === '/') showPanel.value = false;

    const bookingDates = bookingStore.dates;
    const bookingGuests = bookingStore.guests;

    if(bookingDates.checkIn && bookingDates.checkOut) {
      bookingDetails.date.start = bookingDates.checkIn;
      bookingDetails.date.end = bookingDates.checkOut;
    }

    if(bookingGuests.adults && bookingGuests.children) {
      bookingDetails.guests = bookingGuests;
    }
  })
</script>
<template>
  <div v-if="showPanel">
    <div class="relative border-black border w-full grid grid-cols-4 bg-white">
      <div class="flex flex-col py-4 px-6 border-black border-r-[.5px] cursor-pointer">
        <span class="font-bold text-[.75rem]">Hotel</span>
        <span class="text-[.75rem]">Catanduanes Midtown Inn</span>
      </div>
      <div class="border-black border-r border-l-[.5px] flex flex-col py-4 px-6 cursor-pointer relative">
        <span class="font-bold text-[.75rem]">Guests</span>
        <span class="text-[.75rem]">{{ bookingStore.guestsCount }}</span>
      </div>
      <div @click="toggleDatePicker" class="border-black border-r flex flex-col py-4 px-6 cursor-pointer">
        <span class="font-bold text-[.75rem]">Check In</span>
        <span class="text-[.75rem]">{{ checkInDate }}</span>
      </div>
      <div @click="toggleDatePicker" class="border-black flex flex-col py-4 px-6 cursor-pointer">
        <span class="font-bold text-[.75rem]">Check Out</span>
        <span class="text-[.75rem]">{{ checkOutDate }}</span>
      </div>
    </div>
    <div class="w-full grid grid-cols-4 relative">
      <div v-if="showDatePicker" class="bg-white border-black border border-t-0 block absolute right-0 top-full w-1/2 z-50">
        <VDatePicker
          expanded
          transparent
          borderless
          :step="1"
          :min-date="new Date()"
          v-model.range="bookingDetails.date"
          mode="date"
          :columns="2" />
          <div class="w-full">
            <button 
              @click="updateDates"
              class="w-full transition-colors ease-in-out hover:bg-opacity-90 py-4 px-2 bg-dark-green justify-center text-white uppercase flex text-[1rem] font-bold tracking-widest"
                >Update Availabiltiy
            </button>
          </div>
      </div>
    </div>
  </div>
</template>