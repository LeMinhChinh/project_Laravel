<?php
namespace App\Helpers;

class Categories
{
    public static function buildTreeCategory($category = [])
    {
        $data = [];
        $arrCheck = [];
        // Lấy ra cate lớn nhất id = 0
        foreach ($category as $key => $value) {
            if($value['parent_id'] == 0){
                $arrCheck[] = $value['id']; //check khong trung
                $value['subCate'] = []; //tao ra mang con subCate

                $data[$value['id']] = $value;
            }
        }

        // xu li menu con
        foreach ($category as $k => $v) {
            //lay ra nhung item khong ton tai trong mang arrCheck
            if(!in_array($v['id'], $arrCheck)){
                if($v['parent_id'] > 0){
                    $arrCheck[] = $v['id']; //check trung nhung lan tiep theo neu co
                    $v['subCate'] = [];
                    $data[$v['parent_id']]['subCate'][$v['id']] = $v;
                }
            }
        }

        return $data;
    }
}
?>
