<template>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">
    <div class="flex justify-between items-center">
      <h1 class="text-2xl font-bold text-gray-900">Список інвойсів</h1>
      <NuxtLink
          to="/invoices/create"
          class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition"
      >
        Створити інвойс
      </NuxtLink>
    </div>

    <div v-if="pending" class="flex justify-center items-center py-12">
      <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
    </div>

    <div v-else-if="error" class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
      Помилка завантаження даних: {{ error.message || 'Зверніться до адміністратора' }}
    </div>

    <InvoiceTable
        v-else
        :invoices="invoicesResponse?.data || []"
    />
  </div>
</template>

<script setup>
const page = ref(1)
const { getInvoices } = useInvoices()

const { data: invoicesResponse, pending, error } = await getInvoices(page.value)
</script>