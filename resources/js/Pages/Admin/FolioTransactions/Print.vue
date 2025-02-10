<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import UpdateTransactionForm from "@/Pages/Admin/FolioTransactions/Partials/UpdateTransactionForm.vue";
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';

const props = defineProps({
  folio: Object,
  totalExpenses: String,
});
</script>

<template>
  <div class="mx-auto py-10 px-4">
    <div class="flex justify-center w-full mb-4">
        <AuthenticationCardLogo />
    </div>
    <div class="">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        List of Guest Transactions
      </h2>
      <p class="mb-2">
        Guest:
        {{ folio.guest ? folio.guest.full_name : folio.booking.guest.full_name }}
      </p>
      <p v-if="folio.booking" class="mb-4">
        Guest Stay: {{ folio.booking.check_in_formatted }} -
        {{ folio.booking.check_out_formatted }}
      </p>
      <table class="bg-white border">
        <thead class="bg-gray-200">
          <tr>
            <th
              class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-sm"
            >
              Date
            </th>
            <th
              class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-sm"
            >
              Paid?
            </th>
            <th
              class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-sm"
            >
              Name
            </th>
            <th
              class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-sm"
            >
              Reg. No.
            </th>
            <th
              class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-sm"
            >
              Receipt. No.
            </th>
            <th
              class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-sm"
            >
              Payment Method
            </th>
            <th
              class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-sm"
            >
              Price
            </th>
            <th
              class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-sm"
            >
              Quantity
            </th>
            <th
              class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-sm"
            >
              Sub-total
            </th>
          </tr>
        </thead>
        <tbody>
          <!-- Main Row -->
          <template v-if="props.folio.transactions">
            <tr
              v-for="(transaction, tIndex) in props.folio.transactions"
              :key="transaction.id"
              class="hover:bg-gray-300"
              :class="tIndex % 2 === 0 ? 'bg-gray-50' : 'bg-gray-100'"
            >
              <td class="px-6 py-2 pl-10 text-gray-600 text-sm text-nowrap">
                {{ transaction.date }}
              </td>
              <td class="px-6 py-2 pl-10 text-gray-600 text-sm text-nowrap">
                {{ transaction.is_paid ? 'Yes' : 'No' }}
              </td>
              <td class="px-6 py-2 pl-10 text-gray-600 text-sm text-nowrap">
                {{ transaction.service_name }}
              </td>
              <td class="px-6 py-2 text-gray-600 text-sm">
                {{ folio.registration_number }}
              </td>
              <td class="px-6 py-2 text-gray-600 text-sm">
                {{ transaction.receipt_number }}
              </td>
              <td class="px-6 py-2 text-gray-600 text-sm">
                {{ transaction.payment_method }}
              </td>
              <td class="px-6 py-2 text-gray-600 text-sm">
                {{ transaction.formatted_price }}
              </td>
              <td class="px-6 py-2 text-gray-600 text-sm">{{ transaction.quantity }}</td>
              <td class="px-6 py-2 font-semibold">
                {{ transaction.formatted_amount }}
              </td>
            </tr>
          </template>
          <!-- Total Row -->
          <tr class="main-row cursor-pointer bg-gray-100 hover:bg-gray-300">
            <td class="px-6 py-2"></td>
            <td class="px-6 py-2"></td>
            <td class="px-6 py-2"></td>
            <td class="px-6 py-2"></td>
            <td class="px-6 py-2"></td>
            <td class="px-6 py-2"></td>
            <td class="px-6 py-2"></td>
            <td class="px-6 py-2">Total</td>
            <td class="px-6 py-2 font-bold">
              {{ props.totalExpenses }}
            </td>
          </tr>
        </tbody>
      </table>
      <p class="mt-10">Guest Name and Signature: <span class="w-32 h-2 border-b border-b-black inline-block"></span></p>
    </div>
  </div>
</template>
<style scoped>
.text-nowrap {
  text-wrap: nowrap;
}
</style>
