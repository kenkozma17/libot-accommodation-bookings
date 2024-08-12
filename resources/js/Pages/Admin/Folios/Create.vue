<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import CreateFolioForm from '@/Pages/Admin/Folios/Partials/CreateFolioForm.vue';

const props = defineProps({
  guests: Array,
  bookings: Array,
});
</script>

<template>
    <AppLayout title="Create Folio">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create Folio
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <CreateFolioForm :guests="guests" :bookings="bookings" />
            </div>
        </div>
    </AppLayout>
</template>
