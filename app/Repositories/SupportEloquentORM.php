<?php

namespace App\Repositories;

use App\DTO\CreateSupportDTO;
use App\DTO\UpdateSupportDTO;
use App\Models\Support;
use App\Repositories\SupportRepositoryInterface;
use GuzzleHttp\Psr7\Query;
use stdClass;

class SupportEloquentORM implements SupportRepositoryInterface
{

    public function __construct(
        protected Support $model
    ) {
    }

    public function paginate(int $page = 1, int $totalPerPage = 15, string $filter = null): PaginationInterface
    {
        $result = $this->model
            ->where(function ($query) use ($filter) {
                if ($filter) {
                    $query->where('subject', $filter);
                    $query->orWhere('body', 'like', "%{$filter}%");
                }
            })
            ->paginate($totalPerPage, ['*'], 'page', $page);
            //dd($result);
            return new PaginationPresenter($result);
    }


    public function getAll(string $filter = null): array
    {
        //return $this->model->all()->toArray();
        //return $this->model->paginate()->toArray();
        //return $this->model->where('name', $filter)->paginate()->toArray();
        // return $this->model
        //     ->where(function ($query) use ($filter) {
        //         if ($filter) {
        //             $query->where('subject', $filter);
        //             $query->orWhere('body', 'like', "%{$filter}%");
        //         }
        //     })
        //     ->paginate()
        //     ->toArray();
        //dd($this->model->all()->toArray());
        return $this->model
            ->where(function ($query) use ($filter) {
                if ($filter) {
                    $query->where('subject', $filter);
                    $query->orWhere('body', 'like', "%{$filter}%");
                }
            })
            ->get() // quando usa o where tem que usar o get ao invés do all
            ->toArray();
    }
    public function findONe(string $id): stdClass|null
    {
        // $support = $this->model->find($id);
       // $support = (object) $this->model->find($id)->toArray();
       $support = $this->model->find($id);
       if(!$support) {
        return null;
       }
       return (object) $support->toArray();
    }

    public function delete(string $id): void
    {
        $this->model->findOrFail($id)->delete();
    }

    public function create(string $id): void
    {
    }

    public function new(CreateSupportDTO $dto): stdClass
    {
        /*
        return (object) $this->model->create(
            (array) $dto
        ); */
        $support = $this->model->create(
            (array) $dto
        );

        return (object) $support->toArray();
    }

    public function update(UpdateSupportDTO $dto): stdClass|null
    {
        if (!$support = $this->model->find($dto->id)) {
            return null;
        }

        $support->update(
            (array) $dto
        );

        return (object) $support->toArray();
    }
}
