<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import SectionBorder from "@/Components/SectionBorder.vue";
import UpdateEventSetForm from "./Partials/UpdateEventSetForm.vue";
import AddServiceForm from "./Partials/AddServiceForm.vue";

const props = defineProps({
    set: Object,
    serviceCategories: Array,
});
</script>

<template>
    <AppLayout :title="`Event Set: ${set.name}`">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Event Set: {{ set.name }}
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <UpdateEventSetForm :set="set" />

                <SectionBorder />

                <AddServiceForm :set="set" :service-categories="serviceCategories" />

            </div>
        </div>
    </AppLayout>
</template>
