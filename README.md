# Sistem Manajemen Wahana Dududu World

## Penjelasan Sistem


## Fitur utama Sistem Tripify

Sistem Tripify juga menyediakan **Chart Wisata** dan **Chart ** yang didapat dari sistem reservasi Takut.com

### Cara menjalankan sistem

 1. Clone repository berikut dengan link berikut ini
    ```sh
    git clone (https://github.com/k3rlyn/tripify.git)
    ```
2. Pastikan sudah menjalankan atau mengaktifkan start pada **Apache** dan **MySQL** di **XAMPP** 
3. Buka link **php myadmin** http://localhost/phpmyadmin/ dengan web browser, kemudian buatlah database baru dengan nama tripify dengan click new sehingga terbuat database
5. Selanjutnya, fetch data dengan command berikut untuk memasukkan data seeder ke dalam database di php my admin tadi
  
5. Jalankan command berikut di VSCode tempat file sistem ini berada untuk menjalankan sistem di link localhost kalian menggunakan link berikut (http://localhost:8080/)
   ```sh
   php spark serve
   ```
6. Selamat, kalian berhasil masuk ke dalam sistem Tripify apabila di layar kalian sudah tertampil interface autentikasi Tripify