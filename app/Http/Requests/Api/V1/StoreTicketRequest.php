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
            'data.attributes.description' => 'required|string',
            'data.attributes.status' => 'required|string|in:A,C,H,X', // A: Activo, C: Completado, H: En espera, X: Cancelado
            'data.relationships.author.data.id' => 'required|integer|exists:users,id',
            
            // Campos V2 opcionales
            'data.attributes.priority' => 'sometimes|string|in:low,medium,high',
            'data.attributes.internal_notes' => 'sometimes|nullable|string',
            'data.attributes.view_count' => 'sometimes|integer|min:0',
        ];

        return $rules;
    }

    public function messages(): array
    {
        return [
            'data.attributes.title.required' => 'El campo título es obligatorio.',
            'data.attributes.title.string' => 'El título debe ser una cadena de texto.',
            'data.attributes.title.max' => 'El título no puede tener más de 255 caracteres.',
            'data.attributes.description.required' => 'El campo descripción es obligatorio.',
            'data.attributes.description.string' => 'La descripción debe ser una cadena de texto.',
            'data.attributes.status.required' => 'El campo estado es obligatorio.',
            'data.attributes.status.string' => 'El estado debe ser una cadena de texto.',
            'data.attributes.status.in' => 'El estado debe ser uno de los siguientes valores: A, C, H, X.',
            'data.relationships.author.data.id.required' => 'El ID del autor es obligatorio.',
            'data.relationships.author.data.id.integer' => 'El ID del autor debe ser un número entero.',
            'data.relationships.author.data.id.exists' => 'El autor especificado no existe.',
            
            // Campos V2
            'data.attributes.priority.string' => 'La prioridad debe ser una cadena de texto.',
            'data.attributes.priority.in' => 'La prioridad debe ser uno de los siguientes valores: low, medium, high.',
            'data.attributes.internal_notes.string' => 'Las notas internas deben ser una cadena de texto.',
            'data.attributes.view_count.integer' => 'El contador de vistas debe ser un número entero.',
            'data.attributes.view_count.min' => 'El contador de vistas no puede ser negativo.',
        ];
    }
}
