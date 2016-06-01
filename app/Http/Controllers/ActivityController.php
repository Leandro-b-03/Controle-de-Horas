<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Auth;
use Lang;
use App\Client;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\GeneralController;
class ActivityController
{

    private $display_name = '<em>Anon</em>';
    private $image = null;
    private $action_text = null;
    private $date = null;
    private $id;
    private $type;

    public function __construct($activity_type, $action_text, $options = array())
    {
        $options = $this->set_default_options($options);

        date_default_timezone_set('America/Sao_Paulo');

        $this->type = $activity_type;
        $this->id = uniqid();
        $this->date = date('r');

        $this->action_text = $action_text;
        $this->display_name = $options['displayName'];
        $this->image = $options['image'];

        if ($options['email']) {
            $this->image['url'] = Auth::user()->photo;

            if (is_null($this->display_name)) {
                $this->display_name = Auth::user()->username;
            }
        }
    }

    public function getMessage()
    {
        $activity = array(
          'id'          => $this->id,
          'body'        => $this->action_text,
          'published'   => $this->date,
          'type'        => $this->type,
          'actor'       => array(
            'id'            => Auth::user()->getEloquent()->id,
            'displayName'   => $this->display_name,
            'objectType'    => 'person',
            'image'         => $this->image
           )
         );
        return $activity;
    }

    private function set_default_options($options)
    {
        $defaults = array ('email' => null,
            'displayName' => null,
            'image' => array(
                'url' => '../uploads/img-not-found.jpg',
                'width' => 48,
                'height' => 48
               )
           );
        foreach ($defaults as $key => $value) {
            if (isset($options[$key]) == false) {
                $options[$key] = $value;
            }
        }

        return $options;
    }

}
?>