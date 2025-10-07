<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import CreateEventSetForm from '@/Pages/Admin/EventSets/Partials/CreateEventSetForm.vue';

const props = defineProps({

});
</script>

<template>
    <AppLayout title="Create Event Set">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create Event Set
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <CreateEventSetForm
                  />
            </div>
        </div>
    </AppLayout>
</template>
