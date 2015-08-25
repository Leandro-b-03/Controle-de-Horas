<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Lang;
use App\Client;
use App\Proposal;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\GeneralController;

class ProposalController extends Controller
{
    private $controller_name = 'ProposalController';

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // Get all the proposals
        $proposals = Proposal::All();
        $data['proposals'] = $proposals;

        // Return the proposals view.
        return view('proposal.index')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        // Get all clients
        $clients = Client::all();
        $data['clients'] = $clients;

        $data['versions'] = null;

        // Return the proposal view.
        return view('proposal.create')->with('data', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $inputs = $request->all();
        
        // Validation of the fields
        $validator = Validator::make(
            [
                $inputs
            ],
            [
                'name' => 'required',
                'proposal' => 'required|min:8',
                'client' => 'required'
            ]
        );

        if ($inputs['proposal'] == "" || $inputs['proposal'] == null || !$inputs['proposal']) {
            DB::rollback();
            return redirect('proposals/create')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'custom', Lang::get('proposals.error-proposal')));
        }

        try {
            if($validator) {
                if (Proposal::create( $inputs )) {
                    return redirect('proposals')->with('return', GeneralController::createMessage('success', Lang::get('general.' . $this->controller_name), 'create'));
                } else {
                    DB::rollback();
                    return redirect('proposals/create')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'create'));
                }
            } else {
                DB::rollback();
                return redirect('proposals/create')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'create-failed'));
            }
        } catch (Exception $e){
            DB::rollback();
            return redirect('proposals/create')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'create-failed'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        // Get all clients
        $clients = Client::all();
        $data['clients'] = $clients;

        // Retrive the proposal with param $id
        $proposal = Proposal::find($id);
        $data['proposal'] = $proposal;

        // Return the dashboard view.
        return view('proposal.create')->with('data', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, Request $request)
    {
        DB::beginTransaction();

        // Get proposal with param $id
        $proposal = Proposal::find($id);

        // Get all the input from update.
        $inputs = $request->all();

        if ($inputs['proposal'] == "" || $inputs['proposal'] == null || !$inputs['proposal']) {
            DB::rollback();
            return redirect('proposals/' . $id . '/edit')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'custom', Lang::get('proposals.error-proposal')));
        }

        try {
            foreach($inputs as $input => $value) {
                if ($proposal->{$input} || $input == 'proposal')
                    $proposal->{$input} = $value;
            }

            if ($proposal->save()) {
                DB::commit();
                return redirect('proposals')->with('return', GeneralController::createMessage('success', Lang::get('general.' . $this->controller_name), 'update'));
            } else {
                DB::rollback();
                return redirect('proposals/' . $id . '/edit')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'update'));
            }
        } catch (Exception $e) {
            DB::rollback();
            return redirect('proposals/' . $id . '/edit')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'update'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id, Request $request)
    {
        DB::beginTransaction();
        
        // Get all the input data received.
        $input = $request->all();

        $ids = explode(',', $input['id']);

        try {
            if (Proposal::destroy($ids)) {
                DB::commit();
                return redirect('proposals')->with('return', GeneralController::createMessage('success', Lang::get('general.' . $this->controller_name), 'delete'));
            } else {
                DB::rollback();
                return redirect('proposals')->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'delete'));
            }
        } catch (Exception $e) {
            DB::rollback();
            return redirect('proposals')->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'delete'));
        }
    }
}
