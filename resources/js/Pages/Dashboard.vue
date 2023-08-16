<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';

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
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <Welcome
                       :available-rooms="availableRooms"
                       :upcoming-bookings="upcomingBookings" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
