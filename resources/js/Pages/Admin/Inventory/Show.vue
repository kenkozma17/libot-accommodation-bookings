<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import UpdateInventoryForm from "@/Pages/Admin/Inventory/Partials/UpdateInventoryForm.vue";
import CreateInventoryMovementForm from "@/Pages/Admin/Inventory/Partials/CreateInventoryMovementForm.vue";
import SectionBorder from "@/Components/SectionBorder.vue";
import InventoryMovementList from "@/Pages/Admin/Inventory/Partials/InventoryMovementList.vue";

const props = defineProps({
    item: Object,
    categories: Array,
    units: Array,
    movements: Object,
});
</script>

<template>
    <AppLayout :title="`Inventory: ${item.name}`">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Inventory: {{ item.name }}
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <UpdateInventoryForm :categories="categories" :item="item" :units="units" />

                <SectionBorder />

                <InventoryMovementList :item="item" :movements="movements" />

                <SectionBorder />

                <CreateInventoryMovementForm :item="item"  />
            </div>
        </div>
    </AppLayout>
</template>
