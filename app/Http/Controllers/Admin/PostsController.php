<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Tags;
use App\Http\Requests\StoreBlogPost;
use App\Http\Requests\UpdateBlockPost;
use App\Models\Posts;
use App\Models\PostContent;
use Illuminate\Support\Facades\Validator;

class PostsController extends Controller
{
    public function index(Request $request,Posts $post,Tags $tag)
    {
        // $dataPost = DB::table('posts')->get();
        // dd($dataPost);

        // Đổ dữ lieu từ controller ra view
        $name = "Lê Minh Chính";
        $data = [];
        $data['myName'] = $name;
        $data['age'] = 20;
        $data['adress'] = 'Nam Dinh';

        $data['createPostSuccess'] = $request->session()->get('createPostSuccess');
        $data['updatePostSuccess'] = $request->session()->get('updatePostSuccess');

        $keyword = $request->keyword;
        $keyword = \strip_tags($keyword);
        $data['keyword'] = $keyword;

        $lstPosts = $post->getAllDataPosts($keyword);
        $data['paginate'] = $lstPosts;

        $lstPosts = json_decode(json_encode($lstPosts),true);
        $lstPosts = $lstPosts['data'] ?? [];

        $lstTags = $tag->getDataTagsByPost();

        foreach ($lstPosts as $key => $value) {
            $lstPosts[$key]['lstTags'] = [];
            foreach ($lstTags as $k => $item) {
                if($value['id'] == $item['post_id']){
                    $lstPosts[$key]['lstTags'][] = $item['name_tag'];
                }

            }
        }
        $data['lstPosts'] = $lstPosts;
        return view('admin.posts.index', $data);
    }

    public function createPost(Category $cate,Tags $tags, Request $request)
    {
        $data = [];
        $data['cates'] = $cate->getAllDataCategories();
        $data['tags'] = $tags->getAllDataTags();
        $data['errorPublishDate'] = $request->session()->get('errorPublishDate');
        $data['errorAvatar'] = $request->session()->get('errorAvatar');
        return view('admin.posts.create',$data);
    }

    public function handleCreatePost(StoreBlogPost $request,Posts $post, PostContent $postContent)
    {
        $title = $request->titlePost;
        $slug = Str::slug($title, '-');
        $sapo = $request->sapoPost;
        $contentPost = $request->contentPost;
        $languagePost = $request->languagePost;
        $categoryPost = $request->categoryPost;
        $tagsPost = $request->tagsPost;

        $publishdatePost = $request->publishdatePost;
        // Kiểm tra : > ngày hiện tại

        if($publishdatePost){
            // admin chọn ngày xuất bản
            $today = date('Y-m-d H:i:s');
            // dd($publishdatePost, $today);
            $timePublishDate = strtotime($publishdatePost);
            $today = strtotime($today);
            if($timePublishDate < $today){
                $request->session()->flash('errorPublishDate', 'Ngày xuất bản không được trước ngày hiện tại');
                return redirect()->route('admin.createPost');
            }
        }

        // if(isset($_FILES['avatarPost'])){
        //     // dd($_FILES['avatarPost']);
        //     if($_FILES['avatarPost']['error'] == 0){
        //         $fileName = $_FILES['avatarPost']['name'];
        //         $tmpName = $_FILES['avatarPost']['tmp_name'];
        //         $up = move_uploaded_file($tmpName, public_path() . '/uploads/images/'. $fileName);
        //         if(!up){
        //             $request->session()->flash('errorAvatar', 'Không upload được ảnh');
        //             return redirect()->route('admin.createPost');
        //         }
        //     }
        // }


        if ($request->hasFile('avatarPost')) {
            // Kiem tra da chon file hay chua
            // Kiem tra xem file co loi hay k
            if ($request->file('avatarPost')->isValid()) {
                // Lay thong tin cua file
                $file = $request->file('avatarPost');
                // dd($file);
                // Lay ten file
                $nameFile = $file->getClientOriginalName();
                // upload
                $dir = 'uploads/images';
                $up = $file->move($dir, $nameFile);
                if(!up){
                    $request->session()->flash('errorAvatar', 'Không upload được ảnh');
                    return redirect()->route('admin.createPost');
                }
            }
        }

        $dataInsert = [
            'title' => $title,
            'slug' => $slug,
            'sapo' => $sapo,
            'categories_id' => $categoryPost,
            'publish_date' => $publishdatePost,
            'avatar' => $nameFile,
            'admins_id' => $request->session()->get('idSession'),
            'countview' => 0,
            'lang_id' => $languagePost,
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => null
        ];

        $idPost = $posts->insertDataPost(dataInsert);
        if($idPost > 0){
            $postContentData = [
                'post_id' => $idPost,
                'content_web' => $contentPost,
                'content_mobile' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => null
            ];
            $contentInsert = $postContent->insertDataContentPost($postContentData);

            if($contentInsert){
                if(!empty($tagsPost)){
                    foreach ($tagsPost as $key => $idTag) {
                        DB::table('post_tag')->insert([
                            'post_id' => $idPost,
                            'tag_id' => $idTag,
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => null
                        ]);
                    }
                }
                $request->session()->flash('createPostSuccess','Thêm thành công');
                return redirect()->route('admin.posts');
            }else{
                $request->session()->flash('errorPostContent', 'Lỗi thêm dữ liệu vào post content');
                return redirect()->route('admin.createPost');
            }
        }else{
            $request->session()->flash('errorCreate', 'Tạo bài viết bị lỗi');
            return redirect()->route('admin.createPost');
        }
    }

