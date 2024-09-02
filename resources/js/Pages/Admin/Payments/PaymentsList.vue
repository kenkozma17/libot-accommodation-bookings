<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import TableList from "@/Components/TableList.vue";
import PaginationList from "@/Components/PaginationList.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Link } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
  payments: Array,
  search: String,
});

const s = ref(props.search);
</script>
<template>
  <AppLayout title="Payment Management">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Payment Management
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <TableList>
            <template #search>
              <div class="flex md:flex-row flex-col space-y-2 justify-between w-full">
                <form action="" class="md:w-96 w-full">
                  <label for="search" class="sr-only">Search</label>
                  <input
                    type="text"
                    v-model="s"
                    name="search"
                    id="search"
                    class="p-3 pl-10 block w-full border-gray-200 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500"
                    placeholder="Search by Name, Email or Phone Number..."
                  />
                </form>
                <div>
                  <SecondaryButton class="justify-center mr-2">
                    <Link :href="route('payments.index')"> Clear Search </Link>
                  </SecondaryButton>
                  <form class="inline-block" :action="route('payments.export')">
                    <PrimaryButton class="justify-center"> Export </PrimaryButton>
                  </form>
                </div>
              </div>
            </template>
            <template #header>
              <tr>
                <th
                  scope="col"
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
                >
                  Transaction #
                </th>
                <th
                  scope="col"
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
                >
                  Payer Name
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
                  Fee
                </th>
                <th
                  scope="col"
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
                >
                  Payer Email
                </th>
                <th
                  scope="col"
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
                >
                  Payment Method
                </th>
                <th
                  scope="col"
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
                >
                  Status
                </th>
                <th
                  scope="col"
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
                >
                  Date
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
              <tr v-for="payment in payments.data">
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                  <Link :href="route('payments.show', payment.id)">
                    {{ payment.paymongo_payment_id }}
                  </Link>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                  {{ payment.payer_name }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  {{ payment.payment_amount_formatted }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  {{ payment.fee_formatted }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                  {{ payment.payer_email }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                  {{ payment.payment_method }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                  {{ payment.payment_status }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                  {{ payment.payment_date_formatted }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                  <Link :href="route('payments.show', payment.id)">View</Link>
                </td>
              </tr>
            </template>
            <template #pagination>
              <PaginationList :links="payments.links" />
            </template>
          </TableList>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
