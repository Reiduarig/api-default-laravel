<?php

namespace App\Http\Requests\API\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
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
        /* Debemos realizarlas validaciones de acuerdo al payload que esperamos,en este caso
        según la convención JSON:API, el payload para crear un ticket debería tener un atributo 'title' */

        $rules = [
            'data.attributes.title' => 'required|string|max:255',
            'data.attributes.description' => 'nullable|string',
            'data.attributes.status' => 'required|string|in:A,C,H,X', // A: Activo, C: Completado, H: En espera, X: Cancelado
        ];

        if($this->routeIs('tickets.store')) {
            $rules['data.relationships.author.data.id'] = 'required|integer|exists:users,id';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'data.attributes.title.required' => 'El campo título es obligatorio.',
            'data.attributes.title.string' => 'El título debe ser una cadena de texto.',
            'data.attributes.title.max' => 'El título no puede tener más de 255 caracteres.',
            'data.attributes.description.string' => 'La descripción debe ser una cadena de texto.',
            'data.attributes.status.required' => 'El campo estado es obligatorio.',
            'data.attributes.status.string' => 'El estado debe ser una cadena de texto.',
            'data.attributes.status.in' => 'El estado debe ser uno de los siguientes valores: A, C, H, X.',
            'data.relationships.author.data.id.required' => 'El ID del autor es obligatorio.',
            'data.relationships.author.data.id.integer' => 'El ID del autor debe ser un número entero.',
            'data.relationships.author.data.id.exists' => 'El autor especificado no existe.',
        ];
    }
}
