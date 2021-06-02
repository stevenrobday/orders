<div class="container justify-content-xl-center">
    <img src="<?php echo base_url("assets/png/xxxx.png"); ?>" class="img-fluid col-3 mt-2 mb-2"
         alt="Responsive image">
    <nav class="sticky-top bg-white">
        <div class="nav nav-tabs d-flex justify-content-sm-start w-100" id="nav-tab" role="tablist">
            <a class="nav-item nav-link <?php if ($orderClass == 0) echo 'active activeLink'; ?>" id="0"
               href="/orders/get/0" role="tab"
               aria-controls="nav-new" aria-selected="true">New Orders</a>
            <a class="nav-item nav-link <?php if ($orderClass == 1) echo 'active activeLink'; ?>" id="1"
               href="/orders/get/1" role="tab"
               aria-controls="nav-pending" aria-selected="false">Pending</a>
            <a class="nav-item nav-link <?php if ($orderClass == 2) echo 'active activeLink'; ?> mr-auto" id="2"
               href="/orders/get/2" role="tab"
               aria-controls="nav-completed" aria-selected="false">Completed</a>
                <input class="form-control w-25 mb-1" id="search" placeholder="Search"
                    <?php if (isset($params)) echo 'value="' . $params . '"'; ?>
                >
                <i class="fas fa-search mb-1 pointer" id="magnifyingGlass" style="height: auto"></i>
        </div>
        <div class="row mt-2">
            <div class="col col-sm-3 col-md-3 col-lg-2 col-xl-2">
                <input id="selectToggle" class="selectToggle" type="checkbox" data-toggle="toggle"
                       data-on="Deselect<br>All"
                       data-off="Select All<br>Orders"
                       data-onstyle="secondary" data-offstyle="success">
            </div>
            <div class="col col-lg-7 col-xl-7">
                <div class="row">
                    <div class="col col-lg-5 col-xl-5 d-flex justify-content-around">
                        <input type="hidden" id="origFromDate" value="<?php echo $fromDate; ?>">
                        <input placeholder="Date" type="text" name="datepickerFrom" id="datepickerFrom"
                               width="105px"
                               value="<?php echo $fromDate; ?>">
                        <input type="hidden" id="origToDate" value="<?php echo $toDate; ?>">
                        <input placeholder="Date" type="text" name="datepickerTo" id="datepickerTo"
                               width="105px"
                               value="<?php echo $toDate; ?>">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col col-lg-5 col-xl-5 d-flex justify-content-center">
                        <div class="form-group">
                            <select id="selectStore" class="form-control">
                                <option value="all" <?php if ($storefront === "all") echo "selected"; ?>>All stores</option>
                                <option value="amazon" <?php if ($storefront === "amazon") echo "selected"; ?>>Amazon</option>
                                <option value="shopify" <?php if ($storefront === "shopify") echo "selected"; ?>>Shopify</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col col-lg-3 col-xl-3">
                <div class="row mt-1 mb-3">
                    <div class="col text-right">
                        <?php if ($orderClass != 0 && $orderClass != 2) : ?>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input pointer" type="radio" id="new" name="orderClass"
                                       value="0"
                                       checked>
                                <label class="form-check-label" for="new">New</label>
                            </div>
                        <?php endif;
                        if ($orderClass != 1) : ?>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input pointer" type="radio" id="pending" name="orderClass"
                                       value="1"
                                    <?php if ($orderClass == 0) echo " checked"; ?>>
                                <label class="form-check-label" for="pending">Pending</label>
                            </div>
                        <?php endif;
                        if ($orderClass != 2) : ?>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input pointer" type="radio" id="completed"
                                       name="orderClass"
                                       value="2">
                                <label class="form-check-label" for="completed">Completed</label>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col text-right">
                        <button type="button" id="reset" class="btn btn-warning mr-5">Reset</button>
                        <button type="button" id="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </div>
        <hr>
    </nav>
    <div class="tab-content container justify-content-xl-center" id="nav-tabContent">
        <div class="tab-pane fade show active" role="tabpanel" aria-labelledby="nav-new-tab">
            <?php
            $bg = "bg-light";
            foreach ($orders as $order) : ?>
                <div class="row order_<?php echo $order['uid']; ?>">
                    <div class="col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1 d-flex flex-column">
                        <div class="form-check ml-0 pl-0 mt-2 align-self-end">
                            <div class="custom-control custom-checkbox">
                                <input style="width: 30px; height: 30px" type="checkbox"
                                       class="form-check-input position-static pointer selectOrder"
                                       id="selectOrder_<?php echo $order['uid']; ?>">
                            </div>
                        </div>
                        <div class="arrow-toggle collapsed pointer align-self-end mt-4" data-toggle="collapse"
                             href="#orderCollapse_<?php echo $order['uid']; ?>"
                             role="button"
                             aria-expanded="false" aria-controls="orderCollapse_<?php echo $order['uid']; ?>">
                            <i id="downArrow_<?php echo $order['uid']; ?>" style="font-size: 30px; color: Dodgerblue"
                               class="fas fa-arrow-alt-circle-down"></i>
                            <i id="upArrow_<?php echo $order['uid']; ?>"
                               style="font-size: 30px; color: Dodgerblue; display: none"
                               class="fas fa-arrow-alt-circle-up"></i>
                        </div>
                    </div>
                    <div class="col-11 col-sm-11 col-md-11 col-lg-11 col-xl-11">
                        <div class="card mt-2 <?php echo $bg; ?>">
                            <div class="card-body">
                                <div class="row">
                                    <div class="font-weight-bold col-6 col-lg-3 col-xl-2">
                                        Storefront
                                    </div>
                                    <div class="col-6 col-lg-3 col-xl-4 pointer markSelected ms_<?php echo $order['uid']; ?> <?php if (isset($order['fields'])) if (strpos($order['fields'], "sf") !== false) echo 'text-light bg-success'; ?>"
                                        data-uid="<?php echo $order['uid']; ?>"
                                         data-field="sf"
                                    >
                                        <?php echo ucfirst($order['storefront']); ?>
                                    </div>
                                    <div class="font-weight-bold col-6 col-lg-3 col-xl-2">
                                        Order Type
                                    </div>
                                    <div class="col-6 col-lg-3 col-xl-4 pointer markSelected ms_<?php echo $order['uid']; ?> <?php if (isset($order['fields'])) if (strpos($order['fields'], "ot") !== false) echo 'text-light bg-success'; ?>"
                                        data-uid="<?php echo $order['uid']; ?>"
                                         data-field="ot">
                                        <?php if (strpos($order['tags'], 'net30') !== false)
                                            echo "Net30";
                                        elseif (strpos($order['tags'], 'wholesale') !== false || strpos($order['tags'], 'WholesaleNow'))
                                            echo "Wholesale";
                                        else
                                            echo "Retail";
                                        if (isset($order['ship_addr']))
                                        {
                                            $countryCode = '';
                                            if ($order['storefront'] === "shopify") $countryCode = $order['ship_addr']['country_code'];
                                            elseif ($order['storefront'] === "amazon") $countryCode = $order['ship_addr']['country'];
                                            if ($countryCode !== "US") echo " International";
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="font-weight-bold col-6 col-lg-3 col-xl-2">
                                        Order Date
                                    </div>
                                    <div class="col-6 col-lg-3 col-xl-4 pointer markSelected ms_<?php echo $order['uid']; ?> <?php if (isset($order['fields'])) if (strpos($order['fields'], "od") !== false) echo 'text-light bg-success'; ?>"
                                        data-uid="<?php echo $order['uid']; ?>"
                                         data-field="od">
                                        <?php echo $order['created_at']; ?>
                                    </div>
                                    <div class="font-weight-bold col-6 col-lg-3 col-xl-2">
                                        Total Quantity
                                    </div>
                                    <div class="col-6 col-lg-3 col-xl-4 pointer markSelected ms_<?php echo $order['uid']; ?> <?php if (isset($order['fields'])) if (strpos($order['fields'], "tq") !== false) echo 'text-light bg-success'; ?>"
                                        data-uid="<?php echo $order['uid']; ?>"
                                         data-field="tq">
                                        <?php echo $order['total_qty']; ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="font-weight-bold col-6 col-lg-3 col-xl-2">
                                        Order Number
                                    </div>
                                    <div class="col-6 col-lg-3 col-xl-4 pointer markSelected ms_<?php echo $order['uid']; ?> <?php if (isset($order['fields'])) if (strpos($order['fields'], "on") !== false) echo 'text-light bg-success'; ?>"
                                        data-uid="<?php echo $order['uid']; ?>"
                                         data-field="on"
                                    >
                                        <?php echo $order['order_num']; ?>
                                    </div>
                                    <div class="font-weight-bold col-6 col-lg-3 col-xl-2">
                                        Subtotal
                                    </div>
                                    <div class="col-6 col-lg-3 col-xl-4 pointer markSelected ms_<?php echo $order['uid']; ?> <?php if (isset($order['fields'])) if (strpos($order['fields'], "sp") !== false) echo 'text-light bg-success'; ?>"
                                        data-uid="<?php echo $order['uid']; ?>"
                                         data-field="sp">
                                        <?php echo '$' . number_format($order['subtotal_price'], 2); ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="font-weight-bold col-6 col-lg-3 col-xl-2">
                                        Payment Method
                                    </div>
                                    <div class="col-6 col-lg-3 col-xl-4 pointer markSelected ms_<?php echo $order['uid']; ?> <?php if (isset($order['fields'])) if (strpos($order['fields'], "pm") !== false) echo 'text-light bg-success'; ?>"
                                        data-uid="<?php echo $order['uid']; ?>"
                                         data-field="pm">
                                        <?php
                                        if (strpos($order['tags'], 'net30') !== false)
                                            echo "Net30";
                                        elseif ($order['storefront'] === "amazon")
                                            echo "Amazon - CC";
                                        elseif ($order['gateway'] === "shopify_payments")
                                            echo "Shopify - CC";
                                        elseif ($order['gateway'] === "paypal")
                                            echo "PayPal";
                                        ?>
                                    </div>
                                    <div class="font-weight-bold col-6 col-lg-3 col-xl-2">
                                        Tax
                                    </div>
                                    <div class="col-6 col-lg-3 col-xl-4 pointer markSelected ms_<?php echo $order['uid']; ?> <?php if (isset($order['fields'])) if (strpos($order['fields'], "tx") !== false) echo 'text-light bg-success'; ?>"
                                        data-uid="<?php echo $order['uid']; ?>"
                                         data-field="tx">
                                        <?php echo '$' . number_format($order['total_tax'], 2); ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="font-weight-bold col-6 col-lg-3 col-xl-2">
                                        Shipping Method
                                    </div>
                                    <div class="col-6 col-lg-3 col-xl-4 pointer markSelected ms_<?php echo $order['uid']; ?> <?php if (isset($order['fields'])) if (strpos($order['fields'], "sm") !== false) echo 'text-light bg-success'; ?>"
                                        data-uid="<?php echo $order['uid']; ?>"
                                         data-field="sm">
                                        <?php echo $order['ship_method']; ?>
                                    </div>
                                    <div class="font-weight-bold col-6 col-lg-3 col-xl-2">
                                        Shipping
                                    </div>
                                    <div class="col-6 col-lg-3 col-xl-4 pointer markSelected ms_<?php echo $order['uid']; ?> <?php if (isset($order['fields'])) if (strpos($order['fields'], "sh") !== false) echo 'text-light bg-success'; ?>"
                                        data-uid="<?php echo $order['uid']; ?>"
                                         data-field="sh">
                                        <?php echo '$' . number_format($order['total_ship_price'], 2); ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="font-weight-bold col-6 col-lg-3 col-xl-2">
                                        Tracking Number
                                    </div>
                                    <div class="col-6 col-lg-3 col-xl-4 pointer markSelected ms_<?php echo $order['uid']; ?> <?php if (isset($order['fields'])) if (strpos($order['fields'], "tn") !== false) echo 'text-light bg-success'; ?>"
                                        data-uid="<?php echo $order['uid']; ?>"
                                         data-field="tn">
                                        <?php echo $order['track_num']; ?>
                                    </div>
                                    <div class="font-weight-bold col-6 col-lg-3 col-xl-2">
                                        Discount Amount
                                    </div>
                                    <div class="col-6 col-lg-3 col-xl-4 pointer markSelected ms_<?php echo $order['uid']; ?> <?php if (isset($order['fields'])) if (strpos($order['fields'], "da") !== false) echo 'text-light bg-success'; ?>"
                                        data-uid="<?php echo $order['uid']; ?>"
                                         data-field="da">
                                        <?php echo '$' . number_format($order['total_discounts'], 2); ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6 col-lg-3 col-xl-2">
                                    </div>
                                    <div class="col-6 col-lg-3 col-xl-4">
                                    </div>
                                    <div class="font-weight-bold col-6 col-lg-3 col-xl-2">
                                        Total Price
                                    </div>
                                    <div class="col-6 col-lg-3 col-xl-4 pointer markSelected ms_<?php echo $order['uid']; ?> <?php if (isset($order['fields'])) if (strpos($order['fields'], "tp") !== false) echo 'text-light bg-success'; ?>"
                                        data-uid="<?php echo $order['uid']; ?>"
                                         data-field="tp">
                                        <?php echo '$' . number_format($order['total_price_usd'], 2); ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-8 col-lg-4 col-xl-4 mt-2">
                                        <div class="font-weight-bold">Bill to:</div>
                                    </div>
                                    <div class="col-lg-3 col-xl-2"></div>
                                    <div class="col-8 col-lg-4 col-xl-4 mt-2">
                                        <div class="font-weight-bold">Ship to:</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-8 col-lg-4 col-xl-4 border">
                                        <div class="pointer markSelected ms_<?php echo $order['uid']; ?> <?php if (isset($order['fields'])) if (strpos($order['fields'], "bt") !== false) echo 'text-light bg-success'; ?>"
                                        data-uid="<?php echo $order['uid']; ?>"
                                         data-field="bt">
                                            <?php if (isset($order['bill_addr'])) :
                                                $company = $name = $address1 = $address2 = $address3 = $cityStateZip = $country = $phone = '';
                                                if ($order['storefront'] === "shopify") {
                                                    $company = $order['bill_addr']['company'];
                                                    $name = $order['bill_addr']['first_name'] . ' ' . $order['bill_addr']['last_name'];
                                                    $address1 = $order['bill_addr']['address1'];
                                                    $address2 = $order['bill_addr']['address2'];
                                                    $cityStateZip = $order['bill_addr']['city'] . ', ' . $order['bill_addr']['province_code']
                                                        . ' ' . $order['bill_addr']['zip'];
                                                    $country = $order['bill_addr']['country_code'];
                                                    $phone = $order['bill_addr']['phone'];
                                                } elseif ($order['storefront'] === "amazon") {
                                                    $company = $order['bill_addr']['company'];
                                                    $name = $order['bill_addr']['name'];
                                                    $address1 = $order['bill_addr']['street1'];
                                                    $address2 = $order['bill_addr']['street2'];
                                                    $address3 = $order['bill_addr']['street3'];
                                                    if (isset($order['bill_addr']['postalCode'])) $cityStateZip = $order['bill_addr']['city'] . ', ' . $order['bill_addr']['state']
                                                        . ' ' . $order['bill_addr']['postalCode'];
                                                    $country = $order['bill_addr']['country'];
                                                }
                                                ?>
                                                <div class="row">
                                                    <div class="col-xl">
                                                        <?php if (isset($company)) echo $company; ?>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl">
                                                        <?php echo $name; ?>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl">
                                                        <?php echo $address1; ?>
                                                    </div>
                                                </div>
                                                <?php if (isset($address2)) : ?>
                                                <div class="row">
                                                    <div class="col-xl">
                                                        <?php echo $address2; ?>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                                <?php if (isset($address3)) : ?>
                                                <div class="row">
                                                    <div class="col-xl">
                                                        <?php echo $address3; ?>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                                <div class="row">
                                                    <div class="col-xl">
                                                        <?php echo $cityStateZip; ?>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl">
                                                        <?php echo $country; ?>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl">
                                                        <?php echo $phone; ?>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-xl-2"></div>
                                    <div class="col-8 col-lg-4 col-xl-4 border">
                                        <div class="pointer markSelected ms_<?php echo $order['uid']; ?> <?php if (isset($order['fields'])) if (strpos($order['fields'], "st") !== false) echo 'text-light bg-success'; ?>"
                                        data-uid="<?php echo $order['uid']; ?>"
                                         data-field="st">
                                            <?php if (isset($order['ship_addr'])) :
                                                $company = $name = $address1 = $address2 = $address3 = $cityStateZip = $country = $phone = '';
                                                if ($order['storefront'] === "shopify") {
                                                    $company = $order['ship_addr']['company'];
                                                    $name = $order['ship_addr']['first_name'] . ' ' . $order['ship_addr']['last_name'];
                                                    $address1 = $order['ship_addr']['address1'];
                                                    $address2 = $order['ship_addr']['address2'];
                                                    $cityStateZip = $order['ship_addr']['city'] . ', ' . $order['ship_addr']['province_code']
                                                        . ' ' . $order['ship_addr']['zip'];
                                                    $country = $order['ship_addr']['country_code'];
                                                    $phone = $order['ship_addr']['phone'];
                                                } elseif ($order['storefront'] === "amazon") {
                                                    $company = $order['ship_addr']['company'];
                                                    $name = $order['ship_addr']['name'];
                                                    $address1 = $order['ship_addr']['street1'];
                                                    $address2 = $order['ship_addr']['street2'];
                                                    $address3 = $order['ship_addr']['street3'];
                                                    if (isset($order['ship_addr']['postalCode'])) $cityStateZip = $order['ship_addr']['city'] . ', ' . $order['ship_addr']['state']
                                                        . ' ' . $order['ship_addr']['postalCode'];
                                                    $country = $order['ship_addr']['country'];
                                                }
                                                ?>
                                                <div class="row">
                                                    <div class="col-xl">
                                                        <?php if (isset($company)) echo $company; ?>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl">
                                                        <?php echo $name; ?>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl">
                                                        <?php echo $address1; ?>
                                                    </div>
                                                </div>
                                                <?php if (isset($address2)) : ?>
                                                <div class="row">
                                                    <div class="col-xl">
                                                        <?php echo $address2; ?>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                                <?php if (isset($address3)) : ?>
                                                <div class="row">
                                                    <div class="col-xl">
                                                        <?php echo $address3; ?>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                                <div class="row">
                                                    <div class="col-xl">
                                                        <?php echo $cityStateZip; ?>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl">
                                                        <?php echo $country; ?>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl">
                                                        <?php echo $phone; ?>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="collapse collapsable" id="orderCollapse_<?php echo $order['uid']; ?>"
                     data-uid="<?php echo $order['uid']; ?>">
                    <div class="order_<?php echo $order['uid']; ?> row">
                        <div class="col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1">
                        </div>
                        <div class="col-11 col-sm-11 col-md-11 col-lg-11 col-xl-11">
                            <div class="card <?php echo $bg; ?>">
                                <div class="card-body">
                                    <div class="table-responsive mt-3">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th scope="col">Qty</th>
                                                <th scope="col">SKU</th>
                                                <th scope="col">Item</th>
                                                <th scope="col">Price Per</th>
                                                <th scope="col">Discount</th>
                                                <th scope="col">Total Price</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach ($order['line_items'] as $lineItem) : ?>
                                                <tr>
                                                    <?php
                                                    $qty = $lineItem['quantity'];
                                                    $price = number_format($lineItem['price'], 2);
                                                    $discount = number_format($lineItem['total_discount'], 2);
                                                    $totalPrice = number_format($qty * $price - $discount, 2);
                                                    ?>
                                                    <td><?php echo $lineItem['quantity'] ?></td>
                                                    <td><?php echo $lineItem['sku'] ?></td>
                                                    <td><?php echo $lineItem['title'] ?></td>
                                                    <td><?php echo '$' . $price ?></td>
                                                    <td><?php echo '$' . $discount ?></td>
                                                    <td><?php echo '$' . $totalPrice ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                if ($bg === "bg-light") $bg = "bg-white";
                elseif ($bg === "bg-white") $bg = "bg-light";
            endforeach; ?>
        </div>
        <!--        <div class="tab-pane fade" id="nav-pending" role="tabpanel" aria-labelledby="nav-pending-tab">BELL</div>-->
        <!--        <div class="tab-pane fade" id="nav-complete" role="tabpanel" aria-labelledby="nav-complete-tab">AGO</div>-->
    </div>
</div>
