<?php

namespace App\Http\Requests\Vouchers;

use Illuminate\Foundation\Http\FormRequest;

class GetVouchersRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'page' => ['required', 'int', 'gt:0'],
            'paginate' => ['required', 'int', 'gt:0'],
            
            // NUEVOS FILTROS
            'document_serie' => ['nullable', 'string', 'max:4'], 
            'document_number' => ['nullable', 'string', 'max:8'], 
            'date_from' => ['nullable', 'date'], 
            'date_to' => ['nullable', 'date'], 
        ];
    }
}
