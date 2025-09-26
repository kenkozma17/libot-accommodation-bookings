<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import UpdateInventoryMovementForm from "@/Pages/Admin/InventoryMovements/Partials/UpdateInventoryMovementForm.vue";

const props = defineProps({
    movement: Object,
});
</script>

<template>
    <AppLayout :title="`Inventory Transaction: ${movement.id}`">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Inventory Transaction: {{ movement.id }}
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <UpdateInventoryMovementForm :movement="movement" />
            </div>
        </div>
    </AppLayout>
</template>
