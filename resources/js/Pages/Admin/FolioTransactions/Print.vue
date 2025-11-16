<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import UpdateTransactionForm from "@/Pages/Admin/FolioTransactions/Partials/UpdateTransactionForm.vue";
import AuthenticationCardLogo from "@/Components/AuthenticationCardLogo.vue";

const props = defineProps({
  folio: Object,
  gross: String,
  total: String,
  discount: String,
  balance: String,
});
</script>

<template>
  <div class="max-w-[1250px] mx-auto">
    <div class="mx-auto py-[45px] px-[35px] bg-white">
      <div class="flex justify-between w-full mb-4">
        <img src="/logo.png" class="w-[200px]" alt="" />
        <div>
          <h2 class="font-bold text-[2.5rem]">Invoice</h2>
          <p>
            Brgy. Batag <br/> Virac, Catanduanes <br />
            Philippines
          </p>
        </div>
      </div>
      <div class="mt-8 flex justify-between">
        <div>
          <p class="font-semibold">Billed To:</p>
          <p>{{folio.guest ? folio.guest.full_name : folio.booking.guest.full_name}}</p>
        </div>
        <div class="mr-[100px]">
          <p class="font-semibold">Invoice Number:</p>
          <p class="font-semibold">Invoice Date:</p>
        </div>
      </div>
      <div class="mt-8">
        <p v-if="folio.booking">
          <span class="font-semibold">Guest Stay:</span> {{ folio.booking.check_in_formatted }} -
          {{ folio.booking.check_out_formatted }}
        </p>
        <p class="mb-4">
          <span class="font-semibold">Reg. No:</span> {{ folio.registration_number }}
        </p>
        <table class="bg-white border w-full">
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
                Description
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
                Settled
              </th>
              <th
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-sm"
              >
                Amount
              </th>
            </tr>
          </thead>
          <tbody>
            <!-- Main Row -->
            <template v-if="props.folio.transactions">
              <tr
                v-for="(transaction, tIndex) in props.folio.transactions"
                :key="transaction.id"
                class="border"
                :class="tIndex % 2 === 0 ? 'bg-gray-50' : 'bg-gray-100'"
              >
                <td class="px-6 py-2 text-gray-600 text-sm text-nowrap">
                  {{ transaction.date }}
                </td>
                <td class="px-6 py-2 text-gray-600 text-sm text-nowrap">
                  {{ transaction.service_name }}
                </td>
                <td class="px-6 py-2">{{ transaction.formatted_price }}</td>
                <td class="px-6 py-2">
                  {{ transaction.quantity }}
                </td>
                <td class="px-6 py-2">
                  {{ transaction.is_paid ? '✅' : '' }}
                </td>
                <td class="px-6 py-2 text-gray-600 text-sm">
                  {{ transaction.formatted_amount }}
                </td>
              </tr>
            </template>
          </tbody>
        </table>
        <div class="flex flex-col items-end mt-4">
          <div class="w-[200px]">
            <p><span class="font-bold">Sub-Total:</span> {{props.gross}}</p>
            <p><span class="font-bold">Discount:</span> {{ props.discount }}</p>
            <p><span class="font-bold">Total:</span> {{props.total}}</p>
            <p class="mt-4"><span class="font-bold">Balance Due: </span>{{props.balance}}</p>
          </div>
        </div>
        <p class="mt-10">
          Guest Name and Signature:
          <span class="w-32 h-2 border-b border-b-black inline-block"></span>
        </p>
      </div>
    </div>
  </div>
</template>
<style scoped>
.text-nowrap {
  text-wrap: nowrap;
}
</style>
