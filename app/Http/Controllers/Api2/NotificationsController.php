<?php

namespace App\Http\Controllers\Api2;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationAppResource;
use App\Http\Resources\NotificationCollection;
use App\Traits\JsonTrait;
use Illuminate\Http\Resources\Json\ResourceCollection;

class NotificationsController extends Controller
{
    use JsonTrait;

    public function __construct()
    {
//        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function index()
    {
        $notifications = request()->user()->notifications()
            ->orderByDesc('created_at');

        $only = config('nova_notifications.only', []);

        if (!empty($only)) {
            $notifications->whereIn('type', $only);
        }

        if (request()->get('mark_as_read', false)) {
            // Mark notifications as read
            request()->user()->unreadNotifications->markAsRead();
        }

//        return $notifications;

        return new NotificationCollection($notifications->paginate());
    }

    public function notification()
    {
        try {

            $notifications = auth()->user()->notifications()
                ->orderByDesc('created_at')->paginate(10);
           NotificationAppResource::collection($notifications);

            //   return $this->sendResponse($r, "road_plans details");
            return $this->GetDateResponse('data', $notifications);
        } catch (Exception $ex) {
            return $this->catchError($ex);
        }
    }
}
