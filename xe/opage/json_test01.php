<?php

$d = array('foo' => 'bar', 'baz' => 'long');

//$coupon11 = array('coupon_title' => '<녹차 무료!!', 'coupon_point' => '10000');
$coupon11['coupon_title']='^^녹차 무료!>';
$coupon11['coupon_point']='10000';

//$coupon12 = array('coupon_title' => '<음료수 무료!!', 'coupon_point' => '5000');
$coupon12['coupon_title']='<<음료수 무료!!>';
$coupon12['coupon_point']='5000';

//$coupon13 = array('coupon_title' => '<초밥세트 무료!!', 'coupon_point' => '7000');
$coupon13['coupon_title']='<<초밥세트 무료!>';
$coupon13['coupon_point']='7000';

//$coupons = array($coupon11, $coupon12, $coupon13);
$coupons[0] = $coupon11;
$coupons[1] = $coupon12;
$coupons[2] = $coupon13;

//$section1 = array('shop_name' => '오이시 초밥!!', 'shop_point' => '21077', 'coupons' => $coupons);
$section1['shop_name']='오이시 초밥!?!';
$section1['shop_point']='21077';
$section1['coupons']=$coupons;


//$sections = array($section1, $section1, $section1);
$sections[0] = $section1;
$sections[1] = $section1;
$sections[2] = $section1;

/*
$temp = array("1"=>"백두산","2"=>"한라산","3"=>"설악산");
foreach($temp as $key=>$val)
{
echo "key : $key  ~~~  val : $val<br>";
}
*/

echo json_encode($sections);
?>
