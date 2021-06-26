<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Http\Resources\Clients\ClientsResource;
use App\Models\Clients\Client;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ClientsController extends Controller
{
    protected $client;

    public function __construct(Client $client)
    {
        date_default_timezone_set('Africa/Lagos');

        $this->client = $client;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $clients = $this->client->paginate(10);

            $response = response()->json([
                'status' => 200,
                'data' => ClientsResource::collection($clients)
            ]);
        } catch (Exception $e) {
            Log::emergency("File: " . $e->getFile() . PHP_EOL .
                "Line: " . $e->getLine() . PHP_EOL .
                "Message: " . $e->getMessage());

            $response = response()->json(['error' => $e->getMessage(), 'status' => 400], 400);
        }

        return $response;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            // Validate Input
            $validator = validator($request->all(), [
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'email' => 'required|email|unique:clients,email',
                'primary_legal_counsel' => 'required|string',
                'date_of_birth' => 'required|date_format:Y/m/d',
                'case_details' => 'string'
            ]);

            if ($validator->fails()) {
                return $this->respondWithErrorMessage($validator);
            }

            // Create Clients
            $client = $this->client->create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'date_profiled' => now()->toDateTimeLocalString(),
                'primary_legal_counsel' => $request->primary_legal_counsel,
                'date_of_birth' => $request->date_of_birth,
                'case_details' => $request->case_details,
            ]);

            $response = response()->json([
                'status' => 201,
                'data' => 'Client added successfully!'
            ], 201);

        } catch (Exception $e) {
            Log::emergency("File: " . $e->getFile() . PHP_EOL .
                "Line: " . $e->getLine() . PHP_EOL .
                "Message: " . $e->getMessage());

            $response = response()->json(['error' => $e->getMessage(), 'status' => 400], 400);
        }

        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $client = $this->client->where('id', $id)->first();

            if (!$client) {
                $response = response()->json([
                    'status' => 404,
                    'error' => 'Client not found!'
                ], 404);
            }

            $response = response()->json([
                'status' => 200,
                'data' => new ClientsResource($client)
            ], 200);
        } catch (Exception $e) {
            Log::emergency("File: " . $e->getFile() . PHP_EOL .
                "Line: " . $e->getLine() . PHP_EOL .
                "Message: " . $e->getMessage());

            $response = response()->json(['error' => $e->getMessage(), 'status' => 400], 400);
        }

        return $response;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            // Validate Input
            $validator = validator($request->all(), [
                'first_name' => 'string',
                'last_name' => 'string',
                'email' => 'email|unique:clients,email',
                'primary_legal_counsel' => 'string',
                'date_of_birth' => 'date_format:Y/m/d',
                'case_details' => 'string'
            ]);

            if ($validator->fails()) {
                return $this->respondWithErrorMessage($validator);
            }

            $client = $this->client->where('id', $id)->first();

            if (!$client) {
                $response = response()->json([
                    'status' => 404,
                    'error' => 'Client not found!'
                ], 404);
            }

            $client->first_name = $request->get('first_name', $client->first_name);
            $client->last_name = $request->get('last_name', $client->last_name);
            $client->email = $request->get('email', $client->email);
            $client->primary_legal_counsel = $request->get('primary_legal_counsel', $client->primary_legal_counsel);
            $client->date_of_birth = $request->get('date_of_birth', $client->date_of_birth);
            $client->case_details = $request->get('case_details', $client->case_details);

            $client->save();

            $response = response()->json([
                'status' => 200,
                'data' => new ClientsResource($client)
            ], 200);
        } catch (Exception $e) {
            Log::emergency("File: " . $e->getFile() . PHP_EOL .
                "Line: " . $e->getLine() . PHP_EOL .
                "Message: " . $e->getMessage());

            $response = response()->json(['error' => $e->getMessage(), 'status' => 400], 400);
        }

        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $client = $this->client->where('id', $id)->first();

            if (!$client) {
                $response = response()->json([
                    'status' => 404,
                    'error' => 'Client not found!'
                ], 404);
            }

            $client->delete();

            $response = response()->json([
                'status' => 200,
                'message' => 'Client deleted successfully!'
            ], 200);
        } catch (Exception $e) {
            Log::emergency("File: " . $e->getFile() . PHP_EOL .
                "Line: " . $e->getLine() . PHP_EOL .
                "Message: " . $e->getMessage());

            $response = response()->json(['error' => $e->getMessage(), 'status' => 400], 400);
        }

        return $response;
    }
}
