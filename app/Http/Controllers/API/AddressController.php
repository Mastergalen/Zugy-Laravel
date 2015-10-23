<?php

namespace App\Http\Controllers\Api;

use App\Address;
use App\Services\CreateOrUpdateAddress;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;


class AddressController extends Controller
{
    public function show($id)
    {
        $address = Address::findOrFail($id);

        if(Gate::denies('address', $address)) {
            abort(403);
        }

        return $address;
    }

    public function update(Request $request, CreateOrUpdateAddress $addressService, $id)
    {
        $address = Address::findOrFail($id);

        if(Gate::denies('address', $address)) {
            abort(403);
        }

        $addressService->delivery($request->all(), $address);

        return ['success' => 'true'];
    }
}