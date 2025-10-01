<script setup>
import { useForm } from "@inertiajs/vue3";
import FormSection from "@/Components/FormSection.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import TableList from "@/Components/TableList.vue";
import { Link } from "@inertiajs/vue3";
import { computed } from "vue";
import CloseIcon from "@/Components/Icons/CloseIcon.vue";

const props = defineProps({
  service: Object,
  items: Array,
});

const form = useForm({
  inventory_item_id: "",
  quantity: "",
});

const addInventoryItem = () => {
  form.post(route("services.add-inventory-item", props.service.id), {
    errorBag: "addInventoryItem",
    preserveScroll: true,
  });
};

const deleteForm = useForm({
  inventory_item_id: ""
});

const removeInventoryItem = (inventoryItemId) => {
  if(window.confirm('Are you sure you want to remove this item from the service?')) {
    deleteForm.inventory_item_id = inventoryItemId;
    deleteForm.delete(route("services.remove-inventory-item", props.service.id), {
      errorBag: "removeInventoryItem",
      preserveScroll: true,
    });
  }
}

const estCostTotal = computed(() => {
  if(props.service.inventory_items) {
    const attachedItems = props.service.inventory_items;
    const compiledEstCosts = attachedItems.map(item => {
      return item.pivot.quantity * item.est_cost;
    });

    const estCostTotal = compiledEstCosts.reduce((accumulator, currentValue) => accumulator + currentValue, 0);
    return estCostTotal.toLocaleString();
  }

  return 0;
});
</script>
<template>
  <FormSection @submitted="addInventoryItem">
    <template #title> Service Inventory Items </template>

    <template #description> Attach Inventory Items that are consumed when this service is used. </template>

    <template #form>
      <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg col-span-6 border-gray border" v-if="props.service?.inventory_items">
        <p class="px-6 py-4 font-semibold">Attached Inventory Items</p>
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
                Item
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
                Est. Cost per Unit
              </th>
              <th
                scope="col"
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
              >
                Est. Cost
              </th>
            </tr>
          </template>
          <template #content>
            <tr v-for="item in props.service.inventory_items">
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <p @click="removeInventoryItem(item.id)" class="text-red-600 font-semibold hover:underline cursor-pointer">Remove</p>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <Link :href="route('inventory.show', item.id)">{{ item.name }}</Link>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                {{ item.pivot.quantity }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                {{ item.pivot.unit }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                {{ item.est_cost_formatted }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                P{{ (item.est_cost * item.pivot.quantity)?.toLocaleString() }}
              </td>
            </tr>
            <tr>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right"></td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right"></td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right"></td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right">
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right">
                <span class="font-bold">Total</span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right">
                <span class="font-bold">P{{ estCostTotal }}</span>
              </td>
            </tr>
          </template>
        </TableList>
      </div>

      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="inventory_item" value="Inventory Item" />
        <select
          required
          class="block w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
          v-model="form.inventory_item_id"
          name="inventory_item"
          id="inventory_item"
        >
          <option value="" disabled>Select an item</option>
          <option v-for="item in items" :value="item.id">
            {{ item.name }} ({{ item.unit }}) - {{ item.category.name }}
          </option>
        </select>
        <InputError :message="form.errors.item" class="mt-2" />
      </div>

      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="quantity" value="Quantity" />
        <TextInput
          required
          id="quantity"
          v-model="form.quantity"
          type="text"
          class="block w-full mt-1"
          autofocus
        />
        <InputError :message="form.errors.quantity" class="mt-2" />
      </div>
    </template>

    <template #actions>
      <PrimaryButton
        :class="{ 'opacity-25': form.processing }"
        :disabled="form.processing"
      >
        Add
      </PrimaryButton>
    </template>
  </FormSection>
</template>
