<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Standard Permissions
        $permissions = [
            // Restaurant permissions
            'view_restaurant',
            'create_restaurant',
            'update_restaurant',
            'delete_restaurant',
            'restore_restaurant',
            'force_delete_restaurant',
            
            // Category permissions
            'view_category',
            'create_category',
            'update_category',
            'delete_category',
            'restore_category',
            'force_delete_category',
            
            // Product permissions
            'view_product',
            'create_product',
            'update_product',
            'delete_product',
            'restore_product',
            'force_delete_product',
            
            // Table permissions
            'view_table',
            'create_table',
            'update_table',
            'delete_table',
            'restore_table',
            'force_delete_table',
            
            // Order permissions
            'view_order',
            'create_order',
            'update_order',
            'delete_order',
            'restore_order',
            'force_delete_order',
            'change_order_status',
            'change_payment_status',
            
            // User permissions
            'view_user',
            'create_user',
            'update_user',
            'delete_user',
            'restore_user',
            'force_delete_user',
        ];

        // Create Shield Permissions (For Filament Shield)
        $shieldPermissions = [
            'view_role',
            'create_role',
            'update_role',
            'delete_role',
            'restore_role',
            'force_delete_role',
            'view_permission',
            'create_permission',
            'update_permission',
            'delete_permission',
            'restore_permission',
            'force_delete_permission',
            'shield::view_user_management',
            'shield::view_role_management',
        ];

        // Merge all permissions
        $allPermissions = array_merge($permissions, $shieldPermissions);

        // Create all defined permissions
        foreach ($allPermissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        
        // 1. Super Admin role
        $superAdminRole = Role::create(['name' => 'super_admin']);
        $superAdminRole->givePermissionTo(Permission::all());

        // 2. Admin role
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo([
            'view_restaurant', 'create_restaurant', 'update_restaurant',
            'view_category', 'create_category', 'update_category', 'delete_category',
            'view_product', 'create_product', 'update_product', 'delete_product',
            'view_table', 'create_table', 'update_table', 'delete_table',
            'view_order', 'create_order', 'update_order', 'delete_order',
            'change_order_status', 'change_payment_status',
            'view_user', 'create_user', 'update_user',
        ]);

        // 3. Manager role
        $managerRole = Role::create(['name' => 'manager']);
        $managerRole->givePermissionTo([
            'view_restaurant',
            'view_category', 'create_category', 'update_category',
            'view_product', 'create_product', 'update_product',
            'view_table', 'create_table', 'update_table',
            'view_order', 'update_order',
            'change_order_status', 'change_payment_status',
            'view_user',
        ]);

        // 4. Waiter role
        $waiterRole = Role::create(['name' => 'waiter']);
        $waiterRole->givePermissionTo([
            'view_category',
            'view_product',
            'view_table',
            'view_order', 'create_order', 'update_order',
            'change_order_status',
        ]);

        // 5. Cashier role
        $cashierRole = Role::create(['name' => 'cashier']);
        $cashierRole->givePermissionTo([
            'view_order', 'update_order',
            'change_payment_status',
        ]);
    }
}
