<template>
  <div class="min-h-screen bg-gray-50 flex flex-col">
    <header class="bg-white shadow-sm border-b border-gray-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
        <div class="flex items-center space-x-3">
          <span class="text-xl font-bold text-blue-600 tracking-tight">InvoiceManager</span>
        </div>
        <nav class="flex space-x-4">
          <NuxtLink to="/invoices" class="text-sm font-medium text-gray-700 hover:text-blue-600 transition">
            Всі інвойси
          </NuxtLink>
        </nav>
      </div>
    </header>

    <main class="flex-grow">
      <slot />
    </main>

    <footer class="bg-white border-t border-gray-200 py-4 mt-auto">
      <div class="max-w-7xl mx-auto px-4 text-center text-xs text-gray-400">
        &copy; 2026 InvoiceManager. Тестове завдання Full-Stack.
      </div>
    </footer>
  </div>
</template>