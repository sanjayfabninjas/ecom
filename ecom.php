First crate laravel project through composer
    $composer create-project laravel/laravel projecName
     
migrating
    $php artisan migrate
laravel auth
    $composer require laravel/ui
    $php artisan ui vue --auth
    $npm install && npm run dev
seeding
    $php artisan make:seeder UsersSeeder
    $php artisan db:seed


How to Add jQuery UI Plugin to a Laravel App using Laravel-mix-------------------------------------------------

    1) you’d need to install npm if you have not done so.
    
    Step 1: set up your webpack.mix.js configuration
        Check if your webpack.mix.js already contains the codes below, if not copy the code and to it.
        //webpack.mix.js
        mix.js('resources/assets/js/app.js', 'public/js')
        .sass('resources/assets/sass/app.scss', 'public/css');

    Step 2: Install jQuery UI
        Next up is to install the jQuery UI into your app. Run the command below in your terminal. Ensure 
        that you are in the root folder of your app.
        
        npm install jquery-ui --save-dev


Laravel 8 Datatables Example: Use Yajra Datatables in Laravel------------------------------------------------------
        $composer require yajra/laravel-datatables-oracle

        Additionally, enlarge the foundational service of the package such as datatable service provider in providers 
        and alias inside the config/app.php file.

     
        'providers' => [
            ....
            ....
            Yajra\DataTables\DataTablesServiceProvider::class,
        ]
        'aliases' => [
            ....
            ....    
            'DataTables' => Yajra\DataTables\Facades\DataTables::class,
        ]

        Run vendor publish command further this step is optional:
        $php artisan vendor:publish --provider="Yajra\DataTables\DataTablesServiceProvider"

Foreign Key Constarin:--
            It is an attribute or set of attributes that references to primary key of same table or another table(relation)

            foreign key -> Maintane Referential Integrity







            Doubt
                1) how to delete particular table 
                2) Illuminate\Database\QueryException with message 'SQLSTATE[42S02]: Base table or view not found: 1146 Table 
                    'ecom.product_product_image' doesn't exist (SQL: 
                        select  `product_images`.*, 
                                `product_product_image`.`product_id` as `pivot_product_id`,
                                `product_product_image`.`product_image_id` as `pivot_product_image_id` 
                                from `product_images` 
                                inner join `product_product_image` 
                                on `product_images`.`id` = `product_product_image`.`product_image_id` 
                                where `product_product_image`.`product_id` = 1
                        )'
