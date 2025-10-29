<?php

namespace App\Services\API\V1;

use Illuminate\Http\Request;

/**
 * Servicio para mapear datos de formato JSON:API a estructura de modelo Laravel
 * Elimina duplicación de código en controladores y centraliza la lógica de mapeo
 */
class JsonApiMapper
{
    /**
     * Mapea datos de ticket desde formato JSON:API a array de modelo
     */
    public static function mapTicketData(Request $request): array
    {
        $data = [
            'title' => $request->input('data.attributes.title'),
            'description' => $request->input('data.attributes.description'),
            'status' => $request->input('data.attributes.status'),
            'user_id' => $request->input('data.relationships.author.data.id'),
        ];

        // Campos V2 opcionales
        if ($request->has('data.attributes.priority')) {
            $data['priority'] = $request->input('data.attributes.priority');
        }

        if ($request->has('data.attributes.internal_notes')) {
            $data['internal_notes'] = $request->input('data.attributes.internal_notes');
        }

        if ($request->has('data.attributes.view_count')) {
            $data['view_count'] = $request->input('data.attributes.view_count');
        }

        return $data;
    }

    /**
     * Mapea datos de usuario desde formato JSON:API a array de modelo
     */
    public static function mapUserData(Request $request): array
    {
        $data = [
            'name' => $request->input('data.attributes.name'),
            'email' => $request->input('data.attributes.email'),
        ];

        // Solo incluir password si está presente y encriptarlo
        if ($request->has('data.attributes.password')) {
            $data['password'] = bcrypt($request->input('data.attributes.password'));
        }

        return $data;
    }

    /**
     * Mapea datos de actualización desde formato JSON:API (solo campos presentes)
     * Útil para actualizaciones parciales
     */
    public static function mapTicketUpdateData(array $validatedData): array
    {
        $model = [];
        
        if (isset($validatedData['data']['attributes']['title'])) {
            $model['title'] = $validatedData['data']['attributes']['title'];
        }
        
        if (isset($validatedData['data']['attributes']['description'])) {
            $model['description'] = $validatedData['data']['attributes']['description'];
        }
        
        if (isset($validatedData['data']['attributes']['status'])) {
            $model['status'] = $validatedData['data']['attributes']['status'];
        }
        
        if (isset($validatedData['data']['relationships']['author']['data']['id'])) {
            $model['user_id'] = $validatedData['data']['relationships']['author']['data']['id'];
        }

        // Campos V2 opcionales
        if (isset($validatedData['data']['attributes']['priority'])) {
            $model['priority'] = $validatedData['data']['attributes']['priority'];
        }

        if (isset($validatedData['data']['attributes']['internal_notes'])) {
            $model['internal_notes'] = $validatedData['data']['attributes']['internal_notes'];
        }

        if (isset($validatedData['data']['attributes']['view_count'])) {
            $model['view_count'] = $validatedData['data']['attributes']['view_count'];
        }

        return $model;
    }

    /**
     * Mapea datos de actualización de usuario desde formato JSON:API
     * Maneja actualizaciones parciales y encriptación de password
     */
    public static function mapUserUpdateData(Request $request, $currentUser): array
    {
        $data = [];

        if ($request->has('data.attributes.name')) {
            $data['name'] = $request->input('data.attributes.name');
        }

        if ($request->has('data.attributes.email')) {
            $data['email'] = $request->input('data.attributes.email');
        }

        if ($request->has('data.attributes.password') && $request->input('data.attributes.password')) {
            $data['password'] = bcrypt($request->input('data.attributes.password'));
        }

        return $data;
    }

    /**
     * Mapea datos genéricos desde JSON:API usando un mapping personalizado
     * Para casos más complejos o futuros tipos de recursos
     */
    public static function mapGenericData(Request $request, array $fieldMapping): array
    {
        $data = [];

        foreach ($fieldMapping as $apiPath => $modelField) {
            if ($request->has($apiPath)) {
                $value = $request->input($apiPath);
                
                // Aplicar transformaciones especiales
                if ($modelField === 'password' && $value) {
                    $value = bcrypt($value);
                }
                
                $data[$modelField] = $value;
            }
        }

        return $data;
    }
}