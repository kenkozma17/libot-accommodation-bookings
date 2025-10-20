<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import SectionBorder from "@/Components/SectionBorder.vue";
import UpdateEventForm from "./Partials/UpdateEventForm.vue";
import AddEventSetForm from "./Partials/AddEventSetForm.vue";

const props = defineProps({
  event: Object,
  sets: Array,
});
</script>

<template>
    <AppLayout :title="`Event: ${event.name}`">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Event: {{ event.name }}
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <UpdateEventForm :event="event" />

                <SectionBorder />

                <AddEventSetForm :event="event" :sets="sets" />

            </div>
        </div>
    </AppLayout>
</template>
