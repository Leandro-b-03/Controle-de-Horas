<?php namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

class GeneralController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/**
	 * Generates an array with parameters to messages
	 *
	 * @return Array with message
	 */
	public function createMessageJSON(Request $request)
	{
		// Get the data receive from ajax.
		$inputs = $request->all();

		return response()->json($this->createMessage($inputs['type'], $inputs['name'], $inputs['kind'], (isset($inputs['message']) ? $inputs['message'] : '')));
	}

	/**
	 * Generates an array with parameters to messages
	 *
	 * @return Array with message
	 */
	public static function createMessage($type, $name, $kind, $custonMessage = '')
	{
		// Array that will contain the generic message
		$message = array();

		// Verify what type is the message
		if ($type == 'success') {
			// Verify what kind is the message
			switch ($kind) {
				case 'create':
					$message = array(
						'status' => 'Sucesso',
						'class' => 'success',
						'faicon' => 'check',
						'message' =>  $name .' criado com sucesso!'
					);
					break;
				case 'update':
					$message = array(
						'status' => 'Sucesso',
						'class' => 'success',
						'faicon' => 'check',
						'message' =>  $name .' alterado com sucesso!'
					);
					break;
				case 'delete':
					$message = array(
						'status' => 'Sucesso',
						'class' => 'success',
						'faicon' => 'check',
						'message' =>  $name .'(s) deletado(s) com sucesso!'
					);
				default:
					# code...
					break;
			}
		} else {
			// Verify what kind is the message
			switch ($kind) {
			 	case 'create':
			 		$message = array(
						'status' => 'Falhou',
						'class' => 'danger',
						'faicon' => 'ban',
						'message' => 'Ocorreu um ploblema ao criar o ' . strtolower($name) . '.'
					);
			 		break;
		 		case 'update':
					$message = array(
						'status' => 'Falhou',
						'class' => 'danger',
						'faicon' => 'ban',
						'message' => 'Ocorreu um ploblema ao alterar o ' . strtolower($name) . '.'
					);
			 		break;
			 	case 'create-failed':
			 		$message = array(
						'status' => 'Falhou',
						'class' => 'danger',
						'faicon' => 'ban',
						'message' => 'Campos com valores errados.'
					);
			 		break;
			 	case 'delete':
			 		$message = array(
						'status' => 'Falhou',
						'class' => 'danger',
						'faicon' => 'ban',
						'message' => 'Houve erro ao deletar o(s) ' .  strtolower($name) . '(s).'
					);
			 		break;
			 	default:
			 		$message = array(
						'status' => 'Falhou',
						'class' => 'danger',
						'faicon' => 'ban',
						'message' => $custonMessage
					);
			 		break;
			 	}
		}

		return $message;
	}

}
