# Beni Oku
## _Todo Uygulaması_


## Kullanılan Teknolojiler
- Laravel 8
- Livewire
- Fortify

## Kurulum

```sh
git clone https://github.com/bilginnet/todolist.git
cd todolist
composer install
```

#### Serve
```sh
php artisan migrate
php artisan db:seed
php artisan serve
```
veya
```sh
php artisan app:reset ['yes']
php artisan serve
```

## UYGULAMA HAKKINDA

Proje bir todo list uygulamasıdır. Proje ortalama 3.5 saatte tamamlanmıştır. Bu süreye laravel kurulumu paket kurulumu ve git için harcanılan süre dahil değildir.

Kullanıcılar giriş yaptıktan kendi todo listesini oluşturup bu liste üzerinde silme düzenleme filtreleme gibi işlemleri yapabilmektedir.


