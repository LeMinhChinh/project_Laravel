<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Admin;

class QueryDataBaseController extends Controller
{
    public function index()
    {
        // Thuc hien cau lenh truy van
        // lấy tất cả dữ liệu trong bảng admins
        $admins = DB::table('admins')->get();
        $admin = \json_decode(\json_encode($admins), true);
        foreach ($admin as $key => $value) {
            echo $value['id'];
            echo "</br>";
        }
        dd('aa');

        // $admins = DB::table('admins AS a')
        //             ->select('a.id','a.username','a.password')
        //             ->get();
        // dd($admins);

        // Select * From admins Where DK1 AND DK2 OR
        // $admins = DB::table('admins AS a')
        //             // ->where('a.id',1)
        //             // ->where('a.gender',1)
        //             ->where(['a.id' => 1, 'a.gender' =>1 , 'a.role' =>1])
        //             ->orWhere('a.fullname','Lê Minh Chính')
        //             ->first();
        //get() : fetchAll()
        // first() :fetch()
        // dd($admins);

        // select a.id, a.username From admins As a where a.id In (1,2,3)
        // $admins = DB::table('admins AS a')
        //             ->select('a.id', 'a.username')
        //             // ->whereIn('a.id', [1,2,3])
        //             ->whereNotIn('a.id', [1,2,3])
        //             ->get();
        // dd($admins);

        // select max(a.id),min(a.id), avg(a.id) from admins as a
        $admins = DB::table('admins AS a')
                    // ->max('a.id');
                    // ->min('a.id');
                    ->avg('a.id');

        // Select count(*) from admins
        $count = DB::table('admins')->count();

        // Select * from admins As a Limit 0,10;
        $data = DB::table('admins AS a')
                    ->skip(0)
                    ->take(10)
                    ->get();

        $data2 = DB::table('admins AS a')
                    ->offset(0)
                    ->limit(10)
                    ->get();


        // Select * from admins as a where a.username LIKE '%Xlcvs%'
        // $dateLike = DB::table('admins as a')
        //                 ->where('a.username', 'LIKE', '%Xlcvs%')
        //                 ->orWhere('a.email', 'LIKE', '%HUL2O@gmail.com%')
        //                 ->get();

        // select a.title, b.name_cate from posts as a
        // inner join categories as a on a.categories_id = b.id
        // where a.id = 3
        // $join  = DB::table('posts as a')
        //             ->select('a.title','b.name_cate')
        //             ->join('categories as b','a.categories_id' , '=', 'b.id')
        //             // ->leftjoin('categories as b','a.categories_id' , '=', 'b.id')
        //             // ->rightjoin('categories as b','a.categories_id' , '=', 'b.id')
        //             ->where('a.id', 3)
        //             ->first();


        /*
        //insert ,delete update
        // insert into tags('name_cate','description', 'status') value('','','')
        $insert = DB::table('tags')->insert([
            [
                'name_tag' => 'Test',
                'description' => 'demo',
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => null
            ],
            [
                'name_tag' => 'Test1',
                'description' => 'demo1',
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => null
            ]
        ]);
        if($insert){
            echo "OK";
        }else{
            echo "fail";
        }
        */

        // Update categories set as a (a.name_cate = 'abc') where a.id = 1
        // $update = DB::table('categories as a')
        //             ->where('a.id', 1)
        //             ->update([
        //                 'a.name_cate' => 'demo',
        //                 'a.status' => 0
        //             ]);
        // if($update){
        //     echo "OK";
        // }else{
        //     echo "fail";
        // }

        // delete from admins where id = 10;
        // $delete = DB::table('admins')
        //             ->where('id', 10)
        //             ->delete();
        // if($delete){
        //     echo "OK";
        // }else{
        //     echo "fail";
        // }
    }

    public function orm(Admin $admin)
    {
        $data = $admin->getAllDataAdmins();
        foreach ($data as $key => $value) {
            echo $value['id'];
            echo "</br>";
        }

        $info = $admin->getAllDataAdminById(1);
        $cod = $admin->getAllDataAdminByCodition();
        dd($cod);
    }

    public function test()
    {
        $dt = DB::connection('mysqlv2')->table('admins')->get();
        dd($dt);
    }
}
