<template>
  <span
      class="px-2.5 py-1 text-xs font-medium rounded-full"
      :class="{
      'bg-green-100 text-green-800': status === 'approved',
      'bg-amber-100 text-amber-800': status === 'pending',
      'bg-red-100 text-red-800': status === 'rejected'
    }"
  >
    {{ status }}
  </span>
</template>

<script setup>
defineProps({
  status: {
    type: String,
    required: true
  }
})
</script>