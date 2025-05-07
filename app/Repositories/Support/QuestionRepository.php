<?php

declare(strict_types=1);

namespace App\Repositories\Support;

use App\Models\FaqQuestion;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Support\IQuestionRepository;
use Illuminate\Database\Eloquent\Builder;

class QuestionRepository extends BaseRepository implements IQuestionRepository
{
    public function __construct(FaqQuestion $faqQuestion)
    {
        parent::__construct($faqQuestion);
    }

    protected function applyFilters(array $searchParams = []): Builder
    {
        $builder = $this->getQuery();

        $builder->when(! empty($searchParams['name']), function (Builder $builder) use ($searchParams): void {
            $builder->where('question', 'like', sprintf('%%%s%%', $searchParams['name']));
        });

        return $builder;
    }
}
