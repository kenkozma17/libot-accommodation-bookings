<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import TableList from "@/Components/TableList.vue";
import PaginationList from "@/Components/PaginationList.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import FormSection from "@/Components/FormSection.vue";
import { Link } from "@inertiajs/vue3";
import dayjs from "dayjs";
import { computed } from "vue";
const props = defineProps({
  folio: Object,
});

const itemsPaidFor = computed(() => {
  if (props.folio.transactions.length) {
    let unpaidTransactions = 0;
    let paidTransactions = 0;
    props.folio.transactions.forEach((transaction) =>
      transaction.is_paid ? (paidTransactions += 1) : (unpaidTransactions += 1)
    );
    return paidTransactions + " paid out of " + unpaidTransactions + " transactions.";
  }
  return "";
});
</script>
<template>
  <FormSection>
    <template #title> Folio Transactions List </template>

    <template #description> View the transactions of the guest. </template>
    <template #form>
      <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg col-span-6">
        <TableList :hasSearch="false">
          <template #header>
            <tr>
              <th
                scope="col"
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
              >
                Quantity
              </th>
              <th
                scope="col"
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
              >
                Service/Product
              </th>
              <th
                scope="col"
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
              >
                Price
              </th>
              <th
                scope="col"
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
              >
                Amount
              </th>
              <th
                scope="col"
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
              >
                Date
              </th>
              <th
                scope="col"
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
              >
                Paid?
              </th>
              <th
                scope="col"
                class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase"
              >
                Action
              </th>
            </tr>
          </template>
          <template #content>
            <tr v-for="transaction in folio.transactions">
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                {{ transaction.quantity }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                {{ transaction.service_name }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                {{ transaction.formatted_price }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                {{ transaction.formatted_amount }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                {{ dayjs(transaction.date_placed).format("MMM DD, YYYY") }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                {{ transaction.is_paid ? "Yes" : "No" }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <Link :href="route('folio-transactions.show', transaction.id)">View</Link>
              </td>
            </tr>
            <tr>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right"></td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right"></td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right"></td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right">
                {{ itemsPaidFor }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right">
                <span class="font-bold">Total</span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right">
                <span class="font-bold">{{ folio.total }}</span>
              </td>
            </tr>
          </template>
        </TableList>
      </div>
    </template>
  </FormSection>
</template>
