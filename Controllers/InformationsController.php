<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 13.04.2017
 * Time: 17:32
 */

namespace Controllers;


class InformationsController implements Controller
{
    public function post()
    {
        if (isset($_POST['login'])) {
            echo "it is login in informations";
        }
    }

    public function get()
    {
        $this->showMenu();
    }

    private function showMenu()
    {
        echo "
            <div class='large-2 medium-3 small-3 columns'>
                <ul class='vertical menu'>
                    <li><a href='contact' style='background-color: #D0D0D0;'>Contact us</a></li>
                    <ul class='nested vertical menu'>
                        <li><a href='contact'>Contact</a></li>
                    </ul>

                   <li><a href='orders' style='background-color: #D0D0D0;'>Orders</a></li>
                   <ul class='nested vertical menu'>
                        <li><a href='how_to_order'>How to order</a></li>
                        <li><a href='shipping_term'>Shipping term</a></li>
                        <li><a href='terms'>Terms and conditions</a></li>
                        <li><a href='order_state'>Order state</a></li>
                        <li><a href='client_advantages'>Client advantages</a></li>
                        <li><a href='order_cancelation'>Order cancelation</a></li>
                        <li><a href='product_availability'>Product availability</a></li>
                   </ul>

                   <li><a href='returns_warranty' style='background-color: #D0D0D0;'>Returns and warranty</a></li>
                   <ul class='nested vertical menu'>
                        <li><a href='return_policy'>Return policy</a></li>
                        <li><a href='warranty_conditions'>Warranty conditions</a></li>
                        <li><a href='how_to_proceed'>How do I proceed</a></li>
                   </ul>

                   <li><a href='payment_methods' style='background-color: #D0D0D0;'>Payment methods</a></li>
                   <ul class='nested vertical menu'>
                        <li><a href='repayment'>Repayment</a></li>
                        <li><a href='with_card'>With card</a></li>
                        <li><a href='cash_hq'>Cash at the HQ</a></li>
                        <li><a href='rates'>Rates</a></li>
                   </ul>

                   <li><a href='delivery' style='background-color: #D0D0D0;'>Delivery</a></li>
                   <ul class='nested vertical menu'>
                        <li><a href='costs'>Costs</a></li>
                        <li><a href='methods'>Methods</a></li>
                        <li><a href='urgent_delivery'>Urgent delivery in Baia Mare in just 3 hours</a></li>
                   </ul>

                   <li><a href='about_us' style='background-color: #D0D0D0;'>About us</a></li>
                   <ul class='nested vertical menu'>
                        <li><a href='company'>Company</a></li>
                        <li><a href='products'>Products</a></li>
                   </ul>
                </ul>
          </div>
        ";
    }
}