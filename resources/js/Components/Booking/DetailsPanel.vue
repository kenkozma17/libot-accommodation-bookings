<script setup>
  import { ref, reactive, onBeforeMount, computed, onMounted, onUnmounted } from 'vue';
  import { router } from '@inertiajs/vue3';
  import { useBookingStore } from '@/stores/booking';
  import dayjs from 'dayjs';
  import { useToast } from 'vue-toast-notification';
  import { useScreens } from 'vue-screen-utils';

  const { mapCurrent } = useScreens({ xs: '0px', sm: '640px', md: '768px', lg: '1024px' });
  const columns = mapCurrent({ lg: 2 }, 1);

  const $toast = useToast({
    position: 'top-right'
  })
  
  const bookingStore = useBookingStore();

  const bookingDetails = reactive({
    dates: {
      start: null,
      end: null,
    },
    guests: {
      adults: 1,
      children: 0,
    }
  });

  const showDatePicker = ref(false);
  const showGuestsAdjust = ref(false);
  const showPanel = ref(true);

  const checkInDate = computed(() => {
    return dayjs(bookingDetails.dates.start).format('MMMM D, YYYY');
  });

  const checkOutDate = computed(() => {
    return dayjs(bookingDetails.dates.end).format('MMMM D, YYYY');
  });

  function toggleDatePicker() {
    showDatePicker.value = !showDatePicker.value;
    showGuestsAdjust.value = false;
  }

  function toggleGuestsAdjust() {
    showGuestsAdjust.value = !showGuestsAdjust.value;
    showDatePicker.value = false;
  }

  function updateDates() {
    bookingDetails.dates.start = dayjs(bookingDetails.dates.start).format('YYYY-MM-DD')
    bookingDetails.dates.end = dayjs(bookingDetails.dates.end).format('YYYY-MM-DD')
    const daysDifference = dayjs(bookingDetails.dates.end).diff(dayjs(bookingDetails.dates.start), 'day');
    if(daysDifference > 0) {
      bookingStore.setCheckIn(
        dayjs(bookingDetails.dates.start).format('YYYY-MM-DD')
      );
      bookingStore.setCheckOut(
        dayjs(bookingDetails.dates.end).format('YYYY-MM-DD')
      );
      toggleDatePicker();
      unselectRoom();
      
      router.get(route('available-rooms.index'), bookingDetails);
    } else {
      $toast.warning('Stay must be at least 1 night');
    }
  }

  function unselectRoom() {
    bookingStore.setRoom({});
  }

  function updateGuests() {
    bookingStore.setAdultGuests(bookingDetails.guests.adults);
    bookingStore.setChildrenGuests(bookingDetails.guests.children);
    toggleGuestsAdjust();
    unselectRoom();

    router.get(route('available-rooms.index'), bookingDetails);
  }

  onBeforeMount(() => {
    if(router.page.url === '/' || router.page.url.includes('booking-details') || router.page.url.includes('payment')) showPanel.value = false;
    if(router.page.url.includes('edit=true')) showDatePicker.value = true;

    const bookingDates = bookingStore.dates;

    bookingDetails.guests = bookingStore.guests;

    if(bookingDates.start && bookingDates.end) {
      bookingDetails.dates.start = bookingDates.start;
      bookingDetails.dates.end = bookingDates.end;
    }
  })

  onMounted(() => {
    document.addEventListener('click', function handleClickOutsideBox(event) {
      const detailsPanel = document.getElementById('details-panel');

      if (!detailsPanel.contains(event.target)) {
        showDatePicker.value = false;
        showGuestsAdjust.value = false;
      }
    });
  });

</script>
<template>
  <div v-if="showPanel" id="details-panel">
    <div class="relative border-black border bg-black w-full grid grid-cols-4 gap-[1px]">
      <div class="md:col-span-1 col-span-4 flex flex-col md:py-4 py-3 md:px-6 px-3 cursor-pointer bg-white">
        <span class="font-bold text-[.75rem]">Hotel</span>
        <span class="text-[.75rem]">Catanduanes Midtown Inn</span>
      </div>
      <div @click="toggleGuestsAdjust" class="md:col-span-1 col-span-4 flex flex-col md:py-4 py-3 md:px-6 px-3 cursor-pointer relative bg-white">
        <span class="font-bold text-[.75rem]">Guests</span>
        <span class="text-[.75rem]">{{ bookingStore.guestsCount }}</span>
      </div>
      <div @click="toggleDatePicker" class="md:col-span-1 col-span-4 flex flex-col md:py-4 py-3 md:px-6 px-3 cursor-pointer bg-white">
        <span class="font-bold text-[.75rem]">Check In</span>
        <span class="text-[.75rem]">{{ checkInDate }}</span>
      </div>
      <div @click="toggleDatePicker" class="md:col-span-1 col-span-4 flex flex-col md:py-4 py-3 md:px-6 px-3 cursor-pointer bg-white">
        <span class="font-bold text-[.75rem]">Check Out</span>
        <span class="text-[.75rem]">{{ checkOutDate }}</span>
      </div>
    </div>
    <div class="w-full grid grid-cols-4 relative">
      <div v-if="showGuestsAdjust" class="md:col-start-2 md:col-end-3 absolute w-full z-50">
        <div class="mx-2 p-4 bg-white border border-t-0 border-black">
          <div class="input-field">
            <select 
              name="adults" 
              id="adults" 
              v-model="bookingDetails.guests.adults"
              class="border-black border bg-white text-[.875rem] p-3.5 w-full">
              <option value="1">1 Adult</option>
              <option value="2">2 Adults</option>
              <option value="3">3 Adults</option>
              <option value="4">4 Adults</option>
            </select>
          </div>
          <div class="input-field mt-3">
            <select 
              name="children" 
              id="children" 
              v-model="bookingDetails.guests.children"
              class="border-black border bg-white text-[.875rem] p-3.5 w-full">
              <option value="0">0 Children</option>
              <option value="1">1 Children</option>
              <option value="2">2 Children</option>
              <option value="3">3 Children</option>
            </select>
          </div>
          <div class="w-full mt-3">
            <button 
              @click="updateGuests"
              class="w-full transition-colors ease-in-out hover:bg-opacity-90 py-3 px-2 bg-dark-green justify-center text-white uppercase flex text-[1rem] font-bold tracking-widest"
                >Update Availabiltiy
            </button>
          </div>
        </div>
      </div>
      <div v-if="showDatePicker" class="md:col-start-3 w-full col-span-2 absolute z-50">
        <div class="mx-2 bg-white border-black border border-t-0">
          <VDatePicker
            expanded
            transparent
            borderless
            :input-debounce="0"
            :step="1"
            :min-date="new Date()"
            v-model.range="bookingDetails.dates"
            mode="date"
            @update:modelValue="updateDates"
            :columns="columns" />
            <div class="w-full mt-3">
              <button 
                @click="updateDates"
                class="w-full transition-colors ease-in-out hover:bg-opacity-90 py-3 px-2 bg-dark-green justify-center text-white uppercase flex text-[1rem] font-bold tracking-widest"
                  >Update Availabiltiy
              </button>
            </div>
        </div>
      </div>
    </div>
  </div>
</template>