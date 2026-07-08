<template>
  <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

    <div class="flex justify-between items-center border-b border-gray-200 pb-5">
      <div class="flex items-center space-x-4">
        <button @click="navigateTo('/invoices')" class="text-gray-500 hover:text-gray-700 transition">
          ← До списку
        </button>
        <h1 class="text-2xl font-bold text-gray-900" v-if="invoice">
          Інвойс {{ invoice.number }}
        </h1>
      </div>

      <NuxtLink
          v-if="invoice && invoice.status === 'pending'"
          :to="`/invoices/${invoiceId}/edit`"
          class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition font-medium text-sm shadow-sm"
      >
        Редагувати інвойс
      </NuxtLink>
    </div>

    <div v-if="pending" class="flex justify-center items-center py-12">
      <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
    </div>

    <div v-else-if="error" class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
      Не вдалося завантажити дані інвойсу. Можливо, він був видалений.
    </div>

    <div v-else-if="invoice" class="bg-white shadow rounded-lg border border-gray-200 overflow-hidden">
      <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
        <span class="text-sm font-medium text-gray-500">Основна інформація</span>
        <StatusBadge :status="invoice.status" />
      </div>

      <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
        <div>
          <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider">Постачальник</span>
          <span class="mt-1 block text-base font-medium text-gray-900">{{ invoice.supplier_name }}</span>
        </div>

        <div>
          <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider">Податковий номер (Tax ID)</span>
          <span class="mt-1 block text-base font-medium text-gray-900">{{ invoice.supplier_tax_id }}</span>
        </div>

        <div class="md:col-span-2 border-t border-b border-gray-100 py-4 grid grid-cols-3 gap-4 bg-gray-50/30 px-2 rounded">
          <div>
            <span class="block text-xs text-gray-500">Сума Net</span>
            <span class="text-base font-medium text-gray-900">{{ invoice.net_amount }} {{ invoice.currency }}</span>
          </div>
          <div>
            <span class="block text-xs text-gray-500">ПДВ (VAT)</span>
            <span class="text-base font-medium text-gray-900">{{ invoice.vat_amount }} {{ invoice.currency }}</span>
          </div>
          <div>
            <span class="block text-xs font-semibold text-blue-600">Разом (Gross)</span>
            <span class="text-base font-bold text-blue-600">{{ invoice.gross_amount }} {{ invoice.currency }}</span>
          </div>
        </div>

        <div>
          <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider">Дата виписки</span>
          <span class="mt-1 block text-base text-gray-900">{{ formatDate(invoice.issue_date) }}</span>
        </div>

        <div>
          <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider">Термін оплати (Due Date)</span>
          <span class="mt-1 block text-base text-gray-900 font-medium" :class="isOverdue(invoice.due_date) ? 'text-red-600 font-semibold' : 'text-gray-900'">
            {{ formatDate(invoice.due_date) }}
            <span v-if="isOverdue(invoice.due_date)" class="text-xs ml-1 font-normal">(Протерміновано)</span>
          </span>
        </div>

        <div class="md:col-span-2 border-t border-gray-100 pt-4 flex justify-between text-xs text-gray-400">
          <span>Створено: {{ formatDateTime(invoice.created_at) }}</span>
          <span>Останнє оновлення (Last Updated): {{ formatDateTime(invoice.updated_at) }}</span>
        </div>
      </div>
    </div>

  </div>
</template>

<script setup>
const route = useRoute()
const invoiceId = route.params.id
const { getInvoice } = useInvoices()

const { data: invoice, pending, error } = await getInvoice(invoiceId)

const formatDate = (dateStr) => {
  if (!dateStr) return '—'
  return new Date(dateStr).toLocaleDateString('uk-UA', {
    day: 'numeric',
    month: 'long',
    year: 'numeric'
  })
}

const formatDateTime = (dateTimeStr) => {
  if (!dateTimeStr) return '—'
  return new Date(dateTimeStr).toLocaleString('uk-UA', {
    day: 'numeric',
    month: '2-digit',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}

const isOverdue = (dueDateStr) => {
  if (!dueDateStr) return false
  return new Date(dueDateStr) < new Date() && invoice.value?.status === 'pending'
}
</script>