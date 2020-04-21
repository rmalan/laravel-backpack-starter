# Laravel Backpack Starter
Starter template menggunakan [Backpack for Laravel](https://backpackforlaravel.com/). Template ini dibuat karena ada beberapa `error` yang tak bisa saya ketemukan solusinya dan beberapa bagian yang harus saya edit tapi tidak tau bagaimana caranya selain melalui `vendor`. :(

## Fitur
- Laravel 7
- Backpack for Laravel
- Laravel-Backpack/PermissionManager
- *Login/Register* menggunakan *username*

## *Requirements*
- PHP >= 7.2.5
- Git
- Composer

## Instalasi
- Klon repo:
```
$ git clone https://github.com/rmalan/laravel-backpack-stater.git
```
- Jalankan:
```
$ composer install
```
- *Setup* file `.env`. Kemudian jalankan:
```
$ php artisan key:generate
$ php artisan migrate
```
- Buka `vendor/backpack/crud/src/resources/lang/id/crud.php`, kemudian perbaharui bagian berikut menjadi:
```php
// DataTables translation
'emptyTable'     => 'Tak ada data yang tersedia pada tabel ini',
'info'           => 'Menampilkan _END_ dari _TOTAL_ data',
'infoEmpty'      => '',
'infoFiltered'   => '(difilter dari _MAX_ data)',
'infoPostFix'    => '',
'thousands'      => ',',
'lengthMenu'     => '_MENU_ data per halaman',
'loadingRecords' => 'Memuat...',
'processing'     => 'Memproses...',
'search'         => 'Cari: ',
'zeroRecords'    => 'Tidak ada data yang cocok ditemukan',
```
- Buka `vendor/backpack/crud/src/app/Http/Controllers/Auth/RegisterController.php`, kemudian perbaharui bagian berikut menjadi:
```php
return Validator::make($data, [
    'name'                             => 'required|max:255',
    backpack_authentication_column()   => 'required|'.$email_validation.'max:20|unique:'.$users_table,
    'email'                            => 'required|max:255|unique:'.$users_table,
    'password'                         => 'required|min:8|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X]).*$/|confirmed',
]);
```
```php
return $user->create([
    'name'                             => $data['name'],
    backpack_authentication_column()   => $data[backpack_authentication_column()],
    'email'                            => $data['email'],
    'password'                         => bcrypt($data['password']),
]);
```
- Buka `vendor/backpack/crud/src/resources/views/base/auth/register.blade.php`, dan tambahkan bagian berikut:
```html
<div class="form-group">
    <label class="control-label" for="email">Email</label>

    <div>
        <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" id="email" value="{{ old('email') }}">

        @if ($errors->has('email'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
    </div>
</div>
```
- Buka `vendor\backpack\crud\src\resources\views\base\my_account.blade.php`, kemudian perbaharui bagian berikut menjadi:
```html
<div class="row">
    <div class="col-md-4 form-group">
        @php
            $label = trans('backpack::base.name');
            $field = 'name';
        @endphp
        <label class="required">{{ $label }}</label>
        <input required class="form-control" type="text" name="{{ $field }}" value="{{ old($field) ? old($field) : $user->$field }}">
    </div>

    <div class="col-md-4 form-group">
        @php
            $label = config('backpack.base.authentication_column_name');
            $field = backpack_authentication_column();
        @endphp
        <label class="required">{{ $label }}</label>
        <input required class="form-control" type="{{ backpack_authentication_column()=='email'?'email':'text' }}" name="{{ $field }}" value="{{ old($field) ? old($field) : $user->$field }}">
    </div>

    <div class="col-md-4 form-group">
        <label class="required">Email</label>
        <input required class="form-control" type="email" name="email" value="{{ old('email') ? old('email') : $user->email }}">
    </div>
</div>
```
- Buka `vendor/backpack/permissionmanager/src/app/Http/Controllers/UserCrudController.php`, dan tambahkan bagian berikut pada `setupListOperation` dan `addUserFields`:
```php
[
    'name'  => 'username',
    'label' => 'Nama Pengguna',
    'type'  => 'text',
],
```
- Buka `vendor\backpack\permissionmanager\src\app\Http\Requests\UserStoreCrudRequest.php`, kemudian perbaharui bagian berikut menjadi:
```php
return [
    'username' => 'required|unique:'.config('permission.table_names.users', 'users').',username',
    'email'    => 'required|unique:'.config('permission.table_names.users', 'users').',email',
    'name'     => 'required',
    'password' => 'required|confirmed',
];
```
- Buka `vendor/backpack/permissionmanager/src/app/Http/Requests/UserUpdateCrudRequest.php`, kemudian perbaharui bagian berikut:
```php
return [
    'username' => 'required|unique:'.config('permission.table_names.users', 'users').',username,'.$userId,
    'email'    => 'required|unique:'.config('permission.table_names.users', 'users').',email,'.$userId,
    'name'     => 'required',
    'password' => 'confirmed',
];
```
## Dokumentasi
- [Bakcpack for Laravel](https://backpackforlaravel.com/docs)
- [Laravel-Backpack/PermissionManager](https://github.com/Laravel-Backpack/PermissionManager)