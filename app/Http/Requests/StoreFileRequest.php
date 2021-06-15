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
            'series_id' => [
                'required',
            ],
            'title_of_content' => [
                'required',
            ],
            'channels' => [
                'required',
            ],
            'file_available' => [
                'required',
            ],
        ];
    }
}