<template>
  <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

    <div class="flex items-center space-x-4">
      <button
          @click="navigateTo(`/invoices/${invoiceId}`)"
          class="text-gray-500 hover:text-gray-700 transition"
          title="Назад до деталей"
      >
        ← Скасувати
      </button>
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Редагування інвойсу</h1>
        <p v-if="invoice" class="text-xs text-gray-400">Вносяться зміни в документ № {{ invoice.number }}</p>
      </div>
    </div>

    <div v-if="pending" class="flex justify-center items-center py-12">
      <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
    </div>

    <div v-else-if="fetchError" class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">
      Не вдалося знайти інвойс для редагування.
    </div>

    <div v-else-if="invoice">
      <div v-if="submitError" class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">
        <p class="font-semibold">Помилка оновлення даних:</p>
        <p>{{ submitError }}</p>
      </div>

      <InvoiceForm
          :initial-data="invoice"
          :loading="isSubmitting"
          @save="handleUpdateInvoice"
      />
    </div>
  </div>
</template>

<script setup>
const route = useRoute()
const invoiceId = route.params.id
const isSubmitting = ref(false)
const submitError = ref(null)

const { getInvoice, updateInvoice } = useInvoices()

const { data: invoice, pending, error: fetchError } = await getInvoice(invoiceId)
watchEffect(() => {
  if (invoice.value && invoice.value.status !== 'pending') {
    navigateTo(`/invoices/${invoiceId}`)
  }
})

const handleUpdateInvoice = async (formData) => {
  isSubmitting.value = true
  submitError.value = null

  const allowedData = {
    net_amount: formData.net_amount,
    vat_amount: formData.vat_amount,
    gross_amount: formData.gross_amount,
    due_date: formData.due_date
  }

  try {
    await updateInvoice(invoiceId, allowedData)
    await refreshNuxtData(`invoice-${invoiceId}`)
    await navigateTo(`/invoices/${invoiceId}`)
  } catch (err) {
    console.error('Update error:', err)
    submitError.value = err.data?.message || err.message || 'Сталася помилка при збереженні змін.'
  } finally {
    isSubmitting.value = false
  }
}
</script>