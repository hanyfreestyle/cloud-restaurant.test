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

        // Create permissions
        $permissions = [
            // Restaurant permissions
            'view_restaurants',
            'create_restaurants',
            'edit_restaurants',
            'delete_restaurants',
            
            // Category permissions
            'view_categories',
            'create_categories',
            'edit_categories',
            'delete_categories',
            
            // Product permissions
            'view_products',
            'create_products',
            'edit_products',
            'delete_products',
            
            // Table permissions
            'view_tables',
            'create_tables',
            'edit_tables',
            'delete_tables',
            
            // Order permissions
            'view_orders',
            'create_orders',
            'edit_orders',
            'delete_orders',
            'change_order_status',
            'change_payment_status',
            
            // User permissions
            'view_users',
            'create_users',
            'edit_users',
            'delete_users',
            'manage_roles',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        // Admin role
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        // Manager role
        $managerRole = Role::create(['name' => 'manager']);
        $managerRole->givePermissionTo([
            'view_restaurants',
            'view_categories',
            'create_categories',
            'edit_categories',
            'view_products',
            'create_products',
            'edit_products',
            'view_tables',
            'create_tables',
            'edit_tables',
            'view_orders',
            'edit_orders',
            'change_order_status',
            'change_payment_status',
            'view_users',
        ]);

        // Waiter role
        $waiterRole = Role::create(['name' => 'waiter']);
        $waiterRole->givePermissionTo([
            'view_categories',
            'view_products',
            'view_tables',
            'view_orders',
            'create_orders',
            'edit_orders',
            'change_order_status',
        ]);

        // Cashier role
        $cashierRole = Role::create(['name' => 'cashier']);
        $cashierRole->givePermissionTo([
            'view_orders',
            'edit_orders',
            'change_payment_status',
        ]);
    }
}
