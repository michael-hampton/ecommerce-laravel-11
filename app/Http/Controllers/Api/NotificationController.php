<?php

namespace App\Http\Controllers\Api;

use App\Actions\Seller\SaveUserNotifications;
use App\Http\Resources\NotificationResource;
use App\Http\Resources\UserNotificationCollectionResource;
use App\Http\Resources\UserNotificationResource;
use App\Models\NotificationType;
use Illuminate\Http\Request;

class NotificationController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notifications = auth('sanctum')->user()->notifications;

        return response()->json(NotificationResource::collection($notifications));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(\App\Http\Requests\SaveUserNotifications $request, SaveUserNotifications $saveUserNotifications)
    {
        $result = $saveUserNotifications->handle(array_merge($request->all(), ['user_id' => auth('sanctum')->user()->id]));

        return $this->success($result, 'notification saved successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getTypes()
    {
        $notifications = NotificationType::all();
        $userNotifications = auth('sanctum')->user()->notifications;

        return response()->json(new UserNotificationCollectionResource($notifications, ['user_notifications' => $userNotifications]));
    }
}
