<script setup>
import dayjs from 'dayjs';

const daysInAMonth = dayjs().daysInMonth();
</script>

<template>
    <div>
        <div class="bg-gray-200 bg-opacity-25 gap-6 lg:gap-8 p-6 lg:p-8">
          <table class="w-full">
            <thead>
              <tr>
                <td>Rooms</td>
                <td>
                  <table class="w-full">
                    <tbody>
                      <th>
                        <th 
                          v-for="index in daysInAMonth" 
                          :key="index"
                          >
                          {{index}}
                        </th>
                      </th>
                    </tbody>
                  </table>
                </td>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  <tr>test</tr>
                </td>
                <td>
                  <tr></tr>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
    </div>
</template>
<style scoped>
  table, td, th {
    border: 1px solid;
  }
</style>
