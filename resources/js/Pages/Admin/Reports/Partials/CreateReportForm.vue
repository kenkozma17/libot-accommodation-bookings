<script setup>
import { useForm } from "@inertiajs/vue3";
import { reactive } from "vue";
import FormSection from "@/Components/FormSection.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import dayjs from "dayjs";

const months = reactive([
  "January",
  "February",
  "March",
  "April",
  "May",
  "June",
  "July",
  "August",
  "September",
  "October",
  "November",
  "December",
]);

const yearsArray = [];
for (let year = 2024; year <= dayjs().year(); year++) {
  yearsArray.push(year);
}

const years = reactive(yearsArray);

const form = useForm({
  month: "January",
  year: dayjs().year(),
});

const createReport = () => {
  form.get(route("reports.generate"), {
    errorBag: "createReport",
    preserveScroll: true,
  });
};
</script>
<template>
  <FormSection @submitted="createReport">
    <template #title> Report Generation </template>

    <template #description> Generate a new monthly cash flow report. </template>

    <template #form>
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="year" value="Year" />
        <select
          class="block w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
          v-model="form.year"
          name="year"
          id="year"
        >
          <option v-for="year in years" :value="year">{{ year }}</option>
        </select>
        <InputError :message="form.errors.year" class="mt-2" />
      </div>
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="month" value="Month" />
        <select
          class="block w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
          v-model="form.month"
          name="month"
          id="month"
        >
          <option v-for="month in months" :value="month">{{ month }}</option>
        </select>
        <InputError :message="form.errors.month" class="mt-2" />
      </div>
    </template>

    <template #actions>
      <PrimaryButton
        :class="{ 'opacity-25': form.processing }"
        :disabled="form.processing"
      >
        Generate
      </PrimaryButton>
    </template>
  </FormSection>
</template>
