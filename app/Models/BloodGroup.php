<?php

namespace App\Models;

use DomainException;
use App\Helpers\Exception;
use App\Helpers\Translator;
use App\Helpers\ImageHelper;
use App\Http\Requests\FormBloodGroup;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class BloodGroup extends Model
{
    public static $path = [
        'image'  => 'blood-group',
        'url'    => 'blood-group',
        'view'   => 'BloodGroup'
    ];

    public static function getData($id = null, $edit = null, $paginate = null, $search = null)
    {
        $pages['form'] = array(
            'action'  => array(
                'add'    => url(Users::role() . '/general/' . BloodGroup::$path['url'] . '/add/'),
            ),
        );

        $data = array();
        $orderBy = 'DESC';
        if ($id) {
            $id  =  gettype($id) == 'array' ? $id : explode(',', $id);
            $sorted = array_values($id);
            sort($sorted);
            if ($id === $sorted) {
                $orderBy = 'ASC';
            } else {
                $orderBy = 'DESC';
            }
        }
        $get = BloodGroup::orderBy('id', $orderBy);

        if ($id) {
            $get = $get->whereIn('id', $id);
        }
        if ($search) {
            $get = $get->where('name', 'LIKE', '%' . $search . '%');
            if (config('app.languages')) {
                foreach (config('app.languages') as $lang) {
                    $get = $get->orWhere($lang['code_name'], 'LIKE', '%' . $search . '%');
                }
            }
        }

        if ($paginate) {
            $get = $get->paginate($paginate)->toArray();
            foreach ($get as $key => $value) {
                if ($key == 'data') {
                } else {
                    $pages[$key] = $value;
                }
            }

            $get = $get['data'];
        } else {
            $get = $get->get()->toArray();
        }

        if ($get) {

            foreach ($get as $key => $row) {

                $data[$key]         = array(
                    'id'            => $row['id'],
                    'name'          => $row[app()->getLocale()] ? $row[app()->getLocale()] : $row['name'],
                    'description'   => $row['description'],
                    'image'         => $row['image'] ? (ImageHelper::site(BloodGroup::$path['image'], $row['image'])) : asset('/assets/img/icons/image.jpg'),
                    'action'        => [
                        'edit' => url(Users::role() . '/general/' . BloodGroup::$path['url'] . '/edit/' . $row['id']),
                        'view' => url(Users::role() . '/general/' . BloodGroup::$path['url'] . '/view/' . $row['id']),
                        'delete' => url(Users::role() . '/general/' . BloodGroup::$path['url'] . '/delete/' . $row['id']),
                    ]
                );
                $pages['listData'][] = array(
                    'id'     => $data[$key]['id'],
                    'name'   => $data[$key]['name'],
                    'image'  => $data[$key]['image'],
                    'action' => $data[$key]['action'],

                );
                if ($edit) {
                    $data[$key]['name'] =  $row['name'];
                    if (config('app.languages')) {
                        foreach (config('app.languages') as $lang) {
                            $data[$key][$lang['code_name']] = $row[$lang['code_name']];
                        }
                    }
                }
            }

            $response       = array(
                'success'   => true,
                'data'      => $data,
                'pages'     => $pages,
            );
        } else {
            $response = array(
                'success'   => false,
                'data'      => [],
                'pages'     => $pages,
                'message'   => Translator::phrase('no_data'),
            );
        }

        return $response;
    }

    public static function getDataTable()
    {
        $model = BloodGroup::query();
        return DataTables::eloquent($model)
            ->setTransformer(function ($row) {
                $row = $row->toArray();
                return [
                    'id'            => $row['id'],
                    'name'          => $row[app()->getLocale()] ? $row[app()->getLocale()] : $row['name'],
                    'description'   => $row['description'],
                    'image'         => $row['image'] ? (ImageHelper::site(BloodGroup::$path['image'], $row['image'])) : asset('/assets/img/icons/image.jpg'),
                    'action'        => [
                        'edit' => url(Users::role() . '/general/' . BloodGroup::$path['url'] . '/edit/' . $row['id']),
                        'view' => url(Users::role() . '/general/' . BloodGroup::$path['url'] . '/view/' . $row['id']),
                        'delete' => url(Users::role() . '/general/' . BloodGroup::$path['url'] . '/delete/' . $row['id']),
                    ]

                ];
            })
            ->filter(function ($query) {

                if (request('search.value')) {
                    foreach (request('columns') as $i => $value) {
                        if ($value['searchable']) {
                            if ($value['data'] == 'name') {
                                $query =  $query->where(function ($q) {
                                    $q->where('name', 'LIKE', '%' . request('search.value') . '%');
                                    if (config('app.languages')) {
                                        foreach (config('app.languages') as $lang) {
                                            $q->orWhere($lang['code_name'], 'LIKE', '%' . request('search.value') . '%');
                                        }
                                    }
                                });
                            } elseif ($value['data'] == 'description') {
                                $query->orWhere('description', 'LIKE', '%' . request('search.value') . '%');
                            }
                        }
                    }
                }

                return $query;
            })
            ->order(function ($query) {
                if (request('order')) {
                    foreach (request('order') as $order) {
                        $col = request('columns')[$order['column']];
                        if ($col['data'] == 'id') {
                            $query->orderBy('id', $order['dir']);
                        }
                    }
                }
            })
            ->toJson();
    }

    public static function addToTable()
    {

        $response           = array();
        $validator          = Validator::make(request()->all(), FormBloodGroup::rulesField(), FormBloodGroup::customMessages(), FormBloodGroup::attributeField());

        if ($validator->fails()) {
            $response       = array(
                'success'   => false,
                'errors'    => $validator->getMessageBag(),
            );
        } else {

            try {

                $values['name']        = trim(request('name'));
                $values['description'] = trim(request('description'));
                $values['image']       = null;

                if (config('app.languages')) {
                    foreach (config('app.languages') as $lang) {
                        $values[$lang['code_name']] = trim(request($lang['code_name']));
                    }
                }

                $add = BloodGroup::insertGetId($values);

                if ($add) {

                    if (request()->hasFile('image')) {
                        $image      = request()->file('image');
                        BloodGroup::updateImageToTable($add, ImageHelper::uploadImage($image, BloodGroup::$path['image']));
                    } else {
                        ImageHelper::uploadImage(false, BloodGroup::$path['image'], BloodGroup::$path['image'], public_path('/assets/img/icons/image.jpg'), null, true);
                    }

                    $response       = array(
                        'success'   => true,
                        'type'      => 'add',
                        'data'      => BloodGroup::getData($add)['data'],
                        'message'   => array(
                            'title' => Translator::phrase('success'),
                            'text'  => Translator::phrase('add.successfully'),
                            'button'   => array(
                                'confirm' => Translator::phrase('ok'),
                                'cancel'  => Translator::phrase('cancel'),
                            ),
                        ),
                    );
                }
            } catch (DomainException $e) {
                $response       = Exception::exception($e);
            }
        }
        return $response;
    }

    public static function updateToTable($id)
    {

        $response           = array();
        $validator          = Validator::make(request()->all(), FormBloodGroup::rulesField(), FormBloodGroup::customMessages(), FormBloodGroup::attributeField());

        if ($validator->fails()) {
            $response       = array(
                'success'   => false,
                'errors'    => $validator->getMessageBag(),
            );
        } else {

            try {
                $values['name']        = trim(request('name'));
                $values['description'] = trim(request('description'));

                if (config('app.languages')) {
                    foreach (config('app.languages') as $lang) {
                        $values[$lang['code_name']] = trim(request($lang['code_name']));
                    }
                }

                $update = BloodGroup::where('id', $id)->update($values);

                if ($update) {
                    if (request()->hasFile('image')) {
                        $image      = request()->file('image');
                        BloodGroup::updateImageToTable($id, ImageHelper::uploadImage($image, BloodGroup::$path['image']));
                    }
                    $response       = array(
                        'success'   => true,
                        'type'      => 'update',
                        'data'      => BloodGroup::getData($id),
                        'message'   => array(
                            'title' => Translator::phrase('success'),
                            'text'  => Translator::phrase('update.successfully'),
                            'button'   => array(
                                'confirm' => Translator::phrase('ok'),
                                'cancel'  => Translator::phrase('cancel'),
                            ),
                        ),
                    );
                }
            } catch (DomainException $e) {
                $response       = Exception::exception($e);
            }
        }
        return $response;
    }

    public static function updateImageToTable($id, $image)
    {
        $response = array(
            'success'   => false,
            'message'   => Translator::phrase('update.failed'),
        );
        if ($image) {
            try {
                $update =  BloodGroup::where('id', $id)->update([
                    'image'    => $image,
                ]);

                if ($update) {
                    $response       = array(
                        'success'   => true,
                        'type'      => 'update',
                        'message'   => array(
                            'title' => Translator::phrase('success'),
                            'text'  => Translator::phrase('update.successfully'),
                            'button'   => array(
                                'confirm' => Translator::phrase('ok'),
                                'cancel'  => Translator::phrase('cancel'),
                            ),
                        ),
                    );
                }
            } catch (DomainException $e) {
                $response       = Exception::exception($e);
            }
        }

        return $response;
    }

    public static function deleteFromTable($id)
    {
        if ($id) {
            $id  = explode(',', $id);
            if (BloodGroup::whereIn('id', $id)->get()->toArray()) {
                if (request()->method() === 'POST') {
                    try {
                        $delete    = BloodGroup::whereIn('id', $id)->delete();
                        if ($delete) {
                            $response       =  array(
                                'success'   => true,
                                'message'   => array(
                                    'title' => Translator::phrase('deleted.!'),
                                    'text'  => Translator::phrase('delete.successfully'),
                                    'button'   => array(
                                        'confirm' => Translator::phrase('ok'),
                                        'cancel'  => Translator::phrase('cancel'),
                                    ),
                                ),
                            );
                        }
                    } catch (\Exception $e) {
                        $response       = Exception::exception($e);
                    }
                } else {
                    $response = response(
                        array(
                            'success'   => true,
                            'message'   => array(
                                'title' => Translator::phrase('are_you_sure.?'),
                                'text'  => Translator::phrase('you_wont_be_able_to_revert_this.!') . PHP_EOL .
                                    'ID : (' . implode(',', $id) . ')',
                                'button'   => array(
                                    'confirm' => Translator::phrase('yes_delete_it.!'),
                                    'cancel'  => Translator::phrase('cancel'),
                                ),
                            ),
                        )
                    );
                }
            } else {
                $response = response(
                    array(
                        'success'   => false,
                        'message'   => array(
                            'title' => Translator::phrase('error'),
                            'text'  => Translator::phrase('no_data'),
                            'button'   => array(
                                'confirm' => Translator::phrase('ok'),
                                'cancel'  => Translator::phrase('cancel'),
                            ),
                        ),
                    )
                );
            }
        } else {
            $response = response(
                array(
                    'success'   => false,
                    'message'   => array(
                        'title' => Translator::phrase('error'),
                        'text'  => Translator::phrase('please_select_data.!'),
                        'button'   => array(
                            'confirm' => Translator::phrase('ok'),
                            'cancel'  => Translator::phrase('cancel'),
                        ),
                    ),
                )
            );
        }
        return $response;
    }
}
