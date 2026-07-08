<template>
  <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

    <div class="flex items-center space-x-4">
      <button
          @click="navigateTo('/invoices')"
          class="text-gray-500 hover:text-gray-700 transition"
          title="Назад до списку"
      >
        ← Назад
      </button>
      <h1 class="text-2xl font-bold text-gray-900">Новий інвойс</h1>
    </div>

    <div v-if="submitError" class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">
      <p class="font-semibold">Помилка при збереженні інвойсу:</p>
      <p>{{ submitError }}</p>
    </div>

    <InvoiceForm
        :loading="isSubmitting"
        @save="handleCreateInvoice"
    />
  </div>
</template>

<script setup>
const isSubmitting = ref(false)
const submitError = ref(null)

const { createInvoice } = useInvoices()

const handleCreateInvoice = async (formData) => {
  isSubmitting.value = true
  submitError.value = null

  try {
    await createInvoice(formData)

    await navigateTo('/invoices')
  } catch (err) {
    console.error('Create invoice error:', err)
    submitError.value = err.data?.message || err.message || 'Не вдалося зберегти інвойс. Спробуйте пізніше.'
  } finally {
    isSubmitting.value = false
  }
}
</script>