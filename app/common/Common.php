<?php
    //无限级分类
    function get_cate($res,$parent_id=0,$lv=1)
    {
        static 	$array =[];
        foreach($res as $v){
            if($v['parent_id']==$parent_id){
                $v['lv'] =$lv;
                $array[]=$v;	
                get_cate($res,$v['cate_id'],$v['lv']+1);
            }
        }
        return $array;
    }
    /**上传文件 */
    function upload($img){
        $store_result= [];
            foreach($img as $v){
                if($v->isValid()){
                    $store_result[]= $v->store('img');
                }
            }  
        return $store_result;
    }
    /**前台所有分类数据 */
    function getcateData($res,$parent_id=0){
		$getcateData = [];
		foreach($res as $v){
			if($v['parent_id']==$parent_id){
				$son = getcateData($res,$v['cate_id']);
				$v['son']=$son;
				$getcateData[]=$v;
			}
		}
		return $getcateData;
    } 
    //前台地柜 获取分类id
    function getCataId($cateData,$parent_id=0){
		static $c_id =[];
			   $c_id[$parent_id]=$parent_id;
		foreach($cateData as $v){
			if($v['parent_id']==$parent_id){
				$c_id[$v['cate_id']]=$v['cate_id'];
				getCataId($cateData,$v['cate_id']);
			}
		}
		return $c_id;
    } 
    /**检测前台用户是否登录 */
    function checkUser(){
        if(empty(session('user'))){
            echo "<script>alert('请先登录！');location.href='/login'</script>";die;
        }
    }
    /**获取用户id */
    function getUserId(){
        $user = session('user');
        $user_id=$user['user_id'];
        return $user_id;
    }
    function qqq(){
        $a = 2;
        return $a ;
    }