<?php $cart = \Yii::$app->cart; ?>

    <div class="cart_totals">
        <h2 class="heading relative heading-small uppercase mb-30">Итого</h2>

        <table class="table shop_table">
            <tbody>
            <tr class="cart-subtotal">
                <th>Подитог</th>
                <td>
                    <span class="amount"><?= $cart->getCost()?><i class="fa fa-ruble"></i></span>
                </td>
            </tr>
            <tr class="shipping">
                <th>Доставка</th>
                <td>
                    <span>В зависимости от способа доставки</span>
                </td>
            </tr>
            <tr class="order-total">
                <th><strong>Итого</strong></th>
                <td>
                    <strong><span class="amount"><?= $cart->getCost()?><i class="fa fa-ruble"></i></span></strong>
                </td>
            </tr>
            </tbody>
        </table>

    </div>
</div> <!-- end col cart totals -->