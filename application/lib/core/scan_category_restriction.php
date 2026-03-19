<?php

class scan_category_restriction extends dbclass
{
    public function getList($post)
    {
        $query = "SELECT scr.id,pc.category_name,scr.scanLimit FROM scan_category_restriction scr JOIN product_category pc ON pc.id=scr.catId";

        if (isset($post['filterCatName']) && $post['filterCatName'] != "") {
            $query .= " WHERE pc.category_name like '%$post[filterCatName]%' ";
        }

        return $this->fetchResult($query);
    }

    public function delete($id)
    {
        $query = "DELETE FROM scan_category_restriction WHERE id=$id";
        return $this->_query($query);
    }

    public function add($postData)
    {
        foreach ($postData as $data):

            $catgeoryId = $data['catId'];

            $checkExist = "SELECT * FROM scan_category_restriction WHERE catId = $catgeoryId";
            $checkData = $this->fetchRow($checkExist);

            if (count($checkData) > 0):
                $query = "DELETE FROM scan_category_restriction WHERE catId = $catgeoryId";
                $this->_query($query);
            endif;

            $inserData = array(
                'catId' => $catgeoryId,
                'scanLimit' => $data['scanLimit'],
            );

            $return = $this->_insert('scan_category_restriction', $inserData);

        endforeach;

        if ($return['error'] == false) {
            return $return['insert_id'];
        } else {
            return false;
        }
    }

} // END CLASS
