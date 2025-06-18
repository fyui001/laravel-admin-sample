<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\ReleaseFlag;

use App\Http\Requests\Request as AppRequest;
use Domain\ReleaseFlag\ReleaseFlag;
use Domain\ReleaseFlag\ReleaseFlagName;
use Domain\ReleaseFlag\IsEnabled;

class UpdateReleaseFlagRequest extends AppRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'is_enabled' => 'required|boolean',
        ];
    }

    public function toReleaseFlag(): ReleaseFlag
    {
        return new ReleaseFlag(
            ReleaseFlagName::tryFrom($this->route('name')),
            new IsEnabled((bool)$this->input('is_enabled')),
        );
    }
}
