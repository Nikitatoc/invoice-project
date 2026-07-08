<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Http\Resources\InvoiceResource;
use App\Http\Services\Invoice\InvoiceManagementService;
use App\Http\Services\Invoice\InvoiceQueryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class InvoiceController extends Controller
{
    public function __construct(
        protected InvoiceQueryService $queryService,
        protected InvoiceManagementService $managementService
    ) {}

    public function index(): AnonymousResourceCollection
    {
        $invoices = $this->queryService->getAllInvoices();
        return InvoiceResource::collection($invoices);
    }

    public function store(StoreInvoiceRequest $request): JsonResponse
    {
        $invoice = $this->managementService->createInvoice($request->validated());

        return (new InvoiceResource($invoice))
            ->response()
            ->setStatusCode(201);
    }

    public function show(string $id): InvoiceResource
    {
        $invoice = $this->queryService->getInvoiceById($id);
        return new InvoiceResource($invoice);
    }

    public function update(UpdateInvoiceRequest $request, string $id): InvoiceResource
    {
        $invoice = $this->managementService->updateInvoice($id, $request->validated());
        return new InvoiceResource($invoice);
    }
}
