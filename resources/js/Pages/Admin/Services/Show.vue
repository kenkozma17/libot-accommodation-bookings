<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import UpdateServiceForm from "@/Pages/Admin/Services/Partials/UpdateServiceForm.vue";
import AddInventoryItemForm from "@/Pages/Admin/Services/Partials/AddInventoryItemForm.vue";
import SectionBorder from "@/Components/SectionBorder.vue";

const props = defineProps({
  service: Object,
  serviceCategories: Array,
  items: Array,
});
</script>

<template>
  <AppLayout :title="`Service: ${service.name}`">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Service: {{ service.name }}
      </h2>
    </template>

    <div>
      <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <UpdateServiceForm :serviceCategories="serviceCategories" :service="service" />

        <SectionBorder />

        <AddInventoryItemForm :items="items" :service="service" />
      </div>
    </div>
  </AppLayout>
</template>
