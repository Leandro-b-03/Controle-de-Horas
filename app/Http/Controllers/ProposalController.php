<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Lang;
use App\Client;
use App\Proposal;
use App\ProposalType;
use App\ProposalVersion;
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

        // Get all types
        $types = ProposalType::orderBy('name')->get();
        $data['types'] = $types;

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

        d($inputs);

        if ($inputs['proposal'] == "" || $inputs['proposal'] == null || !$inputs['proposal']) {
            DB::rollback();
            return redirect('proposals/create')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'custom', Lang::get('proposals.error-proposal')));
        }

        try {
            if($validator) {
                $proposal = Proposal::create( $inputs );
                if ($proposal) {
                    $inputs['proposal_id'] = $proposal->id;
                    $inputs['version'] = 'v1';
                    $inputs['active'] = true;
                    if (ProposalVersion::create( $inputs )) {
                        DB::commit();
                        return redirect('proposals')->with('return', GeneralController::createMessage('success', Lang::get('general.' . $this->controller_name), 'create'));
                    } else {
                        DB::rollback();
                        return redirect('proposals/create')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'create'));
                    }
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

        // Get all clients
        $versions = ProposalVersion::orderBy('created_at')->where('proposal_id', $id)->get();
        $data['versions'] = $versions;

        // Get all types
        $types = ProposalType::orderBy('name', 'desc')->get();
        $data['types'] = $types;

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
                if ($proposal->{$input})
                    $proposal->{$input} = $value;
            }

            $success = false;

            if ($proposal->save()) {
                if ($inputs['version_id'] == 'new') {
                    $inputs['proposal_id'] = $proposal->id;
                    $inputs['version'] = 'v'. (ProposalVersion::where('proposal_id', $id)->count() + 1);
                    $inputs['active'] = '1';
                    
                    if (ProposalVersion::create( $inputs )) {
                        $success = true;
                    }
                } else {
                    $proposal_version_active = ProposalVersion::where('proposal_id', $id)->where('active', 1)->get()->first();

                    $proposal_version = ProposalVersion::find($inputs['version_id']);
                    $proposal_version->proposal = $inputs['proposal'];
                    $proposal_version->active = true;

                    if ($proposal_version_active->id != $inputs['version_id']) {
                        $proposal_version_active->active = false;
                        if ($proposal_version->save() && $proposal_version_active->save()){
                            $success = true;
                        }
                    } else {
                        if ($proposal_version->save()) {
                            $success = true;
                        }
                    }
                }

                if ($success == true){
                    DB::commit();
                    return redirect('proposals')->with('return', GeneralController::createMessage('success', Lang::get('general.' . $this->controller_name), 'update'));
                } else {
                    DB::rollback();
                    return redirect('proposals/' . $id . '/edit')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'update'));
                }
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
