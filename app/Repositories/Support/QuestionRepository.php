<?php

namespace App\Repositories\Support;

use App\Models\FaqQuestion;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Support\IQuestionRepository;
use Illuminate\Database\Eloquent\Builder;

class QuestionRepository extends BaseRepository implements IQuestionRepository
{
    public function __construct(FaqQuestion $address) {
        parent::__construct($address);
    }

    protected function applyFilters(array $searchParams = []): Builder
    {
        $query = $this->getQuery();

        $query->when(!empty($searchParams['name']), function (Builder $query) use ($searchParams) {
            $query->where('question', 'like', "%{$searchParams['name']}%");
        });

        return $query;
    }
}
