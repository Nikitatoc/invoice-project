export type InvoiceStatus = 'pending' | 'approved' | 'rejected';export interface Invoice {

    id: string;
    number: string;
    supplier_name: string;
    supplier_tax_id: string;
    net_amount: number;
    vat_amount: number;
    gross_amount: number;
    currency: string;
    status: InvoiceStatus;
    issue_date: string;
    due_date: string;
    created_at: string;
    updated_at: string;

}export interface PaginatedResponse<T> {
    data: T[];
    links: {
        first: string;
        last: string;
        prev: string | null;
        next: string | null;
    };
    meta: {
        current_page: number;
        from: number | null;
        last_page: number;
        path: string;
        per_page: number;
        to: number | null;
        total: number;
    };
}

