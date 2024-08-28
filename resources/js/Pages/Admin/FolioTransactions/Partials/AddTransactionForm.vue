<script setup>
import { useForm } from "@inertiajs/vue3";
import { reactive } from "vue";
import FormSection from "@/Components/FormSection.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import Checkbox from "@/Components/Checkbox.vue";

const props = defineProps({
  folio: Object,
  serviceCategories: Array,
});

const form = useForm({
  folio_id: props.folio.id,
  service_id: "",
  quantity: "",
  description: "",
  payment_method: "",
  is_paid: false,
  date_placed: "",
});

const createFolioTransaction = () => {
  form.post(route("folio-transactions.store"), {
    errorBag: "createFolioTransaction",
    preserveScroll: true,
    onSuccess: () => {
      form.reset();
    },
  });
};
</script>
<template>
  <FormSection @submitted="createFolioTransaction">
    <template #title> Folio Transaction </template>

    <template #description>
      Create a new income transaction on a Guest's Folio.
    </template>

    <template #form>
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="services" value="Hotel Services" />
        <select
          required
          class="block w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
          v-model="form.service_id"
          name="services"
          id="services"
        >
          <option value="" disabled selected>Select Service</option>
          <template v-for="serviceCategory in props.serviceCategories">
            <option disabled>{{ serviceCategory.name }}</option>
            <option
              class="ml-[1rem]"
              v-if="serviceCategory.services"
              v-for="service in serviceCategory.services"
              :key="service.id"
              :value="service.id"
            >
              &nbsp;&nbsp;{{ service.name }} - {{ service.formatted_price }}
            </option>
          </template>
        </select>
        <InputError :message="form.errors.services" class="mt-2" />
      </div>
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="quantity" value="Quantity" />
        <TextInput
          required
          id="quantity"
          v-model="form.quantity"
          type="number"
          min="1"
          class="block w-full mt-1"
          autofocus
        />
        <InputError :message="form.errors.quantity" class="mt-2" />
      </div>
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="payment_method" value="Payment Method" />
        <TextInput
          required
          id="payment_method"
          v-model="form.payment_method"
          type="text"
          class="block w-full mt-1"
          autofocus
        />
        <InputError :message="form.errors.payment_method" class="mt-2" />
      </div>
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="date_placed" value="Date" />
        <TextInput
        required
          id="date_placed"
          v-model="form.date_placed"
          type="date"
          class="block w-full mt-1"
          autofocus
        />
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
        <InputLabel for="amenities" value="Has this transaction been paid for?" />
        <label class="flex items-center">
          <Checkbox :checked="form.is_paid" @change="form.is_paid = !form.is_paid" />
        </label>
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
