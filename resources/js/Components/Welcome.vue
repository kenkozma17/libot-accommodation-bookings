<script setup>
import { Link } from '@inertiajs/vue3';
const props = defineProps({
  availableRooms: {
    type: Number,
    default: 0
  },
  upcomingBookings: {
    type: Number,
    default: 0
  }
});
</script>

<template>
    <div>
        <div class="bg-gray-200 bg-opacity-25 gap-6 lg:gap-8 p-6 lg:p-8">
          <div class="grid grid-cols-4 space-x-6">
            <Link :href="route('rooms.index')">
              <div class="rounded bg-white drop-shadow-lg p-4 text-center cursor-pointer">
                  <span class="text-[5rem] font-semibold">
                    {{ props.availableRooms }}
                  </span>
                  <h2 class="text-lg font-bold leading-3">Available Rooms</h2>
              </div>
            </Link>
            <Link :href="route('bookings.index')">
              <div class="rounded bg-white drop-shadow-lg p-4 text-center cursor-pointer">
                  <span class="text-[5rem] font-semibold">
                    {{ props.upcomingBookings }}
                  </span>
                  <h2 class="text-lg font-bold leading-3">Upcoming Bookings</h2>
              </div>
            </Link>
          </div>
        </div>
    </div>
</template>
