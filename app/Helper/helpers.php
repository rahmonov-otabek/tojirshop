<?php 

function setActive(array $route){
    if(is_array($route)){
        foreach($route as $r){
            if(request()->routeIs($r)){
                return 'active';
            }
        }
    }
}

/** Check if product have discount */

function checkDiscount($product){
    $currentDate = date('Y-m-d');

    if($product->offer_price > 0 && $currentDate >= $product->offer_start_date && $currentDate <= $product->offer_end_date){
        return true;
    }

    return false;
}

/** Calculate discount percent */

function calculateDiscountPercent($orginalPrice, $discountPrice){
    $dicountAmount = $orginalPrice - $discountPrice;
    $discountPercent = ($dicountAmount / $orginalPrice) *100;
    return intval($discountPercent);
}

/** Check product type */

function productType(string $type)
{
    switch($type){
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