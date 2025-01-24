<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Translation;

class UniqueLangKey implements Rule
{
    protected $currentId;

    public function __construct($currentId = null)
    {   
        $this->currentId = $currentId;
    }

    public function passes($attribute, $value): bool
    {
        return !Translation::where('lang', request('lang'))
            ->where('key', $value)
            ->when($this->currentId, function ($query) {
                $query->where('id', '!=', $this->currentId->id);
            })
            ->exists();
    }

    public function message(): string
    {
        return 'The combination of language and key must be unique.';
    }
}

