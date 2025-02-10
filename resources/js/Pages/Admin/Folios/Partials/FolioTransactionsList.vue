<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import TableList from "@/Components/TableList.vue";
import PaginationList from "@/Components/PaginationList.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import FormSection from "@/Components/FormSection.vue";
import { Link } from "@inertiajs/vue3";
import dayjs from "dayjs";
import { computed } from "vue";
const props = defineProps({
  folio: Object,
});

const itemsPaidFor = computed(() => {
  if (props.folio.transactions.length) {
    let totalTransactions = props.folio.transactions.length;
    let paidTransactions = 0;
    props.folio.transactions.forEach((transaction) =>
      transaction.is_paid ? (paidTransactions += 1) : ""
    );
    return paidTransactions + " paid out of " + totalTransactions + " transactions.";
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
                class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase"
              >
                Action
              </th>
              <th
                scope="col"
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
              >
                Paid?
              </th>
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
            </tr>
          </template>
          <template #content>
            <tr v-for="transaction in folio.transactions">
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <Link :href="route('folio-transactions.show', transaction.id)">View</Link>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                {{ transaction.is_paid ? "Yes" : "No" }}
              </td>
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
    <template #actions>
      <Link
        :href="route('folio-transactions.print', folio.id)"
        class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
      >
        Print
      </Link>
    </template>
  </FormSection>
</template>
