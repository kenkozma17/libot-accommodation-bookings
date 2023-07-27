<script setup>
import { useForm } from '@inertiajs/vue3';
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
});

</script>
<template>
  <FormSection>
      <template #title>
          Payment Information
      </template>

      <template #description>
          The payment details made on bookings.
      </template>

      <template #form>
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
      </template>

      <template #actions>
          <SecondaryButton 
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
