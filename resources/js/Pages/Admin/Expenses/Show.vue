<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import UpdateExpenseForm from "@/Pages/Admin/Expenses/Partials/UpdateExpenseForm.vue";
import SectionBorder from "@/Components/SectionBorder.vue";

const props = defineProps({
    expense: Object,
});
</script>

<template>
    <AppLayout :title="`Expense: ${expense.name}`">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Expense: {{ expense.name }}
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <UpdateExpenseForm :expense="expense" />
            </div>
        </div>
    </AppLayout>
</template>
