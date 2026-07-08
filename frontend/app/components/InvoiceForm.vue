<template>
  <form @submit.prevent="handleSubmit" class="space-y-6 bg-white p-6 shadow rounded-lg border border-gray-200">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

      <div>
        <label class="block text-sm font-medium text-gray-700">Номер інвойсу</label>
        <input
            v-model="form.number"
            type="text"
            :disabled="isEdit"
            placeholder="напр., INV-2026-001"
            class="mt-1 block w-full rounded-md shadow-sm sm:text-sm border p-2 disabled:bg-gray-100 disabled:text-gray-500"
            :class="errors.number ? 'border-red-300 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-blue-500 focus:ring-blue-500'"
        />
        <p v-if="errors.number" class="mt-1 text-xs text-red-600">{{ errors.number }}</p>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Назва постачальника</label>
        <input
            v-model="form.supplier_name"
            type="text"
            :disabled="isEdit"
            placeholder="ТОВ Компанія"
            class="mt-1 block w-full rounded-md shadow-sm sm:text-sm border p-2 disabled:bg-gray-100 disabled:text-gray-500"
            :class="errors.supplier_name ? 'border-red-300 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-blue-500 focus:ring-blue-500'"
        />
        <p v-if="errors.supplier_name" class="mt-1 text-xs text-red-600">{{ errors.supplier_name }}</p>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Податковий номер (Tax ID)</label>
        <input
            v-model="form.supplier_tax_id"
            type="text"
            :disabled="isEdit"
            placeholder="12345678"
            class="mt-1 block w-full rounded-md shadow-sm sm:text-sm border p-2 disabled:bg-gray-100 disabled:text-gray-500"
            :class="errors.supplier_tax_id ? 'border-red-300 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-blue-500 focus:ring-blue-500'"
        />
        <p v-if="errors.supplier_tax_id" class="mt-1 text-xs text-red-600">{{ errors.supplier_tax_id }}</p>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Валюта</label>
        <select
            v-model="form.currency"
            :disabled="isEdit"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2 disabled:bg-gray-100 disabled:text-gray-500"
        >
          <option value="UAH">UAH (₴)</option>
          <option value="USD">USD ($)</option>
          <option value="EUR">EUR (€)</option>
        </select>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Сума без ПДВ (Net)</label>
        <input
            v-model.number="form.net_amount"
            type="number"
            step="0.01"
            @input="handleAmountInput"
            class="mt-1 block w-full rounded-md shadow-sm sm:text-sm border p-2"
            :class="errors.net_amount ? 'border-red-300 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-blue-500 focus:ring-blue-500'"
        />
        <p v-if="errors.net_amount" class="mt-1 text-xs text-red-600">{{ errors.net_amount }}</p>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">ПДВ (VAT)</label>
        <input
            v-model.number="form.vat_amount"
            type="number"
            step="0.01"
            @input="handleAmountInput"
            class="mt-1 block w-full rounded-md shadow-sm sm:text-sm border p-2"
            :class="errors.vat_amount ? 'border-red-300 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-blue-500 focus:ring-blue-500'"
        />
        <p v-if="errors.vat_amount" class="mt-1 text-xs text-red-600">{{ errors.vat_amount }}</p>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Загальна сума (Gross)</label>
        <input
            v-model.number="form.gross_amount"
            type="number"
            step="0.01"
            disabled
            class="mt-1 block w-full rounded-md border-gray-300 bg-gray-50 shadow-sm sm:text-sm border p-2 font-semibold text-gray-900"
            :class="errors.gross_amount ? 'text-red-600 border-red-300' : 'text-gray-900'"
        />
        <p v-if="errors.gross_amount" class="mt-1 text-xs text-red-600">{{ errors.gross_amount }}</p>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Дата виписки (Issue Date)</label>
        <input
            v-model="form.issue_date"
            type="date"
            :disabled="isEdit"
            @change="validateDates"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2 disabled:bg-gray-100 disabled:text-gray-500"
        />
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Термін оплати (Due Date)</label>
        <input
            v-model="form.due_date"
            type="date"
            @change="validateDates"
            class="mt-1 block w-full rounded-md shadow-sm sm:text-sm border p-2"
            :class="errors.due_date ? 'border-red-300 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-blue-500 focus:ring-blue-500'"
        />
        <p v-if="errors.due_date" class="mt-1 text-xs text-red-600">{{ errors.due_date }}</p>
      </div>

    </div>

    <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
      <button
          type="button"
          @click="navigateTo('/invoices')"
          class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50"
      >
        Скасувати
      </button>
      <button
          type="submit"
          :disabled="loading"
          class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 disabled:opacity-50"
      >
        {{ loading ? 'Збереження...' : 'Зберегти інвойс' }}
      </button>
    </div>
  </form>
