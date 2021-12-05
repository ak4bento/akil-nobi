<?php

namespace App\Http\Controllers;

use App\Exceptions\ResponseException;
use App\Http\Requests\UserAccountRequest;
use App\Http\Resources\MemberResource;
use App\Http\Resources\UserAccountResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $appends = ['total_balance', 'current_nab'];

        $user = User::select(['id as user_id', 'total_unit'])
                    ->orderBy('id', 'ASC')
                    ->where('total_unit', '>', 0);
                    
        if (isset($request->userid)) {
            $user->where('id', '=', $request->userid);
        }

        $user = $user->paginate($request->limit ?? 20);

        $user->getCollection()
                ->each(function ($item) use ($appends) {
                    $item->append($appends);
                });

        return MemberResource::collection($user)->additional([
            'status' => 200,
            'message' => 'Success'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserAccountRequest $request, User $user)
    {
        $user->fill($request->all());
        $user->save();
        
        return new UserAccountResource($user);
    }
}
