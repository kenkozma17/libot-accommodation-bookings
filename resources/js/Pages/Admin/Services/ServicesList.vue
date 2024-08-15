<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import TableList from "@/Components/TableList.vue";
import PaginationList from "@/Components/PaginationList.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { Link } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
  services: Object,
  search: String,
});

const s = ref(props.search);
</script>
<template>
  <AppLayout title="Services/Products Management">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Services/Products Management
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
                    placeholder="Search by Service Name"
                  />
                </form>
                <SecondaryButton class="justify-center">
                  <Link :href="route('services.index')"> Clear Search </Link>
                </SecondaryButton>
              </div>
            </template>
            <template #header>
              <tr>
                <th
                  scope="col"
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
                >
                  Name
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
                  Description
                </th>

                <th
                  scope="col"
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
                >
                  Category
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
              <tr v-for="service in services.data">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  <Link :href="route('services.show', service.id)">
                    {{ service.name }}
                  </Link>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  {{ service.formatted_price }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  {{ service.description }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  {{ service.category.name }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                  <Link :href="route('services.show', service.id)">View</Link>
                </td>
              </tr>
            </template>
            <template #pagination>
              <PaginationList :links="services.links" />
            </template>
          </TableList>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
