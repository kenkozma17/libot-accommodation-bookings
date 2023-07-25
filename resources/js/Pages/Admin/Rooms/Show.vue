<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import UpdateRoomForm from '@/Pages/Admin/Rooms/Partials/UpdateRoomForm.vue';
import GuestBookings from '@/Pages/Admin/Guests/Partials/GuestBookings.vue';
import GuestPayments from '@/Pages/Admin/Guests/Partials/GuestPayments.vue';
import SectionBorder from '@/Components/SectionBorder.vue';

const props = defineProps({
  room: Object,
});
</script>

<template>
    <AppLayout :title="`Room: ${room.name}`">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Room: {{ room.name }}
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
              <UpdateRoomForm :room="room" />

              <!-- <template v-if="guest.bookings.length">
                <SectionBorder /> -->
                
                <!-- <GuestBookings :bookings="guest.bookings" /> -->
              <!-- </template> -->
            </div>
        </div>
    </AppLayout>
</template>