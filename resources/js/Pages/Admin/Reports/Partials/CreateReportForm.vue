<script setup>
import { useForm } from "@inertiajs/vue3";
import { reactive } from "vue";
import FormSection from "@/Components/FormSection.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
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
  report_type: "",
  date: "",
});

const createReport = () => {
  const url = route("reports.generate", form);
  window.open(url, "_blank");
};
</script>
<template>
  <FormSection @submitted="createReport">
    <template #title> Report Generation </template>

    <template #description>
      Choose to generate a daily or monthly remittance report.
    </template>

    <template #form>
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="report_type" value="Report Type" />
        <select
          class="block w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
          v-model="form.report_type"
          name="report_type"
          id="report_type"
        >
          <option value="">Select Report Type</option>
          <option value="daily">Daily</option>
          <option value="monthly">Monthly</option>
        </select>
        <InputError :message="form.errors.year" class="mt-2" />
      </div>
      <template v-if="form.report_type === 'monthly'">
        <div class="col-span-6 sm:col-span-4">
          <InputLabel for="year" value="Year" />
          <select
            required
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
            required
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
      <template v-if="form.report_type === 'daily'">
        <div class="col-span-6 sm:col-span-4">
          <InputLabel for="date" value="Date" />
          <TextInput
            id="date"
            required
            v-model="form.date"
            type="date"
            class="block w-full mt-1"
            autofocus
          />
          <InputError :message="form.errors.date" class="mt-2" />
        </div>
      </template>
    </template>

    <template #actions>
      <PrimaryButton
        v-if="form.report_type"
        :class="{ 'opacity-25': form.processing }"
        :disabled="form.processing"
      >
        Generate
      </PrimaryButton>
    </template>
  </FormSection>
</template>
