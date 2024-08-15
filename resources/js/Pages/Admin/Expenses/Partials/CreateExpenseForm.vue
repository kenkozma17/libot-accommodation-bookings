<script setup>
import { useForm } from "@inertiajs/vue3";
import { reactive, ref } from "vue";
import FormSection from "@/Components/FormSection.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from '@/Components/TextInput.vue';

const expenseTypes = reactive([
    'Payroll',
    'Security',
    'Utilities/Electricity',
    'Water',
    'Corkage Fee',
    'Market'
]);

const form = useForm({
  name: "",
  type: "",
  description: "",
  amount: "",
  expense_date: "",
  payment_method: "",
  vendor: "",
  invoice_number: "",
  notes: "",
});

const createExpense = () => {
  form.post(route("expenses.store"), {
    errorBag: "createExpense",
    preserveScroll: true,
  });
};
</script>
<template>
  <FormSection @submitted="createExpense">
    <template #title> Expense Information </template>

    <template #description> Create a new hotel operational expense. </template>

    <template #form>
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="name" value="Expense Name" />
        <TextInput
          id="name"
          v-model="form.name"
          type="text"
          class="block w-full mt-1"
          autofocus
        />
        <InputError :message="form.errors.name" class="mt-2" />
      </div>
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="type" value="Type" />
        <select
          class="block w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
          v-model="form.type"
          required
          name="type"
          id="type"
        >
          <option value="" disabled selected>Select Expense Type</option>
          <option v-for="(type, index) in expenseTypes" :value="type" :key="index">
            {{ type }}
          </option>
        </select>
        <InputError :message="form.errors.type" class="mt-2" />
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
        <InputLabel for="amount" value="Amount" />
        <TextInput
          id="amount"
          v-model="form.amount"
          type="number"
          class="block w-full mt-1"
          autofocus
        />
        <InputError :message="form.errors.amount" class="mt-2" />
      </div>
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="expense_date" value="Expense Date" />
        <TextInput
          id="expense_date"
          v-model="form.expense_date"
          type="date"
          class="block w-full mt-1"
          autofocus
        />
        <InputError :message="form.errors.expense_date" class="mt-2" />
      </div>
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="payment_method" value="Payment Method" />
        <TextInput
          id="payment_method"
          v-model="form.payment_method"
          type="text"
          class="block w-full mt-1"
          autofocus
        />
        <InputError :message="form.errors.payment_method" class="mt-2" />
      </div>
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="vendor" value="Vendor" />
        <TextInput
          id="vendor"
          v-model="form.vendor"
          type="text"
          class="block w-full mt-1"
          autofocus
        />
        <InputError :message="form.errors.vendor" class="mt-2" />
      </div>
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="invoice_number" value="Invoice Number" />
        <TextInput
          id="invoice_number"
          v-model="form.invoice_number"
          type="text"
          class="block w-full mt-1"
          autofocus
        />
        <InputError :message="form.errors.invoice_number" class="mt-2" />
      </div>
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="notes" value="Notes" />
        <textarea
          id="notes"
          v-model="form.notes"
          type="text"
          class="block w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
          autofocus
        ></textarea>
        <InputError :message="form.errors.notes" class="mt-2" />
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
