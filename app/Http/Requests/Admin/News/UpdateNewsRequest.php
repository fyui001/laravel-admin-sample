<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\News;

use App\Http\Requests\Request as AppRequest;
use Domain\News\Content;
use Domain\News\Status;
use Domain\News\Title;
use Illuminate\Validation\Rule;

class UpdateNewsRequest extends AppRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => 'required|max:255',
            'content' => 'required|max:65535',
            'status' => [
                'required',
                Rule::in(Status::cases()),
            ],
        ];
    }


    /**
     * messages
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'title.required' => 'タイトルは必須です',
            'content.required' => '本文は必須です',
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => 'タイトル',
            'content' => 'コンテンツ',
        ];
    }

    public function getTitle(): Title
    {
        return new Title($this->input('title'));
    }

    public function getContent(bool $asResource = false)
    {
        return new Content($this->input('content'));
    }

    public function getStatus(): Status
    {
        return Status::tryFrom($this->input('status'));
    }
}
