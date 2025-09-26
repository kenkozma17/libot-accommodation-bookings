<script setup>
import TableList from "@/Components/TableList.vue";
import PaginationList from "@/Components/PaginationList.vue";
import FormSection from "@/Components/FormSection.vue";
import { Link } from "@inertiajs/vue3";
import { computed } from "vue";

const props = defineProps({
  item: Object,
  movements: Object,
});

</script>
<template>
  <FormSection>
    <template #title> Item Transactions </template>

    <template #description> View the transactions of the Inventory Item. </template>
    <template #form>
      <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg col-span-6" v-if="movements.data.length">
        <TableList :hasSearch="false">
          <template #header>
            <tr>
              <th
                scope="col"
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
              >
                Action
              </th>
              <th
                scope="col"
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
              >
                Type
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
                Unit
              </th>
              <th
                scope="col"
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
              >
                Current Stock
              </th>
              <th
                scope="col"
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
              >
                Previous Stock
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
            <tr v-for="movement in movements.data">
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <Link :href="route('inventory-movement.show', movement.id)">View</Link>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                {{ movement.type }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                {{ movement.quantity }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                {{ movement.unit }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                {{ movement.current_stock }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                {{ movement.previous_stock }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                {{ movement.created_at_formatted }}
              </td>
            </tr>
          </template>
          <template #pagination>
              <PaginationList :links="movements.links" />
          </template>
        </TableList>
      </div>
      <div class="p-4 col-span-6" v-else>
        <h2 class="font-semibold">No Transactions Yet...</h2>
      </div>
    </template>
  </FormSection>
</template>
