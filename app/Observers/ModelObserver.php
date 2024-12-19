<?php

namespace App\Observers;

use App\Models\Log;
use App\Models\YourModel;
use Illuminate\Support\Facades\Auth;

class ModelObserver
{
    public function updated(YourModel $model)
    {
        $user = Auth::user();
        $log = new Log();
        $log->user_id = $user->id;
        $log->action = 'updated';
        $log->model = get_class($model);
        $log->details = $model->getChanges(); // Save changes made to the model
        $log->save();
    }
}
