<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";

const props = defineProps({
  folios: Array,
  expenses: Array,
  month: String,
  year: String,
  totalIncome: String,
  totalExpenses: String,
  grandTotal: String,
  isPositive: Boolean,
});

const toggleRow = (rowId) => {
  const subRows = document.querySelectorAll(`#${rowId}`);
  subRows.forEach((row) => {
    row.classList.toggle("hidden");
  });
};
</script>

<template>
  <AppLayout :title="`Report: ${props.month + ' ' + props.year}`">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Monthly Cash Flow Report: {{ props.month + " " + props.year }}
      </h2>
    </template>

    <div>
      <div class="mx-auto py-10 px-4">
        <div class="overflow-x-auto">
          <!-- Income Table -->
          <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">Income</h2>
          <table class="min-w-full bg-white border">
            <thead class="bg-gray-200">
              <tr>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                >
                  Date
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                >
                  Name
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                >
                  Reg. No.
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                >
                  Receipt. No.
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                >
                  Payment Method
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                >
                  Price
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                >
                  Quantity
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                >
                  Sub-total
                </th>
              </tr>
            </thead>
            <tbody>
              <!-- Main Row -->
              <template v-for="(income, index) in props.folios" :key="index">
                <tr
                  :class="[
                    'main-row cursor-pointer hover:bg-gray-300',
                    index % 2 === 0 ? 'bg-gray-100' : 'bg-gray-50',
                  ]"
                  @click="toggleRow(`row-${index}`)"
                >
                  <td class="px-6 py-4 font-medium text-gray-900">{{ income.date }}</td>
                  <td class="px-6 py-4">
                    {{
                      income.booking
                        ? income.booking.guest.full_name
                        : income.guest.full_name
                    }}
                  </td>
                  <td class="px-6 py-4">{{ income.registration_number }}</td>
                  <td class="px-6 py-4"></td>
                  <td class="px-6 py-4"></td>
                  <td class="px-6 py-4"></td>
                  <td class="px-6 py-4"></td>
                  <td class="px-6 py-4 text-green-600 font-semibold">
                    {{ income.total }}
                  </td>
                </tr>
                <!-- Sub-Rows -->
                <template v-if="income.transactions">
                  <tr
                    v-for="(transaction, tIndex) in income.transactions"
                    :key="transaction.id"
                    :id="'row-' + index"
                    class="sub-row hidden hover:bg-gray-300"
                    :class="tIndex % 2 === 0 ? 'bg-gray-50' : 'bg-gray-100'"
                  >
                    <td class="px-6 py-4 pl-10 text-gray-600">{{ transaction.date }}</td>
                    <td class="px-6 py-4 pl-10 text-gray-600">
                      {{ transaction.service_name }}
                    </td>
                    <td class="px-6 py-4 text-gray-600"></td>
                    <td class="px-6 py-4 text-gray-600">
                      {{ transaction.receipt_number }}
                    </td>
                    <td class="px-6 py-4 text-gray-600">
                      {{ transaction.payment_method }}
                    </td>
                    <td class="px-6 py-4 text-gray-600">
                      {{ transaction.formatted_price }}
                    </td>
                    <td class="px-6 py-4 text-gray-600">{{ transaction.quantity }}</td>
                    <td class="px-6 py-4 text-green-600 font-semibold">
                      {{ transaction.formatted_amount }}
                    </td>
                  </tr>
                </template>
              </template>
              <!-- Total Row -->
              <tr class="main-row cursor-pointer bg-gray-100 hover:bg-gray-300">
                <td class="px-6 py-4"></td>
                <td class="px-6 py-4"></td>
                <td class="px-6 py-4"></td>
                <td class="px-6 py-4"></td>
                <td class="px-6 py-4"></td>
                <td class="px-6 py-4"></td>
                <td class="px-6 py-4">Total</td>
                <td class="px-6 py-4 text-green-600 font-bold">
                  {{ props.totalIncome }}
                </td>
              </tr>
            </tbody>
          </table>

          <!-- Expenses Table -->
          <h2 class="font-semibold text-xl text-gray-800 leading-tight mt-6 mb-4">Expenses</h2>
          <table class="min-w-full bg-white border">
            <thead class="bg-gray-200">
              <tr>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                >
                  Date
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                >
                  Type
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                >
                  Description
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                >
                  Invoice No.
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                >
                  Vendor
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                >
                  Amount
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                >
                  Sub-total
                </th>
              </tr>
            </thead>
            <tbody>
              <template v-for="(expense, index) in props.expenses" :key="index">
                <tr
                  :class="[
                    'main-row cursor-pointer hover:bg-gray-300',
                    index % 2 === 0 ? 'bg-gray-100' : 'bg-gray-50',
                  ]"
                >
                  <td class="px-6 py-4 font-medium text-gray-900">{{ expense.date }}</td>
                  <td class="px-6 py-4">{{ expense.type }}</td>
                  <td class="px-6 py-4">{{ expense.description }}</td>
                  <td class="px-6 py-4">{{ expense.invoice_number }}</td>
                  <td class="px-6 py-4">{{ expense.vendor }}</td>
                  <td class="px-6 py-4"></td>
                  <td class="px-6 py-4 text-red-600 font-semibold">
                    {{ expense.amount }}
                  </td>
                </tr>
              </template>
              <tr class="main-row cursor-pointer bg-gray-100 hover:bg-gray-300">
                <td class="px-6 py-4"></td>
                <td class="px-6 py-4"></td>
                <td class="px-6 py-4"></td>
                <td class="px-6 py-4"></td>
                <td class="px-6 py-4"></td>
                <td class="px-6 py-4">Total</td>
                <td class="px-6 py-4 text-red-600 font-bold">
                  {{ props.totalExpenses }}
                </td>
              </tr>
              <tr class="main-row cursor-pointer bg-gray-100 hover:bg-gray-300">
                <td class="px-6 py-4"></td>
                <td class="px-6 py-4"></td>
                <td class="px-6 py-4"></td>
                <td class="px-6 py-4"></td>
                <td class="px-6 py-4"></td>
                <td class="px-6 py-4">Net Total</td>
                <td
                  class="px-6 py-4 font-bold"
                  :class="props.isPositive ? 'text-green-600' : 'text-red-600'"
                >
                  {{ props.grandTotal }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
