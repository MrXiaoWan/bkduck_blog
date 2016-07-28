<?php 
//探究：ArrayIterator offsetUnset后 默认不再用该index，使用最后index
class MyArrIterator extends ArrayIterator{
	
	public function __construct($array){
		parent::__construct($array);
		
	}
	
	//append & $myArrIterator[2]='' 会触发
	public function offsetSet($index, $newval){
		if(is_null($index)){ //append
			$index = $this->appendOffsetSet($newval);
		}
		parent::offsetSet($index, $newval); 
		$this->ksort(); //按值排序
	}
	
	//append 触发 offsetSet index索引为null
	public function appendOffsetSet($newval){
		$index = 0; //count($this)
		while($this->offsetExists($index)){
			$index++;
		}
		return $index;
	}
	
	
}

$arrList = array('bkduck01','bkduck02','bkduck03');
$myArrIterator = new MyArrIterator($arrList);
$arrIterator = new ArrayIterator($arrList);

//与append不同，传入index
$myArrIterator['test'] = 'test';
$arrIterator['test'] = 'test';

//删除第二个
$myArrIterator->offsetUnset(1);
$arrIterator->offsetUnset(1);

//验证ArrayIterator 在index=1插入 or last insert
$myArrIterator->append('bkduck04');
$arrIterator->append('bkduck04');

// $myArrIterator->append(array('nn'=>'222'));
// $arrIterator->append(array('nn'=>'222'));

var_dump($arrIterator->serialize());
var_dump($myArrIterator->serialize());
echo '<br/>-----$myArrIterator:------- <br/>';
print_r($myArrIterator);
echo '<br/>-----$arrIterator:------- <br/>';
print_r($arrIterator);




?>