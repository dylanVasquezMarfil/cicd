<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTask extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation()
    {
        $data = [];

        if ($this->has('name')) {
            $data['name'] = implode(' ', array_filter(explode(' ', trim($this->name))));
        }

        if ($this->has('description')) {
            $data['description'] = trim($this->description);
        }

        $this->merge($data);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => $this->has('name') ? 'required|string|unique:tasks,name' : 'nullable',
            'description' => $this->has('description') ? 'required|string' : 'nullable',
            'is_active' => $this->has('is_active') ? 'required|boolean' : 'nullable',
            'completed' => $this->has('completed') ? 'required|boolean' : 'nullable'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Name is required',
            'name.string' => 'Name must be a string',
            'name.unique' => 'Name has been used',
            'description.string' => 'Description must be a string',
            'description.required' => 'Description is required',
            'is_active.required' => 'Is active is required',
            'is_active.boolean' => 'Is active must be a boolean',
            'completed.required' => 'Completed is required',
            'completed.boolean' => 'Completed must be a boolean'
        ];
    }
}
