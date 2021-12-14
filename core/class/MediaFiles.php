<?php

/*
ClassMediaFiles.php: Mengandung 2 class
- SetAddMedia -> class yang berfungsi untuk mengelola file dan mengenerate nama baru file
*/

class MediaFiles{
    protected $files, // isi dari $_FILES
              $directory, // tempat tujuan file akan di pindahkan dari folder tmp
              $extension, // ekstensi file
              $size, // ukuran file yang akan di set
              $fname; // name pada input tipe file (name="polimg")

    public function __construct($files, $directory, $extension, $size, $fname){
        $this->files = $files;
        $this->directory = $directory;
        $this->extension = $extension;
        $this->size = $size;
        $this->fname = $fname;
    }

    /*
    method addMedia berfungsi untuk membuat nama file baru dan memindahkannya ke folder tujuan, dengan membutuhkan parameter $type (tipe yang akan di inputkan) cth:
    img = tipe file gambar/foto (jpg, png, gif, dll..) sesuai inputan dari construc
    vid = tipe file video/rekaman (mp4, 3gp, mkv, dll..) sesuai inputan dari construc
    */
    public function SetAddMedia($type){
        if ($type == 'img') {
            $file = $this->files;
            // ambil data dan pisahkan ke beberapa bagian
            // property dari $_FILES
            $file_name = $file[ "{$this->fname}" ]['name'];
            $file_type = $file[ "{$this->fname}" ]['type'];
            $file_tmp = $file[ "{$this->fname}" ]['tmp_name'];
            $file_error = $file[ "{$this->fname}" ]['error'];
            $file_size = $file[ "{$this->fname}" ]['size'];

            //property dari settings query
            $get_directory = $this->directory;
            $get_extension = $this->extension;
            $get_max_size = $this->size;

            // cek file apakah kosong atau tidak
            if ($file_error === 4) {
                return false;
            }

            // cek ekstensi upload
            $result_extension = explode('.', $file_name);
            $result_extension = strtolower(end($result_extension));
            if (!in_array($result_extension, $get_extension)) {
                return false;
            }

            // cek ukuran file
            if ($file_size > $get_max_size) {
                return false;
            }

            // Buat Nama File baru
            $final_result_extension = uniqid();
            $final_result_extension .= '.';
            $final_result_extension .= $result_extension;

            // gambar dipindahkan ke folder tujuan dengan nama file baru
            move_uploaded_file($file_tmp, $get_directory . $final_result_extension);

            // kembalikan nilai ke result file
            return $final_result_extension;

        }
        return $final_result_extension;
    }
}
