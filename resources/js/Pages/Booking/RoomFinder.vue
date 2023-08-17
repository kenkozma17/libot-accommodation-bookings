<script setup>
  import BookingLayout from '@/Layouts/BookingLayout.vue';
  import dayjs from 'dayjs';
  import { router } from '@inertiajs/vue3';
  import { useBookingStore } from '@/stores/booking';
  import { onBeforeMount, reactive, computed } from 'vue';
  import { useToast } from 'vue-toast-notification';
  import { useScreens } from 'vue-screen-utils';
  import { Head } from '@inertiajs/vue3';

  const { mapCurrent } = useScreens({ xs: '0px', sm: '640px', md: '768px', lg: '1024px' });
  const columns = mapCurrent({ lg: 2 }, 1);

  const $toast = useToast({
    position: 'top-right'
  })

  const bookingStore = useBookingStore();

  const bookingDetails = reactive({
    dates: {
      start: dayjs().format(),
      end: dayjs().add(3, 'day').format(),
    },
    guests: {
      adults: 1,
      children: 0,
    }
  });

  const checkIn = computed(() => {
    if(bookingDetails.dates.start) {
      return dayjs(bookingDetails.dates.start);
    }
  })

  const checkOut = computed(() => {
    if(bookingDetails.dates.end) {
      return dayjs(bookingDetails.dates.end);
    }
  })

  function setBookingDates() {
    bookingStore.setCheckIn(
      dayjs(bookingDetails.dates.start).format('YYYY-MM-DD')
    );
    bookingStore.setCheckOut(
      dayjs(bookingDetails.dates.end).format('YYYY-MM-DD')
    );
  }

  function setGuestDetails() {
    bookingStore.setAdultGuests(bookingDetails.guests.adults);
    bookingStore.setChildrenGuests(bookingDetails.guests.children);
  }

  function checkAvailability() {
    const daysDifference = dayjs(bookingDetails.dates.end).diff(dayjs(bookingDetails.dates.start), 'day');
    if(daysDifference > 0 ){
      setBookingDates();
      setGuestDetails();
      router.get(route('available-rooms.index'), bookingDetails);
    } else {
      $toast.warning('Stay must be at least 1 night');
    }
  }

  onBeforeMount(() => {
    const bookingDates = bookingStore.dates;
    const bookingGuests = bookingStore.guests;

    if(bookingDates.start && bookingDates.end) {
      bookingDetails.dates.start = bookingDates.start;
      bookingDetails.dates.end = bookingDates.end;
    }

    if(bookingGuests.adults && bookingGuests.children) {
      bookingDetails.guests = bookingGuests;
    }
  })
</script>
<template>
  <BookingLayout>
    <Head title="Select Room Dates" />
    <div class="grid grid-cols-12 my-5 gap-7">
      <div class="md:col-span-8 col-span-12">
        <div class="border border-black bg-white">
          <div class="border-b border-black text-center py-5 px-2">
            <p class="text-[.875rem] font-bold uppercase tracking-widest">Select your dates</p>
          </div>
          <div class="m-4">
            <VDatePicker
              expanded
              transparent
              borderless
              :step="1"
              :min-date="new Date()"
              v-model.range.string="bookingDetails.dates"
              mode="date"
              :columns="columns" />
          </div>
        </div>
      </div>
      <div class="md:col-span-4 col-span-12">
        <div class="grid grid-cols-2 border-black border bg-white min-h-[11rem]">
          <div class="border-black border-r">
            <div class="bg-light-brown py-1 text-center">
              <span class="text-[.875rem] font-bold text-white uppercase tracking-widest">Arrival</span>
            </div>
            <div class="bg-white text-center py-4">
              <p class="text-[5.65rem] leading-none">
                {{ checkIn ? checkIn.format('D') : '' }}
              </p>
              <p class="text-[.75rem] uppercase">
                {{ checkIn ? checkIn.format('MMMM') : '' }}
              </p>
            </div>
          </div>
          <div>
            <div class="bg-light-brown py-1 text-center">
              <span class="text-[.875rem] font-bold text-white uppercase tracking-widest">Departure</span>
            </div>
            <div class="bg-white text-center py-4">
              <p class="text-[5.65rem] leading-none">
                {{ checkOut ? checkOut.format('D') : '' }}
              </p>
              <p class="text-[.75rem] uppercase">
                {{ checkOut ? checkOut.format('MMMM') : '' }}
              </p>
            </div>
          </div>
        </div>

        <div>
          <form @submit.prevent="checkAvailability">

            <div class="input-field mt-3">
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

            <div class="mt-4">
              <button 
                class="w-full hover:bg-opacity-90 transition-colors ease-in-out p-4 text-white bg-dark-green uppercase tracking-widest font-bold">
                Check Availability
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </BookingLayout>
</template>
<style scoped>
  .vc-container {
    font-family: "Poppins", "sans-serif";
  }
  .vc-pane.column-1 {
    border-right: 1px solid rgba(0,0,0,0.5);
  }
</style>
