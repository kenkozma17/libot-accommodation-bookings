<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import { ref, reactive } from 'vue'; 
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
  payment: Object
});

const isReadOnly = ref(true);

const form = useForm({
    id: props.payment.id,
    payment_amount: props.payment.payment_amount,
    paymongo_payment_id: props.payment.paymongo_payment_id,
    payer_name: props.payment.payer_name,
    payer_email: props.payment.payer_email,
    payment_method: props.payment.payment_method,
    payment_date: props.payment.payment_date_formatted,
    payment_status: props.payment.payment_status,
    card_last_four_digits: props.payment.card_last_four_digits,
});

</script>
<template>
  <FormSection>
      <template #title>
          Payment Information
      </template>

      <template #description>
          The payment details made on a booking.
      </template>

      <template #image>
        <SecondaryButton class="mt-2">
          <Link :href="route('bookings.show', payment.booking_id)">
            Go To Booking
          </Link>
        </SecondaryButton>
      </template>

      <template #form>
        <div class="col-span-6 sm:col-span-4">
              <InputLabel for="paymongo_payment_id" value="Transaction ID" />
              <TextInput
                  :disabled="isReadOnly"
                  id="paymongo_payment_id"
                  v-model="form.paymongo_payment_id"
                  type="text"
                  class="block w-full mt-1"
                  :class="{'bg-gray-100': isReadOnly}"
                  autofocus
              />
              <InputError :message="form.errors.paymongo_payment_id" class="mt-2" />
          </div>
          <div class="col-span-6 sm:col-span-4">
              <InputLabel for="payment_amount" value="Payment Amount (PHP)" />
              <TextInput
                  :disabled="isReadOnly"
                  id="payment_amount"
                  v-model="form.payment_amount"
                  type="text"
                  class="block w-full mt-1"
                  :class="{'bg-gray-100': isReadOnly}"
                  autofocus
              />
              <InputError :message="form.errors.payment_amount" class="mt-2" />
          </div>
          <div class="col-span-6 sm:col-span-4">
              <InputLabel for="payer_name" value="Payer Name" />
              <TextInput
                  :disabled="isReadOnly"
                  id="payer_name"
                  v-model="form.payer_name"
                  type="text"
                  class="block w-full mt-1"
                  :class="{'bg-gray-100': isReadOnly}"
                  autofocus
              />
              <InputError :message="form.errors.payer_name" class="mt-2" />
          </div>
          <div class="col-span-6 sm:col-span-4">
              <InputLabel for="payer_email" value="Payer Email" />
              <TextInput
                  :disabled="isReadOnly"
                  id="payer_email"
                  v-model="form.payer_email"
                  type="text"
                  class="block w-full mt-1"
                  :class="{'bg-gray-100': isReadOnly}"
                  autofocus
              />
              <InputError :message="form.errors.payer_email" class="mt-2" />
          </div>
          <div class="col-span-6 sm:col-span-4">
              <InputLabel for="payment_date" value="Payment Date" />
              <TextInput
                  :disabled="isReadOnly"
                  id="payment_date"
                  v-model="form.payment_date"
                  type="text"
                  class="block w-full mt-1"
                  :class="{'bg-gray-100': isReadOnly}"
                  autofocus
              />
              <InputError :message="form.errors.payment_date" class="mt-2" />
          </div>
          <div class="col-span-6 sm:col-span-4">
              <InputLabel for="payment_method" value="Payment Method" />
              <TextInput
                  :disabled="isReadOnly"
                  id="payment_method"
                  v-model="form.payment_method"
                  type="text"
                  class="block w-full mt-1"
                  :class="{'bg-gray-100': isReadOnly}"
                  autofocus
              />
              <InputError :message="form.errors.payment_method" class="mt-2" />
          </div>
          <div class="col-span-6 sm:col-span-4">
              <InputLabel for="card_last_four_digits" value="Last 4 Digits on CC/DC" />
              <TextInput
                  :disabled="isReadOnly"
                  id="card_last_four_digits"
                  v-model="form.card_last_four_digits"
                  type="text"
                  class="block w-full mt-1"
                  :class="{'bg-gray-100': isReadOnly}"
                  autofocus
              />
              <InputError :message="form.errors.card_last_four_digits" class="mt-2" />
          </div>
          <div class="col-span-6 sm:col-span-4">
              <InputLabel for="card_expiry_date" value="Card Expiry Date" />
              <TextInput
                  :disabled="isReadOnly"
                  id="card_expiry_date"
                  v-model="form.card_expiry_date"
                  type="text"
                  class="block w-full mt-1"
                  :class="{'bg-gray-100': isReadOnly}"
                  autofocus
              />
              <InputError :message="form.errors.card_expiry_date" class="mt-2" />
          </div>
          <div class="col-span-6 sm:col-span-4">
              <InputLabel for="payment_status" value="Payment Status" />
              <TextInput
                  :disabled="isReadOnly"
                  id="payment_status"
                  v-model="form.payment_status"
                  type="text"
                  class="block w-full mt-1"
                  :class="{'bg-gray-100': isReadOnly}"
                  autofocus
              />
              <InputError :message="form.errors.payment_status" class="mt-2" />
          </div>
      </template>

      <template #actions>
          <SecondaryButton
            :disabled="true" 
            @click="resetForm">
            {{ isReadOnly ? 'Edit' : 'Cancel'}}
          </SecondaryButton>
          <PrimaryButton 
            v-if="!isReadOnly" 
            class="ml-2"
            :class="{ 'opacity-25': form.processing }" 
            :disabled="form.processing">
            Save
          </PrimaryButton>
      </template>
  </FormSection>
</template>
