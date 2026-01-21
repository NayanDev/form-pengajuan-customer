<?php

namespace App\Helpers;

use Idev\EasyAdmin\app\Helpers\Constant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class Sidebar
{

  public function generate()
  {
    $menus = $this->menus();
    $constant = new Constant();
    $permission = $constant->permissions();

    $arrMenu = [];
    foreach ($menus as $key => $menu) {
      $visibilityMenu = in_array($menu['key'] . ".index", $permission['list_access']);
      if (isset($menu['override_visibility'])) {
        $visibilityMenu = $menu['override_visibility'];
      }
      $menu['visibility'] = $visibilityMenu;
      $menu['url'] = (Route::has($menu['key'] . ".index")) ? route($menu['key'] . ".index") : "#";
      $menu['base_key'] = $menu['key'];
      $menu['key'] = $menu['key'] . ".index";

      $arrMenu[] = $menu;
    }
    return $arrMenu;
  }


  public function menus()
  {
    $role = "developer";
    if (config('idev.enable_role', true)) {
      $role = Auth::user()->role->name;
    }
    return
      [
        [
          'name' => 'Dashboard',
          'icon' => 'ti ti-dashboard',
          'key' => 'dashboard',
          'base_key' => 'dashboard',
          'visibility' => true,
          'ajax_load' => false,
          'childrens' => []
        ],
        [
          'name' => 'Warehouse',
          'icon' => 'ti ti-home',
          'key' => 'warehouse',
          'base_key' => 'warehouse',
          'visibility' => true,
          'ajax_load' => false,
          'childrens' => []
        ],
        [
          'name' => 'Location',
          'icon' => 'ti ti-location',
          'key' => 'location',
          'base_key' => 'location',
          'visibility' => true,
          'ajax_load' => false,
          'childrens' => []
        ],
        // [
        //   'name' => 'Form Pengajuan',
        //   'icon' => 'ti ti-clipboard',
        //   'key' => 'form-pengajuan',
        //   'base_key' => 'form-pengajuan',
        //   'visibility' => true,
        //   'ajax_load' => false,
        //   'childrens' => []
        // ],
        [
          'name' => 'Customer',
          'icon' => 'ti ti-user',
          'key' => 'customer',
          'base_key' => 'customer',
          'visibility' => true,
          'ajax_load' => false,
          'childrens' => []
        ],
        [
          'name' => 'Category Mapping',
          'icon' => 'ti ti-target',
          'key' => 'category-mapping',
          'base_key' => 'category-mapping',
          'visibility' => true,
          'ajax_load' => false,
          'childrens' => []
        ],
        [
          'name' => 'Mapping',
          'icon' => 'ti ti-pin',
          'key' => 'mapping',
          'base_key' => 'mapping',
          'visibility' => true,
          'ajax_load' => false,
          'childrens' => []
        ],
        [
          'name' => 'Monitoring',
          'icon' => 'ti ti-device-desktop',
          'key' => 'temp-monitoring',
          'base_key' => 'temp-monitoring',
          'visibility' => true,
          'ajax_load' => false,
          'childrens' => []
        ],
        [
          'name' => 'Employee',
          'icon' => 'ti ti-users',
          'key' => 'employee',
          'base_key' => 'employee',
          'visibility' => true,
          'ajax_load' => false,
          'childrens' => []
        ],
        [
          'name' => 'Asset',
          'icon' => 'ti ti-box',
          'key' => 'asset',
          'base_key' => 'asset',
          'visibility' => true,
          'ajax_load' => false,
          'childrens' => []
        ],
        [
          'name' => 'Transaction',
          'icon' => 'ti ti-link',
          'key' => 'transaction',
          'base_key' => 'transaction',
          'visibility' => true,
          'ajax_load' => false,
          'childrens' => []
        ],
        [
          'name' => 'Device User',
          'icon' => 'ti ti-device-laptop',
          'key' => 'device-user',
          'base_key' => 'device-user',
          'visibility' => true,
          'ajax_load' => false,
          'childrens' => []
        ],
        [
          'name' => 'Maintenance',
          'icon' => 'ti ti-settings',
          'key' => 'maintenance',
          'base_key' => 'maintenance',
          'visibility' => true,
          'ajax_load' => false,
          'childrens' => []
        ],
        [
          'name' => 'Ticket',
          'icon' => 'ti ti-ticket',
          'key' => 'ticket',
          'base_key' => 'ticket',
          'visibility' => true,
          'ajax_load' => false,
          'childrens' => []
        ],
        [
          'name' => 'Role',
          'icon' => 'ti ti-key',
          'key' => 'role',
          'base_key' => 'role',
          'visibility' => in_array($role, ['admin']),
          'ajax_load' => false,
          'childrens' => []
        ],
        [
          'name' => 'User',
          'icon' => 'ti ti-users',
          'key' => 'user',
          'base_key' => 'user',
          'visibility' => in_array($role, ['admin']),
          'ajax_load' => false,
          'childrens' => []
        ],
      ];
  }


  public function defaultAllAccess($exclude = [])
  {
    return ['list', 'create', 'show', 'edit', 'delete', 'import-excel-default', 'export-excel-default', 'export-pdf-default'];
  }


  public function accessCustomize($menuKey)
  {
    $arrMenu = [
      'dashboard' => ['list'],
    ];

    return $arrMenu[$menuKey] ?? $this->defaultAllAccess();
  }
}
