<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import CreateBookingForm from '@/Pages/Admin/Bookings/Partials/CreateBookingForm.vue';

const props = defineProps({
  rooms: Array,
});
</script>

<template>
    <AppLayout title="Create Booking">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create Booking
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <CreateBookingForm :rooms="rooms" />
            </div>
        </div>
    </AppLayout>
</template>
