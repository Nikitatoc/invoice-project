<template>
  <div class="bg-white shadow rounded-lg overflow-hidden border border-gray-200">
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
      <tr>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Номер</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Постачальник</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Сума (Gross)</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Статус</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Термін оплати</th>
      </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
      <tr
          v-for="invoice in invoices"
          :key="invoice.id"
          @click="navigateTo(`/invoices/${invoice.id}`)"
          class="hover:bg-gray-50 cursor-pointer transition-colors"
      >
        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600">
          {{ invoice.number }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
          {{ invoice.supplier_name }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
          {{ invoice.gross_amount }} {{ invoice.currency }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm">
          <StatusBadge :status="invoice.status" />
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
          {{ invoice.due_date }}
        </td>
      </tr>

      <tr v-if="invoices.length === 0">
        <td colspan="5" class="px-6 py-12 text-center text-sm text-gray-500">
          Інвойси не знайдені.
        </td>
      </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
defineProps({
  invoices: {
    type: Array,
    required: true
  }
})
</script>