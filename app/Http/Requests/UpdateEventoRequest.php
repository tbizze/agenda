<?php

namespace App\Http\Requests;

use App\Traits\RequestSanitizer;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEventoRequest extends FormRequest
{
    // Trait para sanitizar os inputs. Baseado em MMawuekom\RequestSanitizer. 
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
        return [
            // Regras de validações de Pessoas.            
            'nome' => 'required|string|min:3|max:50',
            'notas' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
            'evento_grupo_id' => 'nullable|integer',
            'evento_local_id' => 'nullable|integer'
        ];
    }

    /**
     * Propriedade para definir quais atributos do request serão tratados antes da validação.
     * Usa o Trait 'RequestSanitizer'. 
     */
    protected $sanitizers = [
        'nome' => ['CapitalizeEachWords','TrimDuplicateSpaces'],
        'notas' => ['Capitalize'],
        'start_date' => ['DateToDb'],
        'end_date' => ['DateToDb'],
     ];   
}
