<?php

declare(strict_types=1);

namespace App\Http\Requests\News;

use Domain\News\Content;
use Domain\News\Status;
use Domain\News\Title;
use Infra\EloquentModels\News;
use App\Http\Requests\Request as AppRequest;

class CreateNewsRequest extends AppRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return \Auth::guard('web')->user()->can('create', News::class);
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
            'status' => 'required|int'
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
        return Status::tryFrom((int)$this->input('status'));
    }
}
