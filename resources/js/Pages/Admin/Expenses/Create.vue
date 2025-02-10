<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import CreateExpenseForm from '@/Pages/Admin/Expenses/Partials/CreateExpenseForm.vue';
</script>

<template>
    <AppLayout title="Create Expense">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create Expense
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <CreateExpenseForm />
            </div>
        </div>
    </AppLayout>
</template>
