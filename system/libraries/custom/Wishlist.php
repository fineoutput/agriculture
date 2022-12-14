<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class CI_Wishlist
{
    protected $CI;
    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->helper('form');
        $this->CI->load->model("admin/login_model");
        $this->CI->load->model("admin/base_model");
    }
    //======================================================= START WISHLIST ==========================================================


    //===================================== ADD TO WISHLIST ========================================================
    public function AddToWishlist($product_id, $type_id)
    {
        if (!empty($this->CI->session->userdata('user_data'))) {
            $user_id= $this->CI->session->userdata('user_id');
            $user_type= $this->CI->session->userdata('user_type');
            $ip = $this->CI->input->ip_address();
            date_default_timezone_set("Asia/Calcutta");
            $cur_date=date("Y-m-d H:i:s");
            $wishcheck = $this->CI->db->get_where('tbl_wishlist', array('user_id'=> $user_id,'product_id'=> $product_id,'type_id'=> $type_id, 'user_type'=>$user_type))->result();
            if (empty($wishcheck)) {
                //---- insert into wishlist -----
                $data_insert = array('user_id'=>$user_id,
            'product_id'=>$product_id,
            'type_id'=>$type_id,
            'user_type'=>$user_type,
            'ip' =>$ip,
            'date'=>$cur_date
          );
                $last_id=$this->CI->base_model->insert_table("tbl_wishlist", $data_insert, 1) ;

                if (!empty($last_id)) {
                    $respone['status'] = true;
                    $respone['message'] ='Item successfully added in your wishlist';
                    return json_encode($respone);
                } else {
                    $respone['status'] = false;
                    $respone['message'] ='Some error occurred';
                    return json_encode($respone);
                }
            } else {
                $respone['status'] = false;
                $respone['message'] ='Product is already in your wishlist';
                return json_encode($respone);
            }
        } else {
            $respone['status'] = false;
            return json_encode($respone);
        }
    }
    //===================================== REMOVE TO WISHLIST ========================================================
    public function RemoveToWishlist($product_id, $type_id)
    {
        if (!empty($this->CI->session->userdata('user_data'))) {
            $user_id= $this->CI->session->userdata('user_id');
            $ip = $this->CI->input->ip_address();
            date_default_timezone_set("Asia/Calcutta");
            $cur_date=date("Y-m-d H:i:s");
            $wishcheck = $this->CI->db->get_where('tbl_wishlist', array('user_id'=> $user_id,'product_id'=> $product_id,'type_id'=> $type_id))->result();
            if (!empty($wishcheck)) {
                // ---- remove from wishlist ------
                $delete=$this->CI->db->delete('tbl_wishlist', array('user_id' => $user_id,'product_id'=>$product_id, 'type_id'=>$type_id));
                if (!empty($delete)) {
                    $respone['status'] = true;
                    $respone['message'] ='Item successfully removed from your wishlist';
                    return json_encode($respone);
                } else {
                    $respone['status'] = false;
                    $respone['message'] ='Some error occurred';
                    return json_encode($respone);
                }
            } else {
                $respone['status'] = false;
                $respone['message'] ='Some error occurred';
                return json_encode($respone);
            }
        } else {
            $respone['status'] = false;
            return json_encode($respone);
        }
    }
    //===================================== MOVE TO WISHLIST ========================================================
    public function MoveToCart($product_id, $type_id)
    {
        if (!empty($this->CI->session->userdata('user_data'))) {
            $user_id= $this->CI->session->userdata('user_id');
            $user_type= $this->CI->session->userdata('user_type');
            $ip = $this->CI->input->ip_address();
            date_default_timezone_set("Asia/Calcutta");
            $cur_date=date("Y-m-d H:i:s");
            $wishcheck = $this->CI->db->get_where('tbl_cart', array('user_id'=> $user_id,'product_id'=> $product_id,'type_id'=> $type_id, 'user_type'=>$user_type))->result();
            if (empty($wishcheck)) {
                //--- check inventory ---------
                $type_data = $this->CI->db->get_where('tbl_type', array('id = ' => $type_id,'is_active' => 1))->result();
                if (!empty($type_data)) {
                    if ($type_data[0]->inventory < 1) {
                        $respone['status'] = false;
                        $respone['message'] ="Product is out of stock";
                        return json_encode($respone);
                    }
                } else {
                    $respone['status'] = false;
                    $respone['message'] ="Product is out of stock";
                    return json_encode($respone);
                }
                //----- insert into wishlist --------
                $wishlist_insert = array('user_id'=>$user_id,
                'product_id'=>$product_id,
                'type_id'=>$type_id,
                'quantity'=>1,
                'user_type'=>$user_type,
                'ip' =>$ip,
                'date'=>$cur_date
                );
                $wishlist_id=$this->CI->base_model->insert_table("tbl_cart", $wishlist_insert, 1) ;
                if (!empty($wishlist_id)) {
                    //------ remove from wishlist -----
                    $delete=$this->CI->db->delete('tbl_wishlist', array('user_id' => $user_id,'product_id'=>$product_id, 'type_id'=>$type_id));
                    $respone['status'] = true;
                    $respone['message'] ='Item successfully moved to your cart';
                    echo json_encode($respone);
                } else {
                    $respone['status'] = false;
                    $respone['message'] ='Some error occurred';
                    echo json_encode($respone);
                }
            } else {
                $respone['status'] = false;
                $respone['message'] ='Product already exists in cart';
                echo json_encode($respone);
            }
        } else {
            $respone['status'] = false;
            return json_encode($respone);
        }
    }
    //======================== VIEW WISHLIST ====================

    public function ViewWishlist()
    {
        if (!empty($this->CI->session->userdata('user_data'))) {
            $sub_total=0;
            $wishlist_info = [];
            $user_id= $this->CI->session->userdata('user_id');
            $user_type= $this->CI->session->userdata('user_type');
            $wishdata = $this->CI->db->get_where('tbl_wishlist', array('user_id'=> $user_id, 'user_type'=>$user_type));
            if (!empty($wishdata)) {
                foreach ($wishdata->result() as $wishlist) {
                    $total=0;
                    $pro_data = $this->CI->db->get_where('tbl_product', array('id= ' => $wishlist->product_id,'is_active' => 1))->result();
                    $type_data = $this->CI->db->get_where('tbl_type', array('id= ' => $wishlist->type_id,'is_active' => 1))->result();
                    $size_data = $this->CI->db->get_where('tbl_size', array('id= ' => $type_data[0]->size_id,'is_active' => 1))->result();
                    $color_data = $this->CI->db->get_where('tbl_colour', array('id= ' => $type_data[0]->colour_id,'is_active' => 1))->result();
                    $image="";
                    $stock = 1;
                    //---- manage type image-------
                    if (!empty($type_data[0]->image)) {
                        $image=base_url().$type_data[0]->image;
                    } else {
                        $image="";
                    }
                    //------ manage price ------
                if ($user_type==2) {//------ for reselller ----
                    $price = $type_data[0]->reseller_spgst;
                } else{//---- for retailer  -----
                      $price = $type_data[0]->retailer_spgst;
                }
                    //------ stock status -----
                    if ($type_data[0]->inventory==0) {
                        $stock = 0;
                    } else {
                        $stock = 1;
                    }
                    $wishlist_info[] = array('type_id'=>$type_data[0]->id,
        'product_name'=>$pro_data[0]->name,
        'url'=>$pro_data[0]->url,
        'product_id'=>$pro_data[0]->id,
        'size'=>$size_data[0]->name,
        'color'=>$color_data[0]->colour_name,
        'colorcode'=>$color_data[0]->name,
        'image'=>$image,
        'price'=>$price,
        'stock'=>$stock,

        );
                }
            }
            $respone['status'] = true;
            $respone['message'] ="Success";
            $respone['wishlist_data'] =$wishlist_info;
            return $respone;
        // return json_encode($respone);
        } else {
            $respone['status'] = false;
            return json_encode($respone);
        }
    }
    //======================================================= END WISHLIST ==========================================================
}
