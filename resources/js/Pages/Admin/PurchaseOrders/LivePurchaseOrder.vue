<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import TableList from "@/Components/TableList.vue";
import { Link, useForm } from "@inertiajs/vue3";
import { computed, ref } from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
const props = defineProps({
  items: Array,
  categories: Array,
});

const selectedCategory = ref("");

const filteredItems = computed(() => {
  const items = props.items;
  if(selectedCategory.value) {
    return items.filter(item => item.category.id === selectedCategory.value);
  }

  return items;
})

const estCostTotal = computed(() => {
  if (filteredItems.value) {
    const attachedItems = filteredItems.value;
    const compiledEstCosts = attachedItems.map((item) => {
      return item.refill_quantity * item.est_cost;
    });

    const estCostTotal = compiledEstCosts.reduce(
      (accumulator, currentValue) => accumulator + currentValue,
      0
    );
    return estCostTotal.toLocaleString();
  }

  return 0;
});

const form = useForm({
   items: [],
});

const generatePdf = () => {
  form.items = filteredItems.value;
  form.post(route("purchase-order.generate"), {
    errorBag: "generatePurchaseOrder",
    preserveScroll: true,
  });
};

</script>
<template>
  <AppLayout title="Purchase Orders Management">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Purchase Order Management
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <TableList :hasSearch="false">
            <template #search>
              <div class="flex justify-between">
                <div class="flex items-center gap-4">
                  <span class="relative flex h-3 w-3">
                    <span
                      class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"
                    ></span>
                    <span
                      class="relative inline-flex rounded-full h-3 w-3 bg-green-500"
                    ></span>
                  </span>
                  <h2 class="font-semibold text-xl">Live Purchase Order</h2>
                </div>
                <div class="flex gap-2">
                  <select
                    v-model="selectedCategory"
                    class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                    name="inventory_item_id"
                    id="inventory_item_id"
                  >
                    <option value="">Show All</option>
                    <option v-for="category in categories" :value="category.id">
                      {{ category.name }}
                    </option>
                  </select>
                  <PrimaryButton @click="generatePdf" :disabled="!filteredItems.length"> Print </PrimaryButton>
                </div>
              </div>
            </template>
            <template #header>
              <tr>
                <th
                  scope="col"
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
                >
                  Qty.
                </th>
                <th
                  scope="col"
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
                >
                  Unit
                </th>
                <th
                  scope="col"
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
                >
                  Description
                </th>
                <th
                  scope="col"
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
                >
                  Unit Price
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
                  Notes
                </th>
              </tr>
            </template>
            <template #content>
              <tr v-for="item in filteredItems">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  {{ item.refill_quantity }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  {{ item.unit }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  <Link :href="route('inventory.show', item.id)"> {{ item.name }}</Link>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  {{ item.est_cost_formatted }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  P{{ (item.est_cost * item.refill_quantity)?.toLocaleString() }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-left text-sm font-medium">
                  Notes
                </td>
              </tr>
              <tr>
                <td
                  class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right"
                ></td>
                <td
                  class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right"
                ></td>
                <td
                  class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right"
                ></td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-left">
                  <span class="font-bold">Total</span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-left">
                  <span class="font-bold">P{{ estCostTotal }}</span>
                </td>
                <td
                  class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right"
                ></td>
              </tr>
            </template>
          </TableList>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
