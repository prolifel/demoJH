<?php

namespace App\Http\Controllers;

use App\Models\User;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Controller extends BaseController
{
    public function show(Request $request){
        try {
            // $data = $this->$request->all();
            // $val = $request->header('val');
            $aaray = array(
                [
                    'select'        => ['id','firstname','lastname','gender','status','email','city','address','phone','registered_date'],
                    'limit'         => 10,
                    'conditions'     => [
                        [
                            'type'  => 'whereColumn',
                            'data'  => [
                                ['firstname','=','Bani'],
                                ['lastname','=','toni']
                            ]
                        ],
                        [
                            'type'  => 'whereNull',
                            'data'  => ['gender']
                        ],
                        [
                            'type'  => 'whereNotIn',
                            'data'  => ['status',['Banned','Loss']]
                        ],
                        [
                            'type'  => 'whereIn',
                            'data'  => ['status',['Active','Pending']]
                        ],
                        [
                            'type'  => 'whereNotBetween',
                            'data'  => ['id',[10,20]]
                        ],
                        [
                            'type'  => 'whereBetween',
                            'data'  => ['id',[30,50]]
                        ],
                        [
                            'type'  => 'orWhere',
                            'data'  => ['id','<>',0]
                        ],
                        [
                            'type'      => 'orWhere',
                            'function'  => [
                                [
                                    'type'  => 'whereNotIn',
                                    'data'  => ['status',['Banned','Disabled']]
                                ],
                                [
                                    'type'  => 'whereIn',
                                    'data'  => ['status',['Active','Banned']]
                                ],
                            ]
                        ],
                        'current_page'  => 1,
                        'order'         => [
                            [
                                'field' => 'name',
                                'order' => 'DESC'
                            ],
                            [
                                'field' => 'date',
                                'order' => 'DESC'
                            ]
                        ]
                    ]
                ]
            );

            // $dataJson = json_encode($aaray);
            // $sql = DB::table('user')->whereJsonContains(". $dataJson ." , [[ 'select' ]])->get();
            // $sql2 = DB::table('user')->get();
            // $sql3 = User::select();
            // echo $sql2;

            // $sql = DB::table('user')->where('$dataJson->select')->get();
            // echo $sql;

            foreach($aaray as $row){
                // foreach($row['select'] as $sel){
                //     $string  = implode(" ", $sel);
                //     echo $string;
                //     echo implode(",", $sel);;
                // }
                $select = implode(", ", $row['select']);
                echo $row['limit'];
            }

            // echo $select;
            $querySelect = DB::select(DB::raw(
                "SELECT '$select' FROM user"
            ), [1]);
            // var_dump($querySelect);

            return $querySelect;
        } catch (\Throwable $th) {
            $error = Log::error($th->getMessage());
            return $error;
        }


    }
}
