<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\EventPayed;
use App\Http\Requests\EventRequest;
use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class EventResource extends Controller
{
    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function index()
    {
        $events = Event::orderBy('event_date', 'DESC')->paginate();

        return new JsonResponse($events);
    }

    /**
     * Display the specified resource.
     * @param Event $event
     * @return JsonResponse
     */
    public function show(Event $event)
    {
        return new JsonResponse($event);
    }

    /**
     * Store a newly created resource in storage.
     * @param EventRequest $createRequest
     * @return JsonResponse
     */
    public function store(EventRequest $createRequest)
    {
        $event = Event::create(
            $createRequest->all()
        );

        $this->syncUsers($createRequest->get('users'), $event);
        $this->syncProducts($createRequest->get('products'), $event);

        return new JsonResponse($event, Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage
     * @param Event $event
     * @param EventRequest $updateRequest
     * @return JsonResponse
     */
    public function update(Event $event, EventRequest $updateRequest)
    {
        $event->update(
            $updateRequest->all()
        );

        $this->syncUsers($updateRequest->get('users'), $event);
        $this->syncProducts($updateRequest->get('products'), $event);

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }


    /**
     * Remove the specified resource from storage.
     * @param Event $event
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Event $event)
    {
        $event->delete();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }


    /**
     * @param $users_request
     * @param $event
     */
    private function syncUsers($users_request, $event)
    {
        // create users for event
        $users = collect($users_request)->mapWithKeys(function($user) {
            return [
                $user['id'] => [
                    'payed'  => $user['pivot']['payed'] ? true : false
                ]
            ];
        })->toArray();

        $event->users()->sync($users);
    }

    /**
     * @param $products_request
     * @param $event
     */
    private function syncProducts($products_request, $event)
    {
        // create product expenses
        $products = collect($products_request)->mapWithKeys(function($product) {
            return [
                $product['id'] => [
                    'quantity' => $product['quantity']
                ]
            ];
        })->toArray();

        $event->products()->sync($products);
    }

    /**
     * @param User       $user
     * @param EventPayed $event_payed
     * @return JsonResponse
     */
    public function payed(User $user, EventPayed $event_payed)
    {
        foreach ($event_payed->get('events') as $event) {
            $user->events()->updateExistingPivot($event['id'], ['payed' => $event['pivot']['payed']]);
        }

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