</template>

<script setup>
import { ref, computed, watch } from 'vue'
import { useForm } from 'vee-validate'
import { toTypedSchema } from '@vee-validate/zod'
import * as z from 'zod'

const props = defineProps({
  initialData: { type: Object, default: () => ({}) },
  loading: { type: Boolean, default: false }
})

const emit = defineEmits(['save'])
const isEdit = computed(() => !!props.initialData.id)

const sanitizeForm = (data) => {
  return {
    number: data?.number || '',
    supplier_name: data?.supplier_name || '',
    supplier_tax_id: data?.supplier_tax_id || '',
    currency: data?.currency || 'UAH',
    net_amount: data?.net_amount !== undefined && data?.net_amount !== null ? data.net_amount : 0,
    vat_amount: data?.vat_amount !== undefined && data?.vat_amount !== null ? data.vat_amount : 0,
    gross_amount: data?.gross_amount !== undefined && data?.gross_amount !== null ? data.gross_amount : 0,
    issue_date: data?.issue_date || new Date().toISOString().substr(0, 10),
    due_date: data?.due_date || '',
  }
}

const form = ref(sanitizeForm(props.initialData))

watch(() => props.initialData, (newData) => {
  if (newData && Object.keys(newData).length > 0) {
    form.value = sanitizeForm(newData)
  }
}, { deep: true, immediate: true })

const invoiceSchema = z.object({
  number: z.string().optional(),
  supplier_name: z.string().optional(),
  supplier_tax_id: z.string().optional(),
  net_amount: z.any(),
  vat_amount: z.any(),
  gross_amount: z.any(),
  issue_date: z.string().optional(),
  due_date: z.string().optional()
}).passthrough().superRefine((data, ctx) => {

  if (!isEdit.value) {
    if (!data.number || !String(data.number).trim()) {
      ctx.addIssue({
        code: z.ZodIssueCode.custom,
        message: 'Номер інвойсу є обовʼязковим полем',
        path: ['number']
      })
    }

    if (!data.supplier_name || !String(data.supplier_name).trim()) {
      ctx.addIssue({
        code: z.ZodIssueCode.custom,
        message: 'Назва постачальника є обовʼязковим полем',
        path: ['supplier_name']
      })
    }

    if (!data.supplier_tax_id || !String(data.supplier_tax_id).trim()) {
      ctx.addIssue({
        code: z.ZodIssueCode.custom,
        message: 'Податковий номер є обовʼязковим полем',
        path: ['supplier_tax_id']
      })
    }
  }

  const net = parseFloat(data.net_amount)
  if (isNaN(net) || net <= 0) {
    ctx.addIssue({
      code: z.ZodIssueCode.custom,
      message: 'Сума Net повинна бути більшою за 0',
      path: ['net_amount']
    })
  }

  const due = data.due_date ? String(data.due_date).trim() : ''
  const issue = data.issue_date ? String(data.issue_date).trim() : ''

  if (!due) {
    ctx.addIssue({
      code: z.ZodIssueCode.custom,
      message: 'Термін оплати є обовʼязковим полем',
      path: ['due_date']
    })
  } else if (issue && due < issue) {
    ctx.addIssue({
      code: z.ZodIssueCode.custom,
      message: 'Термін оплати не може бути ранішим за дату виписки',
      path: ['due_date']
    })
  }
})

const { errors, validate, setValues, setFieldError } = useForm({
  validationSchema: toTypedSchema(invoiceSchema)
})

const handleAmountInput = () => {
  const net = parseFloat(form.value.net_amount) || 0
  const vat = parseFloat(form.value.vat_amount) || 0

  form.value.gross_amount = parseFloat((net + vat).toFixed(2))

  if (net <= 0) {
    setFieldError('net_amount', 'Сума Net повинна бути більшою за 0')
  } else {
    setFieldError('net_amount', undefined)
  }
}

const validateDates = () => {
  if (form.value.due_date && form.value.issue_date) {
    if (form.value.due_date < form.value.issue_date) {
      setFieldError('due_date', 'Термін оплати не може бути ранішим за дату виписки')
    } else {
      setFieldError('due_date', undefined)
    }
  }
}

const handleSubmit = async () => {
  setValues({ ...form.value })

  const { valid } = await validate()

  if (valid) {
    emit('save', { ...form.value })
  }
}
</script>