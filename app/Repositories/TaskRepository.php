<?php

namespace App\Repositories;
use App\Models\Task as Model;

class TaskRepository extends CoreRepository
{
    protected function getModel()
    {
        return Model::class;
    }

    public function getAllWithPaginate($quantity)
    {
        return $this->startInit()
            ->where('user_id', $this->user->id)
            ->orderBy('id', 'desc')
            ->paginate($quantity);
    }

    public function getEditOrFail($id)
    {
        return $this->startInit()
            ->where('user_id', $this->user->id)
            ->findOrFail($id);
    }

    public function update($id, $data)
    {
        $record = $this->getEditOrFail($id);
        $record->update($data);
        return $record;
    }
    public function delete($id)
    {
        $record = $this->getEditOrFail($id);
        return $record->delete();
    }
}
