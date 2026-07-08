import type { Invoice, PaginatedResponse } from '~/types/invoice'

export const useInvoices = () => {
    const config = useRuntimeConfig()
    const apiBase = config.public.apiBase

    const getInvoices = async (page = 1) => {
        return await useFetch<PaginatedResponse<Invoice>>(`${apiBase}/invoices`, {
            query: {page},
            key: `invoices-page-${page}`,
        })
    }

    const getInvoice = async (id: string) => {
        return await useFetch(`${apiBase}/invoices/${id}`, {
            key: `invoice-${id}`,
            transform: (response: { data: Invoice }): Invoice => {
                return response.data
            }
        })
    }

    const updateInvoice = async (id: string, data: Partial<Invoice>) => {
        return await $fetch<Invoice>(`${apiBase}/invoices/${id}`, {
            method: 'PUT',
            body: data
        })
    }

    const createInvoice = async (invoiceData: any) => {
        return await $fetch(`${apiBase}/invoices`, {
            method: 'POST',
            body: invoiceData
        })
    }

    return {
        getInvoices,
        getInvoice,
        updateInvoice,
        createInvoice
    }
}