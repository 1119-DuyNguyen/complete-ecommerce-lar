<?php
namespace App\Helper;
use Illuminate\Support\Facades\Session;


/** Calculate discount percent */

function calculateDiscountPercent($originalPrice, $discountPrice) {
    $discountAmount = $originalPrice - $discountPrice;
    $discountPercent = ($discountAmount / $originalPrice) * 100;

    return round($discountPercent);
}


/** Check the product type */

function productType($type)
{
    switch ($type) {
        case 'new_arrival':
            return 'New';
            break;
        case 'featured_product':
            return 'Featured';
            break;
        case 'top_product':
            return 'Top';
            break;

        case 'best_product':
            return 'Best';
            break;

        default:
            return '';
            break;
    }
}

/** get total cart amount */
function getCartTotalItem($idCart){
    $total = 0;
    $cart= \Cart::get($idCart);
    $total += ( $cart->price +  $cart->attributes->variants_total) *  $cart->quantity;

    return $total;
}

function getCartTotal(){
    $total = 0;
    foreach(\Cart::getContent() as $cartItem){
        $total += ($cartItem->price + $cartItem->attributes->variants_total) * $cartItem->quantity;
    }
    return $total;
}
//
///** get payable total amount */
function getMainCartTotal(){
    if(Session::has('coupon')){
        $coupon = Session::get('coupon');
        $subTotal = getCartTotal();
        if($coupon['discount_type'] === 'amount'){
            $total = $subTotal - $coupon['discount'];
            return $total;
        }elseif($coupon['discount_type'] === 'percent'){
            $discount = ($subTotal * $coupon['discount'] / 100);
            return $subTotal - $discount;
        }
    }else {
        return getCartTotal();
    }
}
//
///** get cart discount */
function getCartDiscount(){

    if(Session::has('coupon')){
        $coupon = Session::get('coupon');
//        dd($coupon);
        $subTotal = getCartTotal();
        if($coupon['discount_type'] === 'amount'){
            return $coupon['discount'];
        }elseif($coupon['discount_type'] === 'percent'){
            return ($subTotal * $coupon['discount'] / 100);
        }
    }else {
        return 0;
    }
}

/** get selected shipping fee from session */
function getShppingFee(){
    if(Session::has('shipping_method')){
        return Session::get('shipping_method')['cost'];
    }else {
        return 0;
    }
}

/** get payable amount */
function getFinalPayableAmount(){
    return  getMainCartTotal() + getShppingFee();
}

/** lemit text */

function limitText($text, $limit = 20)
{
    return \Str::limit($text, $limit);
}


