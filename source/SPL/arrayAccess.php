<?php 
/**
 *  探究：object改成像array操作
 *  NOTE：
 *  1.ArrayAccess 必须实现4个方法
 *  2.Countable 必须实现1个方法
 */
class MyArrObj implements ArrayAccess,Countable{
	
	public $name;
	public $age;
	public $sex;
	
	public function __construct(){
		$this->name = 'bkduck';
		$this->age = 24;
		$this->sex = 'man';
	}
	
	//赋值
	public function offsetSet($index, $newval){
		//约定:存在的key，才可以赋值
		if( $this->offsetExists($index) ){ 
			$this->{$index} = $newval;
		}
	}
	
	//取值
	public function offsetGet($offset){
		//这里可对取值格式化，如strtoupper等
		if( $this->offsetExists($offset) ){
			return $this->{$offset};
		}
	}
	
	//判断是否存在
	public function offsetExists($offset){
		return array_key_exists( $offset, get_object_vars($this) ) ;
	}
	
	//取消值
	public function offsetUnset($offset){
		if( $this->offsetExists($offset)){
			 unset($this->{$offset});
		}
	}
	
	//计数
	public function count(){
		return count(get_object_vars($this));
	}
	
	
}

echo '<br/>-----$$myArrIterator origin:------- <br/>';
$myArrObj = new MyArrObj();
print_r($myArrObj);

$myArrObj['name'] = 'bkduck01';
$myArrObj['test'] = 'test'; //不会被赋值
unset($myArrObj['age']);
echo '<br/>count:' . $myArrObj->count();

echo '<br/>-----$$myArrIterator now:------- <br/>';
print_r($myArrObj);


/* 结果
-----$$myArrIterator origin:-------
MyArrObj Object ( [name] => bkduck [age] => 24 [sex] => man )
count:2
-----$$myArrIterator now:-------
MyArrObj Object ( [name] => bkduck01 [sex] => man ) 
*/

?>