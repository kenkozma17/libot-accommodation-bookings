<script setup>
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import FormSection from "@/Components/FormSection.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";

const props = defineProps({
  item: Object,
  categories: Array,
  units: Array,
  isDisabled: {
    type: Boolean,
    default: false,
  },
});

const isReadOnly = ref(true);

const form = useForm({
  name: props.item.name,
  est_cost: props.item.est_cost,
  description: props.item.description,
  stock: props.item.stock,
  unit: props.item.unit,
  min_level: props.item.min_level,
  refill_quantity: props.item.refill_quantity,
  inventory_category_id: props.item.inventory_category_id,
});

const updateInventory = () => {
  form.put(route("inventory.update", props.item.id), {
    errorBag: "updateInventory",
    preserveScroll: true,
    onSuccess: () => (isReadOnly.value = true),
  });
};

const deleteInventory = () => {
  const confirmDelete = confirm("Are you sure you want to delete this inventory item?");
  if (confirmDelete) {
    form.delete(route("inventory.destroy", props.item.id), {
      errorBag: "deleteInventory",
      preserveScroll: true,
    });
  }
};

function resetForm() {
  isReadOnly.value = !isReadOnly.value;
  form.reset();
}
</script>
<template>
  <FormSection @submitted="updateInventory">
    <template #title> Inventory Information </template>

    <template #description> Update inventory for the hotel. </template>

    <template #form>
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="name" value="Item Name" />
        <TextInput
          :class="{ 'bg-gray-100': isReadOnly }"
          :disabled="isReadOnly"
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
          :class="{ 'bg-gray-100': true }"
          :disabled="true"
          required
          id="stock"
          v-model="form.stock"
          type="number"
          class="block w-full mt-1"
          autofocus
        />
        <InputError :message="form.errors.stock" class="mt-2" />
      </div>
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="unit" value="Unit" />
        <select
          :class="{ 'bg-gray-100': isReadOnly }"
          :disabled="isReadOnly"
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
          :class="{ 'bg-gray-100': isReadOnly }"
          :disabled="isReadOnly"
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
          :class="{ 'bg-gray-100': isReadOnly }"
          :disabled="isReadOnly"
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
          :class="{ 'bg-gray-100': isReadOnly }"
          :disabled="isReadOnly"
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
          :class="{ 'bg-gray-100': isReadOnly }"
          :disabled="isReadOnly"
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
          :class="{ 'bg-gray-100': isReadOnly }"
          :disabled="isReadOnly"
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
      <SecondaryButton
        class="bg-red-400 text-white hover:bg-[red]"
        v-if="!isReadOnly"
        :disabled="props.isDisabled"
        @click="deleteInventory"
      >
        Delete
      </SecondaryButton>
      <div>
        <SecondaryButton class="ml-2" :disabled="props.isDisabled" @click="resetForm">
          {{ isReadOnly ? "Edit" : "Cancel" }}
        </SecondaryButton>
        <PrimaryButton
          v-if="!isReadOnly"
          class="ml-2"
          :class="{ 'opacity-25': form.processing }"
          :disabled="form.processing"
        >
          Save
        </PrimaryButton>
      </div>
    </template>
  </FormSection>
</template>
