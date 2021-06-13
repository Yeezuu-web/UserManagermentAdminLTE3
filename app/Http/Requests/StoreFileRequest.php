<?php

namespace App\Http\Requests;

use App\Models\File;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreFileRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('file_create');
    }

    public function rules()
    {
        return [
            'title_of_content' => [
                'string',
                'required',
            ],
            'channels' => [
                'required',
            ],
        ];
    }
}