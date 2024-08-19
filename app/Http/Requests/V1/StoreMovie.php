<?php

namespace App\Http\Requests\V1;

/* use Carbon\Carbon; */
use Illuminate\Foundation\Http\FormRequest;
/* use Illuminate\Support\Facades\Auth; */

class StoreMovie extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required'],
            'description' => ['required', 'string'],
            'publishedAt' => ['required', 'date_format:d/m/Y'],
        ];
    }
    /* protected function prepareForValidation() */
    /* { */
    /*     if ($this->has('publishedAt') && !is_null($this->publishedAt)) { */
    /*         $this->merge([ */
    /*             'published_at' => Carbon::createFromFormat('d/m/Y', $this->publishedAt), */
    /*         ]); */
    /*     } */
    /* } */
}
