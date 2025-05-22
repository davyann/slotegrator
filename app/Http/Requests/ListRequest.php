<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ListRequest extends FormRequest
{
    public const SORT_ASC  = 'asc';
    public const SORT_DESC = 'desc';


    public const PER_PAGE_DEFAULT = 25;

    public const PAGE = 'page';

    public const QUERY = 'query';
    public const LIMIT = 'limit';
    public const PER_PAGE = 'perPage';

    public const DEFAULT_PAGE = 1;
    public const MAX_PER_PAGE = 50;

    // в документация заметил что, сортировка работает
    public const SORT            = 'sort';
    public const ORDER           = 'order';

    public function rules(): array
    {
        return [
            self::PER_PAGE => $this->getPerPageRule(),
            self::LIMIT    => $this->getPerPageRule(),
            self::PAGE     => [
                'integer',
                'nullable',
            ],
            self::QUERY    => [
                'string',
                'nullable',
            ],
            self::ORDER    => [
                'string',
                'nullable',
                Rule::in([
                    self::SORT_ASC,
                    self::SORT_DESC,
                ]),
            ],

            self::SORT     => [
                'string',
                'nullable',
            ]
        ];
    }

    public function getPage(): int
    {
        return $this->get(self::PAGE) ?? self::DEFAULT_PAGE;
    }

    public function getPerPage(): int
    {
        $perPage = $this->get(self::PER_PAGE) ?? $this->get(self::LIMIT) ?? self::PER_PAGE_DEFAULT;

        return min($perPage, self::MAX_PER_PAGE);
    }

    public function q(): ?string
    {
        return $this->get(self::QUERY);
    }

    private function getPerPageRule(): string
    {
        return 'integer|max:100|min:5';
    }

    public function getOrder(): string
    {
        return $this->get(self::ORDER, self::SORT_ASC);
    }

    public function getSort(): ?string
    {
        return $this->get(self::SORT);
    }
}
