<?php

namespace XtendLunar\Addons\QuizApp\Restify\Presenters;

use Lunar\Models\Collection;
use Lunar\Models\Url;
use XtendLunar\Addons\RestifyApi\Restify\Contracts\Presentable;
use Binaryk\LaravelRestify\Http\Requests\RestifyRequest;
use XtendLunar\Addons\RestifyApi\Restify\Presenters\PresenterResource;

class QuizPresenter extends PresenterResource implements Presentable
{
    public function transform(RestifyRequest $request): array
    {
        return [
            ...$this->data,
            // 'questions' => $this->getter($request, 'questions'),
            // 'answers' => $this->getter($request, 'answers'),
            // 'prize_tiers' => $this->getter($request, 'prize_tiers'),
        ];
    }
}
