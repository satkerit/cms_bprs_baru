<?php return array (
  'broadcasting' => 
  array (
    'default' => 'log',
    'connections' => 
    array (
      'reverb' => 
      array (
        'driver' => 'reverb',
        'key' => NULL,
        'secret' => NULL,
        'app_id' => NULL,
        'options' => 
        array (
          'host' => NULL,
          'port' => 443,
          'scheme' => 'https',
          'useTLS' => true,
        ),
        'client_options' => 
        array (
        ),
      ),
      'pusher' => 
      array (
        'driver' => 'pusher',
        'key' => NULL,
        'secret' => NULL,
        'app_id' => NULL,
        'options' => 
        array (
          'cluster' => NULL,
          'host' => 'api-mt1.pusher.com',
          'port' => 443,
          'scheme' => 'https',
          'encrypted' => true,
          'useTLS' => true,
        ),
        'client_options' => 
        array (
        ),
      ),
      'ably' => 
      array (
        'driver' => 'ably',
        'key' => NULL,
      ),
      'log' => 
      array (
        'driver' => 'log',
      ),
      'null' => 
      array (
        'driver' => 'null',
      ),
    ),
  ),
  'concurrency' => 
  array (
    'default' => 'process',
  ),
  'hashing' => 
  array (
    'driver' => 'bcrypt',
    'bcrypt' => 
    array (
      'rounds' => '12',
      'verify' => true,
      'limit' => NULL,
    ),
    'argon' => 
    array (
      'memory' => 65536,
      'threads' => 1,
      'time' => 4,
      'verify' => true,
    ),
    'rehash_on_login' => true,
  ),
  'image' => 
  array (
    'default' => 'gd',
  ),
  'view' => 
  array (
    'paths' => 
    array (
      0 => 'D:\\laragon\\www\\cms_baru\\resources\\views',
    ),
    'compiled' => 'D:\\laragon\\www\\cms_baru\\storage\\framework\\views',
  ),
  'app' => 
  array (
    'name' => 'Bank Syariah Babel',
    'env' => 'local',
    'debug' => true,
    'url' => 'http://localhost:8000',
    'frontend_url' => 'http://localhost:3000',
    'asset_url' => NULL,
    'timezone' => 'Asia/Jakarta',
    'locale' => 'id',
    'fallback_locale' => 'id',
    'faker_locale' => 'id_ID',
    'cipher' => 'AES-256-CBC',
    'key' => 'base64:CR0TBixGrwP4zIMKNYyrViwLnDzWbzjubaCcxIfnHAo=',
    'previous_keys' => 
    array (
    ),
    'maintenance' => 
    array (
      'driver' => 'file',
      'store' => 'database',
    ),
    'providers' => 
    array (
      0 => 'Illuminate\\Auth\\AuthServiceProvider',
      1 => 'Illuminate\\Broadcasting\\BroadcastServiceProvider',
      2 => 'Illuminate\\Bus\\BusServiceProvider',
      3 => 'Illuminate\\Cache\\CacheServiceProvider',
      4 => 'Illuminate\\Foundation\\Providers\\ConsoleSupportServiceProvider',
      5 => 'Illuminate\\Concurrency\\ConcurrencyServiceProvider',
      6 => 'Illuminate\\Cookie\\CookieServiceProvider',
      7 => 'Illuminate\\Database\\DatabaseServiceProvider',
      8 => 'Illuminate\\Encryption\\EncryptionServiceProvider',
      9 => 'Illuminate\\Filesystem\\FilesystemServiceProvider',
      10 => 'Illuminate\\Image\\ImageServiceProvider',
      11 => 'Illuminate\\Foundation\\Providers\\FoundationServiceProvider',
      12 => 'Illuminate\\Hashing\\HashServiceProvider',
      13 => 'Illuminate\\Mail\\MailServiceProvider',
      14 => 'Illuminate\\Notifications\\NotificationServiceProvider',
      15 => 'Illuminate\\Pagination\\PaginationServiceProvider',
      16 => 'Illuminate\\Auth\\Passwords\\PasswordResetServiceProvider',
      17 => 'Illuminate\\Pipeline\\PipelineServiceProvider',
      18 => 'Illuminate\\Queue\\QueueServiceProvider',
      19 => 'Illuminate\\Redis\\RedisServiceProvider',
      20 => 'Illuminate\\Session\\SessionServiceProvider',
      21 => 'Illuminate\\Translation\\TranslationServiceProvider',
      22 => 'Illuminate\\Validation\\ValidationServiceProvider',
      23 => 'Illuminate\\View\\ViewServiceProvider',
      24 => 'App\\Providers\\AppServiceProvider',
      25 => 'App\\Providers\\MailConfigServiceProvider',
      26 => 'App\\Providers\\StorageServiceProvider',
      27 => 'App\\Providers\\ViewServiceProvider',
    ),
    'aliases' => 
    array (
      'App' => 'Illuminate\\Support\\Facades\\App',
      'Arr' => 'Illuminate\\Support\\Arr',
      'Artisan' => 'Illuminate\\Support\\Facades\\Artisan',
      'Auth' => 'Illuminate\\Support\\Facades\\Auth',
      'Benchmark' => 'Illuminate\\Support\\Benchmark',
      'Blade' => 'Illuminate\\Support\\Facades\\Blade',
      'Broadcast' => 'Illuminate\\Support\\Facades\\Broadcast',
      'Bus' => 'Illuminate\\Support\\Facades\\Bus',
      'Cache' => 'Illuminate\\Support\\Facades\\Cache',
      'Concurrency' => 'Illuminate\\Support\\Facades\\Concurrency',
      'Config' => 'Illuminate\\Support\\Facades\\Config',
      'Context' => 'Illuminate\\Support\\Facades\\Context',
      'Cookie' => 'Illuminate\\Support\\Facades\\Cookie',
      'Crypt' => 'Illuminate\\Support\\Facades\\Crypt',
      'Date' => 'Illuminate\\Support\\Facades\\Date',
      'DB' => 'Illuminate\\Support\\Facades\\DB',
      'Eloquent' => 'Illuminate\\Database\\Eloquent\\Model',
      'Event' => 'Illuminate\\Support\\Facades\\Event',
      'File' => 'Illuminate\\Support\\Facades\\File',
      'Gate' => 'Illuminate\\Support\\Facades\\Gate',
      'Hash' => 'Illuminate\\Support\\Facades\\Hash',
      'Http' => 'Illuminate\\Support\\Facades\\Http',
      'Js' => 'Illuminate\\Support\\Js',
      'Lang' => 'Illuminate\\Support\\Facades\\Lang',
      'Log' => 'Illuminate\\Support\\Facades\\Log',
      'Mail' => 'Illuminate\\Support\\Facades\\Mail',
      'Notification' => 'Illuminate\\Support\\Facades\\Notification',
      'Number' => 'Illuminate\\Support\\Number',
      'Password' => 'Illuminate\\Support\\Facades\\Password',
      'Process' => 'Illuminate\\Support\\Facades\\Process',
      'Queue' => 'Illuminate\\Support\\Facades\\Queue',
      'RateLimiter' => 'Illuminate\\Support\\Facades\\RateLimiter',
      'Redirect' => 'Illuminate\\Support\\Facades\\Redirect',
      'Request' => 'Illuminate\\Support\\Facades\\Request',
      'Response' => 'Illuminate\\Support\\Facades\\Response',
      'Route' => 'Illuminate\\Support\\Facades\\Route',
      'Schedule' => 'Illuminate\\Support\\Facades\\Schedule',
      'Schema' => 'Illuminate\\Support\\Facades\\Schema',
      'Session' => 'Illuminate\\Support\\Facades\\Session',
      'Storage' => 'Illuminate\\Support\\Facades\\Storage',
      'Str' => 'Illuminate\\Support\\Str',
      'Uri' => 'Illuminate\\Support\\Uri',
      'URL' => 'Illuminate\\Support\\Facades\\URL',
      'Validator' => 'Illuminate\\Support\\Facades\\Validator',
      'View' => 'Illuminate\\Support\\Facades\\View',
      'Vite' => 'Illuminate\\Support\\Facades\\Vite',
    ),
    'secret_cache_token' => 'BismillahPacak9988@',
    'production_public_path' => '/public',
  ),
  'auth' => 
  array (
    'defaults' => 
    array (
      'guard' => 'web',
      'passwords' => 'users',
    ),
    'guards' => 
    array (
      'web' => 
      array (
        'driver' => 'session',
        'provider' => 'users',
      ),
    ),
    'providers' => 
    array (
      'users' => 
      array (
        'driver' => 'eloquent',
        'model' => 'App\\Models\\User',
      ),
    ),
    'passwords' => 
    array (
      'users' => 
      array (
        'provider' => 'users',
        'table' => 'password_reset_tokens',
        'expire' => 60,
        'throttle' => 60,
      ),
    ),
    'password_timeout' => 10800,
  ),
  'cache' => 
  array (
    'default' => 'file',
    'stores' => 
    array (
      'array' => 
      array (
        'driver' => 'array',
        'serialize' => false,
      ),
      'session' => 
      array (
        'driver' => 'session',
        'key' => '_cache',
      ),
      'database' => 
      array (
        'driver' => 'database',
        'connection' => NULL,
        'table' => 'cache',
        'lock_connection' => NULL,
        'lock_table' => NULL,
      ),
      'file' => 
      array (
        'driver' => 'file',
        'path' => 'D:\\laragon\\www\\cms_baru\\storage\\framework/cache/data',
        'lock_path' => 'D:\\laragon\\www\\cms_baru\\storage\\framework/cache/data',
      ),
      'storage' => 
      array (
        'driver' => 'storage',
        'disk' => NULL,
        'path' => 'framework/cache/data',
      ),
      'memcached' => 
      array (
        'driver' => 'memcached',
        'persistent_id' => NULL,
        'sasl' => 
        array (
          0 => NULL,
          1 => NULL,
        ),
        'options' => 
        array (
        ),
        'servers' => 
        array (
          0 => 
          array (
            'host' => '127.0.0.1',
            'port' => 11211,
            'weight' => 100,
          ),
        ),
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'cache',
        'lock_connection' => 'default',
      ),
      'dynamodb' => 
      array (
        'driver' => 'dynamodb',
        'key' => '',
        'secret' => '',
        'region' => 'us-east-1',
        'table' => 'cache',
        'endpoint' => NULL,
      ),
      'octane' => 
      array (
        'driver' => 'octane',
      ),
      'failover' => 
      array (
        'driver' => 'failover',
        'stores' => 
        array (
          0 => 'database',
          1 => 'array',
        ),
      ),
    ),
    'prefix' => 'cms_',
  ),
  'cache-keys' => 
  array (
    'news_home' => 'news_home_3',
    'products_home' => 'products_home_6',
    'auctions_home' => 'auctions_home_3',
    'company_info' => 'company_info',
    'board_members' => 'board_members',
    'hero_slides' => 'hero_slides',
    'why_choose_us' => 'why_choose_us_items',
    'offices' => 'offices',
    'active_careers' => 'active_careers',
    'kas_keliling_schedules' => 'kas_keliling_schedules',
    'financing_configs' => 'financing_configs',
    'reports_by_type' => 'reports_by_type_',
    'news_detail' => 'news_detail_',
    'product_detail' => 'product_detail_',
    'dashboard_stats' => 'dashboard_stats',
    'visitor_stats_7days' => 'visitor_stats_7days',
    'visitor_stats_all' => 'visitor_stats_all',
    'site_settings' => 'site_settings_',
    'storage_stats' => 'storage_stats',
    'products' => 'products_',
    'news_categories' => 'news_categories',
    'report_years' => 'report_years_',
    'kas_keliling' => 'kas_keliling',
    'why_choose_us_settings' => 'why_choose_us_settings',
    'auctions_featured' => 'auctions_featured',
    'auctions_upcoming' => 'auctions_upcoming',
    'auctions_asset_types' => 'auctions_asset_types',
    'auctions_cities' => 'auctions_cities',
  ),
  'cors' => 
  array (
    'paths' => 
    array (
      0 => 'api/*',
      1 => 'sanctum/csrf-cookie',
      2 => 'livewire/*',
    ),
    'allowed_methods' => 
    array (
      0 => 'GET',
      1 => 'POST',
      2 => 'PUT',
      3 => 'PATCH',
      4 => 'DELETE',
      5 => 'OPTIONS',
    ),
    'allowed_origins' => 
    array (
      0 => 'http://localhost:8000',
    ),
    'allowed_origins_patterns' => 
    array (
    ),
    'allowed_headers' => 
    array (
      0 => 'Content-Type',
      1 => 'X-Requested-With',
      2 => 'Authorization',
      3 => 'Accept',
      4 => 'Origin',
      5 => 'X-CSRF-TOKEN',
    ),
    'exposed_headers' => 
    array (
      0 => 'X-RateLimit-Limit',
      1 => 'X-RateLimit-Remaining',
    ),
    'max_age' => 86400,
    'supports_credentials' => true,
  ),
  'database' => 
  array (
    'default' => 'mysql',
    'connections' => 
    array (
      'sqlite' => 
      array (
        'driver' => 'sqlite',
        'url' => NULL,
        'database' => 'cms_db_bprs',
        'prefix' => '',
        'foreign_key_constraints' => true,
        'busy_timeout' => NULL,
        'journal_mode' => NULL,
        'synchronous' => NULL,
        'transaction_mode' => 'DEFERRED',
      ),
      'mysql' => 
      array (
        'driver' => 'mysql',
        'url' => NULL,
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'cms_db_bprs',
        'username' => 'root',
        'password' => '',
        'unix_socket' => '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'prefix_indexes' => true,
        'strict' => true,
        'engine' => NULL,
        'options' => 
        array (
        ),
      ),
      'mariadb' => 
      array (
        'driver' => 'mariadb',
        'url' => NULL,
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'cms_db_bprs',
        'username' => 'root',
        'password' => '',
        'unix_socket' => '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'prefix_indexes' => true,
        'strict' => true,
        'engine' => NULL,
        'options' => 
        array (
        ),
      ),
      'pgsql' => 
      array (
        'driver' => 'pgsql',
        'url' => NULL,
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'cms_db_bprs',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
        'prefix' => '',
        'prefix_indexes' => true,
        'search_path' => 'public',
        'sslmode' => 'prefer',
      ),
      'sqlsrv' => 
      array (
        'driver' => 'sqlsrv',
        'url' => NULL,
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'cms_db_bprs',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
        'prefix' => '',
        'prefix_indexes' => true,
      ),
    ),
    'migrations' => 
    array (
      'table' => 'migrations',
      'update_date_on_publish' => true,
    ),
    'redis' => 
    array (
      'client' => 'phpredis',
      'options' => 
      array (
        'cluster' => 'redis',
        'prefix' => 'bank-syariah-babel-database-',
        'persistent' => false,
      ),
      'default' => 
      array (
        'url' => NULL,
        'host' => '127.0.0.1',
        'username' => NULL,
        'password' => NULL,
        'port' => '6379',
        'database' => '0',
        'max_retries' => 3,
        'backoff_algorithm' => 'decorrelated_jitter',
        'backoff_base' => 100,
        'backoff_cap' => 1000,
      ),
      'cache' => 
      array (
        'url' => NULL,
        'host' => '127.0.0.1',
        'username' => NULL,
        'password' => NULL,
        'port' => '6379',
        'database' => '1',
        'max_retries' => 3,
        'backoff_algorithm' => 'decorrelated_jitter',
        'backoff_base' => 100,
        'backoff_cap' => 1000,
      ),
    ),
  ),
  'filesystems' => 
  array (
    'default' => 'local',
    'disks' => 
    array (
      'local' => 
      array (
        'driver' => 'local',
        'root' => 'D:\\laragon\\www\\cms_baru\\storage\\app/private',
        'serve' => false,
        'throw' => false,
        'report' => false,
      ),
      'public' => 
      array (
        'driver' => 'local',
        'root' => 'D:\\laragon\\www\\cms_baru\\storage\\app/public',
        'url' => 'http://localhost:8000/storage',
        'visibility' => 'public',
        'serve' => true,
        'throw' => false,
        'report' => false,
      ),
      's3' => 
      array (
        'driver' => 's3',
        'key' => '',
        'secret' => '',
        'region' => 'us-east-1',
        'bucket' => '',
        'url' => NULL,
        'endpoint' => NULL,
        'use_path_style_endpoint' => false,
        'throw' => false,
        'report' => false,
      ),
    ),
    'links' => 
    array (
      'D:\\laragon\\www\\cms_baru\\public\\storage' => 'D:\\laragon\\www\\cms_baru\\storage\\app/public',
    ),
  ),
  'livewire' => 
  array (
    'component_locations' => 
    array (
      0 => 'D:\\laragon\\www\\cms_baru\\resources\\views/components',
      1 => 'D:\\laragon\\www\\cms_baru\\resources\\views/livewire',
    ),
    'component_namespaces' => 
    array (
      'layouts' => 'D:\\laragon\\www\\cms_baru\\resources\\views/layouts',
      'pages' => 'D:\\laragon\\www\\cms_baru\\resources\\views/pages',
    ),
    'component_layout' => 'layouts::app',
    'component_placeholder' => NULL,
    'make_command' => 
    array (
      'type' => 'sfc',
      'emoji' => true,
      'with' => 
      array (
        'js' => false,
        'css' => false,
        'test' => false,
      ),
    ),
    'class_namespace' => 'App\\Livewire',
    'class_path' => 'D:\\laragon\\www\\cms_baru\\app\\Livewire',
    'view_path' => 'D:\\laragon\\www\\cms_baru\\resources\\views/livewire',
    'temporary_file_upload' => 
    array (
      'disk' => NULL,
      'rules' => NULL,
      'directory' => NULL,
      'middleware' => NULL,
      'preview_mimes' => 
      array (
        0 => 'png',
        1 => 'gif',
        2 => 'bmp',
        3 => 'svg',
        4 => 'wav',
        5 => 'mp4',
        6 => 'mov',
        7 => 'avi',
        8 => 'wmv',
        9 => 'mp3',
        10 => 'm4a',
        11 => 'jpg',
        12 => 'jpeg',
        13 => 'mpga',
        14 => 'webp',
        15 => 'wma',
      ),
      'max_upload_time' => 5,
      'cleanup' => true,
    ),
    'render_on_redirect' => false,
    'legacy_model_binding' => false,
    'inject_assets' => true,
    'navigate' => 
    array (
      'show_progress_bar' => true,
      'progress_bar_color' => '#2299dd',
    ),
    'inject_morph_markers' => true,
    'smart_wire_keys' => true,
    'pagination_theme' => 'tailwind',
    'release_token' => 'a',
    'csp_safe' => false,
    'payload' => 
    array (
      'max_size' => 1048576,
      'max_nesting_depth' => 10,
      'max_calls' => 50,
      'max_components' => 200,
    ),
  ),
  'logging' => 
  array (
    'default' => 'stack',
    'deprecations' => 
    array (
      'channel' => NULL,
      'trace' => false,
    ),
    'channels' => 
    array (
      'stack' => 
      array (
        'driver' => 'stack',
        'channels' => 
        array (
          0 => 'single',
        ),
        'ignore_exceptions' => false,
      ),
      'single' => 
      array (
        'driver' => 'single',
        'path' => 'D:\\laragon\\www\\cms_baru\\storage\\logs/laravel.log',
        'level' => 'error',
        'replace_placeholders' => true,
      ),
      'daily' => 
      array (
        'driver' => 'daily',
        'path' => 'D:\\laragon\\www\\cms_baru\\storage\\logs/laravel.log',
        'level' => 'error',
        'days' => 14,
        'replace_placeholders' => true,
      ),
      'slack' => 
      array (
        'driver' => 'slack',
        'url' => NULL,
        'username' => 'Laravel Log',
        'emoji' => ':boom:',
        'level' => 'error',
        'replace_placeholders' => true,
      ),
      'papertrail' => 
      array (
        'driver' => 'monolog',
        'level' => 'error',
        'handler' => 'Monolog\\Handler\\SyslogUdpHandler',
        'handler_with' => 
        array (
          'host' => NULL,
          'port' => NULL,
          'connectionString' => 'tls://:',
        ),
        'processors' => 
        array (
          0 => 'Monolog\\Processor\\PsrLogMessageProcessor',
        ),
      ),
      'stderr' => 
      array (
        'driver' => 'monolog',
        'level' => 'error',
        'handler' => 'Monolog\\Handler\\StreamHandler',
        'handler_with' => 
        array (
          'stream' => 'php://stderr',
        ),
        'formatter' => NULL,
        'processors' => 
        array (
          0 => 'Monolog\\Processor\\PsrLogMessageProcessor',
        ),
      ),
      'syslog' => 
      array (
        'driver' => 'syslog',
        'level' => 'error',
        'facility' => 8,
        'replace_placeholders' => true,
      ),
      'errorlog' => 
      array (
        'driver' => 'errorlog',
        'level' => 'error',
        'replace_placeholders' => true,
      ),
      'null' => 
      array (
        'driver' => 'monolog',
        'handler' => 'Monolog\\Handler\\NullHandler',
      ),
      'emergency' => 
      array (
        'path' => 'D:\\laragon\\www\\cms_baru\\storage\\logs/laravel.log',
      ),
    ),
  ),
  'mail' => 
  array (
    'default' => 'smtp',
    'mailers' => 
    array (
      'smtp' => 
      array (
        'transport' => 'smtp',
        'scheme' => NULL,
        'url' => NULL,
        'host' => 'smtp.gmail.com',
        'port' => '587',
        'username' => 'your_email@gmail.com',
        'password' => 'your_app_password_here',
        'timeout' => NULL,
        'local_domain' => 'localhost',
      ),
      'ses' => 
      array (
        'transport' => 'ses',
      ),
      'postmark' => 
      array (
        'transport' => 'postmark',
      ),
      'resend' => 
      array (
        'transport' => 'resend',
      ),
      'sendmail' => 
      array (
        'transport' => 'sendmail',
        'path' => '/usr/sbin/sendmail -bs -i',
      ),
      'log' => 
      array (
        'transport' => 'log',
        'channel' => NULL,
      ),
      'array' => 
      array (
        'transport' => 'array',
      ),
      'failover' => 
      array (
        'transport' => 'failover',
        'mailers' => 
        array (
          0 => 'smtp',
          1 => 'log',
        ),
        'retry_after' => 60,
      ),
      'roundrobin' => 
      array (
        'transport' => 'roundrobin',
        'mailers' => 
        array (
          0 => 'ses',
          1 => 'postmark',
        ),
        'retry_after' => 60,
      ),
    ),
    'from' => 
    array (
      'address' => 'your_email@gmail.com',
      'name' => 'Bank Syariah Babel',
    ),
    'markdown' => 
    array (
      'theme' => 'default',
      'paths' => 
      array (
        0 => 'D:\\laragon\\www\\cms_baru\\resources\\views/vendor/mail',
      ),
      'extensions' => 
      array (
      ),
    ),
  ),
  'permission' => 
  array (
    'models' => 
    array (
      'permission' => 'Spatie\\Permission\\Models\\Permission',
      'role' => 'Spatie\\Permission\\Models\\Role',
      'team' => NULL,
      'default_model' => NULL,
    ),
    'table_names' => 
    array (
      'roles' => 'roles',
      'permissions' => 'permissions',
      'model_has_permissions' => 'model_has_permissions',
      'model_has_roles' => 'model_has_roles',
      'role_has_permissions' => 'role_has_permissions',
    ),
    'column_names' => 
    array (
      'role_pivot_key' => NULL,
      'permission_pivot_key' => NULL,
      'model_morph_key' => 'model_id',
      'team_foreign_key' => 'team_id',
    ),
    'register_permission_check_method' => true,
    'register_octane_reset_listener' => false,
    'events_enabled' => false,
    'teams' => false,
    'team_resolver' => 'Spatie\\Permission\\DefaultTeamResolver',
    'use_passport_client_credentials' => false,
    'display_permission_in_exception' => false,
    'display_role_in_exception' => false,
    'enable_wildcard_permission' => false,
    'cache' => 
    array (
      'expiration_time' => 
      \DateInterval::__set_state(array(
         'from_string' => true,
         'date_string' => '24 hours',
      )),
      'key' => 'spatie.permission.cache',
      'store' => 'default',
    ),
  ),
  'queue' => 
  array (
    'default' => 'database',
    'connections' => 
    array (
      'sync' => 
      array (
        'driver' => 'sync',
      ),
      'database' => 
      array (
        'driver' => 'database',
        'connection' => NULL,
        'table' => 'jobs',
        'queue' => 'default',
        'retry_after' => 90,
        'after_commit' => false,
      ),
      'beanstalkd' => 
      array (
        'driver' => 'beanstalkd',
        'host' => 'localhost',
        'queue' => 'default',
        'retry_after' => 90,
        'block_for' => 0,
        'after_commit' => false,
      ),
      'sqs' => 
      array (
        'driver' => 'sqs',
        'key' => '',
        'secret' => '',
        'prefix' => 'https://sqs.us-east-1.amazonaws.com/your-account-id',
        'queue' => 'default',
        'suffix' => NULL,
        'region' => 'us-east-1',
        'after_commit' => false,
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'default',
        'queue' => 'default',
        'retry_after' => 90,
        'block_for' => NULL,
        'after_commit' => false,
      ),
      'deferred' => 
      array (
        'driver' => 'deferred',
      ),
      'failover' => 
      array (
        'driver' => 'failover',
        'connections' => 
        array (
          0 => 'database',
          1 => 'deferred',
        ),
      ),
      'background' => 
      array (
        'driver' => 'background',
      ),
    ),
    'batching' => 
    array (
      'database' => 'mysql',
      'table' => 'job_batches',
    ),
    'failed' => 
    array (
      'driver' => 'database-uuids',
      'database' => 'mysql',
      'table' => 'failed_jobs',
    ),
  ),
  'responsecache' => 
  array (
    'enabled' => true,
    'cache' => 
    array (
      'store' => 'file',
      'lifetime_in_seconds' => 604800,
      'tag' => '',
    ),
    'bypass' => 
    array (
      'header_name' => NULL,
      'header_value' => NULL,
    ),
    'debug' => 
    array (
      'enabled' => true,
      'cache_time_header_name' => 'X-Cache-Time',
      'cache_status_header_name' => 'X-Cache-Status',
      'cache_age_header_name' => 'X-Cache-Age',
      'cache_key_header_name' => 'X-Cache-Key',
    ),
    'ignored_query_parameters' => 
    array (
      0 => 'utm_source',
      1 => 'utm_medium',
      2 => 'utm_campaign',
      3 => 'utm_term',
      4 => 'utm_content',
      5 => 'gclid',
      6 => 'fbclid',
    ),
    'cache_profile' => 'App\\Support\\CustomCacheProfile',
    'hasher' => 'Spatie\\ResponseCache\\Hasher\\DefaultHasher',
    'serializer' => 'Spatie\\ResponseCache\\Serializers\\JsonSerializer',
    'replacers' => 
    array (
      0 => 'Spatie\\ResponseCache\\Replacers\\CsrfTokenReplacer',
    ),
  ),
  'security' => 
  array (
    'password' => 
    array (
      'min_length' => '12',
      'require_uppercase' => true,
      'require_lowercase' => true,
      'require_numbers' => true,
      'require_special_chars' => true,
      'history_count' => '5',
      'expiry_days' => 90,
    ),
    'session' => 
    array (
      'strict_ip_check' => false,
      'regenerate_interval' => 120,
    ),
    'lockout' => 
    array (
      'max_attempts' => 5,
      'lockout_duration' => 30,
      'throttle_decay' => 1,
    ),
    '2fa' => 
    array (
      'enabled' => false,
      'issuer' => 'Bank Syariah Babel',
      'qr_code_size' => 200,
      'enforce_for_admins' => true,
    ),
    'upload' => 
    array (
      'max_size' => '10240',
      'allowed_extensions' => 
      array (
        0 => 'jpg',
        1 => 'jpeg',
        2 => 'png',
        3 => 'gif',
        4 => 'pdf',
        5 => 'doc',
        6 => 'docx',
        7 => 'xls',
        8 => 'xlsx',
      ),
      'scan_viruses' => false,
      'quarantine_suspicious' => true,
    ),
    'monitoring' => 
    array (
      'alert_email' => 'security@bprsbabel.id',
      'alert_slack' => NULL,
      'alert_threshold' => 10,
    ),
    'csp' => 
    array (
      'report_violations' => false,
      'report_only_mode' => false,
    ),
    'backup' => 
    array (
      'enabled' => true,
      'encrypt' => true,
      'retention_days' => 30,
    ),
    'ddos' => 
    array (
      'rapid_fire_threshold' => '20',
      'same_endpoint_threshold' => '30',
      'requests_per_second' => '10',
      'requests_per_minute' => '120',
      'requests_per_hour' => '3000',
    ),
  ),
  'security-patterns' => 
  array (
    'sql_injection' => 
    array (
      0 => '/\\bunion\\s+(all\\s+)?select\\b/i',
      1 => '/\\bselect\\b.+\\bfrom\\b.+\\bwhere\\b/i',
      2 => '/\\binsert\\s+into\\b/i',
      3 => '/\\bdelete\\s+from\\b/i',
      4 => '/\\bdrop\\s+(table|database|index)\\b/i',
      5 => '/\\btruncate\\s+table\\b/i',
      6 => '/\\balter\\s+table\\b/i',
      7 => '/\\bexec(\\s+|\\()xp_/i',
      8 => '/\\bexecute\\s+immediate\\b/i',
      9 => '/\'\\s*(or|and)\\s+[\'"]?\\d+[\'"]?\\s*=\\s*[\'"]?\\d+/i',
      10 => '/\'\\s*(or|and)\\s+[\'"]?[a-z]+[\'"]?\\s*=\\s*[\'"]?[a-z]+/i',
      11 => '/\\bor\\b\\s+1\\s*=\\s*1/i',
      12 => '/\\band\\b\\s+1\\s*=\\s*1/i',
      13 => '/\\bwaitfor\\s+delay\\b/i',
      14 => '/\\bbenchmark\\s*\\(/i',
      15 => '/\\bsleep\\s*\\(\\s*\\d+\\s*\\)/i',
      16 => '/;\\s*(select|insert|update|delete|drop|create|alter|exec)/i',
      17 => '/\\/\\*[\\s\\S]*?\\*\\//i',
      18 => '/--\\s*$/m',
      19 => '/\\b(char|nchar|varchar|nvarchar)\\s*\\(/i',
      20 => '/\\bconvert\\s*\\(/i',
      21 => '/\\bcast\\s*\\(/i',
      22 => '/0x[0-9a-f]{2,}/i',
    ),
    'xss' => 
    array (
      0 => '/<script[^>]*>.*?<\\/script>/is',
      1 => '/<script[^>]*>/i',
      2 => '/\\bon\\w+\\s*=\\s*["\']?[^"\']+["\']?/i',
      3 => '/javascript\\s*:/i',
      4 => '/vbscript\\s*:/i',
      5 => '/data\\s*:[^,]*;base64/i',
      6 => '/<svg[^>]*onload/i',
      7 => '/<object[^>]*data\\s*=/i',
      8 => '/<embed[^>]*src\\s*=/i',
      9 => '/<iframe[^>]*src\\s*=/i',
      10 => '/expression\\s*\\(/i',
      11 => '/eval\\s*\\(/i',
      12 => '/document\\s*\\.\\s*(cookie|write|location)/i',
      13 => '/window\\s*\\.\\s*(location|open)/i',
      14 => '/innerHTML\\s*=/i',
      15 => '/&#x?[0-9a-f]+;/i',
      16 => '/%3[cC]script/i',
    ),
    'path_traversal' => 
    array (
      0 => '/\\.\\.[\\/\\\\]/i',
      1 => '/\\.\\.%2[fF]/i',
      2 => '/\\.\\.%5[cC]/i',
      3 => '/%2e%2e[\\/\\\\%]/i',
      4 => '/\\.\\.\\//i',
      5 => '/\\.\\.\\\\/i',
      6 => '/\\/etc\\/passwd/i',
      7 => '/\\/etc\\/shadow/i',
      8 => '/\\/proc\\/self/i',
      9 => '/\\/var\\/log/i',
      10 => '/c:\\\\windows/i',
      11 => '/c:\\\\boot\\.ini/i',
    ),
    'command_injection' => 
    array (
      0 => '/\\$\\(/i',
      1 => '/`[^`]+`/',
      2 => '/\\|\\s*\\w+/',
      3 => '/;\\s*\\w+/',
      4 => '/\\bwget\\s+/i',
      5 => '/\\bcurl\\s+/i',
      6 => '/\\bnc\\s+-/i',
      7 => '/\\bnetcat\\b/i',
      8 => '/\\bbash\\s+-/i',
      9 => '/\\bsh\\s+-c/i',
      10 => '/\\bperl\\s+-e/i',
      11 => '/\\bpython\\s+-c/i',
      12 => '/\\bphp\\s+-r/i',
      13 => '/\\bruby\\s+-e/i',
    ),
    'file_inclusion' => 
    array (
      0 => '/\\binclude\\s*\\(/i',
      1 => '/\\brequire\\s*\\(/i',
      2 => '/\\binclude_once\\s*\\(/i',
      3 => '/\\brequire_once\\s*\\(/i',
      4 => '/\\bfile_get_contents\\s*\\(/i',
      5 => '/\\bfopen\\s*\\(/i',
      6 => '/\\breadfile\\s*\\(/i',
      7 => '/php:\\/\\/filter/i',
      8 => '/php:\\/\\/input/i',
      9 => '/expect:\\/\\//i',
      10 => '/data:\\/\\//i',
    ),
    'scanner_agents' => 
    array (
      0 => 'sqlmap',
      1 => 'nikto',
      2 => 'nmap',
      3 => 'masscan',
      4 => 'zgrab',
      5 => 'havij',
      6 => 'acunetix',
      7 => 'nessus',
      8 => 'openvas',
      9 => 'burpsuite',
      10 => 'w3af',
      11 => 'wpscan',
      12 => 'dirbuster',
      13 => 'gobuster',
      14 => 'ffuf',
      15 => 'nuclei',
      16 => 'httpx',
      17 => 'subfinder',
      18 => 'amass',
      19 => 'whatweb',
      20 => 'fierce',
    ),
    'url_attack_patterns' => 
    array (
      0 => '/union\\s+all\\s+select/i',
      1 => '/union\\s+select/i',
      2 => '/select\\s+.*\\s+from\\s+.*\\s+where\\s+.*=/i',
      3 => '/insert\\s+into\\s+\\w+\\s*\\(/i',
      4 => '/drop\\s+table\\s+/i',
      5 => '/delete\\s+from\\s+\\w+\\s+where/i',
      6 => '/update\\s+\\w+\\s+set\\s+\\w+\\s*=/i',
      7 => '/exec\\s*\\(\\s*xp_/i',
      8 => '/;\\s*drop\\s/i',
      9 => '/;\\s*delete\\s/i',
      10 => '/\'\\s*or\\s+\'1\'\\s*=\\s*\'1/i',
      11 => '/\'\\s*or\\s+1\\s*=\\s*1/i',
      12 => '/<script[^>]*>.*<\\/script>/is',
      13 => '/javascript\\s*:\\s*[a-z]/i',
      14 => '/wp-admin/i',
      15 => '/wp-login\\.php/i',
      16 => '/xmlrpc\\.php/i',
      17 => '/phpmyadmin/i',
      18 => '/\\.env$/i',
      19 => '/\\.git\\//i',
      20 => '/\\.htaccess/i',
      21 => '/etc\\/passwd/i',
      22 => '/proc\\/self/i',
    ),
  ),
  'services' => 
  array (
    'postmark' => 
    array (
      'key' => NULL,
    ),
    'resend' => 
    array (
      'key' => NULL,
    ),
    'ses' => 
    array (
      'key' => '',
      'secret' => '',
      'region' => 'us-east-1',
    ),
    'slack' => 
    array (
      'notifications' => 
      array (
        'bot_user_oauth_token' => NULL,
        'channel' => NULL,
      ),
    ),
    'ga4' => 
    array (
      'measurement_id' => NULL,
    ),
  ),
  'session' => 
  array (
    'driver' => 'database',
    'lifetime' => 60,
    'expire_on_close' => false,
    'encrypt' => true,
    'files' => 'D:\\laragon\\www\\cms_baru\\storage\\framework/sessions',
    'connection' => NULL,
    'table' => 'sessions',
    'store' => NULL,
    'lottery' => 
    array (
      0 => 2,
      1 => 100,
    ),
    'cookie' => 'bank-syariah-babel-session',
    'path' => '/',
    'domain' => '',
    'secure' => false,
    'http_only' => true,
    'same_site' => 'strict',
    'partitioned' => false,
    'idle_timeout' => 15,
    'idle_warning' => 5,
    'idle_logout_route' => 'admin.login',
    'auto_extend' => true,
    'strict_ip_check' => false,
  ),
  'sluggable' => 
  array (
    'actions' => 
    array (
      'generate_slug' => 'Spatie\\Sluggable\\Actions\\GenerateSlugAction',
      'build_self_healing_route_key' => 'Spatie\\Sluggable\\Actions\\BuildSelfHealingRouteKeyAction',
      'extract_identifier_from_self_healing_route_key' => 'Spatie\\Sluggable\\Actions\\ExtractIdentifierFromSelfHealingRouteKeyAction',
    ),
  ),
  'storage-production' => 
  array (
    'production_paths' => 
    array (
      'public_storage_path' => 'D:\\laragon\\www\\cms_baru\\public\\storage',
      'storage_url' => 'http://localhost:8000/storage',
      'storage_target' => 'D:\\laragon\\www\\cms_baru\\storage\\app/public',
    ),
  ),
  'telescope' => 
  array (
    'enabled' => true,
    'domain' => NULL,
    'path' => 'telescope',
    'driver' => 'database',
    'storage' => 
    array (
      'database' => 
      array (
        'connection' => 'mysql',
        'chunk' => 1000,
      ),
    ),
    'queue' => 
    array (
      'connection' => NULL,
      'queue' => NULL,
      'delay' => 10,
    ),
    'middleware' => 
    array (
      0 => 'web',
      1 => 'Laravel\\Telescope\\Http\\Middleware\\Authorize',
    ),
    'only_paths' => 
    array (
    ),
    'ignore_paths' => 
    array (
      0 => 'livewire*',
      1 => 'nova-api*',
      2 => 'pulse*',
      3 => '_boost*',
      4 => '.well-known*',
    ),
    'ignore_commands' => 
    array (
    ),
    'watchers' => 
    array (
      'Laravel\\Telescope\\Watchers\\BatchWatcher' => true,
      'Laravel\\Telescope\\Watchers\\CacheWatcher' => 
      array (
        'enabled' => true,
        'hidden' => 
        array (
        ),
        'ignore' => 
        array (
        ),
      ),
      'Laravel\\Telescope\\Watchers\\ClientRequestWatcher' => 
      array (
        'enabled' => true,
        'ignore_hosts' => 
        array (
        ),
      ),
      'Laravel\\Telescope\\Watchers\\CommandWatcher' => 
      array (
        'enabled' => true,
        'ignore' => 
        array (
        ),
      ),
      'Laravel\\Telescope\\Watchers\\DumpWatcher' => 
      array (
        'enabled' => true,
        'always' => false,
      ),
      'Laravel\\Telescope\\Watchers\\EventWatcher' => 
      array (
        'enabled' => true,
        'ignore' => 
        array (
        ),
      ),
      'Laravel\\Telescope\\Watchers\\ExceptionWatcher' => true,
      'Laravel\\Telescope\\Watchers\\GateWatcher' => 
      array (
        'enabled' => true,
        'ignore_abilities' => 
        array (
        ),
        'ignore_packages' => true,
        'ignore_paths' => 
        array (
        ),
      ),
      'Laravel\\Telescope\\Watchers\\JobWatcher' => true,
      'Laravel\\Telescope\\Watchers\\LogWatcher' => 
      array (
        'enabled' => true,
        'level' => 'error',
      ),
      'Laravel\\Telescope\\Watchers\\MailWatcher' => true,
      'Laravel\\Telescope\\Watchers\\ModelWatcher' => 
      array (
        'enabled' => true,
        'events' => 
        array (
          0 => 'eloquent.*',
        ),
        'hydrations' => true,
      ),
      'Laravel\\Telescope\\Watchers\\NotificationWatcher' => true,
      'Laravel\\Telescope\\Watchers\\QueryWatcher' => 
      array (
        'enabled' => true,
        'ignore_packages' => true,
        'ignore_paths' => 
        array (
        ),
        'slow' => 100,
      ),
      'Laravel\\Telescope\\Watchers\\RedisWatcher' => true,
      'Laravel\\Telescope\\Watchers\\RequestWatcher' => 
      array (
        'enabled' => true,
        'size_limit' => 64,
        'ignore_http_methods' => 
        array (
        ),
        'ignore_status_codes' => 
        array (
        ),
      ),
      'Laravel\\Telescope\\Watchers\\ScheduleWatcher' => true,
      'Laravel\\Telescope\\Watchers\\ViewWatcher' => true,
    ),
  ),
  'tinker' => 
  array (
    'commands' => 
    array (
    ),
    'alias' => 
    array (
    ),
    'dont_alias' => 
    array (
      0 => 'App\\Nova',
    ),
    'trust_project' => 'always',
  ),
);
