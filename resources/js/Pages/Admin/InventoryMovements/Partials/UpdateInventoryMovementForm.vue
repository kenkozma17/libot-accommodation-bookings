<script setup>
import { useForm } from "@inertiajs/vue3";
import FormSection from "@/Components/FormSection.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import { ref } from "vue";

const props = defineProps({
  movement: Object,
});

const form = useForm({
  type: props.movement.type,
  quantity: props.movement.quantity,
  unit: props.movement.unit,
  inventory_item_id: props.movement.inventory_item_id,
  note: props.movement.note,
  current_stock: props.movement.current_stock,
  previous_stock: props.movement.previous_stock,
});
</script>
<template>
  <FormSection @submitted="createMovement">
    <template #title> Inventory Transaction Transaction Details </template>

    <template #description> Created on: <b>{{ props.movement.created_at_formatted }}</b> </template>

    <template #form>
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="type" value="Transaction Type" />
        <TextInput
          :class="{ 'bg-gray-100': true }"
          :disabled="true"
          required
          id="type"
          v-model="form.type"
          type="text"
          class="block w-full mt-1"
          autofocus
        />
        <InputError :message="form.errors.type" class="mt-2" />
      </div>
      <div class="col-span-6 sm:col-span-4">
        <InputLabel
          for="quantity"
          value="Quantity (If adjustment is a decrease, use negative number)"
        />
        <TextInput
          :class="{ 'bg-gray-100': true }"
          :disabled="true"
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
        <InputLabel for="current_stock" value="Current Stock" />
        <TextInput
          required
          id="current_stock"
          :class="{ 'bg-gray-100': true }"
          :disabled="true"
          v-model="form.current_stock"
          type="text"
          class="block w-full mt-1"
          autofocus
        />
        <InputError :message="form.errors.current_stock" class="mt-2" />
      </div>

      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="previous_stock" value="Previous Stock" />
        <TextInput
          required
          id="previous_stock"
          :class="{ 'bg-gray-100': true }"
          :disabled="true"
          v-model="form.previous_stock"
          type="text"
          class="block w-full mt-1"
          autofocus
        />
        <InputError :message="form.errors.previous_stock" class="mt-2" />
      </div>

      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="note" value="Note" />
        <TextInput
          :class="{ 'bg-gray-100': true }"
          :disabled="true"
          id="note"
          v-model="form.note"
          type="text"
          class="block w-full mt-1"
          autofocus
        />
        <InputError :message="form.errors.note" class="mt-2" />
      </div>
    </template>

    <!-- <template #actions>
      <PrimaryButton
        class="ml-2"
        :class="{ 'opacity-25': form.processing }"
        :disabled="form.processing"
      >
        Save
      </PrimaryButton>
    </template> -->
  </FormSection>
</template>
