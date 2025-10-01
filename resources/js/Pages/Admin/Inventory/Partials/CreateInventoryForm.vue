<script setup>
import { useForm } from "@inertiajs/vue3";
import FormSection from "@/Components/FormSection.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";

const props = defineProps({
  categories: Array,
  units: Array,
});

const form = useForm({
  name: "",
  est_cost: "",
  description: "",
  stock: "",
  unit: "",
  min_level: "",
  refill_quantity: "",
  inventory_category_id: "",
});

const createInventory = () => {
  form.post(route("inventory.store"), {
    errorBag: "createInventory",
    preserveScroll: true,
  });
};
</script>
<template>
  <FormSection @submitted="createInventory">
    <template #title> Inventory Information </template>

    <template #description> Create a new inventory item for the hotel. </template>

    <template #form>
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="name" value="Item Name" />
        <TextInput
          required
          id="name"
          v-model="form.name"
          type="text"
          class="block w-full mt-1"
          autofocus
        />
        <InputError :message="form.errors.name" class="mt-2" />
      </div>
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="stock" value="Stock" />
        <TextInput
          required
          id="stock"
          v-model="form.stock"
          type="text"
          class="block w-full mt-1"
          autofocus
        />
        <InputError :message="form.errors.stock" class="mt-2" />
      </div>
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="unit" value="Unit" />
        <select
          required
          class="block w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
          v-model="form.unit"
          name="unit"
          id="unit"
        >
          <option value="" disabled>Select unit of measurement</option>
          <option v-for="unit in units" :value="unit">
            {{ unit }}
          </option>
        </select>
        <InputError :message="form.errors.unit" class="mt-2" />
      </div>
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="min_level" value="Min. Level" />
        <TextInput
          required
          id="min_level"
          v-model="form.min_level"
          type="text"
          class="block w-full mt-1"
          autofocus
        />
        <InputError :message="form.errors.min_level" class="mt-2" />
      </div>
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="refill_quantity" value="Refill Quantity" />
        <TextInput
          required
          id="refill_quantity"
          v-model="form.refill_quantity"
          type="text"
          class="block w-full mt-1"
          autofocus
        />
        <InputError :message="form.errors.refill_quantity" class="mt-2" />
      </div>
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="est_cost" value="Est. Cost (PHP)" />
        <TextInput
          required
          id="est_cost"
          v-model="form.est_cost"
          type="text"
          class="block w-full mt-1"
          autofocus
        />
        <InputError :message="form.errors.est_cost" class="mt-2" />
      </div>
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="description" value="Description" />
        <textarea
          id="description"
          v-model="form.description"
          type="text"
          class="block w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
          autofocus
        ></textarea>
        <InputError :message="form.errors.description" class="mt-2" />
      </div>
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="category" value="Category" />
        <select
          required
          class="block w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
          v-model="form.inventory_category_id"
          name="category"
          id="category"
        >
          <option value="" disabled>Select a category</option>
          <option v-for="category in categories" :value="category.id">
            {{ category.name }}
          </option>
        </select>
        <InputError :message="form.errors.category" class="mt-2" />
      </div>
    </template>

    <template #actions>
      <PrimaryButton
        :class="{ 'opacity-25': form.processing }"
        :disabled="form.processing"
      >
        Create
      </PrimaryButton>
    </template>
  </FormSection>
</template>
