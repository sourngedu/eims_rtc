<?php

namespace App\Http\Controllers\General;

use App\Models\App;
use App\Models\Users;
use App\Models\Communes;
use App\Models\Districts;
use App\Models\Languages;
use App\Models\Provinces;
use App\Helpers\FormHelper;
use App\Helpers\MetaHelper;
use App\Helpers\Translator;;

use App\Models\SocailsMedia;
use App\Http\Requests\FormCommune;
use App\Http\Controllers\Controller;

class CommuneController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        App::setConfig();
        SocailsMedia::setConfig();
        Languages::setConfig();
    }

    public function index($param1 = null, $param2 = null, $param3 = null)
    {
        $data['provinces']   = Provinces::getData(request('provinceId'), null, 10);
        $data['districts']   = Districts::getData(request('provinceId', 'null'), request('districtId', 'null'), null, 10);

        $data['formData'] = array(
            'image' => asset('/assets/img/icons/image.jpg'),
        );

        $data['formAction']      = '/add';
        $data['formName']        = 'general/' . Communes::$path['url'];
        $data['title']           = Translator::phrase(Users::role(app()->getLocale()) . '. | .' . $data['formName']);
        $data['metaImage']       = asset('assets/img/icons/' . $param1 . '.png');
        $data['metaLink']        = url(Users::role() . '/' . $param1);
        $data['listData']       = array();

        request()->merge([
            'id' => $param2 ? $param2 : request('id'),
        ]);


        if ($param1 == 'list' || $param1 == null) {
            if (strtolower(request()->server('CONTENT_TYPE')) == 'application/json') {
                return  Communes::getData(request('districtId'), request('id'), null, 10, request('search'));
            } else {
                $data = $this->list($data);
            }
        } elseif (strtolower($param1) == 'list-datatable') {
            if (strtolower(request()->server('CONTENT_TYPE')) == 'application/json') {
                return Communes::getDataTable();
            } else {
                $data = $this->list($data);
            }
        } elseif ($param1 == 'add') {
            if (request()->method() === 'POST') {
                return Communes::addToTable();
            }
            $data = $this->add($data);
        } elseif ($param1 == 'edit') {
            if (request()->method() === 'POST') {
                return Communes::updateToTable($param2);
            }
            $data = $this->show($data, $param2, $param1);
        } elseif ($param1 == 'view') {
            $data = $this->show($data, $param2, $param1);
        } elseif ($param1 == 'delete') {
            return Communes::deleteFromTable($param2);
        } else {
            abort(404);
        }

        MetaHelper::setConfig([
            'title'       => $data['title'],
            'author'      => config('app.name'),
            'keywords'    => '',
            'description' => '',
            'link'        => null,
            'image'       => null
        ]);
        $pages = array(
            'host'       => url('/'),
            'path'       => '/' . Users::role(),
            'pathview'   => '/' . $data['formName'] . '/',
            'parameters' => array(
                'param1' => $param1,
                'param2' => $param2,
                'param3' => $param3,
            ),
            'search'     => parse_url(request()->getUri(), PHP_URL_QUERY) ? '?' . parse_url(request()->getUri(), PHP_URL_QUERY) : '',
            'form'       => FormHelper::form($data['formData'], $data['formName'], $data['formAction']),
            'parent'     => 'Cambodia',
            'view'       => $data['view'],
        );

        $pages['form']['validate'] = [
            'rules'       =>  FormCommune::rulesField(),
            'attributes'  =>  FormCommune::attributeField(),
            'messages'    =>  FormCommune::customMessages(),
            'questions'   =>  FormCommune::questionField(),
        ];

        config()->set('app.title', $data['title']);
        config()->set('pages', $pages);
        return view('Cambodia.index', $data);
    }

    public function list($data)
    {
        $data['view']     = 'Cambodia.includes.list.index';
        $data['title']    = Translator::phrase(Users::role(app()->getLocale()) . '. | .list.commune');
        return $data;
    }

    public function add($data)
    {
        $data['view']      = 'Cambodia.includes.form.commune.index';
        $data['title']     = Translator::phrase(Users::role(app()->getLocale()) . '. | .add.commune');
        $data['metaImage'] = asset('assets/img/icons/register.png');
        $data['metaLink']  = url(Users::role() . '/add/');
        return $data;
    }

    public function show($data, $id, $type)
    {
        $response           = Communes::getData(request('districtId'), $id, true);
        $data['view']       = 'Cambodia.includes.form.commune.index';
        $data['title']      = Translator::phrase(Users::role(app()->getLocale()) . '. | .' . $type . '.commune');
        $data['metaImage']  = asset('assets/img/icons/' . $type . '.png');
        $data['metaLink']   = url(Users::role() . '/' . $type . '/' . $id);
        $data['formData']   = $response['data'][0];
        $data['listData']   = $response['pages']['listData'];
        $data['formAction'] = '/' . $type . '/' . $response['data'][0]['id'];
        $data['districts']      = Districts::getData($data['formData']['province']['id']);
        return $data;
    }
}
