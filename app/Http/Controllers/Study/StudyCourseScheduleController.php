<?php

namespace App\Http\Controllers\Study;

use App\Models\App;
use App\Models\Days;
use App\Models\Staff;
use App\Models\Users;
use App\Models\Languages;
use App\Models\StudyClass;
use App\Helpers\FormHelper;
use App\Helpers\MetaHelper;
use App\Helpers\Translator;
use App\Models\StudyCourse;
use App\Models\SocailsMedia;
use App\Models\StudySession;
use App\Models\StudyPrograms;
use App\Models\StudySubjects;
use App\Models\StudySemesters;
use App\Models\StudyGeneration;
use App\Models\StudyAcademicYears;
use App\Models\StudyCourseSchedule;
use App\Http\Controllers\Controller;
use App\Http\Requests\FormStudyCourseSchedule;
use App\Models\Institute;

class StudyCourseScheduleController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
        App::setConfig();
        SocailsMedia::setConfig();
        Languages::setConfig();
    }


    public function index($param1 = 'list', $param2 = null, $param3 = null)
    {
        $data['institute']                = Institute::getData();
        $data['study_program']            = StudyPrograms::getData();
        $data['study_course']             = StudyCourse::getData('null');
        $data['study_generation']         = StudyGeneration::getData();
        $data['study_academic_year']      = StudyAcademicYears::getData();
        $data['study_semester']           = StudySemesters::getData();
        $data['days']                     = Days::getData();
        $data['study_class']              = StudyClass::getData();
        $data['study_session']           = StudySession::getData();
        $data['teacher']                  = Staff::getData();
        $data['study_subject']            = StudySubjects::getData();



        $data['formData']       = array(
            'image' => asset('/assets/img/icons/image.jpg'),
        );
        $data['formName']       = 'study/'.StudyCourseSchedule::$path['url'];
        $data['formAction']     = '/add';
        $data['listData']       = array();
        if ($param1 == 'list') {

           if (strtolower(request()->server('CONTENT_TYPE')) == 'application/json') {
                return  StudyCourseSchedule::getData(null, null, 10);
            } else {
                $data = $this->list($data, $param1);
            }
        } elseif (strtolower($param1) == 'list-datatable') {
            if (strtolower(request()->server('CONTENT_TYPE')) == 'application/json') {
                return StudyCourseSchedule::getDataTable();
            } else {
                $data = $this->list($data,$param1);
            }
        } elseif ($param1 == 'add') {

            if (request()->ajax()) {
                if (request()->method() === 'POST') {
                    return StudyCourseSchedule::addToTable();
                }
            }

            $data = $this->add($data);
        } elseif ($param1 == 'edit') {
            $id = request('id',$param2);
            if (request()->ajax()) {
                if (request()->method() === 'POST') {
                    return StudyCourseSchedule::updateToTable($id);
                }
            }

            $data = $this->show($data, $id ,$param1);
        } elseif ($param1 == 'view') {
            $id = request('id',$param2);
            $data = $this->show($data, $id ,$param1);
        } elseif ($param1 == 'delete') {
            $id = request('id',$param2);
            return StudyCourseSchedule::deleteFromTable($id);

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
            'path'       => '/'.Users::role(),
            'pathview'   => '/'. $data['formName'].'/',
            'parameters' => array(
                'param1' => $param1,
                'param2' => $param2,
                'param3' => $param3,
            ),
            'search'     => parse_url(request()->getUri(), PHP_URL_QUERY) ? '?'.parse_url(request()->getUri(), PHP_URL_QUERY) : '',
            'form'       => FormHelper::form($data['formData'], $data['formName'], $data['formAction']),
            'parent'     => StudyCourseSchedule::$path['view'],
            'view'       => $data['view'],
        );

         $pages['form']['validate'] = [
            'rules'       =>  FormStudyCourseSchedule::rulesField(),
            'attributes'  =>  FormStudyCourseSchedule::attributeField(),
            'messages'    =>  FormStudyCourseSchedule::customMessages(),
            'questions'   =>  FormStudyCourseSchedule::questionField(),
        ];

        config()->set('app.title', $data['title']);
        config()->set('pages', $pages);
        return view($pages['parent'] . '.index', $data);
    }

    public function list($data, $param1)
    {
        $data['view']     = StudyCourseSchedule::$path['view'] . '.includes.list.index';
        $data['title']    = Translator::phrase(Users::role(app()->getLocale()) . '. | .list.Study_Course_Schedule' . '.' . $param1);
        return $data;
    }

    public function add($data)
    {
        $data['view']      = StudyCourseSchedule::$path['view'] . '.includes.form.index';
        $data['title']     = Translator::phrase(Users::role(app()->getLocale()) . '. | .add.Study_Course_Schedule');
        $data['metaImage'] = asset('assets/img/icons/register.png');
        $data['metaLink']  = url(Users::role() . '/add/');
        return $data;
    }

    public function show($data, $id ,$type)
    {
        $response = StudyCourseSchedule::getData($id, true);
        $data['view']       = StudyCourseSchedule::$path['view'] . '.includes.form.index';
        $data['title']      = Translator::phrase(Users::role(app()->getLocale()) . '. | .'.$type.'.Study_Course_Schedule');
        $data['metaImage']  = asset('assets/img/icons/'.$type.'.png');
        $data['metaLink']   = url(Users::role() . '/'.$type.'/' . $id);
        $data['formData']   = $response['data'][0];
        $data['listData']   = $response['pages']['listData'];
        $data['formAction'] = '/'.$type.'/' . $response['data'][0]['id'];
        $data['study_course'] = StudyCourse::getData($data['formData']['study_course']['id']);
        return $data;
    }
}
