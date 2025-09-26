<script setup>
import { useForm } from "@inertiajs/vue3";
import FormSection from "@/Components/FormSection.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import { ref, computed } from "vue";

const props = defineProps({
  items: Array,
  units: Array,
});

const selectedItem = computed(() => {
  if (form.inventory_item_id) {
    return props.items.find((item) => item.id === form.inventory_item_id);
  }
});

const form = useForm({
  type: "",
  quantity: "",
  unit: "",
  inventory_item_id: "",
  note: "",
});

const types = ref(["Adjustment", "Decrease", "Increase"]);

const createMovement = () => {
  form.post(route("inventory-movement.store"), {
    errorBag: "storeInventoryMovement",
    preserveScroll: true,
    onSuccess: () => (isReadOnly.value = true),
  });
};

function resetForm() {
  isReadOnly.value = !isReadOnly.value;
  form.reset();
}
</script>
<template>
  <FormSection @submitted="createMovement">
    <template #title> Create a Transaction </template>

    <template #description> Increase or decrease an item's stock level. </template>

    <template #form>
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="type" value="Transaction Type" />
        <select
          required
          class="block w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
          v-model="form.type"
          name="type"
          id="type"
        >
          <option value="" disabled>Select transaction type</option>
          <option v-for="type in types" :value="type">
            {{ type }}
          </option>
        </select>
        <InputError :message="form.errors.type" class="mt-2" />
      </div>

      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="inventory_item_id" value="Inventory Item" />
        <select
          @change="form.unit = selectedItem.unit"
          required
          class="block w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
          v-model="form.inventory_item_id"
          name="inventory_item_id"
          id="inventory_item_id"
        >
          <option value="" disabled>Select inventory item</option>
          <option v-for="item in items" :value="item.id">
            {{ item.name }} - {{ item.category.name }}
          </option>
        </select>
        <InputError :message="form.errors.inventory_item_id" class="mt-2" />
      </div>

      <div class="col-span-6 sm:col-span-4">
        <InputLabel
          for="quantity"
          value="Quantity (If adjustment is a decrease, use negative number)"
        />
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

      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="unit" value="Unit" />
        <TextInput
          required
          id="unit"
          :class="{ 'bg-gray-100': true }"
          :disabled="true"
          v-model="form.unit"
          type="text"
          class="block w-full mt-1"
          autofocus
        />
        <InputError :message="form.errors.unit" class="mt-2" />
      </div>

      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="note" value="Note" />
        <TextInput
          id="note"
          v-model="form.note"
          type="text"
          class="block w-full mt-1"
          autofocus
        />
        <InputError :message="form.errors.note" class="mt-2" />
      </div>
    </template>

    <template #actions>
      <PrimaryButton
        class="ml-2"
        :class="{ 'opacity-25': form.processing }"
        :disabled="form.processing"
      >
        Save
      </PrimaryButton>
    </template>
  </FormSection>
</template>
