# To-Do-Planning

Bu çalışma MediaClick firması iş başvuru sürecinde istenen Case Study için hazırlanmıştır.

## Kurulum

Laravel install
```bash
composer install
```

Veritabanlarını oluşturma
```bash
php artisan migrate
```

İş listelerini veritabanına kaydetme
```bash
php artisan todo:create-job-lists
```

## Yeni Provider Api Eklenmesi

app/Http/JobList klasörü altına 'BaseProviderAbstract' class'ından türetilerek yeni Provider dosyası oluşturulmalıdır. Ardından config/job_lists.php dosyasına oluşturulan dosyanın adı yazılmalıdır.

## Notlar

Dashboardta yer alan hesaplamaları ve listelemeleri veritabanına kaydetmedim algoritma dendiği için sadece hesaplama ve parçalama yapıp yazdırdım.
