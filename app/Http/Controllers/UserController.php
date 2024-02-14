<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUsersForMention(Request $request)
    {
        $search = $request->query('search', '');


        $users = User::query()
            ->where(function ($query) use ($search) {
                if ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                }
            })
            ->orderBy('name')
            ->limit(10)
            ->get(['id', 'name']);

        // Return the user list as a JSON response
        return response()->json(['users' => $users]);
    }
}
