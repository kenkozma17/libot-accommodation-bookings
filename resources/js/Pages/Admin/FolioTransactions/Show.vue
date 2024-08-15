<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import UpdateTransactionForm from "@/Pages/Admin/FolioTransactions/Partials/UpdateTransactionForm.vue";

const props = defineProps({
  transaction: Object,
  serviceCategories: Array,
});
</script>

<template>
  <AppLayout :title="`Folio Transaction: ${transaction.service.name}`">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Folio Transaction: {{ transaction.service.name }}
      </h2>
    </template>

    <div>
      <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">

        <UpdateTransactionForm :transaction="transaction" :serviceCategories="serviceCategories"  />
      </div>
    </div>
  </AppLayout>
</template>