    public function deletePost(Request $request,Posts $post)
    {
        $id = $request->id;
        $id  = is_numeric($id) ? $id : 0;
        if($id > 0){
            $del = $post->deletePostById($id);
            if($del){
                echo "OK";
            }else{
                echo "Fail";
            }
        }else{
            echo "Err";
        }
    }

    public function editPost($slug, $id, Posts $post, Category $cate, Tags $tags)
    {
        $id = \is_numeric($id) ? $id : 0;
        $infoPost = $post->getInforDataPostById($id);
        if($infoPost){
            $data = [];
            $data['cates'] = $cate->getAllDataCategories();
            $data['tags'] = $tags->getAllDataTags();

            $lstTags = $tags->getDataTagsByPost();

            $arrIdTags = [];
            foreach ($lstTags as $key => $value) {
                if($value['post_id'] = $id){
                    $arrIdTags[] = $value['id'];
                }
            }
            $data['arrIdTags'] = $arrIdTags;
            $data['info'] = $infoPost;
            return view('admin.posts.edit',$data);
        }else{
            abort(404);
        }
    }

    public function handleUpdatePost(UpdateBlockPost $request, Posts $post, PostContent $postContent,Tags $tag)
    {
        // dd($request->all());
        $title = $request->titlePost;
        $slug = Str::slug($title, '-');
        $sapo = $request->sapoPost;
        $contentPost = $request->contentPost;
        $languagePost = $request->languagePost;
        $categoryPost = $request->categoryPost;
        $tagsPost = $request->tagsPost;
        $statusPost = $request->statusPost;
        $statusPost = in_array($statusPost, ['0','1']) ? $statusPost : 0;

        $publishdatePost = $request->publishdatePost;
        $idPost = $request->id;
        $idPost = is_numeric($idPost) ? $idPost : 0;
        $infoPost = $post->getInforDataPostById($idPost);
        $oldPublishDate = $infoPost['publish_date'];
        if($publishdatePost){

            // so sanh publishdate người dùng gửi lên và trong DB, nếu giống thì không thay đổi ngày xuất bản => không kiểm tra,ngược lại mới kiểm tra

            // admin chọn ngày xuất bản
            $today = date('Y-m-d H:i:s');
            $timePublishDate = strtotime($publishdatePost);
            $today = strtotime($today);
            $timeOldPublishDate = strtotime($oldPublishDate);
            if($timePublishDate != $timeOldPublishDate){
                if($timePublishDate < $today){
                    $request->session()->flash('errorPublishDate', 'Ngày xuất bản không được trước ngày hiện tại');
                    return redirect()->route('admin.createPost');
                }
                $publishDate = date('Y-m-d H:i:s0', \strtotime($publishDate));
            }

            // validate title : khong duoc update title da ton tai trong db loai tru title đang được chọn

        }
        $validator = Validator::make(
            ['titlePost' => $title],
            ['titlePost' => 'unique:posts,title,'.$idPost],
            ['unique' => 'title đã tồn tại']
        );

        if ($validator->fails()) {
            return redirect()->route('admin.editPost',['slug'=>$slug,'id' => $idPost])
                        ->withErrors($validator)
                        ->withInput();
        }else{
            $oldAvatar = $infoPost['avatar'];
            if($request->hasFile('avatarPost')){
                // Có thay ảnh => validate
                if ($request->file('avatarPost')->isValid()) {
                    $validatorAvatar = Validator::make(
                        ['avatarPost' => $request->file('avatar')],
                        ['avatarPost' => 'required|mimes:jepg,jpg,png,gif'],
                        ['required' => 'vui lòng chọn ảnh','mimes' => 'Định dạng ảnh không đúng']
                    );
                    if ($validator->fails()){
                        return redirect()->route('admin.editPost',['slug'=>$slug,'id' => $idPost])
                                         ->withErrors($validatorAvatar)
                                         ->withInput();
                    }else{
                        // thực sự upload ảnh
                        $file = $request->file('avatarPost');
                        // Lay ten file
                        $oldAvatar = $file->getClientOriginalName();
                        // upload
                        $dir = 'uploads/images';
                        $up = $file->move($dir, $oldAvatar);
                        if(!up){
                            $request->session()->flash('errorAvatar', 'Không upload được ảnh');
                            return redirect()->route('admin.createPost');
                        }
                    }
                }
            }
            $dataUpdate = [
                'title' => $title,
                'sapo' => $sapo,
                'slug' => $slug,
                'categories_id' => $categoryPost,
                'publish_date' => date('Y-m-d H:i:s', strtotime($oldPublishDate)),
                'avatar' => $oldAvatar,
                'lang_id' => $languagePost,
                'status' => $statusPost,
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $update = $post->updateDataPost($dataUpdate, $idPost);
            if($update){
                //tiep tuc update
                $updateContent = ['content_web' => $contentPost];

                $upV2 = $postContent->updateDataContentPostById($updateContent, $idPost);

                $lstTags = $tag->getDataTagsByPost();

                $arrIdTags = [];
                foreach ($lstTags as $key => $value) {
                    if($value['post_id'] = $idPost){
                        $arrIdTags[] = $value['id'];
                    }
                }

                $flagCheck = false;
                foreach ($arrIdTags as $i) {
                    foreach ($tagsPost as $j) {
                        if($i != $j){
                            $flagCheck = true;
                            break;
                        }
                    }
                }
                if($flagCheck){
                    $del = DB::table('post_tag')
                                ->where('post_id',$idPost)
                                ->delete();
                    if(!empty($tagsPost) && $del){
                        foreach ($tagsPost as $key => $idTag) {
                            DB::table('post_tag')->insert([
                                'post_id' => $idPost,
                                'tag_id' => $idTag,
                                'created_at' => date('Y-m-d H:i:s'),
                                'updated_at' => null
                            ]);
                        }
                    }
                }
                // $allTag = $tag->getAllDataTags();
                // foreach ($tag as $item) {
                //     foreach ($allTag as $key => $value) {
                //         if($value['id'] == $item){
                //             DB::table('post_tag')
                //                 ->where('post_id', $idPost)
                //                 ->update([
                //                     'tag_id' => $item,
                //                     'updated_at' => date('Y-m-d H:i:s')
                //                 ]);
                //         }
                //     }

                // }
                $request->session()->flash('updatePostSuccess','Sửa thành công');
                return redirect()->route('admin.posts');
            }else{
                $request->session()->flash('errUpdatePost','Sua bai bi loi');
                return redirect()->route('admin.editPost',['slug' => $slug, 'id' => $idPost]);
            }
        }
        // $this->validate($request,
        //     [
        //         'titlePost'=>'unique:posts,title,'.$idPost,
        //     ],
        // );

    }
}

