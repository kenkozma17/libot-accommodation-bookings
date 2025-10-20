<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import CreateEventForm from '@/Pages/Admin/Events/Partials/CreateEventForm.vue';

const props = defineProps({
  guests: Array,
});
</script>

<template>
    <AppLayout title="Create Event">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create Event
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <CreateEventForm :guests="guests"/>
            </div>
        </div>
    </AppLayout>
</template>
