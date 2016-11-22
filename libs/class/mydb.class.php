<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: tuzwu <tuzwu@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');

class WUZHI_mydb {
	private $db ;
	private $where ='';
	private $from =0;
	private $count =200;
	private $order ='';
	public function __construct() {
		$this->db = load_class("db");

	}

	public function getfield($table)
	{
		$where['dbname'] = $table ;
		$result = $this->begin()->where($where)->getall("ziduanx");
		$this->begin();
		return $result;
	}


	public function begin()
	{
		$this->where = '';
		$this->order = '';
		$this->from = 0;
		$this->count = 200;
		return $this ;

	}

	public function where($c)
	{
		$this->where = $c ;
		return $this ;
	}
	public function order($c)
	{
		$this->order = $c ;
		return $this ;
	}
	public function page($from,$count)
	{
		$this->from = $from ;
		$this->count = $count ;
		return $this ;
	}

	public function getall($table){

		$result = $this->db->get_list($table,$this->where,'*',0,$this->count,$this->from,$this->order);
		$this->begin();

		return $result;

	}
	public function getbyid($table,$id){
		$result = $this->db->get_one($table,"id=$id");
		$this->begin();
		return $result;

	}

	public function save($table,$c)
	{
		$result = $this->db->update($table, $c, $this->where);
		$this->begin();
		return $result;
	}
	public function add($table,$c)
	{
		$result = $this->db->insert($table, $c);
		$this->begin();
		return $result;
	}
	public function delete($table,$c)
	{
		$result = $this->db->delete($table, $c);
		$this->begin();
		return $result;
	}
	public function query($sql)
	{

		$result =$this->db->query($sql);
		$this->begin();
		return  $result;
	}







}