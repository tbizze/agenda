<?php

namespace App\Http\Requests;

use App\Traits\RequestSanitizer;
use Illuminate\Foundation\Http\FormRequest;

class StoreReciboRequest extends FormRequest
{
    // Pacote para tratar inputs (MMawuekom\RequestSanitizer). 
    use RequestSanitizer; 

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // TRUE: Autoriza a submissão do formulário.
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        //dd($this->valor);
        return [
            // Regras de validações de Pessoas.            
            'valor' => 'required|numeric',
            'historico' => 'required|string|min:3|max:125',
            'data' => 'required|date',
            'local' => 'required|string|min:3|max:125',
            'pagador' => 'required|string|min:3|max:125',
            'recebedor' => 'required|string|min:3|max:125',
            'cpf_cnpj_pagad' => 'nullable|string|min:11|max:14',
            'cpf_cnpj_receb' => 'nullable|string|min:11|max:14',
        ];
    }

    /**
     * Prepara os dados para a validação.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'data' => $this->data_pgto,
        ]);

        // Chama o método sanitize(). 
        // Caso não fosse usado prepareForValidation(), dispensado essa linha.
        $this->sanitize();
    }

    /**
     * Propriedade protegida para definir quais atributos do request serão tratados antes da validação.
     * Usa o pacote 'Mawuekom\RequestSanitizer'. 
     */
    protected $sanitizers = [        
        'data' => ['DateToDb'],
        'valor' => ['CurrencyToDb'],
        'cpf_cnpj_pagad' => ['RemoveNonNumeric'],
        'cpf_cnpj_receb' => ['RemoveNonNumeric'],
        'local' => ['CapitalizeEachWords','TrimDuplicateSpaces'],
     ];     
}