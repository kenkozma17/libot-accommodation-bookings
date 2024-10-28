<script setup>
import { useForm } from "@inertiajs/vue3";
import { computed, ref } from "vue";
import FormSection from "@/Components/FormSection.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import dayjs from "dayjs";
import Checkbox from "@/Components/Checkbox.vue";

const isReadOnly = ref(true);

const props = defineProps({
  transaction: Object,
  serviceCategories: Array,
});

const guest = computed(() => {
  if (props.transaction.folio.guest) {
    return props.transaction.folio.guest;
  }
  return props.transaction.folio.booking.guest;
});

const form = useForm({
  folio_id: props.transaction.folio_id,
  service_id: props.transaction.service_id,
  quantity: props.transaction.quantity,
  description: props.transaction.description,
  payment_method: props.transaction.payment_method,
  is_paid: props.transaction.is_paid ? true : false,
});

function resetForm() {
  isReadOnly.value = !isReadOnly.value;
  form.reset();
}

const updateFolioTransaction = () => {
  form.put(route("folio-transactions.update", props.transaction.id), {
    errorBag: "updateFolioTransaction",
    preserveScroll: true,
    onSuccess: () => (isReadOnly.value = true),
  });
};
</script>
<template>
  <FormSection @submitted="updateFolioTransaction">
    <template #title> Folio Transaction </template>

    <template #description>
      Folio transaction for <b>{{ guest.full_name }}</b> on
      <i>{{ dayjs(transaction.date_placed).format("MMM DD, YYYY") }}</i
      >. <br />
      Registration No: <b>{{ transaction.folio.registration_number }}</b>
    </template>

    <template #form>
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="services" value="Hotel Services" />
        <select
          required
          :disabled="isReadOnly"
          :class="{ 'bg-gray-100': isReadOnly }"
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
          :disabled="isReadOnly"
          :class="{ 'bg-gray-100': isReadOnly }"
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
        <select
          required
          class="block w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
          v-model="form.payment_method"
          name="payment_method"
          id="payment_method"
          :disabled="isReadOnly"
          :class="{ 'bg-gray-100': isReadOnly }"
        >
          <option value="" disabled selected>Select Payment Method</option>
          <option class="ml-[1rem]">Cash</option>
          <option class="ml-[1rem]">Credit/Debit Card</option>
          <option class="ml-[1rem]">Gcash</option>
          <option class="ml-[1rem]">PayMaya</option>
          <option class="ml-[1rem]">Check</option>
        </select>
        <InputError :message="form.errors.payment_method" class="mt-2" />
      </div>
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="description" value="Description" />
        <textarea
          :disabled="isReadOnly"
          :class="{ 'bg-gray-100': isReadOnly }"
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
          <Checkbox
            :disabled="isReadOnly"
            :class="{ 'bg-gray-100': isReadOnly }"
            :checked="form.is_paid"
            @change="form.is_paid = !form.is_paid"
          />
        </label>
      </div>
    </template>

    <template #actions>
      <SecondaryButton @click="resetForm">
        {{ isReadOnly ? "Edit" : "Cancel" }}
      </SecondaryButton>
      <PrimaryButton
        v-if="!isReadOnly"
        class="ml-2"
        :class="{ 'opacity-25': form.processing }"
        :disabled="form.processing"
      >
        Update
      </PrimaryButton>
    </template>
  </FormSection>
</template>
