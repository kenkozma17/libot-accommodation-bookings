<script setup>
import { useForm } from "@inertiajs/vue3";
import { reactive, ref } from "vue";
import FormSection from "@/Components/FormSection.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";

const expenseTypes = reactive([
  "Payroll",
  "Security",
  "Utilities/Electricity",
  "Water",
  "Corkage Fee",
  "Market",
]);

const props = defineProps({
  expense: Object,
});

const isReadOnly = ref(true);

const form = useForm({
  name: props.expense.name,
  type: props.expense.type,
  description: props.expense.description,
  amount: props.expense.amount,
  expense_date: props.expense.expense_date,
  payment_method: props.expense.payment_method,
  vendor: props.expense.vendor,
  invoice_number: props.expense.invoice_number,
  notes: props.expense.notes,
});

const updateExpenseForm = () => {
  form.put(route("expenses.update", props.expense.id), {
    errorBag: "updateExpenseForm",
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
  <FormSection @submitted="updateExpenseForm">
    <template #title> Expense Information </template>

    <template #description> Create a new hotel operational expense. </template>

    <template #form>
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="name" value="Expense Name" />
        <TextInput
          :class="{ 'bg-gray-100': isReadOnly }"
          :disabled="isReadOnly"
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
          :class="{ 'bg-gray-100': isReadOnly }"
          :disabled="isReadOnly"
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
        <InputLabel for="amount" value="Amount" />
        <TextInput
          :class="{ 'bg-gray-100': isReadOnly }"
          :disabled="isReadOnly"
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
          :class="{ 'bg-gray-100': isReadOnly }"
          :disabled="isReadOnly"
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
          :class="{ 'bg-gray-100': isReadOnly }"
          :disabled="isReadOnly"
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
          :class="{ 'bg-gray-100': isReadOnly }"
          :disabled="isReadOnly"
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
          :class="{ 'bg-gray-100': isReadOnly }"
          :disabled="isReadOnly"
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
          :class="{ 'bg-gray-100': isReadOnly }"
          :disabled="isReadOnly"
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
      <!-- <SecondaryButton
          class="bg-red-500 text-white hover:bg-red-400"
          v-if="!isReadOnly"
          :disabled="props.isDisabled"
          @click="deleteService"
        >
          Delete
        </SecondaryButton> -->
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
    </template>
  </FormSection>
</template>
