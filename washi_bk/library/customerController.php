<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of customerController
 *
 * @author ADMIN
 */
class customerController {

    public function checkMember($mem_code) {
        $result = dbQuery("Select mem_id from tbl_member where mem_code ='$mem_code'");
        if (dbNumRows($result) == 1) {
            return true;
        } else {
            return false;
        }
    }
    public function getPromo($mem_code){
        
    }
    //put your code here
}
