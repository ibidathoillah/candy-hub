<?php

namespace GetCandy\Hub\Services\Navigation\Menus\OrderProcessing;

use GetCandy\Hub\Services\Navigation\Menus\Menu;
use GetCandy\Hub\Services\Navigation\NavItem;

class SideMenu extends Menu
{
    public function __construct()
    {
        $this->navItems = [
            new NavItem('hub::titles.orders', route('hub.orders.index'), 'orders'),
            // new NavItem('Returns', route('hub.orders.index')),
            new NavItem('hub::titles.customers', route('hub.customers.index'), 'customers'),
            new NavItem('hub::titles.shipping_methods', route('hub.shipping.index'), 'shipping_methods'),
            new NavItem('hub::titles.shipping_zones', route('hub.shipping_zones.index'), 'shipping_zones'),
            new NavItem('hub::titles.articles', route('hub.articles.index'), 'articles'),
        ];

        $this->view = 'hub::menus.side-menu';
    }
}
