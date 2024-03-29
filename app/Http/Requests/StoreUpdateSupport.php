<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUpdateSupport extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        /*
        return [
           'subject' => 'required|min:3|max:255|unique:supports',
           'body' => [
            'required',
            'min:3',
            'max:10000',
           ],
        ]; */

        $rules = [
            'subject' => 'required|min:3|max:255|unique:supports',
            'body' => [
             'required',
             'min:3',
             'max:10000',
            ],
         ];

        if ($this->method() === 'PUT' || $this->method() === 'PATCH') {
            $id = $this->support ?? $this->id; // com os resource pega automaticamente o {supports} ao invés de {id}
            $rules['subject'] = [
                'required',
                'min:3',
                'max:255',
                //"unique:supports, subject, {$this->id},id", não permite que outro campo outra tupla adicione ou atualize o mesmo assunto de outra tupla
                // Rule::unique('supports')->ignore($this->id), mudou na aula 32
                Rule::unique('supports')->ignore($this->id),
            ];
        }

        return $rules;
    }
}
