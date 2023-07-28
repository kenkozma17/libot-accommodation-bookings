<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import UpdateRoomForm from '@/Pages/Admin/Rooms/Partials/UpdateRoomForm.vue';
import RoomAvailability from '@/Pages/Admin/Rooms/Partials/RoomAvailability.vue';
import SectionBorder from '@/Components/SectionBorder.vue';

const props = defineProps({
  room: Object,
  amenities: Array,
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
              <UpdateRoomForm 
                :amenities="amenities"
                :room="room" />

              <SectionBorder />
              
              <RoomAvailability :room="room" />
            </div>
        </div>
    </AppLayout>
</template>